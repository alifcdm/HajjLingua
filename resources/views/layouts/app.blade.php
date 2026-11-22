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
                <a href="{{ route('hajj.index') }}" class="text-xs sm:text-sm font-bold {{ request()->routeIs('hajj.*') ? 'text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200' : 'text-slate-600 hover:text-emerald-700' }} flex items-center gap-1.5 transition">
                    <i data-lucide="compass" class="w-4 h-4 text-emerald-600"></i>
                    <span>Modul Haji</span>
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
                <a href="{{ route('hajj.index') }}" class="p-2 rounded-xl bg-emerald-50 text-emerald-700 hover:text-emerald-800 transition" title="Modul Haji">
                    <i data-lucide="compass" class="w-4 h-4"></i>
                </a>
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
        <a href="{{ route('hajj.index') }}" class="flex flex-col items-center justify-center text-[10px] font-bold {{ request()->routeIs('hajj.*') ? 'text-emerald-600' : 'text-slate-500' }}">
            <i data-lucide="compass" class="w-5 h-5 mb-0.5"></i>
            <span>Haji</span>
        </a>
        <a href="{{ route('home') }}#pairs-grid" class="flex flex-col items-center justify-center text-[10px] font-bold text-slate-500 hover:text-blue-600">
            <i data-lucide="languages" class="w-5 h-5 mb-0.5"></i>
            <span>Bahasa</span>
        </a>
    </nav>

    <!-- Audio Speaking Toast Indicator -->
    <div id="audioSpeakingToast" class="fixed top-20 left-1/2 -translate-x-1/2 z-50 max-w-md w-[90%] sm:w-auto px-4 py-2.5 rounded-2xl bg-slate-900/95 text-white text-xs font-semibold backdrop-blur-md shadow-2xl flex items-center gap-2.5 transition-all duration-300 opacity-0 pointer-events-none translate-y-[-10px]">
        <span id="audioSpeakingDot" class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping flex-shrink-0"></span>
        <i id="audioSpeakingIcon" data-lucide="volume-2" class="w-4 h-4 text-blue-400 flex-shrink-0"></i>
        <span id="audioSpeakingLabel" class="truncate">Pelafalan Audio Aktif</span>
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

            if (['ar', 'ja', 'ko', 'zh'].includes(langCode)) {
                cleaned = cleaned.replace(/\([a-zA-Z0-9\s\/\-\'\`’āáǎàēéěèīíǐìōóǒòūúǔùǖǘǚǜ\,\.]+\)/g, '').trim();
            } else if (langCode === 'en') {
                cleaned = cleaned.replace(/\/.*?\//g, '').replace(/\(.*?\)/g, '').trim();
            }

            cleaned = cleaned.replace(/[\r\n]+/g, ' ').replace(/["'“”‘’]/g, '');

            return cleaned.trim() || text;
        }

        function showAudioToast(message, isWarning = false) {
            const toast = document.getElementById('audioSpeakingToast');
            const label = document.getElementById('audioSpeakingLabel');
            const dot = document.getElementById('audioSpeakingDot');
            const icon = document.getElementById('audioSpeakingIcon');
            if (toast && label) {
                label.innerText = message;
                if (isWarning) {
                    toast.classList.remove('bg-slate-900/95');
                    toast.classList.add('bg-amber-900/95', 'border', 'border-amber-500/50');
                    if (dot) dot.classList.replace('bg-emerald-400', 'bg-amber-400');
                    if (icon) icon.classList.replace('text-blue-400', 'text-amber-300');
                } else {
                    toast.classList.remove('bg-amber-900/95', 'border', 'border-amber-500/50');
                    toast.classList.add('bg-slate-900/95');
                    if (dot) dot.classList.replace('bg-amber-400', 'bg-emerald-400');
                    if (icon) icon.classList.replace('text-amber-300', 'text-blue-400');
                }
                toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
                toast.classList.add('opacity-100', 'translate-y-0');
            }
        }

        function hideAudioToast() {
            const toast = document.getElementById('audioSpeakingToast');
            if (toast) {
                toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-[-10px]');
                toast.classList.remove('opacity-100', 'translate-y-0');
            }
        }

        function findNativeVoice(langCode) {
            if (availableVoices.length === 0 && 'speechSynthesis' in window) {
                availableVoices = window.speechSynthesis.getVoices();
            }

            const lang = (langCode || '').toLowerCase();
            const langRules = {
                'ar': {
                    prefixes: ['ar-', 'ar_'],
                    exact: ['ar', 'ar-sa', 'ar-eg', 'ar-ae', 'ar-kw', 'ar-qa'],
                    keywords: ['google', 'natural', 'arabic', 'العربية', 'hoda', 'naayf', 'salma', 'shakir', 'zariyah', 'maged', 'tarik']
                },
                'ja': {
                    prefixes: ['ja-', 'ja_'],
                    exact: ['ja', 'ja-jp'],
                    keywords: ['google', 'natural', 'japanese', '日本語', 'nanami', 'keita', 'ayumi', 'haruka', 'ichiro', 'sayaka', 'otoya']
                },
                'ko': {
                    prefixes: ['ko-', 'ko_'],
                    exact: ['ko', 'ko-kr'],
                    keywords: ['google', 'natural', 'korean', '한국어', 'sunhi', 'injoon', 'heami']
                },
                'zh': {
                    prefixes: ['zh-', 'zh_'],
                    exact: ['zh', 'zh-cn', 'zh-tw', 'zh-hk', 'zh-sg'],
                    keywords: ['google', 'natural', 'chinese', 'mandarin', '普通话', '中文', 'xiaoxiao', 'yunxi', 'yunjian', 'xiaoyi', 'huihui', 'yaoyao', 'kangkang']
                },
                'en': {
                    prefixes: ['en-', 'en_'],
                    exact: ['en', 'en-us', 'en-gb', 'en-au', 'en-ca'],
                    keywords: ['google', 'natural', 'english', 'david', 'mark', 'zira', 'george', 'samantha']
                },
                'id': {
                    prefixes: ['id-', 'id_'],
                    exact: ['id', 'id-id'],
                    keywords: ['google', 'natural', 'indonesian', 'bahasa', 'gadis', 'ardi']
                }
            };

            const rule = langRules[lang];
            if (!rule) {
                return availableVoices.find(v => v.lang.toLowerCase().startsWith(lang));
            }

            // 1. Prioritas Tertinggi: Google Voice & Natural Neural Voices
            for (const v of availableVoices) {
                const voiceLang = v.lang.toLowerCase().replace('_', '-');
                const voiceName = v.name.toLowerCase();
                const isLangMatch = rule.exact.includes(voiceLang) || rule.prefixes.some(p => voiceLang.startsWith(p));
                if (isLangMatch && (voiceName.includes('google') || voiceName.includes('natural') || voiceName.includes('online'))) {
                    return v;
                }
            }

            // 2. Exact locale match
            for (const v of availableVoices) {
                const voiceLang = v.lang.toLowerCase().replace('_', '-');
                if (rule.exact.includes(voiceLang)) {
                    return v;
                }
            }

            // 3. Prefix match
            for (const v of availableVoices) {
                const voiceLang = v.lang.toLowerCase();
                if (rule.prefixes.some(p => voiceLang.startsWith(p))) {
                    return v;
                }
            }

            // 4. Name keywords match
            for (const v of availableVoices) {
                const voiceName = v.name.toLowerCase();
                if (rule.keywords.some(k => voiceName.includes(k))) {
                    return v;
                }
            }

            return null;
        }

        let activeFallbackAudio = null;

        function playTtsAudioFallback(cleanScript, langCode) {
            const gLangMap = {
                'ar': 'ar',
                'ja': 'ja',
                'ko': 'ko',
                'zh': 'zh-CN',
                'en': 'en',
                'id': 'id'
            };
            const tl = gLangMap[langCode] || langCode;
            const encodedText = encodeURIComponent(cleanScript.substring(0, 300));
            const url = `https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&tl=${tl}&q=${encodedText}`;

            if (activeFallbackAudio) {
                try {
                    activeFallbackAudio.pause();
                } catch(e) {}
                activeFallbackAudio = null;
            }

            activeFallbackAudio = new Audio(url);
            activeFallbackAudio.playbackRate = 0.95;
            activeFallbackAudio.onended = () => hideAudioToast();
            activeFallbackAudio.onerror = (e) => {
                console.warn('Fallback audio playback error:', e);
                hideAudioToast();
            };

            const playPromise = activeFallbackAudio.play();
            if (playPromise !== undefined) {
                playPromise.catch(err => {
                    console.warn('Audio play prevented:', err);
                    hideAudioToast();
                });
            }
        }

        function playVoice(buttonElement) {
            if (!buttonElement) return;
            const text = buttonElement.getAttribute('data-text') || buttonElement.getAttribute('data-audio') || buttonElement.innerText;
            const lang = buttonElement.getAttribute('data-lang') || 'en';
            speakText(text, lang);
        }
        window.playVoice = playVoice;

        function speakText(text, langCode) {
            const cleanScript = sanitizeTextForSpeech(text, langCode);
            if (!cleanScript) return;

            const langNames = {
                'ar': 'Bahasa Arab',
                'ja': 'Bahasa Jepang',
                'ko': 'Bahasa Korea',
                'zh': 'Bahasa Mandarin',
                'en': 'Bahasa Inggris',
                'id': 'Bahasa Indonesia'
            };

            const fallbackMap = {
                'en': 'en-US',
                'id': 'id-ID',
                'ar': 'ar-SA',
                'ja': 'ja-JP',
                'ko': 'ko-KR',
                'zh': 'zh-CN'
            };

            const langTitle = langNames[langCode] || langCode.toUpperCase();
            showAudioToast(`Pelafalan ${langTitle}: ${cleanScript}`);

            if (!('speechSynthesis' in window)) {
                playTtsAudioFallback(cleanScript, langCode);
                return;
            }

            // Pastikan antrean audio tidak freeze di Chrome/Edge
            if (window.speechSynthesis.speaking || window.speechSynthesis.pending) {
                window.speechSynthesis.cancel();
            }
            if (window.speechSynthesis.paused) {
                window.speechSynthesis.resume();
            }

            const utterance = new SpeechSynthesisUtterance(cleanScript);
            const targetVoice = findNativeVoice(langCode);
            if (targetVoice) {
                utterance.voice = targetVoice;
                utterance.lang = targetVoice.lang;
            } else {
                utterance.lang = fallbackMap[langCode] || (langCode.includes('-') ? langCode : 'en-US');
            }

            utterance.rate = 0.88;
            utterance.pitch = 1.0;

            utterance.onend = () => {
                hideAudioToast();
            };

            utterance.onerror = (e) => {
                console.warn('SpeechSynthesis event, falling back to Google TTS:', e);
                playTtsAudioFallback(cleanScript, langCode);
            };

            try {
                window.speechSynthesis.speak(utterance);
                setTimeout(() => {
                    if (window.speechSynthesis.paused) {
                        window.speechSynthesis.resume();
                    }
                }, 100);
            } catch(e) {
                console.warn('SpeechSynthesis exception:', e);
                playTtsAudioFallback(cleanScript, langCode);
            }
        }
        window.speakText = speakText;

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
