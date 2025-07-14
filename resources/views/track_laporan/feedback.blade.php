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
                                @if ($reporter?->operation)
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
                                @if ($reporter?->reason)
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
                                @if ($reporter?->file)
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
                    @if ($reporter?->rating)
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
                                    {{ $reporter->comment ?? 'Tidak ada saran atau komentar.' }}
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
                                <textarea id="comments_input" name="comments" placeholder="Bagikan pemikiran atau saran Anda..." rows="4"></textarea>
                            </div>
                        </div>
                    @endif
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
            @if ($reporter?->rating)
                {{-- Jika sudah ada rating, hanya tampilkan tombol "Tutup" --}}
                <button class="btn btn-primary btn-lg" onclick="closeCompletionInfoModal()">
                    <i class="fas fa-times"></i> Tutup
                </button>
            @else
                {{-- Jika belum ada rating, tampilkan pertanyaan dan tombol Kirim Penilaian --}}
                <p class="action-question">Apakah Anda puas dengan penyelesaian ini?</p>
                <div class="action-buttons">
                    <button class="btn btn-secondary" onclick="closeCompletionInfoModal()">
                        <i class="fas fa-times"></i> Nanti Saja
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
    /* Variabel CSS untuk tema yang modern dan estetik */
    :root {
        --primary-color: #4361ee;
        --primary-light: #4cc9f0;
        --secondary-color: #6c757d;
        --success-color: #2a9d8f;
        --success-light: #80ed99;
        --danger-color: #e63946;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --bg-light: #fdfdff;
        --bg-soft: #f8f9fa;
        --border-color: #e9ecef;
        --text-dark: #343a40;
        --text-muted: #6c757d;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 30px rgba(67, 97, 238, 0.15);
        --border-radius: 16px;
        --border-radius-sm: 10px;
    }

    /* --- Modal Overlay & Container --- */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1050;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        backdrop-filter: blur(5px);
    }
    .modal-overlay.show { opacity: 1; }

    .modal {
        background: var(--bg-light);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        width: 95%;
        max-width: 800px; /* Sedikit lebih ramping */
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        transform: scale(0.95) translateY(20px);
        transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .modal-overlay.show .modal { transform: scale(1) translateY(0); }

    /* --- Tombol Close --- */
    .close-btn {
        position: absolute;
        top: 15px; right: 15px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        width: 32px; height: 32px;
        border-radius: 50%;
        font-size: 20px;
        color: white;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
        display: flex; align-items: center; justify-content: center;
    }
    .close-btn:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: rotate(90deg);
    }

    /* --- Modal Header --- */
    .modal-header {
        text-align: center;
        padding: 30px 40px 25px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }
    .header-icon {
        font-size: 42px;
        margin-bottom: 12px;
        text-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .modal-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    /* --- Konten Modal --- */
    .step-content { padding: 25px 35px; }

    .completion-info-section { margin-bottom: 30px; }

    .intro-text {
        font-size: 16px;
        color: var(--text-dark);
        line-height: 1.7;
        text-align: center;
        margin-bottom: 15px;
    }
    .intro-text strong.text-primary { color: var(--primary-color); }
    .intro-text strong.text-danger { color: var(--danger-color); }
    
    /* --- Detail Cards --- */
    .completion-details { margin-bottom: 30px; }
    .detail-card {
        background: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        margin-bottom: 20px;
        box-shadow: none;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .detail-card:hover {

        box-shadow: var(--shadow);
        border-color: var(--primary-color);
    }
    .detail-card-header {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        background: var(--bg-soft);
        border-bottom: 1px solid var(--border-color);
    }
    .detail-card-header i {
        font-size: 20px;
        color: var(--primary-color);
        margin-right: 15px;
    }
    .detail-card-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .detail-card-content { padding: 20px; }
    .detail-card-content p {
        margin: 0;
        color: var(--text-muted);
        line-height: 1.6;
        font-size: 15px;
    }
    
    /* --- Bukti & Thumbnail --- */
    .file-display-container { text-align: center; }
    .evidence-thumbnail {
        position: relative;
        cursor: pointer;
        border-radius: var(--border-radius-sm);
        overflow: hidden;
        display: inline-block;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .evidence-thumbnail:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }
    .evidence-media {
        max-width: 100%; height: auto;
        max-height: 250px;
        border-radius: var(--border-radius-sm);
        object-fit: cover;
        display: block;
    }
    .play-overlay, .view-overlay {
        position: absolute; top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.3);
        color: white;
        display: flex;
        align-items: center; justify-content: center;
        font-size: 32px;
        opacity: 0;
        transition: all 0.3s ease;
    }
    .evidence-thumbnail:hover .play-overlay, .evidence-thumbnail:hover .view-overlay { opacity: 1; }
    .view-hint {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white; padding: 15px 10px 10px;
        font-size: 13px; font-weight: 500; text-align: center;
        opacity: 0;
        transform: translateY(100%);
        transition: all 0.3s ease;
    }
    .evidence-thumbnail:hover .view-hint {
        opacity: 1;
        transform: translateY(0);
    }

    /* --- Feedback Section --- */
    .feedback-section {
        background: linear-gradient(135deg, var(--bg-soft), #f0f3f5);
        border-radius: var(--border-radius-sm);
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
    }
    .feedback-header {
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 25px;
    }
    .feedback-header i {
        font-size: 24px;
        color: var(--warning-color);
        margin-right: 12px;
    }
    .feedback-header h3 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
        color: var(--text-dark);
    }
    
    /* --- Form Elements --- */
    .form-group { margin-bottom: 25px; text-align: center; }
    .form-group label {
        display: block; margin-bottom: 12px;
        font-weight: 600; color: var(--text-dark);
        font-size: 15px;
    }
    
    /* --- Rating Stars --- */
    .rating-container { text-align: center; }
    .rating-stars {
        display: flex; justify-content: center;
        gap: 10px; margin-bottom: 12px;
    }
    .rating-stars i {
        font-size: 36px;
        color: #e0e0e0;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .rating-stars i:hover {
        transform: scale(1.2) rotate(15deg);
        color: var(--warning-color);
    }
    .rating-stars i.fas { color: var(--warning-color); }
    .rating-stars.display-only i {
        cursor: default; color: var(--warning-color);
    }
    .rating-stars.display-only i:hover { transform: none; }
    .rating-text {
        font-size: 15px; color: var(--text-muted);
        font-weight: 500; height: 20px;
    }
    
    /* --- Textarea & Display --- */
    #comments_input {
        width: 100%;
        background-color: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        padding: 15px;
        font-size: 16px; color: var(--text-dark);
        min-height: 120px; line-height: 1.6;
        resize: vertical; box-sizing: border-box;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    #comments_input::placeholder { color: #aaa; }
    #comments_input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }
/* ===== GAYA KOMENTAR PREMIUM (FINAL) ===== */

#display-comments-text {
    /* Hapus 'display: flex' dan gunakan metode yang lebih cocok untuk teks */
    padding: 30px 40px; /* Padding untuk memberi ruang nafas */
    margin-top: 10px;
    background: #ffffff; /* Latar belakang putih bersih */
    border-radius: var(--border-radius-sm);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); /* Bayangan yang lebih lembut dan dalam */
    position: relative;
    text-align: center; /* Kunci utama untuk menengahkan teks */
    overflow: hidden; /* Penting untuk menjaga ::before agar tidak keluar */
}

#display-comments-text::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px; /* Lebar garis aksen */
    /* Gradien warna sebagai aksen modern */
    background: linear-gradient(90deg, var(--primary-light), var(--primary-color));
}

#display-comments-text p {
    position: relative; /* Agar teks berada di atas tanda kutip */
    z-index: 2;
    margin: 0; /* Hapus margin default dari paragraf */
    font-size: 1.25em; /* Ukuran font yang lebih besar */
    font-style: italic;
    font-weight: 600; /* Teks lebih tebal */
    color: #34495e; /* Warna biru tua yang elegan */
    line-height: 1.6;
}

#display-comments-text p::before,
#display-comments-text p::after {
    font-family: 'Georgia', serif; /* Font yang lebih klasik untuk kutipan */
    font-weight: bold;
    font-size: 2em; /* Ukuran tanda kutip */
    color: var(--primary-color); /* Warna tanda kutip yang serasi */
    opacity: 0.6;
}

#display-comments-text p::before {
    content: '“ '; /* Tanda kutip pembuka dengan spasi */
}

#display-comments-text p::after {
    content: ' ”'; /* Tanda kutip penutup dengan spasi */
}

    /* --- Error Validation --- */
    .error-message {
        display: none; color: var(--danger-color);
        font-size: 14px; margin-top: 8px; font-weight: 500;
    }
    .form-group.error .error-message { display: block; }
    .form-group.error .rating-stars { animation: shake 0.5s ease-in-out; }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-6px); }
        75% { transform: translateX(6px); }
    }

    /* --- Info Footer --- */
    .info-footer {
        text-align: center;
        padding: 15px;
        background: transparent;
        border: 1px dashed var(--border-color);
        border-radius: var(--border-radius-sm);
    }
    .info-text {
        margin: 0; font-size: 14px;
        color: var(--text-muted);
        display: flex; align-items: center; justify-content: center;
    }
    .info-text i { margin-right: 8px; font-size: 16px; }
    
    .modal-actions {
    padding: 15px 20px; /* Kurangi lagi padding agar lebih ringkas */
    display: flex;

    align-items: center;
    background: var(--bg-soft);
    border-top: 1px solid var(--border-color);
    border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    /* Tambahkan aturan CSS baru untuk membungkus tombol */
    .modal-button-group {
        display: flex; /* Membuat grup tombol menjadi flex container */
        gap: 10px; /* Memberi jarak antar tombol */
    }

    /* Anda juga bisa menambahkan aturan untuk memperkecil font jika perlu */
    .modal-actions p {
        font-size: 0.9em; /* Contoh pengurangan ukuran font pada teks */
        margin: 0; /* Hilangkan margin default pada paragraf */
    }

    .modal-button-group button {
        font-size: 0.85em; /* Contoh pengurangan ukuran font pada tombol */
        padding: 8px 12px; /* Sesuaikan padding tombol jika perlu */
    }
    .action-question {
        font-size: 18px; font-weight: 600;
        color: var(--text-dark); margin-bottom: 20px;
    }
    .action-buttons {
        display: flex; gap: 15px;
        justify-content: center; flex-wrap: wrap;
    }
    
    /* --- Buttons --- */
    .btn {
        display: inline-flex;
        align-items: center; justify-content: center;
        gap: 10px; padding: 12px 28px;
        border: none;
        border-radius: var(--border-radius-sm);
        font-size: 16px; font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        min-width: 150px;
    }
    .btn i { font-size: 15px; }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
        color: white;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 7px 20px rgba(67, 97, 238, 0.4);
    }
    .btn-secondary {
        background: var(--bg-light);
        color: var(--secondary-color);
        border: 1px solid var(--border-color);
        box-shadow: none;
    }
    .btn-secondary:hover {
        transform: translateY(-3px);
        background: var(--secondary-color);
        color: white;
        box-shadow: 0 7px 20px rgba(108, 117, 125, 0.2);
    }
    .btn-lg { padding: 14px 32px; font-size: 18px; }

    /* --- Media Modal --- */
    .media-modal-overlay { /* Sama dengan modal overlay utama */
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.85); z-index: 1100;
        display: flex; justify-content: center; align-items: center;
        opacity: 0; visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .media-modal-overlay.show { opacity: 1; visibility: visible; }
    .media-modal {
        position: relative; max-width: 90%; max-height: 90%;
        transform: scale(0.8); transition: transform 0.3s ease;
    }
    .media-modal-overlay.show .media-modal { transform: scale(1); }
    .media-close-btn { /* Mirip close-btn utama tapi lebih besar */
        position: absolute; top: -15px; right: -30px;
        background: none; border: none;
        color: white; font-size: 40px; cursor: pointer;
        transition: all 0.2s ease;
    }
    .media-close-btn:hover { color: var(--danger-color); transform: scale(1.1); }
    .media-content img, .media-content video {
        max-width: 100%; max-height: 85vh;
        border-radius: var(--border-radius-sm);
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
        .modal { width: 95%; max-height: 95vh; }
        .modal-header { padding: 25px 20px 20px; }
        .modal-title { font-size: 20px; }
        .step-content { padding: 20px; }
        .action-buttons { flex-direction: column; align-items: stretch; }
        .btn { width: 100%; }
        .media-close-btn { top: 5px; right: 5px; background: rgba(0,0,0,0.4); border-radius: 50%; width: 35px; height: 35px; font-size: 24px; }
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
                @if ($reporter?->rating)
                    selectedRatingInput = {{ $reporter->rating }};
                    updateStarRatingDisplay();
                    updateRatingTextDisplay();
                @endif

                modalOverlay.style.display = 'flex';
                requestAnimationFrame(() => {
                    modalOverlay.classList.add('show');
                });
            }
        }

        function closeCompletionInfoModal() {
            const modalOverlay = document.getElementById('completionInfoModal');
            if(modalOverlay) {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.style.display = 'none';
                    // Reset form hanya jika belum ada rating (mode input)
                    @if (!$reporter?->rating)
                        selectedRatingInput = 0;
                        document.getElementById('selected_rating_input').value = '';
                        document.getElementById('comments_input').value = '';
                        updateStarRatingForm();
                        updateRatingText();
                        hideValidationErrorFeedback(document.getElementById('selected_rating_input'));
                    @endif
                }, 300); // Sesuaikan dengan durasi transisi
            }
        }

        window.completionInfoModal = completionInfoModal;
        window.closeCompletionInfoModal = closeCompletionInfoModal;

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('completionInfoModal');
            if (modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
            }

            const mediaModal = document.getElementById('mediaModal');
            if (mediaModal) {
                mediaModal.style.display = 'none';
                mediaModal.classList.remove('show');
            }

            // Inisialisasi fungsi rating HANYA JIKA feedback belum diberikan
            @if (!$reporter?->rating)
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
                        highlightStars(hoverRating, 'rating-stars');
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
            highlightStars(selectedRatingInput, 'rating-stars');
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
                }
            }
        }

        async function submitUserFeedback() {
            if (!validateFeedbackFormSubmit()) {
                return;
            }

            const submitBtn = document.getElementById('submitUserFeedbackBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

            const formData = new FormData();
            const reportId = '{{ $reporter->id ?? null }}';
            if (!reportId) {
                alert('ID laporan tidak ditemukan. Tidak dapat mengirim ulasan.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                return;
            }

            formData.append('report_id', reportId);
            formData.append('rating', selectedRatingInput);
            formData.append('comments', document.getElementById('comments_input').value);

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
                    alert('Gagal mengirim penilaian: ' + (errorData.message || 'Terjadi kesalahan.'));
                    return;
                }

                closeCompletionInfoModal();
                if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showSuccessMessage === 'function') {
                    trackReportModule.showSuccessMessage('Penilaian Anda berhasil dikirim! Terima kasih atas masukan Anda.');
                } else {
                    alert('Penilaian Anda berhasil dikirim! Terima kasih atas masukan Anda.');
                }
                setTimeout(() => {
                    location.reload();
                }, 1500);
                
            } catch (error) {
                console.error('Network or unexpected error during user feedback submission:', error);
                alert('Terjadi kesalahan jaringan atau tak terduga saat mengirim penilaian. Mohon coba lagi.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        }

        // Media Modal Functions
        function openMediaModal(src, type) {
            const mediaModal = document.getElementById('mediaModal');
            const mediaContainer = document.getElementById('mediaContainer');
            mediaContainer.innerHTML = '';
            
            if (type === 'video') {
                const video = document.createElement('video');
                video.src = src; video.controls = true; video.autoplay = true;
                mediaContainer.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = src; img.alt = 'Bukti Penyelesaian';
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
                mediaContainer.innerHTML = '';
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