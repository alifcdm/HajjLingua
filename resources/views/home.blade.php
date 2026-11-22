@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 pt-4 sm:pt-8 pb-12">

    <!-- Hero Banner (Mobile-Optimized) -->
    <div class="rounded-3xl bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-800 text-white p-6 sm:p-8 md:p-12 shadow-xl relative overflow-hidden mb-8 sm:mb-12">
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
            <i data-lucide="award" class="w-96 h-96"></i>
        </div>
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-[11px] sm:text-xs font-semibold mb-3 sm:mb-4 border border-white/20">
                <i data-lucide="sparkles" class="w-3.5 h-3.5 text-yellow-300"></i>
                <span>Pembelajaran Terstruktur dari Dasar hingga Profesional</span>
            </div>
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-3 sm:mb-4">
                Kuasai Bahasa Dunia dengan Standar Internasional Resmi.
            </h1>
            <p class="text-xs sm:text-base md:text-lg text-blue-100 mb-6 sm:mb-8 leading-relaxed">
                Kurikulum terstandarisasi untuk <strong>English (CEFR A1–C2)</strong>, <strong>Jepang (JLPT N5–N1)</strong>, <strong>Korea (TOPIK 1–6)</strong>, dan <strong>Arab (3 Tahapan & CEFR)</strong>. Lengkap dengan placement test, audio speech pronunciation, dan sertifikat kelulusan digital.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-stretch sm:items-center">
                <a href="#pairs-grid" class="px-6 py-3.5 rounded-xl bg-white text-blue-700 font-bold hover:bg-blue-50 transition shadow-lg flex items-center justify-center gap-2 text-xs sm:text-sm">
                    <span>Pilih Pasangan Bahasa</span>
                    <i data-lucide="arrow-down" class="w-4 h-4"></i>
                </a>
                <a href="{{ route('alphabet.index', 'ar') }}" class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/30 text-white font-bold transition flex items-center justify-center gap-2 backdrop-blur-sm text-xs sm:text-sm">
                    <i data-lucide="languages" class="w-4 h-4 text-amber-300"></i>
                    <span>Aksara & Huruf Lengkap (Zero to Hero)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Curriculum Standards Summary Pills (Mobile 1 Col -> 2 Col -> 4 Col) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8 sm:mb-12">
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-blue-400 transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600">English Standard</span>
                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-xs font-bold">CEFR</span>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-slate-800">A1 - A2 - B1 - B2 - C1 - C2</h3>
            <p class="text-xs text-slate-500 mt-1">Pemula dasar hingga fasih bisnis profesional.</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-purple-400 transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-purple-600">Japanese Standard</span>
                <span class="px-2 py-0.5 rounded bg-purple-50 text-purple-700 text-xs font-bold">JLPT</span>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-slate-800">N5 - N4 - N3 - N2 - N1</h3>
            <p class="text-xs text-slate-500 mt-1">Hiragana, Katakana, Kanji & etiket Keigo.</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-400 transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Korean Standard</span>
                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-xs font-bold">TOPIK</span>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-slate-800">Basic s.d. Level 6</h3>
            <p class="text-xs text-slate-500 mt-1">Hangeul, pemula harian hingga riset bisnis.</p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-amber-400 transition">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Arabic Standard</span>
                <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 text-xs font-bold">3 Tahap + CEFR</span>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-slate-800">Mubtadi' - Mutawassith - Mutaqaddim</h3>
            <p class="text-xs text-slate-500 mt-1">Hijaiyah, teks gundul, nahwu shorof & CEFR A1-C2.</p>
        </div>
    </div>

    <!-- Feature Showcase: Zero to Hero Alphabet Explorer & 100-Stage Drill Arena -->
    <!-- Feature Showcase: Zero to Hero Alphabet, 100-Stage Drill Arena & Modul Haji Terpadu -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-14">
        <!-- Card 1: Zero to Hero Alphabet Master -->
        <div class="p-6 md:p-8 rounded-3xl bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-orange-500/10 border border-amber-200/80 shadow-sm relative overflow-hidden flex flex-col justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold mb-3">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5 text-amber-600"></i>
                    Fondasi Utama: Zero to Hero
                </div>
                <h3 class="text-xl md:text-2xl font-black text-slate-900 mb-2">
                    Eksplorasi Seluruh Huruf & Aksara Dunia
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mb-6 leading-relaxed">
                    Kuasai bentuk huruf terisolasi, awal, tengah, akhir, harakat Arab, Hiragana & Katakana Jepang, 40 Hangeul & Batchim Korea, serta 44 Fonem IPA Bahasa Inggris dengan audio pelafalan asli.
                </p>

                <!-- Quick language pills for alphabet -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 mb-6">
                    <a href="{{ route('alphabet.index', 'ar') }}" class="p-3 bg-white rounded-xl border border-amber-200 text-center hover:shadow-md hover:border-amber-400 transition group">
                        <span class="text-lg font-arabic font-bold text-amber-700 block group-hover:scale-110 transition-transform">العربية</span>
                        <span class="text-[11px] font-semibold text-slate-600">28 Hijaiyah</span>
                    </a>
                    <a href="{{ route('alphabet.index', 'ja') }}" class="p-3 bg-white rounded-xl border border-amber-200 text-center hover:shadow-md hover:border-amber-400 transition group">
                        <span class="text-lg font-bold text-purple-700 block group-hover:scale-110 transition-transform">かな</span>
                        <span class="text-[11px] font-semibold text-slate-600">Hiragana/Kata</span>
                    </a>
                    <a href="{{ route('alphabet.index', 'ko') }}" class="p-3 bg-white rounded-xl border border-amber-200 text-center hover:shadow-md hover:border-amber-400 transition group">
                        <span class="text-lg font-bold text-emerald-700 block group-hover:scale-110 transition-transform">한글</span>
                        <span class="text-[11px] font-semibold text-slate-600">40 Hangeul</span>
                    </a>
                    <a href="{{ route('alphabet.index', 'zh') }}" class="p-3 bg-white rounded-xl border border-amber-200 text-center hover:shadow-md hover:border-amber-400 transition group">
                        <span class="text-lg font-bold text-rose-700 block group-hover:scale-110 transition-transform">拼音汉字</span>
                        <span class="text-[11px] font-semibold text-slate-600">Pinyin & Nada</span>
                    </a>
                    <a href="{{ route('alphabet.index', 'en') }}" class="p-3 bg-white rounded-xl border border-amber-200 text-center hover:shadow-md hover:border-amber-400 transition group">
                        <span class="text-lg font-bold text-blue-700 block group-hover:scale-110 transition-transform">Aa-Zz</span>
                        <span class="text-[11px] font-semibold text-slate-600">26 + 44 IPA</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('alphabet.index', 'ar') }}" class="inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-amber-600 text-white font-bold text-xs hover:bg-amber-700 transition shadow-sm">
                <span>Buka Pustaka Aksara Lengkap</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Card 2: 100-Stage Memory Reinforcement Arena -->
        <div class="p-6 md:p-8 rounded-3xl bg-gradient-to-br from-indigo-500/10 via-indigo-500/5 to-purple-500/10 border border-indigo-200/80 shadow-sm relative overflow-hidden flex flex-col justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-bold mb-3">
                    <i data-lucide="zap" class="w-3.5 h-3.5 text-indigo-600"></i>
                    Penguat Ingatan Permanen
                </div>
                <h3 class="text-xl md:text-2xl font-black text-slate-900 mb-2">
                    Arena 100 Level Drill (1.500 Soal)
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mb-6 leading-relaxed">
                    Setiap stage berisi 15 soal cepat dengan distractor cerdas dan ulasan komprehensif. Didesain untuk mengunci ingatan tata bahasa, partikel, dan kosakata.
                </p>

                <div class="grid grid-cols-3 gap-2 mb-6">
                    <div class="bg-white p-3 rounded-xl border border-indigo-100 text-center">
                        <div class="text-lg font-black text-indigo-600">100</div>
                        <div class="text-[10px] text-slate-500 font-medium">Stage Level</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-indigo-100 text-center">
                        <div class="text-lg font-black text-indigo-600">15</div>
                        <div class="text-[10px] text-slate-500 font-medium">Soal/Stage</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-indigo-100 text-center">
                        <div class="text-lg font-black text-indigo-600">1.500+</div>
                        <div class="text-[10px] text-slate-500 font-medium">Soal & Analisis</div>
                    </div>
                </div>
            </div>

            <a href="#pairs-grid" class="inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-indigo-600 text-white font-bold text-xs hover:bg-indigo-700 transition shadow-sm">
                <span>Pilih Bahasa & Mulai Drill</span>
                <i data-lucide="arrow-down" class="w-4 h-4"></i>
            </a>
        </div>

        <!-- Card 3: Modul Panduan & Manasik Haji Terpadu -->
        <div class="p-6 md:p-8 rounded-3xl bg-gradient-to-br from-emerald-500/10 via-teal-500/5 to-emerald-500/10 border border-emerald-200/80 shadow-sm relative overflow-hidden flex flex-col justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold mb-3">
                    <i data-lucide="compass" class="w-3.5 h-3.5 text-emerald-600"></i>
                    Modul Spesial: Haji & Umrah
                </div>
                <h3 class="text-xl md:text-2xl font-black text-slate-900 mb-2">
                    Panduan & Manasik Ibadah Haji
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 mb-6 leading-relaxed">
                    Riset komprehensif seluruh alur 8-13 Dzulhijjah, rukun & wajib, fiqih dam, 16 doa berharakat dengan audio penutur asli, aturan Kemenag RI, dan regulasi Nusuk Arab Saudi.
                </p>

                <div class="grid grid-cols-3 gap-2 mb-6">
                    <div class="bg-white p-3 rounded-xl border border-emerald-100 text-center">
                        <div class="text-lg font-black text-emerald-700">8-13</div>
                        <div class="text-[10px] text-slate-500 font-medium">Dzulhijjah</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-emerald-100 text-center">
                        <div class="text-lg font-black text-emerald-700">16</div>
                        <div class="text-[10px] text-slate-500 font-medium">Doa & Audio</div>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-emerald-100 text-center">
                        <div class="text-lg font-black text-emerald-700">3D</div>
                        <div class="text-[10px] text-slate-500 font-medium">Simulasi Video</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('hajj.index') }}" class="inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-emerald-700 text-white font-bold text-xs hover:bg-emerald-800 transition shadow-sm">
                <span>Pelajari Modul Materi Haji</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
    <div id="pairs-grid" class="mb-16">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">10 Jalur Pembelajaran Bahasa</h2>
                <p class="text-sm text-slate-600">Pilih pasangan bahasa dasar pengantar dan bahasa target yang ingin Anda pelajari.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($pairs as $pair)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-500 transition-all flex flex-col justify-between overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs group-hover:bg-blue-600 group-hover:text-white transition">
                                {{ strtoupper($pair->targetLanguage->code) }}
                            </span>
                            <span class="text-xs font-medium px-2 py-1 bg-slate-100 rounded-md text-slate-600">
                                {{ $pair->targetLanguage->direction === 'rtl' ? 'RTL Arabic' : 'LTR' }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition">
                            {{ $pair->name }}
                        </h3>
                        <p class="text-xs text-slate-500 mb-4">
                            Bahasa Pengantar: <strong>{{ $pair->baseLanguage->name }}</strong>
                        </p>

                        <!-- Level Indicator Tags -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            @foreach($pair->targetLanguage->levels->take(4) as $lvl)
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                    {{ $lvl->code }}
                                </span>
                            @endforeach
                            @if($pair->targetLanguage->levels->count() > 4)
                                <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-500">
                                    +{{ $pair->targetLanguage->levels->count() - 4 }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex flex-col gap-2">
                        <a href="{{ route('placement.show', $pair->slug) }}" class="w-full py-2.5 px-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold text-xs text-center hover:opacity-95 transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                            <span>Ikuti Placement Test</span>
                        </a>
                        <a href="{{ route('learn.index', $pair->slug) }}" class="w-full py-2 px-3 rounded-xl bg-white border border-slate-300 text-slate-700 font-medium text-xs text-center hover:bg-slate-100 transition flex items-center justify-center gap-1.5">
                            <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                            <span>Mulai dari Level 1</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Certification Showcase -->
    @if($recentCertificates->isNotEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm mb-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Sertifikat Kelulusan Terverifikasi Baru</h3>
                    <p class="text-xs text-slate-500">Bukti resmi pencapaian level dengan UUID & QR code verifikasi online.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($recentCertificates as $cert)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between">
                        <div>
                            <div class="text-sm font-bold text-slate-900">{{ $cert->recipient_name }}</div>
                            <div class="text-xs text-blue-600 font-semibold">{{ $cert->language->name }} • {{ $cert->level->name }}</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">Nilai: {{ $cert->final_score }}%</div>
                        </div>
                        <a href="{{ route('certificate.show', $cert->uuid) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition">
                            Lihat
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
