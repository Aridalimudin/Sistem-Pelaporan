@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header class="page-header">
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

    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div class="stat-info">
                    <h4 id="totalPermissions">0</h4>
                    <p>Total Permissions</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon used">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h4 id="permissionsUsed">0</h4>
                    <p>Permissions Digunakan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon roles">
                    <i class="fa-solid fa-user-tag"></i>
                </div>
                <div class="stat-info">
                    <h4 id="activeRoles">0</h4>
                    <p>Roles Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <div class="management-section">
        <div class="section-header">
            <div class="section-title">
                <h2>Data Permission</h2>
            </div>
            <button class="btn-primary" data-bs-toggle="modal" data-bs-target="#permissionModal">
                <i class="fa-solid fa-plus"></i> 
                <span>Tambah Permission</span>
            </button>
        </div>

        <div class="search-section">
            <div class="search-container">
                <div class="search-input-wrapper">
                    <div class="search-input">
                        <i class="fa-solid fa-search search-icon"></i>
                        <input type="text" id="searchPermission" placeholder="Cari permission..." onkeyup="searchPermissions()">
                    </div>
                </div>
                <div class="search-info">
                    <span class="result-count">
                        Total: <strong id="displayedPermissionsCount">0 permissions</strong>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-section">
            <div class="table-container">
                <table class="data-table" id="permissionTable">
                    <thead>
                        <tr>
                            <th class="col-permission">Permission</th>
                            <th class="col-usage">Penggunaan</th>
                            <th class="col-date">Dibuat</th>
                            <th class="col-date">Diperbarui</th>
                            <th class="col-actions">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('dashboard_Admin.Data_permission.create')
    
    <div class="status-indicator" id="statusIndicator">
        Permission berhasil ditambahkan!
    </div>
</main>

<script>
    const API_BASE_URL = '/api/permissions';
    let permissions = [];

    function openModal() {
        $("#permissionModal").modal('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            document.getElementById('permissionName').focus();
        }, 100);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            if ($.fn.modal && $(modal).data('bs.modal')) {
                $(modal).modal('hide');
            } else {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
            document.body.style.overflow = 'auto';
            if (modalId === 'permissionModal') {
                resetForm();
            }
        }
    }

    function resetForm() {
        document.getElementById('permissionForm').reset();
        document.getElementById('permissionId').value = '';
        document.getElementById('modalTitle').textContent = 'Tambah Permission Baru';
        document.getElementById('submitButton').textContent = 'Simpan Permission';
    }

    // Event listeners for modal (pastikan ini mengacu pada closeModal yang baru)
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-backdrop')) { // Contoh untuk Bootstrap backdrop
             closeModal('permissionModal'); // Menutup modal permission
             closeModal('deleteConfirmModal'); // Menutup modal delete jika terbuka
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal('permissionModal'); // Menutup modal permission
            closeModal('deleteConfirmModal'); // Menutup modal delete
        }
    });

    // --- CRUD Operations ---
    async function fetchPermissions() {
        try {
            const response = await fetch(API_BASE_URL);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            permissions = data.permissions;
            renderPermissions();
            updateStats(data.stats);
        } catch (error) {
            console.error('Error fetching permissions:', error);
            showStatus('Gagal memuat permissions.', 'error');
        }
    }

    function renderPermissions() {
        const tableBody = document.querySelector('#permissionTable tbody');
        tableBody.innerHTML = '';
        let displayedCount = 0;

        permissions.forEach(permission => {
            const newRow = tableBody.insertRow();
            newRow.dataset.id = permission.id;

            let usageClass = getUsageClass(permission.usage);

            newRow.innerHTML = `
                <td class="permission-cell">
                    <div class="permission-details">
                        <h4 class="permission-name">${permission.name}</h4>
                    </div>
                </td>
                <td class="usage-cell">
                    <span class="usage-badge ${usageClass}">${permission.usage} roles</span>
                </td>
                <td class="date-cell">${formatDate(permission.createdAt)}</td>
                <td class="date-cell">${formatDate(permission.updatedAt)}</td>
                <td class="action-cell">
                    <div class="action-buttons">
                        <button class="btn-action edit" title="Edit Permission" onclick="openEditModal(${permission.id})">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button class="btn-action delete" title="Hapus Permission" onclick="deletePermission(${permission.id})">
                            <i class="fa-solid fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            `;
            displayedCount++;
        });
        
        document.getElementById('displayedPermissionsCount').textContent = `${displayedCount} permissions`;
    }

    function getUsageClass(usage) {
        if (usage >= 3) return 'high';
        if (usage === 2) return 'medium';
        return 'low';
    }

    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        const optionsDate = { day: '2-digit', month: 'short', year: 'numeric' };
        const optionsTime = { hour: '2-digit', minute: '2-digit' };
        const formattedDate = date.toLocaleString('en-GB', optionsDate);
        const formattedTime = date.toLocaleString('en-GB', optionsTime);
        return `<div class="date-info">
                    <span class="date">${formattedDate}</span>
                    <small class="time">${formattedTime}</small>
                </div>`;
    }

    function openEditModal(id) {
        const permission = permissions.find(p => p.id === id);
        if (permission) {
            document.getElementById('permissionId').value = permission.id;
            document.getElementById('permissionName').value = permission.name;
            document.getElementById('modalTitle').textContent = 'Edit Permission';
            document.getElementById('submitButton').textContent = 'Simpan Perubahan';
            openModal();
        }
    }

    // Form submission handler
    document.getElementById('permissionForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const id = document.getElementById('permissionId').value;
        const permissionName = document.getElementById('permissionName').value;

        if (!permissionName.trim()) {
            showStatus('Nama Permission wajib diisi!', 'error');
            return;
        }

        const payload = { name: permissionName.trim() };

        try {
            let response;
            let method = id ? 'PUT' : 'POST';
            let url = id ? `${API_BASE_URL}/${id}` : API_BASE_URL;
            let successMessage = id ? 
                `Permission "${permissionName}" berhasil diperbarui!` : 
                `Permission "${permissionName}" berhasil ditambahkan!`;

            response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const responseData = await response.json();

            if (!response.ok) {
                const errorMessage = responseData.message || 'Terjadi kesalahan saat memproses data.';
                showStatus(errorMessage, 'error');
                return;
            }
            
            showStatus(successMessage, 'success');
            closeModal('permissionModal'); // Tutup modal permission
            fetchPermissions();
        } catch (error) {
            console.error('Error submitting form:', error);
            showStatus('Gagal menyimpan permission. Terjadi kesalahan jaringan atau server.', 'error');
        }
    });

    // Ini adalah fungsi yang memicu modal konfirmasi delete
    async function deletePermission(id) {
        const permissionToDelete = permissions.find(p => p.id === id);
        if (!permissionToDelete) {
            showStatus('Permission tidak ditemukan.', 'error');
            return;
        }

        // Panggil modal konfirmasi hapus yang ditingkatkan
        openDeleteModal(id, permissionToDelete.name);
    }

    // Delete modal functions
    function openDeleteModal(idToDelete, nameToDelete) {
        const modal = document.getElementById('deleteConfirmModal');
        const roleNameSpan = document.getElementById('deleteRoleName'); // Ini ID 'deleteRoleName' di modal create.blade.php Anda
        const confirmButton = document.getElementById('confirmDeleteBtn');

        if (modal && roleNameSpan && confirmButton) {
            roleNameSpan.textContent = nameToDelete; // Atur nama permission di sini
            confirmButton.onclick = () => confirmDelete(idToDelete); // Atur aksi untuk tombol konfirmasi
            // Gunakan fungsi modal Bootstrap jika Anda memiliki Bootstrap JS yang dimuat
            // Jika tidak, Anda dapat secara manual menambah/menghapus kelas 'show' dan mengelola gaya tampilan
            $('#deleteConfirmModal').modal('show'); // Diasumsikan Bootstrap 5 digunakan, jika tidak gunakan jQuery atau Vanilla JS sesuai pengaturan modal Anda
            document.body.style.overflow = 'hidden';
        } else {
            console.error("Elemen modal delete atau komponennya tidak ditemukan.");
        }
    }

    async function confirmDelete(idToDelete) {
        try {
            const response = await fetch(`${API_BASE_URL}/${idToDelete}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' },
            });

            const responseData = await response.json();

            if (!response.ok) {
                const errorMessage = responseData.message || 'Terjadi kesalahan saat menghapus data.';
                showStatus(errorMessage, 'error');
                return;
            }

            showStatus(responseData.message, 'success');
            fetchPermissions(); // Muat ulang dan render permission setelah penghapusan
        } catch (error) {
            console.error('Error deleting permission:', error);
            showStatus('Gagal menghapus permission. Terjadi kesalahan jaringan atau server.', 'error');
        } finally {
            closeModal('deleteConfirmModal'); // Tutup modal konfirmasi hapus
        }
    }

    // Search functionality
    function searchPermissions() {
        const searchTerm = document.getElementById('searchPermission').value.toLowerCase().trim();
        const tableBody = document.querySelector('#permissionTable tbody');
        tableBody.innerHTML = '';
        
        const filteredPermissions = permissions.filter(permission => 
            permission.name.toLowerCase().includes(searchTerm)
        );

        filteredPermissions.forEach(permission => {
            const newRow = tableBody.insertRow();
            newRow.dataset.id = permission.id;
            
            let usageClass = getUsageClass(permission.usage);

            newRow.innerHTML = `
                <td class="permission-cell">
                    <div class="permission-details">
                        <h4 class="permission-name">${permission.name}</h4>
                    </div>
                </td>
                <td class="usage-cell">
                    <span class="usage-badge ${usageClass}">${permission.usage} roles</span>
                </td>
                <td class="date-cell">${formatDate(permission.createdAt)}</td>
                <td class="date-cell">${formatDate(permission.updatedAt)}</td>
                <td class="action-cell">
                    <div class="action-buttons">
                        <button class="btn-action edit" title="Edit Permission" onclick="openEditModal(${permission.id})">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button class="btn-action delete" title="Hapus Permission" onclick="deletePermission(${permission.id})">
                            <i class="fa-solid fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            `;
        });
        
        document.getElementById('displayedPermissionsCount').textContent = `${filteredPermissions.length} permissions`;
    }

    // Status indicator
    function showStatus(message, type = 'success') {
        const indicator = document.getElementById('statusIndicator');
        indicator.textContent = message;
        indicator.className = `status-indicator show ${type}`;

        setTimeout(() => {
            indicator.classList.remove('show');
        }, 3000);
    }
    
    // Update statistics
    function updateStats(stats) {
        document.getElementById('totalPermissions').textContent = stats.totalPermissions;
        document.getElementById('permissionsUsed').textContent = stats.permissionsUsed;
        document.getElementById('activeRoles').textContent = stats.activeRoles;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', () => {
        fetchPermissions();
    });
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
</script>
<style>
/* Stats Section - Design Simple */
.stats-section {
    padding: 2rem 1.5rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

/* Card 1 - Total Permissions (Biru) */
.stat-card:nth-child(1) {
    border-left-color: #3b82f6;
}

.stat-card:nth-child(1) .stat-icon {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

/* Card 2 - Permissions Digunakan (Hijau) */
.stat-card:nth-child(2) {
    border-left-color: #10b981;
}

.stat-card:nth-child(2) .stat-icon {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

/* Card 3 - Roles Aktif (Ungu) */
.stat-card:nth-child(3) {
    border-left-color: #8b5cf6;
}

.stat-card:nth-child(3) .stat-icon {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
}

.stat-info h4 {
    margin: 0 0 0.5rem 0;
    font-size: 2.25rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
}

.stat-info p {
    margin: 0;
    font-size: 1rem;
    color: #6b7280;
    font-weight: 500;
    line-height: 1.4;
}

/* Responsive Design untuk Stats */
@media (max-width: 768px) {
    .stats-section {
        padding: 1.5rem 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1.5rem;
        gap: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        font-size: 1.2rem;
    }

    .stat-info h4 {
        font-size: 1.875rem;
    }

    .stat-info p {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .stats-section {
        padding: 1rem 0.5rem;
    }

    .stat-card {
        padding: 1.25rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
    }

    .stat-info h4 {
        font-size: 1.75rem;
    }
}
</style>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection