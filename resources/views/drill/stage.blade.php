@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <!-- Top Navigation -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('drill.index', $drillLevel->level_id) }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Peta 100 Stage
        </a>
        <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">
            {{ $drillLevel->level->language->name }} • {{ $drillLevel->title }}
        </span>
    </div>

    <!-- Drill Session Card -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm mb-8">
        
        <!-- Header -->
        <div class="p-6 sm:p-8 bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-800 text-white">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 rounded bg-white/20 text-xs font-black uppercase">
                    Stage {{ $drillLevel->stage_number }} / 100
                </span>
                <span class="text-xs text-blue-100">15 Soal Penguat Memori</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black mb-1">
                {{ $drillLevel->title }}
            </h1>
            <p class="text-xs text-blue-100">
                Pilih jawaban dengan cepat dan tepat. Skor minimal <strong>80%</strong> diperlukan untuk menaklukkan stage ini.
            </p>
        </div>

        <!-- 15 Questions Form -->
        <form action="{{ route('drill.submit', $drillLevel->id) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf

            @foreach($drillLevel->questions as $index => $q)
                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-blue-400 transition">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            Soal {{ $index + 1 }} dari {{ $drillLevel->questions->count() }}
                        </span>
                    </div>

                    <!-- Prompt Character/Word with Audio Button -->
                    @if($q->prompt_script)
                        <div class="my-3 p-4 rounded-xl bg-white border border-slate-200 flex items-center justify-between shadow-sm {{ $drillLevel->level->language->direction === 'rtl' ? 'flex-row-reverse text-right' : '' }}">
                            <span class="text-2xl font-black text-slate-900 tracking-wide {{ $drillLevel->level->language->code === 'ar' ? 'font-arabic text-3xl' : ($drillLevel->level->language->code === 'ja' ? 'font-japanese' : ($drillLevel->level->language->code === 'ko' ? 'font-korean' : '')) }}">
                                {{ $q->prompt_script }}
                            </span>
                            @if($q->audio_text)
                                <button type="button" onclick="speakText('{{ addslashes($q->audio_text) }}', '{{ $drillLevel->level->language->code }}')" class="p-2.5 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm ml-2">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            @endif
                        </div>
                    @endif

                    <p class="text-sm font-bold text-slate-800 mb-3">{{ $q->question_text }}</p>

                    <!-- 4 Multiple Choice Options -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($q->options_json as $opt)
                            <label class="flex items-center p-3 rounded-xl border border-slate-200 bg-white hover:border-blue-500 hover:bg-blue-50/50 cursor-pointer transition">
                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" required class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300 mr-2.5">
                                <span class="text-xs font-semibold text-slate-700">{{ $opt }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('drill.index', $drillLevel->level_id) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                    Keluar Sesi
                </a>
                <button type="submit" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black text-sm hover:opacity-95 transition shadow-lg flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Kirim & Evaluasi Jawaban Stage {{ $drillLevel->stage_number }}</span>
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
