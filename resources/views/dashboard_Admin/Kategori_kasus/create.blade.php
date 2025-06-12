<!-- Create/Edit Modal -->
<div id="createRoleModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Data Kategori Kasus</h3>
            <span class="close-button" onclick="closeModal('createRoleModal')">&times;</span>
        </div>
        <form id="crimeForm">
            <div class="modal-body">
                <div class="form-group">
                    <label for="crimeName">Nama Kejahatan:</label>
                    <input type="text" id="crimeName" name="name" required maxlength="100" placeholder="Masukkan nama kejahatan">
                </div>
                <div class="form-group">
                    <label for="crimeType">Jenis Kategori:</label>
                    <select id="crimeType" name="type" required>
                        <option value="">Pilih Jenis Kategori</option>
                        <option value="Bullying Verbal">Bullying Verbal</option>
                        <option value="Bullying Fisik">Bullying Fisik</option>
                        <option value="Pelecehan Seksual Verbal">Pelecehan Seksual Verbal</option>
                        <option value="Pelecehan Seksual Fisik">Pelecehan Seksual Fisik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="urgencyLevel">Tingkat Urgensi:</label>
                    <select id="urgencyLevel" name="urgency" required>
                        <option value="">Pilih Tingkat Urgensi</option>
                        <option value="1">Rendah</option>
                        <option value="2">Sedang</option>
                        <option value="3">Tinggi</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('createRoleModal')">
                    <i class="fa-solid fa-times"></i> Batal
                </button>
                <button type="submit" class="btn-primary" id="saveCrimeBtn">
                    <i class="fa-solid fa-save"></i> Simpan
                </button>
            </div>
        </form>
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

<!-- Status Indicator -->
<div class="status-indicator" id="statusIndicator">
    <i class="fa-solid fa-check-circle"></i>
    <span>Data berhasil ditambahkan!</span>
</div>

<style>
    .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(2px);
}

.modal.show {
    display: flex;
}

.modal-content {
    background-color: #ffffff;
    margin: auto;
    padding: 0;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    animation: modalSlideIn 0.3s ease-out forwards;
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    overflow: hidden;
}

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