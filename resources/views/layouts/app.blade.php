<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ?? 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'LinguaPro — Platform Belajar Bahasa Terstruktur' }}</title>

    <!-- Tailwind CSS CDN for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        },
                        emerald: {
                            500: '#10b981',
                            600: '#059669',
                        }
                    },
                    fontFamily: {
                        arabic: ['"Amiri"', '"Noto Naskh Arabic"', 'serif'],
                        japanese: ['"Noto Sans JP"', 'sans-serif'],
                        korean: ['"Noto Sans KR"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Multi-Language Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&family=Noto+Sans+KR:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-arabic { font-family: 'Amiri', serif; }
        .font-japanese { font-family: 'Noto Sans JP', sans-serif; }
        .font-korean { font-family: 'Noto Sans KR', sans-serif; }
        
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Navigation -->
    <header class="no-print bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-2.5 sm:space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md">
                        <i data-lucide="languages" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </div>
                    <span class="text-lg sm:text-xl font-black bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">LinguaPro</span>
                </a>
                <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                    CEFR • JLPT • TOPIK • Arabic
                </span>
            </div>

            <!-- Desktop Nav Links -->
            <nav class="hidden sm:flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1.5 transition">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    <span>Pilihan Bahasa</span>
                </a>
                <a href="{{ route('alphabet.index', 'ar') }}" class="text-xs sm:text-sm font-semibold text-slate-600 hover:text-blue-600 flex items-center gap-1.5 transition">
                    <i data-lucide="type" class="w-4 h-4"></i>
                    <span>Aksara Lengkap</span>
                </a>
                <div class="h-4 w-px bg-slate-200"></div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Vibe Coding Active
                    </span>
                </div>
            </nav>

            <!-- Mobile Quick Header Badge -->
            <div class="flex sm:hidden items-center gap-2">
                <a href="{{ route('alphabet.index', 'ar') }}" class="p-2 rounded-xl bg-slate-100 text-slate-700 hover:text-blue-600 transition" title="Aksara">
                    <i data-lucide="type" class="w-4 h-4"></i>
                </a>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                    Online
                </span>
            </div>
        </div>
    </header>

    <!-- Notification Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full no-print">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600"></i>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1 pb-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="no-print bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500 mb-14 sm:mb-0">
        <div class="max-w-7xl mx-auto px-4">
            <p>LinguaPro Multi-Language Structured Learning Platform &copy; {{ date('Y') }}. Dibangun sesuai standar AI Rules & Kontrak AGENTS.md.</p>
        </div>
    </footer>

    <!-- Mobile Global Bottom Navigation Dock (Responsive Mobile App Experience) -->
    <nav class="sm:hidden fixed bottom-0 left-0 right-0 h-14 bg-white/95 backdrop-blur-md border-t border-slate-200 z-40 flex items-center justify-around px-2 shadow-lg no-print">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center text-[10px] font-bold {{ request()->routeIs('home') ? 'text-blue-600' : 'text-slate-500' }}">
            <i data-lucide="home" class="w-5 h-5 mb-0.5"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('alphabet.index', 'ar') }}" class="flex flex-col items-center justify-center text-[10px] font-bold {{ request()->routeIs('alphabet.*') ? 'text-blue-600' : 'text-slate-500' }}">
            <i data-lucide="type" class="w-5 h-5 mb-0.5"></i>
            <span>Aksara</span>
        </a>
        <a href="{{ route('home') }}#pairs-grid" class="flex flex-col items-center justify-center text-[10px] font-bold text-slate-500 hover:text-blue-600">
            <i data-lucide="languages" class="w-5 h-5 mb-0.5"></i>
            <span>Bahasa</span>
        </a>
    </nav>

    <!-- Audio Speaking Toast Indicator -->
    <div id="audioSpeakingToast" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 px-4 py-2 rounded-full bg-slate-900/90 text-white text-xs font-semibold backdrop-blur-md shadow-xl flex items-center gap-2 transition-all duration-300 opacity-0 pointer-events-none translate-y-[-10px]">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
        <i data-lucide="volume-2" class="w-4 h-4 text-blue-400"></i>
        <span id="audioSpeakingLabel">Pelafalan Audio Aktif</span>
    </div>

    <!-- Web Speech API Universal Pronunciation Engine (High-Fidelity) -->
    <script>
        let availableVoices = [];

        function initVoices() {
            if ('speechSynthesis' in window) {
                availableVoices = window.speechSynthesis.getVoices();
            }
        }

        initVoices();
        if ('speechSynthesis' in window && window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = initVoices;
        }

        // Sanitasi teks agar penutur asli tidak membaca kurung transliterasi/latin
        function sanitizeTextForSpeech(text, langCode) {
            if (!text) return '';
            let cleaned = text.trim();

            if (langCode === 'ja') {
                // Untuk Jepang: jika ada kurung latin seperti 'アイス (Aisu)', hapus latin
                cleaned = cleaned.replace(/\([a-zA-Z\s\/\-]+\)/g, '');
                // Jika ada format 'ほん (本)', ambil kana 'ほん' agar pelafalannya akurat
                if (cleaned.includes('(')) {
                    const parts = cleaned.split('(');
                    if (parts[0].trim().length > 0) cleaned = parts[0].trim();
                }
            } else if (langCode === 'ar') {
                // Untuk Arab: buang kurung latin seperti '(Abun)'
                cleaned = cleaned.replace(/\([a-zA-Z\s\/\-\'\`]+\)/g, '').trim();
            } else if (langCode === 'ko') {
                // Untuk Korea: buang kurung romaja seperti '(Gabang)'
                cleaned = cleaned.replace(/\([a-zA-Z\s\/\-]+\)/g, '').trim();
            } else if (langCode === 'en') {
                // Untuk Inggris: buang simbol fonetik slash atau kurung
                cleaned = cleaned.replace(/\/.*?\//g, '').replace(/\(.*?\)/g, '').trim();
            }

            return cleaned.trim() || text;
        }

        function speakText(text, langCode) {
            if (!('speechSynthesis' in window)) {
                alert('Browser Anda belum mendukung Text-To-Speech Web Speech API.');
                return;
            }

            window.speechSynthesis.cancel(); // Hentikan audio sebelumnya

            const cleanScript = sanitizeTextForSpeech(text, langCode);
            const utterance = new SpeechSynthesisUtterance(cleanScript);
            
            // Map Language Codes ke standar BCP 47
            const langMap = {
                'ar': 'ar-SA',
                'ja': 'ja-JP',
                'ko': 'ko-KR',
                'en': 'en-US',
                'id': 'id-ID'
            };

            const targetLocale = langMap[langCode] || langCode;
            utterance.lang = targetLocale;

            // Pilih voice asli jika tersedia di sistem klien
            if (availableVoices.length === 0) {
                availableVoices = window.speechSynthesis.getVoices();
            }

            const matchedVoice = availableVoices.find(v => v.lang === targetLocale || v.lang.startsWith(langCode));
            if (matchedVoice) {
                utterance.voice = matchedVoice;
            }

            // Atur kecepatan agar jernih dan ramah bagi pelajar bahasa
            utterance.rate = (langCode === 'ja' || langCode === 'ko') ? 0.85 : 0.88;
            utterance.pitch = 1.0;

            // Tampilkan visual toast
            const toast = document.getElementById('audioSpeakingToast');
            const label = document.getElementById('audioSpeakingLabel');
            if (toast && label) {
                label.innerText = 'Memutar: ' + cleanScript;
                toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
                toast.classList.add('opacity-100', 'translate-y-0');
            }

            utterance.onend = () => {
                if (toast) {
                    toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
                    toast.classList.remove('opacity-100', 'translate-y-0');
                }
            };

            utterance.onerror = () => {
                if (toast) {
                    toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
                }
            };

            window.speechSynthesis.speak(utterance);
        }

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
