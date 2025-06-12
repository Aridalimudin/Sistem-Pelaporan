<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
</head>
<body>
<link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
    <!-- Template 3: Laporan Diverifikasi -->
    <div class="email-container">
        <div class="email-header diverifikasi">
            <span class="header-icon">🔍</span>
            <h2>LAPORAN DIVERIFIKASI</h2>
            <p>Laporan Anda telah diverifikasi dan siap diproses</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diverifikasi">Status: Laporan Diverifikasi</div>
            
            <h3>Assalamu'alaikum, Ananda yang Terhormat</h3>
            <p>Alhamdulillah, laporan Anda telah berhasil diverifikasi oleh tim admin kami. Laporan dinyatakan valid dan akan segera ditindaklanjuti.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Verifikasi:</strong> 2 Juni 2025, 18:30 WIB<br>
                <strong>📋 Jenis Laporan:</strong> [Kategori Laporan]<br>
                <strong>⏱️ Estimasi Penanganan:</strong> 2-3 hari kerja<br>
                <strong>👤 Verifikator:</strong> Bapak/Ibu Admin<br>
                <strong>🎯 Prioritas:</strong> Normal
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
                        <div class="step-circle current">3</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">02/06 18:30</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">4</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">-</div>
                    </div>
                </div>
            </div>
            
            <div class="alert-box info">
                <strong>🔍 Hasil Verifikasi:</strong><br>
                Laporan Anda telah memenuhi semua kriteria yang diperlukan. Tim terkait akan segera menangani masalah yang dilaporkan sesuai dengan prosedur yang berlaku.
            </div>
            
            <div class="next-steps">
                <h4>📋 Langkah Selanjutnya:</h4>
                <ul>
                    <li>Laporan akan ditindaklanjuti oleh pihak terkait</li>
                    <li>Proses penanganan dimulai dalam 1x24 jam</li>
                    <li>Anda akan mendapat update progress secara berkala</li>
                    <li>Jika ada pertanyaan tambahan, admin akan menghubungi</li>
                </ul>
            </div>
            
            <div class="highlight-box">
                <h4>💡 Terima Kasih atas Kepedulian Anda</h4>
                <p>Partisipasi aktif dari siswa seperti Anda sangat membantu menciptakan lingkungan sekolah yang lebih baik dan aman untuk semua.</p>
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