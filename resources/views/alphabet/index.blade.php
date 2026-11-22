@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Top Breadcrumbs -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1 mb-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke Beranda
            </a>
            <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Eksplorasi Aksara & Abjad Lengkap</span>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold uppercase">Zero to Hero</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Kuasai seluruh huruf, bunyi fonetik, perubahan posisi bentuk huruf, dan aturan baca dari nol.
            </p>
        </div>

        <!-- Language Selector Tabs -->
        <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm">
            @foreach($allLanguages as $lang)
                <a href="{{ route('alphabet.index', $lang->code) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $langCode === $lang->code ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span>{{ $lang->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Alphabet Overview Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white shadow-lg mb-10">
        <div class="flex items-center gap-2 text-xs font-bold text-blue-400 uppercase tracking-widest mb-2">
            <i data-lucide="info" class="w-4 h-4"></i>
            <span>Pondasi Mutlak Sebelum Memulai Kalimat</span>
        </div>
        <h2 class="text-xl sm:text-2xl font-extrabold mb-2">{{ $language->name }} ({{ $language->native_name }})</h2>
        <p class="text-xs sm:text-sm text-slate-300 max-w-3xl leading-relaxed">
            {{ $alphabetData['overview'] ?? '' }}
        </p>
    </div>

    <!-- Dynamic Language Script Content -->
    @if($langCode === 'ar')
        <!-- ARABIC 28 LETTERS MATRIX -->
        <div class="space-y-10">
            <!-- 28 Hijaiyah with 4 Shapes -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="table" class="w-5 h-5 text-blue-600"></i>
                    <span>Tabel 28 Huruf Hijaiyah & 4 Perubahan Bentuk Sambung</span>
                </h3>

                <div class="overflow-x-auto bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                                <th class="p-4 text-center">Huruf</th>
                                <th class="p-4">Nama & Pelafalan</th>
                                <th class="p-4 text-center">Bentuk Tunggal</th>
                                <th class="p-4 text-center">Awal (Initial)</th>
                                <th class="p-4 text-center">Tengah (Medial)</th>
                                <th class="p-4 text-center">Akhir (Final)</th>
                                <th class="p-4 text-center">Suara</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($alphabetData['letters'] as $item)
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="p-4 text-center font-bold text-2xl font-arabic text-slate-900">{{ $item['char'] }}</td>
                                    <td class="p-4">
                                        <div class="font-bold text-slate-900">{{ $item['name'] }}</div>
                                        <div class="text-xs text-blue-600">{{ $item['latin'] }}</div>
                                    </td>
                                    <td class="p-4 text-center font-arabic text-2xl text-slate-800">{{ $item['isolated'] }}</td>
                                    <td class="p-4 text-center font-arabic text-2xl text-slate-800">{{ $item['initial'] }}</td>
                                    <td class="p-4 text-center font-arabic text-2xl text-slate-800">{{ $item['medial'] }}</td>
                                    <td class="p-4 text-center font-arabic text-2xl text-slate-800">{{ $item['final'] }}</td>
                                    <td class="p-4 text-center">
                                        <button onclick="speakText('{{ addslashes($item['audio']) }}', 'ar')" class="p-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-sm">
                                            <i data-lucide="volume-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Harakat Chart -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-5 h-5 text-amber-600"></i>
                    <span>Tanda Baca Harakat & Vokal Fonetik</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($alphabetData['harakat'] as $h)
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm text-center">
                            <div class="text-4xl font-arabic text-amber-600 mb-2 font-bold">ب{{ $h['symbol'] }}</div>
                            <div class="text-sm font-bold text-slate-900">{{ $h['name'] }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $h['sound'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($langCode === 'ja')
        <!-- JAPANESE HIRAGANA & KATAKANA MATRIX -->
        <div class="space-y-12">
            <!-- Hiragana Gojuon -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="feather" class="w-5 h-5 text-purple-600"></i>
                    <span>46 Huruf Dasar Hiragana (Seion - 五十音)</span>
                </h3>
                <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-10 gap-2.5">
                    @foreach($alphabetData['hiragana'] as $item)
                        <div class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-purple-500 hover:shadow-md transition text-center group cursor-pointer" onclick="speakText('{{ $item['char'] }}', 'ja')">
                            <div class="text-2xl font-bold font-japanese text-slate-900 group-hover:text-purple-600 mb-1">{{ $item['char'] }}</div>
                            <div class="text-[11px] font-semibold text-slate-500">{{ $item['romaji'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Dakuon -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="zap" class="w-5 h-5 text-indigo-600"></i>
                    <span>25 Bunyi Dakuon & Handakuon (Tenten ゛& Maru ゜)</span>
                </h3>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                    @foreach($alphabetData['dakuon'] as $item)
                        <div class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-indigo-500 transition text-center cursor-pointer" onclick="speakText('{{ $item['char'] }}', 'ja')">
                            <div class="text-2xl font-bold font-japanese text-slate-900 mb-1">{{ $item['char'] }}</div>
                            <div class="text-[11px] font-semibold text-indigo-600">{{ $item['romaji'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Katakana -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="hash" class="w-5 h-5 text-blue-600"></i>
                    <span>46 Huruf Katakana (Kata Serapan Asing)</span>
                </h3>
                <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-10 gap-2.5">
                    @foreach($alphabetData['katakana'] as $item)
                        <div class="p-3.5 rounded-xl border border-slate-200 bg-white hover:border-blue-500 hover:shadow-md transition text-center cursor-pointer" onclick="speakText('{{ $item['char'] }}', 'ja')">
                            <div class="text-2xl font-bold font-japanese text-slate-900 mb-1">{{ $item['char'] }}</div>
                            <div class="text-[11px] font-semibold text-blue-600">{{ $item['romaji'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($langCode === 'ko')
        <!-- KOREAN HANGEUL MATRIX -->
        <div class="space-y-10">
            <!-- Consonants -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">14 Konsonan Dasar (자음) & 5 Konsonan Ganda (쌍자음)</h3>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-4">
                    @foreach($alphabetData['basic_consonants'] as $item)
                        <div class="p-4 rounded-xl border border-slate-200 bg-white text-center cursor-pointer hover:border-emerald-500 transition" onclick="speakText('{{ $item['char'] }}', 'ko')">
                            <div class="text-3xl font-bold font-korean text-slate-900 mb-1">{{ $item['char'] }}</div>
                            <div class="text-xs font-bold text-emerald-700">{{ $item['name'] }}</div>
                            <div class="text-[10px] text-slate-400">Bunyi: {{ $item['sound'] }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                    @foreach($alphabetData['double_consonants'] as $item)
                        <div class="p-4 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center cursor-pointer hover:border-emerald-600 transition" onclick="speakText('{{ $item['char'] }}', 'ko')">
                            <div class="text-3xl font-bold font-korean text-emerald-950 mb-1">{{ $item['char'] }}</div>
                            <div class="text-xs font-bold text-emerald-800">{{ $item['name'] }}</div>
                            <div class="text-[10px] text-emerald-600">{{ $item['sound'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Vowels -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">10 Vokal Dasar (모음) & 11 Vokal Gabungan (이중모음)</h3>
                <div class="grid grid-cols-3 sm:grid-cols-5 md:grid-cols-10 gap-2.5">
                    @foreach(array_merge($alphabetData['basic_vowels'], $alphabetData['compound_vowels']) as $item)
                        <div class="p-3 rounded-xl border border-slate-200 bg-white text-center cursor-pointer hover:border-emerald-500 transition" onclick="speakText('{{ $item['char'] }}', 'ko')">
                            <div class="text-2xl font-bold font-korean text-slate-900 mb-1">{{ $item['char'] }}</div>
                            <div class="text-[11px] font-semibold text-slate-500">{{ $item['romaja'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Batchim Rules -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">7 Kaidah Bunyi Konsonan Akhir (Batchim - 받침)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($alphabetData['batchim_rules'] as $b)
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm">
                            <div class="text-xs font-bold uppercase text-emerald-600 mb-1">Bunyi Akhir: {{ $b['sound'] }}</div>
                            <div class="text-base font-bold text-slate-900 mb-2">Huruf: {{ $b['letters'] }}</div>
                            <div class="text-xs text-slate-600 font-semibold bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                Contoh: {{ $b['example'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($langCode === 'en')
        <!-- ENGLISH ALPHABET & 44 PHONEMES -->
        <div>
            <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">26 English Alphabets & Fonetik Internasional (IPA)</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                @foreach($alphabetData['letters'] as $item)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-500 hover:shadow-md transition text-center cursor-pointer group" onclick="speakText('{{ $item['audio'] }}', 'en')">
                        <div class="text-2xl font-black text-slate-900 group-hover:text-blue-600 mb-1">{{ $item['char'] }}</div>
                        <div class="text-xs font-mono font-bold text-blue-600 mb-1">{{ $item['phonetic'] }}</div>
                        <div class="text-[11px] text-slate-400 truncate">{{ $item['sample'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
