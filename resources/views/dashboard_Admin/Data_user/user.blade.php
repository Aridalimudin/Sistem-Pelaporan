@extends('layouts.main_ds')
@section('title', 'User Management - User')
@section('content')

        <main id="content" class="content">
            <header>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
                <h1 class="header-title">Kelola Data User</h1>
                <div class="user-info">
                    <div class="profile-dropdown">
                        <button class="profile-btn" onclick="toggleProfile()">
                            <i class="fa-solid fa-user-circle"></i>
                            <span class="username">{{ Auth::user()->name ?? 'User' }}</span>
                            <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                        </button>
                        <div class="profile-menu" id="profileMenu">
                            <div class="profile-header">
                                <div class="profile-avatar">
                                    <i class="fa-solid fa-user-circle"></i>
                                </div>
                                <div class="profile-info">
                                    <h4>{{ Auth::user()->name ?? 'User' }}</h4>
                                    <p>{{ Auth::user()->email ?? 'user@example.com' }}</p>
                                    <small style="opacity: 0.8;">
                                        {{ Auth::user()->roles->first()->name ?? 'No Role' }}
                                    </small>
                                </div>
                            </div>
                            <hr class="profile-divider">
                            <a href="{{ route('Profile_page.profile') }}" class="profile-item">
                                <i class="fa-solid fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <hr class="profile-divider">
                            <a href="{{ route('logout') }}" class="profile-item logout-item"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </header>
</head>
<body>

    <div class="management-section">
        <div class="section-header">
            <h2>Data User</h2>
            <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#userFormModal" >
                <i class="fa-solid fa-plus"></i> Tambah User
            </button>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;" id="loadingIndicator">Sedang memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            <div class="pagination-info">
                <span id="paginationInfo">Menampilkan 1-10 dari 42 data</span>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="prevBtn" onclick="changePage(-1)" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                    <span>Sebelumnya</span>
                </button>
                <div class="pagination-numbers" id="paginationNumbers">
                </div>
                <button class="pagination-btn" id="nextBtn" onclick="changePage(1)">
                    <span>Selanjutnya</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    @include('dashboard_Admin.Data_user.create')
    
    <div class="modal-overlay delete-confirm-modal" id="deleteConfirmModal">
        <div class="modal">
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('deleteConfirmModal')">Batal</button>
                <button type="button" class="btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>

    <div class="status-indicator" id="statusIndicator"></div>

    <script>
       // === VARIABEL GLOBAL ===
const API_BASE_URL = '/api/users';
let currentPage = 1;
let itemsPerPage = 10;
let totalPages = 1;
let totalItems = 0;
let allUsers = [];
let currentUserId = null;

        function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Cek apakah ini adalah Bootstrap modal
        if (modalId === 'userFormModal') {
            // Gunakan Bootstrap modal untuk userFormModal
            $("#userFormModal").modal('show');
        } else {
            // Gunakan custom modal untuk modal lainnya
            modal.style.display = 'flex';
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                const firstInput = modal.querySelector('input[required]:not([type="hidden"]), select[required]');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 100);
        }
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Cek apakah ini adalah Bootstrap modal
        if (modalId === 'userFormModal') {
            // Gunakan Bootstrap modal untuk userFormModal
            $("#userFormModal").modal('hide');
        } else {
            // Gunakan custom modal untuk modal lainnya
            modal.style.display = 'none';
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        if (modalId === 'userFormModal') {
            resetUserForm();
        }
        
        if (modalId === 'deleteConfirmModal') {
            currentUserId = null;
        }
    }
}

// === FUNGSI SIDEBAR DAN PROFILE ===
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");
    if (sidebar) sidebar.classList.toggle("active");
    if (content) content.classList.toggle("active");
}

function toggleProfile() {
    const profileMenu = document.getElementById('profileMenu');
    if (profileMenu) {
        profileMenu.classList.toggle('show');
    }
}

// === FUNGSI PASSWORD ===
function togglePasswordVisibility(id) {
    const input = document.getElementById(id);
    const button = input?.nextElementSibling;
    const icon = button?.querySelector('i');

    if (input && icon) {
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
}

// === FUNGSI STATUS INDICATOR ===
function showStatus(message, type = 'success') {
    const indicator = document.getElementById('statusIndicator');
    if (!indicator) return;

    indicator.innerHTML = message;
    indicator.className = 'status-indicator show';

    // Clear existing timeout
    if (indicator.timeoutId) {
        clearTimeout(indicator.timeoutId);
    }

    // Styling berdasarkan tipe
    if (type === 'error') {
        indicator.style.background = 'linear-gradient(135deg, #ff6b6b, #ff5252)';
        indicator.style.boxShadow = '0 4px 20px rgba(255, 107, 107, 0.4)';
    } else {
        indicator.style.background = 'linear-gradient(135deg, #4CAF50, #45a049)';
        indicator.style.boxShadow = '0 4px 20px rgba(76, 175, 80, 0.4)';
    }

    // Style positioning
    Object.assign(indicator.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        zIndex: '10000',
        padding: '15px 25px',
        borderRadius: '8px',
        fontSize: '14px',
        fontWeight: '500',
        maxWidth: '400px',
        color: '#fff',
        transform: 'translateX(0)',
        transition: 'all 0.3s ease'
    });

    // Auto hide
    indicator.timeoutId = setTimeout(() => {
        indicator.style.transform = 'translateX(100%)';
        setTimeout(() => {
            indicator.classList.remove('show');
        }, 300);
    }, 4000);
}

// === FUNGSI PAGINATION ===
function changePage(direction) {
    const newPage = currentPage + direction;
    if (newPage >= 1 && newPage <= totalPages) {
        goToPage(newPage);
    }
}

function goToPage(page) {
    if (page >= 1 && page <= totalPages && page !== currentPage) {
        currentPage = page;
        renderUsersPage();
        updatePagination();
    }
}

function updatePagination() {
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, totalItems);

    const paginationInfo = document.getElementById('paginationInfo');
    if (paginationInfo) {
        paginationInfo.textContent = `Menampilkan ${startItem}-${endItem} dari ${totalItems} data`;
    }

    const paginationNumbers = document.getElementById('paginationNumbers');
    if (!paginationNumbers) return;

    let numbersHtml = '';
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);

    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }

    // Add first page and ellipsis if needed
    if (startPage > 1) {
        numbersHtml += `<button class="page-number" onclick="goToPage(1)">1</button>`;
        if (startPage > 2) {
            numbersHtml += `<span class="pagination-ellipsis">...</span>`;
        }
    }

    // Add page numbers
    for (let i = startPage; i <= endPage; i++) {
        numbersHtml += `
            <button class="page-number ${i === currentPage ? 'active' : ''}"
                    onclick="goToPage(${i})">${i}</button>
        `;
    }

    // Add last page and ellipsis if needed
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            numbersHtml += `<span class="pagination-ellipsis">...</span>`;
        }
        numbersHtml += `<button class="page-number" onclick="goToPage(${totalPages})">${totalPages}</button>`;
    }

    paginationNumbers.innerHTML = numbersHtml;

    // Update button states
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages;
}

// === FUNGSI RENDER USERS ===
function renderUsersPage() {
    const tableBody = document.getElementById('userTableBody');
    if (!tableBody) return;

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const usersForPage = allUsers.slice(startIndex, endIndex);

    tableBody.innerHTML = '';

    if (usersForPage.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px;">Tidak ada data user.</td></tr>`;
        return;
    }

    usersForPage.forEach(user => {
        const row = tableBody.insertRow();
        const nameParts = user.name.split(' ');
        const avatarInitials = nameParts[0].charAt(0).toUpperCase() +
                                (nameParts.length > 1 ? nameParts[nameParts.length - 1].charAt(0).toUpperCase() : '');

        row.innerHTML = `
            <td>
                <div class="user-info-cell">
                    <div class="avatar">${avatarInitials}</div>
                    <span>${user.name}</span>
                </div>
            </td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td><span class="role-badge ${user.role ? user.role.toLowerCase() : ''}">${user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : '-'}</span></td>
            <td>${user.phone_number || '-'}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-action edit" title="Edit" onclick="editUser(${user.id})">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button class="btn-action delete" title="Delete" onclick="openDeleteModal(${user.id}, '${user.name.replace(/'/g, "\\'")}')">
                        <i class="fa-solid fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        `;
    });
}

async function renderUsers() {
    const tableBody = document.getElementById('userTableBody');
    if (!tableBody) return;

    tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px;">Sedang memuat data...</td></tr>`;

    try {
        const response = await fetch(API_BASE_URL);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const users = await response.json();

        allUsers = users;
        totalItems = users.length;
        totalPages = Math.ceil(totalItems / itemsPerPage);

        // Reset to first page if current page is out of bounds
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = 1;
        }

        renderUsersPage();
        updatePagination();
        
    } catch (error) {
        console.error('Error fetching users:', error);
        tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px; color: var(--danger-color);">Gagal memuat data user.</td></tr>`;
        showStatus('Gagal memuat data user.', 'error');
    }
}

// === FUNGSI DELETE MODAL ===
function openDeleteModal(userId, userName) {
    currentUserId = userId;
    const modal = document.getElementById('deleteConfirmModal');
    const userNameSpan = document.getElementById('deleteUserName');
    
    if (userNameSpan) {
        userNameSpan.textContent = userName;
    }
    
    openModal('deleteConfirmModal');
}

async function confirmDelete() {
    if (currentUserId === null) return;

    try {
        const response = await fetch(`${API_BASE_URL}/${currentUserId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Gagal menghapus user.');
        }

        showStatus('Data user berhasil dihapus!', 'success');
        closeModal('deleteConfirmModal');
        await renderUsers();
        
    } catch (error) {
        console.error('Error deleting user:', error);
        showStatus(`Gagal menghapus user: ${error.message}`, 'error');
    }
}

// === FUNGSI USER FORM ===
function openCreateUserModal() {
    resetUserForm();
    currentUserId = null;
    
    const modalTitle = document.getElementById('modalTitle');
    const submitButton = document.getElementById('submitButton');
    const passwordLabel = document.querySelector('label[for="password"]');
    const passwordInput = document.getElementById('password');
    const passwordHint = document.getElementById('passwordHint');
    
    if (modalTitle) modalTitle.textContent = 'Tambah User Baru';
    if (submitButton) submitButton.textContent = 'Simpan User';
    if (passwordLabel) passwordLabel.textContent = 'Password *';
    if (passwordInput) passwordInput.setAttribute('required', 'required');
    if (passwordHint) passwordHint.style.display = 'none';
    
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
        
        const modalTitle = document.getElementById('modalTitle');
        const submitButton = document.getElementById('submitButton');
        const passwordLabel = document.querySelector('label[for="password"]');
        const passwordInput = document.getElementById('password');
        const passwordHint = document.getElementById('passwordHint');
        
        if (modalTitle) modalTitle.textContent = 'Edit User';
        if (submitButton) submitButton.textContent = 'Update User';
        if (passwordLabel) passwordLabel.textContent = 'Password';
        if (passwordInput) {
            passwordInput.removeAttribute('required');
            passwordInput.placeholder = 'Kosongkan jika tidak ingin mengubah';
            passwordInput.value = '';
        }
        if (passwordHint) passwordHint.style.display = 'block';

        // Fill form with user data
        const fields = {
            'userId': user.id,
            'name': user.name,
            'username': user.username,
            'email': user.email,
            'phone': user.phone_number || '',
            'role': user.role
        };

        Object.entries(fields).forEach(([fieldId, value]) => {
            const field = document.getElementById(fieldId);
            if (field) field.value = value;
        });

        openModal('userFormModal');
        
    } catch (error) {
        console.error('Error fetching user for edit:', error);
        showStatus('Gagal memuat data user untuk edit.', 'error');
    }
}

function resetUserForm() {
    const form = document.getElementById('userForm');
    if (!form) return;

    form.reset();
    
    const userId = document.getElementById('userId');
    const passwordInput = document.getElementById('password');
    const passwordHint = document.getElementById('passwordHint');
    
    if (userId) userId.value = '';
    if (passwordInput) {
        passwordInput.setAttribute('required', 'required');
        passwordInput.type = 'password';
        passwordInput.placeholder = 'Masukkan password';
    }
    if (passwordHint) passwordHint.style.display = 'none';
    
    // Reset password toggle icon
    const passwordToggleIcon = passwordInput?.nextElementSibling?.querySelector('i');
    if (passwordToggleIcon) {
        passwordToggleIcon.classList.remove('fa-eye-slash');
        passwordToggleIcon.classList.add('fa-eye');
    }
    
    // Reset field styles
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.style.borderColor = '#e9ecef';
        input.classList.remove('shake', 'password-error');
    });
    
    currentUserId = null;
}

// === EVENT LISTENERS ===
document.addEventListener('DOMContentLoaded', function() {
    // Initial render
    renderUsers();
    
    // Profile dropdown close on outside click
    document.addEventListener('click', function(event) {
        const profileDropdown = document.querySelector('.profile-dropdown');
        const profileMenu = document.getElementById('profileMenu');
        
        if (profileDropdown && profileMenu && !profileDropdown.contains(event.target)) {
            profileMenu.classList.remove('show');
        }
    });

    // Modal close on outside click
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal')) {
            const modalId = event.target.getAttribute('id');
            if (modalId) closeModal(modalId);
        }
    });

    // ESC key to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const activeModal = document.querySelector('.modal.active, .modal[style*="flex"]');
            if (activeModal) {
                const modalId = activeModal.getAttribute('id');
                if (modalId) closeModal(modalId);
            }
        }
    });

    // Phone number validation
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            const value = e.target.value;
            
            if (value && !/^\d*$/.test(value)) {
                e.target.value = value.replace(/[^\d]/g, '');
                e.target.classList.add('shake');
                
                setTimeout(() => {
                    e.target.classList.remove('shake');
                }, 500);
                
                showStatus('Nomor HP hanya boleh berisi angka!', 'error');
            }
        });
    }

    // Add user button event
    const addUserBtn = document.querySelector('[data-bs-target="#userFormModal"]');
    if (addUserBtn) {
        addUserBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openCreateUserModal();
        });
    }

    // Delete confirmation button
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', confirmDelete);
    }

    // User form submission
    const userForm = document.getElementById('userForm');
    if (userForm) {
        userForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(userForm);
            const userData = Object.fromEntries(formData);

            // Validation
            const requiredFields = userForm.querySelectorAll('input[required]:not([type="hidden"]), select[required]');
            let isValid = true;
            let firstInvalidField = null;

            // Reset field styles
            userForm.querySelectorAll('input, select').forEach(field => {
                field.style.borderColor = '#e9ecef';
            });

            // Check required fields
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

            // Phone validation
            const phoneInput = document.getElementById('phone');
            if (phoneInput && phoneInput.value.trim() && !/^\d+$/.test(phoneInput.value.trim())) {
                isValid = false;
                phoneInput.style.borderColor = 'var(--danger-color)';
                if (!firstInvalidField) {
                    firstInvalidField = phoneInput;
                }
            }

            if (!isValid) {
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
                showStatus('Mohon lengkapi semua field yang diperlukan!', 'error');
                return;
            }

            try {
                let response;
                let method;
                let url;
                let successMessage;

                if (currentUserId) {
                    method = 'PUT';
                    url = `${API_BASE_URL}/${currentUserId}`;
                    successMessage = 'Data user berhasil diperbarui!';
                    
                    // Remove empty password for update
                    if (!userData.password) {
                        delete userData.password;
                    }
                } else {
                    method = 'POST';
                    url = API_BASE_URL;
                    successMessage = 'Data user berhasil ditambahkan!';
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
                        errorMessage = Object.values(errorData.errors).flat().join(', ');
                    } else if (errorData.message) {
                        errorMessage = errorData.message;
                    }
                    throw new Error(errorMessage);
                }

                showStatus(successMessage, 'success');
                closeModal('userFormModal');
                await renderUsers();
                
            } catch (error) {
                console.error('Error submitting user form:', error);
                showStatus(`Error: ${error.message}`, 'error');
            }
        });
    }
});

// === EXPOSE FUNCTIONS TO GLOBAL SCOPE ===
window.openModal = openModal;
window.closeModal = closeModal;
window.toggleSidebar = toggleSidebar;
window.toggleProfile = toggleProfile;
window.togglePasswordVisibility = togglePasswordVisibility;
window.changePage = changePage;
window.goToPage = goToPage;
window.editUser = editUser;
window.openDeleteModal = openDeleteModal;
window.openCreateUserModal = openCreateUserModal;
    </script>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection