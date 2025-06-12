<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
</head>
<body>
<link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
    <!-- Template 4: Laporan Diproses -->
    <div class="email-container">
        <div class="email-header diproses">
            <span class="header-icon">⚙️</span>
            <h2>LAPORAN SEDANG DIPROSES</h2>
            <p>Tim kami sedang menangani laporan Anda</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diproses">Status: Sedang Diproses</div>
            
            <h3>Assalamu'alaikum, Ananda yang Terhormat</h3>
            <p>Laporan Anda sedang dalam tahap penanganan aktif. Tim terkait telah memulai proses investigasi dan tindak lanjut sesuai dengan prosedur yang berlaku.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Mulai Diproses:</strong> 3 Juni 2025, 08:00 WIB<br>
                <strong>📋 Jenis Laporan:</strong> [Kategori Laporan]<br>
                <strong>⏱️ Estimasi Selesai:</strong> 5 Juni 2025<br>
                <strong>👤 Penanggung Jawab:</strong> Tim BK & Kesiswaan<br>
                <strong>🎯 Status:</strong> Dalam Investigasi
            </div>
            
            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-75"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">1</div>
                        <div class="step-label">Terkirim</div>
                        <div class="step-date">02/06 14:30</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">2</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">02/06 15:00</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">3</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">02/06 18:30</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle current">4</div>
                        <div class="step-label">Diproses</div>
                        <div class="step-date">03/06 08:00</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">5</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">-</div>
                    </div>
                </div>
            </div>
            
            <div class="alert-box warning">
                <strong>⚙️ Laporan Sedang Ditangani!</strong><br>
                Tim kami sedang melakukan investigasi menyeluruh dan mengambil langkah-langkah yang diperlukan untuk menyelesaikan masalah yang Anda laporkan.
            </div>
            
            <div class="highlight-box">
                <h4>🔄 Tindakan yang Sedang Dilakukan:</h4>
                <ul style="text-align: left; margin-top: 15px;">
                    <li>✓ Investigasi awal telah dimulai</li>
                    <li>⚙️ Wawancara dengan pihak terkait</li>
                    <li>📋 Pengumpulan bukti dan dokumentasi</li>
                    <li>🤝 Koordinasi dengan unit terkait</li>
                </ul>
            </div>
            
            <div class="next-steps">
                <h4>📋 Yang Perlu Anda Ketahui:</h4>
                <ul>
                    <li>Proses penanganan sedang berjalan sesuai prosedur</li>
                    <li>Tim akan menghubungi jika memerlukan informasi tambahan</li>
                    <li>Progress akan diupdate secara berkala</li>
                    <li>Estimasi penyelesaian: 2-3 hari kerja</li>
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