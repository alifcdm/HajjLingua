@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    <!-- Result Banner -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xl text-center mb-8">
        
        <div class="w-20 h-20 rounded-full {{ $isPassed ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center mx-auto mb-4 shadow-inner">
            <i data-lucide="{{ $isPassed ? 'award' : 'alert-circle' }}" class="w-10 h-10"></i>
        </div>

        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider mb-2 inline-block {{ $isPassed ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
            {{ $isPassed ? 'STAGE BERHASIL DITAKLUKKAN' : 'BELUM MENCAPAI AMBANG 80%' }}
        </span>

        <h1 class="text-3xl font-black text-slate-900 mb-1">
            {{ $drillLevel->title }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mb-6">
            Akurasi Anda: <strong class="text-slate-900 text-base">{{ $percentage }}%</strong> ({{ $correctCount }} dari {{ $totalQuestions }} soal benar).
        </p>

        <!-- Stars Rating -->
        @if($isPassed)
            <div class="text-3xl text-amber-400 mb-6 flex justify-center gap-1.5">
                @for($s = 0; $s < max(1, $stars); $s++)
                    <span>★</span>
                @endfor
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-center gap-3">
            @if($isPassed && $nextStage)
                <a href="{{ route('drill.stage', $nextStage->id) }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs sm:text-sm shadow-md hover:opacity-95 transition flex items-center gap-1.5">
                    <span>Lanjut ke Stage {{ $nextStage->stage_number }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            @endif
            <a href="{{ route('drill.stage', $drillLevel->id) }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs sm:text-sm hover:bg-slate-50 transition">
                Ulangi Stage Ini
            </a>
            <a href="{{ route('drill.index', $drillLevel->level_id) }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs sm:text-sm hover:bg-slate-200 transition">
                Daftar 100 Stage
            </a>
        </div>
    </div>

    <!-- 15 Questions Explanatory Breakdown -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <h3 class="text-base font-black text-slate-900 mb-6 flex items-center gap-2">
            <i data-lucide="list-checks" class="w-5 h-5 text-blue-600"></i>
            <span>Penjelasan & Bedah Jawaban 15 Soal</span>
        </h3>

        <div class="space-y-4">
            @foreach($evaluations as $idx => $ev)
                <div class="p-4 rounded-2xl border {{ $ev['is_correct'] ? 'bg-emerald-50/40 border-emerald-200' : 'bg-rose-50/40 border-rose-200' }}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold {{ $ev['is_correct'] ? 'text-emerald-700' : 'text-rose-700' }}">
                            Soal {{ $idx + 1 }}: {{ $ev['is_correct'] ? '✓ Benar' : '✗ Belum Tepat' }}
                        </span>
                        @if($ev['prompt'])
                            <span class="text-lg font-bold text-slate-900 px-2 py-0.5 rounded bg-white border border-slate-200">
                                {{ $ev['prompt'] }}
                            </span>
                        @endif
                    </div>

                    <div class="text-xs text-slate-700 font-semibold mb-2">
                        Jawaban Anda: <span class="{{ $ev['is_correct'] ? 'text-emerald-700 font-bold' : 'text-rose-600 font-bold line-through' }}">{{ $ev['user_answer'] ?? '(Tidak dijawab)' }}</span>
                        @if(!$ev['is_correct'])
                            • Jawaban Benar: <span class="text-emerald-700 font-bold">{{ $ev['correct_answer'] }}</span>
                        @endif
                    </div>

                    <div class="text-xs text-slate-600 bg-white/80 p-3 rounded-xl border border-slate-200/80 leading-relaxed">
                        <span class="font-bold text-slate-800">Penjelasan Detail:</span> {{ $ev['explanation'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
