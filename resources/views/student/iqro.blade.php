<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misi Iqro</title>
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

        /* ANIMASI AWAN & BUBBLE SAMA DENGAN SEBELUMNYA */
        .cloud { position: absolute; background: #ffffff; border-radius: 100px; animation: moveCloud linear infinite; }
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

        .bubble {
            position: absolute; bottom: -50px; border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: inset 0 0 10px rgba(255,255,255,0.6), 0 0 10px rgba(255,255,255,0.2);
            animation: floatUp infinite ease-in;
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

        .popup-star { display: inline-block; animation: popPopup 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, floatStar 2s infinite ease-in-out alternate; opacity: 0; }
        @keyframes popPopup { 0% { transform: scale(0) rotate(-30deg); opacity: 0; } 80% { transform: scale(1.3) rotate(10deg); opacity: 1; } 100% { transform: scale(1) rotate(0deg); opacity: 1; } }
        @keyframes floatStar { 0% { transform: translateY(0) scale(1); } 100% { transform: translateY(-6px) scale(1.1); } }
        button, a, .cloud, .bubble { -webkit-tap-highlight-color: transparent; touch-action: manipulation; user-select: none; }
    </style>
</head>
<!-- Alpine diinisiasi dengan state bawaan menu (pilih jilid) -->
<body class="min-h-screen text-gray-800" x-data="iqroGame()">

    {{-- ELEMEN BACKGROUND --}}
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
        <div class="cloud c1"></div> <div class="cloud c2"></div>
        <div class="cloud c3"></div> <div class="cloud c4"></div>
        <div class="cloud c5"></div> <div class="cloud c6"></div>
        <div class="bubble b1"></div> <div class="bubble b2"></div>
        <div class="bubble b3"></div> <div class="bubble b4"></div>
        <div class="bubble b5"></div> <div class="bubble b6"></div>
    </div>

   {{-- HEADER NAVIGASI --}}
    <div x-data="{ showHeader: true, lastScroll: 0 }" 
         @scroll.window="
             if (window.pageYOffset > 50 && window.pageYOffset > lastScroll) { showHeader = false; } else { showHeader = true; }
             lastScroll = window.pageYOffset;
         "
         class="fixed top-0 left-0 w-full z-50 transition-transform duration-500 ease-in-out pointer-events-none"
         :class="showHeader ? 'translate-y-0' : '-translate-y-full'">
         
        <div class="max-w-5xl mx-auto px-4 py-4 md:py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <a href="{{ route('student.dashboard') }}" class="pointer-events-auto bg-white/90 hover:bg-white text-blue-600 px-5 py-2.5 rounded-full font-black shadow-md hover:shadow-lg transition-all flex items-center gap-2 active:scale-95 border-2 border-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Menu Utama
            </a>

            {{-- MENU TAB TERPISAH DENGAN LINK --}}
            <div class="pointer-events-auto bg-white/80 p-1.5 rounded-full shadow-md flex gap-2 border-2 border-white backdrop-blur-sm">
                <!-- Link ke halaman Hijaiyah (ganti URL jika perlu) -->
               <a href="{{ route('student.hijaiyah') }}" class="px-4 py-2 rounded-full font-bold text-sm transition-all duration-300 text-gray-500 hover:bg-white">
                  🎮 Hijaiyah
              </a>
              <a href="#" class="px-4 py-2 rounded-full font-bold text-sm transition-all duration-300 bg-orange-500 text-white shadow-md">
                  📚 Misi Iqro
              </a>
            </div>
        </div>
    </div>

    <div class="h-40 sm:h-44 md:h-28"></div>

    {{-- MENU PILIH JILID IQRO --}}
    <div x-show="viewState === 'menu'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" class="relative z-10">
        <div class="max-w-5xl mx-auto px-4 pb-20">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-black text-blue-900 drop-shadow-sm mb-3">Pilih Misi Iqro Kamu! 🚀</h2>
                <p class="text-blue-800 font-bold max-w-lg mx-auto">Selesaikan misi dari Jilid 1 sampai 6 untuk menjadi ahli membaca Al-Qur'an.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="iqro in iqroLevels" :key="iqro.id">
                    <div class="bg-white/95 backdrop-blur-sm rounded-[2rem] p-2 shadow-xl border-b-8 transition-transform hover:-translate-y-2 duration-300 group" :class="iqro.borderColor">
                        <div class="rounded-[1.5rem] p-6 h-full flex flex-col items-center text-center bg-gradient-to-br" :class="iqro.bgGradient">
                            <div class="w-20 h-20 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center text-4xl shadow-inner mb-4 transform transition-transform group-hover:scale-110">
                                <span x-text="iqro.icon"></span>
                            </div>
                            <h3 class="text-2xl font-black text-white mb-2 drop-shadow-sm" x-text="iqro.title"></h3>
                            <p class="text-white/90 text-sm font-bold mb-6 line-clamp-2" x-text="iqro.desc"></p>
                            <button @click="startIqro(iqro.id)" class="mt-auto w-full py-3 bg-white rounded-xl font-black transition-all active:scale-95 flex items-center justify-center gap-2 shadow-md" :class="iqro.textColor + ' hover:bg-gray-50'">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"></path></svg>
                                Mulai Misi
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- AREA MEMBACA (Tampil saat diklik mulai) --}}
    <div x-show="viewState === 'play'" x-cloak x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-10" class="relative z-10">
        <div class="max-w-3xl mx-auto px-4 pb-24">
            
            <div class="flex items-center justify-between mb-4">
                <button @click="viewState = 'menu'" class="bg-white/80 backdrop-blur-sm text-blue-600 font-bold px-4 py-2 rounded-full shadow-sm hover:shadow-md active:scale-95 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali
                </button>
                <div class="bg-blue-600 text-white font-black px-5 py-2 rounded-full shadow-md border-2 border-white">
                    <span x-text="'Jilid ' + activeJilid"></span> - Hal <span x-text="activePage"></span>
                </div>
            </div>

            <div class="bg-[#FFFDF8] rounded-3xl p-6 md:p-10 shadow-2xl border-b-8 border-gray-200 relative min-h-[50vh] flex flex-col justify-center">
                <div class="space-y-6 md:space-y-10" dir="rtl">
                    <template x-for="(baris, index) in currentIqroPageData" :key="index">
                        <div class="flex flex-wrap justify-around md:justify-between items-center gap-4 text-4xl sm:text-5xl md:text-6xl font-arab font-bold text-gray-800 leading-loose">
                            <template x-for="(kata, idx) in baris" :key="idx">
                                <span class="hover:text-blue-500 transition-colors cursor-pointer active:scale-90" x-text="kata"></span>
                            </template>
                        </div>
                    </template>
                </div>
                <div x-show="currentIqroPageData.length === 0" class="text-center py-10 text-gray-400 font-bold">
                    Materi halaman ini sedang disiapkan... 🛠️
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button @click="prevPage()" :disabled="activePage === 1" 
                    class="px-6 py-3 rounded-2xl font-black transition-all active:scale-95 shadow-md border-b-4 flex items-center gap-2"
                    :class="activePage === 1 ? 'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed' : 'bg-white text-blue-600 border-blue-200 hover:bg-blue-50'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </button>

                <button @click="nextPage()" 
                    class="px-6 py-3 rounded-2xl font-black transition-all active:scale-95 shadow-md border-b-4 flex items-center gap-2"
                    :class="activePage >= maxPages ? 'bg-green-500 text-white border-green-700 hover:bg-green-600' : 'bg-white text-blue-600 border-blue-200 hover:bg-blue-50'">
                    <span x-text="activePage >= maxPages ? 'Selesai 🌟' : 'Selanjutnya'"></span>
                    <svg x-show="activePage < maxPages" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Audio Bintang --}}
    <div class="hidden">
        <audio id="audio-success" preload="auto"><source src="/audio/success-chime.mp3" type="audio/mpeg"></audio>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('iqroGame', () => ({
                viewState: 'menu',
                activeJilid: 1,
                activePage: 1,
                maxPages: 1,
                
                iqroData: {
                    1: {
                        1: [['اَ', 'بَ'], ['بَ', 'اَ', 'بَ'], ['اَ', 'بَ', 'اَ', 'بَ']],
                        2: [['تَ', 'بَ', 'اَ'], ['ثَ', 'تَ', 'بَ'], ['بَ', 'اَ', 'ثَ', 'تَ']],
                        3: [['جَ', 'حَ', 'خَ'], ['تَ', 'حَ', 'بَ'], ['جَ', 'اَ', 'خَ', 'ثَ']]
                    },
                    2: {
                        1: [['بَا', 'تَا'], ['ثَا', 'جَا', 'حَا']]
                    }
                },

                get currentIqroPageData() {
                    if (this.iqroData[this.activeJilid] && this.iqroData[this.activeJilid][this.activePage]) {
                        return this.iqroData[this.activeJilid][this.activePage];
                    }
                    return [];
                },
                
                iqroLevels: [
                    { id: 1, title: 'Iqro Jilid 1', desc: 'Mengenal huruf tunggal dan harakat Fathah.', icon: '🅰️', bgGradient: 'from-orange-400 to-red-500', borderColor: 'border-red-600', textColor: 'text-red-600' },
                    { id: 2, title: 'Iqro Jilid 2', desc: 'Belajar huruf bersambung dan mad dasar.', icon: '🔗', bgGradient: 'from-amber-300 to-orange-500', borderColor: 'border-orange-600', textColor: 'text-orange-600' },
                    { id: 3, title: 'Iqro Jilid 3', desc: 'Mengenal Kasrah, Dhammah, dan panjang pendeknya.', icon: '🔊', bgGradient: 'from-emerald-400 to-green-600', borderColor: 'border-green-700', textColor: 'text-green-700' },
                    { id: 4, title: 'Iqro Jilid 4', desc: 'Belajar Tanwin dan huruf mati (Sukun).', icon: '🛑', bgGradient: 'from-cyan-400 to-blue-500', borderColor: 'border-blue-600', textColor: 'text-blue-600' },
                    { id: 5, title: 'Iqro Jilid 5', desc: 'Pengenalan Tajwid dasar, Waqaf, dan Tasydid.', icon: '📖', bgGradient: 'from-indigo-400 to-purple-600', borderColor: 'border-purple-700', textColor: 'text-purple-700' },
                    { id: 6, title: 'Iqro Jilid 6', desc: 'Tajwid lanjutan, siap membaca Al-Qur\'an!', icon: '👑', bgGradient: 'from-pink-400 to-rose-600', borderColor: 'border-rose-700', textColor: 'text-rose-700' },
                ],

                startIqro(levelId) {
                    this.activeJilid = levelId;
                    this.activePage = 1; 
                    if(this.iqroData[levelId]) { this.maxPages = Object.keys(this.iqroData[levelId]).length; } else { this.maxPages = 1; }
                    this.viewState = 'play';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                prevPage() {
                    if (this.activePage > 1) { this.activePage--; window.scrollTo({ top: 0, behavior: 'smooth' }); }
                },

                nextPage() {
                    if (this.activePage < this.maxPages) {
                        this.activePage++; window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        this.showStarPopup(3);
                        setTimeout(() => {
                            Swal.fire({
                                title: 'Alhamdulillah!', text: 'Kamu telah menyelesaikan Misi Jilid ' + this.activeJilid + '!', icon: 'success', confirmButtonText: 'Kembali ke Menu', width: '340px',
                                customClass: { popup: 'rounded-3xl', title: 'text-xl font-black text-green-600', confirmButton: 'bg-green-500 hover:bg-green-600 text-white font-bold rounded-full px-6 py-2 mt-2 shadow-md transition-all active:scale-95' },
                                buttonsStyling: false, backdrop: `rgba(0,0,0,0.7)`
                            }).then(() => {
                                this.viewState = 'menu'; window.scrollTo({ top: 0, behavior: 'smooth' });
                            });
                        }, 3500);
                    }
                },

                showStarPopup(starLevel) {
                    setTimeout(() => {
                        const successAudio = document.getElementById('audio-success');
                        if(successAudio) { successAudio.currentTime = 0; successAudio.play().catch(e => console.log(e)); }
                    }, 200);

                    const duration = 2500; const end = Date.now() + duration; const defaults = { startVelocity: 25, spread: 360, ticks: 60, zIndex: 9999 };

                    const interval = setInterval(function() {
                        const timeLeft = end - Date.now();
                        if (timeLeft <= 0) { return clearInterval(interval); }
                        const particleCount = 40 * (timeLeft / duration);
                        confetti({ ...defaults, particleCount, origin: { x: (Math.random() * 0.2) + 0.1, y: Math.random() - 0.2 }, shapes: ['star'], colors: ['#FFE400', '#FFBD00'] });
                        confetti({ ...defaults, particleCount, origin: { x: (Math.random() * 0.2) + 0.7, y: Math.random() - 0.2 }, shapes: ['star'], colors: ['#FFE400', '#FFBD00'] });
                    }, 250);

                    let starsHtml = '';
                    for (let i = 0; i < starLevel; i++) { starsHtml += `<span class="popup-star mx-1 text-5xl md:text-6xl drop-shadow-md text-yellow-400" style="animation-delay: ${i * 0.2}s">⭐</span>`; }

                    setTimeout(() => {
                        Swal.fire({
                            title: 'Sempurna!',
                            html: `<div class="flex justify-center items-center h-20 mb-3 mt-1">${starsHtml}</div><p class="text-sm font-bold text-gray-600">Hore! 3 Bintang Terkumpul!</p>`,
                            width: '320px', padding: '1.2rem',
                            customClass: { popup: 'rounded-3xl border-4 border-yellow-300 bg-gradient-to-b from-white to-yellow-50', title: 'text-xl font-black text-yellow-600 mt-2 mb-0', confirmButton: 'bg-gradient-to-r from-yellow-400 to-orange-400 hover:from-yellow-500 hover:to-orange-500 text-white font-bold rounded-full px-6 py-2 shadow-md transform transition active:scale-95 text-sm mt-3' },
                            confirmButtonText: 'Lanjut! 🚀', buttonsStyling: false, backdrop: `rgba(0,0,0,0.6)` 
                        });
                    }, 500);
                }
            }))
        })
    </script>
</body>
</html>