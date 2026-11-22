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

        // Portal Petugas PPIH (Bimtek)
        $response->assertSee('Presensi Petugas');
        $response->assertSee('Alif Chandramaya');
        $response->assertSee('Pendidikan Jasmani');
        $response->assertSee('Kelas Tusi');

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
}
