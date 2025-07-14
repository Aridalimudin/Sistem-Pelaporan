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
                                    <div class="detail-value" id="detailTanggal">12 Juli 2025</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        NIS (Nomor Induk Siswa)
                                    </div>
                                    <div class="detail-value" id="detailNIS">21221001</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Email
                                    </div>
                                    <div class="detail-value" id="detailEmail">pelapor@example.com</div>
                                </div>
                            </div>
                        </div>


                        <div class="detail-section resolution-section">
                            <h4 class="section-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Penyelesaian Laporan
                            </h4>
                            
                            <div class="resolution-grid">
                                <div class="resolution-item">
                                    <div class="resolution-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.17 8.83l-6.36-6.36a2.12 2.12 0 00-3 0L3 11.17a2.12 2.12 0 000 3l6.36 6.36a2.12 2.12 0 003 0l8.81-8.81a2.12 2.12 0 000-2.89z" stroke="currentColor" stroke-width="2"/><path d="M9.5 14.5L14.5 9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        Tindakan Penyelesaian
                                    </div>
                                    <div class="resolution-action-value" id="detailTindakanPenyelesaian">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M22 4L12 14.01l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <span>Program Konseling Intensif</span>
                                    </div>
                                </div>
                                
                                <div class="resolution-item">
                                    <div class="resolution-label">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2"/><line x1="16" y1="2" x2="16" y2="6" stroke="currentColor" stroke-width="2"/><line x1="8" y1="2" x2="8" y2="6" stroke="currentColor" stroke-width="2"/><line x1="3" y1="10" x2="21" y2="10" stroke="currentColor" stroke-width="2"/></svg>
                                        Tanggal Penyelesaian
                                    </div>
                                    <div class="resolution-value-date" id="detailTanggalPenyelesaian">14 Juli 2025</div>
                                </div>
                            </div>
                            
                            <div class="resolution-item full-width">
                                <div class="resolution-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" stroke="currentColor" stroke-width="2"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Catatan Penyelesaian
                                </div>
                                <div class="resolution-notes" id="detailCatatanPenyelesaian">
                                    <p>Siswa yang bersangkutan telah memulai sesi pertama program konseling. Perkembangan akan dipantau selama 2 minggu ke depan.</p>
                                </div>
                            </div>
                            
                            <div class="resolution-item full-width">
                                <div class="resolution-label">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 14.899A7 7 0 1115.71 8h1.79a4.5 4.5 0 012.5 8.242M12 12v9" stroke="currentColor" stroke-width="2"/><path d="M8 17l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Bukti Penyelesaian
                                </div>
                                <div class="bukti-container" id="buktiPenyelesaianContainer">
                                    <div class="bukti-grid">
                                        <div class="bukti-item" onclick="openImageModal(this)">
                                            <img src="https://via.placeholder.com/300x200.png/EBF5FF/868E96?text=Jadwal+Konseling.pdf" alt="Jadwal Konseling">
                                            <div class="bukti-info">
                                                <div class="bukti-name">jadwal_konseling_siswa.pdf</div>
                                                <div class="bukti-size">112 KB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="detail-section">
                            <h4 class="section-title">Ulasan Pelapor</h4>
                            </div>

                    </div>
                </div>

                <div class="modal-footer">
                    </div>
            </form>
        </div>
    </div>
</div>