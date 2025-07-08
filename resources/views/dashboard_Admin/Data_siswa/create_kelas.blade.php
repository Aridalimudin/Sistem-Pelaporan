<div class="modal fade" id="classRoomFormModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Data Kelas Baru</h3>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('classRoomFormModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form class="class-room-form" id="classRoomForm">
                    <input type="hidden" id="classRoomId" name="id">
                    <div class="form-row col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Kelas *</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan Nama Kelas" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal" onclick="closeModal('classRoomFormModal')">Batal</button>
                        <button type="submit" class="btn-primary" id="submitButton">Simpan Kelas</button>
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
                    <p>Apakah Anda yakin ingin menghapus data siswa <strong id="deleteClassRoomName"></strong>?</p>
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