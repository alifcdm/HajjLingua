@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xl mb-8">
        
        <!-- Header -->
        <div class="p-8 bg-gradient-to-r from-amber-600 via-amber-700 to-yellow-700 text-white text-center">
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center mx-auto mb-4 border border-white/20">
                <i data-lucide="award" class="w-8 h-8 text-yellow-300"></i>
            </div>
            <span class="px-3 py-1 rounded-full bg-white/20 text-xs font-black uppercase tracking-wider mb-2 inline-block">
                UJIAN AKHIR KELULUSAN RESMI
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold mb-2">
                {{ $level->language->name }} — Level {{ $level->code }}
            </h1>
            <p class="text-xs sm:text-sm text-amber-100 max-w-xl mx-auto">
                {{ $level->name }}. Selesaikan evaluasi ini dengan nilai minimal <strong>80%</strong> untuk menerbitkan sertifikat digital resmi Anda.
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('exam.submit', $level->id) }}" method="POST" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- Recipient Name Input -->
            <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200">
                <label for="recipient_name" class="block text-xs font-bold uppercase tracking-wider text-amber-900 mb-1">
                    Nama Lengkap Pemilik Sertifikat (Akan tertera di Sertifikat) <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="recipient_name" id="recipient_name" required placeholder="Contoh: Muhammad Alif Pratama" class="w-full px-4 py-3 rounded-xl border border-amber-300 bg-white text-slate-900 font-semibold text-sm focus:ring-2 focus:ring-amber-500 focus:outline-none">
                <p class="text-[11px] text-amber-700 mt-1">Pastikan nama sesuai identitas resmi Anda.</p>
            </div>

            <!-- Exam Questions -->
            <div class="space-y-6">
                @foreach($questions as $index => $q)
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-amber-800">Pertanyaan {{ $index + 1 }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3">{{ $q->question_text }}</h3>

                        @if(!empty($q->prompt_script))
                            <div class="text-2xl font-bold text-slate-900 mb-3 {{ $level->language->code === 'ar' ? 'font-arabic text-3xl' : '' }}">
                                {{ $q->prompt_script }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($q->options_json as $opt)
                                <label class="flex items-center p-3 rounded-xl border border-slate-200 bg-white hover:border-amber-500 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" required class="w-4 h-4 text-amber-600 focus:ring-amber-500 border-slate-300 mr-2.5">
                                    <span class="text-xs font-medium text-slate-700">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('learn.index', ['slug' => $pair->slug ?? 'id-ar', 'level' => $level->code]) }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                    Batal & Kembali
                </a>
                <button type="submit" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-amber-600 to-yellow-600 text-white font-extrabold text-sm hover:opacity-95 transition shadow-lg flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                    <span>Kirim Jawaban & Terbitkan Sertifikat</span>
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
