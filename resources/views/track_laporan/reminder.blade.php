<div class="modal-overlay" id="completionInfoModal">
    <div class="modal">
        <button class="close-btn" onclick="closeCompletionInfoModal()">&times;</button>
        <div class="modal-header">
            <div class="header-icon">✅</div>
            <h2 class="modal-title">Laporan Selesai Ditangani!</h2>
        </div>

        <div class="step-content active">
            <div id="completionInfoContent">
                <div class="completion-info-section">
                    <p class="intro-text">
                        Kami senang menginformasikan bahwa laporan Anda dengan kode unik
                        <strong class="text-primary">{{ $reporter->code ?? 'N/A' }}</strong> telah berhasil ditindaklanjuti dan diselesaikan.
                    </p>

                    <p class="intro-text">
                        Kasus terkait
                        <strong class="text-danger">{{ $categories ?? 'belum ada kategori' }}</strong>
                        telah ditangani oleh tim disipliner sekolah. Kami telah melakukan penyelidikan mendalam
                        dan mengambil langkah-langkah yang diperlukan sesuai prosedur sekolah.
                    </p>
                </div>

                <div class="completion-details">
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-gavel"></i>
                            <h4>Penindakan yang Diambil</h4>
                        </div>
                        <div class="detail-card-content">
                            <p id="display_action_taken_info">
                                @if ($reporter->operation)
                                    {{ $reporter->operation->name}}
                                @else
                                    Belum ada informasi penindakan yang tersedia.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-sticky-note"></i>
                            <h4>Catatan Tambahan</h4>
                        </div>
                        <div class="detail-card-content">
                            <p id="display_feedback_notes_info">
                                @if ($reporter->reason)
                                    {{ $reporter->reason ?? 'Tidak ada catatan tambahan dari pihak sekolah.' }}
                                @else
                                    Tidak ada catatan tambahan dari pihak sekolah.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-file-image"></i>
                            <h4>Bukti Penyelesaian</h4>
                        </div>
                        <div class="detail-card-content">
                            <div id="display_evidence_files_info" class="file-display-container">
                                @if ($reporter->file)
                                    @php
                                        $fileExtension = strtolower(pathinfo($reporter->file, PATHINFO_EXTENSION));
                                        $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg']);
                                    @endphp
                                    <div class="file-display-item" data-src="{{ asset('storage/' . $reporter->file) }}" data-type="{{ $isVideo ? 'video' : 'image' }}">
                                        @if($isVideo)
                                            <div class="evidence-thumbnail" onclick="openMediaModal('{{ asset('storage/' . $reporter->file) }}', 'video')">
                                                <video src="{{ asset('storage/' . $reporter->file) }}" preload="metadata" class="evidence-media"></video>
                                                <div class="play-overlay">
                                                    <i class="fas fa-play"></i>
                                                </div>
                                                <div class="view-hint">Klik untuk melihat</div>
                                            </div>
                                        @else
                                            <div class="evidence-thumbnail" onclick="openMediaModal('{{ asset('storage/' . $reporter->file) }}', 'image')">
                                                <img src="{{ asset('storage/' . $reporter->file) }}" alt="Bukti Tindakan" class="evidence-media">
                                                <div class="view-overlay">
                                                    <i class="fas fa-search-plus"></i>
                                                </div>
                                                <div class="view-hint">Klik untuk melihat</div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada bukti penyelesaian yang dilampirkan.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="feedback-section">
                    <div class="feedback-header">
                        <i class="fas fa-star"></i>
                        <h3>Bagikan Kepuasan Anda</h3>
                    </div>

                    {{-- === Start: Kondisi untuk menampilkan form input atau hasil review === --}}
                    @if ($reporter->rating)
                        {{-- Tampilan hasil review jika sudah ada rating --}}
                        <div id="feedbackDisplayContent">
                            <div class="form-group">
                                <label>Tingkat Kepuasan Anda:</label>
                                <div class="rating-container">
                                    <div class="rating-stars display-only" id="display-rating-stars">
                                        {{-- Bintang akan diisi oleh JS --}}
                                    </div>
                                    <div class="rating-text">
                                        <span id="display-rating-text"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Komentar & Saran:</label>
                                <p id="display-comments-text" class="text-dark">
                                    {{ $reporter->feedback_notes ?? 'Tidak ada saran atau komentar.' }}
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- Form input feedback jika belum ada rating --}}
                        <div id="feedbackRatingContent">
                            <div class="form-group">
                                <label for="rating_input">Tingkat Kepuasan Anda:</label>
                                <div class="rating-container">
                                    <div class="rating-stars" id="rating-stars">
                                        <i class="far fa-star" data-rating="1"></i>
                                        <i class="far fa-star" data-rating="2"></i>
                                        <i class="far fa-star" data-rating="3"></i>
                                        <i class="far fa-star" data-rating="4"></i>
                                        <i class="far fa-star" data-rating="5"></i>
                                    </div>
                                    <div class="rating-text">
                                        <span id="rating-text">Pilih rating</span>
                                    </div>
                                </div>
                                <input type="hidden" id="selected_rating_input" name="selected_rating" value="" required>
                                <div class="error-message" id="error-selected_rating_input"></div>
                            </div>

                            <div class="form-group">
                                <label for="comments_input">Komentar & Saran (Opsional):</label>
                                <textarea id="comments_input" name="comments" placeholder="Bagikan pemikiran atau saran Anda untuk perbaikan di masa mendatang" rows="4"></textarea>
                            </div>
                        </div>
                    @endif
                    {{-- === End: Kondisi untuk menampilkan form input atau hasil review === --}}
                </div>

                <div class="info-footer">
                    <p class="info-text">
                        <i class="fas fa-info-circle"></i>
                        Informasi lebih lanjut dapat Anda dapatkan dengan menghubungi pihak sekolah.
                    </p>
                </div>
            </div>
        </div>

        {{-- === Start: Kondisi untuk tombol aksi di footer modal === --}}
        <div class="modal-actions" id="modal-actions-container">
            @if ($reporter->rating)
                {{-- Jika sudah ada rating, hanya tampilkan tombol "Tutup" --}}
                <button class="btn btn-primary btn-lg" onclick="closeCompletionInfoModal()">
                    <i class="fas fa-times"></i> Tutup
                </button>
            @else
                {{-- Jika belum ada rating, tampilkan pertanyaan dan tombol Kirim Penilaian --}}
                <p class="action-question">Apakah Anda puas dengan penyelesaian ini?</p>
                <div class="action-buttons">
                    <button class="btn btn-secondary" onclick="closeCompletionInfoModal()">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button class="btn btn-primary" onclick="submitUserFeedback()" id="submitUserFeedbackBtn">
                        <i class="fas fa-paper-plane"></i> Kirim Penilaian
                    </button>
                </div>
            @endif
        </div>
        {{-- === End: Kondisi untuk tombol aksi di footer modal === --}}
    </div>
</div>

<div class="media-modal-overlay" id="mediaModal">
    <div class="media-modal">
        <button class="media-close-btn" onclick="closeMediaModal()">&times;</button>
        <div class="media-content">
            <div id="mediaContainer"></div>
        </div>
    </div>
</div>

<style>
    /* Tambahan gaya untuk modal informasi penyelesaian */
    .intro-text, .info-text {
        font-size: 16px;
        color: #34495e;
        line-height: 1.6;
        text-align: center;
    }
    .intro-text strong {
        color: var(--primary-color);
        font-weight: 700;
    }
    .text-danger { /* Pastikan warna merah untuk kategori kasus */
        color: #dc3545 !important;
    }

    /* Gaya khusus untuk modal form penilaian */
    .rating-stars {
        font-size: 28px;
        color: #ddd;
        cursor: pointer;
        display: flex;
        gap: 5px;
        justify-content: center;
        margin-top: 10px;
    }
    .rating-stars i.fas {
        color: #ffc107; /* Warna bintang terisi */
    }
    /* Menggunakan kembali modal-display-text untuk textarea komentar */
    #comments_input {
        background-color: var(--bg-light);
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        color: var(--text-dark);
        min-height: 80px; /* Sesuaikan tinggi */
        line-height: 1.6;
        width: 100%; /* Pastikan lebar 100% */
        box-sizing: border-box; /* Penting untuk padding */
        resize: vertical;
    }
    #comments_input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }
    /* Tambahkan style untuk mode display-only bintang agar tidak ada hover/klik */
    .rating-stars.display-only i {
        cursor: default;
        color: var(--warning-color); /* Pastikan bintang display selalu kuning */
    }
    .rating-stars.display-only i:hover {
        transform: none; /* Hilangkan efek hover */
    }

    /* Style untuk teks komentar yang sudah ada */
    #display-comments-text {
        background-color: #f0f0f0; /* Warna latar belakang ringan */
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        min-height: 80px; /* Pastikan tinggi minimum */
        line-height: 1.6;
        color: var(--text-dark);
        word-wrap: break-word; /* Memastikan teks panjang tidak keluar wadah */
        white-space: pre-wrap; /* Mempertahankan spasi dan baris baru */
    }
    /* Variabel CSS Dasar */
    :root {
        --primary-color: #4361ee;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --bg-light: #ffffff;
        --border-light: #e9ecef;
        --text-dark: #495057;
        --text-muted: #6c757d;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --border-radius-sm: 8px;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
        opacity: 0;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(4px);
    }

    .modal-overlay.show {
        opacity: 1;
    }

    .modal {
        background: var(--bg-light);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        width: 95%;
        max-width: 900px;
        max-height: 95vh;
        overflow-y: auto;
        position: relative;
        transform: scale(0.9) translateY(-20px);
        transition: transform 0.3s ease;
    }

    .modal-overlay.show .modal {
        transform: scale(1) translateY(0);
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        font-size: 28px;
        color: var(--text-muted);
        cursor: pointer;
        z-index: 10;
        transition: color 0.2s ease;
    }

    .close-btn:hover {
        color: var(--danger-color);
    }

    .modal-header {
        text-align: center;
        padding: 25px 30px 20px;
        background: linear-gradient(135deg, var(--success-color), #20c997);
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .header-icon {
        font-size: 36px;
        margin-bottom: 8px;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .step-content {
        padding: 30px 40px;
    }

    .completion-info-section {
        margin-bottom: 30px;
    }

    .intro-text {
        font-size: 16px;
        color: var(--text-dark);
        line-height: 1.6;
        text-align: center;
        margin-bottom: 20px;
        padding: 0 10px;
    }

    .intro-text strong.text-primary {
        color: var(--primary-color);
        font-weight: 700;
    }

    .intro-text strong.text-danger {
        color: var(--danger-color);
        font-weight: 700;
    }

    .completion-details {
        margin-bottom: 30px;
    }

    .detail-card {
        background: var(--bg-light);
        border: 1px solid var(--border-light);
        border-radius: var(--border-radius-sm);
        margin-bottom: 20px;
        box-shadow: var(--shadow);
        transition: box-shadow 0.2s ease;
    }

    .detail-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .detail-card-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        background: linear-gradient(135deg, var(--light-color), #e9ecef);
        border-bottom: 1px solid var(--border-light);
        border-radius: var(--border-radius-sm) var(--border-radius-sm) 0 0;
    }

    .detail-card-header i {
        font-size: 20px;
        color: var(--primary-color);
        margin-right: 10px;
    }

    .detail-card-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .detail-card-content {
        padding: 20px;
    }

    .detail-card-content p {
        margin: 0;
        color: var(--text-dark);
        line-height: 1.6;
        font-size: 15px;
    }

    .file-display-container {
        text-align: center;
    }

    .file-display-item {
        display: inline-block;
        border-radius: var(--border-radius-sm);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .evidence-thumbnail {
        position: relative;
        cursor: pointer;
        border-radius: var(--border-radius-sm);
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .evidence-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    .evidence-media {
        max-width: 100%;
        height: auto;
        max-height: 200px;
        border-radius: var(--border-radius-sm);
        object-fit: cover;
        display: block;
    }

    .play-overlay, .view-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: background 0.2s ease;
    }

    .evidence-thumbnail:hover .play-overlay,
    .evidence-thumbnail:hover .view-overlay {
        background: rgba(0, 0, 0, 0.9);
    }

    .view-hint {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 15px 10px 10px;
        font-size: 12px;
        font-weight: 500;
        text-align: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .evidence-thumbnail:hover .view-hint {
        opacity: 1;
    }

    .text-muted {
        color: var(--text-muted);
        font-style: italic;
    }

    .feedback-section {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: var(--border-radius-sm);
        padding: 25px;
        margin-bottom: 25px;
    }

    .feedback-header {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }

    .feedback-header i {
        font-size: 24px;
        color: var(--warning-color);
        margin-right: 10px;
    }

    .feedback-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 14px;
    }

    .rating-container {
        text-align: center;
    }

    .rating-stars {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .rating-stars i {
        font-size: 32px;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .rating-stars i:hover {
        transform: scale(1.1);
    }

    .rating-stars i.fas {
        color: var(--warning-color);
    }

    .rating-text {
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
    }

    #comments_input {
        width: 100%;
        background-color: var(--bg-light);
        border: 1px solid var(--border-light);
        border-radius: var(--border-radius-sm);
        padding: 15px;
        font-size: 15px;
        color: var(--text-dark);
        min-height: 100px;
        line-height: 1.6;
        resize: vertical;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    #comments_input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .error-message {
        display: none;
        color: var(--danger-color);
        font-size: 13px;
        margin-top: 5px;
        font-weight: 500;
    }

    .form-group.error .error-message {
        display: block;
    }

    .form-group.error .rating-stars {
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .info-footer {
        text-align: center;
        padding: 20px;
        background: linear-gradient(135deg, var(--info-color), #20c997);
        color: white;
        border-radius: var(--border-radius-sm);
        margin-bottom: 20px;
    }

    .info-text {
        margin: 0;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-text i {
        margin-right: 8px;
        font-size: 16px;
    }

    .modal-actions {
        padding: 25px 40px 30px;
        text-align: center;
        background: var(--light-color);
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .action-question {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 20px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: var(--border-radius-sm);
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;

        align-items: center;
        gap: 8px;
        text-decoration: none;
        min-width: 120px;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #3f37c9);
        color: white;
        box-shadow: var(--shadow);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #3f37c9, var(--primary-color));
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: linear-gradient(135deg, var(--secondary-color), #5a6268);
        color: white;
        box-shadow: var(--shadow);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268, var(--secondary-color));
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modal {
            width: 95%;
            max-width: none;
            margin: 10px;
        }

        .modal-header {
            padding: 20px 20px 15px;
        }

        .header-icon {
            font-size: 32px;
        }

        .modal-title {
            font-size: 18px;
        }

        .step-content {
            padding: 25px;
        }

        .detail-card-header {
            padding: 12px 15px;
        }

        .detail-card-content {
            padding: 15px;
        }

        .feedback-section {
            padding: 20px;
        }

        .rating-stars i {
            font-size: 28px;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn {
            width: 100%;
            max-width: 200px;
        }

        .modal-actions {
            padding: 20px 25px 25px;
        }
    }

    /* Animation for modal entrance */
    @keyframes modalSlideIn {
        from {
            transform: scale(0.7) translateY(-50px);
            opacity: 0;
        }
        to {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    /* Media Modal Styles */
    .media-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1100;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .media-modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .media-modal {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .media-modal-overlay.show .media-modal {
        transform: scale(1);
    }

    .media-close-btn {
        position: absolute;
        top: -40px;
        right: 0;
        background: none;
        border: none;
        color: white;
        font-size: 32px;
        cursor: pointer;
        z-index: 10;
        transition: color 0.2s ease;
    }

    .media-close-btn:hover {
        color: var(--danger-color);
    }

    .media-content {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .media-content img {
        max-width: 100%;
        max-height: 80vh;
        border-radius: var(--border-radius-sm);
        box-shadow: var(--shadow-lg);
    }

    .media-content video {
        max-width: 100%;
        max-height: 80vh;
        border-radius: var(--border-radius-sm);
        box-shadow: var(--shadow-lg);
    }

    @media (max-width: 768px) {
        .media-close-btn {
            top: -35px;
            right: -10px;
            font-size: 28px;
        }
        
        .media-modal {
            max-width: 95%;
            max-height: 95%;
        }
        
        .media-content img,
        .media-content video {
            max-height: 70vh;
        }
    }
</style>

@push('scripts')
    <script>
        let selectedRatingInput = 0;
        const ratingTexts = {
            0: 'Pilih rating',
            1: 'Sangat Tidak Puas',
            2: 'Tidak Puas',
            3: 'Cukup Puas',
            4: 'Puas',
            5: 'Sangat Puas'
        };

        function completionInfoModal() {
            const modalOverlay = document.getElementById('completionInfoModal');
            if (modalOverlay) {
                const actualModal = modalOverlay.querySelector('.modal');

                // Jika feedback sudah ada, inisialisasi tampilan display
                @if ($reporter->rating)
                    selectedRatingInput = {{ $reporter->rating }};
                    updateStarRatingDisplay();
                    updateRatingTextDisplay();
                @endif

                modalOverlay.style.display = 'flex';
                requestAnimationFrame(() => {
                    modalOverlay.classList.add('show');
                    if (actualModal) {
                        actualModal.style.animation = 'modalSlideIn 0.3s ease-out forwards';
                    }
                });
            }
        }

        function closeCompletionInfoModal() {
            const modalOverlay = document.getElementById('completionInfoModal');
            const actualModal = modalOverlay.querySelector('.modal');

            console.log("closeCompletionInfoModal called.");
            modalOverlay.classList.remove('show'); // Hapus kelas 'show' dulu untuk transisi opacity

            setTimeout(() => {
                modalOverlay.style.display = 'none'; // Baru sembunyikan setelah transisi
                if (actualModal) {
                    actualModal.style.animation = ''; // Reset animasi
                }

                // Reset form hanya jika belum ada rating (mode input)
                @if (!$reporter->rating)
                    selectedRatingInput = 0;
                    document.getElementById('selected_rating_input').value = '';
                    document.getElementById('comments_input').value = '';
                    updateStarRatingForm();
                    updateRatingText();
                    hideValidationErrorFeedback(document.getElementById('selected_rating_input'));
                @endif
            }, 300); // Sesuaikan dengan durasi transisi CSS .modal-overlay
        }

        window.completionInfoModal = completionInfoModal;
        window.closeCompletionInfoModal = closeCompletionInfoModal; // Pastikan ini diekspos dengan benar

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('completionInfoModal');
            if (modal) {
                modal.style.display = 'none'; // Initially hidden
                modal.classList.remove('show'); // Ensure no initial opacity
            }

            const mediaModal = document.getElementById('mediaModal');
            if (mediaModal) {
                mediaModal.style.display = 'none';
                mediaModal.classList.remove('show');
            }

            // Inisialisasi fungsi rating HANYA JIKA feedback belum diberikan
            @if (!$reporter->rating)
                initializeRatingStarsForm(); // Panggil fungsi untuk interaksi form
            @else
                // Jika feedback sudah ada, panggil fungsi untuk tampilan display
                selectedRatingInput = {{ $reporter->rating }};
                updateStarRatingDisplay();
                updateRatingTextDisplay();
            @endif
        });

        // FUNGSI UNTUK FORM INPUT (JIKA BELUM ADA RATING)
        function initializeRatingStarsForm() {
            const ratingStarsForm = document.getElementById('rating-stars');
            if (ratingStarsForm) {
                ratingStarsForm.addEventListener('click', (e) => {
                    const star = e.target.closest('i');
                    if (star && star.dataset.rating) {
                        selectedRatingInput = parseInt(star.dataset.rating);
                        document.getElementById('selected_rating_input').value = selectedRatingInput;
                        updateStarRatingForm();
                        updateRatingText();
                        hideValidationErrorFeedback(document.getElementById('selected_rating_input'));
                    }
                });

                ratingStarsForm.addEventListener('mouseover', (e) => {
                    const star = e.target.closest('i');
                    if (star && star.dataset.rating) {
                        const hoverRating = parseInt(star.dataset.rating);
                        highlightStars(hoverRating, 'rating-stars'); // Gunakan ID spesifik
                    }
                });

                ratingStarsForm.addEventListener('mouseleave', () => {
                    updateStarRatingForm();
                });
            }
        }

        // FUNGSI UNTUK MENGISI BINTANG PADA TAMPILAN (JIKA SUDAH ADA RATING)
        function updateStarRatingDisplay() {
            const displayStarsContainer = document.getElementById('display-rating-stars');
            if (displayStarsContainer) {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= selectedRatingInput) {
                        starsHtml += '<i class="fas fa-star" data-rating="' + i + '"></i>';
                    } else {
                        starsHtml += '<i class="far fa-star" data-rating="' + i + '"></i>';
                    }
                }
                displayStarsContainer.innerHTML = starsHtml;
            }
        }

        // FUNGSI UNTUK UPDATE TEKS RATING PADA TAMPILAN
        function updateRatingTextDisplay() {
            const ratingTextElement = document.getElementById('display-rating-text');
            if (ratingTextElement) {
                ratingTextElement.textContent = ratingTexts[selectedRatingInput] || 'Pilih rating';
            }
        }

        // FUNGSI UMUM UNTUK HIGHLIGHT BINTANG (digunakan oleh form input dan hover)
        function highlightStars(rating, containerId) {
            document.querySelectorAll('#' + containerId + ' i').forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }

        // FUNGSI UMUM UNTUK UPDATE BINTANG BERDASARKAN selectedRatingInput (digunakan oleh form input)
        function updateStarRatingForm() {
            highlightStars(selectedRatingInput, 'rating-stars'); // Gunakan ID spesifik
        }

        // FUNGSI UMUM UNTUK UPDATE TEKS RATING (digunakan oleh form input)
        function updateRatingText() {
            const ratingTextElement = document.getElementById('rating-text');
            if (ratingTextElement) {
                ratingTextElement.textContent = ratingTexts[selectedRatingInput] || 'Pilih rating';
            }
        }

        function validateFeedbackFormSubmit() {
            let isValid = true;
            let firstInvalidField = null;

            const ratingInput = document.getElementById('selected_rating_input');
            hideValidationErrorFeedback(ratingInput);

            if (selectedRatingInput === 0) {
                showValidationErrorFeedback(ratingInput, 'Mohon berikan penilaian bintang.');
                isValid = false;
                if (!firstInvalidField) firstInvalidField = ratingInput;
            }

            if (!isValid && firstInvalidField) {
                const ratingStarsElement = document.getElementById('rating-stars');
                if (ratingStarsElement) {
                    ratingStarsElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    firstInvalidField.focus();
                }
            }
            return isValid;
        }

        function showValidationErrorFeedback(field, message) {
            const formGroup = field.closest('.form-group');
            if (formGroup) {
                formGroup.classList.add('error');
                const errorMessageDiv = formGroup.querySelector('.error-message');
                if (errorMessageDiv) {
                    errorMessageDiv.textContent = message;
                    errorMessageDiv.style.display = 'block';
                }
            }
        }

        function hideValidationErrorFeedback(field) {
            const formGroup = field.closest('.form-group');
            if (formGroup) {
                formGroup.classList.remove('error');
                const errorMessageDiv = formGroup.querySelector('.error-message');
                if (errorMessageDiv) {
                    errorMessageDiv.textContent = '';
                    errorMessageDiv.style.display = 'none';
                }
            }
        }

        async function submitUserFeedback() {
            if (!validateFeedbackFormSubmit()) {
                return;
            }

            const submitBtn = document.getElementById('submitUserFeedbackBtn');
            const originalText = submitBtn.innerHTML;

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

            const formData = new FormData();
            const reportId = '{{ $reporter->id ?? null }}';
            if (!reportId) {
                // Gunakan trackReportModule.showErrorMessage jika tersedia
                if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showErrorMessage === 'function') {
                    trackReportModule.showErrorMessage('ID laporan tidak ditemukan. Tidak dapat mengirim ulasan.');
                } else {
                    alert('ID laporan tidak ditemukan. Tidak dapat mengirim ulasan.');
                }
                submitBtn.disabled = false; // Pastikan tombol diaktifkan kembali
                submitBtn.innerHTML = originalText;
                return;
            }

            formData.append('report_id', reportId);
            formData.append('rating', selectedRatingInput);
            formData.append('comments', document.getElementById('comments_input').value);

            console.log("Submitting user feedback data:", Object.fromEntries(formData.entries()));

            try {
                const response = await fetch('/submit-user-feedback', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error submitting user feedback:', errorData);
                    // Gunakan trackReportModule.showErrorMessage jika tersedia
                    if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showErrorMessage === 'function') {
                        trackReportModule.showErrorMessage('Gagal mengirim penilaian: ' + (errorData.message || 'Terjadi kesalahan.'));
                    } else {
                        alert('Gagal mengirim penilaian: ' + (errorData.message || 'Terjadi kesalahan.'));
                    }
                    return;
                }

                const result = await response.json();
                console.log('User feedback submitted successfully:', result);

                closeCompletionInfoModal();
                // Gunakan trackReportModule.showSuccessMessage dengan pesan spesifik
                if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showSuccessMessage === 'function') {
                    trackReportModule.showSuccessMessage('Penilaian Anda berhasil dikirim! Terima kasih atas masukan Anda.');
                    // Reload halaman setelah sukses dan modal tertutup untuk update UI
                    setTimeout(() => {
                        location.reload();
                    }, 400); // Beri sedikit waktu untuk notifikasi muncul
                } else {
                    alert('Penilaian berhasil dikirim! Terima kasih.');
                    location.reload(); // Refresh juga jika fallback ke alert()
                }

            } catch (error) {
                console.error('Network or unexpected error during user feedback submission:', error);
                // Gunakan trackReportModule.showErrorMessage jika tersedia
                if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showErrorMessage === 'function') {
                    trackReportModule.showErrorMessage('Terjadi kesalahan jaringan atau tak terduga saat mengirim penilaian. Mohon coba lagi.');
                } else {
                    alert('Terjadi kesalahan jaringan atau tak terduga saat mengirim penilaian. Mohon coba lagi.');
                }
            } finally {
                // Pastikan tombol diaktifkan kembali di sini
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        // Media Modal Functions (tetap sama)
        function openMediaModal(src, type) {
            const mediaModal = document.getElementById('mediaModal');
            const mediaContainer = document.getElementById('mediaContainer');
            
            mediaContainer.innerHTML = ''; // Clear previous content
            
            if (type === 'video') {
                const video = document.createElement('video');
                video.src = src;
                video.controls = true;
                video.autoplay = true;
                mediaContainer.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = src;
                img.alt = 'Bukti Penyelesaian';
                mediaContainer.appendChild(img);
            }
            
            mediaModal.style.display = 'flex';
            requestAnimationFrame(() => {
                mediaModal.classList.add('show');
            });
        }

        function closeMediaModal() {
            const mediaModal = document.getElementById('mediaModal');
            const mediaContainer = document.getElementById('mediaContainer');
            
            mediaModal.classList.remove('show');
            setTimeout(() => {
                mediaModal.style.display = 'none';
                mediaContainer.innerHTML = ''; // Clear content
            }, 300);
        }

        document.addEventListener('click', (e) => {
            const mediaModal = document.getElementById('mediaModal');
            if (e.target === mediaModal) {
                closeMediaModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const mediaModal = document.getElementById('mediaModal');
                if (mediaModal && mediaModal.classList.contains('show')) {
                    closeMediaModal();
                }
            }
        });
    </script>
@endpush