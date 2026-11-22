<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\DrillLevel;
use App\Models\UserDrillProgress;
use App\Services\MemoryDrillGeneratorService;
use Illuminate\Http\Request;

class DrillController extends Controller
{
    public function index($level_id)
    {
        $level = Level::with(['language', 'units'])->findOrFail($level_id);

        // Pastikan 100 stage pertanyaan (15 soal per stage) tersedia
        MemoryDrillGeneratorService::ensureDrillStagesForLevel($level, 100, 15);

        $stages = DrillLevel::with('progresses')
            ->where('level_id', $level->id)
            ->orderBy('stage_number')
            ->get();

        $completedCount = $stages->filter(fn($s) => $s->progresses->where('is_completed', true)->isNotEmpty())->count();

        return view('drill.index', compact('level', 'stages', 'completedCount'));
    }

    public function showStage($stage_id)
    {
        $drillLevel = DrillLevel::with(['level.language', 'questions'])->findOrFail($stage_id);

        return view('drill.stage', compact('drillLevel'));
    }

    public function submitStage(Request $request, $stage_id)
    {
        $drillLevel = DrillLevel::with(['level', 'questions'])->findOrFail($stage_id);
        $answers = $request->input('answers', []);
        $totalQuestions = $drillLevel->questions->count();
        $correctCount = 0;
        $evaluations = [];

        foreach ($drillLevel->questions as $q) {
            $userAns = $answers[$q->id] ?? null;
            $isCorrect = $userAns && trim($userAns) === trim($q->correct_answer);
            if ($isCorrect) {
                $correctCount++;
            }
            $evaluations[] = [
                'question' => $q->question_text,
                'prompt' => $q->prompt_script,
                'user_answer' => $userAns,
                'correct_answer' => $q->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $q->explanation,
            ];
        }

        $percentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        $isPassed = $percentage >= $drillLevel->passing_score;

        $stars = 0;
        if ($percentage >= 95) $stars = 3;
        elseif ($percentage >= 85) $stars = 2;
        elseif ($percentage >= 70) $stars = 1;

        if ($isPassed) {
            UserDrillProgress::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'drill_level_id' => $drillLevel->id,
                ],
                [
                    'is_completed' => true,
                    'score' => $percentage,
                    'stars' => $stars,
                    'completed_at' => now(),
                ]
            );
        }

        $nextStage = DrillLevel::where('level_id', $drillLevel->level_id)
            ->where('stage_number', $drillLevel->stage_number + 1)
            ->first();

        return view('drill.result', compact(
            'drillLevel',
            'percentage',
            'correctCount',
            'totalQuestions',
            'isPassed',
            'stars',
            'evaluations',
            'nextStage'
        ));
    }
}
