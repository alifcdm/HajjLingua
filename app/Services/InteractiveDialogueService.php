<?php

namespace App\Services;

use App\Models\Lesson;

class InteractiveDialogueService
{
    /**
     * Menghasilkan Skenario Percakapan Interaktif Khusus & Bervariasi untuk Materi Tertentu
     * Memadukan percakapan kontekstual yang spesifik membahas kosakata dan materi bab ini,
     * ditambah bank skenario yang diacak & dirotasi secara unik berdasarkan ID materi.
     */
    public static function getDialoguesForLesson(Lesson $lesson, int $variationSeed = 0): array
    {
        $langCode = $lesson->unit?->level?->language?->code ?? 'ar';
        $rawVocabs = $lesson->content_body['vocabularies'] ?? [];

        // 1. Buat skenario percakapan kontekstual khusus bab ini (2 orang dan 3 orang)
        $featuredScenarios = self::generateFeaturedDialogues($lesson, $langCode, $rawVocabs, $variationSeed);

        // 2. Ambil bank skenario umum
        $bank = self::loadDialogueBank($langCode, $rawVocabs, $lesson->sort_order);

        // 3. Rotasi dan acak bank skenario secara deterministik berdasarkan ID materi dan seed variasi
        // Ini memastikan setiap materi memiliki susunan percakapan yang berbeda dan bervariasi
        $bankCount = count($bank);
        if ($bankCount > 0) {
            $seed = abs((int)($lesson->id * 43 + $lesson->sort_order * 19 + $variationSeed * 11));
            $shift = $seed % $bankCount;
            $rotated = array_merge(array_slice($bank, $shift), array_slice($bank, 0, $shift));

            // Permutasi coprime (step 7) agar urutan topik teracak merata di setiap materi
            $step = 7;
            $permutedBank = [];
            for ($i = 0; $i < $bankCount; $i++) {
                $idx = ($i * $step) % $bankCount;
                $permutedBank[] = $rotated[$idx];
            }
        } else {
            $permutedBank = [];
        }

        // 4. Gabungkan percakapan kontekstual materi di posisi teratas, diikuti bank skenario yang teracak
        $combined = array_merge($featuredScenarios, $permutedBank);

        // 5. Normalisasi ID dan judul skenario secara berurutan
        $scenarioNumber = 1;
        foreach ($combined as &$scenario) {
            $scenario['id'] = $scenarioNumber;
            // Bersihkan prefix judul jika sudah ada
            $cleanTitle = preg_replace('/^Skenario #\d+:\s*/u', '', $scenario['title'] ?? '');
            $scenario['title'] = "Skenario #{$scenarioNumber}: {$cleanTitle}";
            $scenarioNumber++;
        }

        return $combined;
    }

    /**
     * Memuat bank 100 skenario dari file JSON atau menghasilkan fallback dinamis
     */
    public static function loadDialogueBank(string $langCode, array $vocabs = [], int $lessonOrder = 1): array
    {
        $filePath = database_path("data/dialogues/{$langCode}_dialogues.json");
        if (file_exists($filePath)) {
            $json = file_get_contents($filePath);
            $decoded = json_decode($json, true);
            if (is_array($decoded) && count($decoded) >= 50) {
                return $decoded;
            }
        }

        return self::generateFallbackBank($langCode, $vocabs, $lessonOrder);
    }

    /**
     * Menghasilkan percakapan kontekstual yang spesifik mengintegrasikan kosakata dan topik materi
     */
    public static function generateFeaturedDialogues(Lesson $lesson, string $langCode, array $rawVocabs, int $variationSeed = 0): array
    {
        $vocabs = self::extractVocabularies($rawVocabs);
        $vCount = count($vocabs);
        $lessonTitle = $lesson->title;

        // Fallback jika materi belum memiliki kosakata terdefinisi
        if ($vCount === 0) {
            $vocabs = self::getDefaultVocabulariesForLanguage($langCode);
            $vCount = count($vocabs);
        }

        $v1 = $vocabs[0];
        $v2 = $vocabs[1 % $vCount];
        $v3 = $vocabs[2 % $vCount];
        $v4 = $vocabs[3 % $vCount];

        $scenarios = [];

        switch ($langCode) {
            case 'ar':
                // Skenario 1 (2 Orang): Tanya Jawab Kosakata Utama
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'sparkles',
                    'title' => "Praktik Langsung Kosakata \"{$v1['word']}\" ({$v1['meaning']})",
                    'situation' => "Diskusi interaktif antara 2 orang mengenai pemahaman dan contoh penggunaan kata '{$v1['word']}' ({$v1['meaning']}) dalam topik {$lessonTitle}.",
                    'participant_count' => 2,
                    'participants' => ['Ahmad (Penutur 1)', 'Fatimah (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => 'أَحْمَد',
                            'speaker_label' => 'Ahmad (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "السَّلَامُ عَلَيْكُمْ يَا فَاطِمَةُ، كَيْفَ نَسْتَخْدِمُ كَلِمَةَ \"{$v1['word']}\" فِي الْجُمْلَةِ؟",
                            'trans' => "Assalamu 'alaikum ya Fatimah, kaifa nastakhdimu kalimata \"{$v1['trans']}\" fil jumlah?",
                            'meaning' => "Assalamu'alaikum wahai Fatimah, bagaimana kita menggunakan kata \"{$v1['word']}\" ({$v1['meaning']}) dalam sebuah kalimat?",
                            'audio' => "السَّلَامُ عَلَيْكُمْ، كَيْفَ نَسْتَخْدِمُ هَذِهِ الْكَلِمَةَ؟",
                        ],
                        [
                            'speaker' => 'فَاطِمَة',
                            'speaker_label' => 'Fatimah (Penutur 2)',
                            'role' => 'Penutur Kedua (Petugas / Rekan)',
                            'text' => "وَعَلَيْكُمُ السَّلَامُ يَا أَحْمَدُ! نَقُولُ مَثَلًا: \"هَذَا {$v1['word']} طَيِّبٌ\"، وَمَعْنَاهُ {$v1['meaning']}.",
                            'trans' => "Wa'alaikumussalam ya Ahmad! Naqulu matsalam: \"Hadza {$v1['trans']} thayyib\", wa ma'naahu {$v1['meaning']}.",
                            'meaning' => "Wa'alaikumsalam wahai Ahmad! Kita bisa berkata misalnya: \"Ini {$v1['meaning']} yang baik\", dan maknanya adalah {$v1['meaning']}.",
                            'audio' => "وَعَلَيْكُمُ السَّلَامُ! هَذَا مِثَالٌ جَيِّدٌ لِلتَّطْبِيقِ.",
                        ],
                        [
                            'speaker' => 'أَحْمَد',
                            'speaker_label' => 'Ahmad (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "شُكْرًا جَزِيلاً لَكِ! الْآنَ فَهِمْتُ الْمَعْنَى وَالسِّيَاقَ بِوُضُوحٍ كَبِيرٍ.",
                            'trans' => "Syukran jazilan laki! Al-aana fahimtul ma'na was siyaaqa biwudhuuhin kabiir.",
                            'meaning' => "Terima kasih banyak kepadamu! Sekarang saya memahami makna dan konteksnya dengan sangat jelas.",
                            'audio' => "شُكْرًا جَزِيلاً لَكِ عَلَى التَّوْضِيحِ.",
                        ],
                        [
                            'speaker' => 'فَاطِمَة',
                            'speaker_label' => 'Fatimah (Penutur 2)',
                            'role' => 'Penutur Kedua (Petugas / Rekan)',
                            'text' => "عَفْوًا، وَيُمْكِنُكَ أَيْضًا اسْتِخْدَامُهَا فِي الْمُحَادَثَةِ الْيَوْمِيَّةِ بِسُهُولَةٍ.",
                            'trans' => "'Afwan, wa yumkinuka aydhan istikhdaamuha fil muhaadatsatil yaumiyyati bisuhuulah.",
                            'meaning' => "Sama-sama, dan Anda juga dapat menggunakannya dalam percakapan sehari-hari dengan mudah.",
                            'audio' => "عَفْوًا، أَهْلًا وَسَهْلًا بِكَ دَائِمًا.",
                        ],
                    ],
                ];

                // Skenario 2 (2 Orang): Komunikasi Situasional
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'activity',
                    'title' => "Komunikasi Situasional Kata \"{$v2['word']}\" ({$v2['meaning']})",
                    'situation' => "Penerapan nyata kata '{$v2['word']}' ({$v2['meaning']}) dalam percakapan situasional sehari-hari antara 2 orang.",
                    'participant_count' => 2,
                    'participants' => ['Ahmad (Penutur 1)', 'Fatimah (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => 'فَاطِمَة',
                            'speaker_label' => 'Fatimah (Penutur 2)',
                            'role' => 'Penutur Kedua (Petugas / Rekan)',
                            'text' => "يَا أَحْمَدُ، هَلْ تَحْتَاجُ إِلَى {$v2['word']} فِي مَهَامِّ هَذَا الْيَوْمِ؟",
                            'trans' => "Ya Ahmad, hal tahtaaju ilaa {$v2['trans']} fii mahaammi hadzal yaum?",
                            'meaning' => "Wahai Ahmad, apakah kamu membutuhkan {$v2['meaning']} dalam tugas hari ini?",
                            'audio' => "هَلْ تَحْتَاجُ إِلَى هَذَا الْأَمْرِ الْيَوْمَ؟",
                        ],
                        [
                            'speaker' => 'أَحْمَد',
                            'speaker_label' => 'Ahmad (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "نَعَمْ بِالتَّأْكِيدِ، {$v2['word']} مُهِمٌّ جِدًّا لِإِتْمَامِ الْعَمَلِ بِنَجَاحٍ.",
                            'trans' => "Na'am bitta'kiid, {$v2['trans']} muhimmun jiddan li-itmaamil 'amali binajaah.",
                            'meaning' => "Ya tentu saja, {$v2['meaning']} sangat penting untuk menyelesaikan pekerjaan dengan sukses.",
                            'audio' => "نَعَمْ بِالتَّأْكِيدِ، هَذَا أَمْرٌ مُهِمٌّ جِدًّا.",
                        ],
                        [
                            'speaker' => 'فَاطِمَة',
                            'speaker_label' => 'Fatimah (Penutur 2)',
                            'role' => 'Penutur Kedua (Petugas / Rekan)',
                            'text' => "حَسَنًا، سَأُسَاعِدُكَ فِي تَرْتِيبِ ذَلِكَ خُطْوَةً بِخُطْوَةٍ.",
                            'trans' => "Hasanan, sa-usaa'iduka fii tartiibi dzaalika khuthwatan bikhuthwah.",
                            'meaning' => "Baiklah, saya akan membantumu mengaturnya langkah demi langkah.",
                            'audio' => "حَسَنًا، سَأُسَاعِدُكَ فَوْرًا.",
                        ],
                    ],
                ];

                // Skenario 3 (3 Orang): Diskusi Kolaboratif
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'blue',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'users',
                    'title' => "Diskusi Kolaboratif 3 Orang - Penerapan \"{$v3['word']}\"",
                    'situation' => "Musyawarah dan koordinasi antara 3 orang (Ahmad, Fatimah, dan Ustadz Zaid) mengenai materi {$lessonTitle}.",
                    'participant_count' => 3,
                    'participants' => ['Ahmad (Penutur 1)', 'Fatimah (Penutur 2)', 'Zaid (Penutur 3)'],
                    'turns' => [
                        [
                            'speaker' => 'أَحْمَد',
                            'speaker_label' => 'Ahmad (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "يَا أُسْتَاذُ زَيْدُ، نَحْنُ نُنَاقِشُ الْيَوْمَ مَوْضُوعَ: \"{$lessonTitle}\".",
                            'trans' => "Ya Ustaadzu Zaid, nahnu nunaaqisyul yauma maudhuu'a: \"{$lessonTitle}\".",
                            'meaning' => "Wahai Ustadz Zaid, kami hari ini sedang mendiskusikan topik: \"{$lessonTitle}\".",
                            'audio' => "يَا أُسْتَاذُ، نَحْنُ نُنَاقِشُ هَذَا الْمَوْضُوعَ.",
                        ],
                        [
                            'speaker' => 'زَيْد',
                            'speaker_label' => 'Zaid (Penutur 3)',
                            'role' => 'Penutur Ketiga (Pemandu / Dosen)',
                            'text' => "مَرْحَبًا بِكُمَا! تَذَكَّرَا دَائِمًا أَنَّ \"{$v3['word']}\" ({$v3['meaning']}) رُكْنٌ أَسَاسِيٌّ هُنَا.",
                            'trans' => "Marhaban bikumaa! Tadzakkaraa daa'iman anna \"{$v3['trans']}\" ruknun asaasiyyun hunaa.",
                            'meaning' => "Selamat datang kalian berdua! Ingatlah selalu bahwa \"{$v3['word']}\" ({$v3['meaning']}) adalah bagian penting di sini.",
                            'audio' => "مَرْحَبًا بِكُمَا! هَذَا أَمْرٌ أَسَاسِيٌّ فِي التَّدْرِيبِ.",
                        ],
                        [
                            'speaker' => 'فَاطِمَة',
                            'speaker_label' => 'Fatimah (Penutur 2)',
                            'role' => 'Penutur Kedua (Petugas / Rekan)',
                            'text' => "صَحِيحٌ يَا أُسْتَاذُ، وَقَدْ تَدَرَّبْنَا عَلَى اسْتِخْدَامِهِ فِي عِدَّةِ جُمَلٍ مُفِيدَةٍ.",
                            'trans' => "Shahiihun ya Ustaadz, wa qad tadarrabnaa 'alastikhdaamihi fii 'iddati jumalin mufiidah.",
                            'meaning' => "Benar wahai Ustadz, dan kami telah berlatih menggunakannya dalam beberapa kalimat yang bermanfaat.",
                            'audio' => "صَحِيحٌ يَا أُسْتَاذُ، هَذَا أَمْرٌ مُفِيدٌ جِدًّا.",
                        ],
                        [
                            'speaker' => 'زَيْد',
                            'speaker_label' => 'Zaid (Penutur 3)',
                            'role' => 'Penutur Ketiga (Pemandu / Dosen)',
                            'text' => "مُمْتَازٌ جِدًّا! التَّعَاوُنُ وَالْمُمَارَسَةُ الْمُسْتَمِرَّةُ هُمَا مِفْتَاحُ الْإِتْقَانِ.",
                            'trans' => "Mumtaazun jiddan! At-ta'aawunu wal mumaarasatul mustamirratu humaa miftaahul itqaan.",
                            'meaning' => "Luar biasa! Kerja sama dan latihan yang terus-menerus adalah kunci penguasaan bahasa.",
                            'audio' => "مُمْتَازٌ جِدًّا! وَاصِلَا التَّدْرِيبَ دَائِمًا.",
                        ],
                    ],
                ];
                break;

            case 'ja':
                // Skenario 1 (2 Orang): Penggunaan Kosakata Utama
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'sparkles',
                    'title' => "Praktik Langsung Kosakata \"{$v1['word']}\" ({$v1['meaning']})",
                    'situation' => "Diskusi interaktif antara 2 orang mengenai cara pemakaian kata '{$v1['word']}' ({$v1['meaning']}) dalam materi {$lessonTitle}.",
                    'participant_count' => 2,
                    'participants' => ['Tanaka-san (Penutur 1)', 'Yuki-san (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => '田中さん',
                            'speaker_label' => 'Tanaka-san (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "すみません、由紀さん。「{$v1['word']}」の使い方を教えていただけますか？",
                            'trans' => "Sumimasen, Yuki-san. \"{$v1['trans']}\" no tsukaikata o oshiete itadakemasu ka?",
                            'meaning' => "Permisi, Yuki-san. Bisakah Anda memberi tahu cara penggunaan \"{$v1['word']}\" ({$v1['meaning']})?",
                            'audio' => "すみません、この言葉の使い方を教えていただけますか？",
                        ],
                        [
                            'speaker' => '由紀さん',
                            'speaker_label' => 'Yuki-san (Penutur 2)',
                            'role' => 'Penutur Kedua (Staf / Rekan)',
                            'text' => "はい、喜んで！例えば「これは素晴らしい{$v1['word']}ですね」のように使いますよ。意味は「{$v1['meaning']}」です。",
                            'trans' => "Hai, yorokonde! Tatoeba \"Kore wa subarashii {$v1['trans']} desu ne\" no you ni tsukaimasu yo. Imi wa \"{$v1['meaning']}\" desu.",
                            'meaning' => "Ya, dengan senang hati! Misalnya kita gunakan seperti \"Ini {$v1['meaning']} yang luar biasa ya\". Artinya adalah \"{$v1['meaning']}\".",
                            'audio' => "はい、喜んで！どうぞこちらを参考にしてください。",
                        ],
                        [
                            'speaker' => '田中さん',
                            'speaker_label' => 'Tanaka-san (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "分かりやすくてとても助かりました。どうもありがとうございます！",
                            'trans' => "Wakariyasukute totemo tasakarimashita. Doumo arigatou gozaimasu!",
                            'meaning' => "Sangat mudah dipahami dan membantu sekali. Terima kasih banyak!",
                            'audio' => "分かりやすくて助かりました。ありがとうございます！",
                        ],
                    ],
                ];

                // Skenario 2 (2 Orang): Situasi Nyata
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'activity',
                    'title' => "Komunikasi Situasional Kata \"{$v2['word']}\" ({$v2['meaning']})",
                    'situation' => "Percakapan praktis antara 2 orang yang mempraktikkan kata '{$v2['word']}' ({$v2['meaning']}) di kehidupan sehari-hari.",
                    'participant_count' => 2,
                    'participants' => ['Tanaka-san (Penutur 1)', 'Yuki-san (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => '由紀さん',
                            'speaker_label' => 'Yuki-san (Penutur 2)',
                            'role' => 'Penutur Kedua (Staf / Rekan)',
                            'text' => "田中さん、今回の準備で「{$v2['word']}」はもう確認しましたか？",
                            'trans' => "Tanaka-san, konkai no junbi de \"{$v2['trans']}\" wa mou kakunin shimashita ka?",
                            'meaning' => "Tanaka-san, dalam persiapan kali ini apakah Anda sudah memeriksa \"{$v2['meaning']}\"?",
                            'audio' => "今回の準備で確認しましたか？",
                        ],
                        [
                            'speaker' => '田中さん',
                            'speaker_label' => 'Tanaka-san (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "はい、ばっちりです！「{$v2['word']}」についてしっかり準備しました。",
                            'trans' => "Hai, bacchiri desu! \"{$v2['trans']}\" ni tsuite shikkari junbi shimashita.",
                            'meaning' => "Ya, sudah beres! Saya telah mempersiapkan tentang \"{$v2['meaning']}\" dengan baik.",
                            'audio' => "はい、ばっちり準備しました！",
                        ],
                        [
                            'speaker' => '由紀さん',
                            'speaker_label' => 'Yuki-san (Penutur 2)',
                            'role' => 'Penutur Kedua (Staf / Rekan)',
                            'text' => "素晴らしいですね。これで安心して進められますよ。",
                            'trans' => "Subarashii desu ne. Kore de anshin shite susumeraremasu yo.",
                            'meaning' => "Luar biasa ya. Dengan ini kita bisa melanjutkan dengan tenang.",
                            'audio' => "素晴らしいですね、お疲れ様です。",
                        ],
                    ],
                ];

                // Skenario 3 (3 Orang): Diskusi 3 Orang
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'blue',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'users',
                    'title' => "Diskusi Kolaboratif 3 Orang - Aplikasi \"{$v3['word']}\"",
                    'situation' => "Koordinasi antara 3 orang (Tanaka-san, Yuki-san, dan Sato-san) mengenai materi {$lessonTitle}.",
                    'participant_count' => 3,
                    'participants' => ['Tanaka-san (Penutur 1)', 'Yuki-san (Penutur 2)', 'Sato-san (Penutur 3)'],
                    'turns' => [
                        [
                            'speaker' => '田中さん',
                            'speaker_label' => 'Tanaka-san (Penutur 1)',
                            'role' => 'Penutur Utama (Tamu / Mahasiswa)',
                            'text' => "佐藤さん、私たちは「{$lessonTitle}」について練習しています。",
                            'trans' => "Sato-san, watashitachi wa \"{$lessonTitle}\" ni tsuite renshuu shiteimasu.",
                            'meaning' => "Sato-san, kami sedang berlatih tentang \"{$lessonTitle}\".",
                            'audio' => "佐藤さん、私たちは今練習しています。",
                        ],
                        [
                            'speaker' => '佐藤さん',
                            'speaker_label' => 'Sato-san (Penutur 3)',
                            'role' => 'Penutur Ketiga (Senior / Manajer)',
                            'text' => "いいですね！特に「{$v3['word']}」（{$v3['meaning']}）の発音と敬語に気をつけましょう。",
                            'trans' => "Ii desu ne! Tokuni \"{$v3['trans']}\" no hatsuon to keigo ni ki o tsukemashou.",
                            'meaning' => "Bagus sekali! Khususnya perhatikan pelafalan dan kesopanan kata \"{$v3['word']}\" ({$v3['meaning']}).",
                            'audio' => "いいですね！発音に気をつけましょう。",
                        ],
                        [
                            'speaker' => '由紀さん',
                            'speaker_label' => 'Yuki-san (Penutur 2)',
                            'role' => 'Penutur Kedua (Staf / Rekan)',
                            'text' => "はい、田中さんと一緒にロールプレイで何度も繰り返しました。",
                            'trans' => "Hai, Tanaka-san to issho ni roorupurei de nandomo kurikaeshimashita.",
                            'meaning' => "Ya, saya dan Tanaka-san sudah mengulanginya berkali-kali dalam simulasi peran.",
                            'audio' => "はい、何度も練習しました。",
                        ],
                        [
                            'speaker' => '佐藤さん',
                            'speaker_label' => 'Sato-san (Penutur 3)',
                            'role' => 'Penutur Ketiga (Senior / Manajer)',
                            'text' => "大変立派です。自信を持って実践で使ってみてくださいね！",
                            'trans' => "Taihen rippa desu. Jishin o motte jissen de tsukatte mite kudasai ne!",
                            'meaning' => "Sangat hebat. Percaya dirilah untuk mempraktikkannya dalam situasi nyata ya!",
                            'audio' => "大変立派です、頑張ってください！",
                        ],
                    ],
                ];
                break;

            case 'ko':
                // Skenario 1 (2 Orang): Penggunaan Kosakata Utama
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'sparkles',
                    'title' => "Praktik Langsung Kosakata \"{$v1['word']}\" ({$v1['meaning']})",
                    'situation' => "Diskusi interaktif antara 2 orang mengenai cara pemakaian kata '{$v1['word']}' ({$v1['meaning']}) dalam materi {$lessonTitle}.",
                    'participant_count' => 2,
                    'participants' => ['Minjun (Penutur 1)', 'Jisoo (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => '민준',
                            'speaker_label' => 'Minjun (Penutur 1)',
                            'role' => 'Penutur Utama (Wisatawan / Siswa)',
                            'text' => "실례합니다, 지수 씨. \"{$v1['word']}\"({$v1['meaning']}) 단어를 문장에서 어떻게 사용하나요?",
                            'trans' => "Sillyehamnida, Jisoo ssi. \"{$v1['trans']}\" daneoreul munjangeseo eotteoke sayonghanayo?",
                            'meaning' => "Permisi, Jisoo. Bagaimana menggunakan kata \"{$v1['word']}\" ({$v1['meaning']}) dalam kalimat?",
                            'audio' => "실례합니다, 이 단어를 문장에서 어떻게 사용하나요?",
                        ],
                        [
                            'speaker' => '지수',
                            'speaker_label' => 'Jisoo (Penutur 2)',
                            'role' => 'Penutur Kedua (Pegawai / Teman)',
                            'text' => "네! 예를 들어 \"이것은 정말 좋은 {$v1['word']}입니다\"처럼 사용하시면 돼요. 뜻은 \"{$v1['meaning']}\"이에요.",
                            'trans' => "Ne! Yeoreul deureo \"Igeoseun jeongmal joeun {$v1['trans']}imnida\"cheoreom sayonghasimyeon dwaeyo. Tteuseun \"{$v1['meaning']}\"ieyo.",
                            'meaning' => "Ya! Misalnya Anda bisa menggunakannya seperti \"Ini sungguh {$v1['meaning']} yang baik\". Artinya adalah \"{$v1['meaning']}\".",
                            'audio' => "네! 이렇게 사용하시면 돼요.",
                        ],
                        [
                            'speaker' => '민준',
                            'speaker_label' => 'Minjun (Penutur 1)',
                            'role' => 'Penutur Utama (Wisatawan / Siswa)',
                            'text' => "친절하게 설명해 주셔서 감사합니다. 이제 확실히 알겠어요!",
                            'trans' => "Chinjeolhage seolmyeonghae jusyeoseo gamsahamnida. Ije hwaksilhi algesseoyo!",
                            'meaning' => "Terima kasih telah menjelaskan dengan ramah. Sekarang saya sudah paham betul!",
                            'audio' => "친절하게 설명해 주셔서 감사합니다!",
                        ],
                    ],
                ];

                // Skenario 2 (2 Orang): Situasi Nyata
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'activity',
                    'title' => "Komunikasi Situasional Kata \"{$v2['word']}\" ({$v2['meaning']})",
                    'situation' => "Percakapan situasional praktis antara 2 orang yang menerapkan kata '{$v2['word']}' ({$v2['meaning']}).",
                    'participant_count' => 2,
                    'participants' => ['Minjun (Penutur 1)', 'Jisoo (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => '지수',
                            'speaker_label' => 'Jisoo (Penutur 2)',
                            'role' => 'Penutur Kedua (Pegawai / Teman)',
                            'text' => "민준 씨, 혹시 지금 {$v2['word']}이/가 필요하신가요?",
                            'trans' => "Minjun ssi, hoksi jigeum {$v2['trans']}i/ga piryohasingayo?",
                            'meaning' => "Minjun, apakah Anda saat ini memerlukan {$v2['meaning']}?",
                            'audio' => "혹시 지금 이것이 필요하신가요?",
                        ],
                        [
                            'speaker' => '민준',
                            'speaker_label' => 'Minjun (Penutur 1)',
                            'role' => 'Penutur Utama (Wisatawan / Siswa)',
                            'text' => "네 맞아요! 마침 {$v2['word']}에 대해 물어보려던 참이었어요.",
                            'trans' => "Ne majayo! Machim {$v2['trans']}e daehae mureoboryeodeon chamieosseoyo.",
                            'meaning' => "Ya benar! Kebetulan saya baru saja mau menanyakan perihal {$v2['meaning']}.",
                            'audio' => "네 맞아요! 물어보려던 참이었어요.",
                        ],
                        [
                            'speaker' => '지수',
                            'speaker_label' => 'Jisoo (Penutur 2)',
                            'role' => 'Penutur Kedua (Pegawai / Teman)',
                            'text' => "그렇군요, 제가 바로 도와드릴게요!",
                            'trans' => "Geureokunyo, jega baro dowadeurilgeyo!",
                            'meaning' => "Begitu ya, saya akan segera membantu Anda!",
                            'audio' => "제가 바로 도와드릴게요!",
                        ],
                    ],
                ];

                // Skenario 3 (3 Orang): Diskusi 3 Orang
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'blue',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'users',
                    'title' => "Diskusi Kolaboratif 3 Orang - Aplikasi \"{$v3['word']}\"",
                    'situation' => "Musyawarah antara 3 orang (Minjun, Jisoo, dan Taehyun) mengenai materi {$lessonTitle}.",
                    'participant_count' => 3,
                    'participants' => ['Minjun (Penutur 1)', 'Jisoo (Penutur 2)', 'Taehyun (Penutur 3)'],
                    'turns' => [
                        [
                            'speaker' => '민준',
                            'speaker_label' => 'Minjun (Penutur 1)',
                            'role' => 'Penutur Utama (Wisatawan / Siswa)',
                            'text' => "태현 선배님, 오늘 \"{$lessonTitle}\"에 대해 배우고 있습니다.",
                            'trans' => "Taehyun seonbaenim, oneul \"{$lessonTitle}\"e daehae baeugo itseumnida.",
                            'meaning' => "Senior Taehyun, hari ini kami sedang belajar tentang \"{$lessonTitle}\".",
                            'audio' => "태현 선배님, 오늘 함께 배우고 있습니다.",
                        ],
                        [
                            'speaker' => '태현',
                            'speaker_label' => 'Taehyun (Penutur 3)',
                            'role' => 'Penutur Ketiga (Pemandu / Senior)',
                            'text' => "환영합니다! 특히 \"{$v3['word']}\"({$v3['meaning']})의 표현을 잘 익히면 일상에서 매우 유용합니다.",
                            'trans' => "Hwanyeonghamnida! Teukhi \"{$v3['trans']}\"ui pyohyeoneul jal ikhimyeon ilsangeseo maeu yuyonghamnida.",
                            'meaning' => "Selamat datang! Terutama bila kalian menguasai ungkapan \"{$v3['word']}\" ({$v3['meaning']}), akan sangat berguna di keseharian.",
                            'audio' => "환영합니다! 일상에서 매우 유용합니다.",
                        ],
                        [
                            'speaker' => '지수',
                            'speaker_label' => 'Jisoo (Penutur 2)',
                            'role' => 'Penutur Kedua (Pegawai / Teman)',
                            'text' => "맞습니다, 실생활 대화로 연습하니 훨씬 자연스러워졌어요.",
                            'trans' => "Matseumnida, silsaenghwal daehwaro yeonseuphani hwolssin jayeonseureowojyeosseoyo.",
                            'meaning' => "Benar sekali, berlatih lewat percakapan nyata membuat pengucapannya jauh lebih alami.",
                            'audio' => "실생활 대화로 연습하니 훨씬 자연스러워요.",
                        ],
                        [
                            'speaker' => '태현',
                            'speaker_label' => 'Taehyun (Penutur 3)',
                            'role' => 'Penutur Ketiga (Pemandu / Senior)',
                            'text' => "아주 좋습니다. 꾸준히 대화하면 금방 능숙해질 거예요!",
                            'trans' => "Aju jotseumnida. Kkujunhi daehwahamyeon geumbang neungsukhaejil geoyeyo!",
                            'meaning' => "Sangat bagus. Jika terus konsisten bercakap-cakap, kalian akan segera mahir!",
                            'audio' => "아주 좋습니다, 계속 파이팅하세요!",
                        ],
                    ],
                ];
                break;

            case 'zh':
                // Skenario 1 (2 Orang): Penggunaan Kosakata Utama
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'sparkles',
                    'title' => "Praktik Langsung Kosakata \"{$v1['word']}\" ({$v1['meaning']})",
                    'situation' => "Diskusi interaktif antara 2 orang mengenai cara pemakaian kata '{$v1['word']}' ({$v1['meaning']}) dalam materi {$lessonTitle}.",
                    'participant_count' => 2,
                    'participants' => ['Li Wei (Penutur 1)', 'Wang Fang (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => '李伟',
                            'speaker_label' => 'Li Wei (Penutur 1)',
                            'role' => 'Penutur Utama (Pelanggan / Pelajar)',
                            'text' => "请问，王芳，在句子里应该怎么使用\"{$v1['word']}\"（{$v1['meaning']}）这个词呢？",
                            'trans' => "Qǐngwèn, Wáng Fāng, zài jùzi lǐ yīnggāi zěnme shǐyòng \"{$v1['trans']}\" zhège cí ne?",
                            'meaning' => "Permisi, Wang Fang, bagaimana sebaiknya menggunakan kata \"{$v1['word']}\" ({$v1['meaning']}) dalam kalimat?",
                            'audio' => "请问，在句子里应该怎么使用这个词呢？",
                        ],
                        [
                            'speaker' => '王芳',
                            'speaker_label' => 'Wang Fang (Penutur 2)',
                            'role' => 'Penutur Kedua (Pramuniaga / Rekan)',
                            'text' => "你好！比如我们可以说：“这是一个很好的{$v1['word']}”，意思就是{$v1['meaning']}。",
                            'trans' => "Nǐ hǎo! Bǐrú wǒmen kěyǐ shuō: \"Zhè shì yīgè hěn hǎo de {$v1['trans']}\", yìsi jiù shì {$v1['meaning']}.",
                            'meaning' => "Halo! Misalnya kita bisa mengucapkan: \"Ini adalah {$v1['meaning']} yang sangat bagus\", artinya adalah {$v1['meaning']}.",
                            'audio' => "你好！比如我们可以这样使用它。",
                        ],
                        [
                            'speaker' => '李伟',
                            'speaker_label' => 'Li Wei (Penutur 1)',
                            'role' => 'Penutur Utama (Pelanggan / Pelajar)',
                            'text' => "太感谢你了！这下我完全理解并且掌握它的用法了。",
                            'trans' => "Tài gǎnxiè nǐ le! Zhè xià wǒ wánquán lǐjiě bìngqiě zhǎngwò tā de yòngfǎ le.",
                            'meaning' => "Terima kasih banyak! Sekarang saya sepenuhnya memahami dan menguasai penggunaannya.",
                            'audio' => "太感谢你了，我完全理解了！",
                        ],
                    ],
                ];

                // Skenario 2 (2 Orang): Situasi Nyata
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'activity',
                    'title' => "Komunikasi Situasional Kata \"{$v2['word']}\" ({$v2['meaning']})",
                    'situation' => "Percakapan praktis antara 2 orang yang mempraktikkan kata '{$v2['word']}' ({$v2['meaning']}) di kehidupan nyata.",
                    'participant_count' => 2,
                    'participants' => ['Li Wei (Penutur 1)', 'Wang Fang (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => '王芳',
                            'speaker_label' => 'Wang Fang (Penutur 2)',
                            'role' => 'Penutur Kedua (Pramuniaga / Rekan)',
                            'text' => "李伟，今天的任务里你需要\"{$v2['word']}\"吗？",
                            'trans' => "Lǐ Wěi, jīntiān de rènwù lǐ nǐ xūyào \"{$v2['trans']}\" ma?",
                            'meaning' => "Li Wei, dalam tugas hari ini apakah kamu membutuhkan \"{$v2['meaning']}\"?",
                            'audio' => "今天的任务里你需要这个吗？",
                        ],
                        [
                            'speaker' => '李伟',
                            'speaker_label' => 'Li Wei (Penutur 1)',
                            'role' => 'Penutur Utama (Pelanggan / Pelajar)',
                            'text' => "是的，非常需要！\"{$v2['word']}\"对我们非常有帮助。",
                            'trans' => "Shì de, fēicháng xūyào! \"{$v2['trans']}\" duì wǒmen fēicháng yǒu bāngzhù.",
                            'meaning' => "Ya, sangat butuh! \"{$v2['meaning']}\" sangat membantu bagi kita.",
                            'audio' => "是的，非常需要，很有帮助！",
                        ],
                        [
                            'speaker' => '王芳',
                            'speaker_label' => 'Wang Fang (Penutur 2)',
                            'role' => 'Penutur Kedua (Pramuniaga / Rekan)',
                            'text' => "好的，我这就为你准备好！",
                            'trans' => "Hǎo de, wǒ zhè jiù wèi nǐ zhǔnbèi hǎo!",
                            'meaning' => "Baiklah, saya akan segera menyiapkannya untukmu!",
                            'audio' => "好的，我这就为你准备好！",
                        ],
                    ],
                ];

                // Skenario 3 (3 Orang): Diskusi 3 Orang
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'blue',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'users',
                    'title' => "Diskusi Kolaboratif 3 Orang - Aplikasi \"{$v3['word']}\"",
                    'situation' => "Musyawarah antara 3 orang (Li Wei, Wang Fang, dan Zhang Ming) mengenai materi {$lessonTitle}.",
                    'participant_count' => 3,
                    'participants' => ['Li Wei (Penutur 1)', 'Wang Fang (Penutur 2)', 'Zhang Ming (Penutur 3)'],
                    'turns' => [
                        [
                            'speaker' => '李伟',
                            'speaker_label' => 'Li Wei (Penutur 1)',
                            'role' => 'Penutur Utama (Pelanggan / Pelajar)',
                            'text' => "张老师好，我们正在一起探讨\"{$lessonTitle}\"。",
                            'trans' => "Zhāng lǎoshī hǎo, wǒmen zhèngzài yīqǐ tàntǎo \"{$lessonTitle}\".",
                            'meaning' => "Halo Guru Zhang, kami sedang bersama mendiskusikan \"{$lessonTitle}\".",
                            'audio' => "老师好，我们正在一起探讨这个主题。",
                        ],
                        [
                            'speaker' => '张明',
                            'speaker_label' => 'Zhang Ming (Penutur 3)',
                            'role' => 'Penutur Ketiga (Manajer / Dosen)',
                            'text' => "很好！特别是在实际交流中，准确表达\"{$v3['word']}\"（{$v3['meaning']}）非常关键。",
                            'trans' => "Hěn hǎo! Tèbié shì zài shíjì jiāoliú zhōng, zhǔnquè biǎodá \"{$v3['trans']}\" fēicháng guānjiàn.",
                            'meaning' => "Sangat bagus! Terutama dalam komunikasi nyata, mengungkapkan \"{$v3['word']}\" ({$v3['meaning']}) dengan tepat sangatlah penting.",
                            'audio' => "很好！准确表达非常关键。",
                        ],
                        [
                            'speaker' => '王芳',
                            'speaker_label' => 'Wang Fang (Penutur 2)',
                            'role' => 'Penutur Kedua (Pramuniaga / Rekan)',
                            'text' => "是的老师，我们刚刚结合对话反复进行了模拟演练。",
                            'trans' => "Shì de lǎoshī, wǒmen gānggāng jiéhé duìhuà fǎnfù jìnxíng le mónǐ yǎnliàn.",
                            'meaning' => "Benar guru, kami baru saja berlatih simulasi berulang kali memadukan percakapan ini.",
                            'audio' => "是的老师，我们刚刚反复演练过了。",
                        ],
                        [
                            'speaker' => '张明',
                            'speaker_label' => 'Zhang Ming (Penutur 3)',
                            'role' => 'Penutur Ketiga (Manajer / Dosen)',
                            'text' => "做得非常出色，继续保持这种积极的学习状态！",
                            'trans' => "Zuò de fēicháng chūsè, jìxù bǎochí zhè zhǒng jījí de xuéxí zhuàngtài!",
                            'meaning' => "Bagus sekali, terus pertahankan semangat belajar yang positif ini!",
                            'audio' => "做得非常出色，继续保持！",
                        ],
                    ],
                ];
                break;

            default: // English & Bahasa Indonesia / Others
                // Skenario 1 (2 Orang): Kosakata Utama
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'sparkles',
                    'title' => "Praktik Langsung Kosakata \"{$v1['word']}\" ({$v1['meaning']})",
                    'situation' => "Diskusi interaktif antara 2 orang mengenai cara penggunaan kata '{$v1['word']}' ({$v1['meaning']}) pada topik {$lessonTitle}.",
                    'participant_count' => 2,
                    'participants' => ['Alex (Penutur 1)', 'Emma (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => 'Alex',
                            'speaker_label' => 'Alex (Penutur 1)',
                            'role' => 'Penutur Utama (Traveler / Student)',
                            'text' => "Excuse me, Emma. How do we naturally use the word \"{$v1['word']}\" ({$v1['meaning']}) in a sentence?",
                            'trans' => "/ɪkˈskjuːz miː, ˈɛmə. haʊ duː wiː ˈnætʃrəli juːz ðə wɜːrd \"{$v1['trans']}\" ɪn ə ˈsɛntəns?/",
                            'meaning' => "Permisi, Emma. Bagaimana cara kita menggunakan kata \"{$v1['word']}\" ({$v1['meaning']}) secara alami dalam kalimat?",
                            'audio' => "Excuse me, how do we use this word naturally?",
                        ],
                        [
                            'speaker' => 'Emma',
                            'speaker_label' => 'Emma (Penutur 2)',
                            'role' => 'Penutur Kedua (Officer / Colleague)',
                            'text' => "Hello Alex! For instance, you can say: \"This is a wonderful {$v1['word']}\", which means {$v1['meaning']}.",
                            'trans' => "/həˈloʊ ˈæləks! fɔːr ˈɪnstəns, juː kæn seɪ: \"ðɪs ɪz ə ˈwʌndərfəl {$v1['trans']}\", wɪtʃ miːnz {$v1['meaning']}./",
                            'meaning' => "Halo Alex! Misalnya, Anda bisa mengatakan: \"Ini adalah {$v1['meaning']} yang luar biasa\", yang artinya {$v1['meaning']}.",
                            'audio' => "Hello Alex! For instance, you can say it like this.",
                        ],
                        [
                            'speaker' => 'Alex',
                            'speaker_label' => 'Alex (Penutur 1)',
                            'role' => 'Penutur Utama (Traveler / Student)',
                            'text' => "Thank you so much! That makes it very clear and practical.",
                            'trans' => "/θæŋk juː soʊ mʌtʃ! ðæt meɪks ɪt ˈvɛri klɪr ænd ˈpræktɪkl./",
                            'meaning' => "Terima kasih banyak! Itu membuatnya sangat jelas dan praktis.",
                            'audio' => "Thank you so much! That explains it clearly.",
                        ],
                    ],
                ];

                // Skenario 2 (2 Orang): Situasi Nyata
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'emerald',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'activity',
                    'title' => "Komunikasi Situasional Kata \"{$v2['word']}\" ({$v2['meaning']})",
                    'situation' => "Percakapan situasional praktis antara 2 orang yang menerapkan kata '{$v2['word']}' ({$v2['meaning']}).",
                    'participant_count' => 2,
                    'participants' => ['Alex (Penutur 1)', 'Emma (Penutur 2)'],
                    'turns' => [
                        [
                            'speaker' => 'Emma',
                            'speaker_label' => 'Emma (Penutur 2)',
                            'role' => 'Penutur Kedua (Officer / Colleague)',
                            'text' => "Alex, do you need any assistance with {$v2['word']} for today's assignment?",
                            'trans' => "/ˈæləks, duː juː niːd ˈɛni əˈsɪstəns wɪð {$v2['trans']} fɔːr təˈdeɪz əˈsaɪnmənt?/",
                            'meaning' => "Alex, apakah kamu memerlukan bantuan terkait {$v2['meaning']} untuk tugas hari ini?",
                            'audio' => "Do you need any assistance for today's assignment?",
                        ],
                        [
                            'speaker' => 'Alex',
                            'speaker_label' => 'Alex (Penutur 1)',
                            'role' => 'Penutur Utama (Traveler / Student)',
                            'text' => "Yes, definitely! {$v2['word']} is essential for our progress.",
                            'trans' => "/jɛs, ˈdɛfɪnətli! {$v2['trans']} ɪz ɪˈsɛnʃl fɔːr ˈaʊər ˈprɑːɡrɛs./",
                            'meaning' => "Ya, pasti! {$v2['meaning']} sangat penting bagi kemajuan kita.",
                            'audio' => "Yes, definitely! That is essential for our progress.",
                        ],
                        [
                            'speaker' => 'Emma',
                            'speaker_label' => 'Emma (Penutur 2)',
                            'role' => 'Penutur Kedua (Officer / Colleague)',
                            'text' => "Great, let's coordinate it right away!",
                            'trans' => "/ɡreɪt, lɛts koʊˈɔːrdɪneɪt ɪt raɪt əˈweɪ!/",
                            'meaning' => "Bagus, mari kita koordinasikan segera!",
                            'audio' => "Great, let's coordinate it right away!",
                        ],
                    ],
                ];

                // Skenario 3 (3 Orang): Diskusi 3 Orang
                $scenarios[] = [
                    'is_featured' => true,
                    'badge' => '⭐ Percakapan Kontekstual Bab Ini',
                    'badge_color' => 'blue',
                    'category' => "Materi: {$lessonTitle}",
                    'icon' => 'users',
                    'title' => "Diskusi Kolaboratif 3 Orang - Aplikasi \"{$v3['word']}\"",
                    'situation' => "Koordinasi dan pertukaran pendapat antara 3 orang (Alex, Emma, dan David) mengenai materi {$lessonTitle}.",
                    'participant_count' => 3,
                    'participants' => ['Alex (Penutur 1)', 'Emma (Penutur 2)', 'David (Penutur 3)'],
                    'turns' => [
                        [
                            'speaker' => 'Alex',
                            'speaker_label' => 'Alex (Penutur 1)',
                            'role' => 'Penutur Utama (Traveler / Student)',
                            'text' => "Hello David, we are reviewing the module: \"{$lessonTitle}\".",
                            'trans' => "/həˈloʊ ˈdeɪvɪd, wiː ɑːr rɪˈvjuːɪŋ ðə ˈmɑːdʒuːl: \"{$lessonTitle}\"./",
                            'meaning' => "Halo David, kami sedang meninjau modul: \"{$lessonTitle}\".",
                            'audio' => "Hello David, we are reviewing this module together.",
                        ],
                        [
                            'speaker' => 'David',
                            'speaker_label' => 'David (Penutur 3)',
                            'role' => 'Penutur Ketiga (Guide / Specialist)',
                            'text' => "Welcome both of you! Keep in mind that \"{$v3['word']}\" ({$v3['meaning']}) plays a central role here.",
                            'trans' => "/ˈwɛlkəm boʊθ ʌv juː! kiːp ɪn maɪnd ðæt \"{$v3['trans']}\" pleɪz ə ˈsɛntrəl roʊl hɪər./",
                            'meaning' => "Selamat datang kalian berdua! Ingatlah bahwa \"{$v3['word']}\" ({$v3['meaning']}) memegang peranan utama di sini.",
                            'audio' => "Welcome both of you! That plays a central role here.",
                        ],
                        [
                            'speaker' => 'Emma',
                            'speaker_label' => 'Emma (Penutur 2)',
                            'role' => 'Penutur Kedua (Officer / Colleague)',
                            'text' => "Absolutely! We just practiced using it in real-world situational examples.",
                            'trans' => "/ˌæbsəˈluːtli! wiː dʒʌst ˈpræktɪst ˈjuːzɪŋ ɪt ɪn ˈriːəl wɜːrld ˌsɪtʃuˈeɪʃənl ɪɡˈzæmplz./",
                            'meaning' => "Tepat sekali! Kami baru saja berlatih menggunakannya dalam contoh situasi dunia nyata.",
                            'audio' => "Absolutely! We just practiced with real examples.",
                        ],
                        [
                            'speaker' => 'David',
                            'speaker_label' => 'David (Penutur 3)',
                            'role' => 'Penutur Ketiga (Guide / Specialist)',
                            'text' => "Excellent teamwork! Consistent practice will make you fluent in no time.",
                            'trans' => "/ˈɛksələnt ˈtiːmwɜːrk! kənˈsɪstənt ˈpræktɪs wɪl meɪk juː ˈfluːənt ɪn noʊ taɪm./",
                            'meaning' => "Kerja tim yang sangat baik! Latihan yang konsisten akan membuat kalian lancar dalam waktu singkat.",
                            'audio' => "Excellent teamwork! Keep up the good work.",
                        ],
                    ],
                ];
                break;
        }

        // Generate automatic syllable breakdowns for every turn in featured scenarios
        foreach ($scenarios as &$sc) {
            foreach ($sc['turns'] as &$turn) {
                $turn['breakdown'] = LinguisticBreakdownService::getBreakdown(
                    $langCode,
                    $turn['text'],
                    $turn['trans'],
                    $turn['meaning']
                );
            }
        }

        return $scenarios;
    }

    /**
     * Mengekstrak format kosakata dari berbagai representasi bahasa
     */
    public static function extractVocabularies(array $rawVocabs): array
    {
        $items = [];
        foreach ($rawVocabs as $v) {
            $word = $v['arabic'] ?? $v['kanji_kana'] ?? $v['hangeul'] ?? $v['word'] ?? '';
            $trans = $v['trans'] ?? $v['romaji'] ?? $v['romaja'] ?? '';
            $meaning = $v['meaning'] ?? '';
            $audio = $v['audio'] ?? $word;

            if (!empty($word) || !empty($meaning)) {
                $items[] = compact('word', 'trans', 'meaning', 'audio');
            }
        }
        return $items;
    }

    /**
     * Kosakata default jika materi kosong
     */
    private static function getDefaultVocabulariesForLanguage(string $langCode): array
    {
        return match ($langCode) {
            'ar' => [
                ['word' => 'مَرْحَبًا', 'trans' => 'Marhaban', 'meaning' => 'Halo / Selamat Datang', 'audio' => 'Marhaban'],
                ['word' => 'شُكْرًا', 'trans' => 'Syukran', 'meaning' => 'Terima Kasih', 'audio' => 'Syukran'],
                ['word' => 'تَفَضَّلْ', 'trans' => 'Tafadh-dhal', 'meaning' => 'Silakan', 'audio' => 'Tafadh-dhal'],
            ],
            'ja' => [
                ['word' => 'こんにちは', 'trans' => 'Konnichiwa', 'meaning' => 'Halo / Selamat Siang', 'audio' => 'Konnichiwa'],
                ['word' => 'ありがとう', 'trans' => 'Arigatou', 'meaning' => 'Terima Kasih', 'audio' => 'Arigatou'],
                ['word' => 'どうぞ', 'trans' => 'Douzo', 'meaning' => 'Silakan', 'audio' => 'Douzo'],
            ],
            'ko' => [
                ['word' => '안녕하세요', 'trans' => 'Annyeonghaseyo', 'meaning' => 'Halo', 'audio' => 'Annyeonghaseyo'],
                ['word' => '감사합니다', 'trans' => 'Gamsahamnida', 'meaning' => 'Terima Kasih', 'audio' => 'Gamsahamnida'],
                ['word' => '여기요', 'trans' => 'Yeogiyo', 'meaning' => 'Permisi / Di sini', 'audio' => 'Yeogiyo'],
            ],
            'zh' => [
                ['word' => '你好', 'trans' => 'Nǐ hǎo', 'meaning' => 'Halo', 'audio' => 'Nǐ hǎo'],
                ['word' => '谢谢', 'trans' => 'Xièxiè', 'meaning' => 'Terima Kasih', 'audio' => 'Xièxiè'],
                ['word' => '请', 'trans' => 'Qǐng', 'meaning' => 'Silakan', 'audio' => 'Qǐng'],
            ],
            default => [
                ['word' => 'Welcome', 'trans' => '/ˈwɛlkəm/', 'meaning' => 'Selamat Datang', 'audio' => 'Welcome'],
                ['word' => 'Thank you', 'trans' => '/θæŋk juː/', 'meaning' => 'Terima Kasih', 'audio' => 'Thank you'],
                ['word' => 'Please', 'trans' => '/pliːz/', 'meaning' => 'Silakan', 'audio' => 'Please'],
            ],
        };
    }

    /**
     * Fallback untuk menghasilkan 100 skenario jika file JSON belum tersedia
     */
    public static function generateFallbackBank(string $langCode, array $vocabs = [], int $lessonOrder = 1): array
    {
        $categories = [
            'Salam & Perkenalan' => [
                'icon' => 'user-check',
                'topics' => [
                    'Menyapa Rekan Baru di Hari Pertama',
                    'Berkenalan saat Menunggu Transportasi Umum',
                    'Menyapa Tetangga Baru di Kompleks',
                    'Pertemuan dengan Mahasiswa Pertukaran Asing',
                    'Sapaan Hangat di Lobi Hotel',
                    'Bertemu Teman Lama di Pusat Perbelanjaan',
                    'Perkenalan Singkat Sebelum Seminar',
                    'Menyapa Tamu Kehormatan di Kantor',
                    'Sapaan Santai di Kafe Perpustakaan',
                    'Menyapa Pemilik Toko Buku Langganan'
                ]
            ],
            'Restoran & Kuliner' => [
                'icon' => 'coffee',
                'topics' => [
                    'Memesan Menu Sarapan Pagi di Kafe',
                    'Menanyakan Rekomendasi Makanan Khas Penutur Asli',
                    'Meminta Pilihan Makanan Halal dan Non-Alergi',
                    'Memesan Meja untuk Rombongan Keluarga',
                    'Menambah Pesanan Minuman Hangat',
                    'Menanyakan Bumbu dan Tingkat Kepedasan Masakan',
                    'Meminta Tagihan Pembayaran di Restoran',
                    'Pemesanan Makanan Cepat Saji di Kasir',
                    'Menanyakan Menu Penutup Tradisional',
                    'Pujian Rasa Masakan kepada Koki Restoran'
                ]
            ],
            'Navigasi & Stasiun' => [
                'icon' => 'map-pin',
                'topics' => [
                    'Menanyakan Arah Menuju Peron Kereta Cepat',
                    'Membeli Tiket Bus Antarkota di Loket',
                    'Menanyakan Jadwal Keberangkatan Terakhir',
                    'Mencari Pintu Keluar Terdekat Menuju Pusat Kota',
                    'Menanyakan Jalur Pergantian Kereta Bawah Tanah',
                    'Memastikan Rute Bus Umum yang Melewati Kampus',
                    'Meminta Bantuan Menggunakan Mesin Tiket Otomatis',
                    'Menanyakan Lokasi Kantor Informasi Turis',
                    'Menanyakan Jarak Tempuh Berjalan Kaki',
                    'Memastikan Nama Halte Pemberhentian'
                ]
            ],
            'Pasar & Belanja' => [
                'icon' => 'shopping-bag',
                'topics' => [
                    'Menanyakan Harga Cinderamata Unik',
                    'Mencari Ukuran Pakaian yang Lebih Pas',
                    'Menanyakan Ketersediaan Warna Lain',
                    'Tawar-menawar Ramah di Pasar Tradisional',
                    'Metode Pembayaran Kartu atau Tunai',
                    'Mencari Hadiah Ulang Tahun untuk Sahabat',
                    'Meminta Bungkusan Hadiah Khusus',
                    'Menanyakan Kebijakan Penukaran Barang',
                    'Membeli Buah-buahan Segar di Pasar Pagi',
                    'Memastikan Kualitas Produk Kerajinan Tangan'
                ]
            ],
            'Kampus & Pendidikan' => [
                'icon' => 'graduation-cap',
                'topics' => [
                    'Menanyakan Ruang Kuliah Bersama Dosen',
                    'Diskusi Tugas Kelompok dengan Rekan Seangkatan',
                    'Meminjam Buku Referensi di Perpustakaan',
                    'Pendaftaran Ujian Bahasa Asing Tingkat Lanjut',
                    'Konsultasi Jadwal Bimbingan Riset',
                    'Menanyakan Bahan Kuliah Pekan Lalu',
                    'Bergabung dengan Klub Kebudayaan Internasional',
                    'Membeli Perlengkapan Alat Tulis di Koperasi',
                    'Mempersiapkan Presentasi Proyek Akhir',
                    'Berbagi Catatan Ringkasan Kuliah'
                ]
            ],
            'Kantor & Rapat' => [
                'icon' => 'briefcase',
                'topics' => [
                    'Menyambut Klien Asing di Ruang Rapat',
                    'Menyampaikan Laporan Progres Mingguan',
                    'Menjadwalkan Ulang Pertemuan Bisnis',
                    'Diskusi Target Penjualan dengan Manajer Tim',
                    'Mengirimkan Dokumen Melalui Surat Elektronik',
                    'Meminta Masukan Ide untuk Peluncuran Produk',
                    'Koordinasi Kerjasama Antardivisi',
                    'Menanyakan Prosedur Cuti Kerja',
                    'Mempersiapkan Ruangan Konferensi Video',
                    'Evaluasi Kepuasan Pelanggan Korporat'
                ]
            ],
            'Hotel & Wisata' => [
                'icon' => 'bed',
                'topics' => [
                    'Proses Check-in Kamar Pesanan Online',
                    'Meminta Layanan Pembersihan Kamar Harian',
                    'Menanyakan Sandi Jaringan Internet Nirkabel',
                    'Menitipkan Koper di Bagasi Resepsionis',
                    'Meminta Panggilan Bangun Pagi (Wake-up Call)',
                    'Menanyakan Rekomendasi Objek Wisata Ikonik',
                    'Memesan Taksi Menuju Bandara Internasional',
                    'Menanyakan Jadwal Sarapan Prasmanan Hotel',
                    'Menyewa Pemandu Wisata Bahasa Indonesia',
                    'Proses Check-out Cepat di Meja Depan'
                ]
            ],
            'Kesehatan & Medis' => [
                'icon' => 'heart-pulse',
                'topics' => [
                    'Konsultasi Gejala Demam dan Flu di Klinik',
                    'Membeli Obat Sakit Kepala di Apotek',
                    'Menanyakan Dosis dan Aturan Minum Obat',
                    'Mendaftar Pemeriksaan Dokter Spesialis',
                    'Menjelaskan Alergi terhadap Makanan Tertentu',
                    'Meminta Surat Keterangan Dokter',
                    'Memeriksakan Tekanan Darah dan Suhu Tubuh',
                    'Mencari Lokasi Instalasi Gawat Darurat',
                    'Menanyakan Layanan Asuransi Kesehatan',
                    'Mendapatkan Resep Vitamin Tambahan'
                ]
            ],
            'Diskusi 3 Orang' => [
                'icon' => 'users',
                'topics' => [
                    'Merencanakan Liburan Akhir Pekan Bertiga',
                    'Memilih Restoran Favorit untuk Acara Makan Bersama',
                    'Diskusi Pembagian Tugas Proyek Antara 3 Mahasiswa',
                    'Percakapan antara Tamu, Kasir, dan Manajer Restoran',
                    'Diskusi Antara Pembeli, Penjual, dan Pemandu Wisata',
                    'Musyawarah Memilih Topik Seminar Kampus',
                    'Percakapan Pasien, Resepsionis, dan Dokter Klinik',
                    'Membahas Rute Perjalanan Antara 3 Rekan Bepergian',
                    'Percakapan antara Pelamar, HRD, dan Pewawancara Teknis',
                    'Diskusi Menentukan Tanggal Reuni Alumni'
                ]
            ],
            'Solusi Masalah & Darurat' => [
                'icon' => 'shield-alert',
                'topics' => [
                    'Melaporkan Barang Tertinggal di Taksi',
                    'Meminta Bantuan Petugas Keamanan Stasiun',
                    'Mengatasi Kendala Koneksi Ponsel Pintar',
                    'Meminta Petunjuk Arah saat Tersesat',
                    'Melaporkan Kerusakan Pendingin Ruangan di Kamar',
                    'Menukar Pesanan Makanan yang Tertukar',
                    'Menanyakan Pos Informasi Barang Hilang',
                    'Meminta Bantuan Medis Pertama saat Terkilir',
                    'Menanyakan Nomor Telepon Darurat Kedutaan',
                    'Menyelesaikan Kesalahpahaman Jadwal Janji Temu'
                ]
            ]
        ];

        $speakers = self::getSpeakersForLanguage($langCode);
        $scenarios = [];
        $scenarioId = 1;

        foreach ($categories as $catName => $catData) {
            foreach ($catData['topics'] as $tIndex => $topicTitle) {
                $isThreeSpeakers = ($catName === 'Diskusi 3 Orang' || ($tIndex % 3 === 0));
                $participantCount = $isThreeSpeakers ? 3 : 2;

                $currentSpeakers = [
                    $speakers[0],
                    $speakers[1],
                    $isThreeSpeakers ? $speakers[2] : null
                ];

                $turns = self::buildScenarioTurns(
                    $langCode,
                    $catName,
                    $topicTitle,
                    $currentSpeakers,
                    $scenarioId,
                    $vocabs
                );

                $scenarios[] = [
                    'id' => $scenarioId,
                    'category' => $catName,
                    'icon' => $catData['icon'],
                    'title' => "Skenario #{$scenarioId}: {$topicTitle}",
                    'situation' => "Percakapan komunikasi kontekstual di situasi '{$topicTitle}' yang melibatkan {$participantCount} penutur aktif.",
                    'participant_count' => $participantCount,
                    'participants' => array_values(array_filter([
                        "{$currentSpeakers[0]['name']} ({$currentSpeakers[0]['role']})",
                        "{$currentSpeakers[1]['name']} ({$currentSpeakers[1]['role']})",
                        $isThreeSpeakers ? "{$currentSpeakers[2]['name']} ({$currentSpeakers[2]['role']})" : null
                    ])),
                    'turns' => $turns,
                ];

                $scenarioId++;
            }
        }

        return $scenarios;
    }

    /**
     * Backward-compatible wrapper untuk generate100Dialogues
     */
    public static function generate100Dialogues(string $langCode, array $vocabs = [], array $uData = [], int $lessonOrder = 1, ?Lesson $lesson = null, int $variationSeed = 0): array
    {
        if ($lesson) {
            return self::getDialoguesForLesson($lesson, $variationSeed);
        }

        $bank = self::loadDialogueBank($langCode, $vocabs, $lessonOrder);
        $bankCount = count($bank);
        if ($bankCount > 0) {
            $shift = abs((int)($lessonOrder * 19 + $variationSeed * 11)) % $bankCount;
            $rotated = array_merge(array_slice($bank, $shift), array_slice($bank, 0, $shift));
            $step = 7;
            $permuted = [];
            for ($i = 0; $i < $bankCount; $i++) {
                $idx = ($i * $step) % $bankCount;
                $permuted[] = $rotated[$idx];
            }
            return $permuted;
        }

        return $bank;
    }

    public static function getSpeakersForLanguage(string $langCode): array
    {
        return match ($langCode) {
            'ar' => [
                ['name' => 'Ahmad', 'role' => 'Penutur Utama (Tamu / Mahasiswa)', 'avatar' => 'AH'],
                ['name' => 'Fatimah', 'role' => 'Penutur Kedua (Petugas / Rekan)', 'avatar' => 'FA'],
                ['name' => 'Zaid', 'role' => 'Penutur Ketiga (Pemandu / Dosen)', 'avatar' => 'ZA'],
            ],
            'ja' => [
                ['name' => 'Tanaka-san', 'role' => 'Penutur Utama (Tamu / Mahasiswa)', 'avatar' => 'TA'],
                ['name' => 'Yuki-san', 'role' => 'Penutur Kedua (Staf / Rekan)', 'avatar' => 'YU'],
                ['name' => 'Sato-san', 'role' => 'Penutur Ketiga (Manajer / Pengajar)', 'avatar' => 'SA'],
            ],
            'ko' => [
                ['name' => 'Minjun', 'role' => 'Penutur Utama (Wisatawan / Siswa)', 'avatar' => 'MJ'],
                ['name' => 'Jisoo', 'role' => 'Penutur Kedua (Pegawai / Teman)', 'avatar' => 'JS'],
                ['name' => 'Taehyun', 'role' => 'Penutur Ketiga (Pemandu / Senior)', 'avatar' => 'TH'],
            ],
            'zh' => [
                ['name' => 'Li Wei', 'role' => 'Penutur Utama (Pelanggan / Pelajar)', 'avatar' => 'LW'],
                ['name' => 'Wang Fang', 'role' => 'Penutur Kedua (Pramuniaga / Rekan)', 'avatar' => 'WF'],
                ['name' => 'Zhang Ming', 'role' => 'Penutur Ketiga (Manajer / Dosen)', 'avatar' => 'ZM'],
            ],
            default => [
                ['name' => 'Alex', 'role' => 'Penutur Utama (Traveler / Student)', 'avatar' => 'AL'],
                ['name' => 'Emma', 'role' => 'Penutur Kedua (Officer / Friend)', 'avatar' => 'EM'],
                ['name' => 'David', 'role' => 'Penutur Ketiga (Guide / Specialist)', 'avatar' => 'DA'],
            ]
        };
    }

    private static function buildScenarioTurns(
        string $langCode,
        string $category,
        string $topic,
        array $speakers,
        int $scenarioNum,
        array $vocabs
    ): array {
        $sp1 = $speakers[0];
        $sp2 = $speakers[1];
        $sp3 = $speakers[2] ?? null;

        switch ($langCode) {
            case 'ar':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "السَّلَامُ عَلَيْكُمْ، هَلْ يُمْكِنُكَ مُسَاعَدَتِي فِي {$topic}؟",
                    'trans' => "Assalamu 'alaikum, hal yumkinuka musa'adati fi {$topic}?",
                    'meaning' => "Assalamu'alaikum, bisakah Anda membantu saya mengenai {$topic}?",
                    'audio' => "السَّلَامُ عَلَيْكُمْ، هَلْ يُمْكِنُكَ مُسَاعَدَتِي هُنَا؟",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "وَعَلَيْكُمُ السَّلَامُ! بِكُلِّ سُرُورٍ، هَذَا هُوَ الْأَمْرُ الْمَطْلُوبُ تَمَامًا.",
                    'trans' => "Wa'alaikumussalam! Bikulli sururin, hadza huwal amrul mathlubu tamaman.",
                    'meaning' => "Wa'alaikumsalam! Dengan senang hati, inilah hal yang diperlukan secara tepat.",
                    'audio' => "وَعَلَيْكُمُ السَّلَامُ! بِكُلِّ سُرُورٍ، تَفَضَّلْ هُنَا.",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "شُكْرًا جَزِيلاً لَكَ عَلَى هَذَا التَّوْضِيحِ الْمُفِيدِ.",
                    'trans' => "Syukran jazilan laka 'ala hadzat taudhihil mufid.",
                    'meaning' => "Terima kasih banyak atas penjelasan yang sangat bermanfaat ini.",
                    'audio' => "شُكْرًا جَزِيلاً لَكَ عَلَى الْمُسَاعَدَةِ.",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "أَهْلًا بِكُمْ دَائِمًا، وَنَحْنُ فِي خِدْمَتِكُمْ فِي أَيِّ وَقْتٍ.",
                        'trans' => "Ahlan bikum da'iman, wa nahnu fi khidmatikum fi ayyi waqt.",
                        'meaning' => "Selamat datang selalu, dan kami siap membantu Anda kapan saja.",
                        'audio' => "أَهْلًا بِكُمْ دَائِمًا فِي أَيِّ وَقْتٍ.",
                    ];
                }
                break;

            case 'ja':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "すみません、{$topic}について教えていただけますか？",
                    'trans' => "Sumimasen, {$topic} ni tsuite oshiete itadakemasu ka?",
                    'meaning' => "Permisi, bisakah Anda memberi tahu saya tentang {$topic}?",
                    'audio' => "すみません、少し教えていただけますか？",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "はい、喜んで！こちらがご案内になりますよ。",
                    'trans' => "Hai, yorokonde! Kochira ga goannai ni narimasu yo.",
                    'meaning' => "Ya, dengan senang hati! Berikut ini adalah petunjuknya.",
                    'audio' => "はい、喜んで！どうぞこちらへ。",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "分かりやすくて助かりました。どうもありがとうございます！",
                    'trans' => "Wakari yasukute tasakarimashita. Doumo arigatou gozaimasu!",
                    'meaning' => "Sangat mudah dipahami dan membantu sekali. Terima kasih banyak!",
                    'audio' => "どうもありがとうございます！",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "素晴らしいですね。また何かあればいつでもお声がけください。",
                        'trans' => "Subarashii desu ne. Mata nanika areba itsudemo okoegake kudasai.",
                        'meaning' => "Bagus sekali ya. Jika ada hal lain lagi silakan beri tahu kami kapan saja.",
                        'audio' => "いつでもお声がけくださいね。",
                    ];
                }
                break;

            case 'ko':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "실례합니다, 혹시 {$topic} 도와주실 수 있나요?",
                    'trans' => "Sillyehamnida, hoksi {$topic} dowajusil su innayo?",
                    'meaning' => "Permisi, apakah Anda bisa membantu saya mengenai {$topic}?",
                    'audio' => "실례합니다, 혹시 좀 도와주실 수 있나요?",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "네, 물론입니다! 여기에 자세히 설명되어 있습니다.",
                    'trans' => "Ne, mollonimnida! Yeogie jasehi seolmyeongdoeeo itseumnida.",
                    'meaning' => "Ya, tentu saja! Di sini sudah dijelaskan secara lengkap.",
                    'audio' => "네, 물론입니다! 여기에 있습니다.",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "친절하게 알려주셔서 정말 감사합니다!",
                    'trans' => "Chinjeolhage allyeojusyeoseo jeongmal gamsahamnida!",
                    'meaning' => "Terima kasih banyak telah memberi tahu dengan sangat ramah!",
                    'audio' => "정말 대단히 감사합니다!",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "좋은 시간 보내세요! 언제든 다시 물어보세요.",
                        'trans' => "Joeun sigan bonaeseyo! Eonjedeun dasi mureoboseyo.",
                        'meaning' => "Semoga hari Anda menyenangkan! Kapan pun silakan bertanya lagi.",
                        'audio' => "좋은 시간 보내시고 언제든 물어보세요.",
                    ];
                }
                break;

            case 'zh':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "请问，关于{$topic}，你能帮我一下吗？",
                    'trans' => "Qǐngwèn, guānyú {$topic}, nǐ néng bāng wǒ yīxià ma?",
                    'meaning' => "Permisi, mengenai {$topic}, bisakah Anda membantu saya sebentar?",
                    'audio' => "请问，你能帮我一下吗？",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "当然可以！请看这里，非常方便实用。",
                    'trans' => "Dāngrán kěyǐ! Qǐng kàn zhèlǐ, fēicháng fāngbiàn shíyòng.",
                    'meaning' => "Tentu saja bisa! Silakan lihat di sini, sangat mudah dan praktis.",
                    'audio' => "当然可以！请看这里。",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "太感谢你了，解决了我的大问题！",
                    'trans' => "Tài gǎnxiè nǐ le, jiějué le wǒ de dà wèntí!",
                    'meaning' => "Sangat berterima kasih kepada Anda, masalah saya terselesaikan!",
                    'audio' => "太感谢你了，非常实用！",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "不客气，祝你一切顺利，有需要随时来找我们！",
                        'trans' => "Bù kèqì, zhù nǐ yīqiè shùnlì, yǒu xūyào suíshí lái zhǎo wǒmen!",
                        'meaning' => "Sama-sama, semoga segalanya lancar, bila butuh bantuan datanglah kapan saja!",
                        'audio' => "不客气，祝你一切顺利！",
                    ];
                }
                break;

            default: // English
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "Excuse me, could you please guide me regarding {$topic}?",
                    'trans' => "/ɪkˈskjuːz miː, kʊd juː pliːz ɡaɪd miː rɪˈɡɑːrdɪŋ {$topic}/",
                    'meaning' => "Permisi, bisakah Anda memandu saya mengenai {$topic}?",
                    'audio' => "Excuse me, could you please guide me here?",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "Certainly, with great pleasure! Here is everything you need to know.",
                    'trans' => "/ˈsɜːrtnli, wɪð ɡreɪt ˈpleʒər! hɪər ɪz ˈevriθɪŋ juː niːd tuː noʊ/",
                    'meaning' => "Tentu saja, dengan senang hati! Inilah semua yang perlu Anda ketahui.",
                    'audio' => "Certainly, with great pleasure! Here you go.",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "Thank you so much! That explains everything clearly.",
                    'trans' => "/θæŋk juː soʊ mʌtʃ! ðæt ɪkˈspleɪnz ˈevriθɪŋ ˈklɪrli/",
                    'meaning' => "Terima kasih banyak! Itu menjelaskan segalanya dengan sangat jelas.",
                    'audio' => "Thank you so much for your kind help!",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "You are most welcome! Feel free to reach out anytime.",
                        'trans' => "/juː ɑːr moʊst ˈwelkəm! fiːl friː tuː riːtʃ aʊt ˈenitaɪm/",
                        'meaning' => "Sama-sama! Jangan ragu menghubungi kami kapan saja.",
                        'audio' => "You are most welcome anytime!",
                    ];
                }
                break;
        }

        // Tambahkan bedah suku kata otomatis
        foreach ($turns as &$turn) {
            if ($scenarioNum <= 10) {
                $trans = LinguisticBreakdownService::getSentenceTransliteration($langCode, $turn['text'], $turn['trans']);
                $turn['trans'] = $trans;
                $turn['breakdown'] = LinguisticBreakdownService::getBreakdown($langCode, $turn['text'], $trans, $turn['meaning']);
            } else {
                $turn['breakdown'] = [];
            }
        }

        return $turns;
    }
}
