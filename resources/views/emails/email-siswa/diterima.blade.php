<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
</head>
<body>
<link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
    <!-- Template 2: Laporan Diterima -->
    <div class="email-container">
        <div class="email-header diterima">
            <span class="header-icon">✅</span>
            <h2>LAPORAN DITERIMA</h2>
            <p>Laporan Anda telah diterima dan akan segera diverifikasi</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diterima">Status: Laporan Diterima</div>
            
            <h3>Assalamu'alaikum, Ananda yang Terhormat</h3>
            <p>Alhamdulillah, laporan yang Anda kirimkan telah diterima oleh tim admin MTS AR-RIYADL dan akan segera diproses.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Diterima:</strong> 2 Juni 2025, 15:00 WIB<br>
                <strong>📋 Jenis Laporan:</strong> [Kategori Laporan]<br>
                <strong>⏱️ Estimasi Verifikasi:</strong> 4-6 jam<br>
                <strong>👤 Admin Penerima:</strong> Bapak/Ibu Admin
            </div>
            
            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-50"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">1</div>
                        <div class="step-label">Terkirim</div>
                        <div class="step-date">02/06 14:30</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle current">2</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">02/06 15:00</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">3</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">-</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">4</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">-</div>
                    </div>
                </div>
            </div>
            
            <div class="alert-box success">
                <strong>✅ Laporan Telah Diterima!</strong><br>
                Tim admin sedang memeriksa kelengkapan dan validitas laporan Anda. Proses verifikasi akan dilakukan dalam waktu dekat.
            </div>
            
            <div class="next-steps">
                <h4>📋 Langkah Selanjutnya:</h4>
                <ul>
                    <li>Laporan akan diverifikasi oleh admin dalam 4-6 jam</li>
                    <li>Jika diperlukan, admin akan menghubungi untuk klarifikasi</li>
                    <li>Anda akan mendapat notifikasi setiap perubahan status</li>
                    <li>Pastikan nomor telepon/email dapat dihubungi</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">🔍 Lacak Status Laporan</a>
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