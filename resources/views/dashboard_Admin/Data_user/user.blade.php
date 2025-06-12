@extends('layouts.main_ds')
@section('title', 'User Management - User')
@section('content')

        <main id="content" class="content">
            <header>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
                <h1 class="header-title">Selamat Datang di Dashboard</h1>
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
                            <a href="#" class="profile-item">
                                <i class="fa-solid fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="#" class="profile-item">
                                <i class="fa-solid fa-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                            <a href="#" class="profile-item">
                                <i class="fa-solid fa-question-circle"></i>
                                <span>Bantuan</span>
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
            <h2>Kelola Data User</h2>
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
    </div>

    @include('dashboard_Admin.Data_user.create')
    

    <div class="modal-overlay delete-confirm-modal" id="deleteConfirmModal">
        <div class="modal">
            <div class="modal-header">
                <h3>Konfirmasi Hapus</h3>
                <button class="close-btn" onclick="closeModal('deleteConfirmModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('deleteConfirmModal')">Batal</button>
                <button type="button" class="btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>

    <div class="status-indicator" id="statusIndicator"></div>

    <script>
        // Base URL for your API
        const API_BASE_URL = '/api/users';

        let currentUserId = null;

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('active');
                $("#userFormModal").modal('show')
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    const firstInput = modal.querySelector('input[required]:not([type="hidden"]), select[required]');
                    if (firstInput) {
                        firstInput.focus();
                    }
                }, 100);
            }
        }

        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
            document.getElementById("content").classList.toggle("active");
        }
        
        function toggleProfile() {
            const profileMenu = document.getElementById('profileMenu');
            profileMenu.classList.toggle('show');
        }
        
        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.querySelector('.profile-dropdown');
            const profileMenu = document.getElementById('profileMenu');
            
            if (!profileDropdown.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });
        
        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.querySelector('.profile-dropdown');
            const profileMenu = document.getElementById('profileMenu');
            
            if (!profileDropdown.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
                if (modalId === 'userFormModal') { // Only reset the user form modal
                    resetUserForm();
                }
            }
        }

        // Close modal when clicking outside the modal content
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                const modalId = event.target.getAttribute('id');
                closeModal(modalId);
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const activeModal = document.querySelector('.modal-overlay.active');
                if (activeModal) {
                    const modalId = activeModal.getAttribute('id');
                    closeModal(modalId);
                }
            }
        });

        // Toggle password visibility
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');

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

        // Show status message (Toast)
        function showStatus(message, type = 'success') {
            const indicator = document.getElementById('statusIndicator');
            indicator.innerHTML = message; // Use innerHTML to allow for <br> tags
            indicator.className = 'status-indicator show'; // Reset classes

            if (type === 'error') {
                indicator.style.background = 'var(--danger-color)';
            } else {
                indicator.style.background = 'var(--success-color)';
            }

            setTimeout(() => {
                indicator.classList.remove('show');
            }, 3000);
        }

        // Function to render (display) user data into the table
        async function renderUsers() {
            const tableBody = document.getElementById('userTableBody');
            const loadingIndicator = document.getElementById('loadingIndicator');

            tableBody.innerHTML = ''; // Clear table before re-rendering
            if (loadingIndicator) {
                 // Re-add loading indicator
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px;">Sedang memuat data...</td></tr>`;
            }


            try {
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const users = await response.json();

                tableBody.innerHTML = ''; // Clear loading indicator once data is fetched

                if (users.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data user.</td></tr>`;
                    return;
                }

                users.forEach(user => {
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
                                <button class="btn-action delete" title="Delete" onclick="confirmDeleteUser(${user.id}, '${user.name}')">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    `;
                });
            } catch (error) {
                console.error('Error fetching users:', error);
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px; color: var(--danger-color);">Gagal memuat data user.</td></tr>`;
                showStatus('Gagal memuat data user.', 'error');
            }
        }

        // Function to open the create user modal
        function openCreateUserModal() {
            document.getElementById('modalTitle').textContent = 'Tambah User Baru';
            document.getElementById('submitButton').textContent = 'Simpan User';
            document.getElementById('password').setAttribute('required', 'required'); // Password required for new user
            document.getElementById('passwordGroup').style.display = 'flex'; // Show password field
            currentUserId = null; // Reset current user ID
            resetUserForm(); // Ensure form is clean
            openModal('userFormModal');
        }

        // Function to populate the form when editing a user
        async function editUser(id) {
            try {
                const response = await fetch(`${API_BASE_URL}/${id}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const user = await response.json();

                currentUserId = id;
                document.getElementById('modalTitle').textContent = 'Edit User';
                document.getElementById('submitButton').textContent = 'Update User';

                // Populate form with user data
                document.getElementById('userId').value = user.id;
                document.getElementById('name').value = user.name;
                document.getElementById('username').value = user.username;
                document.getElementById('email').value = user.email;
                document.getElementById('phone').value = user.phone_number || ''; // Handle null phone_number
                document.getElementById('role').value = user.role;
                // Removed status field population
                document.getElementById('password').removeAttribute('required'); // Password not required for edit
                document.getElementById('password').value = ''; // Clear password for security
                document.getElementById('passwordGroup').style.display = 'none'; // Hide password field

                openModal('userFormModal');
            } catch (error) {
                console.error('Error fetching user for edit:', error);
                showStatus('Gagal memuat data user untuk edit.', 'error');
            }
        }

        // --- Improvement: Function for delete confirmation with modal ---
        function confirmDeleteUser(id, name) {
            currentUserId = id; // Store the ID of the user to be deleted
            document.getElementById('deleteUserName').textContent = name; // Display user's name in the modal
            openModal('deleteConfirmModal');
        }

        // Handler for the "Delete" button in the delete confirmation modal
        document.getElementById('confirmDeleteButton').addEventListener('click', async function() {
            if (currentUserId !== null) {
                try {
                    const response = await fetch(`${API_BASE_URL}/${currentUserId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '', // Include CSRF token if using Blade
                        },
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Gagal menghapus user.');
                    }

                    showStatus('User berhasil dihapus!');
                    closeModal('deleteConfirmModal'); // Close confirmation modal after action
                    currentUserId = null; // Reset ID
                    renderUsers(); // Re-render the user list
                } catch (error) {
                    console.error('Error deleting user:', error);
                    showStatus(`Gagal menghapus user: ${error.message}`, 'error');
                }
            }
        });

        // Function to reset the form
        function resetUserForm() {
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            document.getElementById('password').setAttribute('required', 'required');
            document.getElementById('password').type = 'password'; // Revert type to password
            // Ensure the eye icon is reset to 'eye'
            const passwordToggleIcon = document.getElementById('password').nextElementSibling.querySelector('i');
            if (passwordToggleIcon) {
                passwordToggleIcon.classList.remove('fa-eye-slash');
                passwordToggleIcon.classList.add('fa-eye');
            }
            document.getElementById('passwordGroup').style.display = 'flex'; // Ensure password field is visible for new user
            const inputs = document.getElementById('userForm').querySelectorAll('input, select');
            inputs.forEach(input => {
                input.style.borderColor = '#e9ecef'; // Reset border color
            });
            // Removed resetting the status select field
        }

        // Handler when the form is submitted (for add and edit)
        document.getElementById('userForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const userForm = document.getElementById('userForm');
            const formData = new FormData(userForm);
            const userData = Object.fromEntries(formData);

            // Frontend validation for empty fields
            // Exclude 'status' from required field check if it's no longer part of the form
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

            // Special validation for phone number
            const phoneInput = document.getElementById('phone');
            if (phoneInput.value.trim() && !/^\d+$/.test(phoneInput.value.trim())) {
                isValid = false;
                phoneInput.style.borderColor = 'var(--danger-color)';
                showStatus('Nomor HP hanya boleh berisi angka!', 'error');
                if (!firstInvalidField) {
                    firstInvalidField = phoneInput;
                }
                phoneInput.addEventListener('input', function() {
                    this.style.borderColor = '#e9ecef';
                }, { once: true });
            }

            if (!isValid) {
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
                // Only show a general error if no specific error was already shown (e.g., from phone validation)
                if (!document.getElementById('statusIndicator').classList.contains('show')) {
                    showStatus('Mohon lengkapi semua field yang diperlukan!', 'error');
                }
                return; // Stop form submission if validation fails
            }

            try {
                let response;
                let method;
                let url;
                let successMessage;

                if (currentUserId) {
                    // Logic for EDIT user
                    method = 'PUT';
                    url = `${API_BASE_URL}/${currentUserId}`;
                    successMessage = 'User berhasil diupdate!';
                    // If password field is empty, don't send it in the request
                    if (!userData.password) {
                        delete userData.password;
                    }
                } else {
                    // Logic for ADD new user
                    method = 'POST';
                    url = API_BASE_URL;
                    successMessage = 'User berhasil ditambahkan!';
                }

                response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '', // Include CSRF token if using Blade
                    },
                    body: JSON.stringify(userData),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (errorData.errors) {
                        // Handle validation errors from Laravel
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

        // Call renderUsers when DOMContentLoaded
        document.addEventListener('DOMContentLoaded', renderUsers);
    </script>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection