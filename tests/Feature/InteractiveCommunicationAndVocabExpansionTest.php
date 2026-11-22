<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LanguageCurriculumSeeder;
use Database\Seeders\CurriculumPacingSeeder;
use App\Models\Level;
use App\Models\Lesson;
use App\Services\CurriculumPacingService;
use Tests\TestCase;

class InteractiveCommunicationAndVocabExpansionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageCurriculumSeeder::class);
        $this->seed(CurriculumPacingSeeder::class);
    }

    public function test_level_has_1000_plus_vocabularies_with_indonesian_translation(): void
    {
        foreach (['ar', 'ja', 'ko', 'en', 'zh'] as $code) {
            $vocabs = CurriculumPacingService::getLevelOneVocabularyBank($code);
            $this->assertGreaterThanOrEqual(1000, count($vocabs), "Failed for language code: {$code}");
            $first = $vocabs[0];
            $this->assertArrayHasKey('word', $first);
            $this->assertArrayHasKey('trans', $first);
            $this->assertArrayHasKey('meaning', $first);
            $this->assertArrayHasKey('daily_usage', $first);
            $this->assertArrayHasKey('example', $first);
            $this->assertArrayHasKey('example_trans', $first);
            $this->assertArrayHasKey('audio', $first);
        }

        // Test learn index view displays 1000++ indicator
        $response = $this->get('/learn/id-ar');
        $response->assertStatus(200);
        $response->assertSee('1000++ Kosakata');
        $response->assertSee('Kosakata Tersedia');
    }

    public function test_lesson_renders_100_interactive_dialogues_with_multi_speakers(): void
    {
        $lesson = Lesson::whereHas('unit.level', function ($q) {
            $q->where('code', 'A1');
        })->first();

        $this->assertNotNull($lesson);

        $response = $this->get("/lesson/{$lesson->id}");
        $response->assertStatus(200);

        // Verify 100 Interactive Communications Header and badges
        $response->assertSee('100 Modul Percakapan Interaktif (Komunikasi 2 Orang atau Lebih)');
        $response->assertSee('100 Skenario Tersedia');
        $response->assertSee('Putar Skenario');

        // Verify database persistence of 100 interactive dialogues
        $fresh = $lesson->fresh();
        $this->assertNotEmpty($fresh->content_body['interactive_dialogues']);
        $this->assertCount(100, $fresh->content_body['interactive_dialogues']);
        $this->assertGreaterThanOrEqual(2, $fresh->content_body['interactive_dialogues'][0]['participant_count']);
    }

    public function test_lesson_navigation_includes_previous_lesson_button(): void
    {
        $lessons = Lesson::whereHas('unit.level', function ($q) {
            $q->where('code', 'A1');
        })->orderBy('id')->take(2)->get();

        $this->assertCount(2, $lessons);
        $firstLesson = $lessons[0];
        $secondLesson = $lessons[1];

        // First lesson has no previous lesson
        $resFirst = $this->get("/lesson/{$firstLesson->id}");
        $resFirst->assertStatus(200);

        // Second lesson must have "Materi Sebelumnya" pointing to first lesson
        $resSecond = $this->get("/lesson/{$secondLesson->id}");
        $resSecond->assertStatus(200);
        $resSecond->assertSee('Materi Sebelumnya');
        $resSecond->assertSee(route('lesson.show', $firstLesson->id));
    }

    public function test_lesson_completion_allows_choice_to_stay_or_advance(): void
    {
        $lesson = Lesson::whereHas('unit.level', function ($q) {
            $q->where('code', 'A1');
        })->first();

        $this->assertNotNull($lesson);

        // 1. Completion with action 'stay' stays on current lesson
        $resStay = $this->post("/lesson/{$lesson->id}/complete", [
            'score' => 100,
            'action' => 'stay',
        ]);
        $resStay->assertRedirect(route('lesson.show', $lesson->id));
        $this->assertDatabaseHas('user_lesson_progress', [
            'lesson_id' => $lesson->id,
            'is_completed' => 1,
        ]);

        // 2. Completion via AJAX with action 'stay' returns JSON stay: true
        $resJsonStay = $this->postJson("/lesson/{$lesson->id}/complete", [
            'score' => 100,
            'action' => 'stay',
        ]);
        $resJsonStay->assertStatus(200);
        $resJsonStay->assertJson([
            'success' => true,
            'stay' => true,
        ]);

        // 3. Completion with action 'next' advances to next lesson
        $resNext = $this->post("/lesson/{$lesson->id}/complete", [
            'score' => 100,
            'action' => 'next',
        ]);
        $resNext->assertRedirect();
        $this->assertNotEquals(route('lesson.show', $lesson->id), $resNext->headers->get('Location'));
    }

    public function test_robust_voice_engine_and_data_attributes(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('playVoice');
        $response->assertSee('playTtsAudioFallback');
        $response->assertSee('translate.google.com/translate_tts');

        $lesson = Lesson::first();
        $resLesson = $this->get("/lesson/{$lesson->id}");
        $resLesson->assertStatus(200);
        $resLesson->assertSee('playVoice(this)');
        $resLesson->assertSee('data-text=');
        $resLesson->assertSee('data-lang=');
    }
}
