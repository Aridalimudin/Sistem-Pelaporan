<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
    <link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
</head>
<body>

    <!-- Template 4: Laporan Diproses -->
    <div class="email-container">
        <div class="email-header diproses">
            <span class="header-icon">⚙️</span>
            <h2>LAPORAN SEDANG DIPROSES</h2>
            <p>Tim kami sedang menangani laporan Anda</p>
        </div>
        
        <div class="email-body">
            <div class="status-badge diproses">Status: Sedang Diproses</div>
            
            <h3>Assalamu'alaikum, Ananda {{$report->student?->name}} yang Terhormat</h3>
            <p>Laporan Anda sedang dalam tahap penanganan aktif. Tim terkait telah memulai proses investigasi dan tindak lanjut sesuai dengan prosedur yang berlaku.</p>
            
            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>
            
            <div class="info-box">
                <strong>📅 Tanggal Verifikasi:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                @if($report->urgency == 1)
                <strong>⏱️ Estimasi Penanganan:</strong> 2-8 hari kerja<br>
                @elseif($report->urgency == 2)
                <strong>⏱️ Estimasi Penanganan:</strong> 2-6 hari kerja<br>
                @elseif($report->urgency == 3)
                <strong>⏱️ Estimasi Penanganan:</strong> 2-4 hari kerja<br>
                @endif
                <strong>👤 Verifikator:</strong> {{Auth::user()->name}}<br>
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