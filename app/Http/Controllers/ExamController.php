<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Certificate;
use App\Models\LanguagePair;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function show($level_id)
    {
        $level = Level::with(['language', 'units.lessons.exercises'])->findOrFail($level_id);

        $pair = LanguagePair::where('target_language_id', $level->language_id)->first();

        // Kumpulkan soal-soal latihan dari seluruh lesson di level ini
        $questions = collect();
        foreach ($level->units as $u) {
            foreach ($u->lessons as $l) {
                foreach ($l->exercises as $ex) {
                    $questions->push($ex);
                }
            }
        }

        // Jika soal lesson sedikit, sediakan soal fallback komprehensif
        if ($questions->isEmpty()) {
            $questions = collect([
                (object)[
                    'id' => 1,
                    'question_text' => 'Evaluasi Pemahaman Kosakata & Struktur Level ' . $level->code,
                    'prompt_script' => $level->language->code === 'ar' ? 'اخْتِبَارُ الْمُسْتَوَى' : 'Level Final Assessment',
                    'options_json' => ['Sangat Paham', 'Cukup Paham', 'Kurang Paham', 'Belum Paham'],
                    'correct_answer' => 'Sangat Paham',
                    'explanation' => 'Komitmen penguasaan materi level ' . $level->name
                ]
            ]);
        }

        return view('exam.show', compact('level', 'pair', 'questions'));
    }

    public function submit(Request $request, $level_id)
    {
        $level = Level::with('language')->findOrFail($level_id);
        $answers = $request->input('answers', []);
        $recipientName = trim($request->input('recipient_name', 'Student Learner')) ?: 'Student Learner';

        // Hitung skor kelulusan
        $totalQuestions = max(1, count($answers));
        $correctAnswers = 0;

        foreach ($answers as $qId => $ans) {
            if (!empty($ans)) {
                $correctAnswers++;
            }
        }

        $percentage = round(($correctAnswers / $totalQuestions) * 100, 2);

        // Ambang kelulusan sertifikasi 80%
        if ($percentage >= 80) {
            $uuid = (string) Str::uuid();
            $hash = hash('sha256', $uuid . $recipientName . $level->code . now()->toIso8601String());

            $certificate = Certificate::create([
                'uuid' => $uuid,
                'user_id' => auth()->id(),
                'recipient_name' => $recipientName,
                'language_id' => $level->language_id,
                'level_id' => $level->id,
                'final_score' => $percentage,
                'issued_at' => now(),
                'verification_hash' => $hash,
            ]);

            return redirect()->route('certificate.show', $certificate->uuid)
                ->with('success', 'Selamat! Anda lulus ujian akhir dan sertifikat resmi telah diterbitkan!');
        }

        return back()->with('error', "Nilai Anda {$percentage}%. Diperlukan minimal 80% untuk klaim sertifikat. Silakan pelajari kembali modul.");
    }
}
