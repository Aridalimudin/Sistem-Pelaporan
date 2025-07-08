<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
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

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content delete-modal">
            <div class="modal-header delete-header">
                <div class="delete-icon-header">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                </div>
                <h3 id="deleteModalTitle">Konfirmasi Hapus</h3>
                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirmation">
                    <div class="delete-message">
                        <h4>Hapus Data Permission?</h4>
                        <p>Apakah Anda yakin ingin menghapus permission <strong id="deleteRoleName"></strong>?</p>
                        <div class="warning-box">
                            <i class="fa-solid fa-info-circle"></i>
                            <span>Tindakan ini tidak dapat dibatalkan dan akan menghapus data secara permanen.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="button" class="btn-danger" id="confirmDeleteBtn">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>