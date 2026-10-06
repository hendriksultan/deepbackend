<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petualangan Hijaiyah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Nunito', sans-serif; 
            margin: 0;
            overflow-x: hidden;
            background: linear-gradient(180deg, #38bdf8 0%, #7dd3fc 50%, #bae6fd 100%);
            background-attachment: fixed;
        }
        [x-cloak] { display: none !important; }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ANIMASI AWAN */
        .cloud { position: absolute; background: #ffffff; border-radius: 100px; animation: moveCloud linear infinite; z-index: -1; }
        .cloud::before, .cloud::after { content: ''; position: absolute; background: #ffffff; border-radius: 50%; }
        .cloud::before { width: 50px; height: 50px; top: -20px; left: 15px; }
        .cloud::after { width: 70px; height: 70px; top: -30px; right: 20px; }
        .c1 { width: 140px; height: 40px; top: 10%; opacity: 0.9; animation-duration: 35s; transform: scale(1.2); }
        .c2 { width: 120px; height: 35px; top: 30%; opacity: 0.6; animation-duration: 50s; transform: scale(0.8); }
        .c3 { width: 160px; height: 45px; top: 55%; opacity: 0.8; animation-duration: 40s; transform: scale(1.5); }
        .c4 { width: 130px; height: 40px; top: 75%; opacity: 0.5; animation-duration: 60s; transform: scale(1); }
        .c5 { width: 150px; height: 40px; top: 15%; opacity: 0.4; animation-duration: 70s; transform: scale(0.6); }
        .c6 { width: 140px; height: 40px; top: 85%; opacity: 0.7; animation-duration: 45s; transform: scale(1.3); }
        @keyframes moveCloud { 0% { left: 100vw; } 100% { left: -300px; } }

        /* ANIMASI GELEMBUNG */
        .bubble {
            position: absolute; bottom: -50px; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: inset 0 0 10px rgba(255,255,255,0.6), 0 0 10px rgba(255,255,255,0.2);
            animation: floatUp infinite ease-in;
            z-index: -1;
        }
        @keyframes floatUp {
            0% { transform: translateY(0) scale(0.8) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            80% { opacity: 0.6; }
            100% { transform: translateY(-110vh) scale(1.2) translateX(30px); opacity: 0; }
        }
        .b1 { width: 40px; height: 40px; left: 10%; animation-duration: 8s; animation-delay: 0s; }
        .b2 { width: 25px; height: 25px; left: 25%; animation-duration: 5s; animation-delay: 2s; }
        .b3 { width: 50px; height: 50px; left: 40%; animation-duration: 10s; animation-delay: 4s; }
        .b4 { width: 30px; height: 30px; left: 55%; animation-duration: 7s; animation-delay: 1s; }
        .b5 { width: 60px; height: 60px; left: 70%; animation-duration: 12s; animation-delay: 3s; }
        .b6 { width: 35px; height: 35px; left: 85%; animation-duration: 6s; animation-delay: 5s; }

        button, a, .cloud, .bubble { -webkit-tap-highlight-color: transparent; touch-action: manipulation; user-select: none; }
    </style>
</head>
<body class="min-h-screen text-gray-800" x-data="hijaiyahGame()">

    {{-- ELEMEN BACKGROUND --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="cloud c1"></div> <div class="cloud c2"></div>
        <div class="cloud c3"></div> <div class="cloud c4"></div>
        <div class="cloud c5"></div> <div class="cloud c6"></div>
        <div class="bubble b1"></div> <div class="bubble b2"></div>
        <div class="bubble b3"></div> <div class="bubble b4"></div>
        <div class="bubble b5"></div> <div class="bubble b6"></div>
    </div>

   {{-- FLOATING BOTTOM NAVIGATION (MODERN PILL-STYLE) --}}
    <div class="fixed bottom-4 sm:bottom-6 left-1/2 transform -translate-x-1/2 z-50 w-[92%] max-w-[400px]">
        <div class="bg-white/90 backdrop-blur-md p-1.5 sm:p-2 rounded-full shadow-2xl border-2 border-white flex items-center gap-2">
            
            {{-- Tombol Home --}}
            <a href="{{ route('student.dashboard') }}" class="flex-shrink-0 bg-blue-50 hover:bg-blue-100 text-blue-600 p-3 rounded-full transition-transform active:scale-95 shadow-inner border border-blue-100" aria-label="Menu Utama">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </a>

            {{-- Tabs Switcher --}}
            <div class="flex flex-1 bg-gray-100 p-1 rounded-full relative shadow-inner">
                <a href="#" class="w-1/2 flex items-center justify-center py-2.5 rounded-full font-bold text-[10px] sm:text-xs transition-all bg-[#a855f7] text-white shadow-md transform hover:scale-105">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Hijaiyah
                </a>
                <a href="{{ route('student.iqro') }}" class="w-1/2 flex items-center justify-center py-2.5 rounded-full font-bold text-[10px] sm:text-xs transition-all text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Iqro
                </a>
            </div>
            
        </div>
    </div>

    {{-- Jarak kecil di atas frame --}}
    <div class="h-4 sm:h-6"></div>

    {{-- KONTEN HIJAIYAH (Frame Utama) --}}
    {{-- PERHATIAN: class 'overflow-hidden' telah dihapus dari sini agar posisi sticky berfungsi sempurna --}}
    <div class="relative z-10 w-full max-w-md mx-auto bg-[#e4f1fd] min-h-[100vh] sm:min-h-[850px] sm:mb-10 sm:rounded-[3rem] sm:border-[12px] border-gray-800 shadow-2xl flex flex-col pb-28">
        
        {{-- ========================================== --}}
        {{-- AREA STICKY TOP (Menempel saat di-scroll)    --}}
        {{-- ========================================== --}}
        <div class="sticky top-0 z-40 bg-[#e4f1fd] sm:rounded-t-[2.2rem] shadow-sm pb-2 border-b border-[#c8e1f8]">
            
            {{-- Header (Diberi border melengkung juga agar rapi di desktop) --}}
            <div class="flex items-center gap-4 px-5 pt-6 pb-4 bg-white/50 backdrop-blur-sm border-b border-white sm:rounded-t-[2.2rem]">
                <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center shadow-sm text-gray-700">
                    <svg class="w-6 h-6 text-[#5bc5f3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <div>
                    <h1 class="font-black text-gray-800 text-lg leading-tight tracking-wide">Huruf Hijaiyah</h1>
                    <p class="text-xs text-gray-500 font-bold">Mengenal Harakat</p>
                </div>
            </div>

            {{-- Tabs Switcher Harakat --}}
            <div class="flex px-4 pt-4 gap-2 overflow-x-auto no-scrollbar snap-x">
                <template x-for="tab in tabs" :key="tab.id">
                    <button @click="changeTab(tab.id)" 
                            class="snap-start shrink-0 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all shadow-sm flex flex-col items-center border-2"
                            :class="activeTab === tab.id ? 'bg-[#5bc5f3] text-white border-[#5bc5f3]' : 'bg-white text-gray-500 border-white hover:border-gray-100'">
                        <span x-text="tab.name"></span>
                        <span x-show="tab.sub" class="text-[9px] opacity-90 mt-0.5" x-text="tab.sub"></span>
                    </button>
                </template>
            </div>

            {{-- Hero Box (Huruf Aktif) --}}
            <div class="px-5 mt-4 mb-3">
                <div class="bg-[#5bc5f3] rounded-[2rem] p-5 shadow-lg text-white flex items-center justify-between relative overflow-hidden h-36">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-white/20 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="text-7xl font-arab font-bold drop-shadow-md w-1/2 text-center" dir="rtl" x-text="getDisplayedArabic(activeLetter)"></div>
                    
                    <div class="w-1/2 flex flex-col items-center justify-center border-l border-white/30 pl-3">
                        <p class="font-bold text-xs opacity-90 tracking-wide uppercase">Huruf <span x-text="activeLetter.name"></span></p>
                        <p class="text-[11px] bg-white/20 px-3 py-1 rounded-full font-bold text-white mt-1.5 mb-3">Bunyi: "<span x-text="getDisplayedLatin(activeLetter)"></span>"</p>
                        
                        <button @click="playAudio(activeLetter)" class="bg-white text-[#5bc5f3] px-4 py-2 rounded-full font-black text-xs flex items-center gap-1.5 shadow-md active:scale-95 transition-transform">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg>
                            Dengar
                        </button>
                    </div>
                </div>
            </div>

            {{-- Progress Bar --}}
            <div class="px-6 flex items-center justify-between mb-1 mt-1">
                <div class="h-1.5 flex-1 bg-white rounded-full overflow-hidden mr-3 shadow-inner">
                    <div class="h-full bg-green-400 rounded-full transition-all duration-500" :style="`width: ${(progress / letters.length) * 100}%`"></div>
                </div>
                <span class="text-[10px] font-black text-gray-400"><span x-text="progress"></span> / <span x-text="letters.length"></span></span>
            </div>
        </div>
        {{-- ========================================== --}}
        {{-- AKHIR AREA STICKY                          --}}
        {{-- ========================================== --}}


        {{-- AREA SCROLLABLE (Grid Huruf - 4 Kolom) --}}
        <div class="px-4 grid grid-cols-4 gap-1.5 sm:gap-2 pt-4 pb-6" dir="rtl">
            <template x-for="letter in letters" :key="letter.id">
                <button @click="selectLetter(letter.id)" 
                        class="aspect-square rounded-xl sm:rounded-2xl flex flex-col items-center justify-center shadow-sm transition-all relative overflow-hidden"
                        :class="activeLetterId === letter.id ? 'bg-[#5bc5f3] border-b-4 border-[#3ca9d6]' : 'bg-white hover:bg-gray-50 border-b-4 border-gray-100'">
                    
                    <div x-show="isLearned(letter.id)" class="absolute top-1 right-1 w-3.5 h-3.5 sm:w-4 sm:h-4 bg-green-400 rounded-full flex items-center justify-center shadow-sm z-10">
                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>

                    <span class="text-3xl sm:text-4xl font-arab font-bold mt-1" x-text="getDisplayedArabic(letter)" :class="activeLetterId === letter.id ? 'text-white' : 'text-gray-700'"></span>
                    <span class="text-[9px] sm:text-[10px] font-sans font-black mt-1 tracking-wider" dir="ltr" x-text="getDisplayedLatin(letter)" :class="activeLetterId === letter.id ? 'text-white' : 'text-gray-400'"></span>
                </button>
            </template>
        </div>
        
        {{-- Tombol Reset --}}
        <div class="px-5 pb-5 text-center mt-auto">
            <button @click="resetGame()" class="text-[11px] font-bold text-gray-400 hover:text-red-500 underline transition-colors bg-white/50 px-4 py-2 rounded-full shadow-sm">Reset Progress Harakat Ini</button>
        </div>
    </div>

    {{-- Audio Elements --}}
    <div class="hidden">
        <audio id="audio-success" preload="auto"><source src="/audio/success-chime.mp3" type="audio/mpeg"></audio>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('hijaiyahGame', () => ({
                activeTab: 'asli',
                activeLetterId: 1,
                
                tabs: [
                    { id: 'asli', name: 'Tanpa Tanda', sub: '' },
                    { id: 'fathah', name: 'Fathah', sub: 'bunyi "a"' },
                    { id: 'kasrah', name: 'Kasrah', sub: 'bunyi "i"' },
                    { id: 'dhammah', name: 'Dhammah', sub: 'bunyi "u"' },
                ],

                learned: JSON.parse(localStorage.getItem('hijaiyah_progress_harakat')) || {
                    asli: [], fathah: [], kasrah: [], dhammah: []
                },

                letters: [
                    { id: 1, ar: 'ا', name: 'Alif', f: 'a', k: 'i', d: 'u', audio: 'alif' },
                    { id: 2, ar: 'ب', name: 'Ba', f: 'ba', k: 'bi', d: 'bu', audio: 'ba' },
                    { id: 3, ar: 'ت', name: 'Ta', f: 'ta', k: 'ti', d: 'tu', audio: 'ta' },
                    { id: 4, ar: 'ث', name: 'Tsa', f: 'tsa', k: 'tsi', d: 'tsu', audio: 'tsa' },
                    { id: 5, ar: 'ج', name: 'Jim', f: 'ja', k: 'ji', d: 'ju', audio: 'jim' },
                    { id: 6, ar: 'ح', name: 'Ha', f: 'ha', k: 'hi', d: 'hu', audio: 'ha' },
                    { id: 7, ar: 'خ', name: 'Kha', f: 'kha', k: 'khi', d: 'khu', audio: 'kha' },
                    { id: 8, ar: 'د', name: 'Dal', f: 'da', k: 'di', d: 'du', audio: 'dal' },
                    { id: 9, ar: 'ذ', name: 'Dzal', f: 'dza', k: 'dzi', d: 'dzu', audio: 'dzal' },
                    { id: 10, ar: 'ر', name: 'Ra', f: 'ra', k: 'ri', d: 'ru', audio: 'ra' },
                    { id: 11, ar: 'ز', name: 'Zai', f: 'za', k: 'zi', d: 'zu', audio: 'zai' },
                    { id: 12, ar: 'س', name: 'Sin', f: 'sa', k: 'si', d: 'su', audio: 'sin' },
                    { id: 13, ar: 'ش', name: 'Syin', f: 'sya', k: 'syi', d: 'syu', audio: 'syin' },
                    { id: 14, ar: 'ص', name: 'Shad', f: 'sha', k: 'shi', d: 'shu', audio: 'shad' },
                    { id: 15, ar: 'ض', name: 'Dhad', f: 'dha', k: 'dhi', d: 'dhu', audio: 'dhad' },
                    { id: 16, ar: 'ط', name: 'Tha', f: 'tha', k: 'thi', d: 'thu', audio: 'tha' },
                    { id: 17, ar: 'ظ', name: 'Zha', f: 'zha', k: 'zhi', d: 'zhu', audio: 'zha' },
                    { id: 18, ar: 'ع', name: 'Ain', f: "'a", k: "'i", d: "'u", audio: 'ain' },
                    { id: 19, ar: 'غ', name: 'Ghain', f: 'gha', k: 'ghi', d: 'ghu', audio: 'ghain' },
                    { id: 20, ar: 'ف', name: 'Fa', f: 'fa', k: 'fi', d: 'fu', audio: 'fa' },
                    { id: 21, ar: 'ق', name: 'Qaf', f: 'qa', k: 'qi', d: 'qu', audio: 'qaf' },
                    { id: 22, ar: 'ك', name: 'Kaf', f: 'ka', k: 'ki', d: 'ku', audio: 'kaf' },
                    { id: 23, ar: 'ل', name: 'Lam', f: 'la', k: 'li', d: 'lu', audio: 'lam' },
                    { id: 24, ar: 'م', name: 'Mim', f: 'ma', k: 'mi', d: 'mu', audio: 'mim' },
                    { id: 25, ar: 'ن', name: 'Nun', f: 'na', k: 'ni', d: 'nu', audio: 'nun' },
                    { id: 26, ar: 'و', name: 'Wawu', f: 'wa', k: 'wi', d: 'wu', audio: 'wawu' },
                    { id: 27, ar: 'هـ', name: 'Ha', f: 'ha', k: 'hi', d: 'hu', audio: 'ha_besar' },
                    { id: 28, ar: 'لا', name: 'Lam Alif', f: 'la', k: 'li', d: 'lu', audio: 'lam_alif' },
                    { id: 29, ar: 'ء', name: 'Hamzah', f: 'a', k: 'i', d: 'u', audio: 'hamzah' },
                    { id: 30, ar: 'ي', name: 'Ya', f: 'ya', k: 'yi', d: 'yu', audio: 'ya' }
                ],

                get activeLetter() { return this.letters.find(l => l.id === this.activeLetterId); },
                get progress() { return this.learned[this.activeTab].length; },

                changeTab(tabId) {
                    this.activeTab = tabId;
                    this.activeLetterId = 1; 
                    // Auto-scroll kembali ke atas setiap kali ganti tab
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                selectLetter(id) {
                    this.activeLetterId = id;
                },

                getDisplayedArabic(letter) {
                    if (!letter) return '';
                    let char = letter.ar;
                    if (this.activeTab === 'fathah') return char + '\u064E';
                    if (this.activeTab === 'kasrah') return char + '\u0650';
                    if (this.activeTab === 'dhammah') return char + '\u064F';
                    return char;
                },

                getDisplayedLatin(letter) {
                    if (!letter) return '';
                    if (this.activeTab === 'fathah') return letter.f;
                    if (this.activeTab === 'kasrah') return letter.k;
                    if (this.activeTab === 'dhammah') return letter.d;
                    return letter.name;
                },

                isLearned(id) {
                    return this.learned[this.activeTab].includes(id);
                },

                playAudio(letter) {
                    let folder = this.activeTab === 'asli' ? 'hijaiyah' : this.activeTab;
                    let audioPath = `/audio/${folder}/${letter.audio}.mp3`;
                    
                    let audio = new Audio(audioPath);
                    audio.play().catch(e => {
                        console.log("Audio harakat belum tersedia, memutar audio asli...");
                        new Audio(`/audio/hijaiyah/${letter.audio}.mp3`).play().catch(err => console.log(err));
                    });

                    if (!this.isLearned(letter.id)) {
                        this.learned[this.activeTab].push(letter.id);
                        localStorage.setItem('hijaiyah_progress_harakat', JSON.stringify(this.learned));

                        if (this.progress === this.letters.length) {
                            setTimeout(() => {
                                const successSnd = document.getElementById('audio-success');
                                if(successSnd) { successSnd.currentTime = 0; successSnd.play().catch(e=>e); }
                                confetti({ particleCount: 150, spread: 80, origin: { y: 0.6 }, zIndex: 9999 });
                            }, 300);
                        }
                    }
                },

                resetGame() {
                    Swal.fire({
                        title: 'Ulangi bagian ini?', text: 'Ceklis pada tanda baca ini akan dihapus!', icon: 'warning', showCancelButton: true,
                        confirmButtonText: 'Ya, Ulangi!', cancelButtonText: 'Batal', width: '340px',
                        customClass: { popup: 'rounded-3xl', title: 'text-lg font-black', confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-bold rounded-full px-5 py-2 mx-1 text-sm', cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-full px-5 py-2 mx-1 text-sm' },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.learned[this.activeTab] = []; 
                            localStorage.setItem('hijaiyah_progress_harakat', JSON.stringify(this.learned));
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Progress direset!', showConfirmButton: false, timer: 2000 });
                        }
                    });
                }
            }))
        })
    </script>
</body>
</html>