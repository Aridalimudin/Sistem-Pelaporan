<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
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

    /* Header Colors */
    .email-header.terkirim {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }
    .email-header.verifikasi {
        background: linear-gradient(135deg, #ffc107, #d39e00);
    }
    .email-header.diproses {
        background: linear-gradient(135deg, #6f42c1, #5a32a3);
    }
    .email-header.selesai {
        background: linear-gradient(135deg, #28a745, #218838);
    }

    .email-body {
        padding: 30px;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        margin-bottom: 25px;
    }
    /* Badge Colors */
    .status-badge.terkirim {
        background-color: #007bff;
    }
    .status-badge.verifikasi {
        background-color: #ffc107;
        color: #212529;
    }
    .status-badge.diproses {
        background-color: #6f42c1;
    }
    .status-badge.selesai {
        background-color: #28a745;
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
        background-color: #f0f0f0;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 2px;
        margin: 20px 0;
    }
    .info-box,
    .alert-box,
    .highlight-box,
    .next-steps,
    .solution-box,
    .rating-prompt-box {
        padding: 20px;
        margin-top: 25px;
        border-radius: 8px;
        line-height: 1.7;
    }
    .info-box {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    /* Alert Box Colors */
    .alert-box.info {
        background-color: #e2f0d9;
        border-left: 5px solid #28a745;
        color: #1a5e2a;
    }
    .alert-box.warning {
        background-color: #fff3cd;
        border-left: 5px solid #ffc107;
        color: #856404;
    }
    .alert-box.process {
        background-color: #e7e0f8;
        border-left: 5px solid #6f42c1;
        color: #3b1e70;
    }
    .alert-box.success {
        background-color: #e9f7ef;
        border-left: 5px solid #28a745;
        color: #155724;
    }

    .progress-tracker {
        margin: 30px 0;
    }
    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 15px;
    }
    .progress-line {
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 4px;
        background-color: #e9ecef;
        z-index: 1;
    }
    .progress-line-active {
        height: 100%;
        background-color: #007bff;
        transition: width 0.5s ease;
    }

    .progress-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #ced4da;
        border: 4px solid #ffffff;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
    }
    .progress-step .step-circle.active {
        background-color: #007bff;
    }
    .progress-step .step-circle.current.terkirim {
        background-color: #007bff;
    }
    .progress-step .step-circle.current.verifikasi {
        background-color: #ffc107;
        color: #333;
    }
    .progress-step .step-circle.current.diproses {
        background-color: #6f42c1;
    }
    .progress-step .step-circle.current.selesai {
        background-color: #28a745;
    }

    .step-label {
        font-size: 13px;
        margin-top: 10px;
        font-weight: bold;
    }
    .step-date {
        font-size: 12px;
        color: #6c757d;
    }

    .btn-track {
        background-color: #007bff;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-decoration: none;
        display: inline-block;
        margin-top: 15px;
    }

    .info-box,
    .next-steps,
    .security-note,
    .highlight-box {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-top: 25px;
        line-height: 1.8;
    }

    .alert-box {
        padding: 20px;
        border-radius: 8px;
        margin: 30px 0;
        border-left: 5px solid;
        background-color: #e2f0d9;
        border-color: #28a745;
        color: #1a5e2a;
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

    /* Header Color */
    .email-header.ditolak { background: linear-gradient(135deg, #dc3545, #b02a37); }

    /* Badge Color */
    .status-badge.ditolak { background-color: #dc3545; }

    /* Alert Box Color */
    .alert-box.danger { background-color: #f8d7da; border-left: 5px solid #dc3545; color: #721c24; }

    /* Progress Circle Color */
    .progress-step .step-circle.current.ditolak { background-color: #dc3545; }

    /* Box untuk Alasan Penolakan */
    .rejection-reason {
        padding: 20px;
        margin-top: 25px;
        border-radius: 8px;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }
    .rejection-reason h4 { color: #721c24; }
    .rejection-reason ul { margin-top: 10px; margin-left: 20px; color: #721c24; }

    .solution-box {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }

    .solution-box h4 {
        color: #856404;
        margin-bottom: 15px;
    }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header ditolak">
            <span class="header-icon">❌</span>
            <h2>LAPORAN TIDAK DAPAT DIPROSES</h2>
            <p>Maaf, laporan Anda tidak memenuhi kriteria untuk ditindaklanjuti.</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge ditolak">Status: Ditolak</div>
            
            <h3>Assalamu'alaikum, Ananda {{$report->student?->name}} yang Terhormat</h3>
            <p>Terima kasih atas laporan yang telah Anda kirimkan. Setelah melakukan verifikasi awal, dengan berat hati kami sampaikan bahwa laporan ini tidak dapat diproses lebih lanjut.</p>
            
            <div class="ticket-code">Kode Laporan: {{$report->code}}</div>

            <div class="info-box">
                <strong>📅 Tanggal Terkirim:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>⚠️ Urgensi Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>📋 Jenis Laporan:</strong> Bullying / Perundungan<br>
                <strong>👤 Reviewer:</strong> {{Auth::user()->name}}<br>
                <strong>❌ Status Akhir:</strong> Ditolak untuk Diproses
            </div>

            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line"><div class="progress-line-active" style="width: 50%;"></div></div>
                    <div class="progress-step">
                        <div class="step-circle active">1</div>
                        <div class="step-label">Laporan Terkirim</div>
                        <div class="step-date">13 Jul 2025 20:00</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle current ditolak">2</div>
                        <div class="step-label">Verifikasi & Kelengkapan</div>
                        <div class="step-date">13 Jul 2025 21:30</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle">3</div>
                        <div class="step-label">Sedang Diproses</div>
                        <div class="step-date">-</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle">4</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">-</div>
                    </div>
                </div>
            </div>
            
            <div class="rejection-reason">
                <h4>📋 Alasan Penolakan:</h4>
                <p><strong>Informasi Kurang Memadai:</strong> Setelah ditinjau, laporan yang disampaikan tidak memiliki cukup detail dan bukti pendukung yang kuat untuk dapat diinvestigasi lebih lanjut sebagai kasus pelanggaran.</p>
            </div>
            
            <div class="solution-box">
                <h4>💡 Saran dan Solusi:</h4>
                <ul style="margin-top: 10px; margin-left: 20px; color: #856404;">
                    <li><strong>Lengkapi Informasi:</strong> Jika memungkinkan, kumpulkan informasi dan bukti yang lebih lengkap</li>
                    <li><strong>Konsultasi Langsung:</strong> Hubungi guru BK atau wali kelas untuk berdiskusi mengenai masalah ini</li>
                    <li><strong>Laporan Ulang:</strong> Anda dapat mengirim laporan baru dengan informasi yang lebih lengkap</li>
                </ul>
            </div>
            
            <div class="highlight-box">
                <h4>🤝 Tetap Terbuka untuk Komunikasi</h4>
                <p>Meskipun laporan ini tidak dapat diproses melalui sistem, kami tetap terbuka untuk komunikasi dan siap membantu melalui jalur lain yang lebih sesuai. Jangan ragu untuk menghubungi kami secara langsung.</p>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-track">📞 Hubungi Admin</a>
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