<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siap Diproses - MTS AR-RIYADL</title>
    <link rel="stylesheet" href="{{asset('css/email_bk.css')}}">
</head>
<body>
    <div class="email-container">
        <div class="email-header ready-process">
            <span class="header-icon">✅</span>
            <h2>LAPORAN SIAP DIPROSES</h2>
            <p>Detail laporan telah lengkap dan siap untuk ditindaklanjuti.</p>
        </div>

        <div class="email-body">
            <h3>Assalamu'alaikum, Bapak/Ibu Guru BK {{$user->name}} yang Terhormat</h3>
            <p>Pelapor dengan kode laporan **{{$report->code}}** telah melengkapi semua dokumen dan informasi yang dibutuhkan. Laporan ini sekarang siap untuk masuk ke tahap investigasi dan penanganan lebih lanjut.</p>

            <div class="info-box">
                <strong>📅 Tanggal Kelengkapan:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>👤 Pelapor:</strong> {{$report->student?->name}} (NIS: {{$report->student?->nis}})
            </div>

            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>

            <div class="alert-box success">
                <strong>🎉 Informasi Laporan Lengkap!</strong><br>
                Semua data yang diperlukan untuk laporan ini telah dipenuhi oleh pelapor. Mohon segera proses laporan ini sesuai prioritas.
            </div>

            <div class="next-steps">
                <h4>📋 Langkah Selanjutnya:</h4>
                <ul>
                    <li>Segera mulai proses investigasi dan tindak lanjut.</li>
                    <li>Koordinasikan dengan pihak terkait jika diperlukan.</li>
                    <li>Update status laporan di sistem agar pelapor mendapatkan notifikasi.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{route('admin.reports.show', ['code' => $report->code])}}" class="btn-action">➡️ Mulai Proses Laporan</a>
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