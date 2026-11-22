@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Top Navigation -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-blue-600 flex items-center gap-1 mb-1">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke Beranda
            </a>
            <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <span>100 Level Penguat Ingatan Memori</span>
                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase">
                    1.500 Soal Intensif
                </span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                {{ $level->language->name }} — Level {{ $level->code }}. 100 stage progresif, masing-masing 15 soal untuk mengunci penguasaan bahasa di memori jangka panjang.
            </p>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Penyelesaian Stage</div>
                <div class="text-xl font-black text-blue-700">{{ $completedCount }} <span class="text-xs text-slate-400">/ 100 Selesai</span></div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                <i data-lucide="trophy" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 100 Stages Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($stages as $stage)
            @php
                $prog = $stage->progresses->where('is_completed', true)->first();
                $isDone = $prog !== null;
            @endphp
            <div class="p-5 rounded-2xl border transition flex flex-col justify-between {{ $isDone ? 'bg-emerald-50/60 border-emerald-300 shadow-sm' : 'bg-white border-slate-200 hover:border-blue-400 hover:shadow-md' }}">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-black {{ $isDone ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                            STAGE {{ $stage->stage_number }}
                        </span>
                        @if($isDone)
                            <div class="flex text-amber-400 text-xs">
                                @for($i = 0; $i < ($prog->stars ?? 3); $i++)
                                    ★
                                @endfor
                            </div>
                        @else
                            <span class="text-[10px] font-semibold text-slate-400">15 Soal</span>
                        @endif
                    </div>

                    <h3 class="text-xs font-bold text-slate-800 line-clamp-2 mb-2">
                        {{ $stage->title }}
                    </h3>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100">
                    <a href="{{ route('drill.stage', $stage->id) }}" class="w-full py-2 px-3 rounded-xl {{ $isDone ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-blue-600 text-white hover:bg-blue-700' }} text-xs font-bold transition flex items-center justify-center gap-1 shadow-sm">
                        <span>{{ $isDone ? 'Latihan Lagi' : 'Mulai Stage' }}</span>
                        <i data-lucide="play" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
