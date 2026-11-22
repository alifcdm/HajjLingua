@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Top Breadcrumb & Pair Info -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1 mb-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Pilihan Bahasa
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ $pair->name }}</span>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">20 Jam Kurikulum</span>
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('placement.show', $pair->slug) }}" class="px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 font-semibold text-xs hover:bg-blue-100 transition flex items-center gap-1.5">
                <i data-lucide="target" class="w-4 h-4"></i>
                <span>Placement Test</span>
            </a>
        </div>
    </div>

    <!-- Horizontal Level Tabs -->
    <div class="flex overflow-x-auto space-x-2 pb-3 mb-8 no-scrollbar border-b border-slate-200">
        @foreach($levels as $lvl)
            <a href="{{ route('learn.index', ['slug' => $pair->slug, 'level' => $lvl->code]) }}"
               class="px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 {{ $selectedLevel->id === $lvl->id ? 'bg-blue-600 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-700 hover:border-blue-400' }}">
                <span>{{ $lvl->code }}</span>
                <span class="text-[10px] opacity-80">({{ $lvl->stage_category }})</span>
            </a>
        @endforeach
    </div>

    <!-- Active Level Header & Final Exam CTA -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="max-w-2xl">
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-800 text-xs font-black">
                    LEVEL {{ $selectedLevel->code }}
                </span>
                <span class="px-2.5 py-0.5 rounded-md bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200">
                    Target: 20 Jam Pembelajaran Mandiri
                </span>
                <span class="text-xs font-semibold text-slate-500">
                    Kategori: {{ $selectedLevel->stage_category }}
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">
                {{ $selectedLevel->name }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                {{ $selectedLevel->description }}
            </p>

            <!-- 20-Hour Pacing Metric Pills -->
            <div class="flex flex-wrap gap-2.5 text-[11px] font-semibold text-slate-600">
                <span class="px-3 py-1 rounded-xl bg-slate-100 flex items-center gap-1.5">
                    <i data-lucide="layers" class="w-3.5 h-3.5 text-blue-600"></i>
                    {{ $totalLessons }} Materi Pembelajaran
                </span>
                <span class="px-3 py-1 rounded-xl bg-slate-100 flex items-center gap-1.5">
                    <i data-lucide="clock" class="w-3.5 h-3.5 text-indigo-600"></i>
                    Alokasi: ~{{ $totalHours }} Jam Selesai (12 mnt/materi)
                </span>
                <span class="px-3 py-1 rounded-xl bg-slate-100 flex items-center gap-1.5">
                    <i data-lucide="book-open" class="w-3.5 h-3.5 text-emerald-600"></i>
                    Terjemahan Bahasa Indonesia & Detail Sehari-hari
                </span>
            </div>
        </div>

        <div class="w-full md:w-auto flex-shrink-0 flex flex-col sm:flex-row md:flex-col gap-2.5">
            <a href="{{ route('drill.index', $selectedLevel->id) }}" class="w-full px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-xs sm:text-sm hover:opacity-95 transition shadow-md flex items-center justify-center gap-2">
                <i data-lucide="zap" class="w-4 h-4 text-yellow-300"></i>
                <span>100 Level Drill Memori (1.500 Soal)</span>
            </a>
            <a href="{{ route('exam.show', $selectedLevel->id) }}" class="w-full px-5 py-3 rounded-2xl bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold text-xs sm:text-sm hover:opacity-95 transition shadow-md flex items-center justify-center gap-2">
                <i data-lucide="award" class="w-4 h-4"></i>
                <span>Ujian Akhir Level & Sertifikasi</span>
            </a>
        </div>
    </div>

    <!-- Curriculum Navigation Switcher (Tabs) -->
    <div class="flex items-center gap-2 p-1.5 bg-slate-200/80 rounded-2xl mb-8 max-w-xl">
        <button id="btn-tab-curriculum" onclick="switchTab('curriculum')" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 bg-white text-blue-700 shadow-sm">
            <i data-lucide="book" class="w-4 h-4"></i>
            <span>{{ $totalLessons }} Modul Materi (Silabus 20 Jam)</span>
        </button>
        <button id="btn-tab-vocab" onclick="switchTab('vocab')" class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 text-slate-600 hover:text-slate-900">
            <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
            <span>Kamus Kosakata Inti Level 1</span>
        </button>
    </div>

    <!-- SECTION 1: 100 Structured Curriculum Lessons -->
    <div id="section-curriculum" class="space-y-6">
        @if($selectedLevel->units->isNotEmpty())
            @foreach($selectedLevel->units as $unit)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="p-6 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-blue-100 text-blue-700">UNIT {{ $unit->sort_order }}</span>
                                <span class="text-[11px] font-semibold text-slate-500">10 Materi • 2 Jam Belajar</span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $unit->title }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $unit->description }}</p>
                        </div>
                        <span class="text-xs font-bold text-slate-600 bg-white px-3 py-1.5 rounded-xl border border-slate-200">
                            {{ $unit->lessons->count() }} Variasi Pelajaran
                        </span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($unit->lessons as $lesson)
                            @php
                                $isDone = $lesson->progresses->where('is_completed', true)->isNotEmpty();
                            @endphp
                            <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 hover:bg-slate-50 transition">
                                <div class="flex items-start sm:items-center space-x-3.5 min-w-0">
                                    <div class="w-9 h-9 rounded-xl {{ $isDone ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5 sm:mt-0">
                                        @if($isDone)
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        @else
                                            {{ $lesson->sort_order }}
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h4 class="text-sm font-bold text-slate-800 break-words">{{ $lesson->title }}</h4>
                                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 flex-shrink-0">12 Menit</span>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 text-[11px] text-slate-500">
                                            <span class="capitalize">{{ $lesson->content_type }}</span>
                                            <span>•</span>
                                            <span>Terjemahan Indonesia Lengkap</span>
                                            <span class="hidden sm:inline">•</span>
                                            <span class="hidden sm:inline">Detail Penggunaan Sehari-hari</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('lesson.show', $lesson->id) }}" class="w-full sm:w-auto px-4 py-2.5 sm:py-2 rounded-xl {{ $isDone ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-blue-600 text-white hover:bg-blue-700' }} text-xs font-semibold transition flex items-center justify-center gap-1.5 shadow-sm flex-shrink-0">
                                    <span>{{ $isDone ? 'Ulangi Pelajaran' : 'Mulai Belajar' }}</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- SECTION 2: Level 1 Foundational Vocabulary Bank with Indonesian Translations & Daily Usage -->
    <div id="section-vocab" class="hidden">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="book-marked" class="w-5 h-5 text-amber-500"></i>
                        <span>Pusat Kosakata Inti Level 1 ({{ $selectedLevel->code ?? 'A1' }}) (1000++ Kosakata Berjenjang Terjemahan Bahasa Indonesia & Penggunaan Sehari-hari)</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Bank 1000++ kosakata esensial frekuensi tinggi tingkat {{ $selectedLevel->code ?? '1' }} yang disesuaikan dengan kurikulum resmi {{ $pair->targetLanguage->name }}. Dilengkapi audio pengucapan penutur asli, pelafalan huruf abjad/transliterasi, arti resmi bahasa Indonesia, dan contoh situasi penggunaannya dalam percakapan sehari-hari.
                    </p>
                </div>
                <span class="px-3.5 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold border border-blue-200 shadow-2xs">
                    {{ count($levelOneVocabs) }}+ Kosakata Tersedia
                </span>
            </div>

            <!-- Vocabulary Search -->
            <div class="relative max-w-md mb-6">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                <input type="text" id="vocabSearchInput" onkeyup="filterVocabularies()" placeholder="Cari dari 1000++ kosakata atau arti bahasa Indonesia..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-xs">
            </div>

            <!-- Vocabulary Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="vocabGrid">
                @foreach($levelOneVocabs as $vIndex => $voc)
                    <div class="vocab-card p-5 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-blue-400 hover:shadow-md transition flex flex-col justify-between {{ $vIndex >= 36 ? 'hidden' : '' }}" data-index="{{ $vIndex }}" data-word="{{ strtolower($voc['word'] . ' ' . ($voc['trans'] ?? '') . ' ' . $voc['meaning']) }}">
                        <div>
                            <div class="flex items-start justify-between mb-3">
                                <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-[10px] font-bold">
                                    {{ $voc['pos'] ?? 'Kosakata Inti' }}
                                </span>
                                <button type="button" data-text="{{ $voc['audio'] ?? $voc['word'] }}" data-lang="{{ $pair->targetLanguage->code }}" onclick="playVoice(this)" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition flex items-center justify-center shadow-sm" title="Dengarkan pengucapan penutur asli">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <div class="text-2xl font-bold text-slate-900 mb-1 {{ $pair->targetLanguage->code === 'ar' ? 'font-arabic text-3xl' : ($pair->targetLanguage->code === 'ja' ? 'font-japanese' : 'font-korean') }}">
                                {{ $voc['word'] }}
                            </div>
                            <div class="text-xs text-blue-600 font-semibold mb-2">
                                {{ $voc['trans'] }}
                            </div>

                            <!-- Indonesian Translation -->
                            <div class="p-2.5 rounded-xl bg-white border border-slate-200 mb-3">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Arti Bahasa Indonesia:</div>
                                <div class="text-sm font-bold text-slate-800 mt-0.5">
                                    {{ $voc['meaning'] }}
                                </div>
                            </div>

                            <!-- Daily Usage Detail -->
                            <div class="text-xs text-slate-600 leading-relaxed mb-3">
                                <span class="font-bold text-slate-700">Penggunaan Sehari-hari:</span>
                                {{ $voc['daily_usage'] }}
                            </div>
                        </div>

                        <!-- Daily Example Sentence -->
                        @if(!empty($voc['example']))
                            <div class="p-3 rounded-xl bg-blue-50/60 border border-blue-100 text-xs flex items-start justify-between gap-2">
                                <div>
                                    <div class="font-bold text-slate-900 {{ $pair->targetLanguage->code === 'ar' ? 'font-arabic text-base' : '' }}">
                                        {{ $voc['example'] }}
                                    </div>
                                    <div class="text-slate-600 font-medium mt-1">
                                        {{ $voc['example_trans'] }}
                                    </div>
                                </div>
                                <button type="button" data-text="{{ $voc['example'] }}" data-lang="{{ $pair->targetLanguage->code }}" onclick="playVoice(this)" class="p-1.5 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs flex-shrink-0" title="Dengarkan kalimat contoh">
                                    <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Vocabulary Load More & Pagination Controller -->
            <div class="mt-6 pt-4 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3 text-xs">
                <span id="vocabCountIndicator" class="text-slate-500 font-medium">
                    Menampilkan 36 dari {{ count($levelOneVocabs) }} Kosakata
                </span>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="loadMoreVocabularies()" id="btnLoadMoreVocab" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold transition shadow-xs flex items-center gap-1.5">
                        <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i>
                        <span>Muat 36 Kosakata Lainnya</span>
                    </button>
                    <button type="button" onclick="showAllVocabularies()" id="btnShowAllVocab" class="px-4 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold transition shadow-2xs">
                        Lihat Semua {{ count($levelOneVocabs) }} Kosakata
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function switchTab(tab) {
        const secCurriculum = document.getElementById('section-curriculum');
        const secVocab = document.getElementById('section-vocab');
        const btnCurriculum = document.getElementById('btn-tab-curriculum');
        const btnVocab = document.getElementById('btn-tab-vocab');

        if (tab === 'curriculum') {
            secCurriculum.classList.remove('hidden');
            secVocab.classList.add('hidden');
            btnCurriculum.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            btnCurriculum.classList.remove('text-slate-600');
            btnVocab.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            btnVocab.classList.add('text-slate-600');
        } else {
            secCurriculum.classList.add('hidden');
            secVocab.classList.remove('hidden');
            btnVocab.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            btnVocab.classList.remove('text-slate-600');
            btnCurriculum.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            btnCurriculum.classList.add('text-slate-600');
        }
    }

    let visibleVocabCount = 36;

    function filterVocabularies() {
        const query = document.getElementById('vocabSearchInput')?.value.toLowerCase().trim() || '';
        const cards = document.querySelectorAll('.vocab-card');
        let matched = 0;

        cards.forEach(card => {
            const data = card.getAttribute('data-word') || '';
            const isMatch = (query === '' || data.includes(query));

            if (isMatch) {
                matched++;
                if (query !== '' || matched <= visibleVocabCount) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            } else {
                card.classList.add('hidden');
            }
        });

        const indicator = document.getElementById('vocabCountIndicator');
        if (indicator) {
            indicator.innerText = `Menampilkan ${Math.min(matched, (query !== '' ? matched : visibleVocabCount))} dari ${matched} Kosakata`;
        }
    }

    function loadMoreVocabularies() {
        visibleVocabCount += 36;
        filterVocabularies();
        const total = document.querySelectorAll('.vocab-card').length;
        if (visibleVocabCount >= total) {
            const btn = document.getElementById('btnLoadMoreVocab');
            if (btn) btn.classList.add('hidden');
        }
    }

    function showAllVocabularies() {
        visibleVocabCount = 999999;
        filterVocabularies();
        const btnMore = document.getElementById('btnLoadMoreVocab');
        const btnAll = document.getElementById('btnShowAllVocab');
        if (btnMore) btnMore.classList.add('hidden');
        if (btnAll) btnAll.classList.add('hidden');
    }
</script>
@endpush
@endsection
