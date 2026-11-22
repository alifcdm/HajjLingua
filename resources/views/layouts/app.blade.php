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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md">
                        <i data-lucide="languages" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-transparent">LinguaPro</span>
                </a>
                <span class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                    CEFR • JLPT • TOPIK • Arabic
                </span>
            </div>

            <nav class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 flex items-center gap-1.5 transition">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    <span>Pilihan Bahasa</span>
                </a>
                <div class="h-4 w-px bg-slate-200"></div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                        Vibe Coding Active
                    </span>
                </div>
            </nav>
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
    <footer class="no-print bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p>LinguaPro Multi-Language Structured Learning Platform &copy; {{ date('Y') }}. Dibangun sesuai standar AI Rules & Kontrak AGENTS.md.</p>
        </div>
    </footer>

    <!-- Web Speech API Universal Pronunciation Engine -->
    <script>
        function speakText(text, langCode) {
            if (!('speechSynthesis' in window)) {
                alert('Browser Anda tidak mendukung Text-To-Speech Web Speech API.');
                return;
            }
            window.speechSynthesis.cancel(); // stop current audio

            const utterance = new SpeechSynthesisUtterance(text);
            
            // Map Language Codes
            const langMap = {
                'ar': 'ar-SA',
                'ja': 'ja-JP',
                'ko': 'ko-KR',
                'en': 'en-US',
                'id': 'id-ID'
            };

            utterance.lang = langMap[langCode] || langCode;
            utterance.rate = 0.85; // Slightly slower for language learners

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
