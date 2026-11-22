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
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ $pair->name }}
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
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-800 text-xs font-black">
                    LEVEL {{ $selectedLevel->code }}
                </span>
                <span class="text-xs font-semibold text-slate-500">
                    Kategori: {{ $selectedLevel->stage_category }}
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">
                {{ $selectedLevel->name }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                {{ $selectedLevel->description }}
            </p>
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

    <!-- Units & Lessons Grid -->
    <div class="space-y-6">
        @if($selectedLevel->units->isNotEmpty())
            @foreach($selectedLevel->units as $unit)
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="p-6 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600">UNIT {{ $unit->sort_order }}</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900">{{ $unit->title }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $unit->description }}</p>
                        </div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($unit->lessons as $lesson)
                            @php
                                $isDone = $lesson->progresses->where('is_completed', true)->isNotEmpty();
                            @endphp
                            <div class="p-4 sm:p-5 flex items-center justify-between hover:bg-slate-50 transition">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-9 h-9 rounded-xl {{ $isDone ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        @if($isDone)
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        @else
                                            {{ $lesson->sort_order }}
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">{{ $lesson->title }}</h4>
                                        <div class="flex items-center gap-2 text-[11px] text-slate-500 mt-0.5">
                                            <span class="capitalize">{{ $lesson->content_type }}</span>
                                            <span>•</span>
                                            <span>{{ count($lesson->content_body['vocabularies'] ?? ($lesson->content_body['alphabets'] ?? [])) }} item materi</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('lesson.show', $lesson->id) }}" class="px-4 py-2 rounded-xl {{ $isDone ? 'bg-slate-100 text-slate-700 hover:bg-slate-200' : 'bg-blue-600 text-white hover:bg-blue-700' }} text-xs font-semibold transition flex items-center gap-1.5 shadow-sm">
                                    <span>{{ $isDone ? 'Ulangi' : 'Mulai Belajar' }}</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <!-- Placeholder for levels in progression -->
            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center">
                <i data-lucide="layers" class="w-12 h-12 text-slate-300 mx-auto mb-3"></i>
                <h3 class="text-base font-bold text-slate-800 mb-1">Kurikulum Level {{ $selectedLevel->code }} Siap Dikerjakan</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                    Materi disusun berjenjang mengikuti standar resmi. Anda dapat langsung menguji kompetensi level ini untuk penerbitan sertifikat digital.
                </p>
                <a href="{{ route('exam.show', $selectedLevel->id) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-500 text-white font-bold text-xs shadow-md hover:bg-amber-600 transition">
                    <i data-lucide="award" class="w-4 h-4"></i>
                    <span>Ikuti Ujian Penilaian Level {{ $selectedLevel->code }}</span>
                </a>
            </div>
        @endif
    </div>

</div>
@endsection
