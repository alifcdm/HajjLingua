<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
use App\Services\CurriculumPacingService;

class CurriculumPacingSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan Level 1 (Dasar) masing-masing bahasa memiliki 100 materi terstruktur (20 jam silabus)
        $targetLevels = Level::whereIn('code', ['A1', 'N5', 'Basic', 'HSK 1'])->get();

        foreach ($targetLevels as $level) {
            CurriculumPacingService::ensure100CurriculumLessonsForLevel($level);
        }
    }
}
