<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siap Diproses - MTS AR-RIYADL</title>
    <style>
    body {
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        background-color: #f4f4f7;
        margin: 0;
        padding: 20px;
        color: #333;
    }
    .email-container {
        max-width: 680px;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .email-header {
        padding: 30px;
        text-align: center;
        color: white;
    }
    .email-header .header-icon {
        font-size: 48px;
    }
    .email-header h2 {
        margin: 10px 0 5px;
        font-size: 26px;
        font-weight: bold;
    }
    .email-header p {
        margin: 0;
        font-size: 16px;
        opacity: 0.9;
    }

    /* --- WARNA HEADER UNTUK SETIAP STATUS --- */
    .email-header.new-report {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    .email-header.ready-process {
        background: linear-gradient(135deg, #28a745, #218838);
    }
    .email-header.feedback {
        background: linear-gradient(135deg, #17a2b8, #117a8b);
    }
    .email-header.reminder {
        background: linear-gradient(135deg, #fd7e14, #d96d11);
    }

    .email-body {
        padding: 30px;
    }
    h3,
    h4 {
        color: #333;
        margin-top: 0;
    }
    h3 {
        font-size: 22px;
    }
    h4 {
        font-size: 18px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .ticket-code {
        background-color: #e9ecef;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 2px;
        margin: 20px 0;
        color: #495057;
    }
    .info-box,
    .alert-box,
    .next-steps {
        padding: 20px;
        margin-top: 25px;
        border-radius: 8px;
        line-height: 1.7;
    }
    .info-box {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    /* --- WARNA ALERT BOX UNTUK SETIAP KONTEKS --- */
    .alert-box.primary {
        background-color: #cce5ff;
        border-left: 5px solid #007bff;
        color: #004085;
    }
    .alert-box.success {
        background-color: #e9f7ef;
        border-left: 5px solid #28a745;
        color: #155724;
    }
    .alert-box.info {
        background-color: #d1ecf1;
        border-left: 5px solid #17a2b8;
        color: #0c5460;
    }
    .alert-box.warning {
        background-color: #fff3cd;
        border-left: 5px solid #fd7e14;
        color: #856404;
    }

    .next-steps ul {
        padding-left: 20px;
        margin: 0;
    }
    .btn-action {
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        margin-top: 15px;
    }

    /* --- WARNA TOMBOL UNTUK SETIAP AKSI --- */
    .btn-action.blue-dark {
        background-color: #007bff;
    }
    .btn-action.green {
        background-color: #28a745;
    }
    .btn-action.blue-light {
        background-color: #17a2b8;
    }
    .btn-action.orange {
        background-color: #fd7e14;
    }

    .email-footer {
        background-color: #343a40;
        color: #adb5bd;
        padding: 30px;
        text-align: center;
    }
    .footer-logo {
        font-size: 24px;
        font-weight: bold;
        color: #ffffff;
        margin-bottom: 10px;
    }
    </style>
    </head>
<body>
    <div class="email-container">
        <div class="email-header ready-process">
            <span class="header-icon">✅</span>
            <h2>LAPORAN SIAP DIPROSES</h2>
            <p>Detail laporan telah lengkap dan siap untuk ditindaklanjuti.</p>
        </div>
        <div class="email-body">
            <h3>Assalamu'alaikum, Ibu/Bapak yang Terhormat</h3>
            <p>Pelapor dengan kode laporan {{$report->code}} telah melengkapi semua dokumen dan informasi yang dibutuhkan. Laporan ini sekarang siap untuk masuk ke tahap investigasi dan penanganan lebih lanjut.</p>
            <div class="info-box">
                <strong>📅 Tanggal Laporan:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>👤 Pelapor:</strong> {{$report->student?->name}} (NIS: {{$report->student?->nis}})
            </div>
            <div class="ticket-code">Kode Laporan: {{$report->code}}</div>
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
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-action green">➡️ Mulai Proses Laporan</a>
            </div>
        </div>
        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Menciptakan Lingkungan Sekolah yang Aman</p>
            <div class="contact-info">
                <p><strong>Informasi Kontak:</strong></p>
                <p>📧 admin@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
                <p>🕐 Senin-Jumat: 07:00-15:00 WIB</p>
                <p>📍 JL. RANCABENTANG BARAT RT. 03 RW.15</p>
            </div>
        </div>
    </div>
</body>
</html>