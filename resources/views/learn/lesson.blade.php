@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- Top Navigation -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('learn.index', ['slug' => $pair->slug ?? 'id-ar', 'level' => $lesson->unit->level->code]) }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Silabus Level {{ $lesson->unit->level->code }}
        </a>
        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
            {{ $lesson->unit->title }}
        </span>
    </div>

    <!-- Main Lesson Card -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm mb-8">
        
        <!-- Header -->
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 to-indigo-950 text-white">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 rounded bg-blue-500/20 text-blue-300 text-xs font-bold border border-blue-400/30">
                    {{ strtoupper($lesson->content_type) }}
                </span>
                <span class="text-xs text-slate-400">
                    {{ $lesson->unit->level->language->name }} • Level {{ $lesson->unit->level->code }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                {{ $lesson->title }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl">
                {{ $lesson->content_body['summary'] ?? 'Pelajari materi berikut dengan seksama. Klik tombol audio untuk mendengar pengucapan penutur asli.' }}
            </p>
        </div>

        <div class="p-6 sm:p-8 space-y-10">

            <!-- 1. Pro Tip Box (Duolingo / Volingo Style) -->
            @if(!empty($lesson->content_body['tips']))
                <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200 flex items-start gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900 mb-1">Catatan Penting Pembelajaran</h4>
                        <p class="text-xs sm:text-sm text-amber-800 leading-relaxed">
                            {{ $lesson->content_body['tips'] }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- 2. Alphabets Grid (if available) -->
            @if(!empty($lesson->content_body['alphabets']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="grid" class="w-4 h-4 text-blue-600"></i>
                        <span>Aksara & Pengucapan Huruf</span>
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        @foreach($lesson->content_body['alphabets'] as $alpha)
                            <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-400 hover:shadow-md transition text-center group">
                                <div class="text-3xl font-bold mb-1 text-slate-800 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-4xl' : ($lesson->unit->level->language->code === 'ja' ? 'font-japanese' : 'font-korean') }}">
                                    {{ $alpha['char'] }}
                                </div>
                                <div class="text-xs font-semibold text-slate-500 mb-2">
                                    {{ $alpha['name'] ?? ($alpha['romaji'] ?? ($alpha['romaja'] ?? $alpha['phonetic'])) }}
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($alpha['audio'] ?? $alpha['char']) }}', '{{ $lesson->unit->level->language->code }}')" class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center mx-auto shadow-sm">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 3. Grammar Rules & Patterns (if available) -->
            @if(!empty($lesson->content_body['grammar_rules']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="book" class="w-4 h-4 text-indigo-600"></i>
                        <span>Tata Bahasa & Pola Kalimat (Grammar Notes)</span>
                    </h3>
                    <div class="space-y-4">
                        @foreach($lesson->content_body['grammar_rules'] as $rule)
                            <div class="p-5 rounded-2xl bg-indigo-50/50 border border-indigo-200 shadow-sm">
                                <h4 class="text-sm sm:text-base font-bold text-indigo-950 mb-1.5">{{ $rule['title'] }}</h4>
                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed mb-3">{{ $rule['explanation'] }}</p>

                                @if(!empty($rule['formula']))
                                    <div class="p-3 mb-4 rounded-xl bg-white border border-indigo-200 text-xs font-mono font-bold text-indigo-700 flex items-center gap-2">
                                        <i data-lucide="code" class="w-3.5 h-3.5 text-indigo-500"></i>
                                        <span>Pola: {{ $rule['formula'] }}</span>
                                    </div>
                                @endif

                                @if(!empty($rule['examples']))
                                    <div class="space-y-2.5">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-800">Contoh Penggunaan:</div>
                                        @foreach($rule['examples'] as $examp)
                                            <div class="p-3 rounded-xl bg-white border border-slate-200 flex items-center justify-between">
                                                <div>
                                                    <div class="text-base font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-xl text-right' : '' }}">
                                                        {{ $examp['target'] }}
                                                    </div>
                                                    <div class="text-xs text-indigo-600 font-medium">{{ $examp['trans'] ?? '' }}</div>
                                                    <div class="text-xs text-slate-600 mt-0.5 font-semibold">{{ $examp['meaning'] }}</div>
                                                </div>
                                                <button type="button" onclick="speakText('{{ addslashes($examp['audio'] ?? $examp['target']) }}', '{{ $lesson->unit->level->language->code }}')" class="p-2 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white transition shadow-sm ml-2">
                                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 4. Vocabularies & Phrases (if available) -->
            @if(!empty($lesson->content_body['vocabularies']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i>
                        <span>Kosakata Tematik & Frase Praktis</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($lesson->content_body['vocabularies'] as $voc)
                            <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-400 transition flex items-center justify-between shadow-sm">
                                <div>
                                    <div class="text-xl font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-2xl' : ($lesson->unit->level->language->code === 'ja' ? 'font-japanese' : 'font-korean') }}">
                                        {{ $voc['arabic'] ?? ($voc['kanji_kana'] ?? ($voc['hangeul'] ?? ($voc['word'] ?? ''))) }}
                                    </div>
                                    <div class="text-xs text-blue-600 font-medium">
                                        {{ $voc['trans'] ?? ($voc['romaji'] ?? ($voc['romaja'] ?? '')) }}
                                    </div>
                                    <div class="text-xs text-slate-600 mt-1 font-semibold">
                                        {{ $voc['meaning'] }}
                                    </div>
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($voc['audio'] ?? ($voc['arabic'] ?? ($voc['kanji_kana'] ?? ($voc['hangeul'] ?? ($voc['word'] ?? ''))))) }}', '{{ $lesson->unit->level->language->code }}')" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center flex-shrink-0 shadow-sm ml-3">
                                    <i data-lucide="volume-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 5. Interactive Dialogues (if available) -->
            @if(!empty($lesson->content_body['dialogues']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-emerald-600"></i>
                        <span>Percakapan Kontekstual (Dialogue)</span>
                    </h3>
                    <div class="space-y-3">
                        @foreach($lesson->content_body['dialogues'] as $dia)
                            <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex items-start justify-between">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                        {{ substr($dia['speaker'], 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-[11px] font-bold text-slate-500 uppercase">{{ $dia['speaker'] }}</div>
                                        <div class="text-base font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-xl' : '' }}">
                                            {{ $dia['line'] }}
                                        </div>
                                        <div class="text-xs text-blue-600 font-medium">{{ $dia['trans'] ?? '' }}</div>
                                        <div class="text-xs text-slate-600 mt-0.5">{{ $dia['meaning'] }}</div>
                                    </div>
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($dia['audio'] ?? $dia['line']) }}', '{{ $lesson->unit->level->language->code }}')" class="p-2 rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-sm ml-2">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 6. Interactive Quiz Exercise -->
            @if($lesson->exercises->isNotEmpty())
                <div class="pt-6 border-t border-slate-200">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i>
                        <span>Latihan Evaluasi Pelajaran</span>
                    </h3>

                    @foreach($lesson->exercises as $ex)
                        <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200 mb-4" id="exercise-box-{{ $ex->id }}">
                            <p class="text-sm font-bold text-slate-800 mb-3">{{ $ex->question_text }}</p>
                            @if($ex->prompt_script)
                                <div class="text-2xl font-bold text-slate-900 mb-3 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-3xl' : '' }}">
                                    {{ $ex->prompt_script }}
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                                @foreach($ex->options_json as $opt)
                                    <button type="button" onclick="checkAnswer('{{ $ex->id }}', '{{ addslashes($opt) }}', '{{ addslashes($ex->correct_answer) }}', '{{ addslashes($ex->explanation) }}')" class="exercise-opt-{{ $ex->id }} text-left p-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition">
                                        {{ $opt }}
                                    </button>
                                @endforeach
                            </div>
                            <div id="feedback-{{ $ex->id }}" class="hidden text-xs font-semibold p-2.5 rounded-lg mt-2"></div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- Lesson Completion Footer -->
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs text-slate-500 font-medium">Selesaikan materi untuk mencatat progress capaian Anda.</span>
            
            <form action="{{ route('lesson.complete', $lesson->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs sm:text-sm hover:opacity-95 transition shadow-md flex items-center justify-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>Selesaikan & Lanjutkan</span>
                </button>
            </form>
        </div>

    </div>

</div>

@push('scripts')
<script>
    function checkAnswer(exId, selected, correct, explanation) {
        const feedback = document.getElementById('feedback-' + exId);
        feedback.classList.remove('hidden', 'bg-emerald-100', 'text-emerald-800', 'bg-rose-100', 'text-rose-800');

        if (selected.trim() === correct.trim()) {
            feedback.classList.add('bg-emerald-100', 'text-emerald-800');
            feedback.innerHTML = '<span class="font-bold">✓ Jawaban Benar!</span> ' + (explanation || '');
        } else {
            feedback.classList.add('bg-rose-100', 'text-rose-800');
            feedback.innerHTML = '<span class="font-bold">✗ Belum tepat.</span> Coba lagi atau periksa kembali materi di atas.';
        }
    }
</script>
@endpush
@endsection
