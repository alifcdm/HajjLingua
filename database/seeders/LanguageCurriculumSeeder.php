<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\LanguagePair;
use App\Models\Level;
use App\Models\PlacementTest;
use App\Models\PlacementQuestion;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\LessonExercise;

class LanguageCurriculumSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Languages
        $languages = [
            'id' => Language::create([
                'code' => 'id',
                'name' => 'Bahasa Indonesia',
                'native_name' => 'Bahasa Indonesia',
                'script_type' => 'latin',
                'direction' => 'ltr',
            ]),
            'en' => Language::create([
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'script_type' => 'latin',
                'direction' => 'ltr',
            ]),
            'ar' => Language::create([
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'script_type' => 'arabic',
                'direction' => 'rtl',
            ]),
            'ja' => Language::create([
                'code' => 'ja',
                'name' => 'Japanese',
                'native_name' => '日本語',
                'script_type' => 'kanji_kana',
                'direction' => 'ltr',
            ]),
            'ko' => Language::create([
                'code' => 'ko',
                'name' => 'Korean',
                'native_name' => '한국어',
                'script_type' => 'hangeul',
                'direction' => 'ltr',
            ]),
            'zh' => Language::create([
                'code' => 'zh',
                'name' => 'Chinese Mandarin',
                'native_name' => '中文 (普通话)',
                'script_type' => 'hanzi',
                'direction' => 'ltr',
            ]),
        ];

        // 2. Language Pairs (10 Pairs Sesuai Request)
        $pairsData = [
            ['base' => 'id', 'target' => 'ar', 'name' => 'Bahasa Indonesia → Arabic', 'slug' => 'id-ar'],
            ['base' => 'id', 'target' => 'en', 'name' => 'Bahasa Indonesia → English', 'slug' => 'id-en'],
            ['base' => 'id', 'target' => 'ko', 'name' => 'Bahasa Indonesia → Korean', 'slug' => 'id-ko'],
            ['base' => 'id', 'target' => 'ja', 'name' => 'Bahasa Indonesia → Japanese', 'slug' => 'id-ja'],
            ['base' => 'id', 'target' => 'zh', 'name' => 'Bahasa Indonesia → Chinese Mandarin', 'slug' => 'id-zh'],
            ['base' => 'en', 'target' => 'id', 'name' => 'English → Bahasa Indonesia', 'slug' => 'en-id'],
            ['base' => 'en', 'target' => 'ar', 'name' => 'English → Arabic', 'slug' => 'en-ar'],
            ['base' => 'en', 'target' => 'ja', 'name' => 'English → Japanese', 'slug' => 'en-ja'],
            ['base' => 'en', 'target' => 'ko', 'name' => 'English → Korean', 'slug' => 'en-ko'],
            ['base' => 'en', 'target' => 'zh', 'name' => 'English → Chinese Mandarin', 'slug' => 'en-zh'],
        ];

        $pairs = [];
        foreach ($pairsData as $p) {
            $pairs[$p['slug']] = LanguagePair::create([
                'base_language_id' => $languages[$p['base']]->id,
                'target_language_id' => $languages[$p['target']]->id,
                'name' => $p['name'],
                'slug' => $p['slug'],
                'is_active' => true,
            ]);
        }

        // 3. Levels Structure
        // A. Arabic Levels (3 Tahapan Utama & 6 Level CEFR)
        $arLevels = [
            [
                'code' => 'A1',
                'name' => "Al-Mubtadi' Al-Adna (Pemula 1)",
                'stage' => "Mubtadi' (Ibtida'i)",
                'desc' => "Mengenal huruf hijaiyah, harakat, kosakata dasar, dan salam perkenalan.",
                'order' => 1
            ],
            [
                'code' => 'A2',
                'name' => "Al-Mubtadi' Al-A'la (Pemula 2)",
                'stage' => "Mubtadi' (Ibtida'i)",
                'desc' => "Pola kalimat sederhana, kata benda, kata kerja harian, dan angka dasar.",
                'order' => 2
            ],
            [
                'code' => 'B1',
                'name' => "Al-Mutawassith Al-Adna (Menengah 1)",
                'stage' => "Mutawassith",
                'desc' => "Percakapan sehari-hari, membaca teks berharakat lengkap, dan kalimat tanya-jawab.",
                'order' => 3
            ],
            [
                'code' => 'B2',
                'name' => "Al-Mutawassith Al-A'la (Menengah 2)",
                'stage' => "Mutawassith",
                'desc' => "Membaca dan memahami teks tanpa harakat (teks gundul/kitab kuning) serta menulis paragraf.",
                'order' => 4
            ],
            [
                'code' => 'C1',
                'name' => "Al-Mutaqaddim Al-Adna (Lanjutan 1)",
                'stage' => "Mutaqaddim",
                'desc' => "Diskusi tematik, tata bahasa mendalam (Nahwu & Shorof terapan), dan teks opini ilmiah.",
                'order' => 5
            ],
            [
                'code' => 'C2',
                'name' => "Al-Mutaqaddim Al-A'la (Lanjutan 2)",
                'stage' => "Mutaqaddim",
                'desc' => "Balaghah, sastra Arab klasik, debat akademik, dan komunikasi diplomatik/bisnis internasional.",
                'order' => 6
            ],
        ];

        $levelMap = [];
        foreach ($arLevels as $lvl) {
            $created = Level::create([
                'language_id' => $languages['ar']->id,
                'code' => $lvl['code'],
                'name' => $lvl['name'],
                'stage_category' => $lvl['stage'],
                'description' => $lvl['desc'],
                'sort_order' => $lvl['order'],
            ]);
            $levelMap['ar_' . $lvl['code']] = $created;
        }

        // B. English Levels (CEFR A1-C2)
        $enLevels = [
            ['code' => 'A1', 'name' => 'Breakthrough / Beginner', 'stage' => 'Basic', 'desc' => 'Basic greetings, numbers, family, and simple everyday words.', 'order' => 1],
            ['code' => 'A2', 'name' => 'Waystage / Elementary', 'stage' => 'Elementary', 'desc' => 'Routine tasks, daily communication, asking directions and shopping.', 'order' => 2],
            ['code' => 'B1', 'name' => 'Threshold / Intermediate', 'stage' => 'Intermediate', 'desc' => 'Expressing personal opinions, travel situations, and hobby discussions.', 'order' => 3],
            ['code' => 'B2', 'name' => 'Vantage / Upper Intermediate', 'stage' => 'Upper Intermediate', 'desc' => 'Complex technical and business discussions with native fluency.', 'order' => 4],
            ['code' => 'C1', 'name' => 'Effective Operational Proficiency', 'stage' => 'Advanced', 'desc' => 'Academic writing, implicit meaning analysis, and flexible workplace expression.', 'order' => 5],
            ['code' => 'C2', 'name' => 'Mastery / Proficiency', 'stage' => 'Proficiency', 'desc' => 'Near-native mastery, nuanced subtleties, rhetoric, and publication-ready fluency.', 'order' => 6],
        ];

        foreach ($enLevels as $lvl) {
            $created = Level::create([
                'language_id' => $languages['en']->id,
                'code' => $lvl['code'],
                'name' => $lvl['name'],
                'stage_category' => $lvl['stage'],
                'description' => $lvl['desc'],
                'sort_order' => $lvl['order'],
            ]);
            $levelMap['en_' . $lvl['code']] = $created;
        }

        // C. Japanese Levels (JLPT N5-N1)
        $jaLevels = [
            ['code' => 'N5', 'name' => 'JLPT N5 (Dasar Hiragana & Katakana)', 'stage' => 'Basic', 'desc' => 'Penguasaan 46 Hiragana, 46 Katakana, ~100 Kanji dasar, dan kalimat formal sederhana desu/masu.', 'order' => 1],
            ['code' => 'N4', 'name' => 'JLPT N4 (Percakapan Harian & Kanji Menengah)', 'stage' => 'Elementary', 'desc' => '~300 Kanji, ~1.500 kosakata, percakapan tempo lambat, dan bentuk konjugasi kata kerja.', 'order' => 2],
            ['code' => 'N3', 'name' => 'JLPT N3 (Jembatan Intermediate)', 'stage' => 'Intermediate', 'desc' => '~650 Kanji, memahami artikel koran sederhana, ringkasan informasi, dan pola tata bahasa menengah.', 'order' => 3],
            ['code' => 'N2', 'name' => 'JLPT N2 (Bisnis & Media Sosial)', 'stage' => 'Upper Intermediate', 'desc' => '~1.000 Kanji, percakapan natural penutur asli, artikel opini, dan etiket bisnis Jepang (Keigo).', 'order' => 4],
            ['code' => 'N1', 'name' => 'JLPT N1 (Mahir & Profesional)', 'stage' => 'Advanced', 'desc' => '~2.000 Kanji, teks editorial mendalam, kritik sastra, negosiasi bisnis tingkat tinggi.', 'order' => 5],
        ];

        foreach ($jaLevels as $lvl) {
            $created = Level::create([
                'language_id' => $languages['ja']->id,
                'code' => $lvl['code'],
                'name' => $lvl['name'],
                'stage_category' => $lvl['stage'],
                'description' => $lvl['desc'],
                'sort_order' => $lvl['order'],
            ]);
            $levelMap['ja_' . $lvl['code']] = $created;
        }

        // D. Korean Levels (TOPIK 5 Tahap)
        $koLevels = [
            ['code' => 'Basic', 'name' => 'Hangeul & Frase Dasar', 'stage' => 'Basic', 'desc' => 'Aksara Hangeul (vokal dasar & ganda, konsonan dasar & ganda, batchim) dan salam perkenalan.', 'order' => 1],
            ['code' => 'Beginner', 'name' => 'TOPIK Level 1-2 (Pemula)', 'stage' => 'Beginner', 'desc' => 'Struktur kalimat SOV, partikel 은/는/이/가/을/를, belanja, pesanan makan, dan kalimat aktivitas.', 'order' => 2],
            ['code' => 'Intermediate', 'name' => 'TOPIK Level 3-4 (Menengah)', 'stage' => 'Intermediate', 'desc' => 'Fasilitas publik, etiket sosial Korea, membedakan kalimat formal (하십시오체) dan kasual (해요체).', 'order' => 3],
            ['code' => 'Mid-High', 'name' => 'TOPIK Level 5 (Menengah Tinggi)', 'stage' => 'Upper Intermediate', 'desc' => 'Bahasa profesional di tempat kerja, analisis berita, istilah ekonomi, dan laporan resmi.', 'order' => 4],
            ['code' => 'Advanced', 'name' => 'TOPIK Level 6 (Mahir)', 'stage' => 'Advanced', 'desc' => 'Kefasihan setara penutur asli dalam riset akademik, presentasi bisnis, dan sastra kontemporer.', 'order' => 5],
        ];

        foreach ($koLevels as $lvl) {
            $created = Level::create([
                'language_id' => $languages['ko']->id,
                'code' => $lvl['code'],
                'name' => $lvl['name'],
                'stage_category' => $lvl['stage'],
                'description' => $lvl['desc'],
                'sort_order' => $lvl['order'],
            ]);
            $levelMap['ko_' . $lvl['code']] = $created;
        }

        // E. Chinese Mandarin Levels (Standar HSK 1 s.d. HSK 6)
        $zhLevels = [
            ['code' => 'HSK 1', 'name' => 'HSK 1 (A1 - Pemula Dasar)', 'stage' => 'Basic', 'desc' => '150 kosakata dasar, Pinyin, 4 nada intonasi, salam halo, angka, dan kalimat perkenalan.', 'order' => 1],
            ['code' => 'HSK 2', 'name' => 'HSK 2 (A2 - Pemula Lanjutan)', 'stage' => 'Elementary', 'desc' => '300 kosakata, percakapan harian rutin belanja, menanyakan arah, jam, dan perkenalan keluarga.', 'order' => 2],
            ['code' => 'HSK 3', 'name' => 'HSK 3 (B1 - Menengah Dasar)', 'stage' => 'Intermediate', 'desc' => '600 kosakata, berkomunikasi lancar di tempat kerja, sekolah, wisata dan mampu mengekspresikan opini.', 'order' => 3],
            ['code' => 'HSK 4', 'name' => 'HSK 4 (B2 - Menengah Lanjutan)', 'stage' => 'Upper Intermediate', 'desc' => '1.200 kosakata, berdiskusi topik beragam secara lancar dengan penutur asli dan membaca koran umum.', 'order' => 4],
            ['code' => 'HSK 5', 'name' => 'HSK 5 (C1 - Lanjut Profesional)', 'stage' => 'Advanced', 'desc' => '2.500 kosakata, memahami berita televisi Tiongkok, pidato kerja, dan menulis esai terstruktur.', 'order' => 5],
            ['code' => 'HSK 6', 'name' => 'HSK 6 (C2 - Mahir Setara Penutur Asli)', 'stage' => 'Mastery', 'desc' => '5.000+ kosakata, memahami ekspresi implisit, kritik sastra, negosiasi bisnis dan teks akademik.', 'order' => 6],
        ];

        foreach ($zhLevels as $lvl) {
            $created = Level::create([
                'language_id' => $languages['zh']->id,
                'code' => $lvl['code'],
                'name' => $lvl['name'],
                'stage_category' => $lvl['stage'],
                'description' => $lvl['desc'],
                'sort_order' => $lvl['order'],
            ]);
            $levelMap['zh_' . $lvl['code']] = $created;
        }

        // 4. Sample Placement Test & Questions for Indonesian -> Arabic
        $arTest = PlacementTest::create([
            'language_pair_id' => $pairs['id-ar']->id,
            'title' => 'Tes Penempatan Bahasa Arab (Placement Test)',
            'description' => 'Ikuti tes singkat ini untuk menentukan level kurikulum yang paling cocok dengan kemampuan Anda saat ini.',
            'total_questions' => 5,
        ]);

        $arQuestions = [
            [
                'level' => 'ar_A1',
                'q' => 'Manakah arti salam perkenalan "Selamat Pagi" dalam bahasa Arab yang tepat?',
                'script' => 'صَبَاحُ الخَيْرِ',
                'audio' => 'Sabahu al-khair',
                'options' => ['Sabahu al-khair', 'Masa\'u al-khair', 'Kaifa haluk', 'Ahlan wa sahlan'],
                'answer' => 'Sabahu al-khair',
                'exp' => 'Shobahul khoir (صَبَاحُ الخَيْرِ) adalah ungkapan salam di pagi hari.',
                'order' => 1
            ],
            [
                'level' => 'ar_A1',
                'q' => 'Huruf hijaiyah setelah "Jim (ج)" dan "Ha (ح)" adalah:',
                'script' => 'ج - ح - ...',
                'audio' => 'Kha',
                'options' => ['Kha (خ)', 'Dal (د)', 'Ra (ر)', 'Sin (س)'],
                'answer' => 'Kha (خ)',
                'exp' => 'Urutan abjad hijaiyah adalah Alif, Ba, Ta, Tsa, Jim, Ha, Kha.',
                'order' => 2
            ],
            [
                'level' => 'ar_A2',
                'q' => 'Terjemahkan kalimat ini: "Saya sedang belajar bahasa Arab di perpustakaan":',
                'script' => 'أَنَا أَدْرُسُ اللُّغَةَ العَرَبِيَّةَ فِي المَكْتَبَةِ',
                'audio' => 'Ana adrusu al-lughata al-arabiyyata fi al-maktabah',
                'options' => [
                    'أَنَا أَدْرُسُ اللُّغَةَ العَرَبِيَّةَ فِي المَكْتَبَةِ',
                    'أَنَا أَقْرَأُ الكِتَابَ فِي المَسْجِدِ',
                    'أَنَا أَكْتُبُ الرِّسَالَةَ فِي البَيْتِ',
                    'أَنَا أَسْتَمِعُ إِلَى الأُسْتَاذِ فِي الفَصْلِ'
                ],
                'answer' => 'أَنَا أَدْرُسُ اللُّغَةَ العَرَبِيَّةَ فِي المَكْتَبَةِ',
                'exp' => 'Adrusu = belajar, Al-Maktabah = perpustakaan.',
                'order' => 3
            ],
            [
                'level' => 'ar_B1',
                'q' => 'Dalam kaidah Nahwu, kata yang berposisi sebagai subjek (Fa\'il) memiliki harakat:',
                'script' => 'الفَاعِلُ فِي الجُمْلَةِ الفِعْلِيَّةِ مَرْفُوْعٌ',
                'audio' => 'Al-fa\'ilu fi al-jumlatil fi\'liyyati marfu\'',
                'options' => ['Marfu\' (Dhammah)', 'Manshub (Fathah)', 'Majrur (Kasrah)', 'Majzum (Sukun)'],
                'answer' => 'Marfu\' (Dhammah)',
                'exp' => 'Fa\'il (pelaku pekerjaan) selalu berstatus Marfu\' dengan tanda dasar Dhammah.',
                'order' => 4
            ],
            [
                'level' => 'ar_B2',
                'q' => 'Bacalah teks gundul berikut: (كان المدير مشغولا باجتماع مهم). Makna kata "مشغولا" adalah:',
                'script' => 'كان المدير مشغولا باجتماع مهم',
                'audio' => 'Kana al-mudiiru masyghuulan bi-ijtimaa\'in muhim',
                'options' => ['Sibuk', 'Hadir', 'Marah', 'Terlambat'],
                'answer' => 'Sibuk',
                'exp' => 'Masyghuulan (مشغولاً) bermakna sibuk, berkedudukan sebagai Khobar Kaana (manshub).',
                'order' => 5
            ]
        ];

        foreach ($arQuestions as $aq) {
            PlacementQuestion::create([
                'placement_test_id' => $arTest->id,
                'target_level_id' => $levelMap[$aq['level']]->id,
                'question_text' => $aq['q'],
                'prompt_script' => $aq['script'],
                'audio_text' => $aq['audio'],
                'options_json' => $aq['options'],
                'correct_answer' => $aq['answer'],
                'explanation' => $aq['exp'],
                'sort_order' => $aq['order'],
            ]);
        }

        // 5. Sample Placement Tests for other pairs (EN, JA, KO)
        $enTest = PlacementTest::create([
            'language_pair_id' => $pairs['id-en']->id,
            'title' => 'English Placement Diagnostic Test',
            'description' => 'Assess your English proficiency from A1 to C2 standard.',
            'total_questions' => 4,
        ]);

        $enQuestions = [
            ['q' => 'Choose the correct form: "She _____ to the office every morning."', 'options' => ['goes', 'go', 'going', 'gone'], 'ans' => 'goes', 'level' => 'en_A1', 'order' => 1],
            ['q' => 'If it rains tomorrow, we _____ the outdoor event.', 'options' => ['will cancel', 'cancel', 'cancelled', 'have cancelled'], 'ans' => 'will cancel', 'level' => 'en_A2', 'order' => 2],
            ['q' => 'Despite _____ diligently, he struggled to pass the bar exam.', 'options' => ['studying', 'studied', 'to study', 'study'], 'ans' => 'studying', 'level' => 'en_B1', 'order' => 3],
            ['q' => 'The company\'s fiscal trajectory was characterized by _____ volatility.', 'options' => ['unprecedented', 'unprepared', 'unprescribed', 'unpretended'], 'ans' => 'unprecedented', 'level' => 'en_C1', 'order' => 4],
        ];

        foreach ($enQuestions as $eq) {
            PlacementQuestion::create([
                'placement_test_id' => $enTest->id,
                'target_level_id' => $levelMap[$eq['level']]->id,
                'question_text' => $eq['q'],
                'options_json' => $eq['options'],
                'correct_answer' => $eq['ans'],
                'sort_order' => $eq['order'],
            ]);
        }

        // Japanese Test
        $jaTest = PlacementTest::create([
            'language_pair_id' => $pairs['id-ja']->id,
            'title' => 'Tes Penempatan Bahasa Jepang (JLPT Placement Test)',
            'description' => 'Uji penguasaan Hiragana, Katakana, Kanji, dan tata bahasa N5-N1.',
            'total_questions' => 3,
        ]);

        PlacementQuestion::create([
            'placement_test_id' => $jaTest->id,
            'target_level_id' => $levelMap['ja_N5']->id,
            'question_text' => 'Pilih cara baca hiragana untuk kata "Terima Kasih" (Arigatou):',
            'prompt_script' => 'ありがとう',
            'audio_text' => 'Arigatou gozaimasu',
            'options_json' => ['ありがとう', 'さようなら', 'こんにちは', 'こんばんは'],
            'correct_answer' => 'ありがとう',
            'explanation' => 'Arigatou (ありがとう) bermakna terima kasih.',
            'sort_order' => 1
        ]);

        PlacementQuestion::create([
            'placement_test_id' => $jaTest->id,
            'target_level_id' => $levelMap['ja_N5']->id,
            'question_text' => 'Huruf Katakana untuk suara "Ko-Hii" (Kopi) adalah:',
            'prompt_script' => 'コーヒー',
            'audio_text' => 'Koohii',
            'options_json' => ['コーヒー', 'ケーキ', 'ミルク', 'パン'],
            'correct_answer' => 'コーヒー',
            'explanation' => 'Ko-hii (コーヒー) adalah kata serapan katakana untuk Coffee.',
            'sort_order' => 2
        ]);

        // Korean Test
        $koTest = PlacementTest::create([
            'language_pair_id' => $pairs['id-ko']->id,
            'title' => 'Tes Penempatan Bahasa Korea (TOPIK Placement Test)',
            'description' => 'Uji kemampuan membaca Hangeul dan tata bahasa Korea TOPIK.',
            'total_questions' => 2,
        ]);

        PlacementQuestion::create([
            'placement_test_id' => $koTest->id,
            'target_level_id' => $levelMap['ko_Basic']->id,
            'question_text' => 'Pilihlah tulisan Hangeul yang dibaca "Annyeonghaseyo" (Halo):',
            'prompt_script' => '안녕하세요',
            'audio_text' => 'Annyeonghaseyo',
            'options_json' => ['안녕하세요', '감사합니다', '죄송합니다', '안녕히 계세요'],
            'correct_answer' => '안녕하세요',
            'explanation' => '안녕하세요 (Annyeonghaseyo) adalah salam perkenalan dasar.',
            'sort_order' => 1
        ]);

        // 6. Sample Structured Units & Lessons for Arabic A1
        $unit1 = Unit::create([
            'level_id' => $levelMap['ar_A1']->id,
            'title' => 'Unit 1: Mengenal Aksara Hijaiyah & Vokal Dasar',
            'description' => 'Fondasi dasar membaca dan mengenali huruf hijaiyah serta tanda baca harakat.',
            'sort_order' => 1
        ]);

        $lesson1 = Lesson::create([
            'unit_id' => $unit1->id,
            'title' => 'Pelajaran 1: Huruf Alif sampai Jim & Tanda Harakat',
            'content_type' => 'alphabet',
            'content_body' => [
                'summary' => 'Belajar bentuk dasar huruf awal hijaiyah dan harakat Fathah, Kasrah, Dhammah.',
                'alphabets' => [
                    ['char' => 'ا', 'name' => 'Alif', 'phonetic' => 'A', 'audio' => 'Alif'],
                    ['char' => 'ب', 'name' => 'Ba', 'phonetic' => 'B', 'audio' => 'Ba'],
                    ['char' => 'ت', 'name' => 'Ta', 'phonetic' => 'T', 'audio' => 'Ta'],
                    ['char' => 'ث', 'name' => 'Tsa', 'phonetic' => 'Ts', 'audio' => 'Tsa'],
                    ['char' => 'ج', 'name' => 'Jim', 'phonetic' => 'J', 'audio' => 'Jim'],
                ],
                'vocabularies' => [
                    ['arabic' => 'أَبٌ', 'trans' => 'Abun', 'meaning' => 'Ayah', 'audio' => 'Abun'],
                    ['arabic' => 'أُمٌّ', 'trans' => 'Ummun', 'meaning' => 'Ibu', 'audio' => 'Ummun'],
                    ['arabic' => 'بَيْتٌ', 'trans' => 'Baitun', 'meaning' => 'Rumah', 'audio' => 'Baitun'],
                    ['arabic' => 'تَاجِرٌ', 'trans' => 'Taajirun', 'meaning' => 'Pedagang', 'audio' => 'Taajirun'],
                ]
            ],
            'audio_script' => 'Alif, Ba, Ta, Tsa, Jim. Abun, Ummun, Baitun, Taajirun.',
            'sort_order' => 1
        ]);

        LessonExercise::create([
            'lesson_id' => $lesson1->id,
            'question_text' => 'Manakah kata bahasa Arab yang bermakna "Rumah" (Baitun)?',
            'prompt_script' => 'بَيْتٌ',
            'options_json' => ['بَيْتٌ (Baitun)', 'أَبٌ (Abun)', 'تَاجِرٌ (Taajirun)', 'مَسْجِدٌ (Masjidun)'],
            'correct_answer' => 'بَيْتٌ (Baitun)',
            'explanation' => 'Baitun (بَيْتٌ) berarti rumah.',
            'sort_order' => 1
        ]);

        // Japanese Unit & Lesson
        $jaUnit1 = Unit::create([
            'level_id' => $levelMap['ja_N5']->id,
            'title' => 'Unit 1: Hiragana Baris A, Ka, Sa & Salam Perkenalan',
            'description' => 'Mempelajari aksara dasar Hiragana dan perkenalan diri (Jikoshoukai).',
            'sort_order' => 1
        ]);

        $jaLesson1 = Lesson::create([
            'unit_id' => $jaUnit1->id,
            'title' => 'Pelajaran 1: Hiragana Vokal (あ, い, う, え, お)',
            'content_type' => 'alphabet',
            'content_body' => [
                'summary' => 'Lima vokal utama dasar bahasa Jepang dalam aksara Hiragana.',
                'alphabets' => [
                    ['char' => 'あ', 'romaji' => 'a', 'audio' => 'a'],
                    ['char' => 'い', 'romaji' => 'i', 'audio' => 'i'],
                    ['char' => 'う', 'romaji' => 'u', 'audio' => 'u'],
                    ['char' => 'え', 'romaji' => 'e', 'audio' => 'e'],
                    ['char' => 'お', 'romaji' => 'o', 'audio' => 'o'],
                ],
                'vocabularies' => [
                    ['kanji_kana' => 'あい (愛)', 'romaji' => 'Ai', 'meaning' => 'Cinta', 'audio' => 'Ai'],
                    ['kanji_kana' => 'いえ (家)', 'romaji' => 'Ie', 'meaning' => 'Rumah', 'audio' => 'Ie'],
                    ['kanji_kana' => 'うえ (上)', 'romaji' => 'Ue', 'meaning' => 'Atas', 'audio' => 'Ue'],
                ]
            ],
            'audio_script' => 'a, i, u, e, o. Ai, Ie, Ue.',
            'sort_order' => 1
        ]);

        // Korean Unit & Lesson
        $koUnit1 = Unit::create([
            'level_id' => $levelMap['ko_Basic']->id,
            'title' => 'Unit 1: Vokal & Konsonan Dasar Hangeul',
            'description' => 'Mengenal abjad alfabet bahasa Korea dan cara membentuk suku kata.',
            'sort_order' => 1
        ]);

        Lesson::create([
            'unit_id' => $koUnit1->id,
            'title' => 'Pelajaran 1: Vokal Tunggal (ㅏ, ㅑ, ㅓ, ㅕ, ㅗ, ㅛ, ㅜ, ㅠ, ㅡ, ㅣ)',
            'content_type' => 'alphabet',
            'content_body' => [
                'summary' => '10 vokal dasar Hangeul yang diciptakan oleh Raja Sejong.',
                'alphabets' => [
                    ['char' => 'ㅏ', 'romaja' => 'a', 'audio' => 'a'],
                    ['char' => 'ㅓ', 'romaja' => 'eo', 'audio' => 'eo'],
                    ['char' => 'ㅗ', 'romaja' => 'o', 'audio' => 'o'],
                    ['char' => 'ㅜ', 'romaja' => 'u', 'audio' => 'u'],
                    ['char' => 'ㅣ', 'romaja' => 'i', 'audio' => 'i'],
                ],
                'vocabularies' => [
                    ['hangeul' => '아이', 'romaja' => 'Ai', 'meaning' => 'Anak', 'audio' => 'Ai'],
                    ['hangeul' => '오이', 'romaja' => 'Oi', 'meaning' => 'Mentimun', 'audio' => 'Oi'],
                    ['hangeul' => '우유', 'romaja' => 'Uyu', 'meaning' => 'Susu', 'audio' => 'Uyu'],
                ]
            ],
            'audio_script' => 'a, eo, o, u, i. Ai, Oi, Uyu.',
            'sort_order' => 1
        ]);

        // Chinese Mandarin Placement Test & Questions (id-zh)
        $zhTest = PlacementTest::create([
            'language_pair_id' => $pairs['id-zh']->id,
            'title' => 'Tes Penempatan Bahasa Mandarin (HSK Placement Test)',
            'description' => 'Ikuti tes singkat ini untuk menentukan level HSK yang paling cocok dengan kemampuan Pinyin dan Hanzi Anda saat ini.',
            'total_questions' => 5,
        ]);

        $zhQuestions = [
            [
                'level' => 'zh_HSK 1',
                'q' => 'Manakah arti salam sapaan "你好" (Nǐ hǎo) dalam bahasa Indonesia yang tepat?',
                'script' => '你好',
                'audio' => 'Nǐ hǎo',
                'options' => ['Halo / Apa kabar', 'Terima kasih', 'Selamat tinggal', 'Maaf'],
                'answer' => 'Halo / Apa kabar',
                'exp' => 'Nǐ hǎo (你好) adalah salam umum dasar dalam percakapan bahasa Mandarin.',
                'order' => 1
            ],
            [
                'level' => 'zh_HSK 1',
                'q' => 'Manakah ungkapan rasa terima kasih "Xièxie" dalam karakter Hanzi yang tepat?',
                'script' => '谢谢',
                'audio' => 'Xièxie',
                'options' => ['谢谢 (Xièxie)', '再见 (Zàijiàn)', '对不起 (Duìbuqǐ)', '请 (Qǐng)'],
                'answer' => '谢谢 (Xièxie)',
                'exp' => 'Xièxie (谢谢) bermakna terima kasih.',
                'order' => 2
            ],
            [
                'level' => 'zh_HSK 2',
                'q' => 'Apakah arti dari kalimat "洗手间在哪里？" (Xǐshǒujiān zài nǎlǐ)?',
                'script' => '洗手间在哪里？',
                'audio' => 'Xǐshǒujiān zài nǎlǐ?',
                'options' => ['Toilet berada di mana?', 'Berapa harga buku ini?', 'Siapa nama Anda?', 'Sekarang jam berapa?'],
                'answer' => 'Toilet berada di mana?',
                'exp' => 'Xǐshǒujiān (洗手间) berarti toilet / kamar kecil, dan zài nǎlǐ (在哪里) menanyakan di mana.',
                'order' => 3
            ],
            [
                'level' => 'zh_HSK 2',
                'q' => 'Manakah frase yang tepat untuk menanyakan harga saat berbelanja?',
                'script' => '多少钱',
                'audio' => 'Duōshao qián',
                'options' => ['多少钱 (Duōshao qián)', '太贵了 (Tài guì le)', '便宜一点 (Piányi yīdiǎn)', '不要 (Bù yào)'],
                'answer' => '多少钱 (Duōshao qián)',
                'exp' => 'Duōshao qián (多少钱) digunakan untuk menanyakan berapa harga suatu barang.',
                'order' => 4
            ],
            [
                'level' => 'zh_HSK 3',
                'q' => 'Lengkapi kalimat: "我是印尼人，我____学习汉语。" (Saya orang Indonesia, saya suka belajar bahasa Mandarin)',
                'script' => '喜欢',
                'audio' => 'Xǐhuan',
                'options' => ['喜欢 (Xǐhuan)', '吃 (Chī)', '喝 (Hē)', '去 (Qù)'],
                'answer' => '喜欢 (Xǐhuan)',
                'exp' => 'Xǐhuan (喜欢) bermakna suka atau gemar melakukan suatu aktivitas.',
                'order' => 5
            ]
        ];

        foreach ($zhQuestions as $q) {
            PlacementQuestion::create([
                'placement_test_id' => $zhTest->id,
                'target_level_id' => $levelMap[$q['level']]->id,
                'question_text' => $q['q'],
                'prompt_script' => $q['script'],
                'audio_text' => $q['audio'],
                'options_json' => $q['options'],
                'correct_answer' => $q['answer'],
                'explanation' => $q['exp'],
                'sort_order' => $q['order'],
            ]);
        }

        // Chinese Mandarin Initial Unit & Lesson
        $zhUnit1 = Unit::create([
            'level_id' => $levelMap['zh_HSK 1']->id,
            'title' => 'Unit 1: Pinyin Fonetik, 4 Nada & Salam Dasar',
            'description' => 'Mempelajari sistem pengucapan Pinyin, 4 nada intonasi, dan sapaan halo sehari-hari.',
            'sort_order' => 1
        ]);

        Lesson::create([
            'unit_id' => $zhUnit1->id,
            'title' => 'Pelajaran 1: Inisial Bibir & Ujung Lidah (b, p, m, f, d, t, n, l)',
            'content_type' => 'alphabet',
            'content_body' => [
                'summary' => 'Inisial konsonan dasar Pinyin untuk melafalkan suku kata Mandarin.',
                'alphabets' => [
                    ['char' => 'b', 'pinyin' => 'b', 'audio' => 'b'],
                    ['char' => 'p', 'pinyin' => 'p', 'audio' => 'p'],
                    ['char' => 'm', 'pinyin' => 'm', 'audio' => 'm'],
                    ['char' => 'f', 'pinyin' => 'f', 'audio' => 'f'],
                ],
                'vocabularies' => [
                    ['word' => '爸 (Bà)', 'trans' => 'bà', 'meaning' => 'Ayah', 'audio' => 'bà'],
                    ['word' => '妈 (Mā)', 'trans' => 'mā', 'meaning' => 'Ibu', 'audio' => 'mā'],
                    ['word' => '好 (Hǎo)', 'trans' => 'hǎo', 'meaning' => 'Baik / Bagus', 'audio' => 'hǎo'],
                ]
            ],
            'audio_script' => 'b, p, m, f. Bà, Mā, Hǎo.',
            'sort_order' => 1
        ]);
    }
}
