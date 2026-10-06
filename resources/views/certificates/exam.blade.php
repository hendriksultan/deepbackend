<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat Kelulusan - Deepquran Academy</title>
    <style>
        /* Pengaturan Kertas */
        @page { 
            margin: 0px; 
            size: A4 landscape; 
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #111827;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        /* =========================================
           SIDEBAR KIRI (Gaya Modern Dicoding)
           ========================================= */
        .sidebar {
            position: absolute;
            top: 0; left: 0; bottom: 0;
            width: 280px;
            background-color: #064e3b; /* Hijau Tua Deepquran */
            color: #ffffff;
            text-align: center;
            border-right: 5px solid #d4af37; /* Aksen Emas pemisah */
        }
        
        .logo-container {
            margin-top: 60px;
        }
        .logo-container img {
            max-width: 130px;
            height: auto;
        }

        .sidebar-title {
            margin-top: 50px;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1.4;
            color: #d4af37; /* Emas */
        }

        .qr-container {
            position: absolute;
            bottom: 60px;
            width: 100%;
            text-align: center;
        }
        .qr-code-box img {
            border: 5px solid #ffffff;
            border-radius: 5px;
        }
        .qr-text {
            margin-top: 10px;
            font-size: 11px;
            color: #d1d5db;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cert-id {
            margin-top: 5px;
            font-size: 12px;
            font-family: monospace;
            font-weight: bold;
            color: #ffffff;
        }

        /* =========================================
           AREA KONTEN UTAMA (Kanan)
           ========================================= */
        .main-content {
            position: absolute;
            top: 0; left: 285px; right: 0; bottom: 0;
            padding: 70px 80px;
            text-align: center;
            box-sizing: border-box;
        }

        .academy-name { 
            font-size: 34px; 
            font-weight: bold; 
            color: #064e3b; 
            letter-spacing: 3px; 
            font-family: 'Times New Roman', Times, serif; 
        }
        .academy-sub { 
            font-size: 12px; 
            color: #6b7280; 
            letter-spacing: 2px; 
            margin-top: 5px;
            margin-bottom: 40px; 
            text-transform: uppercase;
        }
        
        .awarded-text { 
            font-size: 16px; 
            color: #374151; 
            margin-bottom: 10px; 
        }
        
        /* Font Nama Santri (Bersambung Elegan) */
        .student-name { 
            font-size: 55px; 
            color: #000000; 
            margin: 10px 0; 
            font-family: 'Brush Script MT', 'Lucida Handwriting', 'Great Vibes', cursive; 
            border-bottom: 1px solid #d1d5db;
            display: inline-block;
            padding: 0 40px 5px 40px;
        }
        
        .program-class {
            font-size: 18px;
            font-weight: bold;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .exam-title { 
            font-size: 18px; 
            font-weight: bold; 
            color: #064e3b; 
            margin-bottom: 30px; 
        }
        
        .score-box { 
            margin-top: 10px; 
            font-size: 16px; 
            color: #4b5563; 
            background-color: #f3f4f6;
            display: inline-block;
            padding: 10px 30px;
            border-radius: 50px;
        }
        .score-number { 
            font-size: 18px; 
            font-weight: bold; 
            color: #064e3b; 
            text-transform: uppercase;
        }

        /* Tanda Tangan */
        .signature-table { 
            width: 100%; 
            margin-top: 50px; 
        }
        .signature-table td { 
            width: 50%; 
            text-align: center; 
            vertical-align: bottom; 
        }
        .date-text { 
            font-size: 13px; 
            margin-bottom: 40px; 
            color: #4b5563; 
        }
        .signature-line { 
            width: 220px; 
            border-bottom: 1px solid #111827; 
            margin: 0 auto 5px auto; 
        }
        .signature-name { 
            font-weight: bold; 
            font-size: 15px; 
            color: #111827; 
        }
        .signature-title { 
            font-size: 12px; 
            color: #6b7280; 
        }
    </style>
</head>
<body>
    @php
        // 1. Membersihkan karakter Arab dari nama pengajar
        $rawTeacherName = $attempt->exam->teacherProfile->user->name ?? 'Asatidz Penguji';
        $cleanTeacherName = trim(preg_replace('/[\x{0600}-\x{06FF}]/u', '', $rawTeacherName));

        // 2. Logika Penentuan Program/Kelas Santri
        $booking = \App\Models\Booking::where('student_name', $attempt->user->name)
                    ->whereIn('status', ['active', 'approved'])
                    ->first();
        
        $programClass = 'Program Al-Quran & Bahasa Arab';
        if ($booking) {
            $type = strtolower($booking->program_type);
            if ($type == 'bahasa') $programClass = 'Program Bahasa Arab';
            elseif ($type == 'tahsin') $programClass = 'Program Tahsin Al-Quran';
            elseif ($type == 'tahfidz') $programClass = 'Program Tahfidz Al-Quran';
            elseif ($type == 'iqra') $programClass = 'Program Iqra';
        } else {
            $titleLower = strtolower($attempt->exam->title);
            if (str_contains($titleLower, 'bahasa')) $programClass = 'Program Bahasa Arab';
            elseif (str_contains($titleLower, 'tahsin')) $programClass = 'Program Tahsin Al-Quran';
            elseif (str_contains($titleLower, 'tahfidz')) $programClass = 'Program Tahfidz Al-Quran';
        }

        // 3. Konversi Nilai Menjadi Predikat Berdasarkan Gender
        $score = $attempt->score;
        $gender = strtolower($attempt->user->gender ?? 'laki-laki');
        $isFemale = in_array($gender, ['p', 'perempuan', 'female', 'akhwat']);

        if ($score >= 90) {
            $predikat = $isFemale ? 'Mumtazah (Istimewa)' : 'Mumtaz (Istimewa)';
        } elseif ($score >= 80) {
            $predikat = 'Jayyid Jiddan (Sangat Baik)';
        } elseif ($score >= 70) {
            $predikat = 'Jayyid (Baik)';
        } else {
            $predikat = 'Maqbul (Cukup)';
        }

        // 4. Data untuk QR Code
        $certId = 'DQA-' . date('Y') . '-' . str_pad($attempt->id, 5, '0', STR_PAD_LEFT);
        $qrData = "Validasi Deepquran Academy | ID: {$certId} | Nama: {$attempt->user->name} | Program: {$programClass} | Predikat: {$predikat}";

        // 5. Mengambil Logo Langsung dari Server Folder (Lebih cepat dan anti-error)
        $logoPath = public_path('images/d6.png');
        $logoSrc = '';
        if (file_exists($logoPath)) {
            // Jika file ditemukan di server, ubah ke Base64 agar DomPDF bisa merendernya sempurna
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoSrc = 'data:image/png;base64,' . $logoData;
        } else {
            // Fallback jika menggunakan sistem storage lain
            $logoSrc = 'https://deepquranacademy.id/images/d6.png';
        }
    @endphp

    <div class="sidebar">
        <div class="logo-container">
            <img src="{{ $logoSrc }}" alt="Logo Deepquran">
        </div>
        
        <div class="sidebar-title">
            Sertifikat<br>Kelulusan
        </div>

        <div class="qr-container">
            <div class="qr-code-box">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&margin=0&data={{ urlencode($qrData) }}" width="110" height="110">
            </div>
            <div class="qr-text">Scan Untuk Verifikasi</div>
            <div class="cert-id">{{ $certId }}</div>
        </div>
    </div>

    <div class="main-content">
        <div class="academy-name">DEEP QURAN ACADEMY</div>
        <div class="academy-sub">Pusat Pembelajaran Al-Quran & Bahasa Arab</div>
        
        <div class="awarded-text">
            Diberikan dengan penuh kebanggaan kepada:
        </div>
        
        <div class="student-name">{{ $attempt->user->name }}</div>
        
        <div class="awarded-text">
            Atas pencapaian dan kelulusannya pada:
        </div>
        
        <div class="program-class">{{ $programClass }}</div>
        <div class="exam-title">Evaluasi: "{{ $attempt->exam->title }}"</div>
        
        <div class="score-box">
            Predikat Kelulusan: <span class="score-number">{{ $predikat }}</span>
        </div>

        <table class="signature-table">
            <tr>
                <td>
                    <div class="date-text">Ditetapkan pada: {{ \Carbon\Carbon::parse($attempt->created_at)->isoFormat('D MMMM Y') }}</div>
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $cleanTeacherName }}</div>
                    <div class="signature-title">Asatidz Penguji / Penanggung Jawab</div>
                </td>
                <td>
                    <div class="date-text">&nbsp;</div>
                    <div class="signature-line"></div>
                    <div class="signature-name">Pimpinan Deepquran Academy</div>
                    <div class="signature-title">Direktur Utama</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>