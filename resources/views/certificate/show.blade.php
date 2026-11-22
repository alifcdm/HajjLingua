@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- Action Toolbar (Hidden in print) -->
    <div class="no-print mb-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600 flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Dashboard
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition shadow-md flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                <span>Cetak / Unduh PDF</span>
            </button>
            <a href="{{ route('certificate.verify', $certificate->uuid) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 font-semibold text-xs hover:bg-blue-100 transition flex items-center gap-1.5">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>Cek Verifikasi Publik</span>
            </a>
        </div>
    </div>

    <!-- Official Certificate Document Container -->
    <div class="bg-white rounded-3xl border-8 border-amber-600/30 p-8 sm:p-14 shadow-2xl relative overflow-hidden text-center my-4 print:my-0 print:border-4 print:shadow-none print:rounded-none">
        
        <!-- Luxury Inner Border -->
        <div class="border-2 border-dashed border-amber-500/40 p-6 sm:p-12 relative">

            <!-- Watermark Background -->
            <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none select-none">
                <i data-lucide="award" class="w-96 h-96 text-amber-700"></i>
            </div>

            <!-- Top Seal / Badge -->
            <div class="mb-6 flex justify-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-amber-600 to-yellow-500 text-white flex items-center justify-center shadow-lg border-4 border-amber-100">
                    <i data-lucide="award" class="w-10 h-10"></i>
                </div>
            </div>

            <div class="uppercase tracking-widest text-xs font-black text-amber-700 mb-2">
                LINGUAPRO INTERNATIONAL LANGUAGE COUNCIL
            </div>

            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight uppercase mb-4" style="font-family: serif;">
                Sertifikat Kelulusan
            </h1>

            <p class="text-xs sm:text-sm text-slate-500 italic mb-8">
                Dengan ini menerangkan bahwa peserta didik di bawah ini telah menyelesaikan seluruh kurikulum dan lulus ujian evaluasi standar resmi:
            </p>

            <!-- Recipient Name -->
            <div class="mb-8">
                <div class="text-3xl sm:text-4xl font-extrabold text-blue-900 border-b-2 border-slate-300 pb-3 max-w-lg mx-auto inline-block">
                    {{ $certificate->recipient_name }}
                </div>
            </div>

            <!-- Achievement Level Description -->
            <div class="max-w-2xl mx-auto mb-10 text-slate-700 text-sm leading-relaxed">
                Telah dinyatakan kompeten dan lulus pada program bahasa:
                <div class="text-xl sm:text-2xl font-black text-slate-900 my-2">
                    {{ $certificate->language->name }} — Level {{ $certificate->level->code }}
                </div>
                <div class="text-xs font-semibold text-slate-600 mb-1">
                    {{ $certificate->level->name }} (Standar {{ $certificate->level->stage_category }})
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold mt-2">
                    <i data-lucide="check" class="w-3.5 h-3.5"></i>
                    <span>Nilai Kelulusan: {{ $certificate->final_score }}%</span>
                </div>
            </div>

            <!-- Bottom Signatures & Verification Hash -->
            <div class="pt-8 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-3 gap-6 items-end text-left">
                <div>
                    <div class="text-[10px] uppercase font-bold text-slate-400">Tanggal Terbit</div>
                    <div class="text-xs font-bold text-slate-800">{{ $certificate->issued_at->format('d F Y') }}</div>
                </div>

                <div class="text-center">
                    <div class="w-24 h-12 border-b-2 border-slate-400 mx-auto mb-1 flex items-end justify-center">
                        <span class="text-xs font-bold text-blue-900 italic font-serif">LinguaPro Auth</span>
                    </div>
                    <div class="text-[10px] uppercase font-bold text-slate-500">Academic Director</div>
                </div>

                <div class="sm:text-right">
                    <div class="text-[10px] uppercase font-bold text-slate-400">UUID Verifikasi</div>
                    <div class="text-[10px] font-mono text-slate-600 break-all select-all">{{ $certificate->uuid }}</div>
                    <div class="text-[9px] text-slate-400 font-mono mt-0.5 truncate">{{ substr($certificate->verification_hash, 0, 24) }}...</div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
