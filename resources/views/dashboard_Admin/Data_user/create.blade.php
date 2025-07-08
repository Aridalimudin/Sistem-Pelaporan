<div class="modal fade" id="userFormModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah User Baru</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('userFormModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form class="user-form" id="userForm">
                    <input type="hidden" id="userId" name="id">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" placeholder="Masukkan alamat email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">No. HP</label>
                            <input type="text" id="phone" name="phone_number" placeholder="Masukkan nomor telepon" pattern="[0-9]*" inputmode="numeric">
                        </div>
                    </div>
                    <div class="form-row">
                <div class="form-group" id="passwordGroup">
                    <label for="password" id="passwordLabel">Password *</label>
                    <div class="password-input">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password')">
                            <i class="fa-solid fa-eye"></i>
                        </button>   
                            </div>
                            <small id="passwordHint" style="color: red; margin-top: 5px;">
                                Kosongkan jika tidak ingin mengubah password
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="role">Role *</label>
                            <select id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal" onclick="closeModal('userFormModal')">Batal</button>
                        <button type="submit" class="btn-primary" id="submitButton">Simpan User</button>
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
                    <h4>Hapus Data ?</h4>
                    <p>Apakah Anda yakin ingin menghapus data user <strong id="deleteUserName"></strong>?</p>
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
