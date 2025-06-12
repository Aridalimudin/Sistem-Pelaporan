@extends('layouts.main_ds')
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
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;" id="loadingIndicator">Sedang memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('dashboard_Admin.Data_role.create')

    <div class="status-indicator" id="statusIndicator">
        Role berhasil ditambahkan!
    </div>

    <script>
        console.log('Role Management Script loaded');

        const API_BASE_URL = '/api/roles';
        const allPermissions = document.getElementById('permissionData').value ? JSON.parse(document.getElementById('permissionData').value) : [];
        let currentModalMode = 'add';
        let roles = []; // Initialize roles array

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

        // Render permissions in the modal form
        function renderPermissionsCheckboxes() {
            const permissionsGrid = document.getElementById('permissionsGrid');
            if (!permissionsGrid) return;
            
            permissionsGrid.innerHTML = '';

            allPermissions.forEach(permission => {
                const div = document.createElement('div');
                div.classList.add('permission-item');
                div.innerHTML = `
                    <input type="checkbox" id="perm_${permission.id}" name="permissions" value="${permission.id}">
                    <label for="perm_${permission.id}">${permission.name}</label>
                `;
                permissionsGrid.appendChild(div);
            });
        }

        // Render roles in the table
        async function renderRoles() {
            const tableBody = document.getElementById('roleTableBody');
            const loadingIndicator = document.getElementById('loadingIndicator');
            
            tableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 20px;">Sedang memuat data...</td></tr>';
            
            try {
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                roles = data; // Store roles globally
                tableBody.innerHTML = '';
                
                if (roles.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data role.</td></tr>`;
                    return;
                }

                roles.forEach(role => {
                    const row = tableBody.insertRow();
                    row.innerHTML = `
                        <td>
                            <div style="font-weight: 600;">${role.name}</div>
                        </td>
                        <td>
                            <div class="permission-list">
                                ${role.permissions ? role.permissions.map(perm => `<span class="permission-badge">${perm}</span>`).join('') : ''}
                            </div>
                        </td>
                        <td>${role.totalUsers || 0} Users</td>
                        <td>${role.createdAt || new Date().toLocaleDateString('id-ID')}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action edit" title="Edit Role" onclick="openModal('createRoleModal', 'edit', ${role.id})">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <button class="btn-action delete" title="Hapus Role" onclick="openDeleteModal(${role.id}, '${role.name}')">
                                    <i class="fa-solid fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    `;
                });
                
            } catch (error) {
                console.error('Error fetching roles:', error);
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 20px; color: var(--danger-color);">Gagal memuat data role.</td></tr>`;
                showStatus('Gagal memuat data role.', 'error');
            }
        }

        // Modal functions
        function openModal(modalId, mode, roleId = null) {
            const modal = document.getElementById(modalId);
            const modalTitle = document.getElementById('modalTitle');
            const submitButton = document.getElementById('submitButton');
            const roleForm = document.getElementById('roleForm');
            const roleNameInput = document.getElementById('roleName');
            const roleIdInput = document.getElementById('roleId');
            const selectAllCheckbox = document.getElementById('selectAll');

            currentModalMode = mode;

            // Reset form
            roleForm.reset();
            const checkboxes = roleForm.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            if (selectAllCheckbox) {
                selectAllCheckbox.indeterminate = false;
            }

            if (mode === 'add') {
                modalTitle.textContent = 'Tambah Role Baru';
                submitButton.textContent = 'Simpan Role';
                roleIdInput.value = '';
            } else if (mode === 'edit') {
                modalTitle.textContent = 'Edit Role';
                submitButton.textContent = 'Update Role';
                const roleToEdit = roles.find(role => role.id == roleId);
                if (roleToEdit) {
                    roleIdInput.value = roleToEdit.id;
                    roleNameInput.value = roleToEdit.name;
                    
                    // Check permissions if they exist
                    if (roleToEdit.permissions && Array.isArray(roleToEdit.permissions)) {
                        roleToEdit.permissions.forEach(permName => {
                            // Find permission by name and check it
                            const permission = allPermissions.find(p => p.name === permName);
                            if (permission) {
                                const checkbox = document.getElementById(`perm_${permission.id}`);
                                if (checkbox) {
                                    checkbox.checked = true;
                                }
                            }
                        });
                    }
                    updateSelectAllCheckboxState();
                }
            }
            
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    roleNameInput.focus();
                }, 100);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
                
                // Reset form
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
                
                // Reset checkboxes
                const selectAllCheckbox = document.getElementById('selectAll');
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
                
                const permissionCheckboxes = document.querySelectorAll('input[name="permissions"]');
                permissionCheckboxes.forEach(cb => cb.checked = false);
            }
        }

        // Delete modal functions
        function openDeleteModal(roleId, roleName) {
            const modal = document.getElementById('deleteConfirmModal');
            const roleNameSpan = document.getElementById('deleteRoleName');
            const confirmButton = document.getElementById('confirmDeleteBtn');
            
            roleNameSpan.textContent = roleName;
            confirmButton.onclick = () => confirmDelete(roleId);
            modal.style.display = 'flex';
        }

        function confirmDelete(roleId) {
            roles = roles.filter(role => role.id != roleId);
            renderRoles();
            showStatus('Role berhasil dihapus!', 'success');
            closeModal('deleteConfirmModal');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                const modalId = event.target.getAttribute('id');
                closeModal(modalId);
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const activeModals = document.querySelectorAll('.modal-overlay[style*="flex"]');
                activeModals.forEach(modal => {
                    closeModal(modal.id);
                });
            }
        });

        // Toggle all permissions
        function toggleAllPermissions() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions"]');
            
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Update select all checkbox when individual permissions change
        function updateSelectAllCheckboxState() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions"]');
            const checkedPermissions = document.querySelectorAll('input[name="permissions"]:checked');
            
            if (!selectAllCheckbox) return;
            
            if (checkedPermissions.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedPermissions.length === permissionCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }

        // Show status message
        function showStatus(message, type = 'success') {
            const indicator = document.getElementById('statusIndicator');
            indicator.textContent = message;
            indicator.className = 'status-indicator show';
            
            if (type === 'error') {
                indicator.style.background = 'var(--danger-color)';
            } else {
                indicator.style.background = 'var(--success-color)';
            }
            
            setTimeout(() => {
                indicator.classList.remove('show');
            }, 3000);
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            renderPermissionsCheckboxes();
            renderRoles();

            // Add event listener for permission checkboxes
            document.addEventListener('change', function(event) {
                if (event.target.name === 'permissions') {
                    updateSelectAllCheckboxState();
                }
            });

            // Form submission handler
            const roleForm = document.getElementById('roleForm');
            if (roleForm) {
                roleForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const roleId = document.getElementById('roleId').value;
                    const roleName = document.getElementById('roleName').value.trim();
                    const selectedPermissions = document.querySelectorAll('input[name="permissions"]:checked');
                    
                    if (!roleName) {
                        showStatus('Nama role harus diisi!', 'error');
                        document.getElementById('roleName').focus();
                        return;
                    }
                    
                    if (selectedPermissions.length === 0) {
                        showStatus('Pilih minimal satu permission!', 'error');
                        return;
                    }
                    
                    const permissions = Array.from(selectedPermissions).map(checkbox => {
                        const permission = allPermissions.find(p => p.id == checkbox.value);
                        return permission ? permission.name : checkbox.value;
                    });
                    
                    if (currentModalMode === 'add') {
                        const newId = roles.length > 0 ? Math.max(...roles.map(r => r.id)) + 1 : 1;
                        const newRole = {
                            id: newId,
                            name: roleName,
                            permissions: permissions,
                            totalUsers: 0,
                            createdAt: new Date().toLocaleDateString('id-ID', { 
                                day: '2-digit', 
                                month: 'short', 
                                year: 'numeric' 
                            })
                        };
                        roles.push(newRole);
                        showStatus('Role berhasil ditambahkan!', 'success');
                    } else if (currentModalMode === 'edit') {
                        const roleIndex = roles.findIndex(r => r.id == roleId);
                        if (roleIndex > -1) {
                            roles[roleIndex].name = roleName;
                            roles[roleIndex].permissions = permissions;
                            showStatus('Role berhasil diperbarui!', 'success');
                        } else {
                            showStatus('Role tidak ditemukan!', 'error');
                        }
                    }
                    
                    closeModal('createRoleModal');
                    renderRoles();
                });
            }
        });
    </script>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection