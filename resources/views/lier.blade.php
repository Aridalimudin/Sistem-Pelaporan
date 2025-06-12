






/@extends('layouts.main_ds')
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

    <input type="hidden" id="permissionData" value=''>
    
    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stats-card bullying-verbal">
            <div class="stats-icon">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div class="stats-content">
                <h3 id="bullyingVerbalCount">0</h3>
                <p>Bullying Verbal</p>
            </div>
        </div>
        <div class="stats-card bullying-fisik">
            <div class="stats-icon">
                <i class="fa-solid fa-hand-fist"></i>
            </div>
            <div class="stats-content">
                <h3 id="bullyingFisikCount">0</h3>
                <p>Bullying Fisik</p>
            </div>
        </div>
        <div class="stats-card pelecehan-verbal">
            <div class="stats-icon">
                <i class="fa-solid fa-exclamation-triangle"></i>
            </div>
            <div class="stats-content">
                <h3 id="pelecehanVerbalCount">0</h3>
                <p>Pelecehan Seksual Verbal</p>
            </div>
        </div>
        <div class="stats-card pelecehan-fisik">
            <div class="stats-icon">
                <i class="fa-solid fa-hand-paper"></i>
            </div>
            <div class="stats-content">
                <h3 id="pelecehanFisikCount">0</h3>
                <p>Pelecehan Seksual Fisik</p>
            </div>
        </div>
    </div>

    <div class="management-section">
        <div class="section-header">
            <h2>Data Kategori Kasus</h2>
            <div class="header-actions">
                <div class="filter-container">
                    <select id="categoryFilter" class="filter-select" onchange="filterByCategory()">
                        <option value="">Semua Kategori</option>
                        <option value="Bullying Verbal">Bullying Verbal</option>
                        <option value="Bullying Fisik">Bullying Fisik</option>
                        <option value="Pelecehan Seksual Verbal">Pelecehan Seksual Verbal</option>
                        <option value="Pelecehan Seksual Fisik">Pelecehan Seksual Fisik</option>
                    </select>
                </div>
                <button class="btn-primary" onclick="openModal('createRoleModal', 'add')">
                    <i class="fa-solid fa-plus"></i> Tambah Data
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Kejahatan</th>
                        <th>Jenis Kategori</th>
                        <th>Tingkat Urgensi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="roleTableBody">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination - Versi yang Diperbaiki -->
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
                    <!-- Page numbers akan diisi oleh JavaScript -->
                </div>
                <button class="pagination-btn" id="nextBtn" onclick="changePage(1)">
                    <span>Selanjutnya</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>

    @include('dashboard_Admin.Kategori_kasus.create')

    <div class="status-indicator" id="statusIndicator">
        Data berhasil ditambahkan!
    </div>

    <script>
        // Data dummy dari seeder
        const crimeData = [
            { name: 'Hinaan', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Ejekan', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Panggilan buruk', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Cemoohan', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Penghinaan', type: 'Bullying Verbal', urgency: 3 },
            { name: 'Sindiran', type: 'Bullying Verbal', urgency: 1 },
            { name: 'Olok-olokan', type: 'Bullying Verbal', urgency: 1 },
            { name: 'Dikatakan bodoh', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Dikatakan tidak berguna', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Makian', type: 'Bullying Verbal', urgency: 3 },
            { name: 'Umpatan', type: 'Bullying Verbal', urgency: 3 },
            { name: 'Kata-kata kasar', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Mempermalukan', type: 'Bullying Verbal', urgency: 3 },
            { name: 'Menyebar foto memalukan', type: 'Bullying Verbal', urgency: 3 },
            { name: 'Sebar info pribadi', type: 'Bullying Verbal', urgency: 3 },
            { name: 'Gosip buruk', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Meneriaki', type: 'Bullying Verbal', urgency: 2 },
            { name: 'Tampar', type: 'Bullying Fisik', urgency: 2 },
            { name: 'Pukul', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Serang', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Dorong', type: 'Bullying Fisik', urgency: 2 },
            { name: 'Tekan', type: 'Bullying Fisik', urgency: 2 },
            { name: 'Hajar', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Tumbuk', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Tikam', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Tendang', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Lempar', type: 'Bullying Fisik', urgency: 2 },
            { name: 'Gigit', type: 'Bullying Fisik', urgency: 2 },
            { name: 'Cengkeram', type: 'Bullying Fisik', urgency: 2 },
            { name: 'Ancaman kekerasan', type: 'Bullying Fisik', urgency: 3 },
            { name: 'Cabul', type: 'Pelecehan Seksual Verbal', urgency: 3 },
            { name: 'Goda', type: 'Pelecehan Seksual Verbal', urgency: 2 },
            { name: 'Komentar seksual', type: 'Pelecehan Seksual Verbal', urgency: 3 },
            { name: 'Ajakan tidak pantas', type: 'Pelecehan Seksual Verbal', urgency: 3 },
            { name: 'Mengomentari tubuh', type: 'Pelecehan Seksual Verbal', urgency: 3 },
            { name: 'Panggilan seksual', type: 'Pelecehan Seksual Verbal', urgency: 3 },
            { name: 'Lelucon seksual', type: 'Pelecehan Seksual Verbal', urgency: 2 },
            { name: 'Pesan negatif', type: 'Pelecehan Seksual Verbal', urgency: 2 },
            { name: 'Raba', type: 'Pelecehan Seksual Fisik', urgency: 3 },
            { name: 'Sentuh', type: 'Pelecehan Seksual Fisik', urgency: 3 },
            { name: 'Cium', type: 'Pelecehan Seksual Fisik', urgency: 3 },
            { name: 'Peluk', type: 'Pelecehan Seksual Fisik', urgency: 3 }
        ];

        const API_BASE_URL = '/api/roles';
        const allPermissions = document.getElementById('permissionData').value ? JSON.parse(document.getElementById('permissionData').value) : [];
        let currentModalMode = 'add';
        let roles = []; 
        let filteredData = [...crimeData]; // Data yang sudah difilter
        
        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;

        function updateStatistics() {
            const bullyingVerbal = crimeData.filter(crime => crime.type === 'Bullying Verbal').length;
            const bullyingFisik = crimeData.filter(crime => crime.type === 'Bullying Fisik').length;
            const pelecehanVerbal = crimeData.filter(crime => crime.type === 'Pelecehan Seksual Verbal').length;
            const pelecehanFisik = crimeData.filter(crime => crime.type === 'Pelecehan Seksual Fisik').length;

            document.getElementById('bullyingVerbalCount').textContent = bullyingVerbal;
            document.getElementById('bullyingFisikCount').textContent = bullyingFisik;
            document.getElementById('pelecehanVerbalCount').textContent = pelecehanVerbal;
            document.getElementById('pelecehanFisikCount').textContent = pelecehanFisik;
        }

        function filterByCategory() {
            const selectedCategory = document.getElementById('categoryFilter').value;
            
            if (selectedCategory === '') {
                filteredData = [...crimeData];
            } else {
                filteredData = crimeData.filter(crime => crime.type === selectedCategory);
            }
            
            currentPage = 1; // Reset ke halaman pertama
            renderTable();
        }

        function getUrgencyText(level) {
            switch(level) {
                case 1: return 'Rendah';
                case 2: return 'Sedang';
                case 3: return 'Tinggi';
                default: return 'Tidak Diketahui';
            }
        }

        function getUrgencyClass(level) {
            switch(level) {
                case 1: return 'urgency-low';
                case 2: return 'urgency-medium';
                case 3: return 'urgency-high';
                default: return '';
            }
        }

        function renderTable() {
            const tableBody = document.getElementById('roleTableBody');
            const totalItems = filteredData.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const currentData = filteredData.slice(startIndex, endIndex);

            let html = '';
            currentData.forEach((crime, index) => {
                const actualIndex = startIndex + index + 1;
                const originalIndex = crimeData.indexOf(crime) + 1;
                html += `
                    <tr>
                        <td>${actualIndex}</td>
                        <td>${crime.name}</td>
                        <td><span class="category-badge">${crime.type}</span></td>
                        <td><span class="urgency-badge ${getUrgencyClass(crime.urgency)}">${getUrgencyText(crime.urgency)}</span></td>
                        <td class="action-buttons">
                            <button class="btn-edit" onclick="editCrime(${originalIndex})" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button class="btn-delete" onclick="openDeleteModal(${originalIndex})" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            tableBody.innerHTML = html;
            updatePagination(totalItems, totalPages);
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


        function updatePagination(totalItems, totalPages) {
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);
            
            document.getElementById('paginationInfo').textContent = 
                `Menampilkan ${startItem}-${endItem} dari ${totalItems} data`;

            // Update pagination numbers
            const paginationNumbers = document.getElementById('paginationNumbers');
            let numbersHtml = '';
            
            // Show page numbers (max 5 visible)
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            
            if (endPage - startPage < 4) {
                startPage = Math.max(1, endPage - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                numbersHtml += `
                    <button class="page-number ${i === currentPage ? 'active' : ''}" 
                            onclick="goToPage(${i})">${i}</button>
                `;
            }
            
            paginationNumbers.innerHTML = numbersHtml;

            // Update navigation buttons
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;
        }

        function changePage(direction) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const newPage = currentPage + direction;
            if (newPage >= 1 && newPage <= totalPages) {
                currentPage = newPage;
                renderTable();
            }
        }

        function goToPage(page) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderTable();
            }
        }

        // Action functions
        function editCrime(id) {
            alert(`Edit crime dengan ID: ${id}`);
        }

        function deleteCrime(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                alert(`Hapus crime dengan ID: ${id}`);
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

        document.addEventListener('click', function(event) {
            const profileDropdown = document.querySelector('.profile-dropdown');
            const profileMenu = document.getElementById('profileMenu');
            
            if (!profileDropdown.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });

        // Initialize table on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateStatistics();
            renderTable();
        });
        
    </script>

    <style>
        /* Statistics Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .bullying-verbal .stats-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bullying-fisik .stats-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .pelecehan-verbal .stats-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .pelecehan-fisik .stats-icon {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        }

        .stats-content h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            color: #1a202c;
        }

        .stats-content p {
            font-size: 14px;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter-container {
            position: relative;
        }

        .filter-select {
            padding: 10px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            color: #374151;
            font-size: 14px;
            min-width: 200px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-select:hover {
            border-color: #9ca3af;
        }

        /* Pagination Container - Perbaikan */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
    padding: 20px;
    background: white;
    border-radius: 8px;
}

.pagination-info {
    color: #6b7280;
    font-size: 14px;
    font-weight: 500;
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 12px;
}

.pagination-btn {
    padding: 10px 16px;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
    min-width: 100px;
    justify-content: center;
}

.pagination-btn:hover:not(:disabled) {
    background: #f9fafb;
    border-color: #3b82f6;
    color: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f9fafb;
    color: #9ca3af;
}

.pagination-numbers {
    display: flex;
    gap: 6px;
    padding: 0 8px;
}

.page-number {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    min-width: 40px;
    text-align: center;
}

.page-number:hover {
    background: #f3f4f6;
    border-color: #3b82f6;
    color: #3b82f6;
    transform: translateY(-1px);
}

.page-number.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
}

/* Responsive Design untuk Pagination */
@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        gap: 15px;
        padding: 15px;
    }
    
    .pagination-controls {
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
    }
    
    .pagination-btn {
        min-width: 80px;
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .page-number {
        min-width: 35px;
        padding: 6px 10px;
        font-size: 13px;
    }
    
    .pagination-numbers {
        padding: 0 4px;
        gap: 4px;
    }
}

@media (max-width: 480px) {
    .pagination-container {
        padding: 12px;
    }
    
    .pagination-info {
        font-size: 13px;
        text-align: center;
    }
    
    .pagination-controls {
        gap: 6px;
    }
    
    .pagination-btn {
        min-width: 70px;
        padding: 6px 10px;
        font-size: 12px;
    }
    
    .page-number {
        min-width: 32px;
        padding: 5px 8px;
        font-size: 12px;
    }
}
        /* Badges */
        .category-badge {
            background: #e0f2fe;
            color: #0277bd;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .urgency-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .urgency-low {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .urgency-medium {
            background: #fff3e0;
            color: #f57c00;
        }

        .urgency-high {
            background: #ffebee;
            color: #d32f2f;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .btn-edit, .btn-delete {
            padding: 6px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .btn-edit {
            background: #fff3cd;
            color: #856404;
        }

        .btn-edit:hover {
            background: #ffeaa7;
        }

        .btn-delete {
            background: #f8d7da;
            color: #721c24;
        }

        .btn-delete:hover {
            background: #f5c6cb;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-select {
                min-width: auto;
            }
        }
    </style>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection