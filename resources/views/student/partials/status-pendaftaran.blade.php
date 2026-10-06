{{-- STATUS PENDAFTARAN --}}
      <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-[20px] shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6">

          {{-- HEADER --}}
          <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
            <div class="p-1.5 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
              </svg>
            </div>
            <h3 class="font-bold text-gray-800 dark:text-white text-lg">Status Pendaftaran</h3>
          </div>

          {{-- LIST STATUS --}}
          <div class="divide-y divide-gray-50 dark:divide-gray-700">
            @forelse($myBookings as $booking)
            
            @php
              // ====================================================================
              // LOGIKA PROGRAM GRATIS DARI DATABASE
              // ====================================================================
              $isGratis = $booking->is_free; 
            @endphp

            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition duration-200">

             {{-- Info Guru --}}
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-700 dark:text-green-300 font-bold text-lg border border-green-200 dark:border-green-800 shrink-0 overflow-hidden">
                  @if($booking->teacherProfile->photo_url ?? false)
                    <img src="{{ $booking->teacherProfile->photo_url }}" alt="{{ $booking->teacherProfile->user->name ?? 'Guru' }}" class="w-full h-full object-cover">
                  @else
                    {{ substr($booking->teacherProfile->user->name ?? 'G', 0, 1) }}
                  @endif
                </div>
                
                <div class="min-w-0">
                  <h4 class="font-bold text-gray-800 dark:text-white text-sm md:text-base line-clamp-1">{{ $booking->teacherProfile->user->name ?? 'Guru' }}</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium flex items-center gap-1">
                    <span>Program:</span>
                    <span class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] font-bold uppercase">{{ ucfirst($booking->program_type) }}</span>
                  </p>
                </div>
              </div>

              {{-- Status Box --}}
              <div class="mb-5">
                @if($booking->status == 'pending')

                  @if($isGratis)
                  {{-- 1. STATUS: PENDAFTARAN GRATIS --}}
                  <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-2xl text-center">
                    <span class="flex items-center justify-center gap-1.5 text-emerald-700 dark:text-emerald-400 text-xs font-extrabold uppercase tracking-wide">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Bebas Biaya Pendaftaran
                    </span>
                    <p class="text-[10px] text-gray-500 mt-2">Program ini tidak memungut biaya awal. Silakan klik konfirmasi di bawah untuk lanjut.</p>
                  </div>
                  @else
                  {{-- 2. STATUS: MENUNGGU PEMBAYARAN (BERBAYAR) --}}
                  <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800 rounded-2xl text-center">
                    <span class="flex items-center justify-center gap-1.5 text-yellow-700 dark:text-yellow-400 text-xs font-extrabold uppercase mb-2 tracking-wide">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                      </svg>
                      Menunggu Pembayaran
                    </span>
                    <div class="text-xs text-gray-500 dark:text-gray-400 pt-3 border-t border-yellow-200 dark:border-yellow-800/50 flex flex-col gap-1">
                      <span class="mb-0.5">Biaya Pendaftaran:</span>
                      <span class="font-extrabold text-gray-900 dark:text-white text-lg mb-1.5">Rp 50.000</span>
                      <span>Silakan Transfer ke Muamalat:</span>
                      <span class="font-mono font-bold text-gray-800 dark:text-gray-200 text-sm tracking-wider">1610055206</span>
                    </div>
                  </div>
                  @endif

                @elseif($booking->status == 'verifying')
                {{-- STATUS: VERIFIKASI --}}
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl text-center">
                  <span class="flex items-center justify-center gap-1.5 text-blue-700 dark:text-blue-400 text-xs font-extrabold uppercase tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Sedang Diverifikasi
                  </span>
                </div>

                @elseif($booking->status == 'active')
                {{-- STATUS: AKTIF --}}
                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 rounded-2xl text-center">
                  <span class="flex items-center justify-center gap-1.5 text-green-700 dark:text-green-400 text-xs font-extrabold uppercase tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    Kelas Aktif
                  </span>
                </div>

                @else
                {{-- STATUS: DITOLAK --}}
                <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-2xl text-center">
                  <span class="flex items-center justify-center gap-1.5 text-red-700 dark:text-red-400 text-xs font-extrabold uppercase tracking-wide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Ditolak
                  </span>
                </div>
                @endif
              </div>

              {{-- AKSI FORM --}}
              @if($booking->status == 'pending')
                @if($isGratis)
                  {{-- TOMBOL UNTUK PROGRAM GRATIS (TANPA UPLOAD FILE) --}}
                  <form action="{{ route('booking.confirm_free', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                      Konfirmasi Ikut Program
                    </button>
                  </form>
                @else
                  {{-- FORM UPLOAD UNTUK PROGRAM BERBAYAR --}}
                  <form action="{{ route('booking.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-2 text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide">Upload Bukti Transfer</label>
                    <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png" required class="block w-full text-xs text-gray-500 file:mr-2 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-100 dark:file:bg-gray-700 dark:file:text-gray-200 file:text-gray-600 cursor-pointer bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition">
                    <button type="submit" class="w-full mt-3 py-2.5 bg-gray-900 dark:bg-gray-700 text-white text-xs font-bold rounded-xl hover:bg-black dark:hover:bg-gray-600 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                      </svg>
                      Kirim Bukti
                    </button>
                  </form>
                @endif
              @endif
            </div>
            @empty
            {{-- Empty State --}}
            <div class="py-12 px-6 text-center">
              <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.499 5.216 50.59 50.59 0 0 0-2.658.813m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>
              </div>
              <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Belum ada kelas yang didaftar.</p>
              <a href="{{ route('student.teachers.index') }}" class="text-green-600 dark:text-green-400 text-xs font-bold hover:underline mt-2 inline-flex items-center gap-1">
                Cari Guru Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
              </a>
            </div>
            @endforelse
          </div>
        </div>
      </div>