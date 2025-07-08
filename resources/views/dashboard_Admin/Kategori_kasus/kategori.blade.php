@extends('layouts.main_ds')
@section('content')

    <main id="content" class="content">
        <header>
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            <h1 class="header-title">Kelola Data Kategori Kasus</h1>
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
                    <button class="btn-primary" onclick="openCreateModal()"> <i class="fa-solid fa-plus"></i> Tambah Data
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

        @include('dashboard_Admin.Kategori_kasus.create')

        <script>
            let crimeData = [];
            const API_BASE_URL = '/api/crimes/data';

            let currentModalMode = 'add';
            let filteredData = [];
            let editingCrimeId = null;

            let currentPage = 1;
            const itemsPerPage = 10;

            // Fungsi untuk mengambil data dari API
            async function fetchCrimes() {
                try {
                    const response = await fetch(API_BASE_URL);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    crimeData = await response.json();

                    filterByCategory();
                } catch (error) {
                    console.error('Error fetching crimes:', error);
                    showStatus('Gagal memuat data kategori.', 'error');
                }
            }

            function filterByCategory() {
                const selectedCategory = document.getElementById('categoryFilter').value;

                if (selectedCategory === '') {
                    filteredData = [...crimeData];
                } else {
                    filteredData = crimeData.filter(crime => crime.type === selectedCategory);
                }
                
                currentPage = 1;
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
                if (currentData.length === 0) {
                    html = `<tr><td colspan="5" style="text-align: center; padding: 20px;">Tidak ada data ditemukan.</td></tr>`;
                } else {
                    currentData.forEach((crime, index) => {
                        const actualIndex = startIndex + index + 1;
                        html += `
                            <tr>
                                <td>${actualIndex}</td>
                                <td>${crime.name}</td>
                                <td><span class="category-badge">${crime.type}</span></td>
                                <td><span class="urgency-badge ${getUrgencyClass(crime.urgency)}">${getUrgencyText(crime.urgency)}</span></td>
                                <td class="action-buttons">
                                    <button class="btn-edit" onclick="editCrime(${crime.id})" title="Edit">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <button class="btn-delete" onclick="openDeleteModal(${crime.id}, '${crime.name}')" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
                tableBody.innerHTML = html;
                updatePagination(totalItems, totalPages);
            }

            function openModal(modalId, mode) {
                const modal = document.getElementById(modalId);
                const modalTitle = document.getElementById('modalTitle');
                const saveButton = document.getElementById('saveCrimeBtn');
                const crimeForm = document.getElementById('crimeForm');

                if (modal) {
                    modal.classList.add('show');
                    document.body.style.overflow = 'hidden';

                    currentModalMode = mode;

                    if (mode === 'add') {
                        modalTitle.textContent = 'Tambah Data Kategori Kasus';
                        saveButton.innerHTML = '<i class="fa-solid fa-save"></i> Simpan';
                        crimeForm.reset();
                        editingCrimeId = null;
                    } else if (mode === 'edit') {
                        modalTitle.textContent = 'Edit Data Kategori Kasus';
                        saveButton.innerHTML = '<i class="fa-solid fa-save"></i> Perbarui';
                    }
                } else {
                    console.error(`Modal dengan ID '${modalId}' tidak ditemukan.`);
                }
            }

            function openCreateModal() {
                openModal('createRoleModal', 'add');
            }

            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';

                    const form = modal.querySelector('form');
                    if (form) {
                        form.reset();
                    }
                }
            }

            function openDeleteModal(idToDelete, nameToDelete) {
                const modal = document.getElementById('deleteConfirmModal');
                const roleNameSpan = document.getElementById('deleteRoleName');
                const confirmButton = document.getElementById('confirmDeleteBtn');

                if (modal && roleNameSpan && confirmButton) {
                    roleNameSpan.textContent = nameToDelete;
                    confirmButton.onclick = () => confirmDelete(idToDelete);
                    modal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                } else {
                    console.error("Elemen modal delete atau komponennya tidak ditemukan.");
                }
            }

            async function confirmDelete(idToDelete) {
                try {
                    const response = await fetch(`${API_BASE_URL}/${idToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Gagal menghapus data.');
                    }

                    showStatus('Data berhasil dihapus!', 'success');
                    await fetchCrimes();
                } catch (error) {
                    console.error('Error deleting crime:', error);
                    showStatus(error.message, 'error');
                } finally {
                    closeModal('deleteConfirmModal');
                }
            }

            function updatePagination(totalItems, totalPages) {
                const startItem = (currentPage - 1) * itemsPerPage + 1;
                const endItem = Math.min(currentPage * itemsPerPage, totalItems);

                document.getElementById('paginationInfo').textContent =
                    `Menampilkan ${startItem}-${endItem} dari ${totalItems} data`;

                const paginationNumbers = document.getElementById('paginationNumbers');
                let numbersHtml = '';

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

            function editCrime(id) {
                const crimeToEdit = crimeData.find(crime => crime.id === id);
                if (crimeToEdit) {
                    document.getElementById('crimeName').value = crimeToEdit.name;
                    document.getElementById('crimeType').value = crimeToEdit.type;
                    document.getElementById('urgencyLevel').value = crimeToEdit.urgency;

                    editingCrimeId = id;
                    openModal('createRoleModal', 'edit');
                } else {
                    console.error(`Data kejahatan dengan ID ${id} tidak ditemukan.`);
                    showStatus('Data tidak ditemukan untuk diedit.', 'error');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const crimeForm = document.getElementById('crimeForm');
                if (crimeForm) {
                    crimeForm.addEventListener('submit', async function(event) {
                        event.preventDefault();

                        const crimeName = document.getElementById('crimeName').value;
                        const crimeType = document.getElementById('crimeType').value;
                        const urgencyLevel = parseInt(document.getElementById('urgencyLevel').value);

                        const dataToSend = {
                            name: crimeName,
                            type: crimeType,
                            urgency: urgencyLevel,
                            _token: '{{ csrf_token() }}'
                        };

                        try {
                            let response;
                            if (currentModalMode === 'add') {
                                response = await fetch(API_BASE_URL, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify(dataToSend)
                                });
                            } else if (currentModalMode === 'edit') {
                                response = await fetch(`${API_BASE_URL}/${editingCrimeId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify(dataToSend)
                                });
                            }
                            console.log(response);
                            if (!response.ok) {
                                const errorData = await response.json();
                                throw new Error(errorData.message || 'Terjadi kesalahan.');
                            }

                            const result = await response.json();
                            showStatus(`Data berhasil ${currentModalMode === 'add' ? 'ditambahkan' : 'diperbarui'}!`, 'success');
                            await fetchCrimes();
                        } catch (error) {
                            console.error('Error submitting form:', error);
                            showStatus(error.message, 'error');
                        } finally {
                            closeModal('createRoleModal');
                        }
                    });
                }
            });

            function showStatus(message, type) {
                const statusIndicator = document.getElementById('statusIndicator');
                const statusIcon = statusIndicator.querySelector('i');
                const statusText = statusIndicator.querySelector('span');

                if (statusIndicator) {
                    statusText.textContent = message;
                    statusIndicator.className = 'status-indicator';

                    if (type === 'success') {
                        statusIndicator.style.backgroundColor = '#10b981';
                        statusIcon.className = 'fa-solid fa-check-circle';
                    } else if (type === 'error') {
                        statusIndicator.style.backgroundColor = '#ef4444';
                        statusIcon.className = 'fa-solid fa-times-circle';
                    } else {
                        statusIndicator.style.backgroundColor = '#10b981';
                        statusIcon.className = 'fa-solid fa-check-circle';
                    }

                    statusIndicator.classList.add('show');

                    setTimeout(() => {
                        statusIndicator.classList.remove('show');
                    }, 3000);
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

                const createRoleModal = document.getElementById('createRoleModal');
                const deleteConfirmModal = document.getElementById('deleteConfirmModal');

                if (createRoleModal && event.target === createRoleModal) {
                    closeModal('createRoleModal');
                }
                if (deleteConfirmModal && event.target === deleteConfirmModal) {
                    closeModal('deleteConfirmModal');
                }
            });

            // Inisialisasi: Panggil fetchCrimes saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                fetchCrimes();
            });
        </script>
        @push('styles')
        <link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
        @endpush
@endsection