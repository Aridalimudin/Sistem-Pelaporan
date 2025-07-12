<div class="modal-overlay" id="completionInfoModal">
    <div class="modal">
        <button class="close-btn" onclick="closeCompletionInfoModal()">&times;</button>
        <div class="modal-header">
            <div class="header-icon">✅</div>
            <h2 class="modal-title">Laporan Selesai Ditangani!</h2>
        </div>

        <div class="step-content active">
            <div id="completionInfoContent">
                <p class="intro-text mb-4">
                    Kami senang menginformasikan bahwa laporan Anda dengan kode unik
                    <strong class="text-primary">{{ $reporter->code ?? 'N/A' }}</strong> telah berhasil ditindaklanjuti dan diselesaikan.
                </p>

                <p class="intro-text mb-4">
                    Kasus terkait
                    <strong class="text-danger">{{ $categories ?? 'belum ada kategori' }}</strong>
                    telah ditangani oleh tim disipliner sekolah. Kami telah melakukan penyelidikan mendalam
                    dan mengambil langkah-langkah yang diperlukan sesuai prosedur sekolah.
                </p>

                <div class="form-group mb-4">
                    <label>Penindakan yang Diambil:</label>
                    <p id="display_action_taken_info" class="modal-display-text">
                        @if ($reporter->operation)
                            {{ $reporter->operation->name}}
                        @else
                            Belum ada informasi penindakan yang tersedia.
                        @endif
                    </p>
                </div>

                <div class="form-group mb-4">
                    <label>Catatan Tambahan:</label>
                    <p id="display_feedback_notes_info" class="modal-display-text">
                        @if ($reporter->reason)
                            {{ $reporter->reason ?? 'Tidak ada catatan tambahan dari pihak sekolah.' }}
                        @else
                            Tidak ada catatan tambahan dari pihak sekolah.
                        @endif
                    </p>
                </div>

                <div class="form-group mb-4">
                    <label>Bukti Penyelesaian:</label>
                    <div id="display_evidence_files_info" class="file-display-container">
                        @if ($reporter->file)
                         
                            @php
                                $fileExtension = strtolower(pathinfo($reporter->file, PATHINFO_EXTENSION));
                                $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg']);
                            @endphp
                            <div class="file-display-item" data-src="{{ asset('storage/' . $reporter->file) }}" data-type="{{ $isVideo ? 'video' : 'image' }}">
                                @if($isVideo)
                                    <video src="{{ asset('storage/' . $reporter->file) }}" controls preload="metadata"></video>
                                @else
                                    <img src="{{ asset('storage/' . $reporter->file) }}" alt="Bukti Tindakan" width="100">
                                @endif
                            </div>
                           
                        @else
                            <p class="text-muted">Tidak ada bukti penyelesaian yang dilampirkan.</p>
                        @endif
                    </div>
                </div>

                <p class="info-text mt-4">
                    Informasi lebih lanjut dapat Anda dapatkan dengan menghubungi pihak sekolah.
                </p>
                  <div class="step-content-title">Bagikan Kepuasan Anda</div>
                <div id="feedbackRatingContent">
                    <div class="form-group">
                        <label for="rating_input">Tingkat Kepuasan Anda:</label>
                        <div class="rating-stars" id="rating-stars">
                            <i class="far fa-star" data-rating="1"></i>
                            <i class="far fa-star" data-rating="2"></i>
                            <i class="far fa-star" data-rating="3"></i>
                            <i class="far fa-star" data-rating="4"></i>
                            <i class="far fa-star" data-rating="5"></i>
                        </div>
                        <input type="hidden" id="selected_rating_input" name="selected_rating" value="" required>
                        <div class="error-message" id="error-selected_rating_input"></div>
                    </div>

                    <div class="form-group mt-4">
                        <label for="comments_input">Komentar & Saran (Opsional):</label>
                        <textarea id="comments_input" name="comments" placeholder="Bagikan pemikiran atau saran Anda untuk perbaikan di masa mendatang" rows="4"></textarea>
                    </div>
                </div>
            </div>
              
        </div>

        <div class="modal-actions d-flex justify-content-center flex-column">
            <p class="mb-3 fw-bold text-center">Apakah Anda puas dengan penyelesaian ini?</p>
            <div class="d-flex justify-content-center gap-3">
                <button class="btn btn-secondary" onclick="closeCompletionInfoModal()">Tutup</button>
                <button class="btn btn-primary" onclick="openFeedbackFormModal()">Berikan Penilaian</button>
            </div>
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
</style>

@push('scripts')
    <script>
        function completionInfoModal(initialStep = 1) {
            const modalOverlay = document.getElementById('completionInfoModal');
            if (modalOverlay) {
                const actualModal = modalOverlay.querySelector('.modal');
                // Ensure it's displayed first, then fade in
                modalOverlay.style.display = 'flex';
                // Wait for display change to render, then apply opacity and animation
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
                modalOverlay.style.display = 'none';
            modalOverlay.classList.remove('show');
        }
        window.completionInfoModal = completionInfoModal;
        window.closeCompleteDocumentsForm = closeCompleteDocumentsForm;

        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('completionInfoModal');
            if (modal) {
                modal.style.display = 'none'; // Initially hidden
                modal.classList.remove('show'); // Ensure no initial opacity
            }
        });

         // Mengatur rating bintang di form penilaian
        const ratingStarsForm = document.getElementById('rating-stars');
        if (ratingStarsForm) {
            ratingStarsForm.addEventListener('click', (e) => {
                const star = e.target.closest('i');
                if (star && star.dataset.rating) {
                    selectedRatingInput = parseInt(star.dataset.rating);
                    document.getElementById('selected_rating_input').value = selectedRatingInput;
                    updateStarRatingForm();
                    hideValidationErrorFeedback(document.getElementById('selected_rating_input'));
                }
            });
        }
        function updateStarRatingForm() {
            document.querySelectorAll('.rating-stars i').forEach((star, index) => {
                if (index < selectedRatingInput) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }
    </script>
@endpush