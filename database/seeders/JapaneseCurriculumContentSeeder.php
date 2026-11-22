<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Level;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\LessonExercise;

class JapaneseCurriculumContentSeeder extends Seeder
{
    public function run(): void
    {
        $ja = Language::where('code', 'ja')->first();
        if (!$ja) return;

        $levels = Level::where('language_id', $ja->id)->get()->keyBy('code');

        // ==========================================
        // LEVEL N5: JLPT N5 (Dasar Hiragana & Katakana)
        // ==========================================
        if (isset($levels['N5'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['N5']->id,
                'title' => 'Unit 1: Aksara Dasar Hiragana & Katakana',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai 46 huruf Hiragana (kata asli Jepang) dan 46 huruf Katakana (kata serapan asing).'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Hiragana Baris Ka, Sa, Ta, Na',
                'sort_order' => 1,
            ], [
                'content_type' => 'alphabet',
                'content_body' => [
                    'summary' => 'Hiragana adalah aksara fonetik utama yang digunakan untuk partikel, kata kerja, dan kata asli Jepang.',
                    'tips' => 'Perhatikan goresan huruf! Huruf さ (sa) dan き (ki) memiliki garis melengkung di bagian bawah.',
                    'alphabets' => [
                        ['char' => 'か', 'romaji' => 'ka', 'audio' => 'ka'],
                        ['char' => 'さ', 'romaji' => 'sa', 'audio' => 'sa'],
                        ['char' => 'た', 'romaji' => 'ta', 'audio' => 'ta'],
                        ['char' => 'な', 'romaji' => 'na', 'audio' => 'na'],
                        ['char' => 'は', 'romaji' => 'ha', 'audio' => 'ha'],
                    ],
                    'vocabularies' => [
                        ['kanji_kana' => 'ねこ (猫)', 'romaji' => 'Neko', 'meaning' => 'Kucing', 'audio' => 'Neko'],
                        ['kanji_kana' => 'いぬ (犬)', 'romaji' => 'Inu', 'meaning' => 'Anjing', 'audio' => 'Inu'],
                        ['kanji_kana' => 'さかな (魚)', 'romaji' => 'Sakana', 'meaning' => 'Ikan', 'audio' => 'Sakana'],
                    ]
                ],
                'audio_script' => 'ka, sa, ta, na, ha. Neko, Inu, Sakana.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Aksara Hiragana untuk kata "Neko" (Kucing) ditulis sebagai:',
                'options_json' => ['ねこ', 'いぬ', 'さかな', 'とり'],
                'correct_answer' => 'ねこ',
                'explanation' => 'ね (ne) + こ (ko) dibaca Neko yang berarti kucing.',
                'sort_order' => 1
            ]);

            $u2 = Unit::firstOrCreate([
                'level_id' => $levels['N5']->id,
                'title' => 'Unit 2: Partikel Pokok (は, が, を, に, で) & Pola Desu/Masu',
                'sort_order' => 2,
            ], [
                'description' => 'Mempelajari cara menyusun kalimat sederhana dengan partikel subjek, objek, dan tempat.'
            ]);

            $l2 = Lesson::firstOrCreate([
                'unit_id' => $u2->id,
                'title' => 'Pelajaran 2: Partikel Wa (は) & O (を)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Partikel は (dibaca wa) menandai topik pembicaraan. Partikel を (dibaca o) menandai objek langsung.',
                    'tips' => 'Huruf は dibaca "HA" saat di dalam kata, tetapi dibaca "WA" jika berfungsi sebagai partikel tata bahasa.',
                    'grammar_rules' => [
                        [
                            'title' => 'Pola Kalimat Dasar SOV Jepang',
                            'explanation' => 'Bahasa Jepang menggunakan urutan Subjek - Objek - Kata Kerja (Berbeda dengan bahasa Indonesia SVO).',
                            'formula' => '[Subjek] は [Objek] を [Kata Kerja] ます',
                            'examples' => [
                                ['target' => 'わたしはみずをのみます。', 'trans' => 'Watashi wa mizu o nomimasu', 'meaning' => 'Saya minum air', 'audio' => 'Watashi wa mizu o nomimasu'],
                                ['target' => 'たなかさんはほんをよみます。', 'trans' => 'Tanaka-san wa hon o yomimasu', 'meaning' => 'Tuan Tanaka membaca buku', 'audio' => 'Tanaka-san wa hon o yomimasu'],
                            ]
                        ]
                    ]
                ],
                'audio_script' => 'Watashi wa mizu o nomimasu. Tanaka-san wa hon o yomimasu.'
            ]);
        }

        // ==========================================
        // LEVEL N4: JLPT N4 (Percakapan Harian & Te-form)
        // ==========================================
        if (isset($levels['N4'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['N4']->id,
                'title' => 'Unit 1: Konjugasi Bentuk Te (Te-form)',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai Te-form untuk permohonan (~te kudasai), kegiatan berlangsung (~te iru), dan menghubungkan kalimat.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Pola ~te kudasai & ~te imasu',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Te-form adalah salah satu bentuk konjugasi paling penting dalam bahasa Jepang untuk berbagai fungsi.',
                    'tips' => 'Perhatikan kelompok kata kerja: Golongan 1 (Gobi u, tsu, ru -> tte), Golongan 2 (ru -> te), Golongan 3 (kuru -> kite, suru -> shite).',
                    'grammar_rules' => [
                        [
                            'title' => 'Permohonan Sopan & Kegiatan Berlangsung',
                            'explanation' => 'Tambahkan "kudasai" untuk memohon dengan sopan, atau "imasu" untuk aksi yang sedang berjalan.',
                            'formula' => '[Kata Kerja Bentuk-Te] + ください / います',
                            'examples' => [
                                ['target' => 'ちょっとまってください。', 'trans' => 'Chotto matte kudasai', 'meaning' => 'Tolong tunggu sebentar', 'audio' => 'Chotto matte kudasai'],
                                ['target' => 'いまにほんごをべんきょうしています。', 'trans' => 'Ima nihongo o benkyou shite imasu', 'meaning' => 'Sekarang saya sedang belajar bahasa Jepang', 'audio' => 'Ima nihongo o benkyou shite imasu'],
                            ]
                        ]
                    ]
                ],
                'audio_script' => 'Chotto matte kudasai. Ima nihongo o benkyou shite imasu.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Bentuk Te-form dari kata kerja "Matsu" (Menunggu / まちます) adalah:',
                'options_json' => ['まって (Matte)', 'まて (Mate)', 'まちて (Machite)', 'またない (Matanai)'],
                'correct_answer' => 'まって (Matte)',
                'explanation' => 'Kata kerja golongan 1 berakhiran chi/tsu berubah menjadi tte (促音便).',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL N3: JLPT N3 (Jembatan Intermediate)
        // ==========================================
        if (isset($levels['N3'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['N3']->id,
                'title' => 'Unit 1: Bentuk Pasif (Ukemi) & Kausatif (Shieki)',
                'sort_order' => 1,
            ], [
                'description' => 'Mempelajari bentuk kalimat pasif (dikerjai) dan kausatif (menyuruh/membuat orang lain melakukan).'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Bentuk Pasif Ukemi (~rareru / ~reru)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Ukemi digunakan untuk menyatakan kejadian pasif, seringkali digunakan dalam nuansa "merugikan" (Meiwaku Ukemi).',
                    'vocabularies' => [
                        ['kanji_kana' => 'あめにふられました。', 'romaji' => 'Ame ni furaremashita', 'meaning' => 'Saya kehujanan (dirugikan oleh hujan)', 'audio' => 'Ame ni furaremashita'],
                        ['kanji_kana' => 'せんせいにほめられました。', 'romaji' => 'Sensei ni homeraremashita', 'meaning' => 'Saya dipuji oleh guru', 'audio' => 'Sensei ni homeraremashita'],
                    ]
                ],
                'audio_script' => 'Ame ni furaremashita. Sensei ni homeraremashita.'
            ]);
        }

        // ==========================================
        // LEVEL N2: JLPT N2 (Bisnis & Keigo)
        // ==========================================
        if (isset($levels['N2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['N2']->id,
                'title' => 'Unit 1: Etiket Bahasa Hormat Jepang (Keigo)',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai Sonkeigo (menghormati klien/atasan) dan Kenjougo (merendahkan tindakan diri sendiri dalam bisnis).'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Sonkeigo vs Kenjougo dalam Email & Rapat',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Di dunia kerja Jepang, Keigo wajib dikuasai untuk menjaga kesopanan profesional antar perusahaan.',
                    'tips' => 'Jangan pernah menggunakan Sonkeigo untuk aksi diri sendiri atau keluarga sendiri kepada orang luar!',
                    'vocabularies' => [
                        ['kanji_kana' => 'しょうしょうおまちください。', 'romaji' => 'Shoushou omachi kudasai', 'meaning' => 'Mohon tunggu sebentar (Sangat sopan)', 'audio' => 'Shoushou omachi kudasai'],
                        ['kanji_kana' => 'よろしくおねがいもうしあげます。', 'romaji' => 'Yoroshiku onegai moushiagemasu', 'meaning' => 'Dengan penuh rasa hormat mohon kerjasamanya', 'audio' => 'Yoroshiku onegai moushiagemasu'],
                        ['kanji_kana' => 'ごかくにんください。', 'romaji' => 'Gokakunin kudasai', 'meaning' => 'Silakan diperiksa/dikonfirmasi', 'audio' => 'Gokakunin kudasai'],
                    ]
                ],
                'audio_script' => 'Shoushou omachi kudasai. Yoroshiku onegai moushiagemasu.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Bentuk Kenjougo (merendahkan diri) untuk kata "Iku / Kuru" (Pergi/Datang) adalah:',
                'options_json' => ['まいります (Mairimasu)', 'いらっしゃいます (Irasshaimasu)', 'おいでになります (Oide ni narimasu)', 'いかれます (Ikaremasu)'],
                'correct_answer' => 'まいります (Mairimasu)',
                'explanation' => 'Mairimasu adalah bentuk kenjougo untuk menyatakan kedatangan/kepergian diri sendiri kepada atasan/klien.',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL N1: JLPT N1 (Mahir & Profesional)
        // ==========================================
        if (isset($levels['N1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['N1']->id,
                'title' => 'Unit 1: Tata Bahasa Editorial & Negosiasi Tinggi',
                'sort_order' => 1,
            ], [
                'description' => 'Mempelajari pola tata bahasa sastra dan wacana formal abstrak setara penutur asli.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Pola ~ya ina ya & ~de are',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Pola N1 digunakan dalam naskah pidato, buku teks perguruan tinggi, dan laporan ekonomi resmi.',
                    'vocabularies' => [
                        ['kanji_kana' => 'べるがなるやいなや、せいとはきょうしつをとびだした。', 'romaji' => 'Beru ga naru ya ina ya, seito wa kyoushitsu o tobidashita', 'meaning' => 'Begitu bel berbunyi seketika itu juga para murid berhamburan keluar kelas', 'audio' => 'Beru ga naru ya ina ya'],
                    ]
                ],
                'audio_script' => 'Beru ga naru ya ina ya, seito wa kyoushitsu o tobidashita.'
            ]);
        }
    }
}
