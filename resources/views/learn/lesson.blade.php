@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8 pb-28 sm:pb-12">

    <!-- Top Navigation -->
    <div class="mb-4 sm:mb-6 flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('learn.index', ['slug' => $pair->slug ?? 'id-ar', 'level' => $lesson->unit->level->code]) }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1 transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Silabus {{ $lesson->unit->level->code }}</span>
            </a>
            @if(isset($previousLesson) && $previousLesson)
                <a href="{{ route('lesson.show', $previousLesson->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 shadow-2xs transition" title="Kembali ke: {{ $previousLesson->title }}">
                    <i data-lucide="chevron-left" class="w-4 h-4 text-blue-600"></i>
                    <span>Materi Sebelumnya</span>
                </a>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                {{ $lesson->unit->title }}
            </span>
            @if($nextLesson)
                <a href="{{ route('lesson.show', $nextLesson->id) }}" class="inline-flex items-center gap-1 text-[11px] text-blue-600 hover:text-blue-800 font-semibold" title="Lanjut ke: {{ $nextLesson->title }}">
                    <span class="hidden md:inline">Berikutnya: {{ Str::limit($nextLesson->title, 20) }}</span>
                    <span class="md:hidden">Berikutnya</span>
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                </a>
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
                                    {{ $alpha['name'] ?? ($alpha['romaji'] ?? ($alpha['romaja'] ?? ($alpha['phonetic'] ?? ($alpha['trans'] ?? '')))) }}
                                </div>
                                <button type="button" data-text="{{ $alpha['audio'] ?? $alpha['char'] }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center mx-auto shadow-sm" title="Dengarkan pengucapan huruf">
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
                                        <button type="button" data-text="{{ $voc['audio'] ?? ($voc['arabic'] ?? ($voc['kanji_kana'] ?? ($voc['hangeul'] ?? ($voc['word'] ?? '')))) }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center flex-shrink-0 shadow-sm ml-2" title="Dengarkan kosakata penutur asli">
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
                                        <button type="button" data-text="{{ $voc['example'] }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" class="p-1.5 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs flex-shrink-0 mt-0.5" title="Dengarkan seluruh kalimat contoh">
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
                                                    <button type="button" data-text="{{ $examp['target'] }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" class="p-2.5 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white transition shadow-sm flex-shrink-0" title="Dengarkan seluruh kalimat penutur asli">
                                                        <i data-lucide="volume-2" class="w-4 h-4"></i>
                                                    </button>
                                                </div>

                                                @if(!empty($breakdown))
                                                    <div class="mt-2.5 pt-2 border-t border-slate-100">
                                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">Bedah Suku Kata & Terjemahan Kata per Kata:</span>
                                                        <div class="flex flex-wrap gap-1.5">
                                                            @foreach($breakdown as $item)
                                                                <div class="inline-flex flex-col items-center bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-300 rounded-lg px-2.5 py-1 text-center transition cursor-pointer" data-text="{{ $item['token'] }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" title="Klik untuk dengarkan pelafalan suku kata">
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

            <!-- 5. Interactive Communications (100+ Skenario Komunikasi 2 Orang atau Lebih yang Bervariasi & Kontekstual) -->
            @php
                $dialogueList = $dialogues ?? \App\Services\InteractiveDialogueService::getDialoguesForLesson($lesson, $variationSeed ?? 0);
            @endphp

            <div class="rounded-3xl border border-emerald-200 bg-gradient-to-b from-emerald-50/50 via-white to-slate-50 p-5 sm:p-7 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs">
                                <i data-lucide="messages-square" class="w-4 h-4"></i>
                            </span>
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900">
                                Modul Percakapan Interaktif (2 Orang atau Lebih)
                            </h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 max-w-2xl leading-relaxed">
                            Simulasi percakapan nyata yang dirancang khusus dan selalu bervariasi di setiap materi. Menampilkan dialog kontekstual kosakata bab ini, dilanjutkan ratusan skenario situasional multi-penutur dengan transliterasi abjad, terjemahan Indonesia, dan bedah suku kata.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200 shadow-2xs">
                            {{ count($dialogueList) }} Skenario Tersedia
                        </span>
                        <button type="button" onclick="shuffleDialogues()" id="btnShuffleDialogues" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-xs flex items-center gap-1.5 group" title="Acak susunan dan tampilkan variasi percakapan baru untuk materi ini">
                            <i data-lucide="shuffle" class="w-3.5 h-3.5 transition-transform group-hover:rotate-180"></i>
                            <span>Acak Variasi Baru</span>
                        </button>
                    </div>
                </div>

                <!-- Mode & Filter Tabs -->
                <div class="flex flex-wrap items-center gap-1.5 mb-4 p-1.5 rounded-2xl bg-slate-100/80 border border-slate-200 text-xs">
                    <button type="button" onclick="filterParticipantMode('all', this)" class="participant-filter-btn px-3 py-1.5 rounded-xl font-bold bg-white text-emerald-800 shadow-2xs border border-emerald-200 transition">
                        Semua Skenario ({{ count($dialogueList) }})
                    </button>
                    <button type="button" onclick="filterParticipantMode('featured', this)" class="participant-filter-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:text-slate-900 transition flex items-center gap-1">
                        <i data-lucide="star" class="w-3 h-3 text-amber-500 fill-current"></i>
                        <span>Percakapan Khusus Bab Ini</span>
                    </button>
                    <button type="button" onclick="filterParticipantMode('2', this)" class="participant-filter-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:text-slate-900 transition flex items-center gap-1">
                        <i data-lucide="users" class="w-3 h-3 text-emerald-600"></i>
                        <span>Percakapan 2 Orang</span>
                    </button>
                    <button type="button" onclick="filterParticipantMode('3', this)" class="participant-filter-btn px-3 py-1.5 rounded-xl font-semibold text-slate-600 hover:text-slate-900 transition flex items-center gap-1">
                        <i data-lucide="message-circle" class="w-3 h-3 text-blue-600"></i>
                        <span>Diskusi 3 Orang</span>
                    </button>
                </div>

                <!-- Search and Filter Bar -->
                <div class="flex flex-col sm:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                        <input type="text" id="dialogueSearchInput" onkeyup="filterDialogueScenarios()" placeholder="Cari skenario percakapan, topik, atau situasi..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-xs">
                    </div>
                    <select id="dialogueCategoryFilter" onchange="filterDialogueScenarios()" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none shadow-xs">
                        <option value="all">Semua Kategori Topik</option>
                        <option value="Salam & Perkenalan">Salam & Perkenalan</option>
                        <option value="Restoran & Kuliner">Restoran & Kuliner</option>
                        <option value="Navigasi & Stasiun">Navigasi & Stasiun</option>
                        <option value="Pasar & Belanja">Pasar & Belanja</option>
                        <option value="Kampus & Pendidikan">Kampus & Pendidikan</option>
                        <option value="Kantor & Rapat">Kantor & Rapat</option>
                        <option value="Hotel & Wisata">Hotel & Wisata</option>
                        <option value="Kesehatan & Medis">Kesehatan & Medis</option>
                        <option value="Diskusi 3 Orang">Diskusi 3 Orang</option>
                        <option value="Solusi Masalah & Darurat">Solusi Masalah & Darurat</option>
                    </select>
                </div>

                <!-- Scenario Cards Container -->
                <div id="dialogueScenariosContainer" class="space-y-4">
                    @foreach($dialogueList as $scIndex => $sc)
                        @php
                            $isFeatured = ($sc['is_featured'] ?? false);
                            $cardBorder = $isFeatured 
                                ? 'border-2 border-emerald-400 bg-gradient-to-br from-emerald-50/70 via-white to-amber-50/20 shadow-md ring-2 ring-emerald-200/40' 
                                : 'border border-slate-200 bg-white hover:border-emerald-300 shadow-xs';
                        @endphp
                        <div class="dialogue-scenario-card p-5 rounded-2xl {{ $cardBorder }} transition {{ $scIndex >= 10 ? 'hidden' : '' }}" 
                             data-index="{{ $scIndex }}" 
                             data-is-featured="{{ $isFeatured ? '1' : '0' }}"
                             data-participants-count="{{ $sc['participant_count'] ?? 2 }}"
                             data-category="{{ $sc['category'] }}" 
                             data-search="{{ strtolower($sc['title'] . ' ' . $sc['category'] . ' ' . implode(' ', $sc['participants'] ?? [])) }}">
                            
                            <!-- Scenario Header -->
                            <div class="flex flex-wrap items-center justify-between gap-2 pb-3 mb-3 border-b border-slate-100">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @if($isFeatured)
                                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-extrabold flex items-center gap-1 shadow-2xs">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                <span>{{ $sc['badge'] ?? '⭐ KONTEKSTUAL BAB INI' }}</span>
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                                {{ $sc['category'] }}
                                            </span>
                                        @endif
                                        <span class="text-xs font-bold text-slate-900">
                                            {{ $sc['title'] }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 mt-1">
                                        {{ $sc['situation'] }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full {{ ($sc['participant_count'] ?? 2) >= 3 ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700' }}">
                                        <i data-lucide="users" class="w-3 h-3"></i>
                                        <span>{{ ($sc['participant_count'] ?? 2) }} Penutur</span>
                                    </span>
                                    @foreach($sc['participants'] as $pName)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">
                                            <i data-lucide="user" class="w-3 h-3 text-slate-500"></i>
                                            <span>{{ $pName }}</span>
                                        </span>
                                    @endforeach
                                    <button type="button" onclick="playFullScenario('{{ $sc['id'] }}', '{{ $lesson->unit->level->language->code }}')" class="ml-2 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition text-xs font-bold flex items-center gap-1 shadow-2xs" title="Putar dialog percakapan berurutan">
                                        <i data-lucide="play-circle" class="w-3.5 h-3.5"></i>
                                        <span>Putar Skenario</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Turns in Chat Bubble Style -->
                            <div class="space-y-3" id="scenario-turns-{{ $sc['id'] }}">
                                @foreach($sc['turns'] as $tIdx => $turn)
                                    @php
                                        $isSpeakerOne = ($tIdx % 2 === 0);
                                        $bubbleBg = $isSpeakerOne ? 'bg-slate-50 border-slate-200' : 'bg-emerald-50/50 border-emerald-200';
                                        $badgeBg = $isSpeakerOne ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800';
                                    @endphp
                                    <div class="p-4 rounded-2xl border {{ $bubbleBg }} transition shadow-2xs scenario-turn-item" data-audio-text="{{ $turn['audio'] ?? $turn['text'] }}">
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <div class="flex items-start gap-2.5">
                                                <div class="w-7 h-7 rounded-full {{ $badgeBg }} font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5 shadow-2xs">
                                                    {{ substr($turn['speaker'], 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-[11px] font-bold text-slate-800">
                                                        {{ $turn['speaker'] }} <span class="text-[10px] text-slate-400 font-normal">({{ $turn['role'] }})</span>
                                                    </div>
                                                    <div class="text-base sm:text-lg font-bold text-slate-900 mt-0.5 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-xl sm:text-2xl' : '' }}">
                                                        {{ $turn['text'] }}
                                                    </div>
                                                    <div class="text-xs text-emerald-600 font-semibold mt-0.5">
                                                        Pelafalan Abjad: {{ $turn['trans'] }}
                                                    </div>
                                                    <div class="text-xs text-slate-600 mt-1">
                                                        Arti: {{ $turn['meaning'] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" data-text="{{ $turn['audio'] ?? $turn['text'] }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" class="p-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition shadow-xs flex-shrink-0" title="Dengarkan seluruh kalimat percakapan">
                                                <i data-lucide="volume-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>

                                        @if(!empty($turn['breakdown']))
                                            <div class="mt-2.5 pt-2 border-t border-slate-200/80">
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Bedah Suku Kata & Arti Kata per Kata:</span>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($turn['breakdown'] as $b)
                                                        <div class="inline-flex flex-col items-center bg-white hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 rounded-lg px-2 py-0.5 text-center transition cursor-pointer shadow-2xs" data-text="{{ $b['token'] }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" title="Klik untuk dengarkan pelafalan suku kata">
                                                            <span class="font-bold text-xs text-slate-800 {{ $lesson->unit->level->language->code === 'ar' ? 'font-arabic text-sm' : '' }}">{{ $b['token'] }}</span>
                                                            <span class="text-[9px] text-emerald-600 font-semibold">[{{ $b['syllables'] }}]</span>
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
                    @endforeach
                </div>

                <!-- Scenario Pagination Controller -->
                <div class="mt-5 pt-4 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <span id="scenarioCountIndicator" class="text-slate-500 font-medium">
                        Menampilkan 10 dari 100 Skenario Komunikasi
                    </span>
                    <div class="flex items-center gap-1.5" id="scenarioPaginationButtons">
                        <button type="button" onclick="loadMoreScenarios()" id="btnLoadMoreScenarios" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-xs flex items-center gap-1.5">
                            <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                            <span>Tampilkan 10 Skenario Berikutnya</span>
                        </button>
                        <button type="button" onclick="showAllScenarios()" id="btnShowAllScenarios" class="px-3.5 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold transition shadow-2xs">
                            Lihat Semua 100 Skenario
                        </button>
                    </div>
                </div>
            </div>

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

            <!-- 7. Interactive Quiz Exercise with Choice Dialog -->
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
                                    <button type="button" data-text="{{ $ex->prompt_script }}" data-lang="{{ $lesson->unit->level->language->code }}" onclick="playVoice(this)" class="p-3 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition shadow-sm ml-3 flex-shrink-0" title="Dengarkan pengucapan penutur asli">
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
            <div class="flex items-center gap-3">
                @if(isset($previousLesson) && $previousLesson)
                    <a href="{{ route('lesson.show', $previousLesson->id) }}" class="px-4 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs sm:text-sm transition flex items-center gap-2 shadow-xs" title="Kembali ke: {{ $previousLesson->title }}">
                        <i data-lucide="arrow-left" class="w-4 h-4 text-slate-600"></i>
                        <span>Materi Sebelumnya</span>
                    </a>
                @endif
                <div>
                    <span class="text-xs text-slate-600 font-semibold block">Selesaikan materi untuk melangkah ke bab selanjutnya.</span>
                    @if($nextLesson)
                        <span class="text-[11px] text-blue-600 font-medium">Langkah selanjutnya: {{ $nextLesson->title }}</span>
                    @else
                        <span class="text-[11px] text-amber-600 font-medium">Materi terakhir! Anda akan lanjut ke Ujian Kelulusan.</span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center gap-2.5 w-full sm:w-auto">
                <button type="button" onclick="completeAndStay()" class="flex-1 sm:flex-none px-4 py-3.5 rounded-xl border-2 border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs sm:text-sm transition shadow-xs flex items-center justify-center gap-2">
                    <i data-lucide="rotate-ccw" class="w-4 h-4 text-slate-500"></i>
                    <span>Tandai Selesai & Tetap di Sini</span>
                </button>

                <form id="completeLessonForm" action="{{ route('lesson.complete', $lesson->id) }}" method="POST" class="flex-1 sm:flex-none">
                    @csrf
                    <input type="hidden" name="action" id="lessonActionInput" value="next">
                    <button type="submit" id="btnCompleteDesktop" class="w-full sm:w-auto px-5 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs sm:text-sm hover:opacity-95 transition shadow-md flex items-center justify-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>{{ $nextLesson ? 'Selesaikan & Lanjut ke Materi Berikutnya' : 'Selesaikan & Lanjut ke Ujian' }}</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

<!-- Mobile Sticky Bottom Action Bar (Touch-Friendly & Previous/Stay/Next) -->
<div class="fixed bottom-0 left-0 right-0 p-3 bg-white/95 backdrop-blur-md border-t border-slate-200 z-50 sm:hidden flex items-center justify-between gap-2 shadow-lg">
    <div class="flex items-center gap-1.5 truncate max-w-[130px]">
        @if(isset($previousLesson) && $previousLesson)
            <a href="{{ route('lesson.show', $previousLesson->id) }}" class="p-2 rounded-xl border border-slate-200 bg-slate-50 text-slate-700 flex items-center justify-center shadow-2xs" title="Materi Sebelumnya">
                <i data-lucide="chevron-left" class="w-4 h-4 text-blue-600"></i>
            </a>
        @endif
        <div class="truncate">
            <div class="text-[9px] text-slate-400 font-bold uppercase truncate">{{ $lesson->unit->title }}</div>
            <div class="text-xs font-bold text-slate-800 truncate">{{ $lesson->title }}</div>
        </div>
    </div>
    <div class="flex items-center gap-1.5">
        <button type="button" onclick="completeAndStay()" class="px-3 py-2 rounded-xl border border-slate-300 bg-white text-slate-700 font-bold text-xs flex items-center gap-1 shadow-2xs">
            <i data-lucide="rotate-ccw" class="w-3.5 h-3.5 text-slate-500"></i>
            <span>Tetap</span>
        </button>
        <button type="button" onclick="completeAndAdvance()" class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center gap-1 shadow-md">
            <span>{{ $nextLesson ? 'Lanjut' : 'Ujian' }}</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </button>
    </div>
</div>

<!-- Interactive Celebration Modal (Choose to advance or stay) -->
<div id="celebrationModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center shadow-2xl animate-bounce-once">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-sm">
            <i data-lucide="sparkles" class="w-8 h-8"></i>
        </div>
        <h3 class="text-xl font-black text-slate-900 mb-1">Materi Selesai!</h3>
        <p class="text-xs text-slate-500 mb-6" id="modalSubtext">
            Hebat! Jawaban Anda benar. Pilih tindakan Anda selanjutnya:
        </p>
        <div class="flex flex-col gap-2.5">
            <button type="button" onclick="completeAndAdvance()" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs hover:opacity-95 transition shadow-md flex items-center justify-center gap-1.5">
                <span>Lanjut ke Materi Selanjutnya</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
            <button type="button" onclick="completeAndStay()" class="w-full py-3 rounded-xl border border-slate-300 bg-slate-50 text-slate-700 font-bold text-xs hover:bg-slate-100 transition shadow-xs flex items-center justify-center gap-1.5">
                <i data-lucide="rotate-ccw" class="w-4 h-4 text-slate-500"></i>
                <span>Tetap di Materi Ini (Ulangi/Pelajari Lagi)</span>
            </button>
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
            
            // Highlight Next button
            const btn = document.getElementById('btnCompleteDesktop');
            if (btn) {
                btn.classList.add('ring-4', 'ring-emerald-400', 'animate-pulse');
            }

            // Show interactive celebration modal
            setTimeout(() => {
                const modal = document.getElementById('celebrationModal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            }, 800);
        } else {
            feedback.classList.add('bg-rose-100', 'text-rose-800');
            feedback.innerHTML = '<span class="font-bold">✗ Belum tepat.</span> Coba lagi atau baca kembali materi di atas.';
        }
    }

    function completeAndStay() {
        const modal = document.getElementById('celebrationModal');
        if (modal) modal.classList.add('hidden');

        fetch('{{ route("lesson.complete", $lesson->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: 'stay', score: 100 })
        })
        .then(r => r.json())
        .then(data => {
            showAudioToast('✓ ' + (data.message || 'Progres disimpan! Anda tetap berada di materi ini.'));
        })
        .catch(err => {
            const input = document.getElementById('lessonActionInput');
            if (input) input.value = 'stay';
            document.getElementById('completeLessonForm').submit();
        });
    }

    function completeAndAdvance() {
        const input = document.getElementById('lessonActionInput');
        if (input) input.value = 'next';
        const form = document.getElementById('completeLessonForm');
        if (form) form.submit();
    }

    // 100+ Dialogues Client Controller (Pagination, Filter, Modes & Shuffle)
    let visibleScenariosCount = 10;
    let currentVariationSeed = {{ $variationSeed ?? 0 }};
    let activeParticipantFilter = 'all';

    function filterParticipantMode(mode, btn) {
        activeParticipantFilter = mode;
        document.querySelectorAll('.participant-filter-btn').forEach(b => {
            b.classList.remove('bg-white', 'text-emerald-800', 'shadow-2xs', 'border', 'border-emerald-200', 'font-bold');
            b.classList.add('font-semibold', 'text-slate-600');
        });
        if (btn) {
            btn.classList.add('bg-white', 'text-emerald-800', 'shadow-2xs', 'border', 'border-emerald-200', 'font-bold');
            btn.classList.remove('text-slate-600');
        }
        visibleScenariosCount = 10;
        filterDialogueScenarios();
    }

    function filterDialogueScenarios() {
        const q = (document.getElementById('dialogueSearchInput')?.value || '').toLowerCase().trim();
        const cat = document.getElementById('dialogueCategoryFilter')?.value || 'all';
        const cards = document.querySelectorAll('.dialogue-scenario-card');
        let matchedCount = 0;

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            const cardSearch = card.getAttribute('data-search') || '';
            const isFeatured = card.getAttribute('data-is-featured') === '1';
            const participantsCount = card.getAttribute('data-participants-count') || '2';

            const matchesCat = (cat === 'all' || cardCat === cat);
            const matchesQuery = (q === '' || cardSearch.includes(q));

            let matchesMode = true;
            if (activeParticipantFilter === 'featured') {
                matchesMode = isFeatured;
            } else if (activeParticipantFilter === '2') {
                matchesMode = (participantsCount === '2');
            } else if (activeParticipantFilter === '3') {
                matchesMode = (parseInt(participantsCount) >= 3);
            }

            if (matchesCat && matchesQuery && matchesMode) {
                matchedCount++;
                if (q !== '' || cat !== 'all' || activeParticipantFilter !== 'all' || matchedCount <= visibleScenariosCount) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            } else {
                card.classList.add('hidden');
            }
        });

        const indicator = document.getElementById('scenarioCountIndicator');
        if (indicator) {
            indicator.innerText = `Menampilkan ${Math.min(matchedCount, (q !== '' || cat !== 'all' || activeParticipantFilter !== 'all' ? matchedCount : visibleScenariosCount))} dari ${matchedCount} Skenario Ditemukan`;
        }
    }

    function shuffleDialogues() {
        const btn = document.getElementById('btnShuffleDialogues');
        if (btn) {
            btn.classList.add('animate-spin');
        }
        currentVariationSeed++;
        const url = new URL(window.location.href);
        url.searchParams.set('variation', currentVariationSeed);
        window.location.href = url.toString();
    }

    function loadMoreScenarios() {
        visibleScenariosCount = Math.min(100, visibleScenariosCount + 10);
        filterDialogueScenarios();
        if (visibleScenariosCount >= 100) {
            const btn = document.getElementById('btnLoadMoreScenarios');
            if (btn) btn.classList.add('hidden');
        }
    }

    function showAllScenarios() {
        visibleScenariosCount = 100;
        filterDialogueScenarios();
        const btnMore = document.getElementById('btnLoadMoreScenarios');
        const btnAll = document.getElementById('btnShowAllScenarios');
        if (btnMore) btnMore.classList.add('hidden');
        if (btnAll) btnAll.classList.add('hidden');
    }

    // Putar percakapan skenario secara otomatis giliran demi giliran
    let isPlayingScenario = false;
    async function playFullScenario(scenarioId, langCode) {
        if (isPlayingScenario) return;
        isPlayingScenario = true;

        const container = document.getElementById('scenario-turns-' + scenarioId);
        if (!container) {
            isPlayingScenario = false;
            return;
        }

        const turns = container.querySelectorAll('.scenario-turn-item');
        for (let i = 0; i < turns.length; i++) {
            const turn = turns[i];
            const text = turn.getAttribute('data-audio-text');
            turn.classList.add('ring-2', 'ring-emerald-400', 'bg-emerald-100/70');

            speakText(text, langCode);

            // Perkirakan jeda bicara (sekitar 3.5 detik per turn)
            await new Promise(r => setTimeout(r, 3500));
            turn.classList.remove('ring-2', 'ring-emerald-400', 'bg-emerald-100/70');
        }

        isPlayingScenario = false;
    }
</script>
@endpush
@endsection
