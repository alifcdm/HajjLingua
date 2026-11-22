<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LanguageCurriculumSeeder;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageCurriculumSeeder::class);
    }

    public function test_homepage_loads_all_eight_language_pairs(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Bahasa Indonesia → Arabic');
        $response->assertSee('Bahasa Indonesia → English');
        $response->assertSee('Bahasa Indonesia → Korean');
        $response->assertSee('Bahasa Indonesia → Japanese');
    }

    public function test_placement_test_page_loads_successfully(): void
    {
        $response = $this->get('/placement/id-ar');

        $response->assertStatus(200);
        $response->assertSee('Tes Penempatan Bahasa Arab');
    }

    public function test_curriculum_roadmap_loads_levels(): void
    {
        $response = $this->get('/learn/id-ar');

        $response->assertStatus(200);
        $response->assertSee('Al-Mubtadi');
    }

    public function test_exam_page_loads_and_submit_certificate(): void
    {
        $level = \App\Models\Level::where('code', 'A1')->first();
        $response = $this->get("/exam/{$level->id}");

        $response->assertStatus(200);
        $response->assertSee('UJIAN AKHIR KELULUSAN RESMI');

        // Submit exam
        $submitResponse = $this->post("/exam/{$level->id}/submit", [
            'recipient_name' => 'Alif Pratama',
            'answers' => [1 => 'Sangat Paham'],
        ]);

        $submitResponse->assertRedirect();
        $this->assertDatabaseHas('certificates', [
            'recipient_name' => 'Alif Pratama',
            'level_id' => $level->id,
        ]);
    }
}
