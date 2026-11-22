@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">

    <div class="bg-white rounded-3xl border border-slate-200 p-8 md:p-12 shadow-xl text-center">
        
        <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-6 shadow-inner">
            <i data-lucide="check-circle-2" class="w-10 h-10"></i>
        </div>

        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-200 inline-block mb-3">
            Hasil Tes Penempatan: {{ $pair->name }}
        </span>

        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">
            Level Rekomendasi Anda Ditemukan!
        </h1>
        <p class="text-sm text-slate-600 mb-8">
            Berdasarkan tes diagnosa, sistem merekomendasikan Anda memulai dari level berikut untuk pengalaman belajar yang optimal.
        </p>

        <!-- Level Card Highlight -->
        <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-left mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="px-3 py-1 rounded-lg bg-blue-600 text-white font-extrabold text-sm tracking-wider">
                    {{ $recommendedLevel->code ?? 'A1' }}
                </span>
                <span class="text-xs font-semibold text-slate-500">
                    Akurasi Skor: <strong class="text-blue-700 text-sm">{{ $percentage }}%</strong> ({{ $correctCount }}/{{ $totalQuestions }})
                </span>
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-1">
                {{ $recommendedLevel->name ?? 'Tingkat Dasar' }}
            </h3>
            <p class="text-xs text-slate-600 leading-relaxed mb-3">
                {{ $recommendedLevel->description ?? 'Fokus pemahaman dasar aksara, kosakata dan tata bahasa esensial.' }}
            </p>
            <div class="text-[11px] font-semibold text-indigo-700">
                Kategori: {{ $recommendedLevel->stage_category ?? 'Pemula' }}
            </div>
        </div>

        <!-- Action CTAs -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('learn.index', ['slug' => $pair->slug, 'level' => $recommendedLevel->code ?? 'A1']) }}" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm hover:opacity-95 transition shadow-lg flex items-center justify-center gap-2">
                <span>Mulai Belajar di Level Ini</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
            <a href="{{ route('placement.show', $pair->slug) }}" class="px-6 py-3.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-sm hover:bg-slate-100 transition">
                Ulangi Tes
            </a>
        </div>
    </div>

</div>
@endsection
