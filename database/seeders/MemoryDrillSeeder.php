<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
use App\Services\MemoryDrillGeneratorService;

class MemoryDrillSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 100 Level Pertanyaan x 15 Soal (1.500 Soal Penguat Memori)
        // untuk level dasar masing-masing bahasa
        $targetLevels = Level::whereIn('code', ['A1', 'N5', 'Basic'])->get();

        foreach ($targetLevels as $level) {
            MemoryDrillGeneratorService::ensureDrillStagesForLevel($level, 100, 15);
        }
    }
}
