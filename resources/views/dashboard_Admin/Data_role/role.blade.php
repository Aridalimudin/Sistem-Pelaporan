@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Kelola Data Role</h1>
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

    <input type="hidden" id="permissionData" value='{{$permissions}}'>

    <div class="management-section">
        <div class="section-header">
            <h2>Data Role</h2>
            <button class="btn-primary" onclick="openModal('createRoleModal', 'add')">
                <i class="fa-solid fa-plus"></i> Tambah Role
            </button>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th>Total Users</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="roleTableBody">
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ini akan memuat modal dari file create.blade.php --}}
    @include('dashboard_Admin.Data_role.create')

    <div class="status-indicator" id="statusIndicator"></div>

</main>

<script>
    const API_BASE_URL = '/api/roles';
    const allPermissions = JSON.parse(document.getElementById('permissionData').value || '[]');
    let currentModalMode = 'add';
    let rolesData = [];

    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("active");
    }

    function toggleProfile() {
        document.getElementById('profileMenu').classList.toggle('show');
    }

    document.addEventListener('click', function(event) {
        const profileDropdown = document.querySelector('.profile-dropdown');
        if (profileDropdown && !profileDropdown.contains(event.target)) {
            document.getElementById('profileMenu').classList.remove('show');
        }
        if (event.target.classList.contains('modal-overlay') || event.target.classList.contains('modal')) {
            const modalId = event.target.closest('.modal-overlay, .modal').id;
            closeModal(modalId);
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal-overlay, .modal').forEach(modal => {
                if(modal.style.display === 'flex') closeModal(modal.id);
            });
        }
    });

    async function renderRoles() {
        const tableBody = document.getElementById('roleTableBody');
        tableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 20px;">Sedang memuat data...</td></tr>';
        
        try {
            const response = await fetch(API_BASE_URL);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            rolesData = await response.json();
            tableBody.innerHTML = '';
            
            if (rolesData.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data role.</td></tr>`;
                return;
            }

            rolesData.forEach(role => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td><div style="font-weight: 600;">${role.name}</div></td>
                    <td>
                        <div class="permission-list">
                            ${role.permissions.map(perm => `<span class="permission-badge">${perm}</span>`).join('') || 'N/A'}
                        </div>
                    </td>
                    <td>${role.totalUsers} Users</td>
                    <td>${role.createdAt}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action edit" title="Edit Role" onclick="openModal('createRoleModal', 'edit', ${role.id})">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button class="btn-action delete" title="Hapus Role" onclick="openDeleteModal(${role.id}, '${role.name.replace(/'/g, "\\'")}')">
                                <i class="fa-solid fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                `;
            });
        } catch (error) {
            console.error('Error fetching roles:', error);
            tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px; color: var(--danger-color);">Gagal memuat data role.</td></tr>`;
            showStatus('Gagal memuat data.', 'error');
        }
    }

    function renderPermissionsCheckboxes() {
        const permissionsGrid = document.getElementById('permissionsGrid');
        if (!permissionsGrid) return;
        
        permissionsGrid.innerHTML = allPermissions.map(permission => `
            <div class="permission-item">
                <input type="checkbox" id="perm_${permission.id}" name="permissions" value="${permission.id}">
                <label for="perm_${permission.id}">${permission.name}</label>
            </div>
        `).join('');

        permissionsGrid.querySelectorAll('input[name="permissions"]').forEach(cb => {
            cb.addEventListener('change', updateSelectAllCheckboxState);
        });
    }

    function openModal(modalId, mode, roleId = null) {
        const modal = document.getElementById(modalId);
        const modalTitle = document.getElementById('modalTitle');
        const submitButton = document.getElementById('submitButton');
        const roleForm = document.getElementById('roleForm');
        
        currentModalMode = mode;
        roleForm.reset();
        document.querySelectorAll('input[name="permissions"]').forEach(cb => cb.checked = false);
        updateSelectAllCheckboxState();

        if (mode === 'add') {
            modalTitle.textContent = 'Tambah Role Baru';
            submitButton.textContent = 'Simpan Role';
            document.getElementById('roleId').value = '';
        } else if (mode === 'edit') {
            modalTitle.textContent = 'Edit Role';
            submitButton.textContent = 'Update Role';
            const roleToEdit = rolesData.find(role => role.id == roleId);
            if (roleToEdit) {
                document.getElementById('roleId').value = roleToEdit.id;
                document.getElementById('roleName').value = roleToEdit.name;
                
                roleToEdit.permissions.forEach(permName => {
                    const permission = allPermissions.find(p => p.name === permName);
                    if (permission) {
                        const checkbox = document.getElementById(`perm_${permission.id}`);
                        if (checkbox) checkbox.checked = true;
                    }
                });
                updateSelectAllCheckboxState();
            }
        }
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
        if (!document.querySelector('.modal-overlay[style*="flex"], .modal[style*="flex"]')) {
            document.body.style.overflow = 'auto';
        }
    }

    function openDeleteModal(roleId, roleName) {
        const modal = document.getElementById('deleteConfirmModal');
        document.getElementById('deleteRoleName').textContent = roleName;
        document.getElementById('confirmDeleteBtn').onclick = () => confirmDelete(roleId);
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function toggleAllPermissions() {
        const selectAll = document.getElementById('selectAll');
        document.querySelectorAll('input[name="permissions"]').forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    }

    function updateSelectAllCheckboxState() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const allCheckboxes = document.querySelectorAll('input[name="permissions"]');
        const checkedCount = document.querySelectorAll('input[name="permissions"]:checked').length;
        
        if (checkedCount === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCount === allCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }

    // --- FUNGSI YANG DIPERBAIKI ---
    async function handleFormSubmit(event) {
        event.preventDefault();
        
        // 1. Dapatkan elemen tombol
        const submitButton = document.getElementById('submitButton');
        
        const roleId = document.getElementById('roleId').value;
        const roleName = document.getElementById('roleName').value.trim();
        const selectedPermissions = Array.from(document.querySelectorAll('input[name="permissions"]:checked')).map(cb => cb.value);

        if (!roleName) {
            showStatus('Nama role wajib diisi!', 'error');
            return;
        }
        if (selectedPermissions.length === 0) {
            showStatus('Pilih minimal satu permission!', 'error');
            return;
        }

        const data = {
            name: roleName,
            permissions: selectedPermissions,
        };
        
        const url = (currentModalMode === 'edit') ? `${API_BASE_URL}/${roleId}` : API_BASE_URL;
        const method = (currentModalMode === 'edit') ? 'PUT' : 'POST';

        // 2. Ubah tombol ke mode "processing" sebelum request
        submitButton.disabled = true;
        submitButton.innerHTML = 'Processing...';
        submitButton.classList.add('processing');

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });
            
            const result = await response.json();
            if (!response.ok) {
                const errorMessage = result.message || 'Terjadi kesalahan pada server.';
                throw new Error(errorMessage);
            }

            showStatus(result.message, 'success');
            closeModal('createRoleModal');
            renderRoles();
        } catch (error) {
            console.error('Form submission error:', error);
            showStatus(error.message, 'error');
        } finally {
            // 3. Kembalikan tombol ke keadaan semula setelah selesai
            submitButton.disabled = false;
            submitButton.innerHTML = (currentModalMode === 'edit') ? 'Update Role' : 'Simpan Role';
            submitButton.classList.remove('processing');
        }
    }

    async function confirmDelete(roleId) {
        try {
            const response = await fetch(`${API_BASE_URL}/${roleId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            });

            const result = await response.json();
            if (!response.ok) {
                const errorMessage = result.message || 'Gagal menghapus role.';
                throw new Error(errorMessage);
            }

            showStatus(result.message, 'success');
            renderRoles();
        } catch (error) {
            console.error('Delete error:', error);
            showStatus(error.message, 'error');
        } finally {
            closeModal('deleteConfirmModal');
        }
    }

    function showStatus(message, type = 'success') {
        const indicator = document.getElementById('statusIndicator');
        indicator.textContent = message;
        indicator.className = 'status-indicator show';
        indicator.style.backgroundColor = (type === 'error') ? 'var(--danger-color)' : 'var(--success-color)';
        
        setTimeout(() => indicator.classList.remove('show'), 3000);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const roleForm = document.getElementById('roleForm');
        roleForm.addEventListener('submit', handleFormSubmit);

        renderPermissionsCheckboxes();
        renderRoles();
    });
</script>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
<style>
    .btn-primary.processing {
        cursor: not-allowed;
        opacity: 0.9;
    }
    .btn-primary.processing::before {
        content: '';
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.6);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
        vertical-align: middle;
    }
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@endsection