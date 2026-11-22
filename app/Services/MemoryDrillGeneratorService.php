<?php

namespace App\Services;

use App\Models\Level;
use App\Models\DrillLevel;
use App\Models\DrillQuestion;
use Illuminate\Support\Facades\DB;

class MemoryDrillGeneratorService
{
    /**
     * Memastikan 100 Stage Memory Drill (masing-masing 15 soal) tersedia untuk suatu level.
     */
    public static function ensureDrillStagesForLevel(Level $level, int $targetStages = 100, int $questionsPerStage = 15): void
    {
        $existingCount = DrillLevel::where('level_id', $level->id)->count();
        if ($existingCount >= $targetStages) {
            return;
        }

        $langCode = $level->language->code;
        $lexiconPool = LinguisticMatrixService::getThematicLexiconPool($langCode, $level->code);

        DB::beginTransaction();
        try {
            for ($stage = $existingCount + 1; $stage <= $targetStages; $stage++) {
                $drillLevel = DrillLevel::create([
                    'level_id' => $level->id,
                    'stage_number' => $stage,
                    'title' => "Stage {$stage}: " . self::getStageThemeTitle($stage),
                    'description' => "Latihan penguat memori intensif stage {$stage} dari 100. Target minimal 80% untuk membuka bintang penuh.",
                    'passing_score' => 80,
                ]);

                // Buat 15 soal untuk stage ini
                self::generateQuestionsForStage($drillLevel, $lexiconPool, $stage, $questionsPerStage, $langCode);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private static function getStageThemeTitle(int $stage): string
    {
        if ($stage <= 15) return "Fondasi Aksara & Kosakata Refleks";
        if ($stage <= 35) return "Penguatan Pola Kalimat & Partikel";
        if ($stage <= 55) return "Ketepatan Konjugasi & Frase Esensial";
        if ($stage <= 75) return "Kecepatan Pemahaman Situasi Nyata";
        if ($stage <= 90) return "Tantangan Kosakata Menengah & Bisnis";
        return "Penguasaan Sempurna & Refleks Alami (Hero Level)";
    }

    private static function generateQuestionsForStage(DrillLevel $drillLevel, array $pool, int $stage, int $count, string $langCode): void
    {
        $poolCount = count($pool);
        if ($poolCount === 0) return;

        for ($i = 1; $i <= $count; $i++) {
            // Rotasi algoritma untuk diversifikasi 1000+ kombinasi
            $itemIndex = ($stage * 7 + $i * 13) % $poolCount;
            $item = $pool[$itemIndex];

            // 3 opsi pengecoh (distractors)
            $distractors = [];
            $offset = 1;
            while (count($distractors) < 3) {
                $distIndex = ($itemIndex + $offset * 5) % $poolCount;
                if ($distIndex !== $itemIndex && !in_array($pool[$distIndex]['meaning'], $distractors)) {
                    $distractors[] = $pool[$distIndex]['meaning'];
                }
                $offset++;
            }

            $options = array_merge([$item['meaning']], $distractors);
            shuffle($options);

            DrillQuestion::create([
                'drill_level_id' => $drillLevel->id,
                'question_text' => "Pilihlah arti bahasa Indonesia yang paling tepat dari kata '{$item['word']}' ({$item['trans']}):",
                'prompt_script' => $item['word'],
                'audio_text' => $item['word'],
                'options_json' => $options,
                'correct_answer' => $item['meaning'],
                'explanation' => "Kata [{$item['word']}] ({$item['trans']}) bermakna '{$item['meaning']}'. Catatan: " . ($item['notes'] ?? 'Pelajari kata ini agar otomatis terekam di memori jangka panjang.'),
                'question_type' => 'vocab',
                'sort_order' => $i,
            ]);
        }
    }
}
