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
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-search me-2"></i>Periksa Status
                            </button>
                        </div>
                    </form>
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
                            {{-- =================== PERUBAHAN DI SINI =================== --}}
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                {{-- Kosongkan sisi kiri agar judul bisa tetap di tengah --}}
                                <div class="header-left"></div>

                                {{-- Judul dan Kode Laporan (tetap di tengah) --}}
                                <div class="header-center text-center">
                                    <h4 class="mb-0">DETAIL LAPORAN</h4>
                                    <div class="kode-container">
                                        <span>Kode Laporan:</span>
                                        <span id="kode-laporan" class="badge bg-light text-primary">{{$reporter->code}}</span>
                                    </div>
                                </div>

                                <div class="header-right">
                                    <a href="#" class="btn-print" title="Cetak Laporan">
                                        <i class="fas fa-print"></i>
                                        <span class="btn-print-text">Cetak</span>
                                    </a>
                                </div>
                            </div>

                            <div class="tracking-wrapper">
                                <div class="progress-timeline">
                                    <div class="timeline-line">
                                        {{-- The width of this progress line will be controlled by JS --}}
                                        <div class="timeline-progress {{ $reporter->status == 4 ? 'rejected' : '' }}" style="width: 50%;"></div>
                                    </div>

                                    <div class="timeline-steps {{ $reporter->status == 4 ? 'rejected-timeline' : '' }}">
                                        @php
                                            $steps = [
                                                ['title' => 'Terkirim', 'icon' => 'fas fa-paper-plane', 'description' => 'Terkirim'],
                                                ['title' => 'Diverifikasi', 'icon' => 'fas fa-check-circle', 'description' => 'Approve'],
                                                ['title' => 'Diproses', 'icon' => 'fas fa-cogs', 'description' => 'Proses'],
                                                ['title' => 'Selesai', 'icon' => 'fas fa-flag-checkered', 'description' => 'Selesai'],
                                                ['title' => 'Ditolak', 'icon' => 'fas fa-times-circle', 'description' => 'Reject'],
                                            ];
                                        @endphp
                                        @foreach($steps as $index => $step)
                                            
                                            <div class="timeline-step" data-reject="{{ $step['description'] == $previousStatus?->description ?  $index : 0 }}" data-step="{{$index}}">
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
                                <div class="status-card {{ $reporter->status == 4 ? 'rejected' : '' }}">
                                    <div class="status-header">
                                        <div class="status-icon">
                                            <i class="{{ $reporter->status == 4 ? 'fas fa-times-circle' : 'fas fa-check-circle' }}"></i>
                                        </div>
                                        <div class="status-title">
                                            <h5 id="status-title">Status: 
                                                @if($reporter->status == 4)
                                                    Laporan Ditolak
                                                @else
                                                    Laporan Terkirim
                                                @endif
                                            </h5>
                                            <span class="status-date" id="status-date">
                                                @if($reporter->status == 4)
                                                    {{$reporter->updated_at->format('d M Y')}}
                                                @else
                                                    {{$reporter->created_at->format('d M Y')}}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="status-description">
                                        <p id="status-description">
                                            @if($reporter->status == 4)
                                                Laporan Anda tidak dapat diproses lebih lanjut karena tidak memenuhi kriteria yang ditetapkan. Tim kami telah meninjau dokumen yang Anda berikan.
                                                <br><br>Silakan hubungi admin untuk informasi lebih lanjut atau ajukan laporan baru dengan informasi yang lebih lengkap.
                                            @else
                                                Laporan Anda telah berhasil masuk ke dalam sistem dan mendapatkan kode unik untuk tracking. Tim kami akan segera meninjau laporan yang Anda berikan.
                                            @endif
                                        </p>
                                    </div>

                                    {{-- REJECTION REASON: Tambahkan div ini di dalam status-card dinamis --}}
                                    @if($reporter->status == 4)
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
                                            <div class="progress-bar-fill" id="progress-fill" style="width: {{ $reporter->status == 4 ? '100' : '20' }}%;"></div>
                                        </div>
                                        <span class="progress-text" id="progress-text">{{ $reporter->status == 4 ? '100% Ditolak' : '20% Selesai' }}</span>
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
                                                        <td>{{$reporter->student?->nis ?? 'Data tidak tersedia'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email :</strong></td>
                                                        <td>{{$reporter->student?->email ?? 'Data tidak tersedia'}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Nama :</strong></td>
                                                        <td>{{$reporter->student?->name ?? 'Data tidak tersedia'}}</td>
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
                                                                @forelse($categoriesArray as $category)
                                                                    @php
                                                                        $trimmed = trim($category);
                                                                        $iconClass = 'icon-default';
                                                                        if (stripos($trimmed, 'verbal') !== false) {
                                                                            $iconClass = 'icon-verbal';
                                                                        } elseif (stripos($trimmed, 'fisik') !== false) {
                                                                            $iconClass = 'icon-fisik';
                                                                        } elseif (stripos(str_replace('seksual', '', $trimmed), 'pelecehan') !== false) {
                                                                            $iconClass = 'icon-seksual';
                                                                        } elseif (stripos($trimmed, 'seksual') !== false) {
                                                                            $iconClass = 'icon-seksual';
                                                                        }
                                                                    @endphp
                                                                    <li class="category-item">
                                                                        <div class="category-icon {{ $iconClass }}"></div>
                                                                        <span class="category-text">{{ $trimmed }}</span>
                                                                    </li>
                                                                @empty
                                                                    <li class="text-muted">Tidak ada kategori yang dilaporkan.</li>
                                                                @endforelse
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Pelaku :</strong></td>
                                                        <td>{{ $perpetratorsNames ?? 'Pelapor belum mengisi data.' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Korban :</strong></td>
                                                        <td>{{ $victimNames ?? 'Pelapor belum mengisi data.' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Saksi :</strong></td>
                                                        <td>{{ $witnesNames ?? 'Pelapor belum mengisi data.' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Lokasi Kejadian :</strong></td>
                                                        <td>{{ $reporter?->reporterDetail?->location ?? 'Pelapor belum mengisi data.' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Waktu Kejadian :</strong></td>
                                                        <td>{{ $reporter?->reporterDetail?->formatted_report_date ?? 'Pelapor belum mengisi data.'}}</td>
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
                                            <p>{{$reporter->description ?? 'Pelapor belum mengisi uraian kejadian.'}}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6 mb-4">
                                        <div class="card info-card h-100">
                                            <div class="card-header bg-success text-white">
                                                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Tambahan</h5>
                                            </div>
                                            <div class="card-body">
                                                @if ($reporter?->reporterDetail?->description)
                                                    <p>{{ $reporter?->reporterDetail->description }}</p>
                                                @else
                                                    <p class="text-muted">Pelapor belum mengisi informasi tambahan.</p>
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
                                                @if ($reporter?->reporterDetail?->notes_by_student)
                                                    <p>{{ $reporter?->reporterDetail->notes_by_student }}</p>
                                                @else
                                                    <p class="text-muted">Pelapor belum menentukan tindakan yang diharapkan.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card info-card mb-4">
                                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0"><i class="fas fa-photo-video me-2"></i>Bukti Foto & Video</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="masonry-container" id="masonryContainer">
                                                @forelse($reporter->reporterFile as $key => $value)
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
                                                @empty
                                                    <p class="text-muted">Pelapor tidak melampirkan foto atau bukti.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <div id="lightbox" class="lightbox" onclick="trackReportModule.closeLightbox(event)">
                                        <div class="lightbox-content">
                                            <button class="lightbox-close" onclick="trackReportModule.closeLightboxExplicit()" title="Tutup">
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

            @if($reporter->status != 3)
            {{-- START: Tombol dan Modal Reminder (Dipindahkan ke dalam blok @if) --}}
            <div id="reminderButton" class="floating-reminder-btn" onclick="showReminderConfirmation()">
                <div class="btn-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="btn-text">
                    <span>Reminder</span>
                    <small>Laporan</small>
                </div>
                <div class="btn-pulse"></div>
            </div>

            <div id="reminderModal" class="reminder-modal">
                <div class="reminder-modal-content">
                    <div class="reminder-modal-header">
                        <div class="reminder-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4>Kirim Permintaan Tindak Lanjut</h4>
                        <p>Apakah Anda ingin mengirim permintaan agar laporan ini segera diproses oleh pihak sekolah?</p>
                    </div>
                    <div class="reminder-modal-body">
                        <div class="reminder-info">
                            <div class="info-item">
                                <span class="info-label">Kode Laporan:</span>
                                <span class="info-value">{{$reporter->code}}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status Saat Ini:</span>
                                <span class="info-value">
                                    @switch($reporter->status)
                                        @case(0)
                                            Laporan Terkirim
                                            @break
                                        @case(1)
                                            Verifikasi Laporan
                                            @break
                                        @case(2)
                                            Laporan Diproses
                                            @break
                                        @case(3)
                                            Laporan Selesai
                                            @break
                                        @case(4)
                                            Laporan Ditolak
                                            @break
                                        @default
                                            Laporan Tidak Diketahui
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="reminder-modal-footer">
                        <button class="btn-cancel" onclick="closeReminderModal()">Batal</button>
                        <button class="btn-confirm" onclick="sendReminder()">Kirim Reminder</button>
                    </div>
                </div>
            </div>
            @endif

            <div id="uploadEvidenceModal" class="popup">
                <div class="popup-content shadow-lg rounded">
                    <span class="close" onclick="trackReportModule.closeUploadEvidenceModal()">&times;</span>
                    <div class="popup-header">
                        <i class="fas fa-upload popup-icon"></i>
                        <h5 class="fw-bold">UNGGAH BUKTI TAMBAHAN</h5>
                        <p>Pilih file foto atau video yang ingin Anda tambahkan.</p>
                    </div>

                    <div class="popup-body">
                        <form id="uploadEvidenceForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="report_code" value="{{ $reporter->code }}">
                            <div class="mb-3">
                                <label for="evidenceFiles" class="form-label">Pilih File (Foto/Video):</label>
                                <input type="file" class="form-control" id="evidenceFiles" name="evidence_files[]" accept="image/*,video/*" multiple required>
                                <small class="form-text text-muted">Maksimal 5 file, ukuran maksimal 10MB per file. Format: JPG, PNG, MP4, MOV, WEBM.</small>
                            </div>
                            <div id="uploadErrorMessage" class="text-danger mb-3" style="display: none;">
                                <small><i class="fas fa-exclamation-circle me-1"></i>Pilih setidaknya satu file.</small>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>Unggah Bukti
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- END: Modal Unggah Bukti Tambahan --}}

        @endif

        @include('track_laporan.complete')
        @include('track_laporan.feedback')

        @push('styles')
        <link rel="stylesheet" href="{{asset('css/style_track.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                        date: "{{ @$terkirim?->created_at->format('d M Y') ?? '' }}"
                    },
                    1: {
                        title: "Verifikasi",
                        status: "Verifikasi Laporan",
                        description: "Laporan Anda masuk dalam tahap verifikasi. Silakan lengkapi dokumen lainnya agar laporan Anda dapat segera diproses lebih lanjut oleh tim kami.",
                        icon: "fas fa-clipboard-check",
                        progress: 40,
                        hasAction: "{{ $feedback }}",
                        actionText: "Lengkapi Dokumen",
                        actionType: "complete_documents",
                        date: "{{ @$verifikasi?->created_at->format('d M Y') ?? '' }}"
                    },
                    2: {
                        title: "Proses",
                        status: "Laporan Sedang Diproses",
                        description: "Laporan sedang dalam tahap penanganan oleh tim yang berwenang. Investigasi mendalam sedang dilakukan untuk menindaklanjuti kasus yang Anda laporkan.",
                        icon: "fas fa-cogs",
                        progress: 80,
                        hasAction: false,
                        date: "{{ @$proses?->created_at->format('d M Y') ?? '' }}"
                    },
                    3: {
                        title: "Selesai",
                        status: "Laporan Selesai Ditangani",
                        description: "Laporan Anda telah selesai ditangani. Tindakan yang diperlukan telah dilakukan sesuai dengan kebijakan dan prosedur yang berlaku.<br><br>Untuk melihat detail penyelesaian laporan dan memberikan penilaian penyelesaian, silakan klik tombol \"Berikan Penilaian\" di bawah ini. Terima kasih atas partisipasi Anda.",
                        icon: "fas fa-flag-checkered",
                        progress: 100,
                        actionText: "Berikan Penilaian",
                        actionType: "give_feedback",
                        hasAction: "{{ @$reporter->rating ? 'false' : 'true' }}",
                        date: "{{ @$done?->created_at->format('d M Y') ?? '' }}",
                    },
                    4: {
                        title: "Ditolak",
                        status: "Laporan Ditolak",
                        description: `Laporan Anda tidak dapat diproses lebih lanjut karena tidak memenuhi kriteria yang ditetapkan. Tim kami telah meninjau dokumen yang Anda berikan.
                        <br><br>Silakan hubungi admin untuk informasi lebih lanjut atau ajukan laporan baru dengan informasi yang lebih lengkap.`,
                        rejection_reason: `{{ @$reporter->rejection_reason ?? 'Dokumen yang dilampirkan tidak lengkap dan informasi yang diberikan kurang detail. Silakan melengkapi dokumen pendukung dan berikan informasi yang lebih spesifik.' }}`,
                        icon: "fas fa-times-circle",
                        progress: 100, 
                        hasAction: true,
                        actionText: "Hubungi Admin",
                        actionType: "contact_admin",
                        date: "{{ @$reject?->created_at->format('d M Y') ?? '' }}",
                        isRejected: true
                    },
                };

                function init() {
                    const isReporterVal = document.getElementById('isReporter').value;
                    const reporterExists = isReporterVal === '1';

                    if (!reporterExists) {
                        trackReportModule.openTrackingPopup();
                        document.getElementById('detailPage').classList.add('hidden');
                        document.getElementById('trackingPage').classList.remove('hidden');
                    } else {
                        document.getElementById('detailPage').classList.remove('hidden');
                        document.getElementById('trackingPage').classList.add('hidden');
                        trackReportModule.initializeElegantTracking({{ intval($reporter->status ?? 0) }});
                        // Initialize media files here as well, since it's on detail page load
                        initializeMediaFiles();
                    }

                    document.addEventListener('keydown', handleKeyboardNavigation);

                    const lightboxVideo = document.getElementById('lightbox-video');
                    if (lightboxVideo) {
                        lightboxVideo.addEventListener('play', () => { isVideoPlaying = true; updatePlayPauseIcon(); });
                        lightboxVideo.addEventListener('pause', () => { isVideoPlaying = false; updatePlayPauseIcon(); });
                        lightboxVideo.addEventListener('ended', () => { isVideoPlaying = false; updatePlayPauseIcon(); setTimeout(trackReportModule.nextMedia, 1000); });
                    }

                    document.querySelectorAll('.masonry-video').forEach(video => {
                        if (!video.poster) {
                            video.addEventListener('loadeddata', function() { this.currentTime = 1; });
                            video.addEventListener('seeked', function() {
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                canvas.width = this.videoWidth;
                                canvas.height = this.videoHeight;
                                ctx.drawImage(this, 0, 0);
                                this.poster = canvas.toDataURL();
                            });
                        }
                    });

                    const categoryListElement = document.getElementById('categoryList');
                    if (categoryListElement && reporterExists) {
                        const categoriesString = @json($categories ?? '');
                        generateCategoryList(categoriesString);
                    }

                    // Event listener untuk form unggah bukti
                    const uploadEvidenceForm = document.getElementById('uploadEvidenceForm');
                    if (uploadEvidenceForm) {
                        uploadEvidenceForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            uploadEvidence();
                        });
                    }
                }

                function initializeMediaFiles() {
                    const masonryItems = document.querySelectorAll('.masonry-item');
                    mediaFiles = [];
                    masonryItems.forEach((item, index) => {
                        const isVideo = item.classList.contains('video');
                        let mediaSrc = '';
                        let mediaType = '';

                        if (isVideo) {
                            const video = item.querySelector('video source');
                            mediaSrc = video ? video.src : '';
                            mediaType = video ? video.type : 'video/' + item.querySelector('video source').src.split('.').pop();
                        } else {
                            const img = item.querySelector('img');
                            mediaSrc = img ? img.src : '';
                            mediaType = 'image';
                        }

                        mediaFiles.push({
                            src: mediaSrc,
                            type: mediaType,
                            isVideo: isVideo,
                            index: index
                        });
                    });
                    document.getElementById('total-media').textContent = mediaFiles.length;
                }

                function openTrackingPopup() {
                    document.getElementById('trackingPopup').style.display = 'flex';
                    document.getElementById('trackingCode').focus();
                    document.getElementById('errorMessage').style.display = 'none';
                    document.getElementById('trackingCode').classList.remove('is-invalid');
                }

                function closePopup() {
                    const popups = document.querySelectorAll('.popup');
                    popups.forEach(popup => {
                        popup.style.display = 'none';
                    });

                    if (typeof window.closeCompleteDocumentsForm === 'function') {
                        window.closeCompleteDocumentsForm();
                    }
                }

                function checkTrackingCode() {
                    const trackingCode = document.getElementById('trackingCode').value.trim();

                    if (!trackingCode) {
                        document.getElementById('errorMessage').style.display = 'block';
                        document.getElementById('trackingCode').classList.add('is-invalid');
                        document.getElementById('trackingCode').focus();
                        return;
                    }

                    document.getElementById('errorMessage').style.display = 'none';
                    document.getElementById('trackingCode').classList.remove('is-invalid');

                    document.getElementById('form-track').submit();
                }

                function backToTracking() {
                    document.getElementById('detailPage').style.display = 'none';
                    document.getElementById('trackingPage').style.display = 'block';
                    document.getElementById('trackingCode').value = '';
                    trackReportModule.openTrackingPopup();
                }

                function updateStatusCardOnly(stepNumber) {
                    const stepData = trackingStepsData[stepNumber];
                    if (!stepData) return;

                    const statusCard = document.querySelector('.status-card');
                    statusCard.classList.add('loading');

                    if (stepData.isRejected) {
                        statusCard.classList.add('rejected');
                    } else {
                        statusCard.classList.remove('rejected');
                    }

                    setTimeout(() => {
                        const statusIcon = statusCard.querySelector('.status-icon i');
                        const statusTitle = statusCard.querySelector('.status-title h5');
                        const statusDate = statusCard.querySelector('.status-date');
                        const statusDescription = statusCard.querySelector('.status-description p');
                        const progressBar = statusCard.querySelector('.progress-bar-fill');
                        const progressText = statusCard.querySelector('.progress-text');
                        const rejectionReasonDiv = statusCard.querySelector('#rejection-reason-display'); // Menggunakan ID

                        if (statusIcon) statusIcon.className = stepData.icon;
                        if (statusTitle) statusTitle.textContent = `Status: ${stepData.status}`;
                        if (statusDate) statusDate.textContent = stepData.date;
                        
                        // Set innerHTML for description to parse <br> and <strong> tags
                        if (statusDescription) {
                            statusDescription.innerHTML = stepData.description;
                        }

                        if (progressBar) progressBar.style.width = `${stepData.progress}%`;
                        if (progressText) {
                            if (stepData.isRejected) {
                                progressText.textContent = `${stepData.progress}% Ditolak`;
                            } else {
                                progressText.textContent = `${stepData.progress}% Selesai`;
                            }
                        }
                        
                        // Show/hide rejection reason based on status
                        if (rejectionReasonDiv) {
                            if (stepData.isRejected) {
                                rejectionReasonDiv.style.display = 'block';
                                rejectionReasonDiv.innerHTML = `
                                    <div class="reason-label">Alasan Penolakan:</div>
                                    <div class="reason-text">${stepData.rejection_reason}</div>
                                `;
                            } else {
                                rejectionReasonDiv.style.display = 'none';
                                rejectionReasonDiv.innerHTML = ''; // Kosongkan konten saat disembunyikan
                            }
                        }


                        updateActionButton(stepData);
                        statusCard.classList.remove('loading');
                    }, 300);
                }

                function updateStatusCard(stepNumber) {
                    const stepData = trackingStepsData[stepNumber];
                    if (!stepData) return;

                    const statusCard = document.querySelector('.status-card');
                    statusCard.classList.add('loading');

                    if (stepData.isRejected) {
                        statusCard.classList.add('rejected');
                    } else {
                        statusCard.classList.remove('rejected');
                    }

                    setTimeout(() => {
                        const statusIcon = statusCard.querySelector('.status-icon i');
                        const statusTitle = statusCard.querySelector('.status-title h5');
                        const statusDate = statusCard.querySelector('.status-date');
                        const statusDescription = statusCard.querySelector('.status-description p');
                        const progressBar = statusCard.querySelector('.progress-bar-fill');
                        const progressText = statusCard.querySelector('.progress-text');
                        const rejectionReasonDiv = statusCard.querySelector('#rejection-reason-display'); // Menggunakan ID

                        if (statusIcon) statusIcon.className = stepData.icon;
                        if (statusTitle) statusTitle.textContent = `Status: ${stepData.status}`;
                        if (statusDate) statusDate.textContent = stepData.date;
                        
                        // Set innerHTML for description to parse <br> and <strong> tags
                        if (statusDescription) {
                            statusDescription.innerHTML = stepData.description;
                        }

                        if (progressBar) progressBar.style.width = `${stepData.progress}%`;
                        if (progressText) {
                            if (stepData.isRejected) {
                                progressText.textContent = `${stepData.progress}% Ditolak`;
                            } else {
                                progressText.textContent = `${stepData.progress}% Selesai`;
                            }
                        }

                        // Show/hide rejection reason based on status
                        if (rejectionReasonDiv) {
                            if (stepData.isRejected) {
                                rejectionReasonDiv.style.display = 'block';
                                rejectionReasonDiv.innerHTML = `
                                    <div class="reason-label">Alasan Penolakan:</div>
                                    <div class="reason-text">${stepData.rejection_reason}</div>
                                `;
                            } else {
                                rejectionReasonDiv.style.display = 'none';
                                rejectionReasonDiv.innerHTML = ''; // Kosongkan konten saat disembunyikan
                            }
                        }

                        const timelineProgress = document.querySelector('.timeline-progress');
                        if (timelineProgress) {
                            if (stepData.isRejected) {
                                timelineProgress.style.width = '0%';
                                timelineProgress.classList.add('rejected');
                            } else {
                                // Calculate width for normal progress (0 to 4)
                                const totalNormalSteps = Object.keys(trackingStepsData).length - 1; // Exclude rejected step
                                timelineProgress.style.width = `${(stepNumber / (totalNormalSteps - 1)) * 100}%`;
                                timelineProgress.classList.remove('rejected');
                            }
                        }

                        updateTimelineStepsInfo(stepNumber);
                        updateActionButton(stepData);
                        statusCard.classList.remove('loading');
                    }, 300);
                }

                function updateRejectedTimeline() {
                    const timelineProgress = document.querySelector('.timeline-progress');
                    if (timelineProgress) {
                        timelineProgress.style.width = '0%';
                        timelineProgress.classList.add('rejected');
                    }

                    document.querySelectorAll('.timeline-step').forEach((step, index) => {
                        const stepData = trackingStepsData[index];
                        const reject = step.dataset.reject;
                    
                        step.classList.remove('completed', 'active', 'current', 'pending', 'rejected');

                        // Always display 'Terkirim' (0) and 'Ditolak' (5) when rejected
                        if (index === 4) {
                            step.classList.add('rejected', 'current');
                            step.style.display = 'flex';
                            step.style.cursor = 'pointer';
                            step.setAttribute('title', `Klik untuk melihat detail: ${stepData.title}`);
                        } else if (index == reject) {
                            step.classList.add('completed');
                            step.style.display = 'flex';
                            step.style.cursor = 'pointer';
                            step.setAttribute('title', `Klik untuk melihat detail: ${stepData.title}`);
                        } else {
                            step.classList.add('pending');
                            step.style.display = 'none'; // Hide other normal steps
                        }
                    });
                    // Add a class to the timeline-steps container to control its children's display
                    document.querySelector('.timeline-steps').classList.add('rejected-timeline');
                }

                function updateTimelineStepsInfo(currentStep) {
                    document.querySelectorAll('.timeline-step').forEach((step, index) => {
                        const stepData = trackingStepsData[index];
                        if (stepData) {
                            const stepTitle = step.querySelector('.step-title');
                            const stepTime = step.querySelector('.step-time');
                            const stepIcon = step.querySelector('.step-circle i');

                            if (stepTitle) stepTitle.textContent = stepData.title;
                            if (stepTime) {
                                stepTime.textContent = stepData.date;
                            }
                            if (stepIcon) stepIcon.className = stepData.icon;
                        }
                    });
                }

                function updateActionButton(stepData) {
                    const actionButtonContainer = document.getElementById('action-button-container');
                    actionButtonContainer.innerHTML = ''; // Clear existing button

                    if (Boolean(Boolean(stepData.hasAction)) && stepData.actionType === "complete_documents") {
                        actionButtonContainer.innerHTML = `
                            <div class="text-center mt-3"> <button class="btn-complete-documents" onclick="window.openCompleteDocumentsForm()">
                                    <i class="fas fa-plus-circle"></i>
                                    ${stepData.actionText}
                                </button>
                            </div>
                        `;
                    } else if (Boolean(stepData.hasAction) && stepData.actionType === "contact_admin") {
                        actionButtonContainer.innerHTML = `
                            <div class="text-center mt-3">
                                <a href="#" class="contact-admin-btn" onclick="trackReportModule.contactAdmin()">
                                    <i class="fas fa-headset"></i>
                                    ${stepData.actionText}
                                </a>
                            </div>
                        `;
                    } else if (Boolean(Boolean(stepData.hasAction)) && stepData.actionType === "give_feedback" && stepData.title === "Selesai") { // Menambahkan kondisi untuk "Selesai"
                    const hasRating = {{ $reporter?->rating ? 'true' : 'false' }}; 
                        actionButtonContainer.innerHTML = `
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary btn-lg px-4" onclick="window.completionInfoModal()">
                                    <i class="fas fa-star me-2"></i>${hasRating ? 'Lihat Hasil Penilaian' : 'Berikan Penilaian'}
                                </button>
                            </div>
                        `;
                    }
                }

                function showSuccessMessage(message) {
                    const successMessageDiv = document.createElement('div');
                    successMessageDiv.className = 'success-notification';
                    successMessageDiv.innerHTML = `
                        <div class="success-content">
                            <i class="fas fa-check-circle"></i>
                            <h4>Berhasil!</h4>
                            <p>${message}</p>
                            
                        </div>
                    `;

                    document.body.appendChild(successMessageDiv);

                    setTimeout(() => {
                        successMessageDiv.classList.add('show');
                    }, 100);

                    setTimeout(() => {
                        successMessageDiv.classList.remove('show');
                        setTimeout(() => {
                            successMessageDiv.remove();
                        }, 500);
                    }, 5000); 
                }

                function showErrorMessage(message) { 
                    const errorMessageDiv = document.createElement('div');
                    errorMessageDiv.className = 'error-notification'; 
                    errorMessageDiv.innerHTML = `
                        <div class="error-content">
                            <i class="fas fa-times-circle"></i>
                            <h4>Gagal!</h4>
                            <p>${message}</p>
                        </div>
                    `;

                    document.body.appendChild(errorMessageDiv);

                    setTimeout(() => {
                        errorMessageDiv.classList.add('show');
                    }, 100);

                    setTimeout(() => {
                        errorMessageDiv.classList.remove('show');
                        setTimeout(() => {
                            errorMessageDiv.remove();
                        }, 500);
                    }, 5000); // Pesan akan hilang setelah 5 detik
                }

                function handleStepClick(stepElement, stepNumber) {
                    // Allow clicking on 'completed', 'active', or 'rejected' steps
                    if (!stepElement.classList.contains('completed') && !stepElement.classList.contains('active') && !stepElement.classList.contains('rejected')) {
                        return;
                    }

                    // Remove 'current' class from all steps
                    document.querySelectorAll('.timeline-step').forEach(step => {
                        step.classList.remove('current');
                    });

                    // Add 'current' class to the clicked step
                    stepElement.classList.add('current');

                    // Update only the status card based on the clicked step
                    updateStatusCardOnly(stepNumber);

                    // Scroll to the status card
                    document.querySelector('.status-card').scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });

                    createRippleEffect(stepElement);
                    isPreviewMode = true; // Enter preview mode
                    setTimeout(() => {
                        if (isPreviewMode && stepNumber !== originalCurrentStep) {
                            restoreToCurrentStep();
                        }
                    }, 10000); // Revert after 10 seconds of inactivity in preview mode
                }

                function restoreToCurrentStep() {
                    isPreviewMode = false;
                    if (originalCurrentStep === 4) {
                        updateRejectedTimeline();
                    } else {
                        restoreOriginalStepStates();
                    }
                    updateStatusCardOnly(originalCurrentStep); // Update status card to original step's data
                }

                function restoreOriginalStepStates() {
                    document.querySelector('.timeline-steps').classList.remove('rejected-timeline');
                    document.querySelectorAll('.timeline-step').forEach((step, index) => {
                        const stepNumber = index;
                        step.classList.remove('completed', 'active', 'current', 'pending', 'rejected');

                        if (stepNumber === 4) { // Hide the rejected step for normal flow
                            step.style.display = 'none';
                            return;
                        }

                        if (stepNumber < originalCurrentStep) {
                            step.classList.add('completed');
                        } else if (stepNumber === originalCurrentStep) {
                            step.classList.add('active', 'current');
                        } else {
                            step.classList.add('pending');
                        }
                        step.style.display = 'flex'; // Ensure normal steps are visible
                    });
                }

                function createRippleEffect(element) {
                    const ripple = document.createElement('div');
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(102, 126, 234, 0.3);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                        z-index: 100;
                    `;

                    const rect = element.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = (rect.width / 2 - size / 2) + 'px';
                    ripple.style.top = (rect.height / 2 - size / 2) + 'px';

                    element.style.position = 'relative';
                    element.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                }

                // CSS untuk animasi ripple
                const rippleCSS = `
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
                const style = document.createElement('style');
                style.textContent = rippleCSS;
                document.head.appendChild(style);

                function initializeElegantTracking(currentStep) {
                    currentStep = parseInt(currentStep);
                    originalCurrentStep = currentStep;
                    isPreviewMode = false;

                    if (currentStep === 4) { // If status is rejected
                        updateRejectedTimeline();
                        updateStatusCard(currentStep);
                    } else {
                        updateTrackingSteps(currentStep);
                        updateStatusCard(currentStep);
                    }

                    document.querySelectorAll('.timeline-step').forEach((step, index) => {
                        const stepNumber = index;

                        step.addEventListener('click', () => {
                            if (stepNumber === originalCurrentStep && isPreviewMode) {
                                restoreToCurrentStep();
                            } else {
                                handleStepClick(step, stepNumber);
                            }
                        });

                        // Perbarui kondisi cursor dan title
                        if (step.classList.contains('completed') || step.classList.contains('active') || step.classList.contains('rejected')) {
                            step.style.cursor = 'pointer';
                            step.setAttribute('title', `Klik untuk melihat detail: ${trackingStepsData[stepNumber].title}`);

                            step.addEventListener('mouseenter', () => {
                                if (!step.classList.contains('current')) {
                                    step.style.transform = 'translateY(-8px) scale(1.02)';
                                }
                            });

                            step.addEventListener('mouseleave', () => {
                                if (!step.classList.contains('current')) {
                                    step.style.transform = 'translateY(0) scale(1)';
                                }
                            });
                        } else {
                            step.style.cursor = 'default';
                            step.setAttribute('title', `Belum mencapai tahap ini`);
                        }
                    });

                    document.querySelector('.status-card').addEventListener('click', (e) => {
                        if (isPreviewMode && !e.target.closest('.status-action-button')) {
                            restoreToCurrentStep();
                        }
                    });
                }

                function updateTrackingSteps(currentStep) {
                    document.querySelectorAll('.timeline-step').forEach((step, index) => {
                        const stepNumber = index;
                        const stepData = trackingStepsData[index];

                        step.classList.remove('completed', 'active', 'current', 'pending', 'rejected');

                        if (stepNumber === 4) { // Hide the rejected step for normal flow
                            step.style.display = 'none';
                            return;
                        }

                        if (stepNumber < currentStep) {
                            step.classList.add('completed');
                        } else if (stepNumber === currentStep) {
                            step.classList.add('active', 'current');
                        } else {
                            step.classList.add('pending');
                        }
                        step.style.display = 'flex'; // Ensure normal steps are visible
                    });
                    document.querySelector('.timeline-steps').classList.remove('rejected-timeline');
                }

                function animateStepChange(newStep) {
                    originalCurrentStep = newStep;
                    const statusCard = document.querySelector('.status-card');
                    const timeline = document.querySelector('.progress-timeline');

                    statusCard.style.transform = 'translateY(20px)';
                    statusCard.style.opacity = '0.7';
                    timeline.style.transform = 'scale(0.98)';
                    timeline.style.opacity = '0.8';

                    setTimeout(() => {
                        if (newStep === 4) {
                            updateRejectedTimeline();
                        } else {
                            updateTrackingSteps(newStep);
                        }
                        updateStatusCard(newStep);

                        statusCard.style.transform = 'translateY(0)';
                        statusCard.style.opacity = '1';
                        timeline.style.transform = 'scale(1)';
                        timeline.style.opacity = '1';
                    }, 300);
                }

                function handleKeyboardNavigation(event) {
                    if (event.key === 'Escape') {
                        trackReportModule.closePopup();
                        trackReportModule.closeUploadEvidenceModal(); // Tutup juga modal unggah bukti
                        trackReportModule.closeLightboxExplicit(); // Tutup lightbox juga
                    }
                    if (event.key === 'Enter' && document.activeElement === document.getElementById('trackingCode')) {
                        trackReportModule.checkTrackingCode();
                    }
                }

                const categoryMap = {
                    'bullying verbal': { iconClass: 'icon-bullying-verbal', symbol: '💬' },
                    'bullying fisik': { iconClass: 'icon-bullying-fisik', symbol: '👊' },
                    'pelecehan seksual verbal': { iconClass: 'icon-pelecehan-verbal', symbol: '🗣️' },
                    'pelecehan seksual fisik': { iconClass: 'icon-pelecehan-fisik', symbol: '⚠️' },
                    'default': { iconClass: 'icon-default', symbol: '📋' }
                };

                function getIconClass(category) {
                    const lowerCategory = category.toLowerCase();
                    if (lowerCategory.includes('bullying') && lowerCategory.includes('verbal')) return 'icon-bullying-verbal';
                    if (lowerCategory.includes('bullying') && lowerCategory.includes('fisik')) return 'icon-bullying-fisik';
                    if (lowerCategory.includes('pelecehan') && lowerCategory.includes('verbal')) return 'icon-pelecehan-verbal';
                    if (lowerCategory.includes('pelecehan') && lowerCategory.includes('fisik')) return 'icon-pelecehan-fisik';
                    return 'icon-default';
                }

                function getIconSymbol(category) {
                    const lowerCategory = category.toLowerCase();
                    if (lowerCategory.includes('bullying') && lowerCategory.includes('verbal')) return '';
                    if (lowerCategory.includes('bullying') && lowerCategory.includes('fisik')) return '';
                    if (lowerCategory.includes('pelecehan') && lowerCategory.includes('verbal')) return '';
                    if (lowerCategory.includes('pelecehan') && lowerCategory.includes('fisik')) return '';
                    return '📋';
                }

                function generateCategoryList(categoriesString) {
                    const categoryList = document.getElementById('categoryList');
                    if (!categoryList) {
                        console.warn('Elemen #categoryList tidak ditemukan. Tidak dapat menggenerate daftar kategori.');
                        return;
                    }

                    const categoriesArray = categoriesString.split(',');
                    categoryList.innerHTML = '';

                    if (categoriesArray.length === 1 && categoriesArray[0].trim() === '') {
                        const listItem = document.createElement('li');
                        listItem.className = 'text-muted';
                        listItem.textContent = 'Tidak ada kategori yang dilaporkan.';
                        categoryList.appendChild(listItem);
                        return;
                    }

                    categoriesArray.forEach(category => {
                        const trimmedCategory = category.trim();
                        const iconClass = getIconClass(trimmedCategory);
                        const iconSymbol = getIconSymbol(trimmedCategory);

                        const listItem = document.createElement('li');
                        listItem.className = 'category-item';

                        listItem.innerHTML = `
                            <div class="category-icon ${iconClass}">${iconSymbol}</div>
                            <span class="category-text">${trimmedCategory}</span>
                        `;
                        categoryList.appendChild(listItem);
                    });
                }

                function getBadgeClass(category) {
                    const lowerCategory = category.toLowerCase();
                    if (lowerCategory.includes('bullying') && lowerCategory.includes('verbal')) return 'bullying-verbal';
                    if (lowerCategory.includes('bullying') && lowerCategory.includes('fisik')) return 'bullying-fisik';
                    if (lowerCategory.includes('pelecehan') && lowerCategory.includes('verbal')) return 'pelecehan-verbal';
                    if (lowerCategory.includes('pelecehan') && lowerCategory.includes('fisik')) return 'pelecehan-fisik';
                    return 'bullying-verbal';
                }

                function openLightbox(index) {
                    currentMediaIndex = index;
                    const lightbox = document.getElementById('lightbox');
                    const lightboxImage = document.getElementById('lightbox-image');
                    const lightboxVideo = document.getElementById('lightbox-video');
                    const lightboxVideoSource = document.getElementById('lightbox-video-source');
                    const loading = document.getElementById('lightbox-loading');
                    const videoControls = document.getElementById('lightbox-video-controls');

                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';

                    loading.style.display = 'block';
                    lightboxImage.style.display = 'none';
                    lightboxVideo.style.display = 'none';
                    videoControls.style.display = 'none';

                    lightboxVideo.pause();
                    isVideoPlaying = false;
                    updatePlayPauseIcon();

                    const currentMedia = mediaFiles[index];

                    if (currentMedia.isVideo) {
                        lightboxVideoSource.src = currentMedia.src;
                        lightboxVideoSource.type = currentMedia.type;
                        lightboxVideo.load();

                        lightboxVideo.addEventListener('loadeddata', function handler() {
                            loading.style.display = 'none';
                            lightboxVideo.style.display = 'block';
                            lightboxVideo.classList.add('loaded');
                            videoControls.style.display = 'flex';
                            lightboxVideo.removeEventListener('loadeddata', handler);
                        });

                        lightboxVideo.addEventListener('error', function handler() {
                            loading.style.display = 'none';
                            console.error('Error loading video:', currentMedia.src);
                            lightboxVideo.removeEventListener('error', handler);
                        });

                    } else {
                        lightboxImage.src = currentMedia.src;
                        lightboxImage.classList.remove('loaded');

                        lightboxImage.onload = function() {
                            loading.style.display = 'none';
                            lightboxImage.style.display = 'block';
                            lightboxImage.classList.add('loaded');
                        };

                        lightboxImage.onerror = function() {
                            loading.style.display = 'none'; // Corrected from style.none to style.display
                            console.error('Error loading image:', currentMedia.src);
                        };
                    }
                    document.getElementById('current-media').textContent = index + 1;
                }

                function closeLightbox(event) {
                    // HANYA tutup lightbox jika klik dilakukan pada OVERLAY (lightbox itu sendiri)
                    // Ini mencegah klik di dalam lightbox-content atau tombol navigasi menutupnya
                    if (event && event.target === event.currentTarget) { // Jika target klik adalah elemen lightbox itu sendiri
                        const lightbox = document.getElementById('lightbox');
                        const lightboxVideo = document.getElementById('lightbox-video');

                        if (lightboxVideo.style.display === 'block') {
                            lightboxVideo.pause();
                        }

                        lightbox.classList.remove('active');
                        document.body.style.overflow = '';

                        setTimeout(() => {
                            document.getElementById('lightbox-image').style.display = 'none';
                            document.getElementById('lightbox-video').style.display = 'none';
                            document.getElementById('lightbox-video-controls').style.display = 'none';
                            document.getElementById('lightbox-image').classList.remove('loaded');
                            document.getElementById('lightbox-video').classList.remove('loaded');
                        }, 300);
                    }
                }
                
                function closeLightboxExplicit() { // Fungsi baru untuk menutup secara eksplisit dari tombol X
                    const lightbox = document.getElementById('lightbox');
                    const lightboxVideo = document.getElementById('lightbox-video');

                    if (lightboxVideo.style.display === 'block') {
                        lightboxVideo.pause();
                    }

                    lightbox.classList.remove('active');
                    document.body.style.overflow = '';

                    setTimeout(() => {
                        document.getElementById('lightbox-image').style.display = 'none';
                        document.getElementById('lightbox-video').style.display = 'none';
                        document.getElementById('lightbox-video-controls').style.display = 'none';
                        document.getElementById('lightbox-image').classList.remove('loaded');
                        document.getElementById('lightbox-video').classList.remove('loaded');
                    }, 300);
                }


                function nextMedia() {
                    if (currentMediaIndex < mediaFiles.length - 1) {
                        openLightbox(currentMediaIndex + 1);
                    } else {
                        openLightbox(0);
                    }
                }

                function prevMedia() {
                    if (currentMediaIndex > 0) {
                        openLightbox(currentMediaIndex - 1);
                    } else {
                        openLightbox(mediaFiles.length - 1);
                    }
                }

                // Fungsi Kontrol Video
                function toggleVideoPlayPause() {
                    const video = document.getElementById('lightbox-video');
                    if (video.paused) {
                        video.play();
                        isVideoPlaying = true;
                    } else {
                        video.pause();
                        isVideoPlaying = false;
                    }
                    updatePlayPauseIcon();
                }

                function updatePlayPauseIcon() {
                    const icon = document.getElementById('play-pause-icon');
                    if (isVideoPlaying) {
                        icon.classList.remove('fa-play');
                        icon.classList.add('fa-pause');
                    } else {
                        icon.classList.remove('fa-pause');
                        icon.classList.add('fa-play');
                    }
                }

                function toggleVideoMute() {
                    const video = document.getElementById('lightbox-video');
                    const icon = document.getElementById('mute-icon');

                    video.muted = !video.muted;

                    if (video.muted) {
                        icon.classList.remove('fa-volume-up');
                        icon.classList.add('fa-volume-mute');
                    } else {
                        icon.classList.remove('fa-volume-mute');
                        icon.classList.add('fa-volume-up');
                    }
                }

                function toggleVideoFullscreen() {
                    const video = document.getElementById('lightbox-video');

                    if (video.requestFullscreen) {
                        video.requestFullscreen();
                    } else if (video.webkitRequestFullscreen) {
                        video.webkitRequestFullscreen();
                    } else if (video.mozRequestFullScreen) {
                        video.mozRequestFullScreen();
                    } else if (video.msRequestFullscreen) {
                        video.msRequestFullscreen();
                    }
                }

                function openCompletionModal() { // BARU: Fungsi untuk membuka completionModal
                    const completionModal = new bootstrap.Modal(document.getElementById('completionModal'));
                    completionModal.show();
                }
            // function completionInfoModal() { // BARU: Fungsi untuk membuka completionModal
                //    $("#exampleModal").modal('show')
            // }

                // ===== FUNGSI UNTUK UNGGAH BUKTI TAMBAHAN =====
                function openUploadEvidenceModal() {
                    document.getElementById('uploadEvidenceModal').style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    document.getElementById('uploadErrorMessage').style.display = 'none';
                    document.getElementById('evidenceFiles').value = ''; // Reset input file
                }

                function closeUploadEvidenceModal() {
                    document.getElementById('uploadEvidenceModal').style.display = 'none';
                    document.body.style.overflow = 'auto';
                }

                async function uploadEvidence() {
                    const form = document.getElementById('uploadEvidenceForm');
                    const filesInput = document.getElementById('evidenceFiles');
                    const errorMessageDiv = document.getElementById('uploadErrorMessage');

                    if (filesInput.files.length === 0) {
                        errorMessageDiv.style.display = 'block';
                        return;
                    } else {
                        errorMessageDiv.style.display = 'none';
                    }

                    const formData = new FormData(form);
                    const reportCode = form.querySelector('input[name="report_code"]').value;

                    // Disable button and show loading (optional)
                    const submitButton = form.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengunggah...';

                    try {
                        const response = await fetch(`/api/reports/${reportCode}/upload-evidence`, { // Sesuaikan URL API Anda
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Pastikan ada meta csrf-token
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (response.ok) {
                            showSuccessMessage(data.message || 'Bukti berhasil ditambahkan!');
                            closeUploadEvidenceModal();
                            // Perbarui tampilan bukti di halaman detail
                            updateEvidenceDisplay(data.new_files); // data.new_files harus berisi array objek file baru
                        } else {
                            let errorMsg = 'Terjadi kesalahan saat mengunggah bukti.';
                            if (data.errors) {
                                errorMsg = Object.values(data.errors).flat().join('<br>');
                            } else if (data.message) {
                                errorMsg = data.message;
                            }
                            showErrorMessage(errorMsg);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showErrorMessage('Terjadi kesalahan jaringan atau server.');
                    } finally {
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="fas fa-cloud-upload-alt me-2"></i>Unggah Bukti';
                    }
                }

                function updateEvidenceDisplay(newFiles) {
                    const masonryContainer = document.getElementById('masonryContainer');
                    if (!masonryContainer) return;

                    // Clear existing "Pelapor tidak melampirkan foto atau bukti." message if present
                    const noEvidenceMessage = masonryContainer.querySelector('.text-muted');
                    if (noEvidenceMessage) {
                        noEvidenceMessage.remove();
                    }

                    newFiles.forEach(file => {
                        const fileExtension = file.file.split('.').pop().toLowerCase();
                        const isVideo = ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg'].includes(fileExtension);
                        const fileType = isVideo ? 'video' : 'image';
                        
                        const newItem = document.createElement('div');
                        newItem.className = `masonry-item ${fileType}`;
                        // Perbarui index untuk klik lightbox
                        newItem.setAttribute('onclick', `trackReportModule.openLightbox(${mediaFiles.length})`);

                        if (isVideo) {
                            newItem.innerHTML = `
                                <video class="masonry-video" preload="metadata" muted>
                                    <source src="${file.url}" type="video/${fileExtension}">
                                    Video tidak dapat dimuat
                                </video>
                                <div class="file-type-badge video">
                                    <i class="fas fa-play me-1"></i>Video
                                </div>
                            `;
                        } else {
                            newItem.innerHTML = `
                                <img src="${file.url}" class="masonry-image" alt="Bukti Kejadian">
                                <div class="file-type-badge image">
                                    <i class="fas fa-image me-1"></i>Foto
                                </div>
                            `;
                        }
                        masonryContainer.appendChild(newItem);

                        // Tambahkan file baru ke array mediaFiles
                        mediaFiles.push({
                            src: file.url,
                            type: isVideo ? `video/${fileExtension}` : 'image',
                            isVideo: isVideo,
                            index: mediaFiles.length // Index baru
                        });
                    });
                    // Perbarui total media di lightbox counter
                    document.getElementById('total-media').textContent = mediaFiles.length;

                    // Re-initialize event listeners for new video elements if necessary (for poster generation)
                    document.querySelectorAll('.masonry-video').forEach(video => {
                        if (!video.poster && !video._posterGenerated) { // Tambahkan flag agar tidak diproses berulang
                            video.addEventListener('loadeddata', function() { this.currentTime = 1; });
                            video.addEventListener('seeked', function() {
                                const canvas = document.createElement('canvas');
                                const ctx = canvas.getContext('2d');
                                canvas.width = this.videoWidth;
                                canvas.height = this.videoHeight;
                                ctx.drawImage(this, 0, 0);
                                this.poster = canvas.toDataURL();
                                this._posterGenerated = true; // Set flag
                            });
                            video.load(); // Load video to trigger loadeddata/seeked
                        }
                    });
                }


                let touchStartX = 0;
                let touchEndX = 0;
                let touchStartY = 0;
                let touchEndY = 0;

                return {
                    openTrackingPopup: openTrackingPopup,
                    closePopup: closePopup,
                    checkTrackingCode: checkTrackingCode,
                    backToTracking: backToTracking,
                    openLightbox: openLightbox,
                    closeLightbox: closeLightbox,
                    closeLightboxExplicit: closeLightboxExplicit, // Expose the new function
                    nextMedia: nextMedia,
                    prevMedia: prevMedia,
                    toggleVideoPlayPause: toggleVideoPlayPause,
                    toggleVideoMute: toggleVideoMute,
                    toggleVideoFullscreen: toggleVideoFullscreen,
                    init: init,
                    initializeElegantTracking: initializeElegantTracking,
                    showSuccessMessage: showSuccessMessage,
                    showErrorMessage: showErrorMessage, // Tambahkan fungsi error
                    contactAdmin: contactAdmin,
                    openCompletionModal: openCompletionModal,
                // completionInfoModal: completionInfoModal,
                    openUploadEvidenceModal: openUploadEvidenceModal, // Fungsi baru
                    closeUploadEvidenceModal: closeUploadEvidenceModal, // Fungsi baru
                };
            })();

            document.addEventListener('DOMContentLoaded', trackReportModule.init);

            document.addEventListener('DOMContentLoaded', function() {
                const lightbox = document.getElementById('lightbox');
                if (lightbox) {
                    lightbox.addEventListener('touchstart', function(e) {
                        trackReportModule.touchStartX = e.changedTouches[0].screenX;
                        trackReportModule.touchStartY = e.changedTouches[0].screenY;
                    }, { passive: true });

                    lightbox.addEventListener('touchend', function(e) {
                        trackReportModule.touchEndX = e.changedTouches[0].screenX;
                        trackReportModule.touchEndY = e.changedTouches[0].screenY;
                        // Only perform swipe action if it's primarily horizontal
                        const deltaX = trackReportModule.touchEndX - trackReportModule.touchStartX;
                        const deltaY = trackReportModule.touchEndY - trackReportModule.touchStartY;
                        const minSwipeDistance = 50;

                        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > minSwipeDistance) {
                            if (deltaX < 0) {
                                trackReportModule.nextMedia();
                            } else {
                                trackReportModule.prevMedia();
                            }
                        }
                        // Add a condition for closing on vertical swipe down
                        if (deltaY > minSwipeDistance && Math.abs(deltaX) < minSwipeDistance) {
                            trackReportModule.closeLightboxExplicit(); // Use explicit close for swipe down
                        }
                    }, { passive: true });
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'ArrowRight' && document.getElementById('lightbox').classList.contains('active')) {
                    trackReportModule.nextMedia();
                } else if (event.key === 'ArrowLeft' && document.getElementById('lightbox').classList.contains('active')) {
                    trackReportModule.prevMedia();
                } else if (event.key === 'Escape' && document.getElementById('lightbox').classList.contains('active')) { // Menambahkan kondisi untuk Escape pada lightbox
                    trackReportModule.closeLightboxExplicit();
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const lightboxVideo = document.getElementById('lightbox-video');

                if (lightboxVideo) {
                    lightboxVideo.addEventListener('play', function() {
                        trackReportModule.isVideoPlaying = true;
                        trackReportModule.updatePlayPauseIcon();
                    });

                    lightboxVideo.addEventListener('pause', function() {
                        trackReportModule.isVideoPlaying = false;
                        trackReportModule.updatePlayPauseIcon();
                    });

                    lightboxVideo.addEventListener('ended', function() {
                        trackReportModule.isVideoPlaying = false;
                        trackReportModule.updatePlayPauseIcon();
                        setTimeout(() => {
                            trackReportModule.nextMedia();
                        }, 1000);
                    });
                }
            });

            // Fungsi untuk menampilkan modal konfirmasi
            function showReminderConfirmation() {
                document.getElementById('reminderModal').style.display = 'block';
                document.body.style.overflow = 'hidden'; // Mencegah scroll
            }

            // Fungsi untuk menutup modal
            function closeReminderModal() {
                document.getElementById('reminderModal').style.display = 'none';
                document.body.style.overflow = 'auto'; // Mengizinkan scroll kembali
            }

            // Fungsi untuk simulasi kirim reminder (hanya tampilan)
            async function sendReminder() {
                const formData = new FormData();
                const reportId = '{{ $reporter->id ?? null }}';
                if (!reportId) {
                    alert('ID laporan tidak ditemukan. Tidak dapat mengirim ulasan.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    return;
                }

                formData.append('report_id', reportId);

                 try {
                    const response = await fetch('/reminder-bk', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        alert('Gagal mengirim penilaian: ' + (errorData.message || 'Terjadi kesalahan.'));
                        return;
                    }

                   // Tutup modal
                    closeReminderModal();
                    
                    // Tampilkan pesan sukses setelah delay singkat
                    setTimeout(() => {
                        const successMessage = document.createElement('div'); // Mendeklarasikan ulang agar tidak error
                        successMessage.className = 'success-notification';
                        successMessage.innerHTML = `
                            <div class="success-content">
                                <i class="fas fa-check-circle"></i>
                                <h4>Reminder Terkirim!</h4>
                                <p>Reminder laporan Anda telah berhasil dikirim.</p>
                            </div>
                        `;
                        document.body.appendChild(successMessage);

                        setTimeout(() => {
                            successMessage.classList.add('show');
                        }, 100);

                        setTimeout(() => {
                            successMessage.classList.remove('show');
                            setTimeout(() => {
                                successMessage.remove();
                            }, 500);
                        }, 3000); // Hilang setelah 3 detik
                    }, 500);
                } catch (error) {
                    console.error('Network or unexpected error during user feedback submission:', error);
                    alert('Terjadi kesalahan jaringan atau tak terduga saat mengirim penilaian. Mohon coba lagi.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }

               
            }

            // Menutup modal ketika klik di luar area modal
            document.addEventListener('click', function(event) {
                const modal = document.getElementById('reminderModal');
                const uploadModal = document.getElementById('uploadEvidenceModal'); 
                const lightbox = document.getElementById('lightbox'); // Dapatkan elemen lightbox

                if (event.target === modal) {
                    closeReminderModal();
                }
                if (event.target === uploadModal) { 
                    trackReportModule.closeUploadEvidenceModal();
                }
                // Logika untuk menutup lightbox jika klik di luar kontennya
                if (event.target === lightbox && lightbox.classList.contains('active')) {
                    trackReportModule.closeLightbox(event);
                }
            });

            // Efek smooth scroll untuk button (opsional)
            window.addEventListener('scroll', function() {
                const button = document.getElementById('reminderButton');
                if (button) {
                    const scrolled = window.pageYOffset;
                    const rate = scrolled * -0.5;
                    
                    if (scrolled > 100) {
                        button.style.transform = `translateY(${rate * 0.05}px)`;
                    }
                }
            });
        </script>

        <style>
        /* Mengatur layout flex untuk card-header */
        .card-header .header-left, .card-header .header-right {
            flex: 1; /* Memberi ruang fleksibel di kiri dan kanan */
        }
        .card-header .header-center {
            flex: 2; /* Memberi ruang lebih besar untuk judul di tengah */
        }
        .card-header .header-right {
            display: flex;
            justify-content: flex-end; /* Memposisikan tombol ke ujung kanan */
        }
        .kode-container {
            font-size: 0.8rem;
            margin-top: 4px;
        }

        /* Styling utama untuk tombol cetak */
        .btn-print {
            background-color: #ffffff;
            color: #0d6efd; /* Warna utama Bootstrap */
            border: 1px solid #dee2e6;
            border-radius: 50px; /* Membuatnya menjadi pil */
            padding: 6px 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px; /* Jarak antara ikon dan teks */
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-decoration: none; /* Menghilangkan garis bawah dari tag <a> */
        }

        /* Efek saat kursor diarahkan ke tombol */
        .btn-print:hover {
            background-color: #0d6efd;
            color: #ffffff;
            transform: translateY(-3px) scale(1.05); /* Efek terangkat dan sedikit membesar */
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        }
        
        /* Ikon di dalam tombol */
        .btn-print i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .btn-print:hover i {
            transform: rotate(-10deg); /* Ikon sedikit berputar saat hover */
        }

        /* Teks di dalam tombol (yang akan muncul saat hover) */
        .btn-print-text {
            display: inline-block;
            max-width: 0;
            overflow: hidden;
            white-space: nowrap;
            vertical-align: middle; /* Memastikan teks sejajar dengan ikon */
            transition: max-width 0.4s ease-in-out;
        }

        /* Mengatur teks agar muncul saat tombol di-hover */
        .btn-print:hover .btn-print-text {
            max-width: 100px; /* Lebar maksimal teks saat muncul */
        }
        
        /* Floating Reminder Button */
        .floating-reminder-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            color: white;
            font-size: 24px;
        }

        .floating-reminder-btn:hover {
            width: 160px;
            border-radius: 35px;
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
        }

        .floating-reminder-btn .btn-icon {
            transition: all 0.3s ease;
            z-index: 2;
        }

        .floating-reminder-btn .btn-text {
            position: absolute;
            right: 20px;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            line-height: 1.2;
        }

        .floating-reminder-btn .btn-text small {
            display: block;
            font-size: 11px;
            font-weight: 400;
            opacity: 0.8;
        }

        .floating-reminder-btn:hover .btn-icon {
            transform: translateX(-30px);
        }

        .floating-reminder-btn:hover .btn-text {
            opacity: 1;
            transform: translateX(0);
        }

        .floating-reminder-btn .btn-pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            70% {
                transform: translate(-50%, -50%) scale(1.4);
                opacity: 0;
            }
            100% {
                transform: translate(-50%, -50%) scale(1.4);
                opacity: 0;
            }
        }

        /* Modal Reminder */
        .reminder-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease;
        }

        .reminder-modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 450px;
            overflow: hidden;
            animation: slideInUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .reminder-modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 25px;
            text-align: center;
        }

        .reminder-modal-header .reminder-icon {
            font-size: 48px;
            margin-bottom: 15px;
            animation: bounce 0.6s ease;
        }

        .reminder-modal-header h4 {
            margin: 0 0 10px 0;
            font-size: 24px;
            font-weight: 600;
        }

        .reminder-modal-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .reminder-modal-body {
            padding: 25px;
        }

        .reminder-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
        }

        .info-value {
            font-weight: 500;
            color: #667eea;
            background: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .reminder-modal-footer {
            padding: 20px 25px;
            display: flex;
            gap: 15px;
            background: #f8f9fa;
        }

        .reminder-modal-footer button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .btn-confirm {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        #action-button-container {
            text-align: center;
            margin-top: 20px;  
        }

        /* ===== SUCCESS NOTIFICATION ===== */
        .success-notification {
            position: fixed;
            top: 24px;
            right: 24px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
            min-width: 320px;
            border: 1px solid #e5e7eb;
        }

        .success-notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .success-content {
            padding: 24px;
            text-align: center;
        }

        .success-content i {
            font-size: 48px;
            color: #10b981;
            margin-bottom: 16px;
            display: block;
        }

        .success-content h4 {
            margin: 0 0 12px 0;
            color: #1f2937;
            font-size: 18px;
            font-weight: 600;
        }

        .success-content p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* ===== ERROR NOTIFICATION (New Style) ===== */
        .error-notification {
            position: fixed;
            top: 24px;
            right: 24px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 400px;
            min-width: 320px;
            border: 1px solid #ef4444; /* Warna border merah untuk error */
        }

        .error-notification.show {
            transform: translateX(0);
            opacity: 1;
        }

        .error-content {
            padding: 24px;
            text-align: center;
        }

        .error-content i {
            font-size: 48px;
            color: #ef4444; /* Warna ikon merah untuk error */
            margin-bottom: 16px;
            display: block;
        }

        .error-content h4 {
            margin: 0 0 12px 0;
            color: #1f2937; /* Warna teks judul tetap gelap */
            font-size: 18px;
            font-weight: 600;
        }

        .error-content p {
            margin: 0;
            color: #6b7280; /* Warna teks deskripsi tetap abu-abu */
            font-size: 14px;
            line-height: 1.6;
        }


        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translate(-50%, -30%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .floating-reminder-btn {
                bottom: 20px;
                right: 20px;
                width: 60px;
                height: 60px;
                font-size: 20px;
            }
            
            .floating-reminder-btn:hover {
                width: 140px;
                border-radius: 30px;
            }
            
            .success-notification, .error-notification {
                top: 15px;
                right: 15px;
                padding: 12px 20px;
            }
        }
        </style>

        @endpush
    @endsection