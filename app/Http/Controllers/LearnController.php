<?php

namespace App\Http\Controllers;

use App\Models\LanguagePair;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\UserLessonProgress;
use App\Services\CurriculumPacingService;
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

        // Pastikan level aktif memiliki minimal 100 materi (20 Jam Pembelajaran)
        if ($selectedLevel && $selectedLevel->units->sum(fn($u) => $u->lessons->count()) < 100) {
            CurriculumPacingService::ensure100CurriculumLessonsForLevel($selectedLevel);
            // Refresh level with loaded relations
            $selectedLevel->load(['units.lessons.progresses']);
        }

        // Ambil 1000++ kosakata yang spesifik sesuai level yang dipilih
        $levelOneVocabs = CurriculumPacingService::getVocabularyBankForLevel(
            $pair->targetLanguage->code,
            $selectedLevel?->code ?? 'A1'
        );
        $totalLessons = $selectedLevel ? $selectedLevel->units->sum(fn($u) => $u->lessons->count()) : 0;
        $totalHours = max(20, round($totalLessons * 12 / 60));

        return view('learn.index', compact('pair', 'levels', 'selectedLevel', 'levelOneVocabs', 'totalLessons', 'totalHours'));
    }

    public function showLesson($id)
    {
        $lesson = Lesson::with(['unit.level.language', 'exercises'])
            ->findOrFail($id);

        $pair = LanguagePair::where('target_language_id', $lesson->unit->level->language_id)
            ->first();

        // Cari pelajaran sebelumnya
        $previousLesson = Lesson::where('unit_id', $lesson->unit_id)
            ->where('sort_order', '<', $lesson->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if (!$previousLesson) {
            $prevUnit = $lesson->unit->level->units()
                ->where('sort_order', '<', $lesson->unit->sort_order)
                ->orderBy('sort_order', 'desc')
                ->first();
            $previousLesson = $prevUnit?->lessons()->orderBy('sort_order', 'desc')->first();
        }

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

        // Pastikan materi memiliki minimal 100 pembelajaran interaktif komunikasi 2 orang atau lebih yang murni autentik
        $body = $lesson->content_body;
        $dialogues = $body['interactive_dialogues'] ?? [];
        $needsRefresh = empty($dialogues) || count($dialogues) < 100;
        if (!$needsRefresh && isset($dialogues[0]['turns'][0]['text']) && str_contains($dialogues[0]['turns'][0]['text'], 'Menyapa Rekan Baru')) {
            $needsRefresh = true;
        }

        if ($needsRefresh) {
            $body['interactive_dialogues'] = \App\Services\InteractiveDialogueService::generate100Dialogues(
                $lesson->unit->level->language->code,
                $body['vocabularies'] ?? [],
                [],
                $lesson->sort_order
            );
            $lesson->content_body = $body;
            $lesson->save();
        }

        return view('learn.lesson', compact('lesson', 'pair', 'nextLesson', 'previousLesson'));
    }

    public function completeLesson(Request $request, $id)
    {
        $lesson = Lesson::with('unit.level')->findOrFail($id);
        $score = (int) $request->input('score', 100);
        $action = $request->input('action', 'next'); // 'next' atau 'stay'

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

        // Cari pelajaran berikutnya dalam unit yang sama atau unit selanjutnya
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

        $nextUrl = $nextLesson 
            ? route('lesson.show', $nextLesson->id) 
            : route('exam.show', $lesson->unit->level_id);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'stay' => ($action === 'stay'),
                'score' => $score,
                'current_url' => route('lesson.show', $lesson->id),
                'next_url' => $nextUrl,
                'is_last' => $nextLesson === null,
                'message' => ($action === 'stay')
                    ? "Hebat! Progres materi '{$lesson->title}' berhasil dicatat. Anda tetap di materi ini."
                    : ($nextLesson 
                        ? "Hebat! Materi {$lesson->title} selesai. Bersiap melanjutkan ke materi berikutnya!"
                        : "Luar biasa! Seluruh materi level ini selesai. Anda diarahkan ke Ujian Kelulusan!")
            ]);
        }

        if ($action === 'stay') {
            return redirect()->route('lesson.show', $lesson->id)
                ->with('success', "Progres materi '{$lesson->title}' tersimpan! Anda tetap berada di materi ini untuk pendalaman.");
        }

        if ($nextLesson) {
            return redirect()->route('lesson.show', $nextLesson->id)
                ->with('success', "Hebat! Materi '{$lesson->title}' selesai. Berlanjut ke materi berikutnya!");
        }

        return redirect()->route('exam.show', $lesson->unit->level_id)
            ->with('success', 'Luar biasa! Seluruh materi level ini tuntas. Bersiap untuk Ujian Sertifikasi!');
    }
}
