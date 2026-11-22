<?php

namespace App\Http\Controllers;

use App\Models\LanguagePair;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\UserLessonProgress;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function index($slug, Request $request)
    {
        $pair = LanguagePair::with(['baseLanguage', 'targetLanguage'])
            ->where('slug', $slug)
            ->firstOrFail();

        $levels = Level::with(['units.lessons.progresses'])
            ->where('language_id', $pair->target_language_id)
            ->orderBy('sort_order')
            ->get();

        $activeLevelCode = $request->query('level', $levels->first()?->code);
        $selectedLevel = $levels->firstWhere('code', $activeLevelCode) ?? $levels->first();

        return view('learn.index', compact('pair', 'levels', 'selectedLevel'));
    }

    public function showLesson($id)
    {
        $lesson = Lesson::with(['unit.level.language', 'exercises'])
            ->findOrFail($id);

        $pair = LanguagePair::where('target_language_id', $lesson->unit->level->language_id)
            ->first();

        // Cari pelajaran berikutnya
        $nextLesson = Lesson::where('unit_id', $lesson->unit_id)
            ->where('sort_order', '>', $lesson->sort_order)
            ->orderBy('sort_order')
            ->first();

        if (!$nextLesson) {
            $nextUnit = $lesson->unit->level->units()
                ->where('sort_order', '>', $lesson->unit->sort_order)
                ->orderBy('sort_order')
                ->first();
            $nextLesson = $nextUnit?->lessons()->orderBy('sort_order')->first();
        }

        return view('learn.lesson', compact('lesson', 'pair', 'nextLesson'));
    }

    public function completeLesson(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $score = (int) $request->input('score', 100);

        UserLessonProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'is_completed' => true,
                'score' => $score,
                'completed_at' => now(),
            ]
        );

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'score' => $score]);
        }

        return back()->with('success', 'Pelajaran berhasil diselesaikan!');
    }
}
