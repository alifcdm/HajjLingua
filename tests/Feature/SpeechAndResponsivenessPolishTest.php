<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LanguageCurriculumSeeder;
use Database\Seeders\CurriculumPacingSeeder;
use Database\Seeders\MemoryDrillSeeder;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\DrillLevel;
use Tests\TestCase;

class SpeechAndResponsivenessPolishTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageCurriculumSeeder::class);
        $this->seed(CurriculumPacingSeeder::class);
        $this->seed(MemoryDrillSeeder::class);
    }

    public function test_home_page_responsive_grid_and_no_duplicate_tags(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();
        // Pastikan tidak ada duplikasi potongan teks
        $this->assertEquals(1, substr_count($content, 'Hijaiyah, teks gundul, nahwu shorof & CEFR A1-C2.'));
        $this->assertStringContainsString('grid-cols-1 sm:grid-cols-2 lg:grid-cols-4', $content);
    }

    public function test_native_speech_engine_is_configured_in_layout(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Verifikasi Web Speech API voice matching engine dengan proteksi anti-English fallback
        $response->assertSee('findNativeVoice');
        $response->assertSee('showAudioToast');
        $response->assertSee('langRules');
    }

    public function test_exercise_questions_include_latin_transliteration_and_indonesian_translation(): void
    {
        $lesson = Lesson::whereHas('unit.level', function ($q) {
            $q->where('code', 'A1');
        })->first();

        $this->assertNotNull($lesson);

        $response = $this->get("/lesson/{$lesson->id}");
        $response->assertStatus(200);
        $response->assertSee('Pelafalan Abjad:');
        $response->assertSee('Latihan Evaluasi Interaktif');
    }

    public function test_drill_stage_renders_transliteration_and_touch_friendly_options(): void
    {
        $drillLevel = DrillLevel::whereHas('level', function ($q) {
            $q->where('code', 'A1');
        })->first();

        $this->assertNotNull($drillLevel);

        $response = $this->get("/drills/stage/{$drillLevel->id}");
        $response->assertStatus(200);
        $response->assertSee('Pelafalan Abjad:');
        $response->assertSee('min-h-[48px]');
        $response->assertSee('Dengarkan pengucapan penutur asli');
    }
}
