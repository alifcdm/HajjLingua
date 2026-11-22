@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Breadcrumb & Top Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-emerald-700 flex items-center gap-1 mb-1 font-semibold transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight flex flex-wrap items-center gap-2">
                <span>Modul Panduan & Manasik Ibadah Haji</span>
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase tracking-wider border border-emerald-300">
                    Kementerian Haji dan Umrah RI
                </span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-3xl leading-relaxed">
                Riset komprehensif seluruh rangkaian ibadah haji dari miqat hingga tawaf wada', rukun & wajib, hukum fiqih kontemporer, doa berharakat dengan audio penutur asli, regulasi resmi Kementerian Haji dan Umrah RI (haji.go.id), dan sistem Bimtek Petugas PPIH.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-600"></i>
                <span>Standar Kemenhaj RI & Saudi Nusuk</span>
            </span>
        </div>
    </div>

    <!-- Hero Banner with Quran & Hadith Foundation -->
    <div class="rounded-3xl bg-gradient-to-r from-emerald-900 via-teal-950 to-slate-900 text-white p-6 sm:p-8 md:p-10 shadow-xl relative overflow-hidden mb-8 border border-emerald-800/40">
        <div class="absolute -right-8 -bottom-8 opacity-10 pointer-events-none">
            <i data-lucide="compass" class="w-80 h-80"></i>
        </div>

        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold mb-3 border border-emerald-400/30">
                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                    <span>{{ $hajj['overview']['dalil_quran']['surah'] }}</span>
                </div>
                <div class="font-arabic text-2xl sm:text-3xl leading-loose font-bold text-amber-200 mb-2" dir="rtl">
                    {{ $hajj['overview']['dalil_quran']['arabic'] }}
                </div>
                <div class="text-xs sm:text-sm text-emerald-200 font-medium italic mb-2">
                    "{{ $hajj['overview']['dalil_quran']['trans'] }}"
                </div>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    {{ $hajj['overview']['dalil_quran']['meaning'] }}
                </p>
            </div>

            <div class="p-5 sm:p-6 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20">
                <div class="flex items-center gap-2 text-xs font-bold text-amber-300 uppercase tracking-wider mb-2">
                    <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
                    <span>Keutamaan Haji Mabrur ({{ $hajj['overview']['hadits']['rawi'] }})</span>
                </div>
                <div class="font-arabic text-xl sm:text-2xl font-bold text-white mb-2" dir="rtl">
                    {{ $hajj['overview']['hadits']['arabic'] }}
                </div>
                <div class="text-xs text-amber-200 font-medium italic mb-2">
                    {{ $hajj['overview']['hadits']['trans'] }}
                </div>
                <p class="text-xs text-slate-200 font-semibold leading-relaxed">
                    {{ $hajj['overview']['hadits']['meaning'] }}
                </p>
            </div>
        </div>
    </div>

    <!-- Interactive Navigation Tabs (Desktop & Mobile Scrollable) -->
    <div class="flex overflow-x-auto space-x-2 pb-3 mb-8 no-scrollbar border-b border-slate-200">
        <button onclick="switchHajjTab('timeline')" id="tab-btn-timeline" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-emerald-700 text-white shadow-md">
            <i data-lucide="milestone" class="w-4 h-4"></i>
            <span>1. Rangkaian & Kronologi Hari (Timeline)</span>
        </button>
        <button onclick="switchHajjTab('fiqh')" id="tab-btn-fiqh" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="scale" class="w-4 h-4 text-emerald-600"></i>
            <span>2. Rukun, Wajib & Fiqih Dam</span>
        </button>
        <button onclick="switchHajjTab('prayers')" id="tab-btn-prayers" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="message-circle" class="w-4 h-4 text-amber-500"></i>
            <span>3. Pustaka 16 Doa Haji & Audio</span>
        </button>
        <button onclick="switchHajjTab('regulations')" id="tab-btn-regulations" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="shield-alert" class="w-4 h-4 text-blue-600"></i>
            <span>4. Regulasi Kemenhaj RI & Saudi</span>
        </button>
        <button onclick="switchHajjTab('officers')" id="tab-btn-officers" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="user-check" class="w-4 h-4 text-amber-500"></i>
            <span>5. Presensi Petugas PPIH (Bimtek)</span>
        </button>
        <button onclick="switchHajjTab('videos')" id="tab-btn-videos" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="video" class="w-4 h-4 text-rose-500"></i>
            <span>6. Video Simulasi 3D & Manasik</span>
        </button>
        <button onclick="switchHajjTab('quiz')" id="tab-btn-quiz" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="check-square" class="w-4 h-4 text-purple-600"></i>
            <span>7. Checklist & Kuis Evaluasi</span>
        </button>
    </div>

    <!-- TAB 1: RANGKAIAN & KRONOLOGI HAJI (TIMELINE) -->
    <div id="tab-timeline" class="hajj-tab-pane space-y-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-6 h-6 text-emerald-600"></i>
                        <span>Peta Alur Kronologis Ibadah Haji (8 s.d. 13 Dzulhijjah)</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Ikuti alur tahapan haji dari Hari Tarwiyah di Mina, Puncak Wukuf di Arafah, Mabit Muzdalifah, Hari Nahr, hingga Hari Tasyrik.
                    </p>
                </div>
            </div>

            <!-- Timeline Steps Container -->
            <div class="relative border-l-2 border-emerald-400 ml-4 sm:ml-6 space-y-8 sm:space-y-10 pl-6 sm:pl-8">
                @foreach($hajj['timeline'] as $idx => $step)
                    <div class="relative group">
                        <!-- Timeline Icon Node -->
                        <div class="absolute -left-[37px] sm:-left-[45px] top-0 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs sm:text-sm shadow-md group-hover:scale-110 transition-transform">
                            {{ $idx + 1 }}
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/20 transition-all shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[11px] font-black uppercase">
                                        {{ $step['day'] }} • {{ $step['date'] }}
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[11px] font-bold">
                                        {{ $step['badge'] }}
                                    </span>
                                </div>
                                <span class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                    <i data-lucide="compass" class="w-3.5 h-3.5 text-emerald-600"></i>
                                    {{ $step['location'] }}
                                </span>
                            </div>

                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2">
                                {{ $step['title'] }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                                {{ $step['description'] }}
                            </p>

                            <!-- Activities List -->
                            <div class="space-y-2 mb-4">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-700 block">Amalan & Tata Cara Utama:</span>
                                @foreach($step['activities'] as $act)
                                    <div class="flex items-start gap-2 text-xs sm:text-sm text-slate-700">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                                        <span>{{ $act }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Doa Highlight Box with Audio -->
                            <div class="p-3.5 rounded-xl bg-white border border-emerald-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
                                <div>
                                    <div class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider mb-0.5">Bacaan / Doa Penting:</div>
                                    <div class="font-arabic text-base sm:text-lg font-bold text-slate-900">{{ $step['doa'] }}</div>
                                    <div class="text-xs text-slate-600 font-medium mt-0.5">Arti: {{ $step['doa_meaning'] }}</div>
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($step['doa']) }}', 'ar')" class="self-start sm:self-center px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition flex items-center gap-1.5 text-xs font-bold shadow-sm flex-shrink-0">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                    <span>Putar Doa</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Rencana Perjalanan Haji (RPH) 1448 H / 2027 M - Regulasi Resmi Kemenhaj RI -->
        <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 rounded-3xl border border-emerald-800/50 p-6 sm:p-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-emerald-800/40 mb-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold mb-2">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i>
                        <span>Regulasi Resmi: RPH 1448 H / 2027 M</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight flex flex-wrap items-center gap-2">
                        <span>{{ $hajj['rph_timeline']['document_title'] }}</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed">
                        {{ $hajj['rph_timeline']['legal_reference'] }}. Total operasional: <strong>{{ $hajj['rph_timeline']['operational_duration'] }}</strong>.
                    </p>
                </div>

                <a href="{{ $hajj['rph_timeline']['drive_source_url'] }}" target="_blank" rel="noopener noreferrer" class="self-start md:self-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs transition shadow-md flex-shrink-0">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>Buka Dokumen PDF (Google Drive)</span>
                </a>
            </div>

            <!-- Grid 12 Tahapan RPH -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($hajj['rph_timeline']['phases'] as $phase)
                    <div class="p-4 rounded-2xl bg-slate-900/80 border border-emerald-900/60 hover:border-emerald-500/50 transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-950 text-emerald-300 border border-emerald-700/50 text-[10px] font-bold">
                                    {{ $phase['badge'] }}
                                </span>
                                <span class="text-[11px] font-mono text-amber-300 font-semibold">{{ $phase['date_hijriah'] }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-white mb-1.5">{{ $phase['milestone'] }}</h4>
                            <div class="text-xs text-emerald-400 font-semibold mb-2 flex items-center gap-1">
                                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                <span>{{ $phase['date_masehi'] }}</span>
                            </div>
                            <p class="text-xs text-slate-300 leading-relaxed">{{ $phase['summary'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 2: RUKUN, WAJIB & FIQIH HAJI -->
    <div id="tab-fiqh" class="hajj-tab-pane hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- 6 Rukun Haji (Tidak Bisa Diganti Dam) -->
            <div class="bg-white rounded-3xl border border-rose-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="alert-octagon" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">6 Rukun Haji (Mutlak Wajib)</h3>
                </div>
                <p class="text-xs text-slate-500 mb-6">
                    Rukun adalah tiang amalan haji yang <strong>tidak sah haji jika salah satunya ditinggalkan</strong>, dan <strong>TIDAK DAPAT diganti dengan Dam (denda)</strong>.
                </p>

                <div class="space-y-3.5">
                    @foreach($hajj['fiqh']['rukun'] as $r)
                        <div class="p-3.5 rounded-xl bg-rose-50/50 border border-rose-100 flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-rose-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                {{ $r['num'] }}
                            </span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $r['name'] }}</h4>
                                <p class="text-xs text-slate-600 mt-0.5">{{ $r['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 6 Wajib Haji (Pelanggaran Wajib Dam) -->
            <div class="bg-white rounded-3xl border border-amber-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="shield" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">6 Wajib Haji</h3>
                </div>
                <p class="text-xs text-slate-500 mb-6">
                    Wajib haji adalah amalan yang wajib dikerjakan. Jika tertinggal (karena uzur atau lupa), <strong>hajinya tetap sah namun berdosa dan wajib membayar Dam (denda)</strong>.
                </p>

                <div class="space-y-3.5">
                    @foreach($hajj['fiqh']['wajib'] as $w)
                        <div class="p-3.5 rounded-xl bg-amber-50/50 border border-amber-100 flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg bg-amber-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                {{ $w['num'] }}
                            </span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $w['name'] }}</h4>
                                <p class="text-xs text-slate-600 mt-0.5">{{ $w['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Perbandingan 3 Jenis Haji: Tamattu' vs Ifrad vs Qiran -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                <i data-lucide="layers" class="w-5 h-5 text-emerald-600"></i>
                <span>Tiga Jenis Pelaksanaan Haji (Tamattu', Ifrad, Qiran)</span>
            </h3>
            <p class="text-xs sm:text-sm text-slate-500 mb-6">
                Pahami perbedaan niat, alur pelaksanaan, dan konsekuensi denda/dam pada masing-masing jenis haji.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($hajj['fiqh']['types'] as $tp)
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-between hover:border-emerald-500 hover:shadow-md transition">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase mb-2 inline-block">
                                Fiqih Haji
                            </span>
                            <h4 class="text-base font-bold text-slate-900 mb-2">{{ $tp['name'] }}</h4>
                            <p class="text-xs text-slate-600 leading-relaxed mb-4">{{ $tp['desc'] }}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 text-xs">
                            <div class="font-bold text-amber-800 mb-1">Status Dam:</div>
                            <div class="text-slate-700">{{ $tp['hukum_dam'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Larangan Ihram -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="ban" class="w-5 h-5 text-rose-600"></i>
                <span>Larangan-Larangan Selama Berihram</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Khusus Pria -->
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-blue-900 mb-2 flex items-center gap-1.5">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>Khusus Pria:</span>
                    </h4>
                    <ul class="space-y-1.5 text-xs text-slate-700">
                        @foreach($hajj['fiqh']['larangan_ihram']['pria'] as $lp)
                            <li class="flex items-start gap-1.5">
                                <span class="text-rose-500 font-bold">&bull;</span>
                                <span>{{ $lp }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Khusus Wanita -->
                <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-purple-900 mb-2 flex items-center gap-1.5">
                        <i data-lucide="user-check" class="w-4 h-4"></i>
                        <span>Khusus Wanita:</span>
                    </h4>
                    <ul class="space-y-1.5 text-xs text-slate-700">
                        @foreach($hajj['fiqh']['larangan_ihram']['wanita'] as $lw)
                            <li class="flex items-start gap-1.5">
                                <span class="text-rose-500 font-bold">&bull;</span>
                                <span>{{ $lw }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Bersama Pria & Wanita -->
                <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-rose-900 mb-2 flex items-center gap-1.5">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Pria & Wanita:</span>
                    </h4>
                    <ul class="space-y-1.5 text-xs text-slate-700">
                        @foreach($hajj['fiqh']['larangan_ihram']['bersama'] as $lb)
                            <li class="flex items-start gap-1.5">
                                <span class="text-rose-500 font-bold">&bull;</span>
                                <span>{{ $lb }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- PANDUAN FIQIH KHUSUS PETUGAS HAJI (KEMENHAJ & KEMENAG RI) -->
        <div class="bg-gradient-to-br from-amber-500/10 via-slate-50 to-emerald-500/10 rounded-3xl border border-amber-300 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-amber-200 mb-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-xs font-bold mb-2">
                        <i data-lucide="award" class="w-3.5 h-3.5 text-amber-600"></i>
                        <span>Fiqih Tematik: Panduan Petugas Haji</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        {{ $hajj['officer_fiqh']['title'] }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                        Riset berdasarkan buku pedoman resmi manasik haji Kementerian Agama RI dan regulasi Ditjen Pelayanan Haji Kementerian Haji dan Umrah RI.
                    </p>
                </div>
            </div>

            <!-- Dalil Ibadah Muta'addiyah & Doa Isytirath -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Box 1: Kaidah Muta'addiyah -->
                <div class="p-5 rounded-2xl bg-white border border-amber-200 shadow-2xs">
                    <span class="text-[10px] font-bold text-amber-800 uppercase tracking-wider block mb-1">Kaidah Fiqih Pelayanan Jemaah:</span>
                    <div class="font-arabic text-xl font-bold text-slate-900 mb-1" dir="rtl">
                        {{ $hajj['officer_fiqh']['legal_foundations']['dalil_social_worship']['arabic'] }}
                    </div>
                    <div class="text-xs text-amber-800 font-semibold mb-1 italic">
                        "{{ $hajj['officer_fiqh']['legal_foundations']['dalil_social_worship']['latin'] }}"
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ $hajj['officer_fiqh']['legal_foundations']['dalil_social_worship']['meaning'] }}
                    </p>
                </div>

                <!-- Box 2: Doa Niat Isytirath -->
                <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider">Lafadz Niat Bersyarat (Isytirath):</span>
                            <button type="button" onclick="speakText('{{ addslashes($hajj['officer_fiqh']['legal_foundations']['isytirath_prayer']['arabic']) }}', 'ar')" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-sm">
                                <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <div class="font-arabic text-lg font-bold text-slate-900 mb-1" dir="rtl">
                            {{ $hajj['officer_fiqh']['legal_foundations']['isytirath_prayer']['arabic'] }}
                        </div>
                        <div class="text-xs text-emerald-700 font-semibold mb-1 italic">
                            "{{ $hajj['officer_fiqh']['legal_foundations']['isytirath_prayer']['latin'] }}"
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $hajj['officer_fiqh']['legal_foundations']['isytirath_prayer']['meaning'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- 6 Butir Fiqih Petugas Haji -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($hajj['officer_fiqh']['principles'] as $principle)
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-amber-400 transition shadow-2xs">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-2 flex items-center gap-1.5 text-amber-950">
                            <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                            <span>{{ $principle['topic'] }}</span>
                        </h4>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $principle['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 3: PUSTAKA 16 DOA HAJI & AUDIO -->
    <div id="tab-prayers" class="hajj-tab-pane hidden space-y-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                        <i data-lucide="volume-2" class="w-6 h-6 text-amber-500"></i>
                        <span>Pustaka Doa-Doa Manasik Haji Lengkap</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Teks Arab berharakat, transliterasi huruf abjad Latin, terjemahan bahasa Indonesia resmi, dan tombol pelafalan audio Google Translate Voice.
                    </p>
                </div>
            </div>

            <!-- Grid of 16 Prayers -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($hajj['prayers'] as $prayer)
                    <div class="p-5 sm:p-6 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-emerald-400 hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div>
                                    <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase">
                                        Doa Haji
                                    </span>
                                    <h3 class="text-base sm:text-lg font-bold text-slate-900 mt-1">
                                        {{ $prayer['title'] }}
                                    </h3>
                                    <span class="text-[11px] text-slate-400 font-semibold block mb-2">
                                        {{ $prayer['occasion'] }}
                                    </span>
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($prayer['audio'] ?? $prayer['arabic']) }}', 'ar')" class="p-2.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-sm flex-shrink-0" title="Dengarkan Pengucapan Penutur Asli">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <!-- Arabic Text -->
                            <div class="p-4 rounded-xl bg-white border border-slate-200 mb-3 text-right" dir="rtl">
                                <span class="font-arabic text-xl sm:text-2xl font-bold text-slate-900 leading-loose">
                                    {{ $prayer['arabic'] }}
                                </span>
                            </div>

                            <!-- Latin Transliteration -->
                            <div class="text-xs text-emerald-700 font-semibold mb-2 leading-relaxed">
                                <span class="text-slate-400 font-bold uppercase text-[10px] block">Pelafalan Abjad Latin:</span>
                                {{ $prayer['trans'] }}
                            </div>

                            <!-- Indonesian Translation -->
                            <div class="text-xs text-slate-600 leading-relaxed bg-slate-100/70 p-3 rounded-xl border border-slate-200">
                                <span class="text-slate-500 font-bold uppercase text-[10px] block mb-0.5">Terjemahan Bahasa Indonesia:</span>
                                "{{ $prayer['meaning'] }}"
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 4: ATURAN RESMI KEMENHAJ RI & SAUDI (NUSUK) -->
    <div id="tab-regulations" class="hajj-tab-pane hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Regulasi Kementerian Haji dan Umrah RI -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                            <i data-lucide="landmark" class="w-4 h-4"></i>
                        </span>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900">Kementerian Haji dan Umrah RI</h3>
                    </div>
                    <a href="https://haji.go.id/regulasi" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold hover:bg-emerald-100 transition">
                        <span>haji.go.id</span>
                        <i data-lucide="external-link" class="w-3 h-3"></i>
                    </a>
                </div>
                <div class="text-xs text-emerald-700 font-bold mb-4">
                    {{ $hajj['regulations']['indonesia']['legal_basis'] }}
                </div>

                <div class="space-y-4">
                    @foreach($hajj['regulations']['indonesia']['rules'] as $rule)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <h4 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                    <i data-lucide="check" class="w-4 h-4 text-emerald-600"></i>
                                    <span>{{ $rule['topic'] }}</span>
                                </h4>
                                @if(!empty($rule['badge']))
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold border border-emerald-200">
                                        {{ $rule['badge'] }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $rule['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Regulasi Arab Saudi (Nusuk & Masyair) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-lg sm:text-xl font-bold text-slate-900">Regulasi Kerajaan Arab Saudi</h3>
                </div>
                <div class="text-xs text-blue-700 font-bold mb-4">
                    {{ $hajj['regulations']['saudi']['authority'] }}
                </div>

                <div class="space-y-4">
                    @foreach($hajj['regulations']['saudi']['rules'] as $rule)
                        <div class="p-4 rounded-2xl bg-blue-50/40 border border-blue-200">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <h4 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                    <i data-lucide="alert-circle" class="w-4 h-4 text-blue-600"></i>
                                    <span>{{ $rule['topic'] }}</span>
                                </h4>
                                @if(!empty($rule['badge']))
                                    <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold border border-blue-200">
                                        {{ $rule['badge'] }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $rule['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 5: PORTAL PRESENSI PETUGAS PPIH (BIMTEK KEMENHAJ RI) -->
    <div id="tab-officers" class="hajj-tab-pane hidden space-y-6">
        <div class="bg-slate-950 text-white rounded-3xl border border-slate-800 p-6 sm:p-8 shadow-2xl relative overflow-hidden">
            <!-- Header Portal Kementerian Haji dan Umrah RI -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 to-yellow-400 text-slate-950 flex items-center justify-center font-black shadow-lg">
                        <i data-lucide="shield-check" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <div class="text-base sm:text-lg font-black tracking-wide text-amber-400 uppercase">
                            {{ $hajj['officers_portal']['institution'] }}
                        </div>
                        <div class="text-xs font-bold text-slate-400 tracking-wider">
                            {{ $hajj['officers_portal']['country'] }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs font-semibold">
                    <span class="px-3 py-1.5 rounded-xl bg-slate-900 text-slate-400 hover:text-white cursor-pointer">Biodata</span>
                    <span class="px-3.5 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 border border-amber-500/40 font-bold">Presensi</span>
                    <span class="px-3 py-1.5 rounded-xl bg-slate-900 text-slate-400 hover:text-white cursor-pointer flex items-center gap-1.5">
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-blue-400"></i>
                        <span>Dashboard</span>
                    </span>
                </div>
            </div>

            <!-- Title & Search Area -->
            <div class="py-6 max-w-2xl mx-auto text-center">
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-wider mb-2 uppercase">
                    Presensi Petugas
                </h2>
                <p class="text-xs text-slate-400 mb-6">
                    Sistem Terintegrasi Presensi Digital Bimbingan Teknis (Bimtek) Petugas Penyelenggara Ibadah Haji (PPIH).
                </p>

                <!-- Search Input matching User's uploaded screenshot -->
                <div class="flex items-center gap-2 bg-slate-900 p-2 rounded-2xl border border-slate-800 shadow-inner">
                    <input type="text" id="officerSearchInput" value="{{ $hajj['officers_portal']['sample_officer']['registration_id'] }}" placeholder="Masukkan Nomor Registrasi Petugas..." class="w-full bg-transparent px-4 py-2.5 text-sm font-mono text-white focus:outline-none">
                    <button type="button" onclick="performOfficerSearch()" class="px-6 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs flex items-center gap-1.5 transition shadow-md flex-shrink-0">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </div>

            <!-- Officer Profile Card -->
            <div id="officerProfileCard" class="max-w-3xl mx-auto rounded-3xl bg-slate-900/90 border border-slate-800 p-6 sm:p-8 backdrop-blur-md shadow-xl">
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold mb-6">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                    <span>Data ditemukan</span>
                </div>

                <!-- Info Table Rows -->
                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800/80 gap-1">
                        <span class="text-slate-400 font-medium">Nama</span>
                        <span class="font-bold text-white text-base">{{ $hajj['officers_portal']['sample_officer']['name'] }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800/80 gap-1">
                        <span class="text-slate-400 font-medium">Jenis Petugas</span>
                        <span class="font-semibold text-slate-200">{{ $hajj['officers_portal']['sample_officer']['officer_type'] }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800/80 gap-1">
                        <span class="text-slate-400 font-medium">Jenis Layanan</span>
                        <span class="font-semibold text-slate-200">{{ $hajj['officers_portal']['sample_officer']['service_type'] }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800/80 gap-1">
                        <span class="text-slate-400 font-medium">Tanggal</span>
                        <span class="font-semibold text-slate-300 font-mono">{{ $hajj['officers_portal']['sample_officer']['date'] }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800/80 gap-1">
                        <span class="text-slate-400 font-medium">Presensi hari ini</span>
                        <span class="font-bold text-amber-300">{{ $hajj['officers_portal']['sample_officer']['attendance_summary'] }}</span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-800/80 gap-2">
                        <span class="text-slate-400 font-medium">Sesi sudah presensi</span>
                        <div class="flex items-center gap-2">
                            @foreach($hajj['officers_portal']['sample_officer']['attended_sessions'] as $sess)
                                <span class="px-3 py-1 rounded-full bg-emerald-950/80 text-emerald-300 border border-emerald-600/50 text-xs font-bold">
                                    {{ $sess }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Jadwal Sesi Hari Ini (Pills) -->
                    <div class="py-2">
                        <span class="text-slate-400 font-medium block mb-2">Jadwal sesi hari ini</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($hajj['officers_portal']['sample_officer']['sessions_schedule'] as $sched)
                                <span class="px-3 py-1.5 rounded-full border text-xs font-semibold {{ $sched['color'] }}">
                                    {{ $sched['session'] }} • {{ $sched['class'] }} • {{ $sched['status'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Detail Materi, Kelas, Narasumber & Moderator -->
                    <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800 space-y-2 mt-4">
                        <div class="flex items-center justify-between text-xs font-bold text-amber-400 mb-1">
                            <span>Materi, Kelas, Narasumber & Moderator</span>
                            <span>{{ $hajj['officers_portal']['sample_officer']['current_detail']['session_title'] }}</span>
                        </div>
                        <div class="text-sm font-bold text-white">
                            Materi: {{ $hajj['officers_portal']['sample_officer']['current_detail']['subject'] }}
                        </div>
                        <div class="text-xs text-slate-300">
                            Kelas: {{ $hajj['officers_portal']['sample_officer']['current_detail']['class_name'] }}
                        </div>
                        <div class="text-xs text-slate-300">
                            Narasumber: <span class="text-amber-200 font-semibold">{{ $hajj['officers_portal']['sample_officer']['current_detail']['speaker'] }}</span>
                        </div>
                        <div class="text-xs text-slate-300">
                            Moderator: <span class="text-slate-200 font-semibold">{{ $hajj['officers_portal']['sample_officer']['current_detail']['moderator'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6 Pilar Bidang Layanan Tusi Petugas PPIH -->
            <div class="mt-8 pt-8 border-t border-slate-800">
                <h3 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i data-lucide="users-round" class="w-4 h-4 text-amber-400"></i>
                    <span>Tugas dan Fungsi (Tusi) Layanan Petugas Haji Kementerian Haji dan Umrah RI</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($hajj['officers_portal']['tusi_categories'] as $tusi)
                        <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 text-xs">
                            <div class="font-bold text-amber-300 mb-1 flex items-center gap-1.5">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span>{{ $tusi['name'] }}</span>
                            </div>
                            <div class="text-slate-400 leading-relaxed">{{ $tusi['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 5: VIDEO SIMULASI 3D & MANASIK -->
    <div id="tab-videos" class="hajj-tab-pane hidden space-y-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                    <i data-lucide="play-circle" class="w-6 h-6 text-rose-600"></i>
                    <span>Simulasi Visual 3D & Video Manasik Terverifikasi</span>
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Saksikan simulasi visual animasi 3D dan rekaman bimbingan resmi untuk memvisualisasikan gerak langkah jemaah di tanah suci.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($hajj['videos'] as $vid)
                    <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50 flex flex-col justify-between shadow-sm hover:shadow-md transition">
                        <div>
                            <!-- 16:9 Responsive Video Embed Container -->
                            <div class="relative w-full pb-[56.25%] bg-slate-900">
                                <iframe src="{{ $vid['embed_url'] }}" title="{{ $vid['title'] }}" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>

                            <div class="p-5">
                                <div class="flex items-center justify-between text-[11px] font-bold text-slate-500 mb-1.5">
                                    <span class="text-emerald-700">{{ $vid['source'] }}</span>
                                    <span>{{ $vid['duration'] }}</span>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mb-2 leading-snug">
                                    {{ $vid['title'] }}
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ $vid['desc'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 6: CHECKLIST & KUIS EVALUASI -->
    <div id="tab-quiz" class="hajj-tab-pane hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Checklist Kesiapan Haji Interaktif (LocalStorage) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5 text-emerald-600"></i>
                        <span>Checklist Kesiapan Manasik</span>
                    </h3>
                    <span id="checklistProgress" class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">0 / 8 Selesai</span>
                </div>
                <p class="text-xs text-slate-500 mb-4">
                    Centang setiap amalan yang sudah Anda kuasai. Progres tersimpan otomatis di perangkat Anda.
                </p>

                <div class="space-y-2.5" id="hajjChecklistItems">
                    @php
                        $items = [
                            'Memahami 6 Rukun Haji yang tidak boleh ditinggalkan',
                            'Memahami 6 Wajib Haji dan konsekuensi denda Dam',
                            'Menghafal Niat Ihram dan Bacaan Talbiyah dengan benar',
                            'Memahami urutan wukuf di Arafah 9 Dzulhijjah',
                            'Mengetahui tata cara mabit di Muzdalifah dan pengambilan kerikil',
                            'Mengetahui urutan melontar jumrah (Aqabah, Ula, Wustha)',
                            'Memahami tata cara Tawaf Ifadhah dan Sa\'i',
                            'Mengetahui larangan ihram serta aturan Smart Card Nusuk',
                        ];
                    @endphp
                    @foreach($items as $i => $itemText)
                        <label class="flex items-start p-3 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-emerald-50/50 cursor-pointer transition">
                            <input type="checkbox" onchange="updateChecklistProgress()" class="hajj-check w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500 mt-0.5 mr-3" id="chk-{{ $i }}">
                            <span class="text-xs sm:text-sm font-semibold text-slate-800">{{ $itemText }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Kuis Evaluasi Pemahaman Haji -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i data-lucide="help-circle" class="w-5 h-5 text-purple-600"></i>
                        <span>Kuis Evaluasi Fiqih Haji</span>
                    </h3>
                    <span class="text-xs font-bold text-slate-400">5 Soal Praktis</span>
                </div>

                <div class="space-y-5" id="hajjQuizContainer">
                    @foreach($hajj['quiz'] as $q)
                        <div class="p-4 rounded-2xl bg-purple-50/40 border border-purple-200" id="quiz-box-{{ $q['id'] }}">
                            <p class="text-xs sm:text-sm font-bold text-slate-900 mb-3">{{ $q['id'] }}. {{ $q['question'] }}</p>

                            <div class="space-y-2 mb-3">
                                @foreach($q['options'] as $opt)
                                    <button type="button" onclick="checkHajjQuizAnswer('{{ $q['id'] }}', '{{ addslashes($opt) }}', '{{ addslashes($q['correct']) }}', '{{ addslashes($q['explanation']) }}')" class="hajj-opt-{{ $q['id'] }} w-full text-left p-3 rounded-xl border border-slate-200 bg-white hover:bg-purple-100/50 text-xs font-semibold text-slate-700 transition">
                                        {{ $opt }}
                                    </button>
                                @endforeach
                            </div>
                            <div id="quiz-feedback-{{ $q['id'] }}" class="hidden text-xs font-semibold p-3 rounded-xl leading-relaxed"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function switchHajjTab(tabName) {
        document.querySelectorAll('.hajj-tab-pane').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.hajj-tab-btn').forEach(btn => {
            btn.classList.remove('bg-emerald-700', 'text-white', 'shadow-md');
            btn.classList.add('bg-white', 'text-slate-700', 'border', 'border-slate-200');
        });

        const activePane = document.getElementById('tab-' + tabName);
        const activeBtn = document.getElementById('tab-btn-' + tabName);

        if (activePane) activePane.classList.remove('hidden');
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
            activeBtn.classList.add('bg-emerald-700', 'text-white', 'shadow-md');
        }

        // Simpan URL state
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);
    }

    function checkHajjQuizAnswer(qId, selected, correct, explanation) {
        const feedback = document.getElementById('quiz-feedback-' + qId);
        if (!feedback) return;

        feedback.classList.remove('hidden', 'bg-emerald-100', 'text-emerald-800', 'bg-rose-100', 'text-rose-800');

        if (selected.trim() === correct.trim()) {
            feedback.classList.add('bg-emerald-100', 'text-emerald-800');
            feedback.innerHTML = '<span class="font-bold">✓ Benar Sekali!</span> ' + explanation;
        } else {
            feedback.classList.add('bg-rose-100', 'text-rose-800');
            feedback.innerHTML = '<span class="font-bold">✗ Belum Tepat.</span> ' + explanation;
        }
    }

    function updateChecklistProgress() {
        const checkboxes = document.querySelectorAll('.hajj-check');
        let checkedCount = 0;
        const state = {};

        checkboxes.forEach((cb, idx) => {
            if (cb.checked) checkedCount++;
            state['chk_' + idx] = cb.checked;
        });

        const label = document.getElementById('checklistProgress');
        if (label) {
            label.innerText = `${checkedCount} / ${checkboxes.length} Selesai`;
        }

        localStorage.setItem('linguapro_hajj_checklist', JSON.stringify(state));
    }

    function loadChecklistState() {
        const saved = localStorage.getItem('linguapro_hajj_checklist');
        if (!saved) return;
        try {
            const state = JSON.parse(saved);
            const checkboxes = document.querySelectorAll('.hajj-check');
            checkboxes.forEach((cb, idx) => {
                if (state['chk_' + idx]) cb.checked = true;
            });
            updateChecklistProgress();
        } catch(e) {}
    }

    function performOfficerSearch() {
        const input = document.getElementById('officerSearchInput');
        const val = input ? input.value.trim() : '';
        const card = document.getElementById('officerProfileCard');
        if (!val) {
            alert('Silakan masukkan nomor registrasi petugas.');
            return;
        }

        if (card) {
            card.classList.add('animate-pulse', 'border-amber-400');
            setTimeout(() => {
                card.classList.remove('animate-pulse');
            }, 600);
        }

        showAudioToast(`Data Petugas Terverifikasi Siskohat: ${val}`);
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadChecklistState();
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab');
        if (tab && document.getElementById('tab-' + tab)) {
            switchHajjTab(tab);
        }
    });
</script>
@endpush
@endsection
