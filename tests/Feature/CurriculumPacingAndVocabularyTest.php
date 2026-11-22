<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LanguageCurriculumSeeder;
use Database\Seeders\CurriculumPacingSeeder;
use App\Models\Level;
use App\Models\Lesson;
use App\Services\CurriculumPacingService;
use Tests\TestCase;

class CurriculumPacingAndVocabularyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageCurriculumSeeder::class);
        $this->seed(CurriculumPacingSeeder::class);
    }

    public function test_curriculum_pacing_generates_100_lessons_per_level(): void
    {
        $level = Level::where('code', 'A1')->first();
        $this->assertNotNull($level);

        $lessonsCount = Lesson::whereHas('unit', function ($q) use ($level) {
            $q->where('level_id', $level->id);
        })->count();

        // Level A1 has at least 100 lessons
        $this->assertGreaterThanOrEqual(100, $lessonsCount);

        // Access learn page
        $response = $this->get('/learn/id-ar');
        $response->assertStatus(200);
        $response->assertSee('20 Jam Kurikulum');
        $response->assertSee('Target: 20 Jam Pembelajaran Mandiri');
        $response->assertSee('Terjemahan Bahasa Indonesia');
    }

    public function test_level_one_vocabulary_bank_renders_indonesian_translations(): void
    {
        $vocabs = CurriculumPacingService::getLevelOneVocabularyBank('ar');
        $this->assertNotEmpty($vocabs);
        $this->assertArrayHasKey('meaning', $vocabs[0]);
        $this->assertArrayHasKey('daily_usage', $vocabs[0]);

        // Visit learn page
        $response = $this->get('/learn/id-ar');
        $response->assertStatus(200);
        $response->assertSee('Pusat Kosakata Inti Level 1');
        $response->assertSee('Arti Bahasa Indonesia');
        $response->assertSee('Penggunaan Sehari-hari');
    }

    public function test_lesson_detail_page_renders_daily_usage_and_translation(): void
    {
        $lesson = Lesson::whereHas('unit.level', function ($q) {
            $q->where('code', 'A1');
        })->first();

        $this->assertNotNull($lesson);

        $response = $this->get("/lesson/{$lesson->id}");
        $response->assertStatus(200);
        $response->assertSee('Arti Bahasa Indonesia:');
        $response->assertSee('Latihan Evaluasi Pelajaran');
    }
}
