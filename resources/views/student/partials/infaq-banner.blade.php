 
    @php
        // Logika Warna Berdasarkan Status
        $bgColor = $tagihanInfaq->status === 'rejected' ? '#fef2f2' : '#fffbeb';
        $borderColor = $tagihanInfaq->status === 'rejected' ? '#fecaca' : '#fde68a';
        $iconColor = $tagihanInfaq->status === 'rejected' ? '#ef4444' : '#f59e0b';
        $btnColor = $tagihanInfaq->status === 'rejected' ? '#dc2626' : '#f59e0b';
    @endphp

    <div style="background-color: {{ $bgColor }}; border: 1px solid {{ $borderColor }}; border-radius: 1.5rem; padding: 2rem; position: relative; overflow: hidden; margin-bottom: 2.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); font-family: ui-sans-serif, system-ui, sans-serif;">

      {{-- Ikon Background Transparan --}}
      <div style="position: absolute; right: -1rem; top: -1rem; opacity: 0.1; color: {{ $iconColor }};">
        <svg style="width: 10rem; height: 10rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
        </svg>
      </div>

      {{-- Container Utama Split Kiri Kanan --}}
      <div style="display: flex; flex-wrap: wrap; gap: 2.5rem; position: relative; z-index: 10; align-items: stretch;">
        
        {{-- ========================================== --}}
        {{-- KOLOM KIRI: EDUKASI & INFORMASI --}}
        {{-- ========================================== --}}
        <div style="flex: 1 1 55%; min-width: 280px; display: flex; flex-direction: column;">

          {{-- Header: Ikon & Judul --}}
          <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-start;">
            <div style="width: 4rem; height: 4rem; background-color: #ffffff; border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: {{ $iconColor }}; border: 1px solid {{ $borderColor }}; box-shadow: 0 1px 2px rgba(0,0,0,0.05); flex-shrink: 0;">
              <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"></path>
              </svg>
            </div>

            <div style="flex: 1;">
              <h3 style="font-size: 1.125rem; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 0.5rem; line-height: 1.4;">
                Pemberitahuan Infaq Operasional ({{ $tagihanInfaq->periode_bulan }})
              </h3>
              <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @if($tagihanInfaq->status === 'unpaid')
                <span style="padding: 0.25rem 0.75rem; background-color: #fee2e2; color: #dc2626; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border-radius: 9999px; letter-spacing: 0.05em;">Belum Ditunaikan</span>
                @elseif($tagihanInfaq->status === 'pending')
                <span style="padding: 0.25rem 0.75rem; background-color: #dbeafe; color: #2563eb; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border-radius: 9999px; letter-spacing: 0.05em;">Menunggu Konfirmasi</span>
                @elseif($tagihanInfaq->status === 'rejected')
                <span style="padding: 0.25rem 0.75rem; background-color: #dc2626; color: #ffffff; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; border-radius: 9999px; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.25rem;">
                  <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg> DITOLAK
                </span>
                @endif
              </div>
            </div>
          </div>

          @if($tagihanInfaq->status === 'rejected')
          <div style="background-color: #ffffff; padding: 1rem; border-radius: 1rem; border-left: 4px solid #ef4444; margin-bottom: 1.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
            <p style="font-size: 0.875rem; font-weight: 700; color: #b91c1c; margin: 0 0 0.25rem 0;">Catatan Admin:</p>
            <p style="font-size: 0.875rem; color: #374151; font-style: italic; margin: 0;">"{{ $tagihanInfaq->catatan_admin ?? 'Afwan, bukti transfer tidak terbaca/tidak valid. Mohon berkenan untuk mengunggah ulang.' }}"</p>
          </div>
          @else
          
          {{-- Deskripsi --}}
          <p style="font-size: 0.9375rem; color: #374151; margin-top: 0; margin-bottom: 1.25rem; line-height: 1.6;">
            Demi keberlangsungan operasional dakwah dan kenyamanan proses belajar mengajar, seluruh dana infaq yang masuk akan dikelola secara amanah untuk keperluan:
          </p>
          
          {{-- List Keperluan --}}
          <div style="display: flex; flex-wrap: wrap; gap: 0.75rem 0; margin-bottom: 1.5rem;">
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Kafalah (Mukafaah) Asatidz</span>
            </div>
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Pengembangan Kurikulum</span>
            </div>
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Pemeliharaan IT & Server</span>
            </div>
            <div style="width: 50%; min-width: 200px; display: flex; align-items: center; gap: 0.5rem;">
              <div style="width: 1.25rem; height: 1.25rem; border-radius: 9999px; background-color: #dcfce7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg style="width: 0.875rem; height: 0.875rem; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
              </div>
              <span style="font-size: 0.875rem; color: #1f2937;">Program Sosial & Beasiswa</span>
            </div>
          </div>

          {{-- Kutipan Hadits --}}
          <div style="background-color: rgba(255, 255, 255, 0.6); padding: 1rem; border-radius: 1rem; border: 1px solid rgba(253, 230, 138, 0.5);">
            <p style="font-size: 0.875rem; color: #4b5563; font-style: italic; line-height: 1.6; margin: 0;">
              "Harta tidak akan berkurang karena sedekah. Dan seorang hamba yang pemaaf pasti akan Allah tambahkan kewibawaan baginya." 
              <span style="font-weight: 700; color: #1f2937; margin-left: 0.25rem;">(HR. Muslim)</span>
            </p>
          </div>
          @endif

        </div>

        {{-- ========================================== --}}
        {{-- KOLOM KANAN: EKSEKUSI PEMBAYARAN --}}
        {{-- ========================================== --}}
        <div style="flex: 1 1 35%; min-width: 280px; display: flex; flex-direction: column;">
          
          {{-- Kartu Putih Utama --}}
          <div style="background-color: #ffffff; border-radius: 1.5rem; border: 1px solid #f3f4f6; box-shadow: 0 10px 25px -5px rgba(120, 53, 15, 0.05); padding: 1.5rem; display: flex; flex-direction: column; height: 100%;">
            
            {{-- Nominal --}}
            <div style="text-align: center; margin-bottom: 1.5rem;">
              <p style="font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.5rem 0;">Nilai Partisipasi</p>
              <div style="font-size: 2.25rem; font-weight: 900; color: #111827; display: flex; align-items: baseline; justify-content: center; gap: 0.25rem;">
                <span style="font-size: 1.25rem; color: #9ca3af;">Rp</span> {{ number_format($tagihanInfaq->nominal, 0, ',', '.') }}
              </div>
            </div>

            @if($tagihanInfaq->status === 'unpaid' || $tagihanInfaq->status === 'rejected')
            
            {{-- Area QRIS --}}
            <div style="background-color: #f9fafb; border-radius: 1rem; padding: 1rem; display: flex; flex-direction: column; align-items: center; border: 1px solid #f3f4f6; margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.75rem; font-weight: 700; color: #1f2937; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 0.75rem 0;">Scan QRIS</h4>
                <div style="background-color: #ffffff; padding: 0.5rem; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                    <img src="{{ asset('images/dqa-qris.png') }}" alt="QRIS Infaq" style="width: 140px; height: auto; object-fit: contain;">
                </div>
                <p style="font-size: 0.65rem; color: #6b7280; text-align: center; margin: 0.75rem 0 0 0; max-width: 200px;">
                    Gopay, OVO, Dana, LinkAja & M-Banking.
                </p>
            </div>

            {{-- Form Upload Konfirmasi --}}
            <form action="{{ route('infaq.upload', $tagihanInfaq->id) }}" method="POST" enctype="multipart/form-data" 
              onsubmit="document.getElementById('btn-upload-{{ $tagihanInfaq->id }}').disabled = true; document.getElementById('btn-upload-{{ $tagihanInfaq->id }}').style.opacity = '0.5'; document.getElementById('btn-upload-{{ $tagihanInfaq->id }}').style.cursor = 'not-allowed'; document.getElementById('btn-text-{{ $tagihanInfaq->id }}').innerText = 'Mengirim...';"
              style="margin-top: auto; display: flex; flex-direction: column;">
              @csrf
              
              <input type="file" name="bukti_transfer" accept=".jpg,.jpeg,.png" required
                style="display: block; width: 100%; font-size: 0.75rem; color: #4b5563; margin-bottom: 0.75rem; padding: 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; background-color: #f9fafb; cursor: pointer; box-sizing: border-box;">

              <button id="btn-upload-{{ $tagihanInfaq->id }}" type="submit" style="width: 100%; padding: 0.75rem; background-color: {{ $btnColor }}; color: #ffffff; font-size: 0.875rem; font-weight: 700; border-radius: 0.75rem; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background-color 0.2s;">
                <span id="btn-text-{{ $tagihanInfaq->id }}">{{ $tagihanInfaq->status === 'rejected' ? 'Upload Ulang Bukti' : 'Kirim Bukti Pembayaran' }}</span>
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                </svg>
              </button>
            </form>
            
            @elseif($tagihanInfaq->status === 'pending')
            <div style="background-color: #eff6ff; border-radius: 1rem; border: 1px solid #bfdbfe; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; height: 100%; min-height: 200px;">
              <div style="position: relative; margin-bottom: 1rem;">
                <svg style="width: 3rem; height: 3rem; color: #bfdbfe; animation: spin 1s linear infinite;" fill="none" viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-dasharray="15 85"></circle>
                </svg>
                <svg style="width: 1.5rem; height: 1.5rem; color: #2563eb; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
              </div>
              <span style="font-size: 1.125rem; font-weight: 700; color: #1d4ed8; margin-bottom: 0.5rem;">Verifikasi Admin</span>
              <span style="font-size: 0.875rem; color: #2563eb;">
                Jazakumullah Khairan. Bukti transfer Anda sedang kami proses.
              </span>
            </div>
            @endif

          </div>
        </div>

      </div>
    </div>
    @endif