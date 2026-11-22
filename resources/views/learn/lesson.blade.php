@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8 pb-28 sm:pb-12">

    <!-- Top Navigation -->
    <div class="mb-4 sm:mb-6 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('learn.index', ['slug' => $pair->slug ?? 'id-ar', 'level' => $lesson->unit->level->code]) }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1 transition">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Kembali ke Silabus {{ $lesson->unit->level->code }}</span>
        </a>
        <div class="flex items-center gap-2">
            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                {{ $lesson->unit->title }}
            </span>
            @if($nextLesson)
                <span class="hidden md:inline-flex text-[11px] text-slate-400">
                    Berikutnya: {{ Str::limit($nextLesson->title, 25) }}
                </span>
            @endif
        </div>
    </div>

    <!-- Main Lesson Card -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm mb-8">
        
        <!-- Header -->
        <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white">
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span class="px-2.5 py-0.5 rounded bg-blue-500/20 text-blue-300 text-xs font-bold border border-blue-400/30 uppercase">
                    {{ $lesson->content_type }}
                </span>
                <span class="px-2.5 py-0.5 rounded bg-amber-500/20 text-amber-300 text-xs font-bold border border-amber-400/30">
                    {{ $lesson->content_body['pacing_badge'] ?? '12 Menit • Silabus 20 Jam' }}
                </span>
                <span class="text-xs text-slate-400">
                    {{ $lesson->unit->level->language->name }} • Level {{ $lesson->unit->level->code }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2">
                {{ $lesson->title }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                {{ $lesson->content_body['summary'] ?? 'Pelajari materi berikut dengan seksama. Dengarkan pengucapan audio penutur asli dan kuasai penggunaannya.' }}
            </p>
        </div>

        <div class="p-5 sm:p-8 space-y-8 sm:space-y-10">

            <!-- 1. Pro Tip & Pembelajaran Detail (Duolingo / Volingo Style) -->
            @if(!empty($lesson->content_body['tips']))
                <div class="p-5 rounded-2xl bg-amber-50/80 border border-amber-200/90 flex items-start gap-3.5 shadow-sm">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900 mb-1">Catatan Penting Penggunaan Sehari-hari</h4>
                        <p class="text-xs sm:text-sm text-amber-900 leading-relaxed font-medium">
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
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach($lesson->content_body['alphabets'] as $alpha)
                            <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white hover:border-blue-400 hover:shadow-md transition text-center group">
                                <div class="text-3xl font-bold mb-1 text-slate-800 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-4xl' : ($lesson->unit->level->language->code === 'ja' ? 'font-japanese' : 'font-korean') }}">
                                    {{ $alpha['char'] }}
                                </div>
                                <div class="text-xs font-semibold text-slate-500 mb-2">
                                    {{ $alpha['name'] ?? ($alpha['romaji'] ?? ($alpha['romaja'] ?? $alpha['phonetic'])) }}
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($alpha['audio'] ?? $alpha['char']) }}', '{{ $lesson->unit->level->language->code }}')" class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center mx-auto shadow-sm">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 3. Vocabularies with Indonesian Translations & Daily Context -->
            @if(!empty($lesson->content_body['vocabularies']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-4 h-4 text-blue-600"></i>
                        <span>Kosakata Tematik & Terjemahan Bahasa Indonesia</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($lesson->content_body['vocabularies'] as $voc)
                            <div class="p-5 rounded-2xl border border-slate-200 bg-white hover:border-blue-400 hover:shadow-md transition flex flex-col justify-between shadow-sm">
                                <div>
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="text-2xl font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-3xl' : ($lesson->unit->level->language->code === 'ja' ? 'font-japanese' : 'font-korean') }}">
                                            {{ $voc['arabic'] ?? ($voc['kanji_kana'] ?? ($voc['hangeul'] ?? ($voc['word'] ?? ''))) }}
                                        </div>
                                        <button type="button" onclick="speakText('{{ addslashes($voc['audio'] ?? ($voc['arabic'] ?? ($voc['kanji_kana'] ?? ($voc['hangeul'] ?? ($voc['word'] ?? ''))))) }}', '{{ $lesson->unit->level->language->code }}')" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center flex-shrink-0 shadow-sm ml-2">
                                            <i data-lucide="volume-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <div class="text-xs text-blue-600 font-semibold mb-2">
                                        {{ $voc['trans'] ?? ($voc['romaji'] ?? ($voc['romaja'] ?? '')) }}
                                    </div>
                                    
                                    <!-- Terjemahan Bahasa Indonesia Resmi -->
                                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 mb-3">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Arti Bahasa Indonesia:</div>
                                        <div class="text-sm font-bold text-slate-900 mt-0.5">
                                            {{ $voc['meaning'] }}
                                        </div>
                                    </div>

                                    @if(!empty($voc['daily_usage']))
                                        <div class="text-xs text-slate-600 leading-relaxed mb-3">
                                            <span class="font-bold text-slate-700">Detail Penggunaan Sehari-hari:</span>
                                            {{ $voc['daily_usage'] }}
                                        </div>
                                    @endif
                                </div>

                                @if(!empty($voc['example']))
                                    <div class="p-3 rounded-xl bg-blue-50/50 border border-blue-100 text-xs mt-2 flex items-start justify-between gap-2">
                                        <div>
                                            <div class="font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-base' : '' }}">
                                                {{ $voc['example'] }}
                                            </div>
                                            <div class="text-slate-600 font-medium mt-1">
                                                {{ $voc['example_trans'] ?? '' }}
                                            </div>
                                        </div>
                                        <button type="button" onclick="speakText('{{ addslashes($voc['example']) }}', '{{ $lesson->unit->level->language->code }}')" class="p-1.5 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs flex-shrink-0 mt-0.5" title="Dengarkan seluruh kalimat contoh">
                                            <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 4. Grammar Rules & Sentence Formulas -->
            @if(!empty($lesson->content_body['grammar_rules']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="book" class="w-4 h-4 text-indigo-600"></i>
                        <span>Tata Bahasa & Pola Kalimat Praktis</span>
                    </h3>
                    <div class="space-y-4">
                        @foreach($lesson->content_body['grammar_rules'] as $rule)
                            <div class="p-5 rounded-2xl bg-indigo-50/50 border border-indigo-200 shadow-sm">
                                <h4 class="text-sm sm:text-base font-bold text-indigo-950 mb-1.5">{{ $rule['title'] }}</h4>
                                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed mb-3">{{ $rule['explanation'] }}</p>

                                @if(!empty($rule['formula']))
                                    <div class="p-3 mb-4 rounded-xl bg-white border border-indigo-200 text-xs font-mono font-bold text-indigo-700 flex items-center gap-2">
                                        <i data-lucide="code" class="w-3.5 h-3.5 text-indigo-500"></i>
                                        <span>Pola Rumus: {{ $rule['formula'] }}</span>
                                    </div>
                                @endif

                                @if(!empty($rule['examples']))
                                    <div class="space-y-3">
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-indigo-800">Contoh Kalimat Terapan & Bedah Suku Kata:</div>
                                        @foreach($rule['examples'] as $examp)
                                            @php
                                                $sentenceTrans = \App\Services\LinguisticBreakdownService::getSentenceTransliteration($lesson->unit->level->language->code, $examp['target'], $examp['trans'] ?? null);
                                                $breakdown = $examp['breakdown'] ?? \App\Services\LinguisticBreakdownService::getBreakdown($lesson->unit->level->language->code, $examp['target'], $sentenceTrans, $examp['meaning'] ?? null);
                                            @endphp
                                            <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
                                                <div class="flex items-start justify-between gap-3 mb-2">
                                                    <div>
                                                        <div class="text-base sm:text-lg font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-xl sm:text-2xl' : '' }}">
                                                            {{ $examp['target'] }}
                                                        </div>
                                                        <div class="text-xs text-indigo-600 font-semibold mt-0.5">
                                                            Pelafalan Abjad: {{ $sentenceTrans }}
                                                        </div>
                                                        <div class="text-xs text-slate-700 font-medium mt-1">
                                                            Arti Kalimat: {{ $examp['meaning'] }}
                                                        </div>
                                                    </div>
                                                    <button type="button" onclick="speakText('{{ addslashes($examp['target']) }}', '{{ $lesson->unit->level->language->code }}')" class="p-2.5 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white transition shadow-sm flex-shrink-0" title="Dengarkan seluruh kalimat penutur asli">
                                                        <i data-lucide="volume-2" class="w-4 h-4"></i>
                                                    </button>
                                                </div>

                                                @if(!empty($breakdown))
                                                    <div class="mt-2.5 pt-2 border-t border-slate-100">
                                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Bedah Suku Kata & Terjemahan Kata per Kata:</span>
                                                        <div class="flex flex-wrap gap-1.5">
                                                            @foreach($breakdown as $item)
                                                                <div class="inline-flex flex-col items-center bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-300 rounded-lg px-2.5 py-1 text-center transition cursor-pointer" onclick="speakText('{{ addslashes($item['token']) }}', '{{ $lesson->unit->level->language->code }}')" title="Klik untuk dengarkan pelafalan suku kata">
                                                                    <span class="font-bold text-xs text-slate-800 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-base' : '' }}">{{ $item['token'] }}</span>
                                                                    <span class="text-[10px] text-indigo-600 font-semibold">[{{ $item['syllables'] }}]</span>
                                                                    <span class="text-[9px] text-slate-500 font-semibold">{{ $item['meaning'] }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 5. Interactive Dialogues -->
            @if(!empty($lesson->content_body['dialogues']))
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4 text-emerald-600"></i>
                        <span>Simulasi Percakapan Situasional & Bedah Suku Kata</span>
                    </h3>
                    <div class="space-y-3">
                        @foreach($lesson->content_body['dialogues'] as $dia)
                            @php
                                $diaTrans = \App\Services\LinguisticBreakdownService::getSentenceTransliteration($lesson->unit->level->language->code, $dia['line'], $dia['trans'] ?? null);
                                $diaBreakdown = $dia['breakdown'] ?? \App\Services\LinguisticBreakdownService::getBreakdown($lesson->unit->level->language->code, $dia['line'], $diaTrans, $dia['meaning'] ?? null);
                            @endphp
                            <div class="p-4 sm:p-5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-white transition shadow-sm">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                            {{ substr($dia['speaker'], 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">{{ $dia['speaker'] }}</div>
                                            <div class="text-base sm:text-lg font-bold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-xl sm:text-2xl' : '' }}">
                                                {{ $dia['line'] }}
                                            </div>
                                            <div class="text-xs text-emerald-600 font-semibold mt-0.5">Pelafalan Abjad: {{ $diaTrans }}</div>
                                            <div class="text-xs text-slate-600 mt-1">Arti: {{ $dia['meaning'] }}</div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="speakText('{{ addslashes($dia['line']) }}', '{{ $lesson->unit->level->language->code }}')" class="p-2.5 rounded-xl bg-emerald-100 text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-sm flex-shrink-0" title="Dengarkan seluruh kalimat percakapan">
                                        <i data-lucide="volume-2" class="w-4 h-4"></i>
                                    </button>
                                </div>

                                @if(!empty($diaBreakdown))
                                    <div class="mt-2.5 pt-2 border-t border-slate-200">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Bedah Suku Kata & Terjemahan Kata per Kata:</span>
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($diaBreakdown as $b)
                                                <div class="inline-flex flex-col items-center bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 rounded-lg px-2 py-1 text-center transition cursor-pointer shadow-2xs" onclick="speakText('{{ addslashes($b['token']) }}', '{{ $lesson->unit->level->language->code }}')" title="Klik untuk dengarkan pelafalan suku kata">
                                                    <span class="font-bold text-xs text-slate-800 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-base' : '' }}">{{ $b['token'] }}</span>
                                                    <span class="text-[10px] text-emerald-600 font-semibold">[{{ $b['syllables'] }}]</span>
                                                    <span class="text-[9px] text-slate-500 font-semibold">{{ $b['meaning'] }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 6. Pembelajaran Mendalam: Etiket, Nuansa & Jebakan Konteks -->
            <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/40 border border-slate-200 space-y-4">
                <div class="flex items-center gap-2 text-xs font-bold text-blue-700 uppercase tracking-wider">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>Pembelajaran Mendalam & Etiket Komunikasi</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs leading-relaxed text-slate-700">
                    <div class="p-3 bg-white rounded-xl border border-slate-200">
                        <span class="font-bold text-slate-900 block mb-1">💡 Nuansa & Kehalusan Bahasa:</span>
                        Dalam bahasa {{ $lesson->unit->level->language->name }}, perhatikan tingkat kesopanan lawan bicara. Gunakan bentuk hormat kepada orang yang baru dikenal atau lebih senior, dan bentuk netral/akrab kepada teman sebaya.
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-slate-200">
                        <span class="font-bold text-slate-900 block mb-1">⚠️ Jebakan Konteks (False Friends):</span>
                        Hindari menerjemahkan kata per kata secara harfiah. Pola susunan kalimat mengikuti logika penutur asli untuk menghindari kesalahpahaman makna di percakapan nyata.
                    </div>
                </div>
            </div>

            <!-- 7. Interactive Quiz Exercise with Auto-Next Trigger -->
            @if($lesson->exercises->isNotEmpty())
                <div class="pt-6 border-t border-slate-200">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i>
                        <span>Latihan Evaluasi Interaktif (Terjemahan Indonesia & Abjad Latin)</span>
                    </h3>

                    @foreach($lesson->exercises as $ex)
                        <div class="p-5 sm:p-6 rounded-2xl bg-emerald-50/60 border border-emerald-200 mb-5 shadow-sm" id="exercise-box-{{ $ex->id }}">
                            <p class="text-sm sm:text-base font-bold text-slate-900 mb-3">{{ $ex->question_text }}</p>
                            @if($ex->prompt_script)
                                <div class="p-4 rounded-xl bg-white border border-slate-200 mb-4 flex items-center justify-between shadow-sm">
                                    <div>
                                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-3xl sm:text-4xl' : ($lesson->unit->level->language->code === 'ja' ? 'font-japanese' : ($lesson->unit->level->language->code === 'ko' ? 'font-korean' : '')) }}">
                                            {{ $ex->prompt_script }}
                                        </div>
                                        @php
                                            $transcription = null;
                                            if (preg_match('/\((.*?)\)/', $ex->question_text, $match)) {
                                                $transcription = $match[1];
                                            } elseif (preg_match('/\((.*?)\)/', $ex->explanation, $match)) {
                                                $transcription = $match[1];
                                            } elseif (preg_match('/\((.*?)\)/', $ex->correct_answer, $match)) {
                                                $transcription = $match[1];
                                            }
                                        @endphp
                                        @if($transcription)
                                            <div class="text-xs text-blue-600 font-semibold mt-1">
                                                Pelafalan Abjad: {{ $transcription }}
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" onclick="speakText('{{ addslashes($ex->prompt_script) }}', '{{ $lesson->unit->level->language->code }}')" class="p-3 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm ml-3 flex-shrink-0" title="Dengarkan pengucapan penutur asli">
                                        <i data-lucide="volume-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3 mb-3">
                                @foreach($ex->options_json as $opt)
                                    <button type="button" onclick="checkAnswer('{{ $ex->id }}', '{{ addslashes($opt) }}', '{{ addslashes($ex->correct_answer) }}', '{{ addslashes($ex->explanation) }}')" class="exercise-opt-{{ $ex->id }} text-left p-4 rounded-xl border border-slate-200 bg-white hover:bg-emerald-50 hover:border-emerald-400 text-xs sm:text-sm font-semibold text-slate-700 transition min-h-[48px] flex items-center shadow-sm">
                                        <span>{{ $opt }}</span>
                                    </button>
                                @endforeach
                            </div>
                            <div id="feedback-{{ $ex->id }}" class="hidden text-xs sm:text-sm font-semibold p-4 rounded-xl mt-3 leading-relaxed border"></div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- Desktop Lesson Completion Footer -->
        <div class="p-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-xs text-slate-600 font-semibold block">Selesaikan materi untuk melangkah ke bab selanjutnya.</span>
                @if($nextLesson)
                    <span class="text-[11px] text-blue-600 font-medium">Langkah selanjutnya: {{ $nextLesson->title }}</span>
                @else
                    <span class="text-[11px] text-amber-600 font-medium">Materi terakhir! Anda akan lanjut ke Ujian Kelulusan.</span>
                @endif
            </div>
            
            <form id="completeLessonForm" action="{{ route('lesson.complete', $lesson->id) }}" method="POST">
                @csrf
                <button type="submit" id="btnCompleteDesktop" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs sm:text-sm hover:opacity-95 transition shadow-md flex items-center justify-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span>{{ $nextLesson ? 'Selesaikan & Lanjut ke Materi Berikutnya' : 'Selesaikan & Lanjut ke Ujian Kelulusan' }}</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>
        </div>

    </div>

</div>

<!-- Mobile Sticky Bottom Action Bar (Smooth & Touch-Friendly) -->
<div class="fixed bottom-0 left-0 right-0 p-3 bg-white/95 backdrop-blur-md border-t border-slate-200 z-50 sm:hidden flex items-center justify-between shadow-lg">
    <div class="truncate max-w-[150px]">
        <div class="text-[10px] text-slate-400 font-bold uppercase truncate">{{ $lesson->unit->title }}</div>
        <div class="text-xs font-bold text-slate-800 truncate">{{ $lesson->title }}</div>
    </div>
    <form action="{{ route('lesson.complete', $lesson->id) }}" method="POST">
        @csrf
        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center gap-1.5 shadow-md">
            <span>{{ $nextLesson ? 'Lanjut' : 'Ujian' }}</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </button>
    </form>
</div>

<!-- Interactive Celebration Modal -->
<div id="celebrationModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center shadow-2xl animate-bounce-once">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="sparkles" class="w-8 h-8"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-1">Materi Selesai!</h3>
        <p class="text-xs text-slate-500 mb-6" id="modalSubtext">
            Hebat! Jawaban Anda benar. Menyiapkan materi berikutnya...
        </p>
        <button type="button" onclick="submitAndAdvance()" class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-1.5">
            <span>Lanjut Sekarang</span>
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
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
            
            // Highlight Next button
            const btn = document.getElementById('btnCompleteDesktop');
            if (btn) {
                btn.classList.add('ring-4', 'ring-emerald-400', 'animate-pulse');
            }

            // Show interactive celebration banner after short delay
            setTimeout(() => {
                const modal = document.getElementById('celebrationModal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            }, 1000);
        } else {
            feedback.classList.add('bg-rose-100', 'text-rose-800');
            feedback.innerHTML = '<span class="font-bold">✗ Belum tepat.</span> Coba lagi atau baca kembali materi di atas.';
        }
    }

    function submitAndAdvance() {
        const form = document.getElementById('completeLessonForm');
        if (form) {
            form.submit();
        }
    }
</script>
@endpush
@endsection
