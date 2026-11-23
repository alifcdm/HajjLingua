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
                Riset menyeluruh seluruh rangkaian ibadah haji, dokumen resmi Keputusan Dirjen Pelayanan Haji No. 26 Tahun 2026 (RPH 1448 H / 2027 M), modul Bimtek Pelatihan Petugas PPIH 1448 H / 2027 M, hukum fiqih 4 mazhab, doa berharakat dengan audio penutur asli, dan regulasi Smart Card Nusuk Arab Saudi.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold">
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-600"></i>
                <span>Standar Kemenhaj RI 1448H & Nusuk KSA</span>
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
            <span>1. Alur Kronologi & RPH 1448 H (24 Agenda)</span>
        </button>
        <button onclick="switchHajjTab('ppih')" id="tab-btn-ppih" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="badge-check" class="w-4 h-4 text-amber-600"></i>
            <span>2. Bimtek & Manasik Petugas PPIH 1448 H</span>
        </button>
        <button onclick="switchHajjTab('fiqh')" id="tab-btn-fiqh" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="scale" class="w-4 h-4 text-emerald-600"></i>
            <span>3. Rukun, Wajib & Fiqih Dam</span>
        </button>
        <button onclick="switchHajjTab('prayers')" id="tab-btn-prayers" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="message-circle" class="w-4 h-4 text-amber-500"></i>
            <span>4. Pustaka 16 Doa Haji & Audio</span>
        </button>
        <button onclick="switchHajjTab('regulations')" id="tab-btn-regulations" class="hajj-tab-btn px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:border-emerald-500">
            <i data-lucide="shield-alert" class="w-4 h-4 text-blue-600"></i>
            <span>5. Regulasi Kemenhaj RI & Saudi</span>
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

    <!-- TAB 1: RANGKAIAN KRONOLOGI & RPH 1448 H (24 AGENDA LENGKAP) -->
    <div id="tab-timeline" class="hajj-tab-pane space-y-8">
        
        <!-- Section Rencana Perjalanan Haji 1448 H / 2027 M Lengkap -->
        <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 rounded-3xl border border-emerald-800/50 p-6 sm:p-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-6 border-b border-emerald-800/40 mb-6">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold mb-2">
                        <i data-lucide="file-check-2" class="w-3.5 h-3.5"></i>
                        <span>Dokumen Resmi: Keputusan Dirjen Pelayanan Haji No. 26 Tahun 2026</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-white tracking-tight">
                        {{ $hajj['rph_timeline']['document_title'] }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-3xl leading-relaxed">
                        Ditandatangani oleh <strong>{{ $hajj['rph_timeline']['signatory'] }}</strong>. Menjadi pedoman resmi mobilisasi, operasional pemberangkatan, masa tinggal, dan pemulangan seluruh jemaah haji Indonesia tahun 1448 H / 2027 M.
                    </p>
                </div>

                <a href="{{ $hajj['rph_timeline']['drive_source_url'] }}" target="_blank" rel="noopener noreferrer" class="self-start md:self-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs transition shadow-md flex-shrink-0">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span>Unduh PDF Asli (Google Drive)</span>
                </a>
            </div>

            <!-- Key Metrics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-300 block mb-1">Masa Operasional Terbang:</span>
                    <div class="text-sm font-black text-white">{{ $hajj['rph_timeline']['operational_summary']['masa_pemberangkatan'] }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300 block mb-1">Masa Pemulangan:</span>
                    <div class="text-sm font-black text-white">{{ $hajj['rph_timeline']['operational_summary']['masa_pemulangan'] }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-teal-300 block mb-1">Rata-Rata Masa Tinggal:</span>
                    <div class="text-sm font-black text-white">{{ $hajj['rph_timeline']['operational_summary']['masa_tinggal'] }}</div>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-300 block mb-1">Closing Date Bandara Saudi:</span>
                    <div class="text-sm font-black text-white">{{ $hajj['rph_timeline']['operational_summary']['closing_date'] }}</div>
                </div>
            </div>

            <!-- 24-Agenda Interactive Table Filter -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-amber-400"></i>
                    <h3 class="text-sm font-bold text-white">Kalender & 24 Kegiatan Operasional Resmi:</h3>
                </div>
                <div class="text-xs text-slate-400 font-medium">
                    10 April 2027 s.d. 20 Juni 2027 (03 Dzulqa'idah 1448 s.d. 15 Muharram 1449)
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-emerald-800/40 bg-slate-950/60 shadow-inner">
                <table class="w-full text-left text-xs text-slate-200">
                    <thead class="bg-emerald-950/80 text-emerald-300 border-b border-emerald-800/50 uppercase text-[10px] font-black tracking-wider">
                        <tr>
                            <th class="py-3 px-3 text-center w-12">No</th>
                            <th class="py-3 px-4 w-36">Kalender Masehi</th>
                            <th class="py-3 px-4 w-44">Kalender Hijriah</th>
                            <th class="py-3 px-4">Uraian Kegiatan Resmi Kemenhaj RI</th>
                            <th class="py-3 px-3 w-40 text-center">Fase / Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-900/30">
                        @foreach($hajj['rph_timeline']['events'] as $ev)
                            @php
                                $isHighlight = in_array($ev['no'], [1, 2, 8, 10, 11, 15, 21, 24]);
                                $rowBg = $isHighlight ? 'bg-emerald-900/20 hover:bg-emerald-900/40 font-semibold' : 'hover:bg-white/5';
                            @endphp
                            <tr class="{{ $rowBg }} transition">
                                <td class="py-3 px-3 text-center font-bold font-mono text-emerald-400">{{ $ev['no'] }}</td>
                                <td class="py-3 px-4 font-bold text-white whitespace-nowrap">{{ $ev['miladiyah'] }}</td>
                                <td class="py-3 px-4 font-mono text-amber-300 whitespace-nowrap">{{ $ev['hijriah'] }}</td>
                                <td class="py-3 px-4 leading-relaxed">
                                    <span class="text-slate-100">{{ $ev['activity'] }}</span>
                                </td>
                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-900/60 text-emerald-300 border border-emerald-700/50 text-[10px] font-semibold">
                                        {{ $ev['badge'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Alur Kronologis Manasik Haji 8 s.d. 13 Dzulhijjah -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-6 h-6 text-emerald-600"></i>
                        <span>Peta Alur Kronologis Ibadah Haji Jemaah (8 s.d. 13 Dzulhijjah)</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Tahapan puncak manasik: Hari Tarwiyah di Mina, Puncak Wukuf di Padang Arafah, Mabit Muzdalifah, Hari Nahr, hingga Hari Tasyrik.
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
    </div>

    <!-- TAB 2: BIMTEK & MANASIK HAJI PETUGAS PPIH 1448 H / 2027 M (DOKUMEN RESMI PELATIHAN) -->
    <div id="tab-ppih" class="hajj-tab-pane hidden space-y-8">
        
        <!-- Header Banner Bimtek Petugas -->
        <div class="rounded-3xl bg-gradient-to-r from-emerald-900 via-teal-900 to-amber-950 p-6 sm:p-8 text-white shadow-xl border border-amber-500/30">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase tracking-wider mb-3 inline-block">
                        Materi Pelatihan PPIH 1448 H / 2027 M (Slide Resmi)
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $hajj['ppih_bimtek']['title'] }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-200 mt-1 max-w-3xl leading-relaxed">
                        Riset mendalam dari materi presentasi resmi Kementerian Haji dan Umrah RI: Pedoman Ihram, Miqat, Thawaf, Sa'i, Tahallul, hingga Penugasan Operasional Petugas Duyufurrahman.
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="px-3 py-1.5 rounded-xl bg-white/10 border border-white/20 text-amber-300 text-xs font-bold flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        <span>Standar Kompetensi Petugas RI</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- 1. Empat Pilar Struktur PPIH & Prinsip "Bisakah Petugas Berhaji?" -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- 4 Jenis PPIH -->
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="users" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-lg font-bold text-slate-900">1. Struktur 4 Jenis Petugas PPIH</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    @foreach($hajj['ppih_bimtek']['structure_types'] as $st)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-400 transition flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <h4 class="text-sm font-bold text-slate-900">{{ $st['title'] }}</h4>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $st['badge'] }}</span>
                                </div>
                                <div class="text-[11px] font-semibold text-emerald-700 mb-1.5">{{ $st['scope'] }}</div>
                                <p class="text-xs text-slate-600 leading-relaxed">{{ $st['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Fiqih: Bisakah PPIH Berhaji? -->
            <div class="bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-slate-50 rounded-3xl border border-amber-300 p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-sm">
                            <i data-lucide="help-circle" class="w-4 h-4"></i>
                        </span>
                        <h3 class="text-lg font-bold text-slate-900">2. Bisakah PPIH Berhaji?</h3>
                    </div>
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 mb-4 text-xs font-semibold text-amber-950 leading-relaxed">
                        "{{ $hajj['ppih_bimtek']['can_officer_hajj']['main_principle'] }}"
                    </div>
                    <div class="space-y-3">
                        @foreach($hajj['ppih_bimtek']['can_officer_hajj']['rules'] as $rule)
                            <div class="p-3 rounded-xl bg-white border border-slate-200">
                                <span class="text-xs font-bold text-slate-900 block mb-0.5">{{ $rule['point'] }}</span>
                                <p class="text-[11px] text-slate-600 leading-relaxed">{{ $rule['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Sunnah Ihram, Tempat Mandi Petugas & Niat Miqat -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sunnah Ihram & Lokasi Mandi Persiapan -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-lg font-bold text-slate-900">3. Sunnah-Sunnah Ihram & Titik Persiapan Petugas</h3>
                </div>

                <div class="space-y-2 mb-5">
                    <span class="text-xs font-bold text-slate-800 block">5 Amalan Sunnah Sebelum Berniat Ihram:</span>
                    @foreach($hajj['ppih_bimtek']['sunnah_ihram']['practices'] as $pr)
                        <div class="flex items-start gap-2 text-xs text-slate-700 p-2 rounded-lg bg-slate-50 border border-slate-100">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                            <span>{{ $pr }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200">
                    <span class="text-[11px] font-bold text-emerald-900 uppercase tracking-wider block mb-2">Lokasi Mandi & Persiapan Berdasarkan Penugasan Petugas:</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        @foreach($hajj['ppih_bimtek']['sunnah_ihram']['locations'] as $loc)
                            <div class="p-2.5 rounded-xl bg-white border border-emerald-100 text-xs">
                                <span class="font-bold text-slate-900 block mb-0.5">{{ $loc['group'] }}</span>
                                <div class="text-emerald-700 font-semibold">{{ $loc['location'] }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">{{ $loc['timing'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Niat Ihram, Titik Miqat & Niat Isytirath -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="navigation" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-lg font-bold text-slate-900">4. Niat Ihram, Titik Miqat Petugas & Doa Isytirath</h3>
                </div>

                <!-- Lafaz Niat Berharakat & Audio -->
                <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200 mb-4">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="text-[11px] font-bold text-amber-900 uppercase">Lafadz Niat Ihram Umrah:</span>
                        <button type="button" onclick="speakText('{{ addslashes($hajj['ppih_bimtek']['niat_miqat']['doa_ihram']['arabic_1']) }}', 'ar')" class="p-1.5 rounded-lg bg-amber-100 text-amber-800 hover:bg-amber-600 hover:text-white transition shadow-xs">
                            <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                        </button>
                    </div>
                    <div class="font-arabic text-xl font-bold text-slate-900 mb-1" dir="rtl">
                        {{ $hajj['ppih_bimtek']['niat_miqat']['doa_ihram']['arabic_1'] }}
                    </div>
                    <div class="text-xs text-amber-800 italic mb-1 font-semibold">
                        "{{ $hajj['ppih_bimtek']['niat_miqat']['doa_ihram']['latin_1'] }}"
                    </div>
                    <div class="text-xs text-slate-600">
                        Artinya: {{ $hajj['ppih_bimtek']['niat_miqat']['doa_ihram']['meaning_1'] }}
                    </div>
                </div>

                <!-- Miqat Locations for Officers -->
                <div class="space-y-2 mb-3">
                    <span class="text-xs font-bold text-slate-800 block">Titik Miqat Resmi Petugas PPIH:</span>
                    @foreach($hajj['ppih_bimtek']['niat_miqat']['miqat_rules'] as $mr)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="font-bold text-slate-900">{{ $mr['group'] }}</span>
                                <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-[10px] font-bold">{{ $mr['location'] }}</span>
                            </div>
                            <div class="text-slate-600">{{ $mr['notes'] }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="p-3 rounded-xl bg-slate-100 text-[11px] text-slate-600 leading-relaxed border border-slate-200">
                    💡 <strong>Catatan Khusus Petugas Wanita:</strong> {{ $hajj['ppih_bimtek']['niat_miqat']['special_notes'] }}
                </div>
            </div>
        </div>

        <!-- 3. Larangan Ihram & Hal yang Diperbolehkan Saat Ihram -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-sm">
                    <i data-lucide="ban" class="w-4 h-4"></i>
                </span>
                <h3 class="text-xl font-bold text-slate-900">5. Larangan Ihram & Hal-Hal yang Diperbolehkan</h3>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Laki-laki dilarang -->
                <div class="p-5 rounded-2xl bg-rose-50/40 border border-rose-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-rose-900 mb-3 flex items-center gap-1.5">
                        <i data-lucide="user" class="w-4 h-4 text-rose-600"></i>
                        <span>Laki-Laki Dilarang:</span>
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-700">
                        @foreach($hajj['ppih_bimtek']['larangan_ihram']['laki_laki'] as $ll)
                            <li class="flex items-start gap-1.5">
                                <span class="text-rose-500 font-bold">&bull;</span>
                                <span>{{ $ll }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Perempuan dilarang -->
                <div class="p-5 rounded-2xl bg-purple-50/40 border border-purple-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-purple-900 mb-3 flex items-center gap-1.5">
                        <i data-lucide="user-check" class="w-4 h-4 text-purple-600"></i>
                        <span>Perempuan Dilarang:</span>
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-700">
                        @foreach($hajj['ppih_bimtek']['larangan_ihram']['perempuan'] as $lp)
                            <li class="flex items-start gap-1.5">
                                <span class="text-purple-500 font-bold">&bull;</span>
                                <span>{{ $lp }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Bersama dilarang -->
                <div class="p-5 rounded-2xl bg-amber-50/40 border border-amber-200">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900 mb-3 flex items-center gap-1.5">
                        <i data-lucide="users" class="w-4 h-4 text-amber-600"></i>
                        <span>Laki-Laki & Perempuan Dilarang:</span>
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-700">
                        @foreach($hajj['ppih_bimtek']['larangan_ihram']['bersama'] as $lb)
                            <li class="flex items-start gap-1.5">
                                <span class="text-amber-600 font-bold">&bull;</span>
                                <span>{{ $lb }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Hal yang diperbolehkan -->
            <div class="p-5 sm:p-6 rounded-2xl bg-emerald-50/50 border border-emerald-200">
                <h4 class="text-sm font-bold text-emerald-950 mb-3 flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                    <span>12 Hal yang Sah & Diperbolehkan Ketika Ihram (Bukan Pelanggaran):</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5">
                    @foreach($hajj['ppih_bimtek']['hal_diperbolehkan'] as $hd)
                        <div class="p-3 rounded-xl bg-white border border-emerald-100 flex items-start gap-2 text-xs text-slate-700">
                            <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                            <span>{{ $hd }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 4. Perjalanan ke Makkah, Tata Cara Talbiyah & Denah Pintu Masjidil Haram -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Talbiyah & Persiapan Menuju Masjidil Haram -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                            <i data-lucide="bus" class="w-4 h-4"></i>
                        </span>
                        <h3 class="text-lg font-bold text-slate-900">6. Perjalanan Menuju Makkah & Tata Cara Talbiyah</h3>
                    </div>

                    <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200 mb-4 text-xs text-slate-700 leading-relaxed space-y-2">
                        <p>{{ $hajj['ppih_bimtek']['perjalanan_ke_makkah']['talbiyah_guidelines'] }}</p>
                        <p><strong>Ketentuan Bertalbiyah:</strong> {{ $hajj['ppih_bimtek']['perjalanan_ke_makkah']['cara_bertalbiyah'] }}</p>
                    </div>

                    <!-- Doa Sapu Jagat Highlight -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Doa Paling Sering Dibaca Nabi SAW:</span>
                        <div class="font-arabic text-xl font-bold text-slate-900 mb-1" dir="rtl">
                            {{ $hajj['ppih_bimtek']['perjalanan_ke_makkah']['doa_sapujagat'] }}
                        </div>
                        <div class="text-xs text-emerald-700 italic font-semibold">
                            "Rabbanā ātinā fid-dunyā ḥasanatan wa fil-ākhirati ḥasanatan wa qinā ‘ażāban-nār"
                        </div>
                    </div>
                </div>

                <div class="mt-4 p-3.5 rounded-xl bg-blue-50/60 border border-blue-200 text-xs text-blue-950">
                    ⏰ <strong>Waktu Menuju Masjidil Haram:</strong> {{ $hajj['ppih_bimtek']['masjidil_haram_prep']['timing'] }}. Petugas haid: {{ $hajj['ppih_bimtek']['masjidil_haram_prep']['haidh_officer'] }}
                </div>
            </div>

            <!-- Denah 13 Pintu (Bab) & 3 Terminal Bus Masjidil Haram -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="compass" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-lg font-bold text-slate-900">7. Denah Pintu Utama (Bab) & Terminal Bus</h3>
                </div>

                <!-- 3 Terminal Bus Shalawat -->
                <div class="space-y-2 mb-4">
                    <span class="text-xs font-bold text-slate-800 block">3 Terminal Bus Shalawat Jemaah Indonesia:</span>
                    @foreach($hajj['ppih_bimtek']['masjidil_haram_prep']['terminals'] as $tm)
                        <div class="p-2.5 rounded-xl bg-indigo-50/50 border border-indigo-100 text-xs flex items-start justify-between gap-2">
                            <div>
                                <span class="font-bold text-indigo-950 block">{{ $tm['name'] }} ({{ $tm['direction'] }})</span>
                                <span class="text-slate-600 text-[11px]">{{ $tm['notes'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 13 Pintu Utama -->
                <div>
                    <span class="text-xs font-bold text-slate-800 block mb-2">13 Pintu Utama (Bab) Masjidil Haram:</span>
                    <div class="grid grid-cols-2 gap-2 text-[11px]">
                        @foreach($hajj['ppih_bimtek']['masjidil_haram_prep']['gates'] as $gt)
                            <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded bg-emerald-600 text-white font-bold text-[10px] flex items-center justify-center flex-shrink-0">{{ $gt['num'] }}</span>
                                <span class="font-medium text-slate-800 truncate" title="{{ $gt['name'] }}">{{ $gt['name'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Syarat Sah, Tata Cara, Larangan, Adab & Hikmah Thawaf -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex items-center gap-2 pb-4 border-b border-slate-100">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                    <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                </span>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">8. Fiqih Lengkap Thawaf: Syarat, Tata Cara, Adab & Hikmah</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Panduan komprehensif mengelilingi Ka'bah 7 putaran dari Hajar Aswad.</p>
                </div>
            </div>

            <!-- 6 Syarat Sah Thawaf -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i data-lucide="check-square" class="w-4 h-4 text-emerald-600"></i>
                    <span>6 Syarat Sah Thawaf (Wajib Dipenuhi):</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($hajj['ppih_bimtek']['thawaf_details']['syarat_sah'] as $idx => $sy)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 leading-relaxed">
                            <span class="font-bold text-emerald-800 block mb-1">Syarat #{{ $idx + 1 }}:</span>
                            {{ $sy }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tata Cara Thawaf 14 Langkah -->
            <div>
                <h4 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <i data-lucide="list-ordered" class="w-4 h-4 text-emerald-600"></i>
                    <span>Tata Cara Praktik Thawaf Langkah demi Langkah:</span>
                </h4>
                <div class="space-y-2">
                    @foreach($hajj['ppih_bimtek']['thawaf_details']['tata_cara'] as $tIdx => $tc)
                        <div class="p-3 rounded-xl bg-white border border-slate-200 hover:border-emerald-400 text-xs text-slate-700 flex items-start gap-3 transition">
                            <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center flex-shrink-0 mt-0.5">{{ $tIdx + 1 }}</span>
                            <span class="leading-relaxed">{{ $tc }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Larangan, Adab & Hikmah Thawaf Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 pt-4 border-t border-slate-100">
                <!-- Larangan Thawaf -->
                <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-200">
                    <span class="text-xs font-bold text-rose-950 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                        <i data-lucide="x-circle" class="w-4 h-4 text-rose-600"></i>
                        <span>Larangan Saat Thawaf:</span>
                    </span>
                    <ul class="space-y-2 text-xs text-slate-700">
                        @foreach($hajj['ppih_bimtek']['thawaf_details']['larangan_thawaf'] as $lt)
                            <li class="flex items-start gap-1.5">
                                <span class="text-rose-500 font-bold">&bull;</span>
                                <span>{{ $lt }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 5 Adab Thawaf -->
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-200">
                    <span class="text-xs font-bold text-blue-950 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                        <i data-lucide="heart" class="w-4 h-4 text-blue-600"></i>
                        <span>5 Adab Utama Thawaf:</span>
                    </span>
                    <ul class="space-y-2 text-xs text-slate-700">
                        @foreach($hajj['ppih_bimtek']['thawaf_details']['adab_thawaf'] as $at)
                            <li class="flex items-start gap-1.5">
                                <span class="text-blue-500 font-bold">&bull;</span>
                                <span>{{ $at }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- 3 Hikmah Thawaf -->
                <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200">
                    <span class="text-xs font-bold text-emerald-950 uppercase tracking-wider block mb-2 flex items-center gap-1.5">
                        <i data-lucide="sparkles" class="w-4 h-4 text-emerald-600"></i>
                        <span>3 Hikmah Filosofis Thawaf:</span>
                    </span>
                    <ul class="space-y-2 text-xs text-slate-700">
                        @foreach($hajj['ppih_bimtek']['thawaf_details']['hikmah_thawaf'] as $ht)
                            <li class="flex items-start gap-1.5">
                                <span class="text-emerald-500 font-bold">&bull;</span>
                                <span>{{ $ht }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- 6. Minum Air Zamzam & Ketentuan Sa'i -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Minum Air Zamzam -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                            <i data-lucide="droplet" class="w-4 h-4"></i>
                        </span>
                        <h3 class="text-lg font-bold text-slate-900">9. Fiqih & Adab Minum Air Zamzam</h3>
                    </div>

                    <!-- Doa Minum Zamzam -->
                    <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200 mb-4">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-[11px] font-bold text-blue-900 uppercase">Doa Meminum Air Zamzam:</span>
                            <button type="button" onclick="speakText('{{ addslashes($hajj['ppih_bimtek']['zamzam_details']['doa']['arabic']) }}', 'ar')" class="p-1.5 rounded-lg bg-blue-100 text-blue-800 hover:bg-blue-600 hover:text-white transition shadow-xs">
                                <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <div class="font-arabic text-xl font-bold text-slate-900 mb-1" dir="rtl">
                            {{ $hajj['ppih_bimtek']['zamzam_details']['doa']['arabic'] }}
                        </div>
                        <div class="text-xs text-blue-800 italic mb-1 font-semibold">
                            "{{ $hajj['ppih_bimtek']['zamzam_details']['doa']['latin'] }}"
                        </div>
                        <div class="text-xs text-slate-600">
                            {{ $hajj['ppih_bimtek']['zamzam_details']['doa']['meaning'] }}
                        </div>
                    </div>

                    <!-- Adab Minum -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 mb-4 text-xs text-slate-700 leading-relaxed">
                        <span class="font-bold text-slate-900 block mb-1">Tata Cara & Adab Minum (Tadhalla'):</span>
                        {{ $hajj['ppih_bimtek']['zamzam_details']['adab'] }}
                    </div>

                    <!-- Manfaat Air Zamzam -->
                    <div>
                        <span class="text-xs font-bold text-slate-800 block mb-2">4 Manfaat Zamzam (Fisik & Spiritual):</span>
                        <div class="space-y-1.5">
                            @foreach($hajj['ppih_bimtek']['zamzam_details']['benefits'] as $bn)
                                <div class="flex items-center gap-2 text-xs text-slate-700 p-2 rounded-lg bg-blue-50/30 border border-blue-100">
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-blue-600 flex-shrink-0"></i>
                                    <span>{{ $bn }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ketentuan, Tata Cara & Adab Sa'i -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                            <i data-lucide="footprints" class="w-4 h-4"></i>
                        </span>
                        <h3 class="text-lg font-bold text-slate-900">10. Ketentuan, Tata Cara & Falsafah Sa'i</h3>
                    </div>

                    <div class="space-y-2 mb-4">
                        <span class="text-xs font-bold text-slate-800 block">Ketentuan Pokok Sa'i Shafa-Marwah:</span>
                        @foreach(array_slice($hajj['ppih_bimtek']['sai_details']['ketentuan'], 0, 4) as $sk)
                            <div class="flex items-start gap-2 text-xs text-slate-700 p-2 rounded-lg bg-slate-50 border border-slate-100">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600 flex-shrink-0 mt-0.5"></i>
                                <span>{{ $sk }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tata Cara Sa'i -->
                    <div class="p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-200 mb-4 text-xs text-slate-700 space-y-2">
                        <span class="font-bold text-emerald-950 block">Tata Cara di Lintasan Sa'i:</span>
                        @foreach($hajj['ppih_bimtek']['sai_details']['tata_cara'] as $sc)
                            <p class="leading-relaxed">&bull; {{ $sc }}</p>
                        @endforeach
                    </div>

                    <!-- Falsafah Ta'abbudi -->
                    <div class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-200 text-xs text-amber-950 leading-relaxed">
                        <span class="font-bold block mb-1">💡 Sa'i Sebagai Ibadah Ta'abbudi:</span>
                        {{ $hajj['ppih_bimtek']['sai_details']['adab_dan_falsafah'][3] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 7. Tahallul / Bercukur & Penempatan Tugas Layanan Pasca Umrah -->
        <div class="bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 rounded-3xl border border-emerald-800 p-6 sm:p-8 text-white shadow-xl">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-emerald-800/40">
                <span class="w-8 h-8 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-sm">
                    <i data-lucide="scissors" class="w-4 h-4"></i>
                </span>
                <div>
                    <h3 class="text-xl font-bold text-white">11. Ketentuan Tahallul & Penempatan Tugas Layanan Pasca-Umrah</h3>
                    <p class="text-xs text-slate-300 mt-0.5">Pelepasan ihram umrah dan pengaktifan pos dinas pelayanan jemaah.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Ketentuan Tahallul -->
                <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                    <span class="text-xs font-bold text-amber-300 uppercase tracking-wider block mb-2">Panduan Bercukur / Tahallul:</span>
                    <p class="text-xs text-slate-300 leading-relaxed mb-3">
                        {{ $hajj['ppih_bimtek']['tahallul_details']['definition'] }}
                    </p>
                    <div class="space-y-2">
                        @foreach($hajj['ppih_bimtek']['tahallul_details']['prosedur'] as $tp)
                            <div class="flex items-start gap-2 text-xs text-slate-200">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5"></i>
                                <span>{{ $tp }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Penugasan Operasional Pasca Umrah -->
                <div class="p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider block mb-2">Penugasan Operasional PPIH:</span>
                        <p class="text-xs text-slate-300 mb-3">{{ $hajj['ppih_bimtek']['post_umrah_duty']['summary'] }}</p>
                        <div class="space-y-3">
                            @foreach($hajj['ppih_bimtek']['post_umrah_duty']['deployments'] as $dp)
                                <div class="p-3 rounded-xl bg-white/5 border border-white/10 text-xs">
                                    <span class="font-bold text-amber-300 block mb-1">{{ $dp['target'] }}</span>
                                    <span class="text-slate-300 leading-relaxed">{{ $dp['role'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- TAB 3: RUKUN, WAJIB & FIQIH HAJI -->
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

        <!-- KETENTUAN 4 MACAM FIQIH DAM (DENDA PELANGGARAN HAJI) -->
        <div class="bg-white rounded-3xl border border-rose-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-sm">
                    <i data-lucide="scale" class="w-4 h-4"></i>
                </span>
                <h3 class="text-xl font-bold text-slate-900">Ketentuan 4 Macam Fiqih Dam (Denda Pelanggaran Haji)</h3>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mb-6">
                Berdasarkan Fiqih Mazhab Syafi'i dan Pedoman Manasik Kementerian Agama & Kementerian Haji dan Umrah RI, Dam terbagi ke dalam 4 klasifikasi hukum:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($hajj['fiqh']['dam_categories'] as $dam)
                    <div class="p-5 rounded-2xl bg-rose-50/40 border border-rose-200 hover:border-rose-400 transition flex flex-col justify-between shadow-2xs">
                        <div>
                            <h4 class="text-sm font-bold text-rose-950 mb-2 flex items-center gap-1.5">
                                <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600 flex-shrink-0"></i>
                                <span>{{ $dam['name'] }}</span>
                            </h4>
                            <div class="text-xs text-slate-700 leading-relaxed mb-3">
                                <span class="font-bold text-slate-900 block mb-0.5">Sebab Denda:</span>
                                {{ $dam['cause'] }}
                            </div>
                        </div>
                        <div class="p-3 rounded-xl bg-white border border-rose-200 text-xs">
                            <span class="font-bold text-rose-700 block mb-0.5">Ketentuan Pembayaran Denda:</span>
                            <span class="text-slate-800 leading-relaxed">{{ $dam['penalty'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 4: PUSTAKA 16 DOA HAJI & AUDIO -->
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
                                    <span class="text-[11px] text-slate-500 block mt-0.5">{{ $prayer['occasion'] }}</span>
                                </div>
                                <button type="button" onclick="speakText('{{ addslashes($prayer['arabic']) }}', 'ar')" class="p-2.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white transition flex-shrink-0 shadow-xs" title="Putar Pelafalan Doa">
                                    <i data-lucide="volume-2" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <div class="p-4 rounded-xl bg-white border border-slate-200/80 my-3">
                                <div class="font-arabic text-xl sm:text-2xl font-bold text-slate-900 leading-loose" dir="rtl">
                                    {{ $prayer['arabic'] }}
                                </div>
                            </div>

                            <div class="text-xs text-emerald-700 font-semibold mb-1 italic">
                                "{{ $prayer['trans'] }}"
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                <strong>Artinya:</strong> {{ $prayer['meaning'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 5: REGULASI KEMENHAJ RI & SAUDI -->
    <div id="tab-regulations" class="hajj-tab-pane hidden space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Regulasi Indonesia (Kemenhaj RI) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="shield" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Regulasi Kementerian Haji dan Umrah RI</h3>
                </div>
                <p class="text-xs text-slate-500 mb-6">
                    Landasan hukum: <strong>{{ $hajj['regulations']['indonesia']['legal_basis'] }}</strong>.
                </p>

                <div class="space-y-4">
                    @foreach($hajj['regulations']['indonesia']['rules'] as $rule)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <h4 class="text-sm font-bold text-slate-900">{{ $rule['topic'] }}</h4>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $rule['badge'] }}</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $rule['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Regulasi Kerajaan Arab Saudi -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                        <i data-lucide="shield-alert" class="w-4 h-4"></i>
                    </span>
                    <h3 class="text-xl font-bold text-slate-900">Regulasi Kerajaan Arab Saudi</h3>
                </div>
                <p class="text-xs text-slate-500 mb-6">
                    Sistem Digital: <strong>{{ $hajj['regulations']['saudi']['legal_basis'] }}</strong>.
                </p>

                <div class="space-y-4">
                    @foreach($hajj['regulations']['saudi']['rules'] as $srule)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <h4 class="text-sm font-bold text-slate-900">{{ $srule['topic'] }}</h4>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">{{ $srule['badge'] }}</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $srule['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 6: VIDEO SIMULASI 3D & MANASIK -->
    <div id="tab-videos" class="hajj-tab-pane hidden space-y-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 flex items-center gap-2 mb-2">
                <i data-lucide="video" class="w-6 h-6 text-rose-500"></i>
                <span>Video Simulasi 3D & Peragaan Manasik Resmi</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mb-6">
                Visualisasi 3D definisi tinggi dari Saudi Ministry of Hajj & Umrah dan Kementerian Haji dan Umrah RI untuk memahami gerakan manasik secara gamblang.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($hajj['videos'] as $vid)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-between hover:border-emerald-400 transition">
                        <div>
                            <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-900 mb-3 shadow-xs">
                                <iframe src="{{ $vid['embed_url'] }}" title="{{ $vid['title'] }}" class="w-full h-full" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase mb-1 inline-block">
                                {{ $vid['duration'] }} • {{ $vid['source'] }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-900 mt-1 mb-2">{{ $vid['title'] }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed mb-4">{{ $vid['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TAB 7: CHECKLIST & KUIS EVALUASI -->
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
                            'Mengetahui 24 butir Kalender RPH 1448 H / 2027 M Keputusan Dirjen No. 26/2026',
                            'Memahami Fiqih Khusus Petugas Haji PPIH (wajib Tamattu\' & khidmat)',
                            'Menghafal Niat Ihram dan Bacaan Talbiyah dengan benar',
                            'Memahami urutan wukuf di Arafah 15 Mei 2027 (9 Dzulhijjah)',
                            'Mengetahui syarat sah, tata cara, dan adab Thawaf di Masjidil Haram',
                            'Mengetahui hakikat ibadah Sa\'i Ta\'abbudi serta aturan Kartu Pintar Nusuk',
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
                        <span>Kuis Evaluasi Fiqih & Manasik Haji</span>
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
