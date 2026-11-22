<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Level;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\LessonExercise;

class EnglishCurriculumContentSeeder extends Seeder
{
    public function run(): void
    {
        $en = Language::where('code', 'en')->first();
        if (!$en) return;

        $levels = Level::where('language_id', $en->id)->get()->keyBy('code');

        // ==========================================
        // LEVEL A1: Breakthrough / Beginner
        // ==========================================
        if (isset($levels['A1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['A1']->id,
                'title' => 'Unit 1: Pronouns, Verb To-Be, & Basic Greetings',
                'sort_order' => 1,
            ], [
                'description' => 'Membangun pondasi kalimat bahasa Inggris: Subject Pronouns (I, You, They, We, He, She, It) dan kata kerja To-Be (am, is, are).'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Verb To-Be (Am, Is, Are) & Perkenalan',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Verb "To-Be" menghubungkan subjek dengan profesi, sifat, atau identitas. I + am, You/We/They + are, He/She/It + is.',
                    'tips' => 'Gunakan kontraksi dalam percakapan santai: I am -> I\'m, She is -> She\'s, They are -> They\'re.',
                    'grammar_rules' => [
                        [
                            'title' => 'Struktur Kalimat Positif, Negatif, & Tanya',
                            'explanation' => 'Tambahkan "not" setelah to-be untuk kalimat negatif. Pindahkan to-be ke depan untuk bertanya.',
                            'formula' => 'Subject + to be + Complement (Noun/Adj)',
                            'examples' => [
                                ['target' => 'I am a software engineer.', 'trans' => '', 'meaning' => 'Saya seorang insinyur perangkat lunak.', 'audio' => 'I am a software engineer.'],
                                ['target' => 'She is very friendly.', 'trans' => '', 'meaning' => 'Dia sangat ramah.', 'audio' => 'She is very friendly.'],
                                ['target' => 'Are they from Indonesia?', 'trans' => '', 'meaning' => 'Apakah mereka dari Indonesia?', 'audio' => 'Are they from Indonesia?'],
                            ]
                        ]
                    ],
                    'vocabularies' => [
                        ['word' => 'Hello / Good morning', 'meaning' => 'Halo / Selamat pagi', 'audio' => 'Good morning'],
                        ['word' => 'Nice to meet you', 'meaning' => 'Senang bertemu dengan Anda', 'audio' => 'Nice to meet you'],
                        ['word' => 'Where are you from?', 'meaning' => 'Dari mana asal Anda?', 'audio' => 'Where are you from?'],
                    ]
                ],
                'audio_script' => 'I am a software engineer. She is very friendly. Nice to meet you.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Choose the correct form: "They _____ excited about the new project."',
                'options_json' => ['are', 'is', 'am', 'be'],
                'correct_answer' => 'are',
                'explanation' => 'Subjek jamak "They" selalu berpasangan dengan to-be "are".',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL A2: Waystage / Elementary
        // ==========================================
        if (isset($levels['A2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['A2']->id,
                'title' => 'Unit 1: Simple Past Tense & Irregular Verbs',
                'sort_order' => 1,
            ], [
                'description' => 'Menceritakan kejadian di masa lampau menggunakan Verb 2 (regular -ed dan irregular verbs) serta time signals (yesterday, last week).'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Regular vs Irregular Verbs di Masa Lampau',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Kalimat lampau menggunakan Verb 2 untuk kalimat positif, dan "did not + Verb 1" untuk kalimat negatif.',
                    'tips' => 'Hati-hati: Dalam kalimat negatif dan tanya, kata kerja selalu kembali ke bentuk dasar Verb 1 karena sudah ada kata bantu "did"!',
                    'vocabularies' => [
                        ['word' => 'went (go)', 'meaning' => 'pergi (lampau)', 'audio' => 'went'],
                        ['word' => 'bought (buy)', 'meaning' => 'membeli (lampau)', 'audio' => 'bought'],
                        ['word' => 'saw (see)', 'meaning' => 'melihat (lampau)', 'audio' => 'saw'],
                    ],
                    'grammar_rules' => [
                        [
                            'title' => 'Pola Simple Past Tense',
                            'explanation' => 'Subject + Verb 2 + Object / Complement.',
                            'formula' => 'S + V2 (Positif) | S + did not + V1 (Negatif)',
                            'examples' => [
                                ['target' => 'We visited the museum yesterday.', 'meaning' => 'Kami mengunjungi museum kemarin.', 'audio' => 'We visited the museum yesterday.'],
                                ['target' => 'I did not receive your email.', 'meaning' => 'Saya tidak menerima email Anda.', 'audio' => 'I did not receive your email.'],
                            ]
                        ]
                    ]
                ],
                'audio_script' => 'We visited the museum yesterday. I did not receive your email.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Pilihlah bentuk kalimat lampau yang benar:',
                'options_json' => [
                    'He went to Singapore last weekend.',
                    'He goed to Singapore last weekend.',
                    'He goes to Singapore last weekend.',
                    'He is go to Singapore last weekend.'
                ],
                'correct_answer' => 'He went to Singapore last weekend.',
                'explanation' => 'Kata kerja lampau tidak beraturan (irregular verb) dari "go" adalah "went".',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL B1: Threshold / Intermediate
        // ==========================================
        if (isset($levels['B1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['B1']->id,
                'title' => 'Unit 1: Present Perfect & Conditionals (Type 1 & 2)',
                'sort_order' => 1,
            ], [
                'description' => 'Mempelajari hubungan masa lalu dengan masa kini (have/has + V3) serta kalimat pengandaian realistis & imajinatif.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Present Perfect (Experience & Unfinished Time)',
                'sort_order' => 1,
            ], [
                'content_type' => 'grammar',
                'content_body' => [
                    'summary' => 'Present Perfect (Subject + have/has + Past Participle) digunakan untuk menyatakan pengalaman hidup tanpa menyebut waktu spesifik.',
                    'vocabularies' => [
                        ['word' => 'Have you ever been to Tokyo?', 'meaning' => 'Pernahkah Anda berkunjung ke Tokyo?', 'audio' => 'Have you ever been to Tokyo?'],
                        ['word' => 'I have lived here for five years.', 'meaning' => 'Saya telah tinggal di sini selama lima tahun.', 'audio' => 'I have lived here for five years.'],
                        ['word' => 'She has already finished the task.', 'meaning' => 'Dia sudah menyelesaikan tugas tersebut.', 'audio' => 'She has already finished the task.'],
                    ]
                ],
                'audio_script' => 'Have you ever been to Tokyo? I have lived here for five years.'
            ]);
        }

        // ==========================================
        // LEVEL B2: Vantage / Upper Intermediate
        // ==========================================
        if (isset($levels['B2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['B2']->id,
                'title' => 'Unit 1: Passive Voice & Professional Business Communication',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai kalimat pasif formal di tempat kerja, penulisan email bisnis berstandar internasional, dan phrasal verbs.'
            ]);

            $l1 = Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Passive Voice in Business Reporting',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Dalam laporan korporat dan berita, kalimat pasif digunakan untuk memberikan fokus pada hasil atau aksi, bukan pada individu pelakunya.',
                    'tips' => 'Formula dasar pasif: to be (sesuai tenses) + Verb 3 (Past Participle).',
                    'vocabularies' => [
                        ['word' => 'The quarterly revenue was increased by 15%.', 'meaning' => 'Pendapatan kuartalan ditingkatkan sebesar 15%.', 'audio' => 'The quarterly revenue was increased by 15%.'],
                        ['word' => 'All stakeholders will be notified accordingly.', 'meaning' => 'Seluruh pemangku kepentingan akan diberitahukan sebagaimana mestinya.', 'audio' => 'All stakeholders will be notified accordingly.'],
                    ]
                ],
                'audio_script' => 'The quarterly revenue was increased by 15%. All stakeholders will be notified accordingly.'
            ]);

            LessonExercise::firstOrCreate([
                'lesson_id' => $l1->id,
                'question_text' => 'Transform into passive voice: "The CEO signed the strategic contract."',
                'options_json' => [
                    'The strategic contract was signed by the CEO.',
                    'The strategic contract is signed by the CEO.',
                    'The strategic contract has signed by the CEO.',
                    'The CEO was signed the strategic contract.'
                ],
                'correct_answer' => 'The strategic contract was signed by the CEO.',
                'explanation' => 'Kalimat lampau aktif berubah menjadi "was/were + V3" dalam pasif.',
                'sort_order' => 1
            ]);
        }

        // ==========================================
        // LEVEL C1: Effective Operational Proficiency
        // ==========================================
        if (isset($levels['C1'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['C1']->id,
                'title' => 'Unit 1: Inversion, Cleft Sentences & Executive Negotiation',
                'sort_order' => 1,
            ], [
                'description' => 'Mempelajari struktur inversi untuk penekanan retorik formal serta negosiasi eksekutif tingkat korporasi.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Inversion with Negative Adverbials',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Inversi (membalik posisi kata kerja bantu sebelum subjek) digunakan ketika kalimat diawali frasa negatif seperti Seldom, Rarely, Never, Scarcely.',
                    'vocabularies' => [
                        ['word' => 'Seldom have we witnessed such remarkable resilience.', 'meaning' => 'Jarang sekali kita menyaksikan ketahanan yang sedemikian luar biasa.', 'audio' => 'Seldom have we witnessed such remarkable resilience.'],
                        ['word' => 'Under no circumstances should client data be compromised.', 'meaning' => 'Dalam kondisi apa pun data klien tidak boleh dikompromikan.', 'audio' => 'Under no circumstances should client data be compromised.'],
                    ]
                ],
                'audio_script' => 'Seldom have we witnessed such remarkable resilience. Under no circumstances should client data be compromised.'
            ]);
        }

        // ==========================================
        // LEVEL C2: Mastery / Native Proficiency
        // ==========================================
        if (isset($levels['C2'])) {
            $u1 = Unit::firstOrCreate([
                'level_id' => $levels['C2']->id,
                'title' => 'Unit 1: Idiomatic Mastery & International Diplomacy',
                'sort_order' => 1,
            ], [
                'description' => 'Menguasai metafora kompleks, diplomasi tingkat tinggi, dan penulisan standar publikasi bergengsi.'
            ]);

            Lesson::firstOrCreate([
                'unit_id' => $u1->id,
                'title' => 'Pelajaran 1: Nuance, Irony & Diplomatic Rhetoric',
                'sort_order' => 1,
            ], [
                'content_type' => 'business',
                'content_body' => [
                    'summary' => 'Pada level C2, pembelajar mampu membedakan nuansa terkecil dari pilihan kata, implikasi tersirat, dan fleksibilitas gaya bahasa tanpa hambatan.',
                    'vocabularies' => [
                        ['word' => 'The ambassador advocated for a multilateral consensus.', 'meaning' => 'Duta besar tersebut memperjuangkan konsensus multilateral.', 'audio' => 'The ambassador advocated for a multilateral consensus.'],
                        ['word' => 'His critique struck a delicate balance between candidness and diplomacy.', 'meaning' => 'Kritiknya mencapai keseimbangan yang halus antara keterusterangan dan diplomasi.', 'audio' => 'His critique struck a delicate balance between candidness and diplomacy.'],
                    ]
                ],
                'audio_script' => 'The ambassador advocated for a multilateral consensus. His critique struck a delicate balance.'
            ]);
        }
    }
}
