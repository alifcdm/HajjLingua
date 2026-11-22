<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Level;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\LessonExercise;

class KoreanCurriculumContentSeeder extends Seeder
{
    public function run(): void
    {
        $ko = Language::where('code', 'ko')->first();
        if (!$ko) return;

        $levels = Level::where('language_id', $ko->id)->get()->keyBy('code');

        // ==========================================
        // LEVEL Basic: Hangeul & Frase Dasar
        // ==========================================
        if (isset($levels['Basic'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['Basic']->id,
                'title' => 'Unit 1: Aksara Hangeul & Aturan Batchim',
                'sort_order' => 1,
            ], [
                'description' => 'Mengenal vokal dasar, konsonan dasar, dan konsonan penutup (Batchim) bahasa Korea.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Konsonan Dasar (ㄱ, ㄴ, ㄷ, ㄹ, ㅁ, ㅂ, ㅅ, ㅇ, ㅈ, ㅎ)',
                'sort_order' => 1,
            ], [
                'content_type' => 'alphabet',
                'content_body' => [
                    'summary' => 'Hangeul diciptakan secara ilmiah oleh Raja Sejong pada abad ke-15. Setiap suku kata terdiri dari Konsonan Awal + Vokal (+ Batchim).',
                    'tips' => 'Huruf ㅇ tidak berbunyi jika berada di awal vokal (contoh: 아 dibaca A), tetapi berbunyi "NG" jika berada di bawah sebagai Batchim (contoh: 강 dibaca Gang).',
                    'alphabets' => [
                        ['char' => 'ㄱ', 'romaja' => 'g/k', 'audio' => 'giyeok'],
                        ['char' => 'ㄴ', 'romaja' => 'n', 'audio' => 'nieun'],
                        ['char' => 'ㄷ', 'romaja' => 'd/t', 'audio' => 'digeut'],
                        ['char' => 'ㄹ', 'romaja' => 'r/l', 'audio' => 'rieul'],
                        ['char' => 'ㅁ', 'romaja' => 'm', 'audio' => 'mieum'],
                    ],
                    'vocabularies' => [
                        ['hangeul' => '한국', 'romaja' => 'Hanguk', 'meaning' => 'Korea', 'audio' => 'Hanguk'],
                        ['hangeul' => '사람', 'romaja' => 'Saram', 'meaning' => 'Orang', 'audio' => 'Saram'],
                        ['hangeul' => '물', 'romaja' => 'Mul', 'meaning' => 'Air', 'audio' => 'Mul'],
                    ]
                ],
                'audio_script' => 'giyeok, nieun, digeut, rieul, mieum. Hanguk, Saram, Mul.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Kata "Hanguk" (한국) dalam bahasa Indonesia memiliki arti:',
                'options_json' => ['Korea', 'Jepang', 'Indonesia', 'Orang'],
                'correct_answer' => 'Korea',
                'explanation' => 'Hanguk (한국) bermakna negara Korea.',
                'sort_order' => 1
            ]);

            $u2 = Unit::firstOrCreate([
                'level_id' => $levels['Basic']->id,
                'title' => 'Unit 2: Salam & Perkenalan Diri (자기소개)',
                'sort_order' => 2,
            ], [
                'description' => 'Mempelajari cara menyapa dan memperkenalkan nama serta kebangsaan.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u2->id,
                'title' => 'Pelajaran 2: Pola Kalimat Imnida (입니다)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Akhiran 입니다 (imnida) adalah bentuk kopula formal sopan yang setara dengan to be (adalah).',
                    'grammar_rules' => [
                        [
                            'title' => 'Perkenalan Formal Imnida',
                            'explanation' => 'Gunakan "jeoneun [Nama] imnida" untuk memperkenalkan diri secara sopan.',
                            'formula' => '저는 [Kata Benda]입니다.',
                            'examples' => [
                                ['target' => '저는 인도네시아 사람입니다.', 'trans' => 'Jeoneun Indonesia saram-imnida', 'meaning' => 'Saya adalah orang Indonesia', 'audio' => 'Jeoneun Indonesia saram-imnida'],
                                ['target' => '만나서 반갑습니다.', 'trans' => 'Mannaseo bangapseumnida', 'meaning' => 'Senang bertemu dengan Anda', 'audio' => 'Mannaseo bangapseumnida'],
                            ]
                        ]
                    ]
                ],
                'audio_script' => 'Jeoneun Indonesia saram-imnida. Mannaseo bangapseumnida.'
            ]);
        }

        // ==========================================
        // LEVEL Beginner: TOPIK Level 1-2 (Pemula)
        // ==========================================
        if (isset($levels['Beginner'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['Beginner']->id,
                'title' => 'Unit 1: Partikel Pokok (은/는, 이/가, 을/를) & Bentuk -아요/어요',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai partikel penanda topik, subjek, dan objek dalam struktur kalimat SOV Korea.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Partikel Topik (은/는) vs Objek (을/를)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Gunakan 은 jika berakhiran konsonan (batchim), 는 jika berakhiran vokal. Gunakan 을 untuk objek berakhiran konsonan, 를 untuk objek berakhiran vokal.',
                    'tips' => 'Bentuk informal sopan -아요/어요 digunakan dalam percakapan sehari-hari kepada orang yang sebaya atau dihormati.',
                    'vocabularies' => [
                        ['hangeul' => '밥을 먹어요', 'romaja' => 'Babeul meogeoyo', 'meaning' => 'Makan nasi', 'audio' => 'Babeul meogeoyo'],
                        ['hangeul' => '커피를 마셔요', 'romaja' => 'Keopireul masyeoyo', 'meaning' => 'Minum kopi', 'audio' => 'Keopireul masyeoyo'],
                        ['hangeul' => '책을 읽어요', 'romaja' => 'Chaegeul ilgeoyo', 'meaning' => 'Membaca buku', 'audio' => 'Chaegeul ilgeoyo'],
                    ]
                ],
                'audio_script' => 'Babeul meogeoyo. Keopireul masyeoyo. Chaegeul ilgeoyo.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Partikel objek yang tepat untuk kata "사과" (Apel / berakhiran vokal) adalah:',
                'options_json' => ['를 (Reul)', '을 (Eul)', '은 (Eun)', '이 (I)'],
                'correct_answer' => '를 (Reul)',
                'explanation' => 'Kata Sagwa berakhiran vokal "wa", sehingga partikel objek yang digunakan adalah 를 (reul).',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL Intermediate: TOPIK Level 3-4 (Menengah)
        // ==========================================
        if (isset($levels['Intermediate'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['Intermediate']->id,
                'title' => 'Unit 1: Konjungsi Kalimat Majemuk & Kalimat Tak Langsung',
                'sort_order' => 1,
            ], [
                'description' => 'Mempelajari bentuk kalimat majemuk sebab-akibat (-기 때문에, -(으)니까) dan kutipan tak langsung (-다고 하다).'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Pola Kutipan Tak Langsung (-다고 해요)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => '-다고 하다 digunakan untuk menyampaikan kembali kabar atau perkataan orang lain ("Katanya...")',
                    'vocabularies' => [
                        ['hangeul' => '내일 비가 온다고 해요.', 'romaja' => 'Naeil biga ondago haeyo', 'meaning' => 'Katanya besok akan turun hujan.', 'audio' => 'Naeil biga ondago haeyo'],
                        ['hangeul' => '그 영화가 재미있다고 들었어요.', 'romaja' => 'Geu yeonghwaga jaemiitdago deureosseoyo', 'meaning' => 'Saya dengar film itu sangat seru.', 'audio' => 'Geu yeonghwaga jaemiitdago deureosseoyo'],
                    ]
                ],
                'audio_script' => 'Naeil biga ondago haeyo. Geu yeonghwaga jaemiitdago deureosseoyo.'
            ]);
        }

        // ==========================================
        // LEVEL Mid-High: TOPIK Level 5 (Menengah Tinggi)
        // ==========================================
        if (isset($levels['Mid-High'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['Mid-High']->id,
                'title' => 'Unit 1: Bahasa Formal Perkantoran & Kosakata Hanja',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai bahasa rapat bisnis, penulisan laporan formal, dan kosakata Hanja-eo (serapan karakter Cina).'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Istilah Rapat & Korespondensi Bisnis Korea',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Di korporat Korea, penggunaan terminologi resmi seperti 회의 (rapat), 결재 (persetujuan dokumen), dan 검토 (peninjauan) sangat penting.',
                    'vocabularies' => [
                        ['hangeul' => '보고서를 검토해 주시기 바랍니다.', 'romaja' => 'Bogoseoreul geomtohae jusigi baramnida', 'meaning' => 'Mohon berkenan meninjau dokumen laporan ini.', 'audio' => 'Bogoseoreul geomtohae jusigi baramnida'],
                        ['hangeul' => '회의 일정을 조율하겠습니다.', 'romaja' => 'Hoeui iljeongeul joyulhagetseumnida', 'meaning' => 'Saya akan mengoordinasikan jadwal rapat.', 'audio' => 'Hoeui iljeongeul joyulhagetseumnida'],
                    ]
                ],
                'audio_script' => 'Bogoseoreul geomtohae jusigi baramnida. Hoeui iljeongeul joyulhagetseumnida.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Istilah bisnis Korea untuk "Meninjau / Memeriksa Dokumen Laporan" adalah:',
                'options_json' => ['검토 (Geomto)', '취소 (Chwiso)', '결석 (Gyeolseok)', '출발 (Chulbal)'],
                'correct_answer' => '검토 (Geomto)',
                'explanation' => 'Geomto (검토) berarti meninjau atau mereview secara teliti.',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL Advanced: TOPIK Level 6 (Mahir)
        // ==========================================
        if (isset($levels['Advanced'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['Advanced']->id,
                'title' => 'Unit 1: Argumentasi Akademik & Retorika Diplomasi',
                'sort_order' => 1,
            ], [
                'description' => 'Kefasihan setara penutur asli dalam menganalisis fenomena sosial, artikel ilmiah, dan negosiasi diplomatik.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Struktur Esai & Pola Tata Bahasa Abstrak',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Tingkat tertinggi TOPIK menuntut kemampuan memahami makna implisit, kritik sastra, dan kebijakan publik.',
                    'vocabularies' => [
                        ['hangeul' => '사회적 갈등을 해소하기 위한 다각적인 노력이 필요하다.', 'romaja' => 'Sahoejeok galdeungeul haesohagi wihan dagakjeogin noryeogi piryohada', 'meaning' => 'Dibutuhkan upaya multifaset untuk menyelesaikan konflik sosial.', 'audio' => 'Sahoejeok galdeungeul haesohagi wihan'],
                    ]
                ],
                'audio_script' => 'Sahoejeok galdeungeul haesohagi wihan dagakjeogin noryeogi piryohada.'
            ]);
        }
    }
}
