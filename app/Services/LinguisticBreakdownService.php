<?php

namespace App\Services;

class LinguisticBreakdownService
{
    /**
     * Mengembalikan bedah suku kata dan kata per kata untuk suatu kalimat.
     * Output: array of ['token' => '...', 'syllables' => '...', 'meaning' => '...']
     */
    public static function getBreakdown(string $langCode, string $target, ?string $trans = null, ?string $meaning = null): array
    {
        $cleanTarget = trim($target);
        if (empty($cleanTarget)) {
            return [];
        }

        // 1. Cek repositori kalimat yang sudah dipetakan secara mendalam
        $known = self::getKnownSentenceBreakdowns($langCode);
        if (isset($known[$cleanTarget])) {
            return $known[$cleanTarget];
        }

        // Normalisasi tanda baca untuk cek kecocokan variasi
        $unpunct = rtrim($cleanTarget, '。！？.?!,،');
        if (isset($known[$unpunct])) {
            return $known[$unpunct];
        }

        // 2. Jika belum ada di repositori statis, lakukan algoritma segmentasi otomatis
        return self::autoSegmentSentence($langCode, $cleanTarget, $trans, $meaning);
    }

    /**
     * Menghasilkan transliterasi huruf abjad Latin utuh dan akurat untuk satu kalimat
     */
    public static function getSentenceTransliteration(string $langCode, string $sentence, ?string $existingTrans = null): string
    {
        $clean = trim($sentence);
        if (empty($clean)) return '';

        // Cek jika ada di kalimat presisi tinggi
        $known = self::getKnownSentenceBreakdowns($langCode);
        if (isset($known[$clean])) {
            $tokens = array_map(fn($item) => str_replace('-', '', $item['syllables']), $known[$clean]);
            return implode(' ', $tokens);
        }

        $unpunct = rtrim($clean, '。！？.?!,،');
        if (isset($known[$unpunct])) {
            $tokens = array_map(fn($item) => str_replace('-', '', $item['syllables']), $known[$unpunct]);
            return implode(' ', $tokens);
        }

        // Jika existingTrans sudah multi-kata dan bukan sekadar kata tunggal padahal kalimat panjang
        $sentenceWordCount = count(preg_split('/\s+/u', $clean, -1, PREG_SPLIT_NO_EMPTY));
        if (!empty($existingTrans)) {
            $transWordCount = count(preg_split('/\s+/u', trim($existingTrans), -1, PREG_SPLIT_NO_EMPTY));
            if ($sentenceWordCount <= 1 || $transWordCount >= 2) {
                return $existingTrans;
            }
        }

        // Transliterasi otomatis berbasis fonetik bahasa
        return match ($langCode) {
            'ja' => self::transliterateJapanese($clean),
            'ko' => self::transliterateKorean($clean),
            'ar' => self::transliterateArabic($clean),
            'zh' => self::transliterateChinese($clean),
            default => $clean,
        };
    }

    /**
     * Database kalimat dan bedah suku kata presisi tinggi
     */
    private static function getKnownSentenceBreakdowns(string $langCode): array
    {
        return match ($langCode) {
            'ar' => [
                'أَنَا طَالِبٌ' => [
                    ['token' => 'أَنَا', 'syllables' => 'A-na', 'meaning' => 'Saya'],
                    ['token' => 'طَالِبٌ', 'syllables' => 'Thaa-li-bun', 'meaning' => 'Siswa / Murid'],
                ],
                'أَنْتَ أُسْتَاذٌ' => [
                    ['token' => 'أَنْتَ', 'syllables' => 'An-ta', 'meaning' => 'Kamu (Laki-laki)'],
                    ['token' => 'أُسْتَاذٌ', 'syllables' => 'Us-taa-dzun', 'meaning' => 'Guru / Dosen'],
                ],
                'هِيَ طَبِيْبَةٌ' => [
                    ['token' => 'هِيَ', 'syllables' => 'Hi-ya', 'meaning' => 'Dia (Perempuan)'],
                    ['token' => 'طَبِيْبَةٌ', 'syllables' => 'Tha-bii-ba-tun', 'meaning' => 'Dokter (Perempuan)'],
                ],
                'السَّلَامُ عَلَيْكُمْ، مَا اسْمُكَ؟' => [
                    ['token' => 'السَّلَامُ', 'syllables' => 'As-sa-laa-mu', 'meaning' => 'Keselamatan'],
                    ['token' => 'عَلَيْكُمْ', 'syllables' => '\'A-lay-kum', 'meaning' => 'Atas kalian'],
                    ['token' => 'مَا', 'syllables' => 'Maa', 'meaning' => 'Apa / Siapa'],
                    ['token' => 'اسْمُكَ', 'syllables' => 'Is-mu-ka', 'meaning' => 'Namamu'],
                ],
                'وَعَلَيْكُمُ السَّلَامُ، اِسْمِي فَيْصَل.' => [
                    ['token' => 'وَعَلَيْكُمُ', 'syllables' => 'Wa-\'a-lay-ku-mu', 'meaning' => 'Dan atas kalian juga'],
                    ['token' => 'السَّلَامُ', 'syllables' => 'As-sa-laa-mu', 'meaning' => 'Keselamatan'],
                    ['token' => 'اِسْمِي', 'syllables' => 'Is-mii', 'meaning' => 'Nama saya'],
                    ['token' => 'فَيْصَل', 'syllables' => 'Fay-shal', 'meaning' => 'Faisal'],
                ],
                'هَذَا كِتَابٌ جَدِيدٌ' => [
                    ['token' => 'هَذَا', 'syllables' => 'Haa-dzaa', 'meaning' => 'Ini (Mudzakkar)'],
                    ['token' => 'كِتَابٌ', 'syllables' => 'Ki-taa-bun', 'meaning' => 'Buku'],
                    ['token' => 'جَدِيدٌ', 'syllables' => 'Ja-dii-dun', 'meaning' => 'Baru'],
                ],
                'هَذَا كِتَابٌ مُفِيدٌ' => [
                    ['token' => 'هَذَا', 'syllables' => 'Haa-dzaa', 'meaning' => 'Ini'],
                    ['token' => 'كِتَابٌ', 'syllables' => 'Ki-taa-bun', 'meaning' => 'Buku'],
                    ['token' => 'مُفِيدٌ', 'syllables' => 'Mu-fii-dun', 'meaning' => 'Bermanfaat'],
                ],
                'عَفْوًا، أَيْنَ المَسْجِدُ؟' => [
                    ['token' => 'عَفْوًا', 'syllables' => '\'Af-wan', 'meaning' => 'Permisi / Maaf'],
                    ['token' => 'أَيْنَ', 'syllables' => 'Ay-na', 'meaning' => 'Di mana'],
                    ['token' => 'المَسْجِدُ', 'syllables' => 'Al-mas-ji-du', 'meaning' => 'Masjid itu'],
                ],
                'أُرِيدُ قَلَمًا لِأَكْتُبَ' => [
                    ['token' => 'أُرِيدُ', 'syllables' => 'U-rii-du', 'meaning' => 'Saya ingin'],
                    ['token' => 'قَلَمًا', 'syllables' => 'Qa-la-man', 'meaning' => 'Pena'],
                    ['token' => 'لِأَكْتُبَ', 'syllables' => 'Li-ak-tu-ba', 'meaning' => 'Untuk menulis'],
                ],
                'أَذْهَبُ إِلَى المَدْرَسَةِ صَبَاحًا' => [
                    ['token' => 'أَذْهَبُ', 'syllables' => 'Adz-ha-bu', 'meaning' => 'Saya pergi'],
                    ['token' => 'إِلَى', 'syllables' => 'I-laa', 'meaning' => 'Ke'],
                    ['token' => 'المَدْرَسَةِ', 'syllables' => 'Al-mad-ra-sa-ti', 'meaning' => 'Sekolah'],
                    ['token' => 'صَبَاحًا', 'syllables' => 'Sha-baa-han', 'meaning' => 'Pagi hari'],
                ],
                'بَيْتِي قَرِيبٌ مِنَ المَسْجِدِ' => [
                    ['token' => 'بَيْتِي', 'syllables' => 'Bay-tii', 'meaning' => 'Rumah saya'],
                    ['token' => 'قَرِيبٌ', 'syllables' => 'Qa-rii-bun', 'meaning' => 'Dekat'],
                    ['token' => 'مِنَ', 'syllables' => 'Mi-na', 'meaning' => 'Dari'],
                    ['token' => 'المَسْجِدِ', 'syllables' => 'Al-mas-ji-di', 'meaning' => 'Masjid'],
                ],
                'أُرِيدُ مَاءً بَارِدًا' => [
                    ['token' => 'أُرِيدُ', 'syllables' => 'U-rii-du', 'meaning' => 'Saya ingin'],
                    ['token' => 'مَاءً', 'syllables' => 'Maa-an', 'meaning' => 'Air'],
                    ['token' => 'بَارِدًا', 'syllables' => 'Baa-ri-dan', 'meaning' => 'Dingin'],
                ],
                'الطَّعَامُ لَذِيذٌ جِدًّا' => [
                    ['token' => 'الطَّعَامُ', 'syllables' => 'Ath-tha-\'aa-mu', 'meaning' => 'Makanan itu'],
                    ['token' => 'لَذِيذٌ', 'syllables' => 'La-dzii-dzun', 'meaning' => 'Lezat / Enak'],
                    ['token' => 'جِدًّا', 'syllables' => 'Jid-dan', 'meaning' => 'Sangat'],
                ],
                'كَتَبْتُ الرِّسَالَةَ أَمْسِ' => [
                    ['token' => 'كَتَبْتُ', 'syllables' => 'Ka-tab-tu', 'meaning' => 'Saya menulis'],
                    ['token' => 'الرِّسَالَةَ', 'syllables' => 'Ar-ri-saa-la-ta', 'meaning' => 'Surat tersebut'],
                    ['token' => 'أَمْسِ', 'syllables' => 'Am-si', 'meaning' => 'Kemarin'],
                ],
                'ذَهَبَ عَلِيٌّ إِلَى السُّوْقِ' => [
                    ['token' => 'ذَهَبَ', 'syllables' => 'Dza-ha-ba', 'meaning' => 'Telah pergi'],
                    ['token' => 'عَلِيٌّ', 'syllables' => '\'A-li-yyun', 'meaning' => 'Ali'],
                    ['token' => 'إِلَى', 'syllables' => 'I-laa', 'meaning' => 'Ke'],
                    ['token' => 'السُّوْقِ', 'syllables' => 'As-suu-qi', 'meaning' => 'Pasar'],
                ],
            ],
            'ja' => [
                'わたし は がくせい です' => [
                    ['token' => 'わたし', 'syllables' => 'Wa-ta-shi', 'meaning' => 'Saya'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'がくせい', 'syllables' => 'Ga-ku-se-i', 'meaning' => 'Siswa / Mahasiswa'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah (Sopan)'],
                ],
                'わたしは がくせい です' => [
                    ['token' => 'わたし', 'syllables' => 'Wa-ta-shi', 'meaning' => 'Saya'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'がくせい', 'syllables' => 'Ga-ku-se-i', 'meaning' => 'Siswa / Mahasiswa'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah (Sopan)'],
                ],
                'わたしはみずをのみます。' => [
                    ['token' => 'わたし', 'syllables' => 'Wa-ta-shi', 'meaning' => 'Saya'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'みず', 'syllables' => 'Mi-zu', 'meaning' => 'Air'],
                    ['token' => 'を', 'syllables' => 'o', 'meaning' => 'Partikel Objek'],
                    ['token' => 'のみます', 'syllables' => 'No-mi-ma-su', 'meaning' => 'Minum'],
                ],
                'たなかさんはほんをよみます。' => [
                    ['token' => 'たなかさん', 'syllables' => 'Ta-na-ka-san', 'meaning' => 'Tuan Tanaka'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'ほん', 'syllables' => 'Hon', 'meaning' => 'Buku'],
                    ['token' => 'を', 'syllables' => 'o', 'meaning' => 'Partikel Objek'],
                    ['token' => 'よみます', 'syllables' => 'Yo-mi-ma-su', 'meaning' => 'Membaca'],
                ],
                'ちょっとまってください。' => [
                    ['token' => 'ちょっと', 'syllables' => 'Chot-to', 'meaning' => 'Sebentar'],
                    ['token' => 'まって', 'syllables' => 'Mat-te', 'meaning' => 'Tunggu (Te-form)'],
                    ['token' => 'ください', 'syllables' => 'Ku-da-sa-i', 'meaning' => 'Silakan / Tolong'],
                ],
                'いまにほんごをべんきょうしています。' => [
                    ['token' => 'いま', 'syllables' => 'I-ma', 'meaning' => 'Sekarang'],
                    ['token' => 'にほんご', 'syllables' => 'Ni-hon-go', 'meaning' => 'Bahasa Jepang'],
                    ['token' => 'を', 'syllables' => 'o', 'meaning' => 'Partikel Objek'],
                    ['token' => 'べんきょうして', 'syllables' => 'Ben-kyou-shi-te', 'meaning' => 'Belajar'],
                    ['token' => 'います', 'syllables' => 'I-ma-su', 'meaning' => 'Sedang berlangsung'],
                ],
                'はじめまして、たなか です。' => [
                    ['token' => 'はじめまして', 'syllables' => 'Ha-ji-me-ma-shi-te', 'meaning' => 'Senang berkenalan'],
                    ['token' => 'たなか', 'syllables' => 'Ta-na-ka', 'meaning' => 'Tanaka'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah'],
                ],
                'これは あたらしい ほん です' => [
                    ['token' => 'これ', 'syllables' => 'Ko-re', 'meaning' => 'Ini'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'あたらしい', 'syllables' => 'A-ta-ra-shi-i', 'meaning' => 'Baru'],
                    ['token' => 'ほん', 'syllables' => 'Hon', 'meaning' => 'Buku'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah'],
                ],
            ],
            'ko' => [
                '저는 학생입니다' => [
                    ['token' => '저', 'syllables' => 'Jeo', 'meaning' => 'Saya (Sopan)'],
                    ['token' => '는', 'syllables' => 'neun', 'meaning' => 'Partikel Topik'],
                    ['token' => '학생', 'syllables' => 'Hak-saeng', 'meaning' => 'Siswa / Murid'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah (Formal)'],
                ],
                '저는 인도네시아 사람입니다.' => [
                    ['token' => '저', 'syllables' => 'Jeo', 'meaning' => 'Saya'],
                    ['token' => '는', 'syllables' => 'neun', 'meaning' => 'Partikel Topik'],
                    ['token' => '인도네시아', 'syllables' => 'In-do-ne-si-a', 'meaning' => 'Indonesia'],
                    ['token' => '사람', 'syllables' => 'Sa-ram', 'meaning' => 'Orang'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah'],
                ],
                '만나서 반갑습니다.' => [
                    ['token' => '만나서', 'syllables' => 'Man-na-seo', 'meaning' => 'Karena bertemu'],
                    ['token' => '반갑습니다', 'syllables' => 'Ban-gap-seum-ni-da', 'meaning' => 'Senang (Formal)'],
                ],
                '밥을 먹어요' => [
                    ['token' => '밥', 'syllables' => 'Bap', 'meaning' => 'Nasi / Makanan'],
                    ['token' => '을', 'syllables' => 'eul', 'meaning' => 'Partikel Objek'],
                    ['token' => '먹어요', 'syllables' => 'Meo-geo-yo', 'meaning' => 'Makan (Informal Sopan)'],
                ],
                '커피를 마셔요' => [
                    ['token' => '커피', 'syllables' => 'Keo-pi', 'meaning' => 'Kopi'],
                    ['token' => '를', 'syllables' => 'reul', 'meaning' => 'Partikel Objek'],
                    ['token' => '마셔요', 'syllables' => 'Ma-syeo-yo', 'meaning' => 'Minum'],
                ],
                '책을 읽어요' => [
                    ['token' => '책', 'syllables' => 'Chaek', 'meaning' => 'Buku'],
                    ['token' => '을', 'syllables' => 'eul', 'meaning' => 'Partikel Objek'],
                    ['token' => '읽어요', 'syllables' => 'Il-geo-yo', 'meaning' => 'Membaca'],
                ],
                '이것은 책입니다' => [
                    ['token' => '이것', 'syllables' => 'I-geot', 'meaning' => 'Benda ini'],
                    ['token' => '은', 'syllables' => 'eun', 'meaning' => 'Partikel Topik'],
                    ['token' => '책', 'syllables' => 'Chaek', 'meaning' => 'Buku'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah'],
                ],
                '이것은 새 책입니다' => [
                    ['token' => '이것', 'syllables' => 'I-geot', 'meaning' => 'Ini'],
                    ['token' => '은', 'syllables' => 'eun', 'meaning' => 'Partikel Topik'],
                    ['token' => '새', 'syllables' => 'Sae', 'meaning' => 'Baru'],
                    ['token' => '책', 'syllables' => 'Chaek', 'meaning' => 'Buku'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah'],
                ],
            ],
            'en' => [
                'This is a new book' => [
                    ['token' => 'This', 'syllables' => 'This', 'meaning' => 'Ini'],
                    ['token' => 'is', 'syllables' => 'is', 'meaning' => 'Adalah'],
                    ['token' => 'a', 'syllables' => 'a', 'meaning' => 'Sebuah'],
                    ['token' => 'new', 'syllables' => 'new', 'meaning' => 'Baru'],
                    ['token' => 'book', 'syllables' => 'book', 'meaning' => 'Buku'],
                ],
                'I am a student' => [
                    ['token' => 'I', 'syllables' => 'I', 'meaning' => 'Saya'],
                    ['token' => 'am', 'syllables' => 'am', 'meaning' => 'Adalah'],
                    ['token' => 'a', 'syllables' => 'a', 'meaning' => 'Seorang'],
                    ['token' => 'student', 'syllables' => 'stu-dent', 'meaning' => 'Murid / Siswa'],
                ]
            ],
            'zh' => [
                '你好吗？' => [
                    ['token' => '你', 'syllables' => 'Nǐ', 'meaning' => 'Kamu'],
                    ['token' => '好', 'syllables' => 'hǎo', 'meaning' => 'Baik'],
                    ['token' => '吗', 'syllables' => 'ma', 'meaning' => 'Apakah?'],
                ],
                '我很好，谢谢。' => [
                    ['token' => '我', 'syllables' => 'Wǒ', 'meaning' => 'Saya'],
                    ['token' => '很', 'syllables' => 'hěn', 'meaning' => 'Sangat'],
                    ['token' => '好', 'syllables' => 'hǎo', 'meaning' => 'Baik'],
                    ['token' => '谢谢', 'syllables' => 'xiè-xie', 'meaning' => 'Terima kasih'],
                ],
                '我是印尼人。' => [
                    ['token' => '我', 'syllables' => 'Wǒ', 'meaning' => 'Saya'],
                    ['token' => '是', 'syllables' => 'shì', 'meaning' => 'Adalah'],
                    ['token' => '印尼人', 'syllables' => 'Yìn-ní-rén', 'meaning' => 'Orang Indonesia'],
                ],
                '这是我的书。' => [
                    ['token' => '这', 'syllables' => 'Zhè', 'meaning' => 'Ini'],
                    ['token' => '是', 'syllables' => 'shì', 'meaning' => 'Adalah'],
                    ['token' => '我的', 'syllables' => 'wǒ-de', 'meaning' => 'Milik saya'],
                    ['token' => '书', 'syllables' => 'shū', 'meaning' => 'Buku'],
                ],
                '你想喝茶还是咖啡？' => [
                    ['token' => '你', 'syllables' => 'Nǐ', 'meaning' => 'Kamu'],
                    ['token' => '想', 'syllables' => 'xiǎng', 'meaning' => 'Ingin'],
                    ['token' => '喝', 'syllables' => 'hē', 'meaning' => 'Minum'],
                    ['token' => '茶', 'syllables' => 'chá', 'meaning' => 'Teh'],
                    ['token' => '还是', 'syllables' => 'hái-shì', 'meaning' => 'Atau'],
                    ['token' => '咖啡', 'syllables' => 'kā-fēi', 'meaning' => 'Kopi'],
                ]
            ],
            default => []
        };
    }

    /**
     * Segmentasi kata dan perkiraan suku kata secara dinamis
     */
    private static function autoSegmentSentence(string $langCode, string $target, ?string $trans, ?string $meaning): array
    {
        // Pisahkan token berdasarkan spasi atau karakter bahasa (misal Jepang & Mandarin)
        $clean = trim($target);
        if ($langCode === 'ja' && !str_contains($clean, ' ')) {
            // Segmentasi morfem dasar Jepang jika kalimat tanpa spasi
            $words = self::segmentJapaneseParticles($clean);
        } elseif ($langCode === 'zh' && !str_contains($clean, ' ')) {
            $words = self::segmentChineseCharacters($clean);
        } else {
            $words = preg_split('/\s+/u', $clean, -1, PREG_SPLIT_NO_EMPTY);
        }

        $breakdown = [];
        $meaningWords = $meaning ? preg_split('/\s+/u', trim($meaning), -1, PREG_SPLIT_NO_EMPTY) : [];

        foreach ($words as $idx => $w) {
            $syl = self::estimateSyllables($langCode, $w);
            $tokenMeaning = self::findTokenMeaning($langCode, $w, $meaningWords[$idx] ?? null);

            $breakdown[] = [
                'token' => $w,
                'syllables' => $syl,
                'meaning' => $tokenMeaning,
            ];
        }

        return $breakdown;
    }

    /**
     * Estimasi bunyi suku kata Latin fonetis presisi tinggi
     */
    public static function estimateSyllables(string $langCode, string $word): string
    {
        $clean = trim($word, " \t\n\r\0\x0B.,?!:;。！？،");
        if (empty($clean)) return $word;

        return match ($langCode) {
            'ja' => self::kanaToSyllables($clean),
            'ko' => self::hangulToSyllables($clean),
            'ar' => self::arabicToSyllables($clean),
            'zh' => self::chineseToPinyin($clean),
            'en' => self::englishToSyllables($clean),
            default => $clean,
        };
    }

    /**
     * Mesin Transliterasi Korea (Hangul to Revised Romanization Syllables)
     */
    public static function hangulToSyllables(string $text): string
    {
        $cho = ['G', 'Kk', 'N', 'D', 'Tt', 'R', 'M', 'B', 'Pp', 'S', 'Ss', '', 'J', 'Jj', 'Ch', 'K', 'T', 'P', 'H'];
        $jung = ['a', 'ae', 'ya', 'yae', 'eo', 'e', 'yeo', 'ye', 'o', 'wa', 'wae', 'oe', 'yo', 'u', 'wo', 'we', 'wi', 'yu', 'eu', 'ui', 'i'];
        $jong = ['', 'k', 'k', 'ks', 'n', 'nj', 'nh', 't', 'l', 'lg', 'lm', 'lb', 'ls', 'lt', 'lp', 'lh', 'm', 'p', 'ps', 's', 'ss', 'ng', 'j', 'ch', 'k', 't', 'p', 'h'];

        $len = mb_strlen($text, 'UTF-8');
        $syls = [];

        for ($i = 0; $i < $len; $i++) {
            $ch = mb_substr($text, $i, 1, 'UTF-8');
            $code = mb_ord($ch, 'UTF-8');

            if ($code >= 0xAC00 && $code <= 0xD7A3) {
                $idx = $code - 0xAC00;
                $c = intdiv($idx, 588);
                $v = intdiv($idx % 588, 28);
                $j = $idx % 28;

                $initial = ($i === 0) ? $cho[$c] : strtolower($cho[$c]);
                $final = $jong[$j];

                // Asimilasi Batchim Nasalisasi: ㅂ/ㅍ + ㄴ/ㅁ -> m-n (contoh: 입니다 -> Im-ni-da, 합니다 -> Ham-ni-da)
                if (($final === 'p' || $final === 'b') && $i + 1 < $len) {
                    $nextCh = mb_substr($text, $i + 1, 1, 'UTF-8');
                    $nextCode = mb_ord($nextCh, 'UTF-8');
                    if ($nextCode >= 0xAC00 && $nextCode <= 0xD7A3) {
                        $nextChoIdx = intdiv($nextCode - 0xAC00, 588);
                        if ($cho[$nextChoIdx] === 'N' || $cho[$nextChoIdx] === 'M') {
                            $final = 'm';
                        }
                    }
                }

                $syls[] = $initial . $jung[$v] . $final;
            } else {
                if (trim($ch) !== '') {
                    $syls[] = $ch;
                }
            }
        }

        return implode('-', $syls);
    }

    /**
     * Mesin Transliterasi Jepang (Kana/Kanji to Hepburn Romaji Syllables)
     */
    public static function kanaToSyllables(string $text): string
    {
        // Kanji substitusi praktis
        $kanjiMap = [
            '私' => 'わたし', '学生' => 'がくせい', '先生' => 'せんせい',
            '日本' => 'にほん', '本' => 'ほん', '水' => 'みず',
            '友達' => 'ともだち', '食べる' => 'たべる', '食べます' => 'たべます',
            '飲む' => 'のむ', '飲みます' => 'のみます', '読む' => 'よむ',
            '読みます' => 'よみます', '勉強' => 'べんきょう', '新' => 'あたら',
            '車' => 'くるま', '家' => 'いえ', '今' => 'いま', '人' => 'ひと',
            '男' => 'おとこ', '女' => 'おんな', '父' => 'ちち', '母' => 'はは'
        ];
        $text = str_replace(array_keys($kanjiMap), array_values($kanjiMap), $text);

        $youon = [
            'きゃ' => 'kya', 'きゅ' => 'kyu', 'きょ' => 'kyo',
            'しゃ' => 'sha', 'しゅ' => 'shu', 'しょ' => 'sho',
            'ちゃ' => 'cha', 'ちゅ' => 'chu', 'ちょ' => 'cho',
            'にゃ' => 'nya', 'にゅ' => 'nyu', 'にょ' => 'nyo',
            'ひゃ' => 'hya', 'ひゅ' => 'hyu', 'ひょ' => 'hyo',
            'みゃ' => 'mya', 'みゅ' => 'myu', 'みょ' => 'myo',
            'りゃ' => 'rya', 'りゅ' => 'ryu', 'りょ' => 'ryo',
            'ぎゃ' => 'gya', 'ぎゅ' => 'gyu', 'ぎょ' => 'gyo',
            'じゃ' => 'ja', 'じゅ' => 'ju', 'じょ' => 'jo',
            'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
            'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
            'キャ' => 'kya', 'キュ' => 'kyu', 'キョ' => 'kyo',
            'シャ' => 'sha', 'シュ' => 'shu', 'ショ' => 'sho',
            'チャ' => 'cha', 'チュ' => 'chu', 'チョ' => 'cho',
        ];

        $single = [
            'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
            'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
            'さ' => 'sa', 'し' => 'shi', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
            'た' => 'ta', 'ち' => 'chi', 'つ' => 'tsu', 'て' => 'te', 'と' => 'to',
            'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
            'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'fu', 'へ' => 'he', 'ほ' => 'ho',
            'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
            'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
            'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
            'わ' => 'wa', 'を' => 'o', 'ん' => 'n',
            'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'ゲ' => 'ge', 'ご' => 'go',
            'ざ' => 'za', 'じ' => 'ji', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
            'だ' => 'da', 'ぢ' => 'ji', 'づ' => 'zu', 'で' => 'de', 'ど' => 'do',
            'ば' => 'ba', 'び' => 'bi', 'ぶ' => 'bu', 'べ' => 'be', 'ぼ' => 'bo',
            'ぱ' => 'pa', 'ぴ' => 'pi', 'ぷ' => 'pu', 'ぺ' => 'pe', 'ぽ' => 'po',
            'ア' => 'a', 'イ' => 'i', 'ウ' => 'u', 'エ' => 'e', 'オ' => 'o',
            'カ' => 'ka', 'キ' => 'ki', 'ク' => 'ku', 'ケ' => 'ke', 'コ' => 'ko',
            'サ' => 'sa', 'シ' => 'shi', 'ス' => 'su', 'セ' => 'se', 'ソ' => 'so',
            'タ' => 'ta', 'チ' => 'chi', 'ツ' => 'tsu', 'テ' => 'te', 'ト' => 'to',
            'ナ' => 'na', 'ニ' => 'ni', 'ヌ' => 'nu', 'ネ' => 'ne', 'ノ' => 'no',
            'ハ' => 'ha', 'ヒ' => 'hi', 'フ' => 'fu', 'ヘ' => 'he', 'ホ' => 'ho',
            'マ' => 'ma', 'ミ' => 'mi', 'ム' => 'mu', 'メ' => 'me', 'モ' => 'mo',
            'ヤ' => 'ya', 'ユ' => 'yu', 'ヨ' => 'yo',
            'ラ' => 'ra', 'リ' => 'ri', 'ル' => 'ru', 'レ' => 're', 'ロ' => 'ro',
            'ワ' => 'wa', 'ヲ' => 'o', 'ン' => 'n',
            'ガ' => 'ga', 'ギ' => 'gi', 'グ' => 'gu', 'ゴ' => 'go',
            'ザ' => 'za', 'ジ' => 'ji', 'ズ' => 'zu', 'ゼ' => 'ze', 'ゾ' => 'zo',
            'ダ' => 'da', 'デ' => 'de', 'ド' => 'do',
            'バ' => 'ba', 'ビ' => 'bi', 'ブ' => 'bu', 'ベ' => 'be', 'ボ' => 'bo',
            'パ' => 'pa', 'ピ' => 'pi', 'プ' => 'pu', 'ペ' => 'pe', 'ポ' => 'po',
        ];

        $res = [];
        $len = mb_strlen($text, 'UTF-8');
        $i = 0;

        while ($i < $len) {
            $ch2 = mb_substr($text, $i, 2, 'UTF-8');
            if (isset($youon[$ch2])) {
                $res[] = ($i === 0) ? ucfirst($youon[$ch2]) : $youon[$ch2];
                $i += 2;
                continue;
            }

            $ch1 = mb_substr($text, $i, 1, 'UTF-8');
            if ($ch1 === 'っ' || $ch1 === 'ッ') {
                $next = mb_substr($text, $i + 1, 1, 'UTF-8');
                $nextSyl = $single[$next] ?? ($youon[mb_substr($text, $i + 1, 2, 'UTF-8')] ?? '');
                if ($nextSyl !== '') {
                    $res[] = substr($nextSyl, 0, 1);
                }
                $i++;
                continue;
            }

            if (isset($single[$ch1])) {
                $val = ($i === 0) ? ucfirst($single[$ch1]) : $single[$ch1];
                $res[] = $val;
            } else {
                if (trim($ch1) !== '') {
                    $res[] = $ch1;
                }
            }
            $i++;
        }

        return implode('-', array_filter($res, fn($x) => $x !== ''));
    }

    /**
     * Mesin Transliterasi Arab (Harakat to Latin Abjad Syllables)
     */
    public static function arabicToSyllables(string $word): string
    {
        $letters = [
            'ا' => 'a', 'أ' => 'a', 'إ' => 'i', 'آ' => 'aa', 'ء' => '\'', 'ؤ' => 'u', 'ئ' => 'i',
            'ب' => 'b', 'ت' => 't', 'ث' => 'ts', 'ج' => 'j', 'ح' => 'h', 'خ' => 'kh',
            'د' => 'd', 'ذ' => 'dz', 'ر' => 'r', 'ز' => 'z', 'س' => 's', 'ش' => 'sy',
            'ص' => 'sh', 'ض' => 'dh', 'ط' => 'th', 'ظ' => 'zh', 'ع' => '\'', 'غ' => 'gh',
            'ف' => 'f', 'ق' => 'q', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
            'ه' => 'h', 'و' => 'w', 'ي' => 'y', 'ة' => 'h', 'ى' => 'aa'
        ];

        $fatHa = "\u{064E}"; // َ
        $kasRa = "\u{0650}"; // ِ
        $dhamMa = "\u{064F}"; // ُ
        $suKun = "\u{0652}"; // ْ
        $shadDah = "\u{0651}"; // ّ
        $fatHatan = "\u{064B}"; // ً
        $kasRatan = "\u{064D}"; // ٍ
        $dhamMatan = "\u{064C}"; // ٌ
        $alifKhanjariah = "\u{0670}"; // ٰ

        $len = mb_strlen($word, 'UTF-8');
        $syls = [];
        $cur = '';

        for ($i = 0; $i < $len; $i++) {
            $ch = mb_substr($word, $i, 1, 'UTF-8');
            $next = ($i + 1 < $len) ? mb_substr($word, $i + 1, 1, 'UTF-8') : '';
            $next2 = ($i + 2 < $len) ? mb_substr($word, $i + 2, 1, 'UTF-8') : '';

            if (isset($letters[$ch])) {
                $base = $letters[$ch];

                if ($next === $shadDah) {
                    $base = $base . $base;
                    if ($next2 === $fatHa) { $base .= 'a'; $i += 2; }
                    elseif ($next2 === $kasRa) { $base .= 'i'; $i += 2; }
                    elseif ($next2 === $dhamMa) { $base .= 'u'; $i += 2; }
                    elseif ($next2 === $fatHatan) { $base .= 'an'; $i += 2; }
                    elseif ($next2 === $kasRatan) { $base .= 'in'; $i += 2; }
                    elseif ($next2 === $dhamMatan) { $base .= 'un'; $i += 2; }
                    else { $i += 1; }
                    $syls[] = $base;
                } elseif ($next === $fatHa) {
                    $vowel = ($next2 === 'ا' || $next2 === 'ى') ? 'aa' : 'a';
                    $i += ($next2 === 'ا' || $next2 === 'ى') ? 2 : 1;
                    $syls[] = $base . $vowel;
                } elseif ($next === $kasRa) {
                    $vowel = ($next2 === 'ي') ? 'ii' : 'i';
                    $i += ($next2 === 'ي') ? 2 : 1;
                    $syls[] = $base . $vowel;
                } elseif ($next === $dhamMa) {
                    $vowel = ($next2 === 'و') ? 'uu' : 'u';
                    $i += ($next2 === 'و') ? 2 : 1;
                    $syls[] = $base . $vowel;
                } elseif ($next === $fatHatan) {
                    $i += ($next2 === 'ا') ? 2 : 1;
                    $syls[] = $base . 'an';
                } elseif ($next === $kasRatan) {
                    $i++;
                    $syls[] = $base . 'in';
                } elseif ($next === $dhamMatan) {
                    $i++;
                    $syls[] = $base . 'un';
                } elseif ($next === $alifKhanjariah) {
                    $i++;
                    $syls[] = $base . 'aa';
                } elseif ($next === $suKun) {
                    $i++;
                    if (!empty($syls)) {
                        $lastIdx = count($syls) - 1;
                        $syls[$lastIdx] .= $base;
                    } else {
                        $syls[] = $base;
                    }
                } else {
                    $syls[] = $base;
                }
            }
        }

        if (empty($syls)) return $word;
        $formatted = implode('-', $syls);
        return ucfirst($formatted);
    }

    /**
     * Mesin Transliterasi Bahasa Inggris
     */
    public static function englishToSyllables(string $word): string
    {
        return ucfirst(strtolower(trim($word)));
    }

    /**
     * Transliterasi utuh kalimat Arab
     */
    private static function transliterateArabic(string $sentence): string
    {
        $words = preg_split('/\s+/u', trim($sentence), -1, PREG_SPLIT_NO_EMPTY);
        $res = array_map(fn($w) => str_replace('-', '', self::arabicToSyllables($w)), $words);
        return implode(' ', $res);
    }

    /**
     * Transliterasi utuh kalimat Jepang
     */
    private static function transliterateJapanese(string $sentence): string
    {
        $kana = self::kanaToSyllables($sentence);
        $clean = str_replace('-', '', $kana);
        // Spasikan partikel umum (wa, o, de, ni, to, ga)
        return preg_replace('/(wa|o|ga|ni|de|to)(?=[A-Z])/u', '$1 ', $clean);
    }

    /**
     * Transliterasi utuh kalimat Korea
     */
    private static function transliterateKorean(string $sentence): string
    {
        $words = preg_split('/\s+/u', trim($sentence), -1, PREG_SPLIT_NO_EMPTY);
        $res = array_map(fn($w) => str_replace('-', '', self::hangulToSyllables($w)), $words);
        return implode(' ', $res);
    }

    /**
     * Transliterasi utuh kalimat Mandarin ke Hanyu Pinyin
     */
    private static function transliterateChinese(string $sentence): string
    {
        $tokens = self::segmentChineseCharacters(trim($sentence));
        $res = array_map(fn($t) => self::chineseToPinyin($t), $tokens);
        return implode(' ', $res);
    }

    /**
     * Pemetaan Hanzi ke Hanyu Pinyin bersuku kata
     */
    public static function chineseToPinyin(string $text): string
    {
        $clean = trim($text, " \t\n\r\0\x0B.,?!:;。！？，、");
        $charMap = [
            '你好' => 'Nǐ-hǎo', '您好' => 'Nín-hǎo', '早' => 'Zǎo', '早上好' => 'Zǎoshang-hǎo',
            '晚上好' => 'Wǎnshang-hǎo', '谢谢' => 'Xiè-xie', '再见' => 'Zài-jiàn',
            '对不起' => 'Duì-bu-qǐ', '没关系' => 'Méi-guān-xi', '不客气' => 'Bù-kè-qi',
            '请' => 'Qǐng', '我' => 'Wǒ', '你' => 'Nǐ', '您' => 'Nín', '他' => 'Tā',
            '她' => 'Tā', '我们' => 'Wǒ-men', '他们' => 'Tā-men', '人' => 'Rén',
            '老师' => 'Lǎo-shī', '学生' => 'Xué-sheng', '朋友' => 'Péng-you', '医生' => 'Yī-shēng',
            '中国' => 'Zhōng-guó', '印尼' => 'Yìn-ní', '印尼人' => 'Yìn-ní-rén',
            '中国人' => 'Zhōng-guó-rén', '书' => 'Shū', '水' => 'Shuǐ', '饭' => 'Fàn',
            '吃饭' => 'Chī-fàn', '喝水' => 'Hē-shuǐ', '茶' => 'Chá', '咖啡' => 'Kā-fēi',
            '家' => 'Jiā', '学校' => 'Xué-xiào', '医院' => 'Yī-yuàn', '饭店' => 'Fàn-diàn',
            '这' => 'Zhè', '这是' => 'Zhè-shì', '那' => 'Nà', '那是' => 'Nà-shì',
            '哪里' => 'Nǎ-lǐ', '什么' => 'Shén-me', '谁' => 'Shéi', '多少' => 'Duō-shǎo',
            '多少钱' => 'Duō-shao-qián', '太贵了' => 'Tài-guì-le', '便宜' => 'Pián-yi',
            '是' => 'Shì', '不是' => 'Bù-shì', '有' => 'Yǒu', '没有' => 'Méi-yǒu',
            '看' => 'Kàn', '听' => 'Tīng', '说' => 'Shuō', '读' => 'Dú', '写' => 'Xiě',
            '去' => 'Qù', '来' => 'Lái', '想' => 'Xiǎng', '喜欢' => 'Xǐ-huan',
            '好' => 'Hǎo', '大' => 'Dà', '小' => 'Xiǎo', '多' => 'Duō', '少' => 'Shǎo',
            '很' => 'Hěn', '太' => 'Tài', '不' => 'Bù', '也' => 'Yě', '都' => 'Dōu',
            '吗' => 'ma', '呢' => 'ne', '的' => 'de', '在' => 'zài', '和' => 'hé',
            '一' => 'Yī', '二' => 'Èr', '三' => 'Sān', '四' => 'Sì', '五' => 'Wǔ',
            '六' => 'Liù', '七' => 'Qī', '八' => 'Bā', '九' => 'Jiǔ', '十' => 'Shí',
            '百' => 'Bǎi', '千' => 'Qiān', '块' => 'Kuài', '钱' => 'Qián',
            '年' => 'Nián', '月' => 'Yuè', '日' => 'Rì', '星期' => 'Xīng-qī', '点' => 'Diǎn',
            '现在' => 'Xiàn-zài', '今天' => 'Jīn-tiān', '明天' => 'Míng-tiān', '昨天' => 'Zuó-tiān',
        ];

        if (isset($charMap[$clean])) {
            return $charMap[$clean];
        }

        // Jika multi-karakter yang belum terdaftar di kamus frase
        $len = mb_strlen($clean, 'UTF-8');
        $chars = [];
        for ($i = 0; $i < $len; $i++) {
            $c = mb_substr($clean, $i, 1, 'UTF-8');
            $chars[] = $charMap[$c] ?? $c;
        }

        return implode('-', $chars);
    }

    /**
     * Segmentasi kalimat Mandarin tanpa spasi menjadi token kata bermakna
     */
    private static function segmentChineseCharacters(string $sentence): array
    {
        $clean = trim($sentence);
        $punctuation = "。！？，、：；“”‘’（）,.?!;:";
        
        // Pola kata kunci multi-karakter populer HSK 1-2
        $keywords = [
            '多少钱', '太贵了', '对不起', '没关系', '不客气', '早上好', '晚上好',
            '印尼人', '中国人', '洗手间', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期天',
            '你好', '您好', '谢谢', '再见', '老师', '学生', '朋友', '医生', '中国', '印尼',
            '吃饭', '喝水', '咖啡', '学校', '医院', '饭店', '商店', '车站', '这是', '那是',
            '哪里', '什么', '没有', '喜欢', '现在', '今天', '明天', '昨天', '便宜',
            '我们', '他们', '她们', '我的', '你的', '他的', '还是'
        ];

        $tokens = [];
        $len = mb_strlen($clean, 'UTF-8');
        $i = 0;

        while ($i < $len) {
            $matched = false;
            // Coba cocokkan 4, 3, atau 2 karakter
            for ($kLen = 4; $kLen >= 2; $kLen--) {
                if ($i + $kLen <= $len) {
                    $sub = mb_substr($clean, $i, $kLen, 'UTF-8');
                    if (in_array($sub, $keywords, true)) {
                        $tokens[] = $sub;
                        $i += $kLen;
                        $matched = true;
                        break;
                    }
                }
            }

            if (!$matched) {
                $c = mb_substr($clean, $i, 1, 'UTF-8');
                if (mb_strpos($punctuation, $c) === false && trim($c) !== '') {
                    $tokens[] = $c;
                }
                $i++;
            }
        }

        return !empty($tokens) ? $tokens : [$clean];
    }

    /**
     * Pembagi partikel bahasa Jepang jika kalimat tidak mengandung spasi
     */
    private static function segmentJapaneseParticles(string $sentence): array
    {
        $tokens = preg_split('/(は|を|が|に|で|と|です|ます)/u', $sentence, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        return !empty($tokens) ? $tokens : [$sentence];
    }

    /**
     * Kamus Cepat Makna Token Kata Tunggal Bahasa Indonesia
     */
    private static function findTokenMeaning(string $langCode, string $token, ?string $default = null): string
    {
        $clean = trim($token, " \t\n\r\0\x0B.,?!:;。！？،");

        $dict = [
            'ar' => [
                'أَنَا' => 'Saya', 'أَنْتَ' => 'Kamu (L)', 'أَنْتِ' => 'Kamu (P)',
                'هُوَ' => 'Dia (L)', 'هِيَ' => 'Dia (P)', 'طَالِبٌ' => 'Murid',
                'طَبِيْبٌ' => 'Dokter', 'طَبِيْبَةٌ' => 'Dokter (P)', 'أُسْتَاذٌ' => 'Guru',
                'كِتَابٌ' => 'Buku', 'قَلَمٌ' => 'Pena', 'مَدْرَسَةٌ' => 'Sekolah',
                'بَيْتٌ' => 'Rumah', 'مَاءٌ' => 'Air', 'طَعَامٌ' => 'Makanan',
                'سَيَّارَةٌ' => 'Mobil', 'مَسْجِدٌ' => 'Masjid', 'هَذَا' => 'Ini (L)',
                'هَذِهِ' => 'Ini (P)', 'ذَلِكَ' => 'Itu (L)', 'تِلْكَ' => 'Itu (P)',
                'مِنْ' => 'Dari', 'إِلَى' => 'Ke', 'فِي' => 'Di dalam',
                'عَفْوًا' => 'Permisi/Maaf', 'شُكْرًا' => 'Terima kasih',
                'جَدِيدٌ' => 'Baru', 'قَدِيمٌ' => 'Lama', 'كَبِيرٌ' => 'Besar',
                'صَغِيرٌ' => 'Kecil', 'جَمِيلٌ' => 'Indah/Bagus', 'لَذِيذٌ' => 'Lezat',
            ],
            'ja' => [
                'わたし' => 'Saya', 'あなた' => 'Anda', 'かれ' => 'Dia (L)',
                'かのじょ' => 'Dia (P)', 'がくせい' => 'Mahasiswa', 'せんせい' => 'Guru',
                'ほん' => 'Buku', 'みず' => 'Air', 'ごはん' => 'Nasi/Makan',
                'くるま' => 'Mobil', 'いえ' => 'Rumah', 'がっこう' => 'Sekolah',
                'これ' => 'Ini', 'それ' => 'Itu', 'あれ' => 'Itu (Jauh)',
                'は' => 'Partikel Topik', 'を' => 'Partikel Objek', 'が' => 'Partikel Subjek',
                'に' => 'Di/Ke', 'で' => 'Dengan/Di', 'と' => 'Dan/Bersama',
                'です' => 'Adalah (Sopan)', 'でした' => 'Dahulu adalah',
                'のみます' => 'Minum', 'たべます' => 'Makan', 'よみます' => 'Membaca',
                'いきます' => 'Pergi', 'きます' => 'Datang', 'かえります' => 'Pulang',
                'あたらしい' => 'Baru', 'ふるい' => 'Lama', 'おおきい' => 'Besar',
                'ちいさい' => 'Kecil', 'おいしい' => 'Enak/Lezat',
            ],
            'ko' => [
                '저' => 'Saya (Sopan)', '나' => 'Aku', '너' => 'Kamu',
                '학생' => 'Murid', '선생님' => 'Guru', '의사' => 'Dokter',
                '책' => 'Buku', '물' => 'Air', '밥' => 'Nasi/Makanan',
                '집' => 'Rumah', '학교' => 'Sekolah', '차' => 'Mobil/Teh',
                '이것' => 'Ini', '그것' => 'Itu', '저것' => 'Itu (Jauh)',
                '는' => 'Partikel Topik', '은' => 'Partikel Topik',
                '를' => 'Partikel Objek', '을' => 'Partikel Objek',
                '가' => 'Partikel Subjek', '이' => 'Partikel Subjek',
                '입니다' => 'Adalah (Formal)', '입니까' => 'Apakah adalah?',
                '먹어요' => 'Makan', '마셔요' => 'Minum', '읽어요' => 'Membaca',
                '가요' => 'Pergi', '와요' => 'Datang', '만나요' => 'Bertemu',
                '사람' => 'Orang', '새' => 'Baru/Burung', '좋아요' => 'Bagus/Suka',
            ],
            'zh' => [
                '我' => 'Saya', '你' => 'Kamu', '您' => 'Anda (Sopan)',
                '他' => 'Dia (L)', '她' => 'Dia (P)', '我们' => 'Kami/Kita',
                '他们' => 'Mereka', '人' => 'Orang/Manusia', '老师' => 'Guru',
                '学生' => 'Murid/Siswa', '朋友' => 'Teman', '医生' => 'Dokter',
                '中国' => 'Tiongkok', '印尼' => 'Indonesia', '中国人' => 'Orang Tiongkok',
                '印尼人' => 'Orang Indonesia', '书' => 'Buku', '水' => 'Air',
                '饭' => 'Nasi/Makanan', '吃饭' => 'Makan', '喝水' => 'Minum air',
                '茶' => 'Teh', '咖啡' => 'Kopi', '家' => 'Rumah/Keluarga',
                '学校' => 'Sekolah', '医院' => 'Rumah Sakit', '这' => 'Ini',
                '这是' => 'Ini adalah', '那' => 'Itu', '那是' => 'Itu adalah',
                '哪里' => 'Di mana', '什么' => 'Apa', '多少' => 'Berapa',
                '多少钱' => 'Berapa harga', '太贵了' => 'Terlalu mahal', '便宜' => 'Murah',
                '是' => 'Adalah', '不是' => 'Bukan', '有' => 'Ada/Punya',
                '没有' => 'Tidak ada', '好' => 'Baik/Bagus', '大' => 'Besar',
                '小' => 'Kecil', '多' => 'Banyak', '少' => 'Sedikit',
                '很' => 'Sangat', '太' => 'Terlalu', '不' => 'Tidak/Bukan',
                '想' => 'Ingin', '喜欢' => 'Suka', '去' => 'Pergi',
                '来' => 'Datang', '看' => 'Melihat/Membaca', '吃' => 'Makan',
                '喝' => 'Minum', '说' => 'Bicara', '买' => 'Membeli',
                '吗' => 'Apakah?', '呢' => 'Bagaimana dengan?', '的' => 'Kepunyaan (partikel)',
                '谢谢' => 'Terima kasih', '再见' => 'Sampai jumpa', '不客气' => 'Sama-sama',
                '对不起' => 'Maaf', '没关系' => 'Tidak apa-apa', '早上好' => 'Selamat pagi',
            ]
        ];

        if (isset($dict[$langCode][$clean])) {
            return $dict[$langCode][$clean];
        }

        return $default ?? 'Elemen Kalimat';
    }
}
