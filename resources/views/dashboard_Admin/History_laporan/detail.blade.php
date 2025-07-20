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
            <form action="" method="POST" enctype="multipart/form-data" id="form-proses">
                @csrf
                <div class="modal-body">
                    <div class="laporan-detail">
                        
                        <div class="detail-section">
                            <h4 class="section-title">Informasi Pelapor</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 4h6m-6 4h6M6 7h12l1 12H5L6 7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Tanggal Melapor
                                    </div>
                                    <div class="detail-value" id="detailTanggal"></div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        NIS (Nomor Induk Siswa)
                                    </div>
                                    <div class="detail-value" id="detailNIS"></div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
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
                                    <span class="badge badge-danger">Bullying Verbal</span>
                                    <span class="badge badge-danger">Bullying Fisik</span> 
                                    <span class="badge badge-warning">Pelecehan Seksual Verbal</span> 
                                    <span class="badge badge-warning">Pelecehan Seksual Fisik</span>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="detail-section">
                            <h4 class="section-title">Waktu dan Lokasi Kejadian</h4>
                            <div class="detail-grid-2-col">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/></svg>
                                        Tanggal Kejadian
                                    </div>
                                    <div class="detail-value" id="detailTanggalKejadian"></div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/></svg>
                                        Lokasi Kejadian
                                    </div>
                                    <div class="detail-value" id="detailLokasiKejadian"></div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4 class="section-title">Pihak Terlibat</h4>
                            <div class="pihak-grid">
                                <div class="pihak-subsection">
                                    <h5 class="subsection-title korban">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/></svg>
                                        Korban
                                    </h5>
                                    <div class="detail-grid-horizontal" id="detail-korban"></div>
                                </div>

                                <div class="pihak-subsection">
                                    <h5 class="subsection-title pelaku">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="2"/><path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2"/></svg>
                                        Pelaku
                                    </h5>
                                    <div class="detail-grid-horizontal" id="detail-pelaku">
                                        <div class="detail-item">
                                            <div class="detail-label">Nama Pelaku</div>
                                            <div class="detail-value" id="detailNamaPelaku"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pihak-subsection">
                                <h5 class="subsection-title saksi">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M23 21v-2a4 4 0 0 0-3-3.87" stroke="currentColor" stroke-width="2"/><path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="2"/></svg>
                                    Saksi (Opsional)
                                </h5>
                                <div class="detail-grid-horizontal" id="detail-saksi">
                                    <div class="detail-item">
                                        <div class="detail-label">Nama Saksi</div>
                                        <div class="detail-value" id="detailNamaSaksi"></div>
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


                        <div class="detail-grid-2-col no-margin">
                             <div class="detail-section">
                                <h4 class="section-title">Informasi Tambahan</h4>
                                <div class="info-tambahan-content" id="detailInfoTambahan">
                                    <div class="info-placeholder">
                                        <p>Tidak ada informasi tambahan</p>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-section">
                                <h4 class="section-title">Tindakan yang Diharapkan</h4>
                                <div class="tindakan-content" id="detailTindakan"></div>
                            </div>
                        </div>

                        <div class="detail-section">
                        <h4 class="section-title">Bukti Pendukung</h4>
                        <div id="detailBukti" class="bukti-container">
                            <div class="bukti-grid">
                                </div>
                        </div>
                    </div>

                        <div class="detail-section rejection-section" id="rejection-section-container" style="display: none;">
                            <h4 class="section-title rejection-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Alasan Penolakan:
                            </h4>
                            <div class="rejection-reason" id="detailAlasanPenolakan">
                                Laporan kurang lengkap
                            </div>
                        </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="footer-info">

                </div>
                <div class="action-buttons">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Batal
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<style>
/* KODE CSS BARU YANG LEBIH MENARIK */
.detail-section.rejection-section {
    background: linear-gradient(135deg, #e57373 0%, #d32f2f 100%); /* Latar belakang gradient */
    border: 1px solid #c62828;
    color: white;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 4px 6px rgba(0, 0, 0, 0.1); /* Efek shadow */
}
.rejection-section .section-title {
    color: white;
    font-size: 1.1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2); /* Garis bawah lebih soft */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); /* Shadow pada teks judul */
}

/* Mengaktifkan kembali garis vertikal di kiri judul, tapi dengan warna putih */
.rejection-section .section-title::before {
    display: block;
    background: white;
    opacity: 0.8;
}

.rejection-reason {
    font-size: 1rem;
    padding: 15px;
    background-color: rgba(0, 0, 0, 0.15); /* Latar belakang semi-transparan untuk teks */
    border-radius: 8px; /* Sudut lebih melengkung */
    margin-top: 10px;
    line-height: 1.6;
}
.detail-grid-2-col {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive grid */
    gap: 20px;
    margin-bottom: 20px;
}

.pihak-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 24px; /* Space before Saksi section */
}

/* Modifier to remove margin from sections inside a grid wrapper */
.detail-grid-2-col.no-margin > .detail-section {
    margin-bottom: 0;
}

/* Responsive adjustments for the new grids */
@media (max-width: 768px) {
    .detail-grid-2-col, .pihak-grid {
        grid-template-columns: 1fr; /* Stack on smaller screens */
    }

    .pihak-grid {
      gap: 0; /* Remove gap when stacked */
    }
    
    .pihak-grid > .pihak-subsection {
        margin-bottom: 24px;
    }

    .pihak-grid > .pihak-subsection:last-child {
        margin-bottom: 0;
    }
}
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
    max-width: 900px;
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
    max-height: 70vh;
    overflow-y: auto;
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

/* Pihak Terlibat Subsections */
.pihak-subsection {
    margin-bottom: 24px;
}

.pihak-subsection:last-child {
    margin-bottom: 0;
}

.subsection-title {
    font-size: 1rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 16px 0;
    padding: 8px 12px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.subsection-title.korban {
    background: rgba(16, 185, 129, 0.1);
    color: #065f46;
    border-left: 3px solid #10b981;
}

.subsection-title.pelaku {
    background: rgba(239, 68, 68, 0.1);
    color: #7f1d1d;
    border-left: 3px solid #ef4444;
}

.subsection-title.saksi {
    background: rgba(99, 102, 241, 0.1);
    color: #312e81;
    border-left: 3px solid #6366f1;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    gap: 16px;
}

.detail-grid-horizontal {
    display: grid;
    grid-template-columns: 1fr 1fr;
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

/* Content Styles */
.uraian-content, .tindakan-content {
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

.tindakan-content {
    border-left-color: #10b981;
}

.info-tambahan-content {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    padding: 20px 24px;
    border-radius: 16px;
    border-left: 5px solid #f59e0b;
    font-size: 1rem;
    line-height: 1.7;
    color: #92400e;
    text-align: justify;
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
}

.info-placeholder, .saksi-placeholder {
    text-align: center;
    color: #94a3b8;
    padding: 20px;
    font-style: italic;
}

/* Saksi Container */
.saksi-container {
    min-height: 60px;
}

.saksi-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.saksi-item:hover {
    border-color: #6366f1;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
}

.saksi-item:last-child {
    margin-bottom: 0;
}

.saksi-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.saksi-detail {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.saksi-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.saksi-value {
    font-size: 0.875rem;
    color: #1e293b;
    font-weight: 500;
}

/* Keywords */
.keywords-container {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    min-height: 40px;
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

/* Bukti Container */
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
    height: 100%;
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

/* Ulasan Pelapor Styles - Improved & Compact */
#feedbackContent {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.feedback-content {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.feedback-placeholder {
    text-align: center;
    color: #64748b;
    padding: 30px 20px;
    font-style: italic;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100px;
    position: relative;
    overflow: hidden;
}

.feedback-placeholder::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23e2e8f0' fill-opacity='0.2'%3E%3Ccircle cx='3' cy='3' r='2'/%3E%3Ccircle cx='13' cy='13' r='2'/%3E%3C/g%3E%3C/svg%3E") repeat;
    opacity: 0.3;
}

.feedback-placeholder p {
    position: relative;
    z-index: 1;
    margin: 0;
    font-size: 1rem;
    font-weight: 500;
}

.feedback-item {
    background: white;
    border-radius: 10px;
    padding: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.feedback-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6, #06b6d4);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.feedback-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
}

.feedback-item:hover::before {
    opacity: 1;
}

.feedback-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: #475569;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    margin-bottom: 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #f1f5f9;
}

.feedback-label svg {
    flex-shrink: 0;
    color: #6366f1;
    background: #f0f9ff;
    padding: 4px;
    border-radius: 6px;
    width: 24px;
    height: 24px;
}

.feedback-value {
    font-size: 0.95rem;
    color: #1e293b;
    font-weight: 500;
    line-height: 1.5;
    word-break: break-word;
}

/* Compact grid layout for satisfaction and rating */
.feedback-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}

/* Special styling for satisfaction level */
.feedback-item.satisfaction .feedback-value {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    color: #166534;
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #bbf7d0;
    font-weight: 600;
    text-align: center;
    position: relative;
    font-size: 0.9rem;
}

.feedback-item.satisfaction .feedback-value::before {
    content: '✓';
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-weight: bold;
    color: #16a34a;
}

/* Star rating container - more compact */
.star-display {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    padding: 12px 16px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 8px;
    border: 1px solid #fde68a;
    justify-content: center;
}

.fa.fa-star {
    color: #d1d5db;
    font-size: 1.4rem;
    transition: all 0.2s ease-in-out;
    cursor: default;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.08));
}

.fa.fa-star.checked {
    color: #f59e0b;
    transform: scale(1.02);
    text-shadow: 0 0 6px rgba(245, 158, 11, 0.3);
}

.fa.fa-star:hover {
    transform: scale(1.05);
}

.rating-text {
    font-size: 0.95rem;
    font-weight: 700;
    color: #92400e;
    margin-left: 12px;
    padding: 4px 8px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 6px;
    backdrop-filter: blur(4px);
}

/* Comment section - more compact */
.feedback-item.comment .feedback-value {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    padding: 16px;
    border-radius: 8px;
    border: 1px solid #bae6fd;
    font-style: italic;
    position: relative;
    white-space: pre-wrap;
    line-height: 1.6;
    font-size: 0.9rem;
}

.feedback-item.comment .feedback-value::before {
    content: '"';
    position: absolute;
    top: 6px;
    left: 8px;
    font-size: 1.5rem;
    color: #0284c7;
    font-weight: bold;
    opacity: 0.3;
}

.feedback-item.comment .feedback-value::after {
    content: '"';
    position: absolute;
    bottom: 6px;
    right: 8px;
    font-size: 1.5rem;
    color: #0284c7;
    font-weight: bold;
    opacity: 0.3;
}

/* Responsive Design */
@media (max-width: 768px) {
    #feedbackContent {
        padding: 16px;
        border-radius: 10px;
    }
    
    .feedback-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .feedback-item {
        padding: 14px;
    }
    
    .feedback-label {
        font-size: 0.8rem;
        gap: 8px;
        margin-bottom: 8px;
    }
    
    .feedback-label svg {
        width: 20px;
        height: 20px;
        padding: 3px;
    }
    
    .feedback-value {
        font-size: 0.9rem;
    }
    
    .star-display {
        padding: 10px 14px;
        gap: 4px;
    }
    
    .fa.fa-star {
        font-size: 1.2rem;
    }
    
    .rating-text {
        font-size: 0.85rem;
        margin-left: 8px;
        padding: 3px 6px;
    }
    
    .feedback-item.comment .feedback-value {
        padding: 14px;
        font-size: 0.85rem;
    }
    
    .feedback-item.satisfaction .feedback-value {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
}

@media (max-width: 480px) {
    .feedback-content {
        gap: 12px;
    }
    
    .feedback-placeholder {
        padding: 24px 16px;
        min-height: 80px;
    }
    
    .star-display {
        flex-direction: column;
        gap: 8px;
        padding: 12px;
    }
    
    .rating-text {
        margin-left: 0;
        margin-top: 4px;
    }
    
    .fa.fa-star {
        font-size: 1.1rem;
    }
    
    .feedback-item.comment .feedback-value::before,
    .feedback-item.comment .feedback-value::after {
        font-size: 1.2rem;
    }
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
    background: #10b981;
}
.status-dot.rejected {
    background: #ef4444;
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

/* Image Modal */
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

    .detail-grid-horizontal {
        grid-template-columns: 1fr;
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

    .saksi-info {
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

    .modal-body {
        max-height: 60vh;
    }

    /* Penyesuaian khusus untuk ulasan pada layar sangat kecil */
    .star-display {
        flex-direction: column; /* Bintang dan teks rating bisa turun baris jika sangat sempit */
        align-items: flex-start;
        gap: 2px;
    }
    .rating-text {
        margin-left: 0;
        margin-top: 4px;
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

/* Scroll Styles */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
#detail-korban, 
#detail-pelaku, 
#detail-saksi {
    display: flex;
    justify-content: center; 
    align-items: center;   
    min-height: 60px;     
    width: 100%;            
    font-style: italic;     
    color: #94a3b8;        
}
.pihak-subsection .detail-item {
    align-items: center;
    text-align: center;
}

.pihak-subsection .detail-label {
    display: none;
}

.resolution-section .section-title svg {
    color: #10b981; /* Warna hijau untuk ikon judul */
}

.resolution-section .section-title::before {
    background: linear-gradient(135deg, #10b981, #059669); /* Gradient hijau */
}

.resolution-grid {
    display: grid;
    grid-template-columns: 2fr 1fr; /* Kolom tindakan lebih lebar */
    gap: 20px;
    margin-bottom: 20px;
    align-items: stretch; /* PENTING: Membuat item di grid memiliki tinggi yang sama */
}

.resolution-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.resolution-item.full-width {
    grid-column: 1 / -1; /* Membuat item ini memakan semua kolom grid */
    margin-top: 10px;
}

.resolution-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.resolution-label svg {
    color: #6366f1;
}

/* Tampilan baru untuk Tindakan Penyelesaian */
.resolution-action-value {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
    border: 1px solid #c7d2fe;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 600;
    color: #4338ca;
    height: 100%; /* Memastikan tinggi sama dengan item di sebelahnya */
}

.resolution-action-value svg {
    flex-shrink: 0;
    color: #6366f1;
}

.resolution-value-date {
    font-size: 1rem;
    color: #059669; /* Warna hijau untuk tanggal */
    font-weight: 700;
    background: #dcfce7; /* Latar belakang hijau muda */
    padding: 12px 16px;
    border-radius: 12px;
    border: 1px solid #a7f3d0;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.resolution-notes {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    padding: 20px 24px;
    border-radius: 16px;
    border-left: 5px solid #0ea5e9; /* Warna biru untuk catatan */
    font-size: 1rem;
    line-height: 1.7;
    color: #0369a1; /* Warna teks biru tua */
    box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
}

.resolution-notes p {
    margin: 0;
    font-style: italic;
}

#buktiPenyelesaianContainer {
    margin-top: 8px;
}

/* Penyesuaian untuk layar kecil */
@media (max-width: 768px) {
    .resolution-grid {
        grid-template-columns: 1fr; /* Tumpuk di layar kecil */
    }
    
    .resolution-action-value,
    .resolution-value-date {
        height: auto; /* Kembalikan tinggi otomatis */
        padding-top: 16px;
        padding-bottom: 16px;
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

