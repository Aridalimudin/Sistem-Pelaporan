<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan Terkirim - MTS AR-RIYADL</title>
    <link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
</head>
<body>
    <div class="email-container">
        <div class="email-header terkirim">
            <span class="header-icon">✉️</span>
            <h2>LAPORAN BERHASIL TERKIRIM</h2>
            <p>Terima kasih, laporan Anda telah berhasil dikirim.</p>
        </div>

        <div class="email-body">
            <div class="status-badge terkirim">Status: Laporan Terkirim</div>

            <h3>Assalamu'alaikum, Ananda {{$report->student?->name}} yang Terhormat</h3>
            <p>Terima kasih telah menggunakan Sistem Pelaporan Digital MTS AR-RIYADL. Laporan yang Anda kirimkan telah berhasil masuk ke dalam sistem kami.</p>

            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>

            <div class="info-box">
                <strong>📅 Tanggal Terkirim:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
            </div>

            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-33"></div> 
                    </div>
                    @foreach($report->reporterHistory as $key => $history)
                        <div class="progress-step">
                            <div class="step-circle {{$loop->first ? 'current' : ''}}">{{$key + 1}}</div> 
                            <div class="step-label">{!! $history->formatted_status !!}</div>
                            <div class="step-date">{{$history->created_at->format('d M Y H:i')}}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="alert-box info" style="background-color: #e2f0d9; border-left: 5px solid #28a745; color: #1a5e2a;"> {{-- Ubah warna sesuai "terkirim" --}}
                <strong>✅ Laporan Anda Berhasil Diterima Sistem!</strong><br>
                Sistem kami telah mencatat laporan Anda dengan nomor tiket di atas. Simpan kode ini untuk melacak progress laporan.
            </div>

            <div class="next-steps">
                <h4>📋 Apa yang Terjadi Selanjutnya?</h4>
                <ul>
                    <li>Pihak kami akan mereview laporan dalam 2-4 jam kerja</li>
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
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-track">➡️ Lacak Status Laporan Anda</a>
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