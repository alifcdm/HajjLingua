<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Level;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\LessonExercise;

class ArabicCurriculumContentSeeder extends Seeder
{
    public function run(): void
    {
        $ar = Language::where('code', 'ar')->first();
        if (!$ar) return;

        $levels = Level::where('language_id', $ar->id)->get()->keyBy('code');

        // ==========================================
        // LEVEL A1: Al-Mubtadi' Al-Adna (Pemula 1)
        // ==========================================
        if (isset($levels['A1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['A1']->id,
                'title' => 'Unit 1: Hijaiyah, Harakat, & Vokal Dasar',
                'sort_order' => 1,
            ], [
                'description' => 'Mengenal huruf hijaiyah, harakat pokok (fathah, kasrah, dhammah, sukun, tasydid), dan vokal panjang.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Harakat Pokok & Bunyi Vokal',
                'sort_order' => 1,
            ], [
                'content_type' => 'alphabet',
                'content_body' => [
                    'summary' => 'Dalam bahasa Arab, huruf konsonan dibunyikan oleh tanda baca harakat: Fathah (A), Kasrah (I), Dhammah (U), Sukun (Mati), dan Tasydid (Dobel).',
                    'tips' => 'Fathah miring di atas huruf (َ ), Kasrah miring di bawah huruf (ِ ), Dhammah seperti huruf waw kecil di atas huruf (ُ ).',
                    'alphabets' => [
                        ['char' => 'بَ', 'name' => 'Ba Fathah', 'phonetic' => 'Ba', 'audio' => 'Ba'],
                        ['char' => 'بِ', 'name' => 'Ba Kasrah', 'phonetic' => 'Bi', 'audio' => 'Bi'],
                        ['char' => 'بُ', 'name' => 'Ba Dhammah', 'phonetic' => 'Bu', 'audio' => 'Bu'],
                        ['char' => 'تَ', 'name' => 'Ta Fathah', 'phonetic' => 'Ta', 'audio' => 'Ta'],
                        ['char' => 'تِ', 'name' => 'Ta Kasrah', 'phonetic' => 'Ti', 'audio' => 'Ti'],
                    ],
                    'vocabularies' => [
                        ['arabic' => 'كِتَابٌ', 'trans' => 'Kitaabun', 'meaning' => 'Buku', 'audio' => 'Kitaabun'],
                        ['arabic' => 'قَلَمٌ', 'trans' => 'Qalamun', 'meaning' => 'Pena', 'audio' => 'Qalamun'],
                        ['arabic' => 'بَابٌ', 'trans' => 'Baabun', 'meaning' => 'Pintu', 'audio' => 'Baabun'],
                    ]
                ],
                'audio_script' => 'Ba, Bi, Bu, Ta, Ti. Kitaabun, Qalamun, Baabun.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Tanda harakat manakah yang menghasilkan bunyi vokal "I" dalam bahasa Arab?',
                'options_json' => ['Kasrah ( ِ )', 'Fathah ( َ )', 'Dhammah ( ُ )', 'Sukun ( ْ )'],
                'correct_answer' => 'Kasrah ( ِ )',
                'explanation' => 'Kasrah terletak di bawah huruf dan menghasilkan bunyi vokal pendek "I".',
                'sort_order' => 1,
            ]);

            $u2 = Unit::firstOrCreate([
                'level_id' => $levels['A1']->id,
                'title' => 'Unit 2: Salam Perkenalan (At-Ta\'aruf) & Kata Ganti Orang',
                'sort_order' => 2,
            ], [
                'description' => 'Mempelajari salam harian, ungkapan perkenalan diri, dan dhamir munfashil dasar.'
            ]);

            $l2 = Lesson::firstOrCreate([
                'unit_id' => $u2->id,
                'title' => 'Pelajaran 2: Dhamir Munfashil (Kata Ganti Orang Tunggal)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Dhamir Munfashil adalah kata ganti orang yang berdiri sendiri (Ana, Anta, Anti, Huwa, Hiya).',
                    'tips' => 'Perhatikan gender: Gunakan "Anta" untuk kamu laki-laki, dan "Anti" untuk kamu perempuan.',
                    'grammar_rules' => [
                        [
                            'title' => 'Kata Ganti Tunggal (Mufrod)',
                            'explanation' => 'Bahasa Arab membedakan kata ganti berdasarkan gender (mudzakkar/muannats).',
                            'formula' => 'Dhamir + Isim (Contoh: أَنَا طَالِبٌ)',
                            'examples' => [
                                ['target' => 'أَنَا طَالِبٌ', 'trans' => 'Ana thaalibun', 'meaning' => 'Saya seorang murid laki-laki', 'audio' => 'Ana thaalibun'],
                                ['target' => 'أَنْتَ أُسْتَاذٌ', 'trans' => 'Anta ustaadzun', 'meaning' => 'Kamu seorang guru laki-laki', 'audio' => 'Anta ustaadzun'],
                                ['target' => 'هِيَ طَبِيْبَةٌ', 'trans' => 'Hiya thabiibatun', 'meaning' => 'Dia seorang dokter perempuan', 'audio' => 'Hiya thabiibatun'],
                            ]
                        ]
                    ],
                    'dialogues' => [
                        ['speaker' => 'Ahmad', 'line' => 'السَّلَامُ عَلَيْكُمْ، مَا اسْمُكَ؟', 'trans' => 'Assalamu\'alaikum, masmuka?', 'meaning' => 'Salam sejahtera, siapa namamu?', 'audio' => 'Assalamu alaikum, masmuka?'],
                        ['speaker' => 'Faisal', 'line' => 'وَعَلَيْكُمُ السَّلَامُ، اِسْمِي فَيْصَل.', 'trans' => 'Wa\'alaikumussalam, ismi Faisal.', 'meaning' => 'Dan salam sejahtera juga, nama saya Faisal.', 'audio' => 'Wa alaikumussalam, ismi Faisal.']
                    ]
                ],
                'audio_script' => 'Assalamu alaikum, masmuka? Wa alaikumussalam, ismi Faisal.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l2->id,
                'question_text' => 'Kata ganti yang tepat untuk "Kamu (Perempuan)" adalah:',
                'options_json' => ['أَنْتِ (Anti)', 'أَنْتَ (Anta)', 'هُوَ (Huwa)', 'هِيَ (Hiya)'],
                'correct_answer' => 'أَنْتِ (Anti)',
                'explanation' => 'Anti (أَنْتِ) dengan kasrah digunakan untuk lawan bicara tunggal perempuan.',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL A2: Al-Mubtadi' Al-A'la (Pemula 2)
        // ==========================================
        if (isset($levels['A2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['A2']->id,
                'title' => 'Unit 1: Kata Tunjuk (Isim Isyarah) & Lingkungan Rumah',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai penggunaan Hadza, Hadzihi (ini) dan Dzalika, Tilka (itu) serta kosakata rumah dan perabot.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Isim Isyarah Dekat dan Jauh',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Isim Isyarah disesuaikan dengan jenis kata benda (Mudzakkar tanpa ta\' marbuthah vs Muannats dengan ta\' marbuthah).',
                    'tips' => 'Benda berakhiran ة (ta marbuthah) seperti مَدْرَسَةٌ (madrasah) menggunakan هَذِهِ (hadzihi) atau تِلْكَ (tilka).',
                    'vocabularies' => [
                        ['arabic' => 'هَذَا بَيْتٌ', 'trans' => 'Hadza baitun', 'meaning' => 'Ini sebuah rumah', 'audio' => 'Hadza baitun'],
                        ['arabic' => 'هَذِهِ غُرْفَةٌ', 'trans' => 'Hadzihi ghurfatun', 'meaning' => 'Ini sebuah kamar', 'audio' => 'Hadzihi ghurfatun'],
                        ['arabic' => 'ذَلِكَ مَسْجِدٌ', 'trans' => 'Dzalika masjidun', 'meaning' => 'Itu sebuah masjid', 'audio' => 'Dzalika masjidun'],
                        ['arabic' => 'تِلْكَ سَيَّارَةٌ', 'trans' => 'Tilka sayyaaratun', 'meaning' => 'Itu sebuah mobil', 'audio' => 'Tilka sayyaaratun'],
                    ]
                ],
                'audio_script' => 'Hadza baitun, Hadzihi ghurfatun, Dzalika masjidun, Tilka sayyaaratun.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Kata tunjuk yang tepat untuk kata "سَاعَةٌ" (Jam tangan / Muannats) adalah:',
                'options_json' => ['هَذِهِ (Hadzihi)', 'هَذَا (Hadza)', 'ذَلِكَ (Dzalika)', 'هُوَ (Huwa)'],
                'correct_answer' => 'هَذِهِ (Hadzihi)',
                'explanation' => 'Sa\'atun memiliki ta marbuthah (ة) sehingga muannats, menggunakan Hadzihi.',
                'sort_order' => 1
            ]);

            $u2 = Unit::firstOrCreate([
                'level_id' => $levels['A2']->id,
                'title' => 'Unit 2: Angka 1-20 & Jam / Waktu',
                'sort_order' => 2,
            ], [
                'description' => 'Mempelajari hitungan angka dasar dan cara menyatakan jam dan waktu dalam bahasa Arab.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u2->id,
                'title' => 'Pelajaran 2: Jam & Rutinitas Harian',
                'sort_order' => 1,
            ], [
                'content_type' => 'vocabulary',
                'content_body' => [
                    'summary' => 'Menyebutkan waktu menggunakan bentuk bilangan bertingkat (As-Saa\'ah al-Waahidah, dsb).',
                    'vocabularies' => [
                        ['arabic' => 'السَّاعَةُ الوَاحِدَةُ', 'trans' => 'As-Saa\'atu al-Waahidah', 'meaning' => 'Pukul Satu', 'audio' => 'As-Saa\'atu al-Waahidah'],
                        ['arabic' => 'السَّاعَةُ الثَّانِيَةُ', 'trans' => 'As-Saa\'atu ats-Tsaaniyah', 'meaning' => 'Pukul Dua', 'audio' => 'As-Saa\'atu ats-Tsaaniyah'],
                        ['arabic' => 'صَبَاحًا', 'trans' => 'Shobaahan', 'meaning' => 'Pagi hari', 'audio' => 'Shobaahan'],
                        ['arabic' => 'مَسَاءً', 'trans' => 'Masaa-an', 'meaning' => 'Sore / Malam hari', 'audio' => 'Masaa-an'],
                    ]
                ],
                'audio_script' => 'As-Saa\'atu al-Waahidah, As-Saa\'atu ats-Tsaaniyah, Shobaahan, Masaa-an.'
            ]);
        }

        // ==========================================
        // LEVEL B1: Al-Mutawassith Al-Adna (Menengah 1)
        // ==========================================
        if (isset($levels['B1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['B1']->id,
                'title' => 'Unit 1: Konjugasi Kata Kerja (Fi\'il Madhi & Mudhari\')',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai perubahan kata kerja lampau dan sedang/akan datang berdasarkan 14 dhamir.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Tasrif Fi\'il Madhi (Bentuk Lampau)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Fi\'il Madhi menunjukkan pekerjaan yang telah selesai. Huruf akhir berubah sesuai subjeknya.',
                    'tips' => 'Kata dasar fi\'il madhi berpatokan pada bentuk Huwa (Dia 1 laki-laki), seperti كَتَبَ (kataba).',
                    'grammar_rules' => [
                        [
                            'title' => 'Pola Tasrif Fi\'il Madhi',
                            'explanation' => 'Tambahkan akhiran (ta sukun, ta dhommah, na, dsb) untuk menandai subjek pelaku.',
                            'formula' => 'كَتَبَ (Huwa) -> كَتَبَتْ (Hiya) -> كَتَبْتَ (Anta) -> كَتَبْتُ (Ana)',
                            'examples' => [
                                ['target' => 'كَتَبْتُ الرِّسَالَةَ أَمْسِ', 'trans' => 'Katabtu ar-risaalah amsi', 'meaning' => 'Saya telah menulis surat kemarin', 'audio' => 'Katabtu ar-risaalah amsi'],
                                ['target' => 'ذَهَبَ عَلِيٌّ إِلَى السُّوْقِ', 'trans' => 'Dzahaba \'Aliyyun ilas suuq', 'meaning' => 'Ali telah pergi ke pasar', 'audio' => 'Dzahaba Aliyyun ilas suuq'],
                            ]
                        ]
                    ]
                ],
                'audio_script' => 'Katabtu ar-risaalah amsi. Dzahaba Aliyyun ilas suuq.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Bentuk fi\'il madhi dari "dzahaba" (pergi) untuk subjek "Saya (Ana)" adalah:',
                'options_json' => ['ذَهَبْتُ (Dzahabtu)', 'ذَهَبْتَ (Dzahabta)', 'ذَهَبَتْ (Dzahabat)', 'ذَهَبْنَا (Dzahabna)'],
                'correct_answer' => 'ذَهَبْتُ (Dzahabtu)',
                'explanation' => 'Akhiran ta dhommah (-tu) menandakan subjek Ana (Saya).',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL B2: Al-Mutawassith Al-A'la (Menengah 2)
        // ==========================================
        if (isset($levels['B2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['B2']->id,
                'title' => 'Unit 1: Membaca Teks Gundul & I\'rab Dasar',
                'sort_order' => 1,
            ], [
                'description' => 'Melatih kemampuan membaca kalimat bahasa Arab tanpa bantuan harakat berdasarkan posisi gramatikal.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Menentukan Harakat Akhir (I\'rab Marfu\' & Manshub)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Teks tanpa harakat dapat dibaca dengan memahami kedudukan kata: Mubtada/Khabar/Fa\'il (Marfu\'), Maf\'ul Bih (Manshub), dan Majrur setelah huruf jar.',
                    'tips' => 'Subjek selalu Marfu (dhammah), Objek selalu Manshub (fathah), setelah huruf jar selalu Majrur (kasrah).',
                    'vocabularies' => [
                        ['arabic' => 'يَقْرَأُ الطَّالِبُ الكِتَابَ فِي المَكْتَبَةِ', 'trans' => 'Yaqra-uth thaalibul kitaaba fil maktabah', 'meaning' => 'Murid itu membaca buku di perpustakaan (Thaalib=Marfu, Kitaab=Manshub, Maktabah=Majrur)', 'audio' => 'Yaqra-uth thaalibul kitaaba fil maktabah'],
                    ]
                ],
                'audio_script' => 'Yaqra-uth thaalibul kitaaba fil maktabah.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Dalam kalimat "يَشْرَبُ الوَلَدُ المَاءَ", harakat akhir kata "المَاءَ" berkedudukan sebagai:',
                'options_json' => ['Maf\'ul Bih (Objek / Manshub dengan Fathah)', 'Fa\'il (Subjek / Marfu\' dengan Dhammah)', 'Mubtada', 'Majrur'],
                'correct_answer' => 'Maf\'ul Bih (Objek / Manshub dengan Fathah)',
                'explanation' => 'Al-Maa-a berkedudukan sebagai objek (yang diminum), wajib manshub berharakat fathah.',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL C1: Al-Mutaqaddim Al-Adna (Lanjutan 1)
        // ==========================================
        if (isset($levels['C1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['C1']->id,
                'title' => 'Unit 1: Nahwu Lanjutan & Analisis Teks Berita',
                'sort_order' => 1,
            ], [
                'description' => 'Mempelajari struktur kalimat kompleks: Bab Haal, Tamyiz, Isim Ghairu Munsharif, dan kosakata jurnalistik.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Haal (Keterangan Keadaan) & Tamyiz',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Haal menjelaskan kondisi pelaku saat melakukan perbuatan (contoh: datang sambil tersenyum). Tamyiz menjelaskan ketidakjelasan zat atau nisbat.',
                    'vocabularies' => [
                        ['arabic' => 'جَاءَ المُعَلِّمُ مُبْتَسِمًا', 'trans' => 'Jaa-al mu\'allimu mubtasiman', 'meaning' => 'Guru itu datang dalam keadaan tersenyum (Mubtasiman = Haal)', 'audio' => 'Jaa-al mu\'allimu mubtasiman'],
                        ['arabic' => 'اشْتَرَيْتُ عِشْرِينَ كِتَابًا', 'trans' => 'Isytaraitu \'isyriina kitaaban', 'meaning' => 'Saya membeli dua puluh buku (Kitaaban = Tamyiz)', 'audio' => 'Isytaraitu isyriina kitaaban'],
                    ]
                ],
                'audio_script' => 'Jaa-al mu\'allimu mubtasiman. Isytaraitu isyriina kitaaban.'
            ]);
        }

        // ==========================================
        // LEVEL C2: Al-Mutaqaddim Al-A'la (Lanjutan 2)
        // ==========================================
        if (isset($levels['C2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['C2']->id,
                'title' => 'Unit 1: Balaghah & Retorika Bahasa Arab Bisnis/Diplomasi',
                'sort_order' => 1,
            ], [
                'description' => 'Memahami keindahan sastra klasik (Tasybih, Majaz, Kinayah) dan etiket negosiasi resmi bertaraf internasional.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Dasar Ilmu Balaghah & Gaya Bahasa Tingkat Tinggi',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Ilmu Balaghah terbagi atas Bayan (metafora/analogi), Ma\'ani (kesesuaian konteks), dan Badi\' (keindahan rima/kata). Sangat penting untuk pidato resmi dan sastra tinggi.',
                    'vocabularies' => [
                        ['arabic' => 'يَسُرُّنَا أَنْ نُعْرِبَ عَنْ بَالِغِ شُكْرِنَا وَتَقْدِيْرِنَا', 'trans' => 'Yasurrunaa an nu\'riba \'an baalighi syukrinaa wa taqdiirinaa', 'meaning' => 'Kami dengan senang hati menyampaikan rasa terima kasih dan penghargaan setinggi-tingginya (Diplomatic Greeting)', 'audio' => 'Yasurrunaa an nu\'riba an baalighi syukrinaa'],
                    ]
                ],
                'audio_script' => 'Yasurrunaa an nu\'riba an baalighi syukrinaa wa taqdiirinaa.'
            ]);
        }
    }
}
