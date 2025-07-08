@extends('layouts.main')
@section('title', 'Track Laporan - MTS AR-RIYADL')
@section('content')

    <input type="hidden" id="isReporter" value="{{(bool)$reporter ? '1' : '0'}}">
    <div class="container text-center mt-5 {{ (bool)$reporter ? 'hidden' : '' }}" id="trackingPage">
        <div class="tracking-header">
            <h3 class="fw-bold">TRACK LAPORAN ANDA</h3>
            <p>Klik tombol di bawah untuk melacak status laporan Anda</p>
        </div>

        <div class="col-md-6 mx-auto">
            <button class="btn btn-primary btn-track mt-3 w-100" onclick="trackReportModule.openTrackingPopup()">
                <i class="fas fa-search me-2"></i>Track Laporan
            </button>
            
            <!-- Reminder Button untuk halaman tracking -->
            <div class="reminder-section mt-4">
                <p class="text-muted small mb-2">Belum punya kode laporan?</p>
                <button class="btn btn-outline-info btn-sm" onclick="trackReportModule.showReminderInfo()">
                    <i class="fas fa-bell me-2"></i>Cara Mendapatkan Kode
                </button>
            </div>
        </div>
    </div>

    <div id="trackingPopup" class="popup">
        <div class="popup-content shadow-lg rounded">
            <span class="close" onclick="trackReportModule.closePopup()">&times;</span>
            <div class="popup-header">
                <i class="fas fa-search-location popup-icon"></i>
                <h5 class="fw-bold">TRACK LAPORAN</h5>
                <p>Masukkan kode unik laporan Anda untuk melacak status</p>
            </div>

            <div class="popup-body">
                <form action="{{route('track')}}" id="form-track" method="GET">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-fingerprint"></i>
                        </span>
                        <input type="text" name="code" id="trackingCode" class="form-control shadow-sm"
                                placeholder="Contoh: HTC-1234" required>
                    </div>
                    <div id="errorMessage" class="text-danger mb-3" style="display: none;">
                        <small><i class="fas fa-exclamation-circle me-1"></i>Kode laporan harus diisi</small>
                    </div>
                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-search me-2"></i>Periksa Status
                        </button>
                    </div>
                    
                    <!-- Reminder info dalam popup -->
                    <div class="reminder-info-popup">
                        <hr class="my-3">
                        <div class="text-start">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Catatan:</strong> Kode tracking dikirim via email setelah laporan berhasil dikirim
                            </small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup Info Reminder -->
    <div id="reminderInfoPopup" class="popup">
        <div class="popup-content shadow-lg rounded" style="max-width: 500px;">
            <span class="close" onclick="trackReportModule.closeReminderInfo()">&times;</span>
            <div class="popup-header text-center">
                <i class="fas fa-info-circle popup-icon text-info"></i>
                <h5 class="fw-bold">CARA MENDAPATKAN KODE LAPORAN</h5>
            </div>
            <div class="popup-body text-start">
                <div class="reminder-steps">
                    <div class="reminder-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h6>Kirim Laporan</h6>
                            <p>Isi formulir laporan dengan lengkap dan kirim</p>
                        </div>
                    </div>
                    <div class="reminder-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h6>Cek Email</h6>
                            <p>Kode tracking akan dikirim ke email yang Anda daftarkan</p>
                        </div>
                    </div>
                    <div class="reminder-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h6>Track Laporan</h6>
                            <p>Gunakan kode tersebut untuk melacak status laporan</p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{route('reporter.create')}}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Buat Laporan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="errorPopup" class="popup">
        <div class="error-popup-content">
            <div class="error-icon-container">
                <div class="error-circle">
                    <i class="fas fa-exclamation"></i>
                </div>
            </div>
            <h5 class="error-title">LAPORAN TIDAK DITEMUKAN</h5>
            <p class="error-message">Kode atau laporan tidak tersedia. Silakan periksa kembali kode yang Anda masukkan.</p>
            <button class="error-btn" onclick="trackReportModule.closePopup()">
                Tutup
            </button>
        </div>
    </div>

    @if((bool)$reporter)
        <div class="container mt-4 mb-5" id="detailPage">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-lg detail-card">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">DETAIL LAPORAN</h4>
                                    <div class="kode-container mt-2">
                                        <span>Kode Laporan:</span>
                                        <span id="kode-laporan" class="badge bg-light text-primary">{{$reporter->code}}</span>
                                    </div>
                                </div>
                                
                                <!-- Reminder Button di header detail -->
                                <div class="reminder-actions">
                                    @if($reporter->status == 1)
                                        <button class="btn btn-outline-light btn-sm me-2" onclick="trackReportModule.showDocumentReminder()" title="Pengingat Dokumen">
                                            <i class="fas fa-bell"></i>
                                            <span class="d-none d-md-inline ms-1">Reminder</span>
                                        </button>
                                    @endif
                                    
                                    <button class="btn btn-outline-light btn-sm" onclick="trackReportModule.shareReport()" title="Bagikan Laporan">
                                        <i class="fas fa-share-alt"></i>
                                        <span class="d-none d-md-inline ms-1">Bagikan</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="tracking-wrapper">
                            <!-- Status reminder notification -->
                            @if($reporter->status == 1)
                                <div class="alert alert-info alert-dismissible fade show mt-3 mx-3" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bell me-2"></i>
                                        <div class="flex-grow-1">
                                            <strong>Pengingat:</strong> Laporan Anda memerlukan dokumen tambahan untuk melanjutkan proses verifikasi.
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="trackReportModule.openCompleteDocuments()">
                                            Lengkapi Sekarang
                                        </button>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="progress-timeline">
                                <div class="timeline-line">
                                    {{-- The width of this progress line will be controlled by JS --}}
                                    <div class="timeline-progress {{ $reporter->status == 5 ? 'rejected' : '' }}" style="width: 50%;"></div>
                                </div>

                                <div class="timeline-steps {{ $reporter->status == 5 ? 'rejected-timeline' : '' }}">
                                    @php
                                        $steps = [
                                            ['title' => 'Terkirim', 'icon' => 'fas fa-paper-plane'],
                                            ['title' => 'Diterima', 'icon' => 'fas fa-clipboard-check'],
                                            ['title' => 'Diverifikasi', 'icon' => 'fas fa-check-circle'],
                                            ['title' => 'Diproses', 'icon' => 'fas fa-cogs'],
                                            ['title' => 'Selesai', 'icon' => 'fas fa-flag-checkered'],
                                            ['title' => 'Ditolak', 'icon' => 'fas fa-times-circle'],
                                        ];
                                    @endphp
                                    @foreach($steps as $index => $step)
                                        <div class="timeline-step" data-step="{{ $index }}">
                                            <div class="step-circle">
                                                <i class="{{ $step['icon'] }}"></i>
                                            </div>
                                            <div class="step-info">
                                                <h6 class="step-title">{{ $step['title'] }}</h6>
                                                <span class="step-time"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- START: STATUS CARD DINAMIS - INI YANG AKAN DIKONTROL JS --}}
                            <div class="status-card {{ $reporter->status == 5 ? 'rejected' : '' }}">
                                <div class="status-header">
                                    <div class="status-icon">
                                        <i class="{{ $reporter->status == 5 ? 'fas fa-times-circle' : 'fas fa-check-circle' }}"></i>
                                    </div>
                                    <div class="status-title">
                                        <h5 id="status-title">Status: 
                                            @if($reporter->status == 5)
                                                Laporan Ditolak
                                            @else
                                                Laporan Terkirim
                                            @endif
                                        </h5>
                                        <span class="status-date" id="status-date">
                                            @if($reporter->status == 5)
                                                {{$reporter->updated_at->format('d M Y')}}
                                            @else
                                                {{$reporter->created_at->format('d M Y')}}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="status-description">
                                    <p id="status-description">
                                        @if($reporter->status == 5)
                                            Laporan Anda tidak dapat diproses lebih lanjut karena tidak memenuhi kriteria yang ditetapkan. Tim kami telah meninjau dokumen yang Anda berikan.
                                            <br><br>Silakan hubungi admin untuk informasi lebih lanjut atau ajukan laporan baru dengan informasi yang lebih lengkap.
                                        @else
                                            Laporan Anda telah berhasil masuk ke dalam sistem dan mendapatkan kode unik untuk tracking. Tim kami akan segera meninjau laporan yang Anda berikan.
                                        @endif
                                    </p>
                                </div>

                                {{-- REJECTION REASON: Tambahkan div ini di dalam status-card dinamis --}}
                                @if($reporter->status == 5)
                                    <div class="rejection-reason" id="rejection-reason-display">
                                        <div class="reason-label">Alasan Penolakan:</div>
                                        <div class="reason-text">
                                            {{ $reporter->rejection_reason ?? 'Dokumen yang dilampirkan tidak lengkap dan informasi yang diberikan kurang detail. Silakan melengkapi dokumen pendukung dan berikan informasi yang lebih spesifik.' }}
                                        </div>
                                    </div>
                                @else
                                    <div class="rejection-reason" id="rejection-reason-display" style="display: none;">
                                        {{-- Konten akan diisi oleh JS jika status berubah --}}
                                    </div>
                                @endif
                                
                                <div class="status-progress-bar">
                                    <div class="progress-bar-container">
                                        <div class="progress-bar-fill" id="progress-fill" style="width: {{ $reporter->status == 5 ? '100' : '20' }}%;"></div>
                                    </div>
                                    <span class="progress-text" id="progress-text">{{ $reporter->status == 5 ? '100% Ditolak' : '20% Selesai' }}</span>
                                </div>
                                
                                {{-- Tombol "Hubungi Admin" akan diinjeksi oleh JS --}}
                                <div id="action-button-container"></div>
                            </div>
                            {{-- END: STATUS CARD DINAMIS --}}

                            <div class="row mt-5">
                                <div class="col-12 mb-3">
                                    @if($reporter->urgency == 1)
                                        <div class="alert urgency-alert urgency-ringan" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Laporan Prioritas Rendah</strong> - Dapat ditangani sesuai jadwal rutin dan tidak memerlukan tindakan mendesak
                                        </div>
                                    @elseif($reporter->urgency == 2)
                                        <div class="alert urgency-alert urgency-sedang" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Laporan Prioritas Sedang</strong> - Memerlukan perhatian dalam waktu dekat dan penanganan terencana
                                        </div>
                                    @elseif($reporter->urgency == 3)
                                        <div class="alert urgency-alert urgency-tinggi" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Laporan Prioritas Tinggi</strong> - Memerlukan perhatian khusus dan penanganan segera
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="card info-card mb-4">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pelapor</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="40%"><strong>NIS Pelapor :</strong></td>
                                                    <td>{{$reporter->student?->nis}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email :</strong></td>
                                                    <td>{{$reporter->student?->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama :</strong></td>
                                                    <td>{{$reporter->student?->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tanggal Lapor : </strong></td>
                                                    <td>{{$reporter->created_at->format('d F Y')}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card info-card mb-4">
                                        <div class="card-header bg-warning text-dark">
                                            <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Informasi Kejadian</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="40%"><strong>Kategori Kasus :</strong></td>
                                                    <td>
                                                        <ul class="category-list" id="categoryList">
                                                            @php
                                                                $categoriesArray = isset($categories) ? explode(',', $categories) : [];
                                                            @endphp
                                                            @foreach($categoriesArray as $category)
                                                                @php
                                                                    $trimmed = trim($category);
                                                                    $iconClass = 'icon-default';
                                                                    if (stripos($trimmed, 'verbal') !== false) {
                                                                        $iconClass = 'icon-verbal';
                                                                    } elseif (stripos($trimmed, 'fisik') !== false) {
                                                                        $iconClass = 'icon-fisik';
                                                                    } elseif (stripos(str_replace('seksual', '', $trimmed), 'pelecehan') !== false) { // Menangani 'pelecehan' tanpa 'seksual'
                                                                        $iconClass = 'icon-seksual'; // Asumsi jika hanya 'pelecehan' tetap masuk seksual
                                                                    } elseif (stripos($trimmed, 'seksual') !== false) {
                                                                        $iconClass = 'icon-seksual';
                                                                    }
                                                                @endphp
                                                                <li class="category-item">
                                                                    <div class="category-icon {{ $iconClass }}"></div>
                                                                    <span class="category-text">{{ $trimmed }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pelaku :</strong></td>
                                                    <td>{{ $reporter->nama_pelaku ?? 'Nama Pelaku' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Korban :</strong></td>
                                                    <td>{{ $reporter->nama_korban ?? 'Nama Korban' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Saksi :</strong></td>
                                                    <td>{{ $reporter->nama_saksi ?? 'Nama Saksi' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Lokasi Kejadian :</strong></td>
                                                    <td>{{ $reporter->lokasi ?? 'Ruang Kelas XII-A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Waktu Kejadian :</strong></td>
                                                    <td>{{ ($reporter->tanggal ?? false) ? \Carbon\Carbon::parse($reporter->tanggal)->format('d M Y') . ', ' . \Carbon\Carbon::parse($reporter->jam)->format('H:i') . ' WIB' : '18 Feb 2023, 10:30 WIB' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card info-card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0"><i class="fas fa-align-left me-2"></i>Uraian Kejadian</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{$reporter->description}}</p>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 mb-4">
                                    <div class="card info-card h-100">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Tambahan</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($reporter->additional_info)
                                                <p>{{ $reporter->additional_info }}</p>
                                            @else
                                                <p class="text-muted">Belum ada informasi tambahan yang dilaporkan.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 mb-4">
                                    <div class="card info-card h-100">
                                        <div class="card-header bg-danger text-white">
                                            <h5 class="mb-0"><i class="fas fa-hands-helping me-2"></i>Tindakan yang Diharapkan</h5>
                                        </div>
                                        <div class="card-body">
                                            @if ($reporter->expected_action)
                                                <p>{{ $reporter->expected_action }}</p>
                                            @else
                                                <p class="text-muted">Pelapor belum menentukan tindakan yang diharapkan.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card info-card mb-4">
                                    <div class="card-header bg-dark text-white">
                                        <h5 class="mb-0"><i class="fas fa-photo-video me-2"></i>Bukti Foto & Video</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="masonry-container">
                                            @foreach($reporter->reporterFile as $key => $value)
                                                @php
                                                    $fileExtension = strtolower(pathinfo($value->file, PATHINFO_EXTENSION));
                                                    $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg']);
                                                    $fileType = $isVideo ? 'video' : 'image';
                                                @endphp

                                                <div class="masonry-item {{ $fileType }}" style="--item-index: {{ $key }}" onclick="trackReportModule.openLightbox({{ $key }})">
                                                    @if($isVideo)
                                                        <video class="masonry-video" preload="metadata" muted>
                                                            <source src="{{asset('storage/'. $value->file)}}" type="video/{{ $fileExtension }}">
                                                            Video tidak dapat dimuat
                                                        </video>
                                                        <div class="file-type-badge video">
                                                            <i class="fas fa-play me-1"></i>Video
                                                        </div>
                                                    @else
                                                        <img src="{{asset('storage/'. $value->file)}}" class="masonry-image" alt="Bukti Kejadian {{ $key + 1 }}">
                                                        <div class="file-type-badge image">
                                                            <i class="fas fa-image me-1"></i>Foto
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div id="lightbox" class="lightbox" onclick="trackReportModule.closeLightbox(event)">
                                    <div class="lightbox-content">
                                        <button class="lightbox-close" onclick="trackReportModule.closeLightbox(event)" title="Tutup">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button class="lightbox-nav lightbox-prev" onclick="trackReportModule.prevMedia()" title="Media Sebelumnya">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="lightbox-nav lightbox-next" onclick="trackReportModule.nextMedia()" title="Media Selanjutnya">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>

                                        <div id="lightbox-loading" class="lightbox-loading" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>

                                        <img id="lightbox-image" class="lightbox-image" src="" alt="" style="display: none;">

                                        <video id="lightbox-video" class="lightbox-video" controls preload="metadata" style="display: none;">
                                            <source id="lightbox-video-source" src="" type="">
                                            Browser Anda tidak mendukung pemutar video.
                                        </video>

                                        <div class="lightbox-counter">
                                            <span id="current-media">1</span> / <span id="total-media">{{ count($reporter->reporterFile) }}</span>
                                        </div>

                                        <div id="lightbox-video-controls" class="lightbox-video-controls" style="display: none;">
                                            <button class="video-control-btn" onclick="trackReportModule.toggleVideoPlayPause()" title="Play/Pause">
                                                <i id="play-pause-icon" class="fas fa-play"></i>
                                            </button>
                                            <button class="video-control-btn" onclick="trackReportModule.toggleVideoMute()" title="Mute/Unmute">
                                                <i id="mute-icon" class="fas fa-volume-up"></i>
                                            </button>
                                            <button class="video-control-btn" onclick="trackReportModule.toggleVideoFullscreen()" title="Fullscreen">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Floating Action Buttons -->
                                <div class="floating-actions">
                                    @if($reporter->status == 1)
                                        <button class="fab fab-primary" onclick="trackReportModule.showDocumentReminder()" title="Pengingat Dokumen">
                                            <i class="fas fa-bell"></i>
                                        </button>
                                    @endif
                                    
                                    <button class="fab fab-secondary" onclick="trackReportModule.shareReport()" title="Bagikan Laporan">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                    
                                    <button class="fab fab-info" onclick="trackReportModule.showHelpInfo()" title="Bantuan">
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>

                                <div class="text-center mt-4">
                                    <button class="btn btn-primary px-5" onclick="trackReportModule.backToTracking()">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Tracking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Popup untuk Document Reminder -->
    <div id="documentReminderPopup" class="popup">
        <div class="popup-content shadow-lg rounded" style="max-width: 600px;">
            <span class="close" onclick="trackReportModule.closeDocumentReminder()">&times;</span>
            <div class="popup-header text-center">
                <i class="fas fa-file-upload popup-icon text-warning"></i>
                <h5 class="fw-bold">PENGINGAT DOKUMEN</h5>
                <p>Dokumen tambahan diperlukan untuk melanjutkan proses verifikasi</p>
            </div>
            <div class="popup-body">
                <div class="reminder-document-list">
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div class="document-info">
                            <h6>Bukti Tambahan</h6>
                            <p class="text-muted">Foto atau video pendukung jika ada</p>
                        </div>
                        <div class="document-status">
                            <span class="badge bg-secondary">Opsional</span>
                        </div>
                    </div>
                    
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="document-info">
                            <h6>Keterangan Saksi</h6>
                            <p class="text-muted">Informasi kontak atau keterangan dari saksi</p>
                        </div>
                        <div class="document-status">
                            <span class="badge bg-info">Direkomendasikan</span>
                        </div>
                    </div>
                </div>
                
                <div class="reminder-deadline mt-4">
                    <div class="alert alert-warning">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Batas Waktu:</strong> Dokumen harus dilengkapi dalam 7 hari untuk melanjutkan proses
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button class="btn btn-success me-2" onclick="trackReportModule.openCompleteDocuments()">
                        <i class="fas fa-upload me-2"></i>Lengkapi Dokumen
                    </button>
                    <button class="btn btn-outline-secondary" onclick="trackReportModule.closeDocumentReminder()">
                        Nanti Saja
                    </button>
                </div>
            </div>
        </div>
    </div>

@include('track_laporan.complete')
@include('track_laporan.feedback')

@push('styles')
<link rel="stylesheet" href="{{asset('css/style_track.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
/* Reminder Styles */
.reminder-section {
    padding: 15px;
    background: rgba(23, 162, 184, 0.05);
    border-radius: 10px;
    border: 1px dashed #17a2b8;
}

.reminder-info-popup {
    background: rgba(0, 123, 255, 0.05);
    padding: 10px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.reminder-steps {
    margin: 20px 0;
}

.reminder-step {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #17a2b8;
}

.step-number {
    background: #17a2b8;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
}

.step-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
    color: #333;
}

.step-content p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

/* Reminder Actions in Header */
.reminder-actions {
    display: flex;
    align-items: center;
}

@media (max-width: 768px) {
    .reminder-actions {
        flex-direction: column;
        gap: 5px;
    }
    
    .reminder-actions .btn {
        font-size: 12px;
        padding: 5px 10px;
    }
}

/* Document Reminder Popup */
.reminder-document-list {
    margin: 20px 0;
}

.document-item {
    display: flex;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 15px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.document-item:hover {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.document-icon {
    width: 50px;
    height: 50px;
    background: #e9ecef;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: #6c757d;
    font-size: 20px;
}

.document-info {
    flex-grow: 1;
}

.document-info h6 {
    margin-bottom: 5px;
    font-weight: 600;
    color: #333;
}

.document-info p {
    margin: 0;
    font-size: 14px;
}

.document-status {
    margin-left: 15px;
}

.reminder-deadline .alert {
    border-left: 4px solid #ffc107;
    background: rgba(255, 193, 7, 0.1);
}

/* Floating Action Buttons */
.floating-actions {
    position: fixed;
    bottom: 30px;
    right: 30px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 1000;
}

.fab {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.fab:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.fab-primary {
    background: #007bff;
    color: white;
}

.fab-secondary {
    background: #6c757d;
    color: white;
}

.fab-info {
    background: #17a2b8;
    color: white;
}

.fab-primary:hover {
    background: #0056b3;
}

.fab-secondary:hover {
    background: #545b62;
}

.fab-info:hover {
    background: #117a8b;
}

@media (max-width: 768px) {
    .floating-actions {
        bottom: 20px;
        right: 20px;
        gap: 10px;
    }
    
    .fab {
        width: 48px;
        height: 48px;
        font-size: 18px;
    }
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .reminder-section {
        padding: 10px;
    }
    
    .reminder-step {
        flex-direction: column;
        text-align: center;
    }
    
    .step-number {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .document-item {
        flex-direction: column;
        text-align: center;
    }
    
    .document-icon {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .document-status {
        margin-left: 0;
        margin-top: 10px;
    }
}

/* Animation for reminder notification */
@keyframes reminderPulse {
    0% { background-color: rgba(0, 123, 255, 0.1); }
    50% { background-color: rgba(0, 123, 255, 0.2); }
    100% { background-color: rgba(0, 123, 255, 0.1); }
}

.alert-info {
    animation: reminderPulse 2s infinite;
}

/* Popup enhancements */
.popup-content {
    max-height: 90vh;
    overflow-y: auto;
}

.popup-header .popup-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

/* Status-specific reminder styles */
.status-card.reminder-needed {
    border-left: 4px solid #ffc107;
}

.status-card.reminder-needed .status-header {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
}
</style>
@endpush

@push('scripts')
<script>
    const trackReportModule = (function() {
        // Fungsi contactAdmin sudah ada, tidak perlu diubah
        function contactAdmin() {
            alert('Fitur hubungi admin akan segera tersedia. Silakan hubungi admin melalui email atau telepon yang tertera di website.');
        }

        let originalCurrentStep = 0;
        let isPreviewMode = false;
        let mediaFiles = [];
        let currentMediaIndex = 0;
        let isVideoPlaying = false;

        const trackingStepsData = {
            0: {
                title: "Terkirim",
                status: "Laporan Terkirim",
                description: "Laporan Anda telah berhasil masuk ke dalam sistem dan mendapatkan kode unik untuk tracking. Tim kami akan segera meninjau laporan yang Anda berikan.",
                icon: "fas fa-paper-plane",
                progress: 20,
                hasAction: false,
                date: "{{ @$reporter?->created_at->format('d M Y') ?? 'N/A' }}"
            },
            1: {
                title: "Diterima",
                status: "Laporan Diterima",
                description: "Laporan Anda telah diterima. Silakan lengkapi dokumen lainnya agar laporan Anda bisa melanjutkan ke proses verifikasi.",
                icon: "fas fa-clipboard-check",
                progress: 40,
                hasAction: true,
                actionText: "Lengkapi Dokumen",
                actionType: "complete_documents",
                date: "{{ @$reporter?->created_at->format('d M Y') ?? 'N/A' }}"
            },
            2: {
                title: "Diverifikasi",
                status: "Diverifikasi",
                description: "Laporan Anda telah melalui proses verifikasi dan dinyatakan valid. Semua informasi yang diperlukan telah lengkap dan laporan akan segera diteruskan ke tahap penanganan selanjutnya.",
                icon: "fas fa-check-circle",
                progress: 60,
                hasAction: false,
                date: "{{ @$reporter?->created_at->format('d M Y') ?? 'N/A' }}"
            },
            3: {
                title: "Diproses",
                status: "Sedang Diproses",
                description: "Laporan sedang dalam tahap penanganan oleh tim yang berwenang. Investigasi mendalam sedang dilakukan untuk menindaklanjuti kasus yang Anda laporkan.",
                icon: "fas fa-cogs",
                progress: 80,
                hasAction: false,
                date: "-"
            },
            4: {
                title: "Selesai",
                status: "Selesai Ditangani",
                description: "Laporan Anda telah selesai ditangani. Tindakan yang diperlukan telah dilakukan sesuai dengan kebijakan dan prosedur yang berlaku. Terima kasih atas partisipasi Anda.",
                icon: "fas fa-flag-checkered",
                progress: 100,
                hasAction: true,
                actionText: "Berikan Penilaian",
                actionType: "give_feedback",
                date: "{{ @$reporter?->updated_at->format('d M Y') ?? 'N/A' }}",
            },
            5: {
                title: "Ditolak",
                status: "Laporan Ditolak",
                description: `Laporan Anda tidak dapat diproses lebih lanjut karena tidak memenuhi kriteria yang ditetapkan. Tim kami telah meninjau dokumen yang Anda berikan.
                <br><br>Silakan hubungi admin untuk informasi lebih lanjut atau ajukan laporan baru dengan informasi yang lebih lengkap.`,
                rejection_reason: `{{ $reporter->rejection_reason ?? 'Dokumen yang dilampirkan tidak lengkap dan informasi yang diberikan kurang detail. Silakan melengkapi dokumen pendukung dan berikan informasi yang lebih spesifik.' }}`,
                icon: "fas fa-times-circle",
                progress: 100, 
                hasAction: true,
                actionText: "Hubungi Admin",
                actionType: "contact_admin",
                date: "{{ @$reporter?->updated_at->format('d M Y') ?? 'N/A' }}",
                isRejected: true
            },
        };

        // Existing functions...
        function openTrackingPopup() {
            document.getElementById('trackingPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('trackingPopup').style.display = 'none';
            document.getElementById('errorPopup').style.display = 'none';
        }

        function backToTracking() {
            document.getElementById('detailPage').classList.add('hidden');
            document.getElementById('trackingPage').classList.remove('hidden');
        }

        // New reminder functions
        function showReminderInfo() {
            document.getElementById('reminderInfoPopup').style.display = 'block';
        }

        function closeReminderInfo() {
            document.getElementById('reminderInfoPopup').style.display = 'none';
        }

        function showDocumentReminder() {
            document.getElementById('documentReminderPopup').style.display = 'block';
        }

        function closeDocumentReminder() {
            document.getElementById('documentReminderPopup').style.display = 'none';
        }

        function openCompleteDocuments() {
            // Close reminder popup if open
            closeDocumentReminder();
            
            // Open complete documents modal/page
            // This should trigger your existing complete documents functionality
            if (typeof window.openCompleteDocumentsModal === 'function') {
                window.openCompleteDocumentsModal();
            } else {
                // Fallback: redirect to complete documents page
                window.location.href = '/reporter/complete-documents/{{ @$reporter->id }}';
            }
        }

        function shareReport() {
            const reportCode = '{{ @$reporter->code }}';
            const reportUrl = window.location.href;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Laporan ' + reportCode,
                    text: 'Status laporan saya dengan kode: ' + reportCode,
                    url: reportUrl
                }).catch(console.error);
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(reportUrl).then(() => {
                    alert('Link laporan telah disalin ke clipboard!');
                }).catch(() => {
                    // Fallback for older browsers
                    const tempInput = document.createElement('input');
                    tempInput.value = reportUrl;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    alert('Link laporan telah disalin ke clipboard!');
                });
            }
        }

        function showHelpInfo() {
            const helpMessage = `
                BANTUAN TRACKING LAPORAN
                
                📋 Cara menggunakan sistem tracking:
                1. Masukkan kode laporan yang diterima via email
                2. Klik "Periksa Status" untuk melihat detail
                3. Pantau progress laporan melalui timeline
                
                ⚠️ Jika memerlukan bantuan:
                - Hubungi admin melalui tombol "Hubungi Admin"
                - Email: admin@mts-arriyadl.sch.id
                - Telepon: (021) 123-4567
                
                📝 Status laporan:
                • Terkirim: Laporan masuk sistem
                • Diterima: Menunggu dokumen tambahan
                • Diverifikasi: Dokumen lengkap dan valid
                • Diproses: Sedang ditangani tim
                • Selesai: Penanganan selesai
                • Ditolak: Tidak memenuhi kriteria
            `;
            
            alert(helpMessage);
        }

        // Initialize reminder system
        function initReminders() {
            // Check if user needs to complete documents
            const isReporter = document.getElementById('isReporter').value === '1';
            const currentStatus = {{ @$reporter->status ?? 0 }};
            
            if (isReporter && currentStatus === 1) {
                // Show periodic reminder for document completion
                setTimeout(() => {
                    if (confirm('Pengingat: Laporan Anda masih memerlukan dokumen tambahan. Apakah Anda ingin melengkapinya sekarang?')) {
                        showDocumentReminder();
                    }
                }, 30000); // Show after 30 seconds
            }
        }

        // Close popups when clicking outside
        window.addEventListener('click', function(event) {
            const popups = ['reminderInfoPopup', 'documentReminderPopup'];
            popups.forEach(popupId => {
                const popup = document.getElementById(popupId);
                if (event.target === popup) {
                    popup.style.display = 'none';
                }
            });
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initReminders();
        });

        // Return public functions
        return {
            contactAdmin,
            openTrackingPopup,
            closePopup,
            backToTracking,
            showReminderInfo,
            closeReminderInfo,
            showDocumentReminder,
            closeDocumentReminder,
            openCompleteDocuments,
            shareReport,
            showHelpInfo,
            // Add other existing functions here...
            openLightbox: function(index) {
                // Your existing lightbox function
            },
            closeLightbox: function(event) {
                // Your existing lightbox function
            },
            // ... other existing functions
        };
    })();
</script>
@endpush

@endsectionfas fa-file-alt"></i>
                        </div>
                        <div class="document-info">
                            <h6>Formulir Keterangan Tambahan</h6>
                            <p class="text-muted">Isi formulir dengan informasi detail kejadian</p>
                        </div>
                        <div class="document-status">
                            <span class="badge bg-warning">Diperlukan</span>
                        </div>
                    </div>
                    
                    <div class="document-item">
                        <div class="document-icon">
                            <i class="