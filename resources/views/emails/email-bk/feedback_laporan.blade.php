<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Feedback Laporan - MTS AR-RIYADL</title>
    <link rel="stylesheet" href="{{asset('css/email_bk.css')}}">
</head>
<body>
    <div class="email-container">
        <div class="email-header feedback">
            <span class="header-icon">⭐</span>
            <h2>NOTIFIKASI FEEDBACK LAPORAN</h2>
            <p>Pelapor telah memberikan ulasan terhadap laporan yang telah selesai.</p>
        </div>

        <div class="email-body">
            <h3>Assalamu'alaikum, Bapak/Ibu Guru BK {{$user->name}} yang Terhormat</h3>
            <p>Kami memberitahukan bahwa pelapor dengan kode laporan **{{$report->code}}** telah memberikan ulasan dan feedback terhadap penanganan laporan mereka. Ulasan ini penting untuk evaluasi dan peningkatan kualitas layanan kami.</p>

            <div class="info-box">
                <strong>📅 Tanggal Feedback:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>👤 Pelapor:</strong> {{$report->student?->name}} (NIS: {{$report->student?->nis}})
            </div>

            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>
            
            <div class="alert-box info">
                <strong>📝 Ringkasan Ulasan:</strong><br>
                <p>"{{ Str::limit($feedback->comment, 150) }}"</p>
                <p><strong>Rating:</strong> {{ $feedback->rating }} dari 5 Bintang</p>
            </div>

            <div class="next-steps">
                <h4>📋 Tindakan yang Direkomendasikan:</h4>
                <ul>
                    <li>Tinjau ulasan dan feedback yang diberikan oleh pelapor.</li>
                    <li>Gunakan feedback ini untuk mengevaluasi proses penanganan laporan.</li>
                    <li>Identifikasi area yang dapat ditingkatkan berdasarkan masukan pelapor.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{route('admin.reports.show', ['code' => $report->code])}}" class="btn-action">➡️ Lihat Detail Feedback & Laporan</a>
            </div>
        </div>

        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Menciptakan Lingkungan Sekolah yang Aman</p>
            <div class="contact-info">
                <p><strong>Informasi Kontak:</strong></p>
                <p>📧 admin@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
                <p>🕐 Senin-Jumat: 07:00-15:00 WIB</p>
                <p>📍 Jl. Pendidikan No. 123, Yogyakarta</p>
            </div>
        </div>
    </div>
</body>
</html>