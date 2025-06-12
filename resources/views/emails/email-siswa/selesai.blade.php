<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
</head>
<body>
    <!-- Template 5: Laporan Selesai -->
    <link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
    <div class="email-container">
        <div class="email-header selesai">
            <span class="header-icon">🎉</span>
            <h2>LAPORAN SELESAI DITANGANI</h2>
            <p>Alhamdulillah, laporan Anda telah berhasil diselesaikan</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge selesai">Status: Selesai</div>
            
            <h3>Assalamu'alaikum, Ananda yang Terhormat</h3>
            <p>Alhamdulillahi rabbil 'alamiin, kami dengan senang hati mengabarkan bahwa laporan yang Anda sampaikan telah berhasil diselesaikan dengan tuntas.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Selesai:</strong> 5 Juni 2025, 16:00 WIB<br>
                <strong>📋 Jenis Laporan:</strong> [Kategori Laporan]<br>
                <strong>⏱️ Total Waktu Penanganan:</strong> 3 hari kerja<br>
                <strong>👤 Penanggung Jawab:</strong> Tim BK & Kesiswaan<br>
                <strong>✅ Status Akhir:</strong> Selesai dengan Sukses
            </div>
            
            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-100"></div>
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
                        <div class="step-circle active">4</div>
                        <div class="step-label">Diproses</div>
                        <div class="step-date">03/06 08:00</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">5</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">05/06 16:00</div>
                    </div>
                </div>
            </div>
            
            <div class="alert-box success">
                <strong>🎉 Laporan Berhasil Diselesaikan!</strong><br>
                Semua tindakan yang diperlukan telah dilakukan dan masalah yang dilaporkan telah ditangani dengan baik sesuai prosedur sekolah.
            </div>
            
            <div class="solution-box">
                <h4>✅ Ringkasan Penyelesaian:</h4>
                <p><strong>Tindakan yang Telah Dilakukan:</strong></p>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    <li>Investigasi menyeluruh terhadap kasus yang dilaporkan</li>
                    <li>Mediasi dan konseling dengan pihak-pihak terkait</li>
                    <li>Penerapan sanksi edukatif sesuai aturan sekolah</li>
                    <li>Program pembinaan untuk mencegah kejadian serupa</li>
                </ul>
            </div>
            
            <div class="highlight-box">
                <h4>🙏 Terima Kasih atas Keberanian Anda</h4>
                <p>Jazakallahu khairan atas keberanian dan kepedulian Anda dalam melaporkan masalah ini. Kontribusi Anda sangat berharga dalam menciptakan lingkungan sekolah yang lebih baik, aman, dan kondusif untuk semua.</p>
            </div>
            
            <div class="next-steps">
                <h4>📋 Informasi Penting:</h4>
                <ul>
                    <li>Kasus ini telah ditutup dan dianggap selesai</li>
                    <li>Semua pihak telah mendapat pembinaan yang sesuai</li>
                    <li>Monitoring akan terus dilakukan untuk memastikan tidak ada pengulangan</li>
                    <li>Jika ada masalah serupa, jangan ragu untuk melaporkan kembali</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">📋 Lihat Laporan Lengkap</a>
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