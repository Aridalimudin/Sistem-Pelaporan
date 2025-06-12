<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .email-header {
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .email-header.diterima {
            background: linear-gradient(135deg, #4CAF50, #45a049);
        }

        .email-header.diverifikasi {
            background: linear-gradient(135deg, #2196F3, #1976D2);
        }

        .email-header.diproses {
            background: linear-gradient(135deg, #FF9800, #F57C00);
        }

        .email-header.selesai {
            background: linear-gradient(135deg, #8BC34A, #689F38);
        }

        .email-header.ditolak {
            background: linear-gradient(135deg, #f44336, #d32f2f);
        }

        .header-icon {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }

        .email-body {
            padding: 30px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .status-badge.diterima {
            background-color: #e8f5e8;
            color: #2e7d32;
            border: 2px solid #4caf50;
        }

        .status-badge.diverifikasi {
            background-color: #e3f2fd;
            color: #1565c0;
            border: 2px solid #2196f3;
        }

        .status-badge.diproses {
            background-color: #fff3e0;
            color: #ef6c00;
            border: 2px solid #ff9800;
        }

        .status-badge.selesai {
            background-color: #f1f8e9;
            color: #558b2f;
            border: 2px solid #8bc34a;
        }

        .status-badge.ditolak {
            background-color: #ffebee;
            color: #c62828;
            border: 2px solid #f44336;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .ticket-code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .progress-tracker {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin: 20px 0;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #e0e0e0;
            z-index: 1;
        }

        .progress-line-active {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #2196F3);
            transition: width 0.3s ease;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            background: white;
            padding: 5px;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .step-circle.active {
            background: #4CAF50;
            color: white;
        }

        .step-circle.inactive {
            background: #e0e0e0;
            color: #999;
        }

        .step-label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .step-date {
            font-size: 10px;
            color: #666;
        }

        .email-footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }

        .footer-info {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .contact-info {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .btn-track {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin-top: 15px;
            transition: transform 0.2s ease;
        }

        .btn-track:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ddd, transparent);
            margin: 25px 0;
        }

        .email-selector {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .selector-btn {
            display: block;
            width: 100%;
            margin: 5px 0;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s ease;
        }

        .selector-btn:hover {
            transform: translateY(-1px);
        }

        .selector-btn.diterima { background: #4CAF50; color: white; }
        .selector-btn.diverifikasi { background: #2196F3; color: white; }
        .selector-btn.diproses { background: #FF9800; color: white; }
        .selector-btn.selesai { background: #8BC34A; color: white; }
        .selector-btn.ditolak { background: #f44336; color: white; }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .email-body {
                padding: 20px;
            }
            
            .progress-steps {
                flex-wrap: wrap;
            }
            
            .progress-step {
                margin: 10px 5px;
            }
            
            .email-selector {
                position: relative;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    {{-- <!-- Email Selector -->
    <div class="email-selector">
        <h4 style="margin-bottom: 10px; font-size: 14px;">Pilih Template Email:</h4>
        <button class="selector-btn diterima" onclick="showEmail('diterima')">Laporan Diterima</button>
        <button class="selector-btn diverifikasi" onclick="showEmail('diverifikasi')">Laporan Diverifikasi</button>
        <button class="selector-btn diproses" onclick="showEmail('diproses')">Laporan Diproses</button>
        <button class="selector-btn selesai" onclick="showEmail('selesai')">Laporan Selesai</button>
        <button class="selector-btn ditolak" onclick="showEmail('ditolak')">Laporan Ditolak</button>
    </div> --}}

    <!-- Template 1: Laporan Diterima -->
    <div class="email-container" id="email-diterima">
        <div class="email-header diterima">
            <span class="header-icon">✓</span>
            <h2>PEMBERITAHUAN LAPORAN BARU</h2>
            <p>Terima kasih telah melaporkan kejadian kepada kami</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diterima">Status: Laporan Baru Dibuat</div>
            
            <h3>Halo, Guru BK yang Terhormat</h3>
            <p>Laporan yang Anda kirimkan telah berhasil diterima oleh sistem kami dan akan segera diproses oleh tim yang berwenang.</p>
            
            <div class="ticket-code">
                Kode Laporan: {{$reporter->code}}
            </div>
            
            <div class="info-box">
                <strong>👤 Nama Siswa:</strong> {{$reporter->student?->name}}
                <strong>📅 Tanggal Dibuat:</strong> {{$reporter->created_at->format('d M Y, H:i')}} WIB<br>
                {{-- <strong>⏱️ Estimasi Verifikasi:</strong> 1-2 hari kerja<br> --}}
            </div>
            
            {{-- <div class="progress-tracker">
                <h4>Progress Laporan Anda:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active" style="width: 25%"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">1</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">22 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">2</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">Pending</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">3</div>
                        <div class="step-label">Proses</div>
                        <div class="step-date">Pending</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">4</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">Pending</div>
                    </div>
                </div>
            </div>
             --}}
            {{-- <div class="divider"></div> --}}
            
            {{-- <p><strong>Langkah Selanjutnya:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>Tim kami akan melakukan verifikasi data dalam 1-2 hari kerja</li>
                <li>Anda akan mendapat notifikasi email untuk setiap perubahan status</li>
                <li>Simpan kode laporan Anda untuk melacak progress</li>
            </ul>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">🔍 Lacak Status Laporan</a>
            </div> --}}
        </div>
        
        <div class="email-footer">
            <div class="footer-info">
                <strong>MTS AR-RIYADL - Sistem Pelaporan Kejadian</strong>
            </div>
            <div class="contact-info">
                <p><strong>Butuh Bantuan?</strong></p>
                <p>📧 Email: admin@mts-arriyadl.sch.id</p>
                <p>📞 Telepon: (0274) 123-4567</p>
                <p>🕐 Jam Operasional: Senin-Jumat, 07:00-15:00 WIB</p>
            </div>
        </div>
    </div>

    {{-- <!-- Template 2: Laporan Diverifikasi -->
    <div class="email-container" id="email-diverifikasi" style="display: none;">
        <div class="email-header diverifikasi">
            <span class="header-icon">🔍</span>
            <h2>LAPORAN ANDA TELAH DIVERIFIKASI</h2>
            <p>Laporan Anda telah melewati tahap verifikasi</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diverifikasi">Status: Laporan Diverifikasi</div>
            
            <h3>Update Status Laporan Anda</h3>
            <p>Setelah melakukan verifikasi terhadap laporan yang Anda kirimkan, tim kami telah memvalidasi bahwa laporan Anda memenuhi kriteria untuk diproses lebih lanjut.</p>
            
            <div class="ticket-code">
                Kode Laporan: HTC-2024-001
            </div>
            
            <div class="info-box">
                <strong>✅ Status Verifikasi:</strong> VALID - Data lengkap dan dapat diproses<br>
                <strong>📅 Tanggal Verifikasi:</strong> 23 Mei 2025, 10:15 WIB<br>
                <strong>⏱️ Estimasi Pemrosesan:</strong> 3-5 hari kerja<br>
                <strong>👤 Petugas Verifikator:</strong> Ahmad Fauzi, S.Pd
            </div>
            
            <div class="progress-tracker">
                <h4>Progress Laporan Anda:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active" style="width: 50%"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">22 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">23 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">3</div>
                        <div class="step-label">Proses</div>
                        <div class="step-date">Pending</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">4</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">Pending</div>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <p><strong>Hasil Verifikasi:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px; color: #2e7d32;">
                <li>✅ Data pelapor lengkap dan valid</li>
                <li>✅ Uraian kejadian jelas dan detail</li>
                <li>✅ Bukti pendukung memadai</li>
                <li>✅ Laporan sesuai dengan kewenangan sekolah</li>
            </ul>
            
            <p style="margin-top: 15px;"><strong>Langkah Selanjutnya:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>Laporan akan diteruskan ke unit terkait untuk ditindaklanjuti</li>
                <li>Tim penanganan akan melakukan investigasi dan pemrosesan</li>
                <li>Anda akan mendapat update progress secara berkala</li>
            </ul>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">🔍 Lacak Status Laporan</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-info">
                <strong>MTS AR-RIYADL - Sistem Pelaporan Kejadian</strong>
            </div>
            <div class="contact-info">
                <p><strong>Tim Verifikasi</strong></p>
                <p>📧 Email: verifikasi@mts-arriyadl.sch.id</p>
                <p>📞 Telepon: (0274) 123-4567 ext. 102</p>
            </div>
        </div>
    </div>

    <!-- Template 3: Laporan Diproses -->
    <div class="email-container" id="email-diproses" style="display: none;">
        <div class="email-header diproses">
            <span class="header-icon">⚙️</span>
            <h2>LAPORAN ANDA SEDANG DIPROSES</h2>
            <p>Tim penanganan sedang menindaklanjuti laporan Anda</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diproses">Status: Sedang Diproses</div>
            
            <h3>Laporan Anda Dalam Penanganan</h3>
            <p>Tim penanganan telah mulai memproses laporan Anda. Kami sedang melakukan investigasi dan koordinasi dengan pihak-pihak terkait untuk menyelesaikan masalah yang Anda laporkan.</p>
            
            <div class="ticket-code">
                Kode Laporan: HTC-2024-001
            </div>
            
            <div class="info-box">
                <strong>🔄 Status Pemrosesan:</strong> AKTIF - Sedang dalam penanganan<br>
                <strong>📅 Mulai Diproses:</strong> 24 Mei 2025, 08:00 WIB<br>
                <strong>⏱️ Estimasi Penyelesaian:</strong> 26 Mei 2025<br>
                <strong>👤 Penanggung Jawab:</strong> Drs. Bambang Suryono, M.Pd<br>
                <strong>🏢 Unit Penanganan:</strong> Bagian Kesiswaan & BK
            </div>
            
            <div class="progress-tracker">
                <h4>Progress Laporan Anda:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active" style="width: 75%"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">22 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">23 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">⚙️</div>
                        <div class="step-label">Proses</div>
                        <div class="step-date">24 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">4</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">Pending</div>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <p><strong>Tindakan yang Sedang Dilakukan:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>🔍 Investigasi mendalam terhadap kejadian yang dilaporkan</li>
                <li>👥 Koordinasi dengan pihak-pihak yang terlibat</li>
                <li>📋 Dokumentasi dan pengumpulan bukti tambahan</li>
                <li>⚖️ Penyusunan rencana tindakan penyelesaian</li>
            </ul>
            
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p><strong>⏰ Catatan Penting:</strong></p>
                <p>Proses penanganan memerlukan waktu untuk memastikan solusi yang tepat dan menyeluruh. Tim kami berkomitmen untuk menyelesaikan laporan Anda sebaik mungkin.</p>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">🔍 Lacak Status Laporan</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-info">
                <strong>MTS AR-RIYADL - Tim Penanganan Laporan</strong>
            </div>
            <div class="contact-info">
                <p><strong>Kontak Tim Penanganan</strong></p>
                <p>📧 Email: penanganan@mts-arriyadl.sch.id</p>
                <p>📞 Telepon: (0274) 123-4567 ext. 103</p>
                <p>💬 WhatsApp: 0812-3456-7890 (Jam Kerja)</p>
            </div>
        </div>
    </div>

    <!-- Template 4: Laporan Selesai -->
    <div class="email-container" id="email-selesai" style="display: none;">
        <div class="email-header selesai">
            <span class="header-icon">🎉</span>
            <h2>LAPORAN ANDA TELAH SELESAI DITANGANI</h2>
            <p>Terima kasih atas laporan Anda, masalah telah diselesaikan</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge selesai">Status: Laporan Selesai</div>
            
            <h3>Laporan Anda Telah Tuntas Diselesaikan</h3>
            <p>Dengan bangga kami informasikan bahwa laporan yang Anda kirimkan telah berhasil diselesaikan oleh tim penanganan. Solusi telah diimplementasikan dan masalah telah diatasi dengan baik.</p>
            
            <div class="ticket-code">
                Kode Laporan: HTC-2024-001
            </div>
            
            <div class="info-box">
                <strong>✅ Status Penyelesaian:</strong> SELESAI - Masalah telah tertangani<br>
                <strong>📅 Tanggal Selesai:</strong> 26 Mei 2025, 15:30 WIB<br>
                <strong>⏱️ Total Waktu Penanganan:</strong> 4 hari kerja<br>
                <strong>👤 Penyelesai:</strong> Drs. Bambang Suryono, M.Pd<br>
                <strong>📋 Hasil:</strong> Masalah terselesaikan dengan baik
            </div>
            
            <div class="progress-tracker">
                <h4>Progress Laporan Anda:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active" style="width: 100%"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">22 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Verifikasi</div>
                        <div class="step-date">23 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Proses</div>
                        <div class="step-date">24 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">🎉</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">26 Mei 2025</div>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #155724; margin-bottom: 10px;">📋 Ringkasan Penyelesaian:</h4>
                <p style="color: #155724;">
                    Berdasarkan investigasi yang telah dilakukan, tim penanganan telah mengambil langkah-langkah yang diperlukan untuk menyelesaikan masalah yang Anda laporkan. Semua pihak yang terlibat telah diberikan pembinaan yang sesuai, dan langkah preventif telah diimplementasikan untuk mencegah kejadian serupa di masa mendatang.
                </p>
                
                <p style="color: #155724; margin-top: 15px;"><strong>Tindakan yang Telah Dilakukan:</strong></p>
                <ul style="margin-left: 20px; color: #155724;">
                    <li>✅ Investigasi menyeluruh terhadap kejadian</li>
                    <li>✅ Mediasi dan pembinaan kepada pihak terkait</li>
                    <li>✅ Implementasi langkah pencegahan</li>
                    <li>✅ Monitoring dan evaluasi hasil</li>
                </ul>
            </div>
            
            <p><strong>Komitmen Kami:</strong></p>
            <p>MTS AR-RIYADL berkomitmen untuk terus menciptakan lingkungan yang aman dan kondusif bagi seluruh warga sekolah. Laporan Anda sangat berharga untuk meningkatkan kualitas lingkungan pendidikan kami.</p>
            
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p><strong>💡 Saran untuk Ke Depan:</strong></p>
                <p>Jika Anda mengalami atau menyaksikan kejadian serupa di masa mendatang, jangan ragu untuk melaporkannya melalui sistem pelaporan kami. Keamanan dan kenyamanan Anda adalah prioritas utama kami.</p>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track">📄 Lihat Detail Laporan</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-info">
                <strong>Terima kasih atas kepercayaan Anda kepada MTS AR-RIYADL</strong>
            </div>
            <div class="contact-info">
                <p><strong>Tetap Terhubung dengan Kami</strong></p>
                <p>📧 Email: admin@mts-arriyadl.sch.id</p>
                <p>📞 Telepon: (0274) 123-4567</p>
                <p>🌐 Website: www.mts-arriyadl.sch.id</p>
                <p style="margin-top: 10px; font-size: 12px; color: #999;">
                    Sistem Pelaporan Kejadian - MTS AR-RIYADL<br>
                    Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Template 5: Laporan Ditolak -->
    <div class="email-container" id="email-ditolak" style="display: none;">
        <div class="email-header ditolak">
            <span class="header-icon">❌</span>
            <h2>LAPORAN ANDA TIDAK DAPAT DIPROSES</h2>
            <p>Mohon maaf, laporan Anda tidak memenuhi kriteria untuk diproses</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge ditolak">Status: Laporan Ditolak</div>
            
            <h3>Informasi Penolakan Laporan</h3>
            <p>Setelah melakukan review terhadap laporan yang Anda kirimkan, dengan menyesal kami informasikan bahwa laporan tersebut tidak dapat diproses lebih lanjut karena beberapa alasan teknis dan prosedural.</p>
            
            <div class="ticket-code">
                Kode Laporan: HTC-2024-001
            </div>
            
            <div class="info-box">
                <strong>❌ Status Penolakan:</strong> DITOLAK - Tidak memenuhi kriteria<br>
                <strong>📅 Tanggal Penolakan:</strong> 23 Mei 2025, 11:45 WIB<br>
                <strong>👤 Reviewer:</strong> Ahmad Fauzi, S.Pd<br>
                <strong>📋 Kategori:</strong> Tidak Sesuai Kewenangan
            </div>
            
            <div class="progress-tracker">
                <h4>Progress Laporan Anda:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active" style="width: 50%; background: #f44336;"></div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active">✓</div>
                        <div class="step-label">Diterima</div>
                        <div class="step-date">22 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle active" style="background: #f44336;">❌</div>
                        <div class="step-label">Ditolak</div>
                        <div class="step-date">23 Mei 2025</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">-</div>
                        <div class="step-label">Proses</div>
                        <div class="step-date">Tidak Dilanjutkan</div>
                    </div>
                    <div class="progress-step">
                        <div class="step-circle inactive">-</div>
                        <div class="step-label">Selesai</div>
                        <div class="step-date">Tidak Dilanjutkan</div>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #721c24; margin-bottom: 10px;">📋 Alasan Penolakan:</h4>
                <ul style="margin-left: 20px; color: #721c24;">
                    <li>❌ Kejadian yang dilaporkan berada di luar kewenangan sekolah</li>
                    <li>❌ Data yang disampaikan tidak lengkap atau tidak valid</li>
                    <li>❌ Laporan tidak sesuai dengan format yang ditentukan</li>
                    <li>❌ Bukti pendukung tidak memadai untuk verifikasi</li>
                </ul>
                
                <p style="color: #721c24; margin-top: 15px;"><strong>Catatan Reviewer:</strong></p>
                <p style="color: #721c24; font-style: italic;">
                    "Berdasarkan review yang telah dilakukan, kejadian yang dilaporkan tampaknya terjadi di luar lingkungan sekolah dan melibatkan pihak yang tidak memiliki keterkaitan langsung dengan MTS AR-RIYADL. Untuk kasus seperti ini, kami menyarankan untuk melaporkan kepada pihak yang berwenang seperti RT/RW setempat atau kepolisian."
                </p>
            </div>
            
            <p><strong>Langkah yang Dapat Anda Lakukan:</strong></p>
            <ul style="margin-left: 20px; margin-top: 10px;">
                <li>🔄 <strong>Perbaiki dan kirim ulang:</strong> Jika Anda yakin laporan sesuai kriteria, silakan perbaiki data dan kirim kembali</li>
                <li>📞 <strong>Konsultasi:</strong> Hubungi tim kami untuk klarifikasi lebih lanjut</li>
                <li>🏢 <strong>Alternatif pelaporan:</strong> Laporkan ke instansi yang lebih sesuai dengan jenis kejadian</li>
                <li>📝 <strong>Panduan:</strong> Pelajari panduan pelaporan untuk submission yang lebih baik</li>
            </ul>
            
            <div style="background: #d1ecf1; border: 1px solid #bee5eb; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="color: #0c5460;"><strong>💡 Tips untuk Laporan Selanjutnya:</strong></p>
                <ul style="margin-left: 20px; color: #0c5460; margin-top: 10px;">
                    <li>Pastikan kejadian terjadi di lingkungan sekolah atau melibatkan warga sekolah</li>
                    <li>Lengkapi data dengan informasi yang akurat dan terverifikasi</li>
                    <li>Sertakan bukti pendukung yang jelas dan relevan</li>
                    <li>Gunakan bahasa yang sopan dan objektif dalam menjelaskan kejadian</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin-top: 25px;">
                <a href="#" class="btn-track" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">📝 Buat Laporan Baru</a>
                <a href="#" class="btn-track" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%); margin-left: 10px;">📞 Hubungi Kami</a>
            </div>
        </div>
        
        <div class="email-footer">
            <div class="footer-info">
                <strong>MTS AR-RIYADL - Sistem Pelaporan Kejadian</strong>
            </div>
            <div class="contact-info">
                <p><strong>Butuh Bantuan atau Klarifikasi?</strong></p>
                <p>📧 Email: admin@mts-arriyadl.sch.id</p>
                <p>📞 Telepon: (0274) 123-4567</p>
                <p>💬 WhatsApp: 0812-3456-7890</p>
                <p>🕐 Jam Operasional: Senin-Jumat, 07:00-15:00 WIB</p>
                <p style="margin-top: 15px; font-size: 12px; color: #999;">
                    Jangan putus asa! Kami tetap siap membantu Anda menemukan solusi terbaik.<br>
                    Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                </p>
            </div>
        </div>
    </div> --}}
</body>
</html>