@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Top Breadcrumbs & Nav -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1 mb-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke Beranda
            </a>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight flex flex-wrap items-center gap-2">
                <span>Eksplorasi Aksara & Abjad Lengkap</span>
                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold uppercase">Zero to Hero</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Kuasai seluruh huruf, bunyi fonetik, perubahan posisi sambung, kata contoh, dan terjemahan bahasa Indonesia dari nol.
            </p>
        </div>

        <!-- Language Selector Tabs (Responsive Scrollable on Mobile) -->
        <div class="flex items-center gap-1.5 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm overflow-x-auto no-scrollbar">
            @foreach($allLanguages as $lang)
                <a href="{{ route('alphabet.index', $lang->code) }}" class="px-3 sm:px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap {{ $langCode === $lang->code ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span>{{ $lang->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Alphabet Overview Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white shadow-lg mb-8 sm:mb-10">
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
        <div class="space-y-8 sm:space-y-10">
            <!-- 28 Hijaiyah with 4 Shapes & Indonesian Translations -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="table" class="w-5 h-5 text-blue-600"></i>
                    <span>Tabel 28 Huruf Hijaiyah, Bentuk Posisi & Terjemahan Kata Contoh Indonesia</span>
                </h3>

                <div class="overflow-x-auto bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                                <th class="p-4 text-center">Huruf</th>
                                <th class="p-4">Nama & Latin</th>
                                <th class="p-4 text-center">Tunggal</th>
                                <th class="p-4 text-center">Awal</th>
                                <th class="p-4 text-center">Tengah</th>
                                <th class="p-4 text-center">Akhir</th>
                                <th class="p-4">Kata Contoh & Arti Indonesia</th>
                                <th class="p-4 text-center">Audio</th>
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
                                    <td class="p-4">
                                        <div class="font-arabic text-lg font-bold text-slate-900">{{ $item['sample'] ?? '' }}</div>
                                        <div class="text-xs text-slate-500">{{ $item['sample_trans'] ?? '' }}</div>
                                        <div class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded inline-block mt-0.5">
                                            Arti: {{ $item['sample_meaning'] ?? '' }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button onclick="speakText('{{ addslashes($item['audio']) }}', 'ar')" class="p-2.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-sm" title="Dengarkan pengucapan">
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
                    <span>Tanda Baca Harakat & Vokal Fonetik (Terjemahan Indonesia)</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($alphabetData['harakat'] as $h)
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm text-center flex flex-col justify-between">
                            <div>
                                <div class="text-4xl font-arabic text-amber-600 mb-2 font-bold">ب{{ $h['symbol'] }}</div>
                                <div class="text-sm font-bold text-slate-900">{{ $h['name'] }}</div>
                                <div class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $h['sound'] }}</div>
                            </div>
                            @if(!empty($h['example']))
                                <div class="mt-3 pt-2 border-t border-slate-100 text-xs font-semibold text-amber-800 bg-amber-50 py-1 px-2 rounded-lg">
                                    Contoh: {{ $h['example'] }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($langCode === 'ja')
        <!-- JAPANESE HIRAGANA & KATAKANA MATRIX -->
        <div class="space-y-10 sm:space-y-12">
            <!-- Hiragana Gojuon -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="feather" class="w-5 h-5 text-purple-600"></i>
                    <span>46 Huruf Dasar Hiragana (Seion) & Terjemahan Kata Contoh</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-3">
                    @foreach($alphabetData['hiragana'] as $item)
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-purple-500 hover:shadow-md transition text-center group cursor-pointer flex flex-col justify-between" onclick="speakText('{{ $item['char'] }}', 'ja')">
                            <div>
                                <div class="text-3xl font-bold font-japanese text-slate-900 group-hover:text-purple-600 mb-1">{{ $item['char'] }}</div>
                                <div class="text-xs font-bold text-purple-700 mb-1.5">{{ $item['romaji'] }}</div>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-xl text-left border border-slate-100">
                                <div class="text-[11px] font-semibold text-slate-700 truncate">{{ $item['sample'] ?? '' }}</div>
                                <div class="text-[10px] font-bold text-emerald-700 truncate">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Dakuon -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="zap" class="w-5 h-5 text-indigo-600"></i>
                    <span>25 Bunyi Dakuon & Handakuon (Tenten & Maru) & Terjemahan</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                    @foreach($alphabetData['dakuon'] as $item)
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-indigo-500 hover:shadow-md transition text-center group cursor-pointer flex flex-col justify-between" onclick="speakText('{{ $item['char'] }}', 'ja')">
                            <div>
                                <div class="text-3xl font-bold font-japanese text-slate-900 group-hover:text-indigo-600 mb-1">{{ $item['char'] }}</div>
                                <div class="text-xs font-bold text-indigo-700 mb-1.5">{{ $item['romaji'] }}</div>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-xl text-left border border-slate-100">
                                <div class="text-[11px] font-semibold text-slate-700 truncate">{{ $item['sample'] ?? '' }}</div>
                                <div class="text-[10px] font-bold text-emerald-700 truncate">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Katakana -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i data-lucide="hash" class="w-5 h-5 text-blue-600"></i>
                    <span>46 Huruf Katakana (Kata Serapan Asing) & Terjemahan Indonesia</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-3">
                    @foreach($alphabetData['katakana'] as $item)
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-white hover:border-blue-500 hover:shadow-md transition text-center group cursor-pointer flex flex-col justify-between" onclick="speakText('{{ $item['char'] }}', 'ja')">
                            <div>
                                <div class="text-3xl font-bold font-japanese text-slate-900 group-hover:text-blue-600 mb-1">{{ $item['char'] }}</div>
                                <div class="text-xs font-bold text-blue-700 mb-1.5">{{ $item['romaji'] }}</div>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-xl text-left border border-slate-100">
                                <div class="text-[11px] font-semibold text-slate-700 truncate">{{ $item['sample'] ?? '' }}</div>
                                <div class="text-[10px] font-bold text-emerald-700 truncate">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($langCode === 'ko')
        <!-- KOREAN HANGEUL MATRIX -->
        <div class="space-y-10 sm:space-y-12">
            <!-- Consonants -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">14 Konsonan Dasar (자음) & Terjemahan Indonesia</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mb-4">
                    @foreach($alphabetData['basic_consonants'] as $item)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-white text-center cursor-pointer hover:border-emerald-500 hover:shadow-md transition flex flex-col justify-between" onclick="speakText('{{ $item['char'] }}', 'ko')">
                            <div>
                                <div class="text-3xl font-bold font-korean text-slate-900 mb-1">{{ $item['char'] }}</div>
                                <div class="text-xs font-bold text-emerald-700">{{ $item['name'] }}</div>
                                <div class="text-[10px] text-slate-400 mb-2">Bunyi: {{ $item['sound'] }}</div>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-xl text-left border border-slate-100">
                                <div class="text-xs font-semibold text-slate-700">{{ $item['sample'] ?? '' }}</div>
                                <div class="text-[10px] font-bold text-emerald-700">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4 mt-6">5 Konsonan Ganda (쌍자음)</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                    @foreach($alphabetData['double_consonants'] as $item)
                        <div class="p-4 rounded-2xl border border-emerald-200 bg-emerald-50/40 text-center cursor-pointer hover:border-emerald-600 hover:shadow-md transition flex flex-col justify-between" onclick="speakText('{{ $item['char'] }}', 'ko')">
                            <div>
                                <div class="text-3xl font-bold font-korean text-emerald-950 mb-1">{{ $item['char'] }}</div>
                                <div class="text-xs font-bold text-emerald-800">{{ $item['name'] }}</div>
                                <div class="text-[10px] text-emerald-600 mb-2">{{ $item['sound'] }}</div>
                            </div>
                            <div class="bg-white p-2 rounded-xl text-left border border-emerald-100">
                                <div class="text-xs font-semibold text-slate-700">{{ $item['sample'] ?? '' }}</div>
                                <div class="text-[10px] font-bold text-emerald-700">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Vowels -->
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">10 Vokal Dasar & 11 Vokal Gabungan</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 gap-3">
                    @foreach(array_merge($alphabetData['basic_vowels'], $alphabetData['compound_vowels']) as $item)
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-white text-center cursor-pointer hover:border-emerald-500 hover:shadow-md transition flex flex-col justify-between" onclick="speakText('{{ $item['char'] }}', 'ko')">
                            <div>
                                <div class="text-3xl font-bold font-korean text-slate-900 mb-1">{{ $item['char'] }}</div>
                                <div class="text-xs font-semibold text-emerald-700 mb-2">{{ $item['romaja'] }}</div>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-xl text-left border border-slate-100">
                                <div class="text-xs font-semibold text-slate-700 truncate">{{ $item['sample'] ?? '' }}</div>
                                <div class="text-[10px] font-bold text-emerald-700 truncate">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                            </div>
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
            <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">26 English Alphabets, Fonetik IPA & Terjemahan Bahasa Indonesia</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($alphabetData['letters'] as $item)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-white hover:border-blue-500 hover:shadow-md transition text-center cursor-pointer group flex flex-col justify-between" onclick="speakText('{{ $item['audio'] }}', 'en')">
                        <div>
                            <div class="text-3xl font-black text-slate-900 group-hover:text-blue-600 mb-1">{{ $item['char'] }}</div>
                            <div class="text-xs font-mono font-bold text-blue-600 mb-2">{{ $item['phonetic'] }}</div>
                        </div>
                        <div class="bg-slate-50 p-2 rounded-xl text-left border border-slate-100">
                            <div class="text-xs font-semibold text-slate-800">{{ $item['sample'] }}</div>
                            <div class="text-[10px] font-bold text-emerald-700">Arti: {{ $item['sample_meaning'] ?? '' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
