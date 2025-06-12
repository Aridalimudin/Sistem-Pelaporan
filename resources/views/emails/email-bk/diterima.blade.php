<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email untuk Guru BK - MTS AR-RIYADL</title>
    <style>
        /* CSS untuk Template Email Guru BK */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        /* Header Styles */
        .email-header {
            padding: 25px;
            text-align: center;
            color: white;
            position: relative;
        }

        .email-header.new-report {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .email-header.in-verification {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .email-header.in-process {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
        }

        .email-header.completed {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }

        .email-header.rejected {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .header-icon {
            font-size: 48px;
            display: block;
            margin-bottom: 15px;
        }

        .email-header h2 {
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .email-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        /* Body Styles */
        .email-body {
            padding: 30px 25px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .status-badge.new-report {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .status-badge.in-verification {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .status-badge.in-process {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .status-badge.completed {
            background-color: #e8f5e8;
            color: #2e7d32;
        }

        .status-badge.rejected {
            background-color: #ffebee;
            color: #c62828;
        }

        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .ticket-code {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            margin: 20px 0;
            letter-spacing: 1px;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .info-box strong {
            color: #495057;
        }

        .student-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .report-summary {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid;
        }

        .alert-box.info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }

        .alert-box.warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .alert-box.success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .alert-box.danger {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .action-items {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .action-items h4 {
            color: #495057;
            margin-bottom: 15px;
        }

        .action-items ul {
            list-style: none;
            padding: 0;
        }

        .action-items li {
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .action-items li:last-child {
            border-bottom: none;
        }

        .priority-indicator {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
        }

        .priority-high {
            background-color: #ffebee;
            color: #c62828;
        }

        .priority-medium {
            background-color: #fff3e0;
            color: #ef6c00;
        }

        .priority-low {
            background-color: #e8f5e8;
            color: #2e7d32;
        }

        .btn-action {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .timeline {
            margin: 20px 0;
        }

        .timeline-item {
            padding: 15px 0;
            border-left: 2px solid #dee2e6;
            padding-left: 20px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 20px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #007bff;
        }

        .timeline-item.completed::before {
            background: #28a745;
        }

        .timeline-date {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        .timeline-content {
            margin-top: 5px;
        }

        /* Footer Styles */
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .footer-logo {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .contact-info {
            margin-top: 15px;
            font-size: 13px;
            opacity: 0.9;
        }

        .contact-info p {
            margin: 5px 0;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .email-body {
                padding: 20px 15px;
            }
            
            .header-icon {
                font-size: 36px;
            }
            
            .email-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Template 1: Laporan Baru Masuk -->
    <div class="email-container">
        <div class="email-header new-report">
            <span class="header-icon">📨</span>
            <h2>LAPORAN BARU MASUK</h2>
            <p>Ada laporan baru yang memerlukan verifikasi Anda</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge new-report">Status: Laporan Baru</div>
            
            <div class="greeting">Assalamu'alaikum, Bapak/Ibu Guru BK</div>
            <p>Terdapat laporan baru dari siswa yang memerlukan verifikasi dan tindak lanjut dari Anda.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="student-info">
                <strong>👤 Informasi Pelapor:</strong><br>
                <strong>Nama:</strong> Ahmad Fauzi<br>
                <strong>Kelas:</strong> VIII-A<br>
                <strong>NIS:</strong> 20231001<br>
                <strong>Tanggal Lapor:</strong> 2 Juni 2025, 14:30 WIB
            </div>
            
            <div class="report-summary">
                <strong>📋 Ringkasan Laporan:</strong><br>
                <strong>Kategori:</strong> Bullying/Perundungan<br>
                <strong>Tingkat Urgensi:</strong> Tinggi <span class="priority-indicator priority-high">HIGH</span><br>
                <strong>Lokasi Kejadian:</strong> Ruang Kelas VIII-B<br>
                <strong>Deskripsi Singkat:</strong> Siswa melaporkan adanya tindakan bullying berulang dari teman sekelas...
            </div>
            
            <div class="alert-box info">
                <strong>ℹ️ Perhatian!</strong><br>
                Laporan ini memiliki tingkat urgensi tinggi dan memerlukan verifikasi segera dalam 2 jam ke depan.
            </div>
            
            <div class="action-items">
                <h4>📋 Tindakan yang Diperlukan:</h4>
                <ul>
                    <li>✅ Verifikasi kelengkapan laporan</li>
                    <li>📞 Hubungi pelapor untuk konfirmasi</li>
                    <li>🔍 Lakukan investigasi awal</li>
                    <li>📝 Tentukan langkah penanganan</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-action">📖 Buka Detail Laporan</a>
                <a href="#" class="btn-action btn-secondary">📞 Hubungi Pelapor</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Portal Guru BK</p>
            <div class="contact-info">
                <p><strong>Bantuan Teknis:</strong></p>
                <p>📧 support@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
                <p>🕐 Senin-Jumat: 07:00-15:00 WIB</p>
            </div>
        </div>
    </div>

    <!-- Template 2: Sedang Verifikasi -->
    <div class="email-container">
        <div class="email-header in-verification">
            <span class="header-icon">🔍</span>
            <h2>LAPORAN DALAM VERIFIKASI</h2>
            <p>Update proses verifikasi laporan</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge in-verification">Status: Dalam Verifikasi</div>
            
            <div class="greeting">Assalamu'alaikum, Bapak/Ibu Guru BK</div>
            <p>Berikut adalah update terkait proses verifikasi laporan yang sedang Anda tangani.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Waktu Mulai Verifikasi:</strong> 2 Juni 2025, 16:00 WIB<br>
                <strong>⏱️ Durasi Verifikasi:</strong> 2 jam 30 menit<br>
                <strong>🔍 Status Saat Ini:</strong> Menunggu konfirmasi saksi<br>
                <strong>📋 Kemajuan:</strong> 60% selesai
            </div>
            
            <div class="timeline">
                <h4>📈 Timeline Verifikasi:</h4>
                <div class="timeline-item completed">
                    <div class="timeline-date">16:00 WIB</div>
                    <div class="timeline-content"><strong>Verifikasi dimulai</strong> - Membaca detail laporan</div>
                </div>
                <div class="timeline-item completed">
                    <div class="timeline-date">16:30 WIB</div>
                    <div class="timeline-content"><strong>Kontak pelapor</strong> - Konfirmasi via telepon</div>
                </div>
                <div class="timeline-item completed">
                    <div class="timeline-date">17:15 WIB</div>
                    <div class="timeline-content"><strong>Investigasi lokasi</strong> - Kunjungan ke lokasi kejadian</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">Sedang berlangsung</div>
                    <div class="timeline-content"><strong>Menunggu konfirmasi saksi</strong> - 2 dari 3 saksi telah dikonfirmasi</div>
                </div>
            </div>
            
            <div class="alert-box warning">
                <strong>⚠️ Catatan Penting!</strong><br>
                Masih menunggu konfirmasi dari 1 saksi lagi. Estimasi penyelesaian verifikasi: 1 jam lagi.
            </div>
            
            <div class="action-items">
                <h4>📋 Langkah Selanjutnya:</h4>
                <ul>
                    <li>📞 Menghubungi saksi ketiga (Siti Aminah - VIII-C)</li>
                    <li>📝 Menyusun laporan verifikasi</li>
                    <li>🎯 Menentukan rencana penanganan</li>
                    <li>📧 Mengirim notifikasi ke pelapor</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-action">📋 Update Progress</a>
                <a href="#" class="btn-action btn-secondary">👥 Hubungi Saksi</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Portal Guru BK</p>
            <div class="contact-info">
                <p><strong>Bantuan Teknis:</strong></p>
                <p>📧 support@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
            </div>
        </div>
    </div>

    <!-- Template 3: Sedang Diproses -->
    <div class="email-container">
        <div class="email-header in-process">
            <span class="header-icon">⚙️</span>
            <h2>LAPORAN SEDANG DIPROSES</h2>
            <p>Penanganan kasus sedang berlangsung</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge in-process">Status: Dalam Proses</div>
            
            <div class="greeting">Assalamu'alaikum, Bapak/Ibu Guru BK</div>
            <p>Laporan telah memasuki tahap penanganan aktif. Berikut adalah update progress penanganan.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Mulai Penanganan:</strong> 2 Juni 2025, 19:00 WIB<br>
                <strong>🎯 Jenis Penanganan:</strong> Mediasi dan Konseling<br>
                <strong>👥 Pihak Terlibat:</strong> 3 siswa + 2 wali murid<br>
                <strong>⏱️ Estimasi Selesai:</strong> 3 Juni 2025, 15:00 WIB
            </div>
            
            <div class="report-summary">
                <strong>📋 Rencana Penanganan:</strong><br>
                <strong>Sesi 1:</strong> Konseling individu dengan pelapor ✅<br>
                <strong>Sesi 2:</strong> Konseling dengan pelaku ✅<br>
                <strong>Sesi 3:</strong> Mediasi antara kedua pihak (Sedang berlangsung)<br>
                <strong>Sesi 4:</strong> Konseling kelompok (Dijadwalkan)<br>
                <strong>Sesi 5:</strong> Follow-up dengan wali murid (Dijadwalkan)
            </div>
            
            <div class="alert-box info">
                <strong>ℹ️ Progress Terkini!</strong><br>
                Sesi mediasi sedang berlangsung. Kedua pihak menunjukkan kerjasama yang baik dalam proses penyelesaian.
            </div>
            
            <div class="action-items">
                <h4>📋 Agenda Hari Ini:</h4>
                <ul>
                    <li>🕐 10:00 - Sesi mediasi lanjutan (30 menit tersisa)</li>
                    <li>🕐 11:00 - Dokumentasi hasil mediasi</li>
                    <li>🕐 13:00 - Persiapan sesi konseling kelompok</li>
                    <li>🕐 14:00 - Koordinasi dengan wali kelas</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-action">📝 Catat Progress</a>
                <a href="#" class="btn-action btn-secondary">📞 Hubungi Wali Murid</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Portal Guru BK</p>
            <div class="contact-info">
                <p><strong>Bantuan Teknis:</strong></p>
                <p>📧 support@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
            </div>
        </div>
    </div>

    <!-- Template 4: Laporan Selesai -->
    <div class="email-container">
        <div class="email-header completed">
            <span class="header-icon">✅</span>
            <h2>LAPORAN SELESAI DITANGANI</h2>
            <p>Kasus telah berhasil diselesaikan</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge completed">Status: Selesai</div>
            
            <div class="greeting">Assalamu'alaikum, Bapak/Ibu Guru BK</div>
            <p>Alhamdulillah, laporan telah berhasil ditangani hingga selesai. Berikut adalah ringkasan penanganan.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Selesai:</strong> 3 Juni 2025, 15:30 WIB<br>
                <strong>⏱️ Total Waktu Penanganan:</strong> 1 hari 1 jam<br>
                <strong>🎯 Metode Penanganan:</strong> Mediasi & Konseling<br>
                <strong>📊 Tingkat Kepuasan:</strong> 95% (Semua pihak puas)
            </div>
            
            <div class="alert-box success">
                <strong>✅ Penanganan Berhasil!</strong><br>
                Kasus bullying telah diselesaikan dengan baik. Kedua pihak telah berdamai dan berkomitmen untuk menjaga hubungan yang harmonis.
            </div>
            
            <div class="report-summary">
                <strong>📋 Ringkasan Hasil:</strong><br>
                <strong>Kesepakatan:</strong> Pelaku meminta maaf secara resmi<br>
                <strong>Komitmen:</strong> Tidak mengulangi perbuatan serupa<br>
                <strong>Monitoring:</strong> Follow-up mingguan selama 1 bulan<br>
                <strong>Dokumentasi:</strong> Tersimpan dalam sistem BK<br>
                <strong>Pelaporan:</strong> Disampaikan ke Kepala Sekolah
            </div>
            
            <div class="action-items">
                <h4>📋 Langkah Follow-up:</h4>
                <ul>
                    <li>📝 Buat laporan lengkap untuk arsip</li>
                    <li>📞 Jadwalkan monitoring mingguan</li>
                    <li>👥 Koordinasi dengan wali kelas untuk observasi</li>
                    <li>📧 Kirim notifikasi penyelesaian ke semua pihak</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-action">📋 Buat Laporan Final</a>
                <a href="#" class="btn-action btn-secondary">📅 Jadwalkan Follow-up</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Portal Guru BK</p>
            <div class="contact-info">
                <p><strong>Bantuan Teknis:</strong></p>
                <p>📧 support@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
            </div>
        </div>
    </div>

    <!-- Template 5: Laporan Ditolak -->
    <div class="email-container">
        <div class="email-header rejected">
            <span class="header-icon">❌</span>
            <h2>LAPORAN DITOLAK</h2>
            <p>Laporan tidak dapat diproses lebih lanjut</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge rejected">Status: Ditolak</div>
            
            <div class="greeting">Assalamu'alaikum, Bapak/Ibu Guru BK</div>
            <p>Setelah melalui proses verifikasi, laporan ini tidak dapat diproses lebih lanjut karena alasan tertentu.</p>
            
            <div class="ticket-code">
                Kode Laporan: #RPT-2025-0001
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Penolakan:</strong> 2 Juni 2025, 17:45 WIB<br>
                <strong>👤 Diputuskan oleh:</strong> Ibu Siti Nurjanah, S.Pd<br>
                <strong>⏱️ Waktu Verifikasi:</strong> 3 jam 15 menit<br>
                <strong>📋 Status Akhir:</strong> Tidak Valid
            </div>
            
            <div class="alert-box danger">
                <strong>❌ Alasan Penolakan:</strong><br>
                Setelah dilakukan verifikasi menyeluruh, ditemukan bahwa laporan ini tidak memiliki dasar yang kuat. Tidak ada bukti atau saksi yang mendukung klaim yang dilaporkan.
            </div>
            
            <div class="report-summary">
                <strong>📋 Detail Verifikasi:</strong><br>
                <strong>Saksi yang Dihubungi:</strong> 4 orang<br>
                <strong>Bukti yang Dicari:</strong> Tidak ditemukan<br>
                <strong>Konfirmasi Pihak Terkait:</strong> Menyangkal kejadian<br>
                <strong>Investigasi Lokasi:</strong> Tidak ada tanda-tanda<br>
                <strong>Kesimpulan:</strong> Laporan tidak berdasar
            </div>
            
            <div class="action-items">
                <h4>📋 Tindak Lanjut yang Dilakukan:</h4>
                <ul>
                    <li>📞 Menghubungi pelapor untuk penjelasan</li>
                    <li>💬 Memberikan konseling tentang pentingnya laporan yang akurat</li>
                    <li>📝 Mendokumentasikan hasil verifikasi</li>
                    <li>🔒 Menutup kasus secara resmi</li>
                </ul>
            </div>
            
            <div class="alert-box warning">
                <strong>⚠️ Catatan Penting!</strong><br>
                Pelapor telah diberikan pemahaman tentang konsekuensi laporan palsu dan pentingnya memberikan informasi yang akurat di masa mendatang.
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-action btn-danger">📋 Dokumentasi Final</a>
                <a href="#" class="btn-action btn-secondary">📞 Konseling Pelapor</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-logo">🏫 MTS AR-RIYADL</div>
            <p>Sistem Pelaporan Digital - Portal Guru BK</p>
            <div class="contact-info">
                <p><strong>Bantuan Teknis:</strong></p>
                <p>📧 support@mts-arriyadl.sch.id | 📞 (0274) 123-4567</p>
            </div>
        </div>
    </div>

</body>
</html>