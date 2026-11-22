@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">

    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-lg text-center">

        @if($isValid && $certificate)
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shield-check" class="w-8 h-8"></i>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-black uppercase tracking-wider mb-2 inline-block">
                SERTIFIKAT RESMI TERVERIFIKASI
            </span>
            <h1 class="text-2xl font-bold text-slate-900 mb-6">
                Data Sertifikasi Valid & Asli
            </h1>

            <div class="text-left p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 mb-8">
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400">Nama Penerima</div>
                    <div class="text-base font-bold text-slate-900">{{ $certificate->recipient_name }}</div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-[10px] uppercase font-bold text-slate-400">Bahasa & Level</div>
                        <div class="text-sm font-semibold text-slate-800">{{ $certificate->language->name }} ({{ $certificate->level->code }})</div>
                    </div>
                    <div>
                        <div class="text-[10px] uppercase font-bold text-slate-400">Nilai Akhir</div>
                        <div class="text-sm font-semibold text-emerald-600">{{ $certificate->final_score }}%</div>
                    </div>
                </div>
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400">Tanggal Terbit</div>
                    <div class="text-xs text-slate-600">{{ $certificate->issued_at->format('d F Y, H:i:s') }}</div>
                </div>
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400">Kode UUID</div>
                    <div class="text-[11px] font-mono text-slate-600">{{ $certificate->uuid }}</div>
                </div>
            </div>

            <a href="{{ route('certificate.show', $certificate->uuid) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-bold text-xs hover:bg-blue-700 transition shadow-md">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                <span>Buka Dokumen Sertifikat Asli</span>
            </a>
        @else
            <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shield-alert" class="w-8 h-8"></i>
            </div>
            <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-black uppercase tracking-wider mb-2 inline-block">
                TIDAK DITEMUKAN
            </span>
            <h1 class="text-2xl font-bold text-slate-900 mb-2">
                Sertifikat Tidak Valid
            </h1>
            <p class="text-xs text-slate-500 mb-6">
                Nomor verifikasi UUID: <span class="font-mono text-slate-700">{{ $uuid }}</span> tidak terdaftar dalam basis data resmi LinguaPro.
            </p>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition">
                Kembali ke Beranda
            </a>
        @endif

    </div>

</div>
@endsection
