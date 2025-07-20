<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="header-content">
                    <div class="header-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 id="modalTitle">Detail Laporan</h3>
                </div>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <div class="laporan-detail">
                    <div class="detail-section">
                        <h4 class="section-title">Informasi Pelapor</h4>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 4h6m-6 4h6M6 7h12l1 12H5L6 7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Tanggal Melapor
                                </div>
                                <div class="detail-value" id="detailTanggal"></div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    NIS (Nomor Induk Siswa)
                                </div>
                                <div class="detail-value" id="detailNIS"></div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Email
                                </div>
                                <div class="detail-value" id="detailEmail"></div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4 class="section-title">Kategori Kasus</h4>
                        <div class="category-container">
                            <div class="category-item">
                                <div class="category-value" id="detailKategoriKasus">
                                
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="detail-section">
                        <h4 class="section-title">Deskripsi Kejadian</h4>
                        <div class="uraian-content" id="detailUraian"></div>
                    </div>

                    <div class="detail-section">
                        <h4 class="section-title">Kata Kunci</h4>
                        <div class="keywords-container" id="detailKataKunci"></div>
                    </div>

                    <div class="detail-section">
                        <h4 class="section-title">Bukti Pendukung</h4>
                        <div id="detailBukti" class="bukti-container">
                            <div class="bukti-grid">
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="footer-info">
                    <div class="status-indicator">
                        <div class="status-dot" id="detailStatusDot"></div>
                        <span id="detailStatusText"></span>
                    </div>
                </div>
                <div class="action-buttons">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="btnReject">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Tolak Laporan
                    </button>
                    <button type="button" class="btn btn-success" id="btnAccept">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Terima Laporan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="image-modal" onclick="closeImageModal()">
    <span class="close-image" onclick="closeImageModal()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
    <img id="modalImage" src="" alt="Bukti Laporan">
</div>


{{-- Modal for Reject Reason --}}
<div class="modal fade" id="modal-reject-reason" tabindex="-1" aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectReasonModalLabel">Alasan Penolakan Laporan</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="rejectReasonSelect">Pilih Alasan:</label>
                    <select class="form-control" id="rejectReasonSelect">
                        <option value="">-- Pilih Alasan Penolakan --</option>
                        <option value="Laporan kurang lengkap">Laporan kurang lengkap</option>
                        <option value="Laporan tidak jelas/tidak dipahami">Laporan tidak jelas/tidak dipahami</option>
                        <option value="Tidak ada bukti pendukung yang relevan">Tidak ada bukti pendukung yang relevan</option>
                        <option value="Laporan duplikat">Laporan duplikat</option>
                        <option value="Bukan wewenang sekolah">Bukan wewenang sekolah</option>
                        <option value="Lainnya">Lainnya (mohon jelaskan)</option>
                    </select>
                </div>
                <div class="form-group mt-3" id="otherReasonContainer" style="display: none;">
                    <label for="otherReasonText">Alasan Lainnya:</label>
                    <textarea class="form-control" id="otherReasonText" rows="3" placeholder="Masukkan alasan penolakan lainnya..."></textarea>
                </div>
                <div id="rejectReasonError" class="text-danger mt-2" style="display: none;">Mohon pilih atau masukkan alasan penolakan.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmRejectBtn">Tolak Laporan</button>
            </div>
        </div>
    </div>
</div>

{{-- Generic Confirmation Modal --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Terima Laporan</h5> 
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmationMessage">Anda yakin ingin menerima laporan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmActionButton">Terima Laporan</button>
            </div>
        </div>
    </div>
</div>

{{-- Success Notification Toast (example) --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                {{-- Message will be inserted here --}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<style>
/* Reset dan Base Styles */
* {
    box-sizing: border-box;
}

html, body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f1f5f9;
}

/* Modal Styles Umum */
.modal-dialog.modal-xl {
    max-width: 800px;
    margin: 2rem auto;
}

.modal-content {
    border: none;
    border-radius: 20px; /* Lebih membulat */
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(10px);
    overflow: hidden;
    background-color: #ffffff; /* Pastikan latar belakang konten putih */
}

/* Header Styles Umum */
.modal-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    color: white;
    padding: 24px 32px;
    border-bottom: none;
    position: relative;
    border-top-left-radius: 20px; /* Sudut atas membulat sesuai content */
    border-top-right-radius: 20px; /* Sudut atas membulat sesuai content */
}

.header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-icon {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.modal-header h3 {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
    letter-spacing: -0.025em;
}

.close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 8px;
    border-radius: 10px;
    position: absolute;
    right: 24px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-50%) scale(1.05);
}

/* Body Styles Umum */
.modal-body {
    padding: 0;
    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
}

.laporan-detail {
    padding: 32px;
}

.detail-section {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.3s ease;
}

.detail-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.detail-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 20px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title::before {
    content: '';
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 2px;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    gap: 16px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-label svg {
    color: #6366f1;
}

.detail-value {
    font-size: 1rem;
    color: #1e293b;
    font-weight: 500;
    background: #f8fafc;
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

/* Uraian Content */
.uraian-content {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 20px 24px;
    border-radius: 16px;
    border-left: 5px solid #6366f1;
    font-size: 1rem;
    line-height: 1.7;
    color: #374151;
    text-align: justify;
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
}

/* Keywords - DIPERBAIKI */
.keywords-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    min-height: 40px; /* Ensure space even if no keywords */
}

.keyword-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 2px solid transparent;
    white-space: nowrap;
}

.keyword-tag:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.keyword-tag svg {
    flex-shrink: 0;
}

/* Warna kata kunci yang diperbaiki */
.keyword-tag.severity-high {
    background: #ef4444;
    color: white;
}

.keyword-tag.severity-medium {
    background: #f59e0b;
    color: white;
}

.keyword-tag.location {
    background: #8b5cf6;
    color: white;
}

.keyword-tag.category {
    background: #06b6d4;
    color: white;
}

.keyword-tag.time {
    background: #10b981;
    color: white;
}

/* Bukti Container - DIPERBAIKI */
.bukti-container {
    min-height: 120px;
}

.bukti-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.bukti-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 12px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
    cursor: pointer;
}

.bukti-item:hover {
    border-color: #6366f1;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px -8px rgba(99, 102, 241, 0.3);
}

.bukti-item img, .bukti-item video {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 8px;
    border: 1px solid #e2e8f0;
}

.bukti-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.bukti-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
    word-break: break-word;
}

.bukti-size {
    font-size: 0.75rem;
    color: #64748b;
}

.bukti-placeholder {
    text-align: center;
    color: #94a3b8;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%; /* Ensure it fills the container */
}

.bukti-placeholder svg {
    margin-bottom: 16px;
    opacity: 0.5;
}

.bukti-placeholder p {
    margin: 0;
    font-size: 1rem;
    font-weight: 500;
}

/* Footer */
.modal-footer {
    background: white;
    padding: 24px 32px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-info {
    display: flex;
    align-items: center;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 500;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-dot.pending {
    background: #f59e0b;
}
.status-dot.approved {
    background: #10b981; /* Green for approved */
}
.status-dot.rejected {
    background: #ef4444; /* Red for rejected */
}


@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.action-buttons {
    display: flex;
    gap: 12px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    outline: none;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn-secondary {
    background: #64748b;
    color: white;
    box-shadow: 0 4px 6px -1px rgba(100, 116, 139, 0.4);
}

.btn-secondary:hover {
    background: #475569;
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(100, 116, 139, 0.4);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.4);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4);
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
}

/* Image Modal - DIPERBAIKI */
.image-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
}

.image-modal img {
    max-width: 85%;
    max-height: 85%;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.close-image {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 12px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    z-index: 10000;
}

.close-image:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .modal-dialog.modal-xl {
        max-width: 95%;
        margin: 1rem;
    }

    .modal-header {
        padding: 20px;
    }

    .modal-header h3 {
        font-size: 1.5rem;
    }

    .laporan-detail {
        padding: 20px;
    }

    .detail-section {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        flex-direction: column;
        gap: 16px;
        align-items: stretch;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn {
        justify-content: center;
    }

    .bukti-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .keywords-container {
        gap: 8px;
    }

    .keyword-tag {
        font-size: 0.75rem;
        padding: 6px 12px;
    }

    .bukti-item img, .bukti-item video {
        height: 100px;
    }
}

/* Animation */
.modal.fade .modal-dialog {
    transform: scale(0.8) translateY(-50px);
    opacity: 0;
    transition: all 0.3s ease;
}

.modal.show .modal-dialog {
    transform: scale(1) translateY(0);
    opacity: 1;
}

/* ===== NEW & IMPROVED REJECT REASON MODAL STYLES ===== */
#modal-reject-reason .modal-dialog {
    max-width: 500px; /* Sedikit lebih lebar dari modal konfirmasi */
    border-radius: 20px;
}

#modal-reject-reason .modal-content {
    border-radius: 20px; /* Sudut membulat */
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Bayangan halus */
}

#modal-reject-reason .modal-header {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important; /* Gradien merah */
    color: white;
    padding: 20px 25px; /* Padding lebih luas */
    border-bottom: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}
#modal-reject-reason .modal-title {
    font-size: 1.5rem; /* Ukuran judul lebih besar */
    font-weight: 700;
    letter-spacing: -0.02em;
    color: white;
}
#modal-reject-reason .close-btn {
    position: static;
    transform: none;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%; /* Tombol close bulat */
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    flex-shrink: 0;
}
#modal-reject-reason .close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

#modal-reject-reason .modal-body {
    padding: 25px; /* Padding body lebih banyak */
    background-color: #fcfdfe; /* Latar belakang body sedikit off-white */
    font-size: 1rem;
    color: #333;
    line-height: 1.6;
}

#modal-reject-reason .form-group {
    margin-bottom: 20px; /* Jarak antar form group */
}

#modal-reject-reason .form-group label {
    font-weight: 600;
    color: #4a5568; /* Warna label lebih gelap */
    margin-bottom: 8px;
    display: block;
    font-size: 0.95rem;
}
#modal-reject-reason .form-control {
    width: 100%;
    padding: 12px 15px; /* Padding lebih banyak */
    border: 1px solid #e2e8f0; /* Border lebih halus */
    border-radius: 10px; /* Sudut membulat */
    font-size: 1rem;
    background-color: white; /* Latar belakang input putih */
    transition: all 0.3s ease;
}
#modal-reject-reason .form-control:focus {
    border-color: #ef4444; /* Border merah saat fokus */
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25); /* Shadow saat fokus */
    outline: none;
}
#modal-reject-reason #rejectReasonError {
    font-size: 0.875rem;
    color: #ef4444;
    margin-top: 5px;
}

#modal-reject-reason .modal-footer {
    border-top: 1px solid #e0e0e0;
    padding: 20px 25px; /* Padding footer lebih banyak */
    background-color: #fcfdfe;
    justify-content: flex-end;
    gap: 15px; /* Jarak antar tombol */
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
}

/* Styles for the generic confirmation modal */
#confirmationModal .modal-dialog {
    max-width: 450px;
    border-radius: 20px;
}

#confirmationModal .modal-content {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

#confirmationModal .modal-header {
    background: linear-gradient(135deg, #7b68ee 0%, #a020f0 100%) !important;
    color: white;
    padding: 20px 25px;
    border-bottom: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

#confirmationModal .modal-header .modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: white;
}

#confirmationModal .modal-header .close-btn {
    position: static;
    transform: none;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    flex-shrink: 0;
}

#confirmationModal .modal-body {
    padding: 25px;
    background-color: #fcfdfe;
    font-size: 1.05rem;
    color: #333;
    line-height: 1.6;
}

#confirmationModal .modal-footer {
    padding: 20px 25px;
    border-top: 1px solid #e0e0e0;
    background-color: #fcfdfe;
    justify-content: flex-end;
    gap: 15px;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
}

#confirmationModal .modal-footer .btn-secondary {
    background: #6c757d;
    color: white;
    border-radius: 10px;
    padding: 10px 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

#confirmationModal .modal-footer .btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

#confirmationModal .modal-footer .btn-primary {
    background: linear-gradient(135deg, #7b68ee 0%, #a020f0 100%) !important;
    color: white;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(123, 104, 238, 0.4);
}

#confirmationModal .modal-footer .btn-primary:hover {
    background: linear-gradient(135deg, #6a5acd 0%, #8a2be2 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 15px rgba(123, 104, 238, 0.5);
}

/* Styles for Toast Notification */
.toast-container {
    z-index: 1080; /* Higher than modals if you want it on top */
}
.toast {
    max-width: 350px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    opacity: 0.95;
    animation: slideInFromRight 0.5s ease-out forwards; /* Animasi masuk */
}
.toast.bg-success {
    background-color: #10b981 !important; /* Green */
}
.toast.bg-danger {
    background-color: #ef4444 !important; /* Red */
}
.toast-body {
    font-weight: 500;
}

@keyframes slideInFromRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 0.95;
    }
}

.category-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-top: 0.5rem;
}

.category-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.category-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #374151;
    font-size: 0.875rem;
}

.category-value {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.badge-danger {
    background-color: #ef4444;
    color: white;
}

.badge-warning {
    background-color: #f59e0b;
    color: white;
}
</style>