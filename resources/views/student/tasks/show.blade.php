<x-student-layout>
  {{-- PERBAIKAN: Mengurangi padding atas (pt-2) agar card lebih naik ke atas --}}
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-2 md:pt-6 pb-12">

    {{-- Tombol Kembali --}}
    <a href="{{ route('student.dashboard') }}" class="inline-flex w-fit items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition mb-4 font-bold text-sm bg-white dark:bg-gray-800 px-4 py-2.5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
      </svg>
      Kembali ke Dashboard
    </a>

    {{-- Alert Error/Success --}}
    @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl font-bold shadow-sm flex items-center gap-3 text-sm">
      <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      {{ session('error') }}
    </div>
    @endif
    @error('file_tugas')
    <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-xl font-bold shadow-sm flex items-center gap-3 text-sm">
      <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      {{ $message }}
    </div>
    @enderror

    {{-- KONTUR UTAMA --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

      {{-- Header Tugas --}}
      <div class="p-5 md:p-8 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">

        {{-- PERBAIKAN: Mengatur badge agar lebarnya pas (w-fit) dan jarak tumpukan lebih rapat (gap-3) di mobile --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
          <div class="inline-flex w-fit items-center gap-1.5 text-[11px] md:text-sm font-bold uppercase tracking-wide px-3 py-2 rounded-lg {{ \Carbon\Carbon::now()->isAfter($tugas->deadline) && !$submission ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Tenggat: {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y, H:i') }} WIB
          </div>

          <div class="inline-flex w-fit items-center gap-1.5 text-xs md:text-sm text-gray-600 dark:text-gray-300 font-medium bg-white dark:bg-gray-700 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
            </svg>
            Pengajar: <span class="font-bold text-gray-900 dark:text-white">{{ $tugas->teacherProfile->user->name ?? 'Ustadz' }}</span>
          </div>
        </div>

        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight mt-1">{{ $tugas->title }}</h1>
      </div>

      {{-- KONTEN BAWAH --}}
      <div class="p-5 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">

          {{-- KOLOM KIRI: Instruksi & File --}}
          <div class="lg:col-span-2 space-y-6">

            {{-- Box Instruksi --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 md:p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
              <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-3 flex items-center gap-2 border-b border-gray-100 dark:border-gray-700 pb-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Instruksi Pengerjaan
              </h3>
              <div class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                {!! nl2br(e($tugas->description)) !!}
              </div>
            </div>

            {{-- Box File Lampiran --}}
            @if($tugas->file_path)
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-200 dark:border-blue-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-sm font-bold text-gray-800 dark:text-gray-200 leading-tight">Lampiran Soal</p>
                  <p class="text-[11px] text-gray-500 mt-0.5">Klik unduh untuk membuka file</p>
                </div>
              </div>
              <a href="{{ asset('storage/' . $tugas->file_path) }}" target="_blank" class="w-full sm:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-lg text-xs shadow-sm transition">
                Unduh File
              </a>
            </div>
            @endif
          </div>

          {{-- KOLOM KANAN: Form Upload / Status --}}
          <div class="lg:col-span-1">

            <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-3 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Status Pengumpulan
            </h3>

            @if($submission)
            {{-- JIKA SUDAH MENGUMPULKAN --}}
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-5 shadow-sm">
              <div class="text-center mb-4">
                <span class="inline-block bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs mb-2">Tugas Terkirim</span>
              </div>

              <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-green-100 dark:border-gray-700 mb-4 text-center shadow-sm">
                <span class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1">Nilai Akhir</span>
                @if($submission->score !== null)
                <div class="text-4xl font-black text-blue-600">{{ $submission->score }}</div>
                @else
                <div class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded border border-yellow-200 inline-block mt-1">Menunggu Dinilai</div>
                @endif
              </div>

              <div class="text-xs text-gray-600 dark:text-gray-400 mb-4 bg-white dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                Waktu Kirim: <br><strong class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($submission->updated_at)->format('d M Y, H:i') }}</strong>
              </div>

              @if($submission->teacher_notes)
              <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 mb-4">
                <span class="block text-xs font-bold text-blue-600 mb-1">Catatan Ustadz:</span>
                <p class="text-xs text-gray-700 italic">"{{ $submission->teacher_notes }}"</p>
              </div>
              @endif

              {{-- [BARU] LOGIKA AUDIO PLAYER UNTUK SANTRI --}}
              @php
                  $ext = strtolower(pathinfo($submission->file_path, PATHINFO_EXTENSION));
                  $isAudio = in_array($ext, ['mp3', 'wav', 'ogg', 'm4a', 'aac']);
                  $fileUrl = asset('storage/' . $submission->file_path);
              @endphp

              @if($isAudio)
                  <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 mt-4 text-left shadow-sm">
                      <span class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase mb-2">Rekaman Jawaban Anda:</span>
                      <audio controls class="w-full h-10 rounded-md">
                          <source src="{{ $fileUrl }}" type="audio/{{ $ext === 'mp3' ? 'mpeg' : $ext }}">
                          Browser Anda tidak mendukung pemutar audio.
                      </audio>
                  </div>
              @else
                  <a href="{{ $fileUrl }}" target="_blank" class="block w-full mt-4 text-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold py-2.5 rounded-lg transition text-sm shadow-sm">
                      Lihat File Saya
                  </a>
              @endif
              {{-- ======================================= --}}

            </div>

            @elseif(\Carbon\Carbon::now()->isAfter($tugas->deadline))
            {{-- JIKA TERLAMBAT --}}
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
              <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
              </div>
              <h4 class="text-lg font-bold text-red-700 mb-1">Waktu Habis</h4>
              <p class="text-sm text-red-600">Batas akhir penyerahan tugas telah terlewat.</p>
            </div>

            @else
            {{-- FORM UPLOAD --}}
            <form action="{{ route('student.task.submit', $tugas->id) }}" method="POST" enctype="multipart/form-data" class="bg-blue-50 dark:bg-gray-800 p-5 rounded-xl border border-blue-200 dark:border-gray-700">
              @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-800 dark:text-white mb-2">Upload Jawaban</label>
                            
                            {{-- [UPDATE] Tambahkan format audio di atribut accept --}}
                            <input type="file" name="file_tugas" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,audio/*,.mp3,.wav,.ogg,.m4a"
                                class="block w-full text-xs text-gray-600
                                file:mr-3 file:py-2 file:px-3
                                file:rounded-lg file:border-0
                                file:text-xs file:font-bold
                                file:bg-blue-600 file:text-white
                                hover:file:bg-blue-700
                                border border-gray-300 rounded-lg bg-white cursor-pointer w-full overflow-hidden">
                            
                            {{-- [UPDATE] Ubah teks panduan di bawahnya --}}
                            <p class="mt-2 text-[10px] text-gray-500">PDF, JPG, DOCX, ZIP, MP3, WAV (Maks 10MB)</p>
                        </div>

              <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition text-sm">
                Kirim Jawaban
              </button>
            </form>
            @endif
          </div>

        </div>
      </div>

    </div>
  </div>
</x-student-layout>