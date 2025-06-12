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

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.5s ease-in-out;
}

.password-error {
    border-color: #dc3545 !important;
    box-shadow: 0 0 5px rgba(220, 53, 69, 0.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    function openCreateUserModal() {
        resetUserForm();
        currentUserId = null; 
        document.getElementById('modalTitle').textContent = 'Tambah User Baru';
        document.getElementById('submitButton').textContent = 'Simpan User';
        document.getElementById('passwordLabel').textContent = 'Password *';
        document.getElementById('password').setAttribute('required', 'required');
        document.getElementById('passwordHint').style.display = 'none';
        
        openModal('userFormModal');
    }

    async function editUser(id) {
        try {
            const response = await fetch(`${API_BASE_URL}/${id}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const user = await response.json();

            resetUserForm();
            
            currentUserId = id;
            
            document.getElementById('modalTitle').textContent = 'Edit User';
            document.getElementById('submitButton').textContent = 'Update User';
            document.getElementById('passwordLabel').textContent = 'Password';
            document.getElementById('password').removeAttribute('required');
            document.getElementById('passwordHint').style.display = 'block';

            document.getElementById('userId').value = user.id;
            document.getElementById('name').value = user.name;
            document.getElementById('username').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('phone').value = user.phone_number || '';
            document.getElementById('role').value = user.role;
            
            document.getElementById('password').placeholder = 'Masukan password';
            document.getElementById('password').value = '';

            openModal('userFormModal');
        } catch (error) {
            console.error('Error fetching user for edit:', error);
            showStatus('Gagal memuat data user untuk edit.', 'error');
        }
    }

    function resetUserForm() {
        const form = document.getElementById('userForm');
        form.reset();
        
        // Reset semua field
        document.getElementById('userId').value = '';
        document.getElementById('password').setAttribute('required', 'required');
        document.getElementById('password').type = 'password';
        document.getElementById('passwordHint').style.display = 'none';
        
        // Reset icon mata password
        const passwordToggleIcon = document.getElementById('password').nextElementSibling.querySelector('i');
        if (passwordToggleIcon) {
            passwordToggleIcon.classList.remove('fa-eye-slash');
            passwordToggleIcon.classList.add('fa-eye');
        }
        
        // Reset border color semua input
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.style.borderColor = '#e9ecef';
            input.classList.remove('shake', 'password-error');
        });
        
        // Reset modal state
        currentUserId = null;
    }

    // Function untuk close modal (diperbaiki)
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
            
            // Reset form ketika modal ditutup
            if (modalId === 'userFormModal') {
                resetUserForm();
            }
            
            // Tutup modal Bootstrap jika menggunakan Bootstrap
            if (typeof bootstrap !== 'undefined') {
                const bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal) {
                    bootstrapModal.hide();
                }
            }
        }
    }

    document.getElementById('phone').addEventListener('input', function(e) {
        const phoneInput = e.target;
        const value = phoneInput.value;
        
        // Hanya izinkan angka
        if (value && !/^\d*$/.test(value)) {
            phoneInput.value = value.replace(/[^\d]/g, '');
            phoneInput.classList.add('shake');
            
            setTimeout(() => {
                phoneInput.classList.remove('shake');
            }, 500);
            
            // Tampilkan alert di dalam modal
            showStatus('Nomor HP hanya boleh berisi angka!', 'error');
        }
    });

    // Event listener untuk tombol tambah user
    document.querySelector('[data-bs-target="#userFormModal"]').addEventListener('click', function(e) {
        e.preventDefault();
        openCreateUserModal();
    });

    // Perbaikan submit form
    document.getElementById('userForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const userForm = document.getElementById('userForm');
        const formData = new FormData(userForm);
        const userData = Object.fromEntries(formData);

        // Validasi field yang diperlukan
        const requiredFields = userForm.querySelectorAll('input[required]:not([type="hidden"]), select[required]');
        let isValid = true;
        let firstInvalidField = null;

        // Clear previous error highlights
        userForm.querySelectorAll('input, select').forEach(field => {
            field.style.borderColor = '#e9ecef';
        });

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = 'var(--danger-color)';
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
                field.addEventListener('input', function() {
                    this.style.borderColor = '#e9ecef';
                }, { once: true });
            }
        });

        // Validasi khusus untuk nomor HP agar muncul di dalam modal
        const phoneInput = document.getElementById('phone');
        if (phoneInput.value.trim() && !/^\d+$/.test(phoneInput.value.trim())) {
            isValid = false;
            phoneInput.style.borderColor = 'var(--danger-color)';
            if (!firstInvalidField) {
                firstInvalidField = phoneInput;
            }
            // showStatus('Nomor HP hanya boleh berisi angka!', 'error'); // Ini akan ditampilkan oleh event listener 'input' di atas
        }


        if (!isValid) {
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
            // Hanya tampilkan pesan umum jika belum ada pesan spesifik dari validasi nomor HP
            if (!document.getElementById('statusIndicator').classList.contains('show')) {
                showStatus('Mohon lengkapi semua field yang diperlukan!', 'error');
            }
            return;
        }

        try {
            let response;
            let method;
            let url;
            let successMessage;

            if (currentUserId) {
                // Edit user
                method = 'PUT';
                url = `${API_BASE_URL}/${currentUserId}`;
                successMessage = 'User berhasil diupdate!';
                
                // Jika password kosong, jangan kirim dalam request
                if (!userData.password) {
                    delete userData.password;
                }
            } else {
                // Tambah user baru
                method = 'POST';
                url = API_BASE_URL;
                successMessage = 'User berhasil ditambahkan!';
            }

            response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify(userData),
            });

            if (!response.ok) {
                const errorData = await response.json();
                let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                if (errorData.errors) {
                    errorMessage = Object.values(errorData.errors).flat().join('<br>');
                } else if (errorData.message) {
                    errorMessage = errorData.message;
                }
                throw new Error(errorMessage);
            }

            showStatus(successMessage);
            renderUsers();
            closeModal('userFormModal');
        } catch (error) {
            console.error('Error submitting user form:', error);
            showStatus(`Error: ${error.message}`, 'error');
        }
    });

    // Expose functions to global scope jika diperlukan
    window.openCreateUserModal = openCreateUserModal;
    window.editUser = editUser;
    window.resetUserForm = resetUserForm;
    window.closeModal = closeModal;
});
</script>
