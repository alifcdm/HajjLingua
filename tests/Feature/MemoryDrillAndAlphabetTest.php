<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LanguageCurriculumSeeder;
use Database\Seeders\MemoryDrillSeeder;
use App\Models\Level;
use App\Models\DrillLevel;
use App\Models\UserDrillProgress;
use Tests\TestCase;

class MemoryDrillAndAlphabetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageCurriculumSeeder::class);
    }

    public function test_alphabet_explorer_renders_all_four_languages(): void
    {
        // 1. Arabic Hijaiyah
        $resAr = $this->get('/alphabet/ar');
        $resAr->assertStatus(200);
        $resAr->assertSee('Tabel 28 Huruf Hijaiyah');
        $resAr->assertSee('Fathah');

        // 2. Japanese Kana
        $resJa = $this->get('/alphabet/ja');
        $resJa->assertStatus(200);
        $resJa->assertSee('46 Huruf Dasar Hiragana');
        $resJa->assertSee('46 Huruf Katakana');

        // 3. Korean Hangeul
        $resKo = $this->get('/alphabet/ko');
        $resKo->assertStatus(200);
        $resKo->assertSee('14 Konsonan Dasar');
        $resKo->assertSee('Batchim');

        // 4. English IPA
        $resEn = $this->get('/alphabet/en');
        $resEn->assertStatus(200);
        $resEn->assertSee('26 English Alphabets');
    }

    public function test_drill_arena_generates_and_renders_100_stages(): void
    {
        $level = Level::where('code', 'A1')->first();
        $this->assertNotNull($level);

        $response = $this->get("/drills/{$level->id}");
        $response->assertStatus(200);
        $response->assertSee('100 Level Penguat Ingatan Memori');
        $response->assertSee('1.500 Soal Intensif');

        // Check that 100 stages exist
        $stagesCount = DrillLevel::where('level_id', $level->id)->count();
        $this->assertEquals(100, $stagesCount);
    }

    public function test_drill_stage_displays_15_questions_with_options(): void
    {
        $level = Level::where('code', 'A1')->first();
        $this->get("/drills/{$level->id}"); // ensures stages generated

        $stage1 = DrillLevel::where('level_id', $level->id)->where('stage_number', 1)->first();
        $this->assertNotNull($stage1);
        $this->assertEquals(15, $stage1->questions()->count());

        $response = $this->get("/drills/stage/{$stage1->id}");
        $response->assertStatus(200);
        $response->assertSee('Stage 1:');
        $response->assertSee('Soal 15');
    }

    public function test_drill_stage_submission_grades_score_and_renders_explanations(): void
    {
        $level = Level::where('code', 'A1')->first();
        $this->get("/drills/{$level->id}");

        $stage1 = DrillLevel::where('level_id', $level->id)->where('stage_number', 1)->with('questions')->first();
        $questions = $stage1->questions;

        // Siapkan jawaban (jawab benar semua 15 soal)
        $answers = [];
        foreach ($questions as $q) {
            $answers[$q->id] = $q->correct_answer;
        }

        $submitResponse = $this->post("/drills/stage/{$stage1->id}/submit", [
            'answers' => $answers,
        ]);

        $submitResponse->assertStatus(200);
        $submitResponse->assertSee('100%');
        $submitResponse->assertSee('STAGE BERHASIL DITAKLUKKAN');
        $submitResponse->assertSee('Penjelasan');
        $submitResponse->assertSee('Bedah Jawaban 15 Soal');

        // Verify DB persistence
        $this->assertDatabaseHas('user_drill_progress', [
            'drill_level_id' => $stage1->id,
            'score' => 100,
            'is_completed' => 1,
            'stars' => 3,
        ]);
    }
}
