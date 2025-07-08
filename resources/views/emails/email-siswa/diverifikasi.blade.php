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
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .email-header.terkirim {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        .email-header.diterima {
            background: linear-gradient(135deg, #4caf50, #45a049);
        }

        .email-header.diverifikasi {
            background: linear-gradient(135deg, #2196f3, #1976d2);
        }

        .email-header.diproses {
            background: linear-gradient(135deg, #ff9800, #f57c00);
        }

        .email-header.selesai {
            background: linear-gradient(135deg, #28a745, #20754a);
        }

        .email-header.ditolak {
            background: linear-gradient(135deg, #dc3545, #c82333);
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
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.terkirim {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 2px solid #17a2b8;
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
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }

        .status-badge.ditolak {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .alert-box.success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-box.info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .alert-box.warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        .alert-box.danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
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
            height: 3px;
            background: #e0e0e0;
            z-index: 1;
            border-radius: 2px;
        }

        .progress-line-active {
            height: 100%;
            background: linear-gradient(90deg, #4caf50, #2196f3);
            border-radius: 2px;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            background: white;
            padding: 5px;
        }

        .step-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 16px;
            font-weight: bold;
            border: 3px solid;
        }

        .step-circle.active {
            background: #4caf50;
            color: white;
            border-color: #4caf50;
        }

        .step-circle.current {
            background: #ff9800;
            color: white;
            border-color: #ff9800;
        }

        .step-circle.inactive {
            background: white;
            color: #999;
            border-color: #e0e0e0;
        }

        .step-label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
            color: #333;
        }

        .step-date {
            font-size: 10px;
            color: #666;
        }

        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #3498db;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
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
        }

        .highlight-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            text-align: center;
        }

        .next-steps {
            background: #e8f4fd;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .next-steps h4 {
            color: #004085;
            margin-bottom: 15px;
        }

        .next-steps ul {
            margin-left: 20px;
        }

        .next-steps li {
            margin-bottom: 8px;
            color: #004085;
        }

        .rejection-reason {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .rejection-reason h4 {
            color: #721c24;
            margin-bottom: 15px;
        }

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

        /* Template Specific Progress Widths */
        .progress-25 {
            width: 25%;
        }
        .progress-50 {
            width: 50%;
        }
        .progress-75 {
            width: 75%;
        }
        .progress-100 {
            width: 100%;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-body {
                padding: 20px;
            }

            .progress-steps {
                flex-wrap: wrap;
                justify-content: center;
            }

            .progress-step {
                margin: 10px 5px;
                flex: 0 1 auto;
            }

            .progress-line {
                display: none;
            }

            .step-circle {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
        }

    </style>
</head>
<body>
    <!-- Template 3: Laporan Diverifikasi -->
    <div class="email-container">
        <div class="email-header diverifikasi">
            <span class="header-icon">🔍</span>
            <h2>LAPORAN DIVERIFIKASI</h2>
            <p>Laporan Anda telah diverifikasi dan siap diproses</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diverifikasi">Status: Laporan Diverifikasi</div>
            
            <h3>Assalamu'alaikum, {{$report->student?->name}} yang Terhormat</h3>
            <p>Alhamdulillah, laporan Anda telah berhasil diverifikasi oleh tim admin kami. Laporan dinyatakan valid dan akan segera ditindaklanjuti.</p>
            
            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Verifikasi:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                @if($report->urgency == 1)
                <strong>⏱️ Estimasi Penanganan:</strong> 2-3 hari kerja<br>
                @elseif($report->urgency == 2)
                <strong>⏱️ Estimasi Penanganan:</strong> 2-3 hari kerja<br>
                @elseif($report->urgency == 3)
                <strong>⏱️ Estimasi Penanganan:</strong> 2-3 hari kerja<br>
                @endif
                <strong>👤 Verifikator:</strong> {{Auth::user()->name}}<br>
                {{-- <strong>🎯 Prioritas:</strong> Normal --}}
            </div>
            
            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-75"></div>
                    </div>
                    @foreach($report->reporterHistory as $key => $history)
                        <div class="progress-step">
                            <div class="step-circle active">{{$key + 1}}</div>
                            <div class="step-label">{!! $history->formatted_status !!}</div>
                            <div class="step-date">{{$history->created_at->format('d M Y H:i')}}</div>
                        </div>
                    @endforeach
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
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-track">🔍 Lacak Status Laporan</a>
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