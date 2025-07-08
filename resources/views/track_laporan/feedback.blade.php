{{-- 
<div class="modal-overlay" id="completionInfoModal">
    <div class="modal1">
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
                        @if ($reporter->feedback)
                            {{ $reporter->feedback->action_taken }}
                        @else
                            Belum ada informasi penindakan yang tersedia.
                        @endif
                    </p>
                </div>

                <div class="form-group mb-4">
                    <label>Catatan Tambahan:</label>
                    <p id="display_feedback_notes_info" class="modal-display-text">
                        @if ($reporter->feedback)
                            {{ $reporter->feedback->notes ?? 'Tidak ada catatan tambahan dari pihak sekolah.' }}
                        @else
                            Tidak ada catatan tambahan dari pihak sekolah.
                        @endif
                    </p>
                </div>

                <div class="form-group mb-4">
                    <label>Bukti Penyelesaian:</label>
                    <div id="display_evidence_files_info" class="file-display-container">
                        @if ($reporter->feedback && $reporter->feedback->files->count() > 0)
                            @foreach($reporter->feedback->files as $file)
                                @php
                                    $fileExtension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                    $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg']);
                                @endphp
                                <div class="file-display-item" data-src="{{ asset('storage/' . $file->file_path) }}" data-type="{{ $isVideo ? 'video' : 'image' }}" data-index="{{ $loop->index }}">
                                    @if($isVideo)
                                        <video src="{{ asset('storage/' . $file->file_path) }}" controls preload="metadata"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $file->file_path) }}" alt="Bukti Tindakan">
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada bukti penyelesaian yang dilampirkan.</p>
                        @endif
                    </div>
                </div>

                <p class="info-text mt-4">
                    Informasi lebih lanjut dapat Anda dapatkan dengan menghubungi pihak sekolah.
                </p>
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

<div class="modal-overlay" id="feedbackFormModal">
    <div class="modal">
        <button class="close-btn" onclick="closeFeedbackFormModal()">&times;</button>
        <div class="modal-header">
            <div class="header-icon">⭐</div>
            <h2 class="modal-title">Berikan Penilaian Anda</h2>
        </div>

        <div class="step-content active">
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

        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeFeedbackFormModal()">Batal</button>
            <button class="btn btn-primary" onclick="submitUserFeedback()" id="submitUserFeedbackBtn">Kirim Penilaian</button>
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
    let completionMediaFiles = []; // Untuk media di Completion Info Modal
    let selectedRatingInput = 0; // Untuk rating di Feedback Form Modal

    // --- FUNGSI UNTUK MODAL PERTAMA (INFORMASI PENYELESAIAN) ---
    function openCompletionInfoModal() {
        const modalOverlay = document.getElementById('completionInfoModal');
        const actualModal = modalOverlay.querySelector('.modal');

        console.log("openCompletionInfoModal called.");

        if (!modalOverlay || !actualModal) {
            console.error("Completion Info Modal elements not found.");
            return;
        }

        // Ambil data dari Blade PHP (pastikan $reporter->feedback di-load di controller)
        const feedbackData = @json($reporter->feedback);
        const reporterCode = '{{ $reporter->code ?? 'N/A' }}';
        const categoriesText = '{{ $categories ?? 'belum ada kategori' }}';

        // Update teks intro
        const introTextElements = actualModal.querySelectorAll('.intro-text');
        if (introTextElements.length > 0) {
            introTextElements[0].innerHTML = `
                Kami senang menginformasikan bahwa laporan Anda dengan kode unik
                <strong class="text-primary">${reporterCode}</strong> telah berhasil ditindaklanjuti dan diselesaikan.
            `;
            if (introTextElements.length > 1) { // Jika ada paragraf kedua untuk kategori
                introTextElements[1].innerHTML = `
                    Kasus terkait
                    <strong class="text-danger">${categoriesText}</strong>
                    telah ditangani oleh tim disipliner sekolah. Kami telah melakukan penyelidikan mendalam
                    dan mengambil langkah-langkah yang diperlukan sesuai prosedur sekolah.
                `;
            }
        }

        // Perbarui konten modal dengan data dari feedbackData
        document.getElementById('display_action_taken_info').innerText = feedbackData && feedbackData.action_taken ? feedbackData.action_taken : 'Belum ada informasi penindakan yang tersedia.';
        document.getElementById('display_feedback_notes_info').innerText = feedbackData && feedbackData.notes ? feedbackData.notes : 'Tidak ada catatan tambahan dari pihak sekolah.';

        // Perbarui bukti tindakan (untuk lightbox)
        const displayEvidenceContainer = document.getElementById('display_evidence_files_info');
        displayEvidenceContainer.innerHTML = ''; // Kosongkan konten sebelumnya
        completionMediaFiles = []; // Reset array media files untuk lightbox

        if (feedbackData && feedbackData.files && feedbackData.files.length > 0) {
            feedbackData.files.forEach((file, index) => {
                const fileExtension = file.file_path.split('.').pop().toLowerCase();
                const isVideo = ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg'].includes(fileExtension);
                const assetPath = '{{ asset('storage') }}' + '/' + file.file_path;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'file-display-item';
                itemDiv.dataset.index = index;
                itemDiv.onclick = () => openLightboxCompletion(index); // Fungsi baru untuk lightbox dari modal ini

                if (isVideo) {
                    const videoElem = document.createElement('video');
                    videoElem.src = assetPath;
                    videoElem.controls = false;
                    videoElem.muted = true;
                    videoElem.preload = 'metadata';
                    itemDiv.appendChild(videoElem);
                } else {
                    const imgElem = document.createElement('img');
                    imgElem.src = assetPath;
                    imgElem.alt = 'Bukti Tindakan';
                    itemDiv.appendChild(imgElem);
                }
                displayEvidenceContainer.appendChild(itemDiv);

                completionMediaFiles.push({
                    src: assetPath,
                    type: isVideo ? `video/${fileExtension}` : 'image',
                    isVideo: isVideo
                });
            });
        } else {
            const noEvidence = document.createElement('p');
            noEvidence.className = 'text-muted';
            noEvidence.innerText = 'Tidak ada bukti penyelesaian yang dilampirkan.';
            displayEvidenceContainer.appendChild(noEvidence);
        }

        // Tampilkan modal
        actualModal.style.display = 'flex'; // Menggunakan flex karena .modal sudah display:flex
        setTimeout(() => {
            modalOverlay.classList.add('active'); // Aktifkan overlay
            actualModal.style.opacity = '1';
            actualModal.style.transform = 'translateY(0) scale(1)';
            actualModal.style.animation = 'modalSlideIn 0.3s ease-out forwards';
        }, 10);
    }

    function closeCompletionInfoModal() {
        const modalOverlay = document.getElementById('completionInfoModal');
        const actualModal = modalOverlay.querySelector('.modal');

        console.log("closeCompletionInfoModal called.");

        actualModal.style.animation = 'modalSlideOut 0.3s ease-in forwards';
        actualModal.style.opacity = '0';
        actualModal.style.transform = 'translateY(-20px) scale(0.95)';

        modalOverlay.classList.remove('active');

        setTimeout(() => {
            actualModal.style.display = 'none';
            actualModal.style.animation = '';
        }, 300);
    }

    // Fungsi untuk membuka lightbox dari Completion Info Modal
    function openLightboxCompletion(index) {
        console.log("Opening lightbox from Completion Info Modal for index:", index);
        if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.openLightbox === 'function') {
            trackReportModule.currentMediaIndex = index;
            trackReportModule.mediaFiles = completionMediaFiles; // Gunakan media dari Completion Modal
            // Pastikan total media di lightbox juga diperbarui
            document.getElementById('total-media').textContent = completionMediaFiles.length;
            trackReportModule.openLightbox(index);
        } else {
            console.error("trackReportModule atau openLightbox tidak terdefinisi.");
        }
    }


    // --- FUNGSI UNTUK MODAL KEDUA (FORM PENILAIAN) ---
    function openFeedbackFormModal() {
        closeCompletionInfoModal(); // Tutup modal informasi terlebih dahulu

        const modalOverlay = document.getElementById('feedbackFormModal');
        const actualModal = modalOverlay.querySelector('.modal');

        console.log("openFeedbackFormModal called.");

        // Reset form penilaian saat membuka
        document.getElementById('selected_rating_input').value = '';
        selectedRatingInput = 0; // Reset variabel
        updateStarRatingForm(); // Perbarui tampilan bintang
        document.getElementById('comments_input').value = '';
        // Sembunyikan pesan error
        document.querySelectorAll('#feedbackRatingContent .error-message').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.form-group.error').forEach(el => el.classList.remove('error'));

        actualModal.style.display = 'flex';
        setTimeout(() => {
            modalOverlay.classList.add('active');
            actualModal.style.opacity = '1';
            actualModal.style.transform = 'translateY(0) scale(1)';
            actualModal.style.animation = 'modalSlideIn 0.3s ease-out forwards';
        }, 10);
    }

    function closeFeedbackFormModal() {
        const modalOverlay = document.getElementById('feedbackFormModal');
        const actualModal = modalOverlay.querySelector('.modal');

        console.log("closeFeedbackFormModal called.");

        actualModal.style.animation = 'modalSlideOut 0.3s ease-in forwards';
        actualModal.style.opacity = '0';
        actualModal.style.transform = 'translateY(-20px) scale(0.95)';

        modalOverlay.classList.remove('active');

        setTimeout(() => {
            actualModal.style.display = 'none';
            actualModal.style.animation = '';
        }, 300);
    }

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

    // Validasi form penilaian
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
            // Untuk rating, mungkin arahkan ke area bintang
            const ratingStarsElement = document.getElementById('rating-stars');
            if (ratingStarsElement) {
                ratingStarsElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                firstInvalidField.focus();
            }
        }
        return isValid;
    }

    // Fungsi untuk menampilkan pesan error validasi (untuk form penilaian)
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

    // Fungsi untuk menyembunyikan pesan error validasi (untuk form penilaian)
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


    // Fungsi untuk mengirim penilaian pengguna ke Laravel
    async function submitUserFeedback() {
        if (!validateFeedbackFormSubmit()) {
            return;
        }

        const formData = new FormData();
        const reportId = '{{ $reporter->id ?? null }}'; // Pastikan ini aman dan tersedia
        if (!reportId) {
            alert('ID laporan tidak ditemukan. Tidak dapat mengirim ulasan.');
            return;
        }

        formData.append('report_id', reportId);
        formData.append('rating', selectedRatingInput);
        formData.append('comments', document.getElementById('comments_input').value);

        console.log("Submitting user feedback data:", Object.fromEntries(formData.entries()));

        try {
            // Ubah '/submit-user-feedback' ke endpoint Laravel Anda yang sebenarnya
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
                alert('Gagal mengirim penilaian: ' + (errorData.message || 'Terjadi kesalahan.'));
                return;
            }

            const result = await response.json();
            console.log('User feedback submitted successfully:', result);

            closeFeedbackFormModal();
            if (typeof trackReportModule !== 'undefined' && typeof trackReportModule.showSuccessMessage === 'function') {
                trackReportModule.showSuccessMessage(); // Gunakan pesan sukses yang sudah ada
            } else {
                alert('Penilaian berhasil dikirim! Terima kasih.');
            }
            // Tidak perlu location.reload() setelah feedback, karena laporan sudah selesai.
            // Atau jika perlu, sesuaikan sesuai kebutuhan.
        } catch (error) {
            console.error('Network or unexpected error during user feedback submission:', error);
            alert('Terjadi kesalahan jaringan atau tak terduga saat mengirim penilaian. Mohon coba lagi.');
        }
    }


    // --- INTEGRASI KE TRACKREPORTMODULE DAN INITIALISASI ---
    // Mengganti fungsi `openCompletionModal` di `trackReportModule`
    if (typeof trackReportModule !== 'undefined') {
        // Ini adalah fungsi yang akan dipanggil oleh tombol "Berikan Penilaian" di track.blade.php
        trackReportModule.openCompletionModal = openCompletionInfoModal;
    } else {
        console.warn("trackReportModule belum terdefinisi di feedback.blade.php. Pastikan urutan pemuatan script sudah benar.");
    }

    // Inisialisasi: Pastikan kedua modal tersembunyi saat DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        const completionInfoModal = document.getElementById('completionInfoModal');
        const feedbackFormModal = document.getElementById('feedbackFormModal');

        if (completionInfoModal) {
            const actualModalContent = completionInfoModal.querySelector('.modal');
            completionInfoModal.style.opacity = '0';
            completionInfoModal.style.pointerEvents = 'none';
            actualModalContent.style.display = 'none';
            actualModalContent.style.opacity = '0';
            actualModalContent.style.transform = 'translateY(-20px) scale(0.95)';
            actualModalContent.style.animation = '';
        }

        if (feedbackFormModal) {
            const actualModalContent = feedbackFormModal.querySelector('.modal');
            feedbackFormModal.style.opacity = '0';
            feedbackFormModal.style.pointerEvents = 'none';
            actualModalContent.style.display = 'none';
            actualModalContent.style.opacity = '0';
            actualModalContent.style.transform = 'translateY(-20px) scale(0.95)';
            actualModalContent.style.animation = '';
        }
    });
</script>
@endpush --}}