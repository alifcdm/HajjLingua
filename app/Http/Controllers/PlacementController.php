<?php

namespace App\Http\Controllers;

use App\Models\LanguagePair;
use App\Models\PlacementTest;
use App\Models\UserPlacementResult;
use App\Models\Level;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function show($slug)
    {
        $pair = LanguagePair::with(['baseLanguage', 'targetLanguage'])
            ->where('slug', $slug)
            ->firstOrFail();

        $test = PlacementTest::with(['questions.targetLevel'])
            ->where('language_pair_id', $pair->id)
            ->first();

        $levels = Level::where('language_id', $pair->target_language_id)
            ->orderBy('sort_order')
            ->get();

        return view('placement.test', compact('pair', 'test', 'levels'));
    }

    public function submit(Request $request, $slug)
    {
        $pair = LanguagePair::where('slug', $slug)->firstOrFail();
        $test = PlacementTest::with('questions.targetLevel')->where('language_pair_id', $pair->id)->firstOrFail();

        $answers = $request->input('answers', []);
        $totalQuestions = $test->questions->count();
        $correctCount = 0;
        $highestPassedLevel = null;

        foreach ($test->questions as $q) {
            $userAns = $answers[$q->id] ?? null;
            if ($userAns && trim($userAns) === trim($q->correct_answer)) {
                $correctCount++;
                if ($q->targetLevel) {
                    $highestPassedLevel = $q->targetLevel;
                }
            }
        }

        $percentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;

        // Tentukan level rekomendasi
        $allLevels = Level::where('language_id', $pair->target_language_id)->orderBy('sort_order')->get();
        if ($percentage < 40) {
            $recommendedLevel = $allLevels->first();
        } elseif ($percentage < 70) {
            $recommendedLevel = $allLevels->skip(1)->first() ?? $allLevels->first();
        } else {
            $recommendedLevel = $highestPassedLevel ?? ($allLevels->skip(2)->first() ?? $allLevels->last());
        }

        $result = UserPlacementResult::create([
            'user_id' => auth()->id(),
            'language_pair_id' => $pair->id,
            'total_score' => $percentage,
            'recommended_level_id' => $recommendedLevel?->id,
        ]);

        return view('placement.result', compact('pair', 'test', 'result', 'recommendedLevel', 'correctCount', 'totalQuestions', 'percentage'));
    }
}
