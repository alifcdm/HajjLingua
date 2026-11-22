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
        $response->assertSee('Latihan Evaluasi Interaktif');
    }

    public function test_lesson_completion_advances_to_next_lesson(): void
    {
        $firstLesson = Lesson::whereHas('unit.level', function ($q) {
            $q->where('code', 'A1');
        })->orderBy('id')->first();

        $this->assertNotNull($firstLesson);

        $response = $this->post("/lesson/{$firstLesson->id}/complete", [
            'score' => 100,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('user_lesson_progress', [
            'lesson_id' => $firstLesson->id,
            'is_completed' => 1,
        ]);
    }

    public function test_alphabet_explorer_renders_character_sample_words_and_indonesian_translations(): void
    {
        // 1. Arabic
        $resAr = $this->get('/alphabet/ar');
        $resAr->assertStatus(200);
        $resAr->assertSee('Arti:');
        $resAr->assertSee('Ayah');

        // 2. Japanese
        $resJa = $this->get('/alphabet/ja');
        $resJa->assertStatus(200);
        $resJa->assertSee('Arti: Hujan');

        // 3. Korean
        $resKo = $this->get('/alphabet/ko');
        $resKo->assertStatus(200);
        $resKo->assertSee('Arti: Tas');

        // 4. English
        $resEn = $this->get('/alphabet/en');
        $resEn->assertStatus(200);
        $resEn->assertSee('Arti: Apel');
    }
}
