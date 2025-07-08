<div class="modal-overlay" id="createRoleModal">
    <div class="modal-dialog1">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Role Baru</h3>
                <button type="button" class="close-btn" onclick="closeModal('createRoleModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form class="role-form" id="roleForm">
                    <input type="hidden" id="roleId" name="roleId">
                    <div class="form-group">
                        <label for="roleName">Nama Role *</label>
                        <input type="text" id="roleName" name="roleName" placeholder="Masukkan nama role" required>
                    </div>
                    
                    <div class="permissions-section">
                        <div class="permissions-header">
                            <i class="fa-solid fa-key"></i>
                            Pilih Permissions
                        </div>
                        
                        <div class="select-all-container">
                            <input type="checkbox" id="selectAll" onchange="toggleAllPermissions()">
                            <label for="selectAll" style="font-weight: 600;">Pilih Semua Permissions</label>
                        </div>
                        
                        <div class="permissions-grid" id="permissionsGrid">
                            <!-- Permissions akan dirender di sini -->
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('createRoleModal')">Batal</button>
                        <button type="submit" class="btn-primary" id="submitButton">Simpan Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Enhanced Delete Confirmation Modal -->
<div class="modal" id="deleteConfirmModal">
    <div class="modal-dialog">
        <div class="modal-content delete-modal">
            <div class="modal-header delete-header">
                <div class="delete-icon-header">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                </div>
                <h3>Konfirmasi Hapus</h3>
                <button type="button" class="close-btn" onclick="closeModal('deleteConfirmModal')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirmation">
                    <div class="delete-message">
                        <h4>Hapus Data Role?</h4>
                        <p>Apakah Anda yakin ingin menghapus role <strong id="deleteRoleName"></strong>?</p>
                        <div class="warning-box">
                            <i class="fa-solid fa-info-circle"></i>
                            <span>Tindakan ini tidak dapat dibatalkan dan akan menghapus data secara permanen.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('deleteConfirmModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="button" class="btn-danger" id="confirmDeleteBtn">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>