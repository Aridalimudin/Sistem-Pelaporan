<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
</head>
<body>
    <!-- Template 1: Laporan Terkirim -->
    <link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
    <div class="email-container">
        <div class="email-header terkirim">
            <span class="header-icon">📨</span>
            <h2>LAPORAN BERHASIL TERKIRIM</h2>
            <p>Terima kasih, laporan Anda telah berhasil dikirim</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge terkirim">Status: Laporan Terkirim</div>
            
            <h3>Assalamu'alaikum, Ananda yang Terhormat</h3>
            <p>Terima kasih telah menggunakan sistem pelaporan MTS AR-RIYADL. Laporan yang Anda kirimkan telah berhasil masuk ke dalam sistem kami.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Waktu Terkirim:</strong> 2 Juni 2025, 14:30 WIB<br>
                <strong>📋 Jenis Laporan:</strong> [Kategori Laporan]<br>
                <strong>⏱️ Estimasi Review:</strong> 2-4 jam<br>
                <strong>🔒 Status Keamanan:</strong> Data Terenkripsi<br>
                <strong>📧 Konfirmasi Dikirim Ke:</strong> [Email Pengirim]
            </div>
            
            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-25"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle current">1</div>
                        <div class="step-label">Terkirim</div>
                        <div class="step-date">02/06 14:30</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">2</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">-</div>
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
            
            <div class="alert-box info">
                <strong>📤 Laporan Berhasil Terkirim!</strong><br>
                Sistem kami telah mencatat laporan Anda dengan nomor tiket di atas. Simpan kode ini untuk melacak progress laporan.
            </div>
            
            <div class="important-info">
                <h4>⚠️ Informasi Penting:</h4>
                <ul>
                    <li><strong>Simpan Kode Laporan:</strong> Catat kode laporan #RPT-2025-0001 untuk tracking</li>
                    <li><strong>Jaga Kerahasiaan:</strong> Jangan share kode laporan ke pihak lain</li>
                    <li><strong>Email Notifikasi:</strong> Anda akan mendapat update via email</li>
                    <li><strong>Waktu Kerja:</strong> Proses hanya berjalan pada hari kerja (Senin-Jumat)</li>
                </ul>
            </div>
            
            <div class="next-steps">
                <h4>📋 Apa yang Terjadi Selanjutnya?</h4>
                <ul>
                    <li>Admin akan mereview laporan dalam 2-4 jam kerja</li>
                    <li>Anda akan mendapat konfirmasi "Laporan Diterima"</li>
                    <li>Tim akan melakukan verifikasi data dan informasi</li>
                    <li>Proses penanganan akan dimulai setelah verifikasi</li>
                    <li>Update status akan dikirim via email secara berkala</li>
                </ul>
            </div>
            
            <div class="security-note">
                <h4>🔒 Keamanan & Privasi</h4>
                <p>Laporan Anda dilindungi dengan enkripsi end-to-end. Identitas pelapor akan dijaga kerahasiaannya sesuai dengan kebijakan privasi sekolah. Hanya pihak berwenang yang dapat mengakses informasi laporan.</p>
            </div>
            
            <div class="highlight-box">
                <h4>🙏 Jazakallahu Khairan</h4>
                <p>Terima kasih atas kepedulian dan keberanian Anda dalam menyampaikan laporan ini. Partisipasi aktif dari siswa seperti Anda sangat membantu menciptakan lingkungan sekolah yang lebih baik dan aman untuk semua.</p>
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
                <p style="margin-top: 10px; font-size: 12px; opacity: 0.8;">
                    Email otomatis - Mohon tidak membalas email ini
                </p>
            </div>
        </div>
    </div>
</body>
</html>