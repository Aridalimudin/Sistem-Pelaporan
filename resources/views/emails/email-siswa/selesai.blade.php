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
        <div class="email-header selesai">
            <span class="header-icon">🎉</span>
            <h2>LAPORAN SELESAI DITANGANI</h2>
            <p>Alhamdulillah, laporan Anda telah berhasil diselesaikan</p>
        </div>

        <div class="email-body">
            <div class="status-badge selesai">Status: Selesai</div>

            <h3>Assalamu'alaikum, Ananda {{$report->student?->name}} yang Terhormat</h3>
            <p>Alhamdulillahi rabbil 'alamiin, kami dengan senang hati mengabarkan bahwa laporan yang Anda sampaikan telah berhasil diselesaikan dengan tuntas.</p>

            <div class="ticket-code">
                Kode Laporan: {{$report->code}}
            </div>

            <div class="info-box">
                <strong>📅 Tanggal Selesai:</strong> {{date('d M Y')}}, {{date('H:i')}}<br>
                <strong>📋 Jenis Laporan:</strong> {!! $report->formatted_urgency !!}<br>
                <strong>⏱️ Total Waktu Penanganan:</strong> 3 hari kerja<br>
                <strong>👤 Penanggung Jawab:</strong> {{Auth::user()->name}}<br> 
                <strong>✅ Status Akhir:</strong> Selesai dengan Sukses
            </div>

            <div class="progress-tracker">
                <h4>🔄 Progress Laporan:</h4>
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-active progress-100"></div>
                    </div>
                    @foreach($report->reporterHistory as $key => $history)
                        <div class="progress-step">
                            <div class="step-circle active">{{$key + 1}}</div>
                            <div class="step-label">{!! $history->formatted_status !!}</div>
                            <div class="step-date">{{$history->created_at->format('d/m H:i')}}</div>
                        </div>
                    @endforeach
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

            ---

            <div class="rating-prompt-box" style="background-color: #e0f2f7; border: 1px solid #b3e5fc; padding: 20px; margin-top: 30px; border-radius: 8px; text-align: center;">
                <h4>✨ Berikan Penilaian Anda!</h4>
                <p>Masukan Anda sangat penting bagi kami. Mohon berikan **rating kepuasan** Anda terhadap proses penanganan dan penyelesaian laporan ini.</p>
                <p style="font-style: italic; color: #555;">Kunjungi halaman status laporan Anda untuk mengisi penilaian.</p>
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-track" style="background-color: #007bff; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; margin-top: 15px;">➡️ Beri Rating Sekarang</a>
            </div>

            ---

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
                <a href="{{route('track', ['code' => $report->code])}}" class="btn-track">📋 Lihat Laporan Lengkap</a>
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