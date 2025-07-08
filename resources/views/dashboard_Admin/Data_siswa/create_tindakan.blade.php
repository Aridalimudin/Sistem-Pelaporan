<div class="modal fade" id="operationFormModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Data Tindakan Baru</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('operationFormModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form class="operation-form" id="operationForm">
                    <input type="hidden" id="operationId" name="id">
                    <div class="form-row col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Tindakan *</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan Nama Tindakan" required>
                        </div>
                    </div>
                    <div class="form-row col-md-12">
                        <div class="form-group">
                            <label for="name">Keterangan</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Keterangan Tindakan" row="5"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal" onclick="closeModal('operationFormModal')">Batal</button>
                        <button type="submit" class="btn-primary" id="submitButton">Simpan Tindakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteConfirmModal">
    <div class="modal-content delete-modal">
        <div class="modal-header delete-header">
            <div class="delete-icon-header">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <h3>Konfirmasi Hapus</h3>
            <button type="button" class="close-button" onclick="closeModal('deleteConfirmModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-confirmation">
                <div class="delete-message">
                    <h4>Hapus Data ?</h4>
                    <p>Apakah Anda yakin ingin menghapus data siswa <strong id="deleteOperationName"></strong>?</p>
                    <div class="warning-box">
                        <i class="fa-solid fa-info-circle"></i>
                        <span>Tindakan ini tidak dapat dibatalkan dan akan menghapus data secara permanen.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('deleteConfirmModal')">
                <i class="fa-solid fa-times"></i> Batal
            </button>
            <button type="button" class="btn-danger" id="confirmDeleteBtn">
                <i class="fa-solid fa-trash"></i> Hapus
            </button>
        </div>
    </div>
</div>