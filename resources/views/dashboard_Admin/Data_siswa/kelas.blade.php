@extends('layouts.main_ds')
@section('title', 'Manajemen Kelas - Data Kelas')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Kelola Data Kelas</h1>
        <div class="user-info">
            <div class="profile-dropdown">
                <button class="profile-btn" onclick="toggleProfile()">
                    <i class="fa-solid fa-user-circle"></i>
                    {{-- Perbaiki di sini: Pastikan Auth::user() ada sebelum mengakses properti --}}
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
                                @if(Auth::check() && Auth::user()->roles->isNotEmpty())
                                    {{ Auth::user()->roles->first()->name }}
                                @else
                                    No Role / Guest
                                @endif
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

    <div class="management-section">
        <div class="section-header">
            <h2>Data Kelas</h2>
            <button class="btn-primary" onclick="openCreateClassModal()">
                <i class="fa-solid fa-plus"></i> Tambah Kelas
            </button>
        </div>
        <div class="table-container modern-table-container">
            <div class="table-wrapper">
                <table class="data-table modern-table">
                    <thead>
                        <tr>
                            <th class="table-header-cell">
                                <div class="header-content">
                                    <span>No</span>
                                </div>
                            </th>
                            <th class="table-header-cell">
                                <div class="header-content">
                                    <span>Nama Kelas</span>
                                    <i class="fa-solid fa-sort sort-icon"></i>
                                </div>
                            </th>
                            <th class="table-header-cell action-column">
                                <div class="header-content">
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="classRoomTableBody">
                        <tr class="loading-row">
                            <td colspan="3" class="loading-cell">
                                <div class="loading-content">
                                    <div class="loading-spinner"></div>
                                    <span>Sedang memuat data...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination-container modern-pagination">
            <div class="pagination-info modern-info">
                <span id="paginationInfo">Menampilkan 1-10 dari 42 data</span>
            </div>
            <div class="pagination-controls modern-controls">
                <button class="pagination-btn modern-page-btn" id="prevBtn" onclick="changePage(-1)" disabled>
                    <i class="fa-solid fa-chevron-left"></i>
                    <span>Sebelumnya</span>
                </button>
                <div class="pagination-numbers modern-numbers" id="paginationNumbers">
                </div>
                <button class="pagination-btn modern-page-btn" id="nextBtn" onclick="changePage(1)">
                    <span>Selanjutnya</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>


    @include('dashboard_Admin.Data_siswa.create_kelas')

    <div class="status-indicator" id="statusIndicator"></div>

    <script>
        // === VARIABEL GLOBAL ===
        const API_BASE_URL = '/api/class-room';
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;
        let totalItems = 0;
        let allClassRooms = [];
        let displayedClassRooms = [];
        let currentClassRoomId = null;

        // === FUNGSI MODAL ===
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (modalId === 'classRoomFormModal' || modalId === 'userFormModal') {
                    $(`#${modalId}`).modal('show');
                } else {
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
                if (modalId === 'classRoomFormModal' || modalId === 'userFormModal') {
                    $(`#${modalId}`).modal('hide');
                } else {
                    modal.style.display = 'none';
                    modal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }

                if (modalId === 'classRoomFormModal') {
                    resetclassRoomForm();
                }

                if (modalId === 'deleteConfirmModal') {
                    currentClassRoomId = null;
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

        // === FUNGSI STATUS INDICATOR ===
        function showStatus(message, type = 'success') {
            const indicator = document.getElementById('statusIndicator');
            if (!indicator) return;

            indicator.innerHTML = message;
            indicator.className = 'status-indicator show';

            if (indicator.timeoutId) {
                clearTimeout(indicator.timeoutId);
            }

            if (type === 'error') {
                indicator.style.background = 'linear-gradient(135deg, #ff6b6b, #ff5252)';
                indicator.style.boxShadow = '0 4px 20px rgba(255, 107, 107, 0.4)';
            } else {
                indicator.style.background = 'linear-gradient(135deg, #4CAF50, #45a049)';
                indicator.style.boxShadow = '0 4px 20px rgba(76, 175, 80, 0.4)';
            }

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
                renderClassRoomsPage();
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

            if (startPage > 1) {
                numbersHtml += `<button class="page-number" onclick="goToPage(1)">1</button>`;
                if (startPage > 2) {
                    numbersHtml += `<span class="pagination-ellipsis">...</span>`;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                numbersHtml += `
                    <button class="page-number ${i === currentPage ? 'active' : ''}"
                            onclick="goToPage(${i})">${i}</button>
                `;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    numbersHtml += `<span class="pagination-ellipsis">...</span>`;
                }
                numbersHtml += `<button class="page-number" onclick="goToPage(${totalPages})">${totalPages}</button>`;
            }

            paginationNumbers.innerHTML = numbersHtml;

            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            if (prevBtn) prevBtn.disabled = currentPage === 1;
            if (nextBtn) nextBtn.disabled = currentPage === totalPages;
        }

        // Fungsi untuk mengubah jumlah entri per halaman
        function changeEntriesPerPage(value) {
            itemsPerPage = parseInt(value, 10);
            currentPage = 1;
            totalItems = displayedClassRooms.length;
            totalPages = Math.ceil(totalItems / itemsPerPage);
            renderClassRoomsPage();
            updatePagination();
        }

        // === FUNGSI RENDER classRoomS ===
        function renderClassRoomsPage() {
            const tableBody = document.getElementById('classRoomTableBody');
            if (!tableBody) return;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const classRoomForPages = displayedClassRooms.slice(startIndex, endIndex);

            tableBody.innerHTML = '';

            if (classRoomForPages.length === 0) {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px;">${searchTerm ? `Tidak ada hasil untuk pencarian "${searchTerm}".` : `Tidak ada data kelas.`}</td></tr>`;
                return;
            }

            classRoomForPages.forEach((classRoom, index) => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${startIndex + index + 1}</td>
                    <td>${classRoom.name}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action edit" title="Edit" onclick="editClassRoom(${classRoom.id})">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button class="btn-action delete" title="Delete" onclick="openDeleteModal(${classRoom.id}, '${classRoom.name.replace(/'/g, "\\'")}')">
                                <i class="fa-solid fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                `;
            });
        }

        async function fetchClassRooms() {
            const tableBody = document.getElementById('classRoomTableBody');
            if (!tableBody) return;

            tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px;">Sedang memuat data...</td></tr>`;

            try {
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const classRooms = await response.json();

                allClassRooms = classRooms;
                displayedClassRooms = [...allClassRooms];

                totalItems = displayedClassRooms.length;
                totalPages = Math.ceil(totalItems / itemsPerPage);

                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = 1;
                }

                renderClassRoomsPage();
                updatePagination();

            } catch (error) {
                console.error('Error fetching class rooms:', error);
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px; color: var(--danger-color);">Gagal memuat data kelas.</td></tr>`;
                showStatus('Gagal memuat data kelas.', 'error');
            }
        }

        // === FUNGSI DELETE MODAL ===
        function openDeleteModal(ClassRoomId, classRoomName) {
            currentClassRoomId = ClassRoomId;
            const modal = document.getElementById('deleteConfirmModal');
            const classRoomNameSpan = document.getElementById('deleteClassRoomName');

            if (classRoomNameSpan) {
                classRoomNameSpan.textContent = classRoomName;
            }

            openModal('deleteConfirmModal');
        }

        async function confirmDelete() {
            if (currentClassRoomId === null) return;

            try {
                const response = await fetch(`${API_BASE_URL}/${currentClassRoomId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal menghapus kelas.');
                }

                showStatus('Data kelas berhasil dihapus!', 'success');
                closeModal('deleteConfirmModal');
                await fetchClassRooms();

            } catch (error) {
                console.error('Error deleting class room:', error);
                showStatus(`Gagal menghapus kelas: ${error.message}`, 'error');
            }
        }

        // === FUNGSI classRoom FORM ===
        function openCreateClassModal() {
            resetclassRoomForm();
            currentClassRoomId = null;

            const modalTitle = document.getElementById('modalTitle');
            const submitButton = document.getElementById('submitButton');

            if (modalTitle) modalTitle.textContent = 'Tambah Data Kelas Baru';
            if (submitButton) submitButton.textContent = 'Simpan Kelas';

            openModal('classRoomFormModal');
        }

        async function editClassRoom(id) {
            try {
                const response = await fetch(`${API_BASE_URL}/${id}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const classRoom = await response.json();

                console.log("Data kelas yang Diterima:", classRoom);

                resetclassRoomForm();
                currentclassRoomId = id;
                console.log(id)

                const modalTitle = document.getElementById('modalTitle');
                const submitButton = document.getElementById('submitButton');

                if (modalTitle) modalTitle.textContent = 'Edit Data kelas';
                if (submitButton) submitButton.textContent = 'Update kelas';

                // Isi formulir dengan data kelas
                const fields = {
                    'name': classRoom.name,
                };

                Object.entries(fields).forEach(([fieldId, value]) => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = value;
                });

                // Set nilai untuk input hidden 'classRoomId' jika ada
                const hiddenClassRoomIdInput = document.getElementById('classRoomId');
                if (hiddenClassRoomIdInput) {
                    hiddenClassRoomIdInput.value = classRoom.id;
                }

                openModal('classRoomFormModal');

            } catch (error) {
                console.error('Error fetching classRoom for edit:', error);
                showStatus('Gagal memuat data kelas untuk edit.', 'error');
            }
        }

        function resetclassRoomForm() {
            const form = document.getElementById('classRoomForm');
            if (!form) return;

            form.reset();

            const classRoomId = document.getElementById('classRoomId');

            if (classRoomId) classRoomId.value = '';

            // Reset field styles dan hapus kelas shake
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.style.borderColor = '#e9ecef';
                input.classList.remove('shake');
            });

            currentClassRoomId = null;
        }

        // === EVENT LISTENERS ===
        document.addEventListener('DOMContentLoaded', function() {
            // Initial fetch and render
            fetchClassRooms();

            // Profile dropdown close on outside click
            document.addEventListener('click', function(event) {
                const profileDropdown = document.querySelector('.profile-dropdown');
                const profileMenu = document.getElementById('profileMenu');

                if (profileDropdown && profileMenu && !profileDropdown.contains(event.target)) {
                    profileMenu.classList.remove('show');
                }
            });

            // Modal close on outside click (Diperbarui untuk Bootstrap modal)
            document.addEventListener('click', function(event) {
                // Untuk modal kustom
                if (event.target.classList.contains('modal-overlay') && event.target.classList.contains('delete-confirm-modal')) {
                    closeModal('deleteConfirmModal');
                }
            });

            // ESC key to close modal (Diperbarui untuk Bootstrap modal)
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    // Coba sembunyikan modal Bootstrap terlebih dahulu
                    if ($('#classRoomFormModal').is(':visible')) {
                        $('#classRoomFormModal').modal('hide');
                    } else if ($('#deleteConfirmModal').is(':visible')) {
                        // Jika bukan Bootstrap modal, gunakan fungsi closeModal kustom
                        closeModal('deleteConfirmModal');
                    }
                }
            });

            // Add classRoom button event
            const addClassRoomBtn = document.querySelector('.section-header .btn-primary');
            if (addClassRoomBtn) {
                addClassRoomBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openCreateClassModal();
                });
            }

            // Delete confirmation button
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', confirmDelete);
            }

            // classRoom form submission
            const classRoomForm = document.getElementById('classRoomForm');
            if (classRoomForm) {
                classRoomForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const formData = new FormData(classRoomForm);
                    const classRoomData = Object.fromEntries(formData);

                    // Validation
                    const requiredFields = classRoomForm.querySelectorAll('input[required]:not([type="hidden"]), select[required]');
                    let isValid = true;
                    let firstInvalidField = null;

                    // Hapus semua efek error/shake sebelumnya
                    classRoomForm.querySelectorAll('input, select').forEach(field => {
                        field.style.borderColor = '#e9ecef';
                        field.classList.remove('shake');
                    });

                    // Validasi field yang wajib diisi
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.style.borderColor = 'var(--danger-color)';
                            field.classList.add('shake');
                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                            field.addEventListener('input', function() {
                                this.style.borderColor = '#e9ecef';
                                this.classList.remove('shake');
                            }, { once: true });
                        }
                    });

                    if (!isValid) {
                        if (firstInvalidField) {
                            firstInvalidField.focus();
                        }
                        if (!document.querySelector('.status-indicator.show')) {
                             showStatus('Mohon lengkapi semua field yang diperlukan!', 'error');
                        }
                        return;
                    }
                    const hiddenClassRoomIdInput = document.getElementById('classRoomId');
                    try {
                        let response;
                        let method;
                        let url;
                        let successMessage;
                        if (hiddenClassRoomIdInput.value) {
                            method = 'PUT';
                            url = `${API_BASE_URL}/${hiddenClassRoomIdInput.value}`;
                            successMessage = 'Data kelas berhasil diperbarui!';
                        } else {
                            method = 'POST';
                            url = API_BASE_URL;
                            successMessage = 'Data kelas berhasil ditambahkan!';
                        }

                        response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            },
                            body: JSON.stringify(classRoomData),
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
                        closeModal('classRoomFormModal');
                        await fetchClassRooms();

                    } catch (error) {
                        console.error('Error submitting class room form:', error);
                        showStatus(`Error: ${error.message}`, 'error');
                    }
                });
            }
        });

        // === FUNGSI PENCARIAN ===
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput.value.toLowerCase();

            displayedClassRooms = allClassRooms.filter(classRoom => {
                return Object.values(classRoom).some(value =>
                    String(value).toLowerCase().includes(searchTerm)
                );
            });

            totalItems = displayedClassRooms.length;
            totalPages = Math.ceil(totalItems / itemsPerPage);
            currentPage = 1;

            renderClassRoomsPage();
            updatePagination();
        }
        window.searchTable = searchTable;

        // === EXPOSE FUNCTIONS TO GLOBAL SCOPE ===
        window.openModal = openModal;
        window.closeModal = closeModal;
        window.toggleSidebar = toggleSidebar;
        window.toggleProfile = toggleProfile;
        window.changePage = changePage;
        window.goToPage = goToPage;
        window.editClassRoom = editClassRoom;
        window.openDeleteModal = openDeleteModal;
        window.openCreateClassModal = openCreateClassModal;
        window.changeEntriesPerPage = changeEntriesPerPage;
    </script>

<style>
    
.entries-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
}

.entries-selector select {
    padding: 0.5rem;
    border: 2px solid #e9ecef;
    border-radius: 6px;
    background: white;
    color: #333;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
}

.entries-selector select:focus {
    outline: none;
    border-color: #667eea;
}

.action-column {
    width: 120px;
    text-align: center;
    flex-shrink: 0;
}

</style>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection