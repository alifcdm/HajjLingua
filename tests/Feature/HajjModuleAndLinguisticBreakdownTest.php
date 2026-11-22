<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\HajjModuleService;
use App\Services\LinguisticBreakdownService;
use Database\Seeders\LanguageCurriculumSeeder;
use Database\Seeders\CurriculumPacingSeeder;
use App\Models\Lesson;
use Tests\TestCase;

class HajjModuleAndLinguisticBreakdownTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageCurriculumSeeder::class);
        $this->seed(CurriculumPacingSeeder::class);
    }

    public function test_hajj_module_page_renders_complete_data(): void
    {
        $response = $this->get('/hajj');
        $response->assertStatus(200);

        // Header & Overview
        $response->assertSee('Manasik Ibadah Haji');
        $response->assertSee('QS. Ali', false);
        $response->assertSee('Al-Hajju', false);

        // Timeline Rangkaian Hari (8-13 Dzulhijjah)
        $response->assertSee('8 Dzulhijjah (Hari Tarwiyah)');
        $response->assertSee('9 Dzulhijjah (Hari Arafah)');
        $response->assertSee('Muzdalifah');
        $response->assertSee('Tawaf Wada');

        // RPH 1448 H / 2027 M & Regulasi
        $response->assertSee('Rencana Perjalanan Haji');
        $response->assertSee('Keputusan Direktur Jenderal Pelayanan Haji');
        $response->assertSee('10 April 2027');

        // Fiqih Petugas Haji Kemenhaj RI
        $response->assertSee('Panduan Petugas Haji');
        $response->assertSee('Niat Bersyarat');

        // Rukun & Wajib
        $response->assertSee('6 Rukun Haji');
        $response->assertSee('6 Wajib Haji');
        $response->assertSee('Haji Tamattu');

        // Doa Manasik
        $response->assertSee('Niat Ihram Haji');
        $response->assertSee('Bacaan Talbiyah Lengkap');
        $response->assertSee('Labbaikallāhumma labbaīk', false);

        // Regulasi Kemenhaj RI & Saudi
        $response->assertSee('Kementerian Haji dan Umrah');
        $response->assertSee('Perpres No. 92 Tahun 2025');
        $response->assertSee('Kartu Pintar Nusuk');
        $response->assertSee('Istitha', false);

        // 4 Macam Fiqih Dam
        $response->assertSee('Ketentuan 4 Macam Fiqih Dam');
        $response->assertSee('Dam Tartib wa Taqdir');
        $response->assertSee('Dam Takhyir wa Taqdir');

        // Section Presensi Petugas PPIH dipastikan terhapus dari Modul Haji
        $response->assertDontSee('Presensi Petugas');
        $response->assertDontSee('Alif Chandramaya');

        // Video & Kuis
        $response->assertSee('Simulasi Visual 3D');
        $response->assertSee('Checklist Kesiapan Manasik');
        $response->assertSee('Kuis Evaluasi Fiqih Haji');
    }

    public function test_linguistic_breakdown_service_segments_sentences_into_syllables_and_meanings(): void
    {
        // 1. Arabic sentence breakdown
        $arBreakdown = LinguisticBreakdownService::getBreakdown('ar', 'أَنَا طَالِبٌ');
        $this->assertNotEmpty($arBreakdown);
        $this->assertEquals('أَنَا', $arBreakdown[0]['token']);
        $this->assertEquals('A-na', $arBreakdown[0]['syllables']);
        $this->assertEquals('Saya', $arBreakdown[0]['meaning']);

        // 2. Japanese sentence breakdown
        $jaBreakdown = LinguisticBreakdownService::getBreakdown('ja', 'わたし は がくせい です');
        $this->assertNotEmpty($jaBreakdown);
        $this->assertEquals('わたし', $jaBreakdown[0]['token']);
        $this->assertEquals('Wa-ta-shi', $jaBreakdown[0]['syllables']);

        // 3. Korean sentence breakdown
        $koBreakdown = LinguisticBreakdownService::getBreakdown('ko', '저는 학생입니다');
        $this->assertNotEmpty($koBreakdown);
        $this->assertEquals('저', $koBreakdown[0]['token']);
        $this->assertEquals('Jeo', $koBreakdown[0]['syllables']);
    }

    public function test_lesson_detail_renders_syllable_and_word_breakdown_chips(): void
    {
        $lesson = Lesson::whereNotNull('content_body->grammar_rules')->first();
        if (!$lesson) {
            $lesson = Lesson::first();
        }

        $this->assertNotNull($lesson);

        $response = $this->get("/lesson/{$lesson->id}");
        $response->assertStatus(200);

        // Cek label bedah suku kata
        $response->assertSee('Bedah Suku Kata');
    }

    public function test_app_layout_contains_hajj_navigation_and_google_voice_engine(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Hajj links
        $response->assertSee('/hajj');
        $response->assertSee('Modul Haji');

        // Web Speech API Voice Engine
        $response->assertSee('findNativeVoice');
        $response->assertSee('speechSynthesis');
    }

    public function test_chinese_mandarin_track_and_alphabet_matrix_render_correctly(): void
    {
        // 1. Home page shows 10 tracks including Chinese Mandarin
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('10 Jalur Pembelajaran Bahasa');
        $response->assertSee('Bahasa Indonesia → Chinese Mandarin');
        $response->assertSee('English → Chinese Mandarin');

        // 2. Chinese alphabet page (Pinyin & 4 Tones)
        $zhAlpha = $this->get('/alphabet/zh');
        $zhAlpha->assertStatus(200);
        $zhAlpha->assertSee('Chinese Mandarin');
        $zhAlpha->assertSee('4 Nada Utama Intonasi Pinyin');
        $zhAlpha->assertSee('23 Inisial Konsonan Pinyin');
        $zhAlpha->assertSee('24 Final Vokal Pinyin');

        // 3. Chinese HSK 1 Learn Page
        $zhLearn = $this->get('/learn/id-zh');
        $zhLearn->assertStatus(200);
        $zhLearn->assertSee('HSK 1');
        $zhLearn->assertSee('20 Jam Kurikulum');
    }

    public function test_lesson_view_speaks_full_sentence_and_renders_multi_turn_dialogues(): void
    {
        $lesson = Lesson::whereNotNull('content_body->dialogues')->first();
        $this->assertNotNull($lesson);

        $dialogues = $lesson->content_body['dialogues'];
        $this->assertGreaterThanOrEqual(2, count($dialogues));

        $response = $this->get("/lesson/{$lesson->id}");
        $response->assertStatus(200);

        // Verify full sentence button title
        $response->assertSee('Dengarkan seluruh kalimat penutur asli');
        $response->assertSee('Dengarkan seluruh kalimat percakapan');
    }
}
