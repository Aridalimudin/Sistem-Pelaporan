<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Laporan - MTS AR-RIYADL</title>
    <link rel="stylesheet" href="{{asset('css/email_bk.css')}}">
</head>
<body>
    <div class="email-container">
        <div class="email-header reminder">
            <span class="header-icon">⏰</span>
            <h2>PENGINGAT: LAPORAN MENUNGGU TINDAK LANJUT</h2>
            <p>Ada laporan yang belum diproses dalam waktu yang ditentukan.</p>
        </div>

        <div class="email-body">
            <h3>Assalamu'alaikum, Bapak/Ibu Guru BK {{$user->name}} yang Terhormat</h3>
            <p>Kami ingin mengingatkan Anda mengenai laporan dengan kode **{{$report->code}}** yang belum ditindaklanjuti. Laporan ini telah masuk sistem pada tanggal **{{$report->created_at->format('d M Y')}}** dan membutuhkan perhatian Anda segera.</p>

            <div class="info-box">
                <strong>📅 Tanggal Laporan Dibuat:</strong> {{$report->created_at->format('d M Y')}}, {{$report->created_at->format('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>👤 Pelapor:</strong> {{$report->student?->name}} (NIS: {{$report->student?->nis}})
            </div>

            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>

            <div class="alert-box warning">
                <strong>⚠️ Harap Segera Tindak Lanjuti!</strong><br>
                Untuk menjaga efektivitas sistem pelaporan dan kepuasan pelapor, mohon segera proses laporan ini.
            </div>

            <div class="next-steps">
                <h4>📋 Tindakan yang Direkomendasikan:</h4>
                <ul>
                    <li>Tinjau kembali detail laporan dan statusnya.</li>
                    <li>Lakukan investigasi atau tindakan yang diperlukan.</li>
                    <li>Update status laporan di sistem setelah tindakan diambil.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{route('admin.reports.show', ['code' => $report->code])}}" class="btn-action">➡️ Periksa Laporan Ini</a>
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