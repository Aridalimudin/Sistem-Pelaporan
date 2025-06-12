<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
</head>
<body>
<link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
    <!-- Template 6: Laporan Ditolak -->
    <div class="email-container">
        <div class="email-header ditolak">
            <span class="header-icon">❌</span>
            <h2>LAPORAN TIDAK DAPAT DIPROSES</h2>
            <p>Maaf, laporan Anda tidak memenuhi kriteria untuk diproses</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge ditolak">Status: Ditolak</div>
            
            <h3>Assalamu'alaikum, Ananda yang Terhormat</h3>
            <p>Terima kasih atas laporan yang telah Anda kirimkan. Setelah dilakukan verifikasi, kami menyampaikan bahwa laporan ini tidak dapat diproses lebih lanjut dengan alasan tertentu.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Ditolak:</strong> 3 Juni 2025, 10:00 WIB<br>
                <strong>📋 Jenis Laporan:</strong> [Kategori Laporan]<br>
                <strong>👤 Reviewer:</strong> Tim Admin Verifikasi<br>
                <strong>❌ Status Akhir:</strong> Ditolak untuk Diproses
            </div>
            
            <div class="alert-box danger">
                <strong>❌ Laporan Tidak Dapat Diproses</strong><br>
                Mohon maaf, setelah dilakukan review menyeluruh, laporan ini tidak memenuhi kriteria untuk dapat ditindaklanjuti.
            </div>
            
            <div class="rejection-reason">
                <h4>📋 Alasan Penolakan:</h4>
                <ul style="margin-top: 10px; margin-left: 20px; color: #721c24;">
                    <li><strong>Informasi Tidak Lengkap:</strong> Data dan informasi yang disampaikan kurang detail atau tidak mencukupi untuk dilakukan investigasi</li>
                    <li><strong>Bukti Kurang Memadai:</strong> Dokumentasi atau bukti pendukung yang diperlukan tidak tersedia atau tidak valid</li>
                    <li><strong>Di Luar Kewenangan Sekolah:</strong> Masalah yang dilaporkan berada di luar lingkup kewenangan sekolah</li>
                    <li><strong>Duplikasi Laporan:</strong> Kasus serupa sudah pernah dilaporkan dan sedang/telah ditangani</li>
                </ul>
            </div>
            
            <div class="solution-box">
                <h4>💡 Saran dan Solusi:</h4>
                <ul style="margin-top: 10px; margin-left: 20px; color: #856404;">
                    <li><strong>Lengkapi Informasi:</strong> Jika memungkinkan, kumpulkan informasi dan bukti yang lebih lengkap</li>
                    <li><strong>Konsultasi Langsung:</strong> Hubungi guru BK atau wali kelas untuk berdiskusi mengenai masalah ini</li>
                    <li><strong>Laporan Ulang:</strong> Anda dapat mengirim laporan baru dengan informasi yang lebih lengkap</li>
                    <li><strong>Jalur Alternatif:</strong> Pertimbangkan untuk melaporkan melalui jalur lain yang lebih sesuai</li>
                </ul>
            </div>
            
            <div class="next-steps">
                <h4>📋 Langkah yang Dapat Dilakukan:</h4>
                <ul>
                    <li>Hubungi admin untuk klarifikasi lebih lanjut</li>
                    <li>Konsultasi dengan guru BK atau wali kelas</li>
                    <li>Siapkan informasi tambahan jika ingin melaporkan ulang</li>
                    <li>Gunakan jalur komunikasi langsung untuk masalah mendesak</li>
                </ul>
            </div>
            
            <div class="highlight-box">
                <h4>🤝 Tetap Terbuka untuk Komunikasi</h4>
                <p>Meskipun laporan ini tidak dapat diproses melalui sistem, kami tetap terbuka untuk komunikasi dan siap membantu melalui jalur lain yang lebih sesuai. Jangan ragu untuk menghubungi kami secara langsung.</p>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">📞 Hubungi Admin</a>
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