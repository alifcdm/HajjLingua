@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- Header Navigation -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-blue-600 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Pilihan Bahasa
        </a>
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
            {{ $pair->name }}
        </span>
    </div>

    <!-- Intro Card -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">
            {{ $test->title ?? 'Tes Penempatan Level' }}
        </h1>
        <p class="text-sm text-slate-600 mb-6">
            {{ $test->description ?? 'Jawab pertanyaan berikut sebaik mungkin untuk mendeteksi level awal belajar Anda.' }}
        </p>

        @if($test && $test->questions->isNotEmpty())
            <form action="{{ route('placement.submit', $pair->slug) }}" method="POST" id="placementForm">
                @csrf

                <div class="space-y-8">
                    @foreach($test->questions as $index => $q)
                        <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-blue-400 transition">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                    Soal {{ $index + 1 }} dari {{ $test->questions->count() }}
                                </span>
                                @if($q->targetLevel)
                                    <span class="text-[11px] font-medium text-slate-500">
                                        Level: {{ $q->targetLevel->code }}
                                    </span>
                                @endif
                            </div>

                            <!-- Script Prompt (if any) -->
                            @if($q->prompt_script)
                                <div class="my-4 p-4 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-between {{ $pair->targetLanguage->direction === 'rtl' ? 'flex-row-reverse text-right' : '' }}">
                                    <span class="text-2xl font-bold tracking-wide {{ $pair->targetLanguage->code === 'ar' ? 'font-arabic text-3xl' : ($pair->targetLanguage->code === 'ja' ? 'font-japanese' : 'font-korean') }}">
                                        {{ $q->prompt_script }}
                                    </span>
                                    @if($q->audio_text)
                                        <button type="button" onclick="speakText('{{ addslashes($q->audio_text) }}', '{{ $pair->targetLanguage->code }}')" class="p-2.5 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm ml-2">
                                            <i data-lucide="volume-2" class="w-5 h-5"></i>
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <p class="text-base font-semibold text-slate-800 mb-4">
                                {{ $q->question_text }}
                            </p>

                            <!-- Options -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($q->options_json as $opt)
                                    <label class="flex items-center p-3.5 rounded-xl border border-slate-200 bg-white hover:border-blue-500 hover:bg-blue-50/50 cursor-pointer transition">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300 mr-3" required>
                                        <span class="text-sm font-medium text-slate-700 {{ $pair->targetLanguage->code === 'ar' && preg_match('/[\x{0600}-\x{06FF}]/u', $opt) ? 'font-arabic text-base' : '' }}">
                                            {{ $opt }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('learn.index', $pair->slug) }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-700 font-semibold text-sm hover:bg-slate-100 transition">
                        Lewati & Mulai Level 1
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:opacity-95 transition shadow-md flex items-center gap-2">
                        <span>Selesaikan & Lihat Rekomendasi Level</span>
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        @else
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                <i data-lucide="book-open" class="w-12 h-12 text-slate-400 mx-auto mb-3"></i>
                <h3 class="text-base font-bold text-slate-800 mb-1">Materi Sedang Disiapkan</h3>
                <p class="text-xs text-slate-500 mb-4">Anda dapat langsung menjelajahi kurikulum berjenjang.</p>
                <a href="{{ route('learn.index', $pair->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold text-xs">
                    Masuk Kurikulum
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
