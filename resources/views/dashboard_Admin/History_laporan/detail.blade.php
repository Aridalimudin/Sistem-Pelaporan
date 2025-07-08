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

/* Modal Styles */
.modal-dialog.modal-xl {
    max-width: 800px;
    margin: 2rem auto;
}

.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    backdrop-filter: blur(10px);
    overflow: hidden;
}

/* Header Styles */
.modal-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    color: white;
    padding: 24px 32px;
    border-bottom: none;
    position: relative;
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

/* Body Styles */
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
</style>