<x-student-layout>
  {{--
      =============================================
      CSS OVERRIDE (PENGUNCI LAYOUT CBT)
      =============================================
  --}}
  <style>
    /* 1. Mencegah Double Scroll Bawaan Browser */
    html,
    body {
      overflow: hidden !important;
      height: 100vh !important;
      margin: 0;
      touch-action: none;
      /* Mencegah pull-to-refresh di mobile */
    }

    /* 2. Container CBT: Mengunci secara presisi di antara Top Nav dan Bottom Nav */
    .cbt-container {
      position: fixed;
      /* SESUAIKAN ANGKA INI: Tinggi Navbar Putih (Logo) di bagian atas */
      top: 64px;
      left: 0;
      right: 0;
      bottom: 0;
      /* Di Desktop menempel ke bawah */
      z-index: 40;
      display: flex;
      flex-direction: column;
      background-color: #f9fafb;
    }

    .dark .cbt-container {
      background-color: #111827;
      /* dark:bg-gray-900 */
    }

    /* Penyesuaian Khusus Mobile (HP) */
    @media (max-width: 767px) {
      .cbt-container {
        /* SESUAIKAN ANGKA INI: Tinggi Bottom Navbar aplikasi Anda (Beranda, Jadwal, Keluar) */
        /* Jika tombol next masih tertutup, naikkan angkanya jadi 80px atau 85px */
        bottom: 56px;
      }
    }

    /* Penyesuaian Khusus Desktop */
    @media (min-width: 768px) {
      .cbt-container {
        flex-direction: row;
      }
    }

    /* 3. Desain Scrollbar Internal */
    .cbt-scroll::-webkit-scrollbar {
      width: 5px;
    }

    .cbt-scroll::-webkit-scrollbar-track {
      background: transparent;
    }

    .cbt-scroll::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 10px;
    }

    .cbt-scroll::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }

    .dark .cbt-scroll::-webkit-scrollbar-thumb {
      background: #475569;
    }

    .dark .cbt-scroll::-webkit-scrollbar-thumb:hover {
      background: #64748b;
    }
  </style>

  {{--
      =============================================
      ALPINE.JS STATE MANAGEMENT
      =============================================
  --}}
  <div x-data="{ 
        timeLeft: parseInt({{ $remainingSeconds }}), 
        timerInterval: null,
        isSubmitting: false,
        currentQuestion: 0,
        totalQuestions: {{ $exam->questions->count() }},
        mobileNavOpen: false,
        answers: {}, 
        flagged: {},

        formatTime(seconds) {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = Math.floor(seconds % 60);
            if(h > 0) return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        },

        startTimer() {
            this.timerInterval = setInterval(() => {
                if (this.timeLeft > 0) this.timeLeft--;
                else this.timeIsUp();
            }, 1000);
        },

        timeIsUp() {
            clearInterval(this.timerInterval);
            if (!this.isSubmitting) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ title: 'Waktu Habis!', text: 'Jawaban Anda dikirim otomatis.', icon: 'warning', timer: 3000, showConfirmButton: false, allowOutsideClick: false });
                }
                this.submitForm();
            }
        },

        submitForm() {
            this.isSubmitting = true;
            document.body.style.overflow = 'auto'; // Kembalikan scroll browser normal setelah submit
            document.getElementById('exam-form').submit();
        },

        next() {
            if(this.currentQuestion < this.totalQuestions - 1) {
                this.currentQuestion++;
                this.scrollToTop();
            }
        },

        prev() {
            if(this.currentQuestion > 0) {
                this.currentQuestion--;
                this.scrollToTop();
            }
        },

        jumpTo(index) {
            this.currentQuestion = index;
            this.scrollToTop();
            if (window.innerWidth < 768) this.mobileNavOpen = false;
        },

        scrollToTop() {
            const panes = document.querySelectorAll('.question-scroll-pane');
            panes.forEach(pane => pane.scrollTo({ top: 0, behavior: 'smooth' }));
        },

        toggleFlag(questionId) {
            this.flagged[questionId] = !this.flagged[questionId];
        },

        autoSave(questionId, answer) {
            console.log('Tersimpan:', questionId, answer);
            // Integrasi AJAX Auto-save disini nanti
        },

        getNavClass(index, questionId) {
            let classes = 'relative flex items-center justify-center font-bold text-sm h-10 w-10 md:h-11 md:w-11 transition-all duration-200 cursor-pointer rounded-lg border ';
            
            if (this.currentQuestion === index) {
                classes += 'border-emerald-600 ring-2 ring-emerald-600 ring-offset-2 dark:ring-offset-gray-800 z-10 shadow-sm ';
            } else {
                classes += 'hover:border-emerald-400 dark:hover:border-emerald-500 ';
            }

            if (this.answers[questionId] && this.answers[questionId].trim() !== '') {
                if(this.flagged[questionId]) classes += 'bg-yellow-400 text-yellow-900 border-yellow-500 ';
                else classes += 'bg-emerald-500 text-white border-emerald-600 dark:bg-emerald-600 dark:border-emerald-500 ';
            } else {
                if(this.flagged[questionId]) classes += 'bg-yellow-50 text-yellow-800 border-yellow-400 dark:bg-yellow-900/40 dark:text-yellow-400 dark:border-yellow-700 ';
                else classes += 'bg-white text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 ';
            }
            return classes;
        },
        
        answeredCount() {
            let count = 0;
            for (let key in this.answers) {
                if (this.answers[key] && this.answers[key].trim() !== '') count++;
            }
            return count;
        }
    }"
    x-init="startTimer()"
    @beforeunload.window="if (!isSubmitting) $event.returnValue = 'Yakin ingin keluar? Ujian masih berjalan!'"
    class="cbt-container">

    {{--
        =============================================
        HEADER MOBILE KHUSUS (Warna Emerald)
        =============================================
    --}}
    <div class="md:hidden flex-none z-30 bg-emerald-700 dark:bg-emerald-900 text-white px-4 py-3 flex justify-between items-center shadow-md border-b border-emerald-800/50">
      <div class="flex items-center gap-3">
        <button type="button" @click="mobileNavOpen = true" class="p-2 -ml-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors focus:outline-none">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <div class="flex flex-col">
          <span class="text-[10px] font-bold text-emerald-200 uppercase tracking-widest leading-none mb-1">CBT Mode</span>
          <span class="text-sm font-bold leading-none line-clamp-1 max-w-[150px]">{{ $exam->title }}</span>
        </div>
      </div>

      <div class="flex items-center gap-2 font-mono font-bold bg-white/10 px-3 py-1.5 rounded-lg text-sm transition-colors duration-300 border border-transparent" :class="{'bg-red-500/90 text-white animate-pulse border-white/50': timeLeft < 300}">
        <svg class="w-4 h-4" :class="{'text-white': timeLeft < 300}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span x-text="formatTime(timeLeft)">00:00</span>
      </div>
    </div>

    {{-- BACKDROP MOBILE --}}
    <div x-show="mobileNavOpen" x-cloak
      x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
      x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
      class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm z-40 md:hidden" @click="mobileNavOpen = false">
    </div>

    {{--
        =============================================
        1. SIDEBAR KIRI (NAVIGASI SOAL)
        =============================================
    --}}
    <aside class="absolute md:relative inset-y-0 left-0 z-50 w-[280px] md:w-[320px] flex-shrink-0 border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 h-full flex flex-col shadow-2xl md:shadow-none transform transition-transform duration-300 md:translate-x-0"
      :class="mobileNavOpen ? 'translate-x-0' : '-translate-x-full'">

      {{-- Header Sidebar (Desktop Only) --}}
      <div class="hidden md:flex p-6 border-b border-emerald-800 dark:border-emerald-950 justify-between items-start bg-emerald-700 dark:bg-emerald-900 text-white flex-none">
        <div>
          <span class="inline-block px-2 py-1 bg-white/20 text-[10px] font-bold rounded mb-2 tracking-widest uppercase">CBT Mode</span>
          <h2 class="text-lg font-bold leading-snug line-clamp-2" title="{{ $exam->title }}">{{ $exam->title }}</h2>
        </div>
      </div>

      {{-- Timer Box Desktop --}}
      <div class="hidden md:flex p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 justify-between items-center flex-none">
        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Sisa Waktu</span>
        <div class="font-mono text-xl font-bold text-gray-800 dark:text-white bg-white dark:bg-gray-900 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm flex items-center gap-2 transition-colors duration-300"
          :class="{'text-red-600 dark:text-red-400 border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-900/20 animate-pulse': timeLeft < 300}">
          <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400" :class="{'text-red-500 dark:text-red-400': timeLeft < 300}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span x-text="formatTime(timeLeft)">00:00</span>
        </div>
      </div>

      {{-- Sidebar Header Mobile Buka Tutup --}}
      <div class="md:hidden flex items-center justify-between p-4 border-b border-gray-100 flex-none bg-white">
        <span class="font-bold text-gray-800">Menu Ujian</span>
        <button type="button" @click="mobileNavOpen = false" class="p-2 bg-red-50 text-red-500 hover:bg-red-100 rounded-lg transition-colors">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      {{-- Grid Nomor Soal --}}
      <div class="p-5 overflow-y-auto flex-1 cbt-scroll bg-white dark:bg-gray-800">
        <div class="flex items-center justify-between mb-4">
          <span class="text-sm font-bold text-gray-700 dark:text-gray-200">Daftar Soal</span>
          <span class="text-[11px] font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-md border border-gray-200 dark:border-gray-600">
            <span x-text="answeredCount()"></span>/{{ $exam->questions->count() }} Dijawab
          </span>
        </div>

        <div class="grid grid-cols-5 md:grid-cols-5 gap-2 md:gap-3">
          @foreach($exam->questions as $index => $q)
          <button type="button" @click="jumpTo({{ $index }})" :class="getNavClass({{ $index }}, '{{ $q->id }}')">
            {{ $index + 1 }}
            <span x-show="flagged['{{ $q->id }}']" x-cloak class="absolute -top-1.5 -right-1.5 flex h-3.5 w-3.5">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-yellow-500 border-2 border-white dark:border-gray-800"></span>
            </span>
          </button>
          @endforeach
        </div>

        {{-- Legenda Sidebar --}}
        <div class="mt-8 grid grid-cols-2 gap-3 text-[10px] md:text-[11px] text-gray-600 dark:text-gray-400 font-medium bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 md:w-4 md:h-4 rounded bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600"></div>Belum dijawab
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 md:w-4 md:h-4 rounded bg-emerald-500 dark:bg-emerald-600 border border-emerald-600 dark:border-emerald-500"></div>Sudah dijawab
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 md:w-4 md:h-4 rounded bg-yellow-400 border border-yellow-500"></div>Ragu-ragu
          </div>
          <div class="flex items-center gap-2">
            <div class="w-3 h-3 md:w-4 md:h-4 rounded border-2 border-emerald-600 ring-1 ring-offset-1 ring-emerald-600 dark:ring-offset-gray-900"></div>Sedang dibuka
          </div>
        </div>
      </div>
    </aside>

    {{--
        =============================================
        2. AREA KANAN (KONTEN SOAL UTAMA)
        =============================================
    --}}
    <main class="flex-1 flex flex-col min-h-0 h-full bg-gray-50 dark:bg-gray-900 overflow-hidden">

      {{-- Note: p-0 pada mobile menghilangkan gap agar kotak putih full menempel --}}
      <form id="exam-form" action="{{ route('student.exam.submit', $exam->id) }}" method="POST" @submit="isSubmitting = true" class="flex-1 flex flex-col min-h-0 w-full max-w-5xl mx-auto p-0 md:p-6 lg:p-8 h-full">
        @csrf

        {{-- Kotak Pembungkus Soal --}}
        <div class="flex-1 flex flex-col min-h-0 bg-white dark:bg-gray-800 md:rounded-2xl md:shadow-sm md:border border-gray-200 dark:border-gray-700 overflow-hidden">
          @foreach($exam->questions as $index => $q)
          <div x-show="currentQuestion === {{ $index }}" style="display: none;" class="flex-1 flex flex-col min-h-0 h-full">

            {{-- Header Soal (Fixed Top Inside Card) --}}
            <div class="flex-none px-4 py-3 md:px-8 md:py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-white md:bg-gray-50/50 dark:bg-gray-800">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center font-bold text-lg shrink-0">
                  {{ $index + 1 }}
                </div>
                <div>
                  <span class="block text-[10px] md:text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Soal Ke-{{ $index + 1 }} dari {{ $exam->questions->count() }}</span>
                  <span class="block text-[11px] md:text-xs font-semibold text-emerald-600 dark:text-emerald-400 mt-0.5">Bobot: {{ $q->points }} Poin</span>
                </div>
              </div>

              {{-- Toggle Ragu-ragu --}}
              <label class="flex items-center gap-2 cursor-pointer group bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition select-none shrink-0">
                <input type="checkbox" class="sr-only peer" @change="toggleFlag('{{ $q->id }}')" :checked="flagged['{{ $q->id }}']">
                <div class="w-4 h-4 md:w-5 md:h-5 rounded border-2 border-gray-300 dark:border-gray-600 peer-checked:bg-yellow-400 peer-checked:border-yellow-500 flex items-center justify-center transition">
                  <svg class="w-3 h-3 text-white dark:text-gray-900 opacity-0 peer-checked:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span class="text-[10px] md:text-xs font-bold text-gray-600 dark:text-gray-300 peer-checked:text-yellow-600 dark:peer-checked:text-yellow-500 hidden sm:block">Ragu-ragu</span>
              </label>
            </div>

            {{-- Body Soal (Area yang bisa di-scroll) --}}
            <div class="question-scroll-pane flex-1 overflow-y-auto p-4 md:p-8 cbt-scroll bg-white dark:bg-gray-800">

              {{-- Teks Pertanyaan --}}
              <div class="mb-8 prose prose-base md:prose-lg dark:prose-invert max-w-none text-gray-800 dark:text-gray-100 font-medium leading-relaxed">
                {!! nl2br(e($q->question)) !!}
              </div>

              {{-- Asset Gambar --}}
              @if($q->image)
              <div class="mb-8 border border-gray-200 dark:border-gray-700 p-2 rounded-xl bg-gray-50 dark:bg-gray-900 inline-block max-w-full">
                <img src="{{ asset('storage/' . $q->image) }}" class="max-w-full h-auto object-contain max-h-[400px] rounded-lg shadow-sm">
              </div>
              @endif

              {{-- Asset Audio --}}
              @if($q->audio)
              <div class="mb-8 max-w-md bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 p-4 rounded-xl flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center shrink-0 shadow-md">
                  <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                  </svg>
                </div>
                <audio controls class="w-full h-10" controlsList="nodownload">
                  <source src="{{ asset('storage/' . $q->audio) }}" type="audio/mpeg">
                </audio>
              </div>
              @endif

              {{-- Opsi Jawaban --}}
              <div class="mt-6 space-y-3 pb-6">

                {{-- A. PILIHAN GANDA --}}
                @if($q->type === 'multiple_choice')
                @foreach(['a', 'b', 'c', 'd'] as $opt)
                <label class="relative flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 group
                                bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-emerald-400 dark:hover:border-emerald-500
                                has-[:checked]:border-emerald-500 dark:has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50 dark:has-[:checked]:bg-emerald-900/20">

                  <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt }}" class="peer sr-only" x-model="answers['{{ $q->id }}']" @change="autoSave('{{ $q->id }}', '{{ $opt }}')">

                  <div class="w-5 h-5 md:w-6 md:h-6 flex-shrink-0 rounded-full border-2 border-gray-300 dark:border-gray-500 mr-3 md:mr-4 flex items-center justify-center transition-colors peer-checked:border-emerald-500 peer-checked:bg-emerald-500 dark:peer-checked:border-emerald-400 dark:peer-checked:bg-emerald-400">
                    <div class="w-2.5 h-2.5 rounded-full bg-white dark:bg-gray-900 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                  </div>

                  <div class="flex-1">
                    <span class="font-bold text-gray-500 dark:text-gray-400 mr-1.5 md:mr-2 uppercase">{{ $opt }}.</span>
                    <span class="text-gray-700 dark:text-gray-200 text-sm md:text-base font-medium peer-checked:text-emerald-900 dark:peer-checked:text-emerald-100 leading-snug">{{ $q->options[$opt] ?? '' }}</span>
                  </div>
                </label>
                @endforeach

                {{-- B. BENAR / SALAH --}}
                @elseif($q->type === 'true_false')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                  @foreach(['true' => 'BENAR', 'false' => 'SALAH'] as $val => $label)
                  <label class="relative cursor-pointer group h-full">
                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $val }}" class="peer sr-only" x-model="answers['{{ $q->id }}']" @change="autoSave('{{ $q->id }}', '{{ $val }}')">

                    <div class="flex flex-col items-center justify-center py-6 px-6 h-full rounded-2xl border-2 transition-all duration-200
                                    bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-500
                                    peer-checked:border-emerald-600 dark:peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 peer-checked:ring-1 peer-checked:ring-emerald-600">

                      <div class="w-10 h-10 md:w-12 md:h-12 mb-3 rounded-full flex items-center justify-center transition-colors
                                        {{ $val == 'true' ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400 peer-checked:bg-emerald-500 peer-checked:text-white' : 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400 peer-checked:bg-red-500 peer-checked:text-white' }}">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                          @if($val == 'true')
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                          @else
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                          @endif
                        </svg>
                      </div>
                      <span class="text-lg md:text-xl font-bold text-gray-500 dark:text-gray-400 peer-checked:text-emerald-800 dark:peer-checked:text-emerald-200 tracking-wider">
                        {{ $label }}
                      </span>
                    </div>
                  </label>
                  @endforeach
                </div>

                {{-- C. ESAI --}}
                @elseif($q->type === 'essay')
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800/50 p-3 md:p-4 rounded-xl mb-4 text-xs text-yellow-800 dark:text-yellow-300 flex items-start gap-2">
                  <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Tuliskan jawaban selengkap mungkin. Jawaban otomatis tersimpan.
                </div>
                <textarea name="answers[{{ $q->id }}]" rows="6" x-model="answers['{{ $q->id }}']" @input.debounce.500ms="autoSave('{{ $q->id }}', answers['{{ $q->id }}'])"
                  class="w-full p-4 md:p-5 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-0 text-sm md:text-base leading-relaxed shadow-inner resize-y transition-colors"
                  placeholder="Ketik jawaban Anda di sini..."></textarea>
                @endif

              </div>
            </div>

            {{-- Footer Navigasi Antar Soal (Fixed Bottom Inside Card) --}}
            <div class="flex-none p-3 md:p-5 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] md:shadow-none z-10">

              {{-- Tombol Sebelumnya --}}
              <button type="button" @click="prev" :disabled="currentQuestion === 0"
                class="px-4 py-2.5 md:px-5 rounded-lg font-bold text-xs md:text-sm transition-all duration-200 flex items-center gap-1.5
                           disabled:opacity-40 disabled:cursor-not-allowed bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="hidden sm:inline">Sebelumnya</span>
                <span class="sm:hidden">Prev</span>
              </button>

              {{-- Status Tersimpan --}}
              <div class="text-[10px] md:text-xs font-bold text-emerald-600 dark:text-emerald-400 flex flex-col md:flex-row items-center gap-1 opacity-0 transition-opacity duration-300" :class="{'opacity-100': answers['{{ $q->id }}']}">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span>Tersimpan</span>
              </div>

              <div>
                {{-- Tombol Next --}}
                <button type="button" x-show="currentQuestion < totalQuestions - 1" @click="next"
                  class="px-4 py-2.5 md:px-5 rounded-lg font-bold text-xs md:text-sm transition-all duration-200 flex items-center gap-1.5 bg-emerald-600 text-white hover:bg-emerald-700 shadow-md">
                  <span class="hidden sm:inline">Selanjutnya</span>
                  <span class="sm:hidden">Next</span>
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                  </svg>
                </button>

                {{-- Tombol Submit --}}
                <button type="button" x-show="currentQuestion === totalQuestions - 1" style="display: none;"
                  @click.prevent="
                            let empty = totalQuestions - answeredCount();
                            if(typeof Swal === 'undefined'){ if(confirm('Yakin ingin menyelesaikan ujian?')) submitForm(); return; }

                            if(empty > 0) {
                                Swal.fire({
                                    title: 'Ada Soal Kosong!',
                                    html: `Anda masih memiliki <b>${empty}</b> soal yang belum dijawab.<br>Yakin ingin mengakhiri ujian sekarang?`,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, Akhiri Ujian',
                                    cancelButtonText: 'Kembali Cek Soal',
                                    confirmButtonColor: '#dc2626',
                                    cancelButtonColor: '#64748b',
                                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire({title: 'Memproses...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() }});
                                        submitForm();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Selesai Ujian?',
                                    text: 'Pastikan Anda telah mengecek ulang semua jawaban.',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, Kirim Jawaban',
                                    cancelButtonText: 'Periksa Kembali',
                                    confirmButtonColor: '#059669',
                                    cancelButtonColor: '#64748b',
                                    background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#fff',
                                    color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire({title: 'Mengirim Jawaban...', allowOutsideClick: false, didOpen: () => { Swal.showLoading() }});
                                        submitForm();
                                    }
                                });
                            }"
                  class="px-4 py-2.5 md:px-5 rounded-lg font-bold text-xs md:text-sm transition-all duration-200 flex items-center gap-1.5 bg-slate-800 dark:bg-slate-700 text-white hover:bg-slate-900 shadow-lg">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="hidden sm:inline">Kirim Jawaban</span>
                  <span class="sm:hidden">Selesai</span>
                </button>
              </div>
            </div>

          </div>
          @endforeach
        </div>

      </form>
    </main>
  </div>
</x-student-layout>