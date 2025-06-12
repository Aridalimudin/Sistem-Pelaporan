@extends('layouts.main')
@section('title', 'Track Laporan - MTS AR-RIYADL')
@section('content')
    
    <input type="hidden" id="isReporter" value="{{(bool)$reporter}}">
    <!-- Konten Track Laporan (akan otomatis disembunyikan) -->
    <div class="container text-center mt-5" id="trackingPage">
        <div class="tracking-header">
            <h3 class="fw-bold">TRACK LAPORAN ANDA</h3>
            <p>Klik tombol di bawah untuk melacak status laporan Anda</p>
        </div>

        <div class="col-md-6 mx-auto">
            <button class="btn btn-primary btn-track mt-3 w-100" onclick="openTrackingPopup()">
                <i class="fas fa-search me-2"></i>Track Laporan
            </button>
        </div>
    </div>

    <!-- Popup Input Tracking dengan design baru -->
    <div id="trackingPopup" class="popup">
        <div class="popup-content shadow-lg rounded">
            <span class="close" onclick="closePopup()">&times;</span>
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

    <!-- Popup Error Message dengan design baru -->
    <div id="errorPopup" class="popup">
        <div class="error-popup-content">
            <div class="error-icon-container">
                <div class="error-circle">
                    <i class="fas fa-exclamation"></i>
                </div>
            </div>
            <h5 class="error-title">LAPORAN TIDAK DITEMUKAN</h5>
            <p class="error-message">Kode atau laporan tidak tersedia. Silakan periksa kembali kode yang Anda masukkan.</p>
            <button class="error-btn" onclick="closePopup()">
                Tutup
            </button>
        </div>
    </div>

    <!-- Detail Laporan Section dengan design baru -->
    @if((bool)$reporter)
    <div class="container hidden mt-4 mb-5" id="detailPage">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg detail-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">DETAIL LAPORAN</h4>
                        <div class="kode-container">
                            <span>Kode Laporan:</span>
                            <span id="kode-laporan" class="badge bg-light text-primary">{{$reporter->code}}</span>
                        </div>
                    </div>
                    <!-- Tracking Progress Section yang Baru dan Elegant -->
                    <div class="tracking-wrapper">
                    <!-- Progress Timeline -->
                    <div class="progress-timeline">
                        <div class="timeline-line">
                            <div class="timeline-progress" style="width: 50%;"></div>
                        </div>
                        
                        <div class="timeline-steps">
                            <div class="timeline-step completed" data-step="0">
                                <div class="step-circle">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="step-info">
                                    <h6 class="step-title">Terkirim</h6>
                                    <span class="step-time">{{$sendReporter->created_at->format('d M Y')}}</span>
                                </div>
                            </div>

                            <div class="timeline-step completed" data-step="1">
                                <div class="step-circle">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <div class="step-info">
                                    <h6 class="step-title">Diterima</h6>
                                    <span class="step-time">{{$sendReporter->created_at->format('d M Y')}}</span>
                                </div>
                            </div>
                            
                            <div class="timeline-step active current" data-step="2">
                                <div class="step-circle">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="step-info">
                                    <h6 class="step-title">Diverifikasi</h6>
                                    <span class="step-time">{{$sendReporter->created_at->format('d M Y')}}</span>
                                </div>
                            </div>
                            
                            <div class="timeline-step pending" data-step="3">
                                <div class="step-circle">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="step-info">
                                    <h6 class="step-title">Diproses</h6>
                                    <span class="step-time">{{$sendReporter->created_at->format('d M Y')}}</span>
                                </div>
                            </div>
                            
                            <div class="timeline-step pending" data-step="4">
                                <div class="step-circle">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <div class="step-info">
                                    <h6 class="step-title">Selesai</h6>
                                    <span class="step-time">{{$sendReporter->created_at->format('d M Y')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Description Card -->
                    <div class="status-card">
                        <div class="status-header">
                            <div class="status-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="status-title">
                                <h5>Status: Laporan Terkirim</h5>
                                <span class="status-date">{{$sendReporter->created_at->format('d M Y')}}</span>
                            </div>
                        </div>
                        <div class="status-description">
                            <p>>Laporan Anda telah berhasil masuk ke dalam sistem dan mendapatkan kode unik untuk tracking. Tim kami akan segera meninjau laporan yang Anda berikan.</p>
                        </div>
                        <div class="status-progress-bar">
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: 60%;"></div>
                            </div>
                            <span class="progress-text">20% Selesai</span>
                        </div>
                    </div>
                    
                    <!-- Detail Informasi Laporan -->
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
                                                <td><strong>Tanggal Melapor :   </strong></td>
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
                                    <ul class="category-list">
                                        @php
                                            $categoriesArray = explode(',', $categories);
                                        @endphp
                                        @foreach($categoriesArray as $category)
                                            @php
                                                $trimmed = trim($category);
                                                $iconClass = 'icon-default';
                                                
                                                if (stripos($trimmed, 'verbal') !== false) {
                                                    $iconClass = 'icon-verbal';
                                                } elseif (stripos($trimmed, 'fisik') !== false) {
                                                    $iconClass = 'icon-fisik';
                                                } elseif (stripos($trimmed, 'pelecehan') !== false || stripos($trimmed, 'seksual') !== false) {
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
                                <td>Nama Pelaku</td>
                            </tr>
                            <tr>
                                <td><strong>Korban :</strong></td>
                                <td>Nama Korban</td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi Kejadian :</strong></td>
                                <td>Ruang Kelas XII-A</td>
                            </tr>
                            <tr>
                                <td><strong>Waktu Kejadian :</strong></td>
                                <td>18 Feb 2023, 10:30 WIB</td>
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

            <!-- Replace the existing photo evidence section with this -->
            <div class="card info-card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-photo-video me-2"></i>Bukti Foto & Video</h5>
                </div>
                <div class="card-body">
                    <!-- Masonry Container -->
                    <div class="masonry-container">
                        @foreach($reporter->reporterFile as $key => $value)
                            @php
                                $fileExtension = strtolower(pathinfo($value->file, PATHINFO_EXTENSION));
                                $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg']);
                                $fileType = $isVideo ? 'video' : 'image';
                            @endphp
                            
                            <div class="masonry-item {{ $fileType }}" style="--item-index: {{ $key }}" onclick="openLightbox({{ $key }})">
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
                        
                        <!-- Dummy Video Data untuk Testing -->
                        <div class="masonry-item video" style="--item-index: {{ count($reporter->reporterFile) }}" onclick="openLightbox({{ count($reporter->reporterFile) }})">
                            <video class="masonry-video" preload="metadata" muted poster="https://via.placeholder.com/400x300/333/fff?text=Video+Dummy">
                                <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                                Video tidak dapat dimuat
                            </video>
                            <div class="file-type-badge video">
                                <i class="fas fa-play me-1"></i>Video
                            </div>
                        </div>
                        
                        <div class="masonry-item video" style="--item-index: {{ count($reporter->reporterFile) + 1 }}" onclick="openLightbox({{ count($reporter->reporterFile) + 1 }})">
                            <video class="masonry-video" preload="metadata" muted poster="https://via.placeholder.com/400x300/666/fff?text=Video+Demo">
                                <source src="https://sample-videos.com/zip/10/mp4/SampleVideo_1280x720_1mb.mp4" type="video/mp4">
                                Video tidak dapat dimuat
                            </video>
                            <div class="file-type-badge video">
                                <i class="fas fa-play me-1"></i>Video
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Lightbox dengan Video Support -->
            <div id="lightbox" class="lightbox" onclick="closeLightbox(event)">
                <div class="lightbox-content">
                    <button class="lightbox-close" onclick="closeLightbox()" title="Tutup">
                        <i class="fas fa-times"></i>
                    </button>
                    <button class="lightbox-nav lightbox-prev" onclick="prevMedia()" title="Media Sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="lightbox-nav lightbox-next" onclick="nextMedia()" title="Media Selanjutnya">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    
                    <!-- Loading Spinner -->
                    <div id="lightbox-loading" class="lightbox-loading" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                    
                    <!-- Image Display -->
                    <img id="lightbox-image" class="lightbox-image" src="" alt="" style="display: none;">
                    
                    <!-- Video Display -->
                    <video id="lightbox-video" class="lightbox-video" controls preload="metadata" style="display: none;">
                        <source id="lightbox-video-source" src="" type="">
                        Browser Anda tidak mendukung pemutar video.
                    </video>
                    
                    <div class="lightbox-counter">
                        <span id="current-media">1</span> / <span id="total-media">{{ count($reporter->reporterFile) + 2 }}</span>
                    </div>
                    
                    <!-- Video Controls (Optional) -->
                    <div id="lightbox-video-controls" class="lightbox-video-controls" style="display: none;">
                        <button class="video-control-btn" onclick="toggleVideoPlayPause()" title="Play/Pause">
                            <i id="play-pause-icon" class="fas fa-play"></i>
                        </button>
                        <button class="video-control-btn" onclick="toggleVideoMute()" title="Mute/Unmute">
                            <i id="mute-icon" class="fas fa-volume-up"></i>
                        </button>
                        <button class="video-control-btn" onclick="toggleVideoFullscreen()" title="Fullscreen">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
            </div>
                                    
                                    <div class="text-center mt-4">
                                        <button class="btn btn-primary px-5" onclick="backToTracking()">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Tracking
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

@push('styles')
<link rel="stylesheet" href="{{asset('css/style_track.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('scripts')
<script>
// Fungsi untuk mendeteksi jika halaman diakses dari navbar
document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah ada parameter di URL yang menunjukkan akses dari navbar
    const urlParams = new URLSearchParams(window.location.search);
    const fromNav = urlParams.get('fromNav');
    
    // Otomatis buka popup saat halaman dimuat jika dari navbar
    // Jika tidak ada parameter spesifik, gunakan otomatis buka popup
    if($("#isReporter").val() == ""){
        openTrackingPopup();
        $("#detailPage").addClass('hidden');
        $("#trackingPage").removeClass('hidden');
    }else{
        $("#detailPage").removeClass('hidden');
        $("#trackingPage").addClass('hidden');
    }

});

// Fungsi untuk membuka popup tracking
function openTrackingPopup() {
    document.getElementById('trackingPopup').style.display = 'flex';
    document.getElementById('trackingCode').focus();
    // Reset pesan error jika ada
    document.getElementById('errorMessage').style.display = 'none';
    document.getElementById('trackingCode').classList.remove('is-invalid');
}

// Fungsi untuk menutup semua popup
function closePopup() {
    const popups = document.querySelectorAll('.popup');
    popups.forEach(popup => {
        popup.style.display = 'none';
    });
}

// Fungsi untuk memeriksa kode tracking
function checkTrackingCode() {
    const trackingCode = document.getElementById('trackingCode').value.trim();
    
    if (!trackingCode) {
        // Tampilkan pesan error inline saja
        document.getElementById('errorMessage').style.display = 'block';
        document.getElementById('trackingCode').classList.add('is-invalid');
        document.getElementById('trackingCode').focus();
        return;
    }
    
    // Hapus pesan error jika ada
    document.getElementById('errorMessage').style.display = 'none';
    document.getElementById('trackingCode').classList.remove('is-invalid');
    
    // Pastikan kode dimulai dengan "HTC-" untuk valid
    if (trackingCode.toUpperCase().startsWith('HTC-')) {
        // Tutup popup tracking
        closePopup();
        
        // Tampilkan halaman detail dan sembunyikan halaman tracking
        document.getElementById('trackingPage').style.display = 'none';
        document.getElementById('detailPage').style.display = 'block';
        
        // Update kode laporan di halaman detail
        document.getElementById('kode-laporan').textContent = trackingCode;
        
        // Animasi untuk halaman detail
        document.getElementById('detailPage').classList.add('fade-in');
        
        // Scrolling ke atas halaman
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        // Tutup popup tracking
        closePopup();
        
        // Tampilkan popup error
        document.getElementById('errorPopup').style.display = 'flex';
    }

    $("#form-track").submit();
}

// Fungsi untuk kembali ke halaman tracking
function backToTracking() {
    document.getElementById('detailPage').style.display = 'none';
    document.getElementById('trackingPage').style.display = 'block';
    
    // Reset input tracking code
    document.getElementById('trackingCode').value = '';
    
    // Buka kembali popup tracking
    openTrackingPopup();
}

// Menambahkan event listener untuk keyboard
document.addEventListener('keydown', function(event) {
    // Tutup popup dengan tombol Escape
    if (event.key === 'Escape') {
        closePopup();
    }
    
    // Submit tracking code dengan tombol Enter saat di input field
    if (event.key === 'Enter' && document.activeElement === document.getElementById('trackingCode')) {
        checkTrackingCode();
    }
});
</script>

    <script>
        // Data untuk setiap step dengan informasi lengkap
            const trackingSteps = {
                0: {
                    title: "Terkirim",
                    status: "Laporan Terkirim",
                    date: "19 Februari 2023",
                    description: "Laporan Anda telah berhasil masuk ke dalam sistem dan mendapatkan kode unik untuk tracking. Tim kami akan segera meninjau laporan yang Anda berikan.",
                    icon: "fas fa-paper-plane",
                    progress: 20
                },
                1: {
                    title: "Diterima", 
                    status: "Laporan Diterima",
                    date: "20 Februari 2023",
                    description: "Laporan Anda telah diterima. Silakan lengkapi dokumen lainnya agar laporan Anda bisa melanjutkan ke proses verifikasi.",
                    icon: "fas fa-clipboard-check",
                    progress: 40,
                    hasAction: true, 
                    actionText: "Lengkapi Dokumen", 
                    actionType: "complete_documents" 
                },
                2: {
                    title: "Diverifikasi",
                    status: "Diverifikasi", 
                    date: "21 Februari 2023",
                    description: "Laporan Anda telah melalui proses verifikasi dan dinyatakan valid. Semua informasi yang diperlukan telah lengkap dan laporan akan segera diteruskan ke tahap penanganan selanjutnya.",
                    icon: "fas fa-check-circle",
                    progress: 60
                },
                3: {
                    title: "Diproses",
                    status: "Sedang Diproses",
                    date: "-",
                    description: "Laporan sedang dalam tahap penanganan oleh tim yang berwenang. Investigasi mendalam sedang dilakukan untuk menindaklanjuti kasus yang Anda laporkan.",
                    icon: "fas fa-cogs", 
                    progress: 80
                },
                4: {
                    title: "Selesai",
                    status: "Selesai Ditangani",
                    date: "-", 
                    description: "Laporan Anda telah selesai ditangani. Tindakan yang diperlukan telah dilakukan sesuai dengan kebijakan dan prosedur yang berlaku. Terima kasih atas partisipasi Anda.",
                    icon: "fas fa-flag-checkered",
                    progress: 100
                }
            };

            // Store the original current step to maintain timeline integrity
            let originalCurrentStep = 0;

            // Fixed function to update status card only without changing timeline state
            function updateStatusCardOnly(stepNumber) {
                const stepData = trackingSteps[stepNumber];
                if (!stepData) return;
                
                const statusCard = document.querySelector('.status-card');
                statusCard.classList.add('loading');
                
                setTimeout(() => {
                    // Update status header
                    const statusIcon = document.querySelector('.status-icon i');
                    const statusTitle = document.querySelector('.status-title h5');
                    const statusDate = document.querySelector('.status-date');
                    const statusDescription = document.querySelector('.status-description p');
                    const progressBar = document.querySelector('.progress-bar-fill');
                    const progressText = document.querySelector('.progress-text');
                    
                    if (statusIcon) statusIcon.className = stepData.icon;
                    if (statusTitle) statusTitle.textContent = `Status: ${stepData.status}`;
                    if (statusDate) statusDate.textContent = stepData.date;
                    if (statusDescription) statusDescription.textContent = stepData.description;
                    if (progressBar) progressBar.style.width = `${stepData.progress}%`;
                    if (progressText) progressText.textContent = `${stepData.progress}% Selesai`;

                    updateActionButton(stepData);
                    
                    statusCard.classList.remove('loading');
                }, 300);
            }

            // Function to update the actual timeline state (for real progress changes)
            function updateStatusCard(stepNumber) {
                const stepData = trackingSteps[stepNumber];
                if (!stepData) return;
                
                const statusCard = document.querySelector('.status-card');
                statusCard.classList.add('loading');
                
                setTimeout(() => {
                    // Update status header
                    const statusIcon = document.querySelector('.status-icon i');
                    const statusTitle = document.querySelector('.status-title h5');
                    const statusDate = document.querySelector('.status-date');
                    const statusDescription = document.querySelector('.status-description p');
                    const progressBar = document.querySelector('.progress-bar-fill');
                    const progressText = document.querySelector('.progress-text');
                    
                    if (statusIcon) statusIcon.className = stepData.icon;
                    if (statusTitle) statusTitle.textContent = `Status: ${stepData.status}`;
                    if (statusDate) statusDate.textContent = stepData.date;
                    if (statusDescription) statusDescription.textContent = stepData.description;
                    if (progressBar) progressBar.style.width = `${stepData.progress}%`;
                    if (progressText) progressText.textContent = `${stepData.progress}% Selesai`;
                    
                    // Update timeline progress for real state changes
                    const timelineProgress = document.querySelector('.timeline-progress');
                    if (timelineProgress) timelineProgress.style.width = `${stepNumber * 25}%`;

                    // Update timeline steps title and date
                    updateTimelineStepsInfo(stepNumber);

                    // Tambahkan tombol action jika ada
                    updateActionButton(stepData);
                    
                    statusCard.classList.remove('loading');
                }, 300);
            }

            // Function baru untuk update informasi timeline steps
            function updateTimelineStepsInfo(currentStep) {
                document.querySelectorAll('.timeline-step').forEach((step, index) => {
                    const stepData = trackingSteps[index];
                    if (stepData) {
                        const stepTitle = step.querySelector('.step-title');
                        const stepTime = step.querySelector('.step-time');
                        const stepIcon = step.querySelector('.step-circle i');
                        
                        if (stepTitle) stepTitle.textContent = stepData.title;
                        if (stepTime) stepTime.textContent = stepData.date;
                        if (stepIcon) stepIcon.className = stepData.icon;
                    }
                });
            }

            // Function baru untuk menambah/menghapus tombol action
            function updateActionButton(stepData) {
                // Hapus tombol action yang sudah ada
                const existingButton = document.querySelector('.status-action-button');
                if (existingButton) {
                    existingButton.remove();
                }
                
                // Tambahkan tombol jika step memiliki action
                if (stepData.hasAction) {
                    const statusCard = document.querySelector('.status-card');
                    const actionButton = document.createElement('div');
                    actionButton.className = 'status-action-button';
                    actionButton.innerHTML = `
                        <button class="btn-complete-documents" onclick="showCompleteDocumentsForm()">
                            <i class="fas fa-plus-circle"></i>
                            ${stepData.actionText}
                        </button>
                    `;
                    statusCard.appendChild(actionButton);
                }
            }

            // Fixed function to handle step clicks without breaking the timeline
            function handleStepClick(stepElement, stepNumber) {
                // Only allow clicks on completed or active steps
                if (!stepElement.classList.contains('completed') && !stepElement.classList.contains('active')) {
                    return;
                }
                
                // Remove current class from all steps TEMPORARILY for visual feedback
                document.querySelectorAll('.timeline-step').forEach(step => {
                    step.classList.remove('current');
                });
                
                // Add current class to clicked step TEMPORARILY
                stepElement.classList.add('current');
                
                // Update status card with the clicked step data
                updateStatusCardOnly(stepNumber);
                
                // DON'T restore original step states immediately - let user see the clicked step info
                // The restoration will happen when they click on the actual current step or after some time
                
                // Smooth scroll to status card
                document.querySelector('.status-card').scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
                
                // Add ripple effect
                createRippleEffect(stepElement);
                
                // Set a flag to remember we're in "preview mode"
                window.isPreviewMode = true;
                
                // Auto-restore after 10 seconds or when user clicks current step
                setTimeout(() => {
                    if (window.isPreviewMode) {
                        restoreToCurrentStep();
                    }
                }, 10000);
            }

            // New function to restore to current step
            function restoreToCurrentStep() {
                window.isPreviewMode = false;
                
                // Restore visual states
                restoreOriginalStepStates();
                
                // Restore status card to current step
                updateStatusCardOnly(originalCurrentStep);
            }

            // Function to restore original step states
            function restoreOriginalStepStates() {
                document.querySelectorAll('.timeline-step').forEach((step, index) => {
                    const stepNumber = index;
                    
                    // Clear all state classes first
                    step.classList.remove('completed', 'active', 'current', 'pending');
                    
                    // Set proper states based on original current step
                    if (stepNumber < originalCurrentStep) {
                        step.classList.add('completed');
                    } else if (stepNumber === originalCurrentStep) {
                        step.classList.add('active', 'current');
                    } else {
                        step.classList.add('pending');
                    }
                });
                
                // Also update the status card back to current step if we're not in preview mode
                if (!window.isPreviewMode) {
                    updateStatusCardOnly(originalCurrentStep);
                }
            }

            // Function to create ripple effect
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

            // CSS for ripple animation
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

            // Function to initialize tracking
            function initializeElegantTracking(currentStep = 0) {
                currentStep = parseInt(currentStep);
                originalCurrentStep = currentStep;
                window.isPreviewMode = false; // Initialize preview mode flag
                updateTrackingSteps(currentStep);
                updateStatusCard(currentStep);
                
                // Add event listeners for each step
                document.querySelectorAll('.timeline-step').forEach((step, index) => {
                    const stepNumber = index;
                    
                    step.addEventListener('click', () => {
                        // If clicking on current step while in preview mode, restore to current
                        if (stepNumber === originalCurrentStep && window.isPreviewMode) {
                            restoreToCurrentStep();
                        } else {
                            handleStepClick(step, stepNumber);
                        }
                    });
                    
                    // Add hover effects only for clickable steps
                    if (step.classList.contains('completed') || step.classList.contains('active')) {
                        step.style.cursor = 'pointer';
                        step.setAttribute('title', `Klik untuk melihat detail: ${trackingSteps[stepNumber].title}`);
                        
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
                
                // Add click listener to status card to restore current step when clicked
                document.querySelector('.status-card').addEventListener('click', (e) => {
                    // Only restore if we're in preview mode and not clicking on action buttons
                    if (window.isPreviewMode && !e.target.closest('.status-action-button')) {
                        restoreToCurrentStep();
                    }
                });
            }

            // Function to update step states properly
            function updateTrackingSteps(currentStep) {
                document.querySelectorAll('.timeline-step').forEach((step, index) => {
                    const stepNumber = index;
                    step.classList.remove('completed', 'active', 'current', 'pending');
                    
                    if (stepNumber < currentStep) {
                        step.classList.add('completed');
                    } else if (stepNumber === currentStep) {
                        step.classList.add('active', 'current');
                    } else {
                        step.classList.add('pending');
                    }
                });
            }

            // Function for step change animation (for real progress updates)
            function animateStepChange(newStep) {
                originalCurrentStep = newStep;
                const statusCard = document.querySelector('.status-card');
                const timeline = document.querySelector('.progress-timeline');
                
                // Animation fade out
                statusCard.style.transform = 'translateY(20px)';
                statusCard.style.opacity = '0.7';
                timeline.style.transform = 'scale(0.98)';
                timeline.style.opacity = '0.8';
                
                setTimeout(() => {
                    updateTrackingSteps(newStep);
                    updateStatusCard(newStep);
                    
                    // Animation fade in
                    statusCard.style.transform = 'translateY(0)';
                    statusCard.style.opacity = '1';
                    timeline.style.transform = 'scale(1)';
                    timeline.style.opacity = '1';
                }, 300);
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize dengan status dari server (0 = Terkirim, 1 = Diterima, dst)
                initializeElegantTracking("{{intval($reporter?->status ?? 0)}}");
            });

            function showCompleteDocumentsForm() {
            // Buat modal overlay
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay';
            modalOverlay.innerHTML = `
                <div class="modal-content wizard-modal">
                    <div class="modal-header">
                        <h4><i class="fas fa-file-upload"></i> Lengkapi Laporan Kejadian</h4>
                        <button class="modal-close" onclick="closeCompleteDocumentsForm()">&times;</button>
                    </div>
                    <div class="step-progress">
                        <!-- Progress Line Background -->
                        <div class="progress-line">
                            <div class="progress-fill" style="width: 0%;"></div>
                        </div>
                        
                        <!-- Container untuk semua step -->
                        <div class="steps-container">
                            <!-- Step 1 -->
                            <div class="step-indicator active" data-step="1">
                                <div class="step-number">1</div>
                                <div class="step-label">Waktu Kejadian</div>
                            </div>
                            
                            <!-- Step 2 -->
                            <div class="step-indicator" data-step="2">
                                <div class="step-number">2</div>
                                <div class="step-label">Pihak Terlibat</div>
                            </div>
                            
                            <!-- Step 3 -->
                            <div class="step-indicator" data-step="3">
                                <div class="step-number">3</div>
                                <div class="step-label">Tindakan</div>
                            </div>
                            
                            <!-- Step 4 -->
                            <div class="step-indicator" data-step="4">
                                <div class="step-number">4</div>
                                <div class="step-label">Bukti</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form id="completeDocumentsForm">
                            <!-- Step 1: Waktu Kejadian -->
                            <div class="form-step active" data-step="1">
                                <div class="step-header">
                                    <h5><i class="fas fa-clock"></i> Waktu Kejadian</h5>
                                    <p>Berikan informasi waktu dan lokasi terjadinya kejadian</p>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group half-width">
                                        <label for="incidentDate">Tanggal Kejadian *</label>
                                        <input type="date" id="incidentDate" name="incidentDate" required>
                                    </div>
                                    <div class="form-group half-width">
                                        <label for="incidentTime">Jam Kejadian *</label>
                                        <input type="time" id="incidentTime" name="incidentTime" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="incidentLocation">Lokasi Kejadian *</label>
                                    <textarea id="incidentLocation" name="incidentLocation" rows="4" placeholder="Sebutkan lokasi lengkap tempat kejadian..." required></textarea>
                                </div>
                            </div>

                            <!-- Step 2: Pihak Terlibat -->
                            <div class="form-step" data-step="2">
                                <div class="step-header">
                                    <h5><i class="fas fa-users"></i> Pihak yang Terlibat</h5>
                                    <p>Identifikasi semua pihak yang terlibat dalam kejadian</p>
                                </div>
                                
                                <div class="form-group">
                                    <label for="victimName">Nama Korban *</label>
                                    <input type="text" id="victimName" name="victimName" placeholder="Nama lengkap korban" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="victimClass">Kelas Korban *</label>
                                    <input type="text" id="victimClass" name="victimClass" placeholder="Contoh: XII IPA 1, Staff, Guru, dll." required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="perpetratorName">Nama Pelaku *</label>
                                    <input type="text" id="perpetratorName" name="perpetratorName" placeholder="Nama lengkap pelaku" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="perpetratorClass">Kelas/Status Pelaku *</label>
                                    <input type="text" id="perpetratorClass" name="perpetratorClass" placeholder="Contoh: XI IPS 2, Staff, Guru, dll." required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="witnessName">Nama Saksi (Jika Ada)</label>
                                    <textarea id="witnessName" name="witnessName" rows="3" placeholder="Sebutkan nama saksi dan kelas/statusnya jika ada..."></textarea>
                                </div>
                            </div>

                            <!-- Step 3: Tindakan yang Diharapkan -->
                            <div class="form-step" data-step="3">
                                <div class="step-header">
                                    <h5><i class="fas fa-clipboard-check"></i> Tindakan yang Diharapkan</h5>
                                    <p>Jelaskan tindakan atau solusi yang Anda harapkan</p>
                                </div>
                                
                                <div class="form-group">
                                    <label for="expectedAction">Tindakan yang Diharapkan *</label>
                                    <textarea id="expectedAction" name="expectedAction" rows="6" placeholder="Jelaskan tindakan atau solusi yang Anda harapkan dari pihak sekolah..." required></textarea>
                                </div>
                            </div>

                            <!-- Step 4: Bukti Tambahan -->
                            <div class="form-step" data-step="4">
                                <div class="step-header">
                                    <h5><i class="fas fa-paperclip"></i> Bukti Tambahan</h5>
                                    <p>Tambahkan informasi dan dokumen pendukung</p>
                                </div>
                                
                                <div class="form-group">
                                    <label for="additionalInfo">Informasi Tambahan</label>
                                    <textarea id="additionalInfo" name="additionalInfo" rows="4" placeholder="Berikan informasi tambahan terkait kejadian..."></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="supportingDocuments">Dokumen/Foto Pendukung</label>
                                    <div class="file-upload-area">
                                        <input type="file" id="supportingDocuments" name="supportingDocuments" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <div class="file-upload-text">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <p>Klik untuk pilih file atau drag & drop</p>
                                            <small>Format: PDF, DOC, DOCX, JPG, PNG (Max 5MB per file)</small>
                                        </div>
                                    </div>
                                    <div id="file-list"></div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="checkbox-group">
                                        <input type="checkbox" id="confirmData" name="confirmData" required>
                                        <label for="confirmData">Saya menyatakan bahwa semua informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="modal-footer wizard-footer">
                        <button type="button" class="btn-back" onclick="previousStep()" style="display: none;">
                            <i class="fas fa-arrow-left"></i>
                            Sebelumnya
                        </button>
                        <button type="button" class="btn-cancel" onclick="closeCompleteDocumentsForm()">Batal</button>
                        <button type="button" class="btn-next" onclick="nextStep()">
                            Selanjutnya
                            <i class="fas fa-arrow-right"></i>
                        </button>
                        <button type="submit" class="btn-submit" onclick="submitCompleteDocuments()" style="display: none;">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Laporan
                        </button>
                    </div>
                </div>
            `;
                    
                    document.body.appendChild(modalOverlay);
                    // Step 1 active
                    document.querySelector('.progress-fill').style.width = '0%';
                    // Step 2 active  
                    document.querySelector('.progress-fill').style.width = '33%';
                    // Step 3 active
                    document.querySelector('.progress-fill').style.width = '66%';
                    // Step 4 active
                    document.querySelector('.progress-fill').style.width = '100%';
                    
                    // Add event listener untuk file upload
                    setupFileUpload();
                    // Initialize wizard
                    initializeWizard();
                    
                    // Set max date to today for incident date
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('incidentDate').max = today;
                    
                    // Animate modal
                    setTimeout(() => {
                        modalOverlay.classList.add('show');
                    }, 10);
                }

                let currentWizardStep = 1;
                const totalSteps = 4;

                function initializeWizard() {
            currentWizardStep = 1;
            updateStepIndicator();
            setupFileUpload();
        }

        function nextStep() {
            if (!validateCurrentStep()) {
                return;
            }
            
            if (currentWizardStep < totalSteps) {
                document.querySelector(`.form-step[data-step="${currentWizardStep}"]`).classList.remove('active');
                currentWizardStep++;
                
                setTimeout(() => {
                    document.querySelector(`.form-step[data-step="${currentWizardStep}"]`).classList.add('active');
                    updateStepIndicator();
                    updateNavigationButtons();
                }, 150);
            }
        }

        function previousStep() {
            if (currentWizardStep > 1) {
                document.querySelector(`.form-step[data-step="${currentWizardStep}"]`).classList.remove('active');
                currentWizardStep--;
                
                setTimeout(() => {
                    document.querySelector(`.form-step[data-step="${currentWizardStep}"]`).classList.add('active');
                    updateStepIndicator();
                    updateNavigationButtons();
                }, 150);
            }
        }

        function updateStepIndicator() {
            document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
                const stepNumber = index + 1;
                indicator.classList.remove('active', 'completed');
                
                if (stepNumber < currentWizardStep) {
                    indicator.classList.add('completed');
                } else if (stepNumber === currentWizardStep) {
                    indicator.classList.add('active');
                }
            });
            
            const progressFill = document.querySelector('.progress-fill');
            const progressPercentage = ((currentWizardStep - 1) / (totalSteps - 1)) * 100;
            progressFill.style.width = progressPercentage + '%';
        }

        function updateNavigationButtons() {
            const btnBack = document.querySelector('.btn-back');
            const btnNext = document.querySelector('.btn-next');
            const btnSubmit = document.querySelector('.btn-submit');
            
            btnBack.style.display = currentWizardStep > 1 ? 'inline-flex' : 'none';
            
            if (currentWizardStep === totalSteps) {
                btnNext.style.display = 'none';
                btnSubmit.style.display = 'inline-flex';
            } else {
                btnNext.style.display = 'inline-flex';
                btnSubmit.style.display = 'none';
            }
        }

        function validateCurrentStep() {
            const currentStepElement = document.querySelector(`.form-step[data-step="${currentWizardStep}"]`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            
            for (let field of requiredFields) {
                if (!field.value.trim()) {
                    field.focus();
                    field.classList.add('error');
                    
                    setTimeout(() => {
                        field.classList.remove('error');
                    }, 3000);
                    
                    showErrorMessage('Mohon lengkapi semua field yang wajib diisi');
                    return false;
                }
            }
            
            return true;
        }

        function showErrorMessage(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-circle"></i>
                ${message}
            `;
            
            const modalBody = document.querySelector('.modal-body');
            modalBody.insertBefore(errorDiv, modalBody.firstChild);
            
            setTimeout(() => {
                errorDiv.remove();
            }, 3000);
        }

        // Function untuk setup file upload
        function setupFileUpload() {
            const fileInput = document.getElementById('supportingDocuments');
            const fileList = document.getElementById('file-list');
            
            if (!fileInput || !fileList) return;
            
            fileInput.addEventListener('change', function(e) {
                displaySelectedFiles(e.target.files);
            });
            
            // Drag and drop functionality
            const uploadArea = document.querySelector('.file-upload-area');
            
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('drag-over');
            });
            
            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('drag-over');
            });
            
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('drag-over');
                const files = e.dataTransfer.files;
                fileInput.files = files;
                displaySelectedFiles(files);
            });
        }

        // Function untuk menampilkan file yang dipilih
        function displaySelectedFiles(files) {
            const fileList = document.getElementById('file-list');
            if (!fileList) return;
            
            fileList.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                const fileItem = document.createElement('div');
                fileItem.className = 'file-item';
                fileItem.innerHTML = `
                    <div class="file-info">
                        <i class="fas fa-file"></i>
                        <span class="file-name">${file.name}</span>
                        <span class="file-size">(${formatFileSize(file.size)})</span>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                fileList.appendChild(fileItem);
            });
        }

        // Function untuk format ukuran file
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Function untuk menghapus file
        function removeFile(index) {
            const fileInput = document.getElementById('supportingDocuments');
            if (!fileInput) return;
            
            const dt = new DataTransfer();
            const files = Array.from(fileInput.files);
            
            files.splice(index, 1);
            files.forEach(file => dt.items.add(file));
            
            fileInput.files = dt.files;
            displaySelectedFiles(fileInput.files);
        }

        // Function untuk menutup form
        function closeCompleteDocumentsForm() {
            const modalOverlay = document.querySelector('.modal-overlay');
            if (modalOverlay) {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
            }
        }

        // Function untuk submit form
        function submitCompleteDocuments() {
            const form = document.getElementById('completeDocumentsForm');
            if (!form) return;
            
            // Validasi form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Simulasi proses submit
            const submitBtn = document.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;
            
            // Simulasi API call
            setTimeout(() => {
                // Success
                showSuccessMessage();
                closeCompleteDocumentsForm();
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
            }, 2000);
        }

        // Function untuk menampilkan pesan sukses
        function showSuccessMessage() {
            const successMessage = document.createElement('div');
            successMessage.className = 'success-notification';
            successMessage.innerHTML = `
                <div class="success-content">
                    <i class="fas fa-check-circle"></i>
                    <h4>Laporan Berhasil Dikirim!</h4>
                    <p>Terima kasih telah melengkapi laporan kejadian. Tim kami akan segera memproses laporan Anda dan mengambil tindakan yang diperlukan.</p>
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
                }, 300);
            }, 5000);
        }

        // Export functions
        window.showCompleteDocumentsForm = showCompleteDocumentsForm;
        window.closeCompleteDocumentsForm = closeCompleteDocumentsForm;
        window.submitCompleteDocuments = submitCompleteDocuments;
        window.initializeElegantTracking = initializeElegantTracking;
        window.animateStepChange = animateStepChange;
        window.updateStatusCard = updateStatusCard;
    </script>
    <script>
        // Demo: Simulasi data categories
        const categories = "Bullying Verbal,Bullying Fisik,Pelecehan Seksual Verbal,Pelecehan Seksual Fisik";
        
        // Function untuk generate category list dengan icon
        function generateCategoryList(categoriesString) {
            const categoryList = document.getElementById('categoryList');
            const categoriesArray = categoriesString.split(',');
            
            categoryList.innerHTML = '';
            
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

        // Function untuk generate badges
        function generateBadges(categoriesString) {
            const badgeContainer = document.getElementById('badgeContainer');
            const categoriesArray = categoriesString.split(',');
            
            badgeContainer.innerHTML = '';
            
            categoriesArray.forEach(category => {
                const trimmedCategory = category.trim();
                const badgeClass = getBadgeClass(trimmedCategory);
                
                const badge = document.createElement('span');
                badge.className = `category-badge ${badgeClass}`;
                badge.textContent = trimmedCategory;
                
                badgeContainer.appendChild(badge);
            });
        }
        
        // Function untuk menentukan class icon berdasarkan kategori
        function getIconClass(category) {
            const lowerCategory = category.toLowerCase();
            
            if (lowerCategory.includes('bullying') && lowerCategory.includes('verbal')) {
                return 'icon-bullying-verbal';
            } else if (lowerCategory.includes('bullying') && lowerCategory.includes('fisik')) {
                return 'icon-bullying-fisik';
            } else if (lowerCategory.includes('pelecehan') && lowerCategory.includes('verbal')) {
                return 'icon-pelecehan-verbal';
            } else if (lowerCategory.includes('pelecehan') && lowerCategory.includes('fisik')) {
                return 'icon-pelecehan-fisik';
            } else {
                return 'icon-default';
            }
        }

        // Function untuk menentukan symbol icon
        function getIconSymbol(category) {
            const lowerCategory = category.toLowerCase();
            
            if (lowerCategory.includes('bullying') && lowerCategory.includes('verbal')) {
                return '💬';
            } else if (lowerCategory.includes('bullying') && lowerCategory.includes('fisik')) {
                return '👊';
            } else if (lowerCategory.includes('pelecehan') && lowerCategory.includes('verbal')) {
                return '🗣️';
            } else if (lowerCategory.includes('pelecehan') && lowerCategory.includes('fisik')) {
                return '⚠️';
            } else {
                return '📋';
            }
        }

        // Function untuk badge class
        function getBadgeClass(category) {
            const lowerCategory = category.toLowerCase();
            
            if (lowerCategory.includes('bullying') && lowerCategory.includes('verbal')) {
                return 'bullying-verbal';
            } else if (lowerCategory.includes('bullying') && lowerCategory.includes('fisik')) {
                return 'bullying-fisik';
            } else if (lowerCategory.includes('pelecehan') && lowerCategory.includes('verbal')) {
                return 'pelecehan-verbal';
            } else if (lowerCategory.includes('pelecehan') && lowerCategory.includes('fisik')) {
                return 'pelecehan-fisik';
            } else {
                return 'bullying-verbal'; // default
            }
        }
        
        // Generate list dan badges saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            generateCategoryList(categories);
            generateBadges(categories);
        });

// Lightbox functionality
let currentImageIndex = 0;
let images = [];

// Initialize images array
document.addEventListener('DOMContentLoaded', function() {
    const imageElements = document.querySelectorAll('.masonry-image');
    images = Array.from(imageElements).map(img => ({
        src: img.src,
        alt: img.alt
    }));
    
    document.getElementById('total-images').textContent = images.length;
});

function openLightbox(index) {
    currentImageIndex = index;
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    
    lightboxImage.classList.remove('loaded');
    lightboxImage.src = images[index].src;
    lightboxImage.alt = images[index].alt;
    
    // Update counter
    document.getElementById('current-image').textContent = index + 1;
    
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Add loaded class when image is loaded
    lightboxImage.onload = function() {
        this.classList.add('loaded');
    };
}

function closeLightbox(event) {
    if (event && event.target !== event.currentTarget && !event.target.classList.contains('lightbox-close')) {
        return;
    }
    
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    openLightbox(currentImageIndex);
}

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    openLightbox(currentImageIndex);
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (lightbox.classList.contains('active')) {
        switch(e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                prevImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
        }
    }
});
// Enhanced Lightbox with Video Support
let currentMediaIndex = 0;
let mediaFiles = [];
let isVideoPlaying = false;

// Initialize media files data
document.addEventListener('DOMContentLoaded', function() {
    // Collect all media files from the masonry container
    const masonryItems = document.querySelectorAll('.masonry-item');
    mediaFiles = [];
    
    masonryItems.forEach((item, index) => {
        const isVideo = item.classList.contains('video');
        let mediaSrc = '';
        let mediaType = '';
        
        if (isVideo) {
            const video = item.querySelector('video source');
            mediaSrc = video ? video.src : '';
            mediaType = video ? video.type : 'video/mp4';
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
    
    // Update total media counter
    document.getElementById('total-media').textContent = mediaFiles.length;
});

function openLightbox(index) {
    currentMediaIndex = index;
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxVideo = document.getElementById('lightbox-video');
    const lightboxVideoSource = document.getElementById('lightbox-video-source');
    const loading = document.getElementById('lightbox-loading');
    const videoControls = document.getElementById('lightbox-video-controls');
    
    // Show lightbox
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Show loading
    loading.style.display = 'block';
    lightboxImage.style.display = 'none';
    lightboxVideo.style.display = 'none';
    videoControls.style.display = 'none';
    
    // Reset video state
    lightboxVideo.pause();
    isVideoPlaying = false;
    updatePlayPauseIcon();
    
    const currentMedia = mediaFiles[index];
    
    if (currentMedia.isVideo) {
        // Load video
        lightboxVideoSource.src = currentMedia.src;
        lightboxVideoSource.type = currentMedia.type;
        lightboxVideo.load();
        
        lightboxVideo.addEventListener('loadstart', function() {
            loading.style.display = 'block';
        });
        
        lightboxVideo.addEventListener('canplay', function() {
            loading.style.display = 'none';
            lightboxVideo.style.display = 'block';
            lightboxVideo.classList.add('loaded');
            videoControls.style.display = 'flex';
        });
        
        lightboxVideo.addEventListener('error', function() {
            loading.style.display = 'none';
            console.error('Error loading video:', currentMedia.src);
        });
        
    } else {
        // Load image
        lightboxImage.src = currentMedia.src;
        lightboxImage.classList.remove('loaded');
        
        lightboxImage.onload = function() {
            loading.style.display = 'none';
            lightboxImage.style.display = 'block';
            lightboxImage.classList.add('loaded');
        };
        
        lightboxImage.onerror = function() {
            loading.style.display = 'none';
            console.error('Error loading image:', currentMedia.src);
        };
    }
    
    // Update counter
    document.getElementById('current-media').textContent = index + 1;
    
    // Keyboard navigation
    document.addEventListener('keydown', handleKeyboardNavigation);
}

function closeLightbox(event) {
    if (event && event.target !== event.currentTarget && 
        !event.target.classList.contains('lightbox-close')) {
        return;
    }
    
    const lightbox = document.getElementById('lightbox');
    const lightboxVideo = document.getElementById('lightbox-video');
    
    // Pause video if playing
    if (lightboxVideo.style.display === 'block') {
        lightboxVideo.pause();
    }
    
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
    
    // Clean up
    setTimeout(() => {
        document.getElementById('lightbox-image').style.display = 'none';
        document.getElementById('lightbox-video').style.display = 'none';
        document.getElementById('lightbox-video-controls').style.display = 'none';
        document.getElementById('lightbox-image').classList.remove('loaded');
        document.getElementById('lightbox-video').classList.remove('loaded');
    }, 300);
    
    // Remove keyboard listener
    document.removeEventListener('keydown', handleKeyboardNavigation);
}

function nextMedia() {
    if (currentMediaIndex < mediaFiles.length - 1) {
        openLightbox(currentMediaIndex + 1);
    } else {
        openLightbox(0); // Loop to first
    }
}

function prevMedia() {
    if (currentMediaIndex > 0) {
        openLightbox(currentMediaIndex - 1);
    } else {
        openLightbox(mediaFiles.length - 1); // Loop to last
    }
}

function handleKeyboardNavigation(e) {
    switch(e.key) {
        case 'Escape':
            closeLightbox();
            break;
        case 'ArrowRight':
            nextMedia();
            break;
        case 'ArrowLeft':
            prevMedia();
            break;
        case ' ':
            e.preventDefault();
            if (document.getElementById('lightbox-video').style.display === 'block') {
                toggleVideoPlayPause();
            }
            break;
    }
}

// Video Control Functions
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

// Enhanced Touch/Swipe Support
let touchStartX = 0;
let touchEndX = 0;
let touchStartY = 0;
let touchEndY = 0;

document.getElementById('lightbox').addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
    touchStartY = e.changedTouches[0].screenY;
}, { passive: true });

document.getElementById('lightbox').addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    touchEndY = e.changedTouches[0].screenY;
    handleSwipe();
}, { passive: true });

function handleSwipe() {
    const deltaX = touchEndX - touchStartX;
    const deltaY = touchEndY - touchStartY;
    const minSwipeDistance = 50;
    
    // Horizontal swipe (left/right navigation)
    if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > minSwipeDistance) {
        if (deltaX < 0) {
            nextMedia(); // Swipe left -> next media
        } else {
            prevMedia(); // Swipe right -> previous media
        }
    }
    
    // Vertical swipe down to close
    if (deltaY > minSwipeDistance && Math.abs(deltaX) < minSwipeDistance) {
        closeLightbox();
    }
}

// Video event listeners for better UX
document.addEventListener('DOMContentLoaded', function() {
    const lightboxVideo = document.getElementById('lightbox-video');
    
    if (lightboxVideo) {
        lightboxVideo.addEventListener('play', function() {
            isVideoPlaying = true;
            updatePlayPauseIcon();
        });
        
        lightboxVideo.addEventListener('pause', function() {
            isVideoPlaying = false;
            updatePlayPauseIcon();
        });
        
        lightboxVideo.addEventListener('ended', function() {
            isVideoPlaying = false;
            updatePlayPauseIcon();
            // Auto advance to next media after video ends
            setTimeout(() => {
                nextMedia();
            }, 1000);
        });
    }
});

// Preload next/previous media for smoother experience
function preloadAdjacentMedia() {
    const nextIndex = (currentMediaIndex + 1) % mediaFiles.length;
    const prevIndex = currentMediaIndex === 0 ? mediaFiles.length - 1 : currentMediaIndex - 1;
    
    // Preload next
    if (mediaFiles[nextIndex] && !mediaFiles[nextIndex].isVideo) {
        const img = new Image();
        img.src = mediaFiles[nextIndex].src;
    }
    
    // Preload previous
    if (mediaFiles[prevIndex] && !mediaFiles[prevIndex].isVideo) {
        const img = new Image();
        img.src = mediaFiles[prevIndex].src;
    }
}

// Initialize video thumbnails
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('.masonry-video');
    
    videos.forEach(video => {
        // Generate thumbnail if no poster
        if (!video.poster) {
            video.addEventListener('loadeddata', function() {
                // Set current time to 1 second to get a good thumbnail
                this.currentTime = 1;
            });
            
            video.addEventListener('seeked', function() {
                // Create canvas to capture frame
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                ctx.drawImage(video, 0, 0);
                
                // Set the canvas image as poster
                video.poster = canvas.toDataURL();
            });
        }
    });
});
    </script>
@endpush
@endsection