<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Email Laporan - MTS AR-RIYADL</title>
    <link rel="stylesheet" href="{{asset('css/emails_siswa.css')}}">
</head>
<body>
    <div class="email-container">
        <div class="email-header diterima">
            <span class="header-icon">✅</span>
            <h2>LAPORAN DITERIMA & MENUNGGU KELENGKAPAN DOKUMEN</h2>
            <p>Laporan Anda telah diterima dan saat ini berada dalam tahap verifikasi awal.</p>
        </div>

        <div class="email-body">
            <div class="status-badge diterima">Status: Menunggu Kelengkapan Dokumen</div>

            <h3>Assalamu'alaikum, Ananda {{$report->student?->name}} yang Terhormat</h3>
            <p>Alhamdulillah, laporan yang Anda kirimkan telah diterima oleh tim admin MTS AR-RIYADL dan sedang dalam proses verifikasi awal. Untuk dapat melanjutkan ke proses investigasi dan tindak lanjut, **kami membutuhkan beberapa informasi tambahan dari Anda.**</p>

            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>

            <div class="info-box">
                <strong>📅 Tanggal Diterima:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>👤 Admin Penerima:</strong>{{Auth::user()->name}}
            </div>

            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-100"></div>
                    </div>
                    @foreach($report->reporterHistory as $key => $history)
                        <div class="progress-step">
                            <div class="step-circle {{$loop->last ? 'current' : 'active'}}">{{$key + 1}}</div>
                            <div class="step-label">{!! $history->formatted_status !!}</div>
                            <div class="step-date">{{$history->created_at->format('d M Y H:i')}}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="alert-box info" style="background-color: #d1ecf1; border-left: 5px solid #007bff; color: #0c5460;">
                <strong>⚠️ Perhatian: Verifikasi Laporan Membutuhkan Data Tambahan!</strong><br>
                Laporan Anda kini berada pada tahap **Verifikasi Lanjutan**. Untuk dapat melanjutkan ke proses investigasi dan tindak lanjut, mohon segera lengkapi informasi yang diperlukan, seperti:
                <ul>
                    <li>**Waktu dan Lokasi Kejadian:** Detail jam dan lokasi spesifik insiden.</li>
                    <li>**Identitas Pihak Terlibat:** Informasi lebih lanjut mengenai pelaku dan/atau korban.</li>
                    <li>**Sanksi yang Diharapkan:** Jika Anda memiliki saran atau ekspektasi terkait sanksi.</li>
                </ul>
                Silakan klik tombol "Lengkapi Dokumen" di bawah atau lacak status laporan Anda untuk mengisi informasi ini.
            </div>

            <div class="next-steps">
                <h4>📋 Langkah Selanjutnya:</h4>
                <ul>
                    <li>**Segera Lengkapi Dokumen:** Kunjungi halaman pelacakan laporan Anda untuk mengisi data-data yang dibutuhkan (jam, lokasi, pelaku/korban, dll.).</li>
                    <li>Setelah dokumen lengkap, tim admin akan segera memproses laporan Anda ke tahap investigasi.</li>
                    <li>Anda akan mendapat notifikasi setiap perubahan status laporan.</li>
                    <li>Pastikan nomor telepon/email Anda aktif dan dapat dihubungi untuk komunikasi lebih lanjut.</li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-track">➡️ Lengkapi Dokumen Laporan</a>
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