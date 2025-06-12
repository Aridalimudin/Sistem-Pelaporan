<div class="modal fade" id="permissionModal">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Permission Baru</h3>
             <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            <form class="permission-form" id="permissionForm">
                <input type="hidden" id="permissionId">
                <div class="form-group">
                    <label for="permissionName">Nama Permission *</label>
                    <input type="text" id="permissionName" name="permissionName" placeholder="Contoh: user-view, product-create" required>
                    <div class="form-help">Gunakan format: modul-aksi (contoh: user-create, product-edit)</div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit" class="btn-primary" id="submitButton">Simpan Permission</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Delete Confirmation Modal -->
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
                    <h4>Hapus Data Kategori Kasus?</h4>
                    <p>Apakah Anda yakin ingin menghapus data <strong id="deleteRoleName"></strong>?</p>
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

<style>
.delete-modal {
    max-width: 450px;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-30px) scale(0.95);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
    border-radius: 12px 12px 0 0;
}

.delete-header {
    background: #fef2f2;
    border-bottom-color: #fecaca;
}

.delete-icon-header {
    color: #dc2626;
    font-size: 24px;
    margin-right: 10px;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
}
</style>