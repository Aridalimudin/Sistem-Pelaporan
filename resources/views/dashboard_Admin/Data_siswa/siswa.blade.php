@extends('layouts.main_ds')
@section('title', 'Manajemen Siswa - Data Siswa')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Kelola Data Siswa</h1>
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
                                {{-- PERBAIKAN PENTING DI BARIS INI (Baris 25 di log Anda) --}}
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
            <h2>Data Siswa</h2>
            <button class="btn-primary" onclick="openCreateStudentModal()">
                <i class="fa-solid fa-plus"></i> Tambah Siswa
            </button>
        </div>

        <div class="table-controls">
            <div class="table-controls-left">
                <div class="entries-selector">
                    <label for="entriesPerPage">Show</label>
                    <select id="entriesPerPage" onchange="changeEntriesPerPage(this.value)">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entries</span>
                </div>
            </div>

            <div class="table-controls-right">
                <div class="search-container">
                    <label for="searchInput">Search:</label>
                    <input type="text" id="searchInput" placeholder="Search Siswa..." onkeyup="searchTable()">
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
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

    @include('dashboard_Admin.Data_siswa.create')

    <div class="status-indicator" id="statusIndicator"></div>

    <script>
        // === VARIABEL GLOBAL ===
        const API_BASE_URL = '/api/students';
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalPages = 1;
        let totalItems = 0;
        let allStudents = [];
        let displayedStudents = [];
        let currentStudentId = null;

        // === FUNGSI MODAL ===
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                if (modalId === 'studentFormModal' || modalId === 'userFormModal') {
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
                if (modalId === 'studentFormModal' || modalId === 'userFormModal') {
                    $(`#${modalId}`).modal('hide');
                } else {
                    modal.style.display = 'none';
                    modal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }

                if (modalId === 'studentFormModal') {
                    resetStudentForm();
                }

                if (modalId === 'deleteConfirmModal') {
                    currentStudentId = null;
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
                renderStudentsPage();
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
            totalItems = displayedStudents.length;
            totalPages = Math.ceil(totalItems / itemsPerPage);
            renderStudentsPage();
            updatePagination();
        }

        // === FUNGSI RENDER STUDENTS ===
        function renderStudentsPage() {
            const tableBody = document.getElementById('studentTableBody');
            if (!tableBody) return;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const studentsForPage = displayedStudents.slice(startIndex, endIndex);

            tableBody.innerHTML = '';

            if (studentsForPage.length === 0) {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px;">${searchTerm ? `Tidak ada hasil untuk pencarian "${searchTerm}".` : `Tidak ada data siswa.`}</td></tr>`;
                return;
            }

            studentsForPage.forEach((student, index) => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${startIndex + index + 1}</td>
                    <td>
                        <div class="user-info-cell">
                            <div class="avatar">${student.name.charAt(0).toUpperCase()}</div>
                            <span>${student.nis}</span>
                        </div>
                    </td>
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>${student.classroom}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action edit" title="Edit" onclick="editStudent(${student.id})">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button class="btn-action delete" title="Delete" onclick="openDeleteModal(${student.id}, '${student.name.replace(/'/g, "\\'")}')">
                                <i class="fa-solid fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                `;
            });
        }

        async function fetchStudents() {
            const tableBody = document.getElementById('studentTableBody');
            if (!tableBody) return;

            tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px;">Sedang memuat data...</td></tr>`;

            try {
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const students = await response.json();

                allStudents = students;
                displayedStudents = [...allStudents];

                totalItems = displayedStudents.length;
                totalPages = Math.ceil(totalItems / itemsPerPage);

                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = 1;
                }

                renderStudentsPage();
                updatePagination();

            } catch (error) {
                console.error('Error fetching students:', error);
                tableBody.innerHTML = `<tr><td colspan="6" style="text-align: center; padding: 20px; color: var(--danger-color);">Gagal memuat data siswa.</td></tr>`;
                showStatus('Gagal memuat data siswa.', 'error');
            }
        }

        // === FUNGSI DELETE MODAL ===
        function openDeleteModal(studentId, studentName) {
            currentStudentId = studentId;
            const modal = document.getElementById('deleteConfirmModal');
            const studentNameSpan = document.getElementById('deleteStudentName');

            if (studentNameSpan) {
                studentNameSpan.textContent = studentName;
            }

            openModal('deleteConfirmModal');
        }

        async function confirmDelete() {
            if (currentStudentId === null) return;

            try {
                const response = await fetch(`${API_BASE_URL}/${currentStudentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal menghapus siswa.');
                }

                showStatus('Data siswa berhasil dihapus!', 'success');
                closeModal('deleteConfirmModal');
                await fetchStudents();

            } catch (error) {
                console.error('Error deleting student:', error);
                showStatus(`Gagal menghapus siswa: ${error.message}`, 'error');
            }
        }

        // === FUNGSI STUDENT FORM ===
        function openCreateStudentModal() {
            resetStudentForm();
            currentStudentId = null;

            const modalTitle = document.getElementById('modalTitle');
            const submitButton = document.getElementById('submitButton');

            if (modalTitle) modalTitle.textContent = 'Tambah Data Siswa Baru';
            if (submitButton) submitButton.textContent = 'Simpan Siswa';

            openModal('studentFormModal');
        }

        async function editStudent(id) {
            try {
                const response = await fetch(`${API_BASE_URL}/${id}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const student = await response.json();

                console.log("Data Siswa yang Diterima:", student);

                resetStudentForm();
                currentStudentId = id;

                const modalTitle = document.getElementById('modalTitle');
                const submitButton = document.getElementById('submitButton');

                if (modalTitle) modalTitle.textContent = 'Edit Data Siswa';
                if (submitButton) submitButton.textContent = 'Update Siswa';

                // Isi formulir dengan data siswa
                const fields = {
                    'nis': student.nis,
                    'name': student.name,
                    'email': student.email,
                    'classroom': student.classroom,
                };

                Object.entries(fields).forEach(([fieldId, value]) => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = value;
                });

                // Set nilai untuk input hidden 'studentId' jika ada
                const hiddenStudentIdInput = document.getElementById('studentId');
                if (hiddenStudentIdInput) {
                    hiddenStudentIdInput.value = student.id;
                }

                openModal('studentFormModal');

            } catch (error) {
                console.error('Error fetching student for edit:', error);
                showStatus('Gagal memuat data siswa untuk edit.', 'error');
            }
        }

        function resetStudentForm() {
            const form = document.getElementById('studentForm');
            if (!form) return;

            form.reset();

            const studentId = document.getElementById('studentId');

            if (studentId) studentId.value = '';

            // Reset field styles dan hapus kelas shake
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.style.borderColor = '#e9ecef';
                input.classList.remove('shake');
            });

            currentStudentId = null;
        }

        // === EVENT LISTENERS ===
        document.addEventListener('DOMContentLoaded', function() {
            // Initial fetch and render
            fetchStudents();

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
                    if ($('#studentFormModal').is(':visible')) {
                        $('#studentFormModal').modal('hide');
                    } else if ($('#deleteConfirmModal').is(':visible')) {
                        // Jika bukan Bootstrap modal, gunakan fungsi closeModal kustom
                        closeModal('deleteConfirmModal');
                    }
                }
            });

            // NIS number validation and shake effect (mirip dengan phone number)
            const nisInput = document.getElementById('nis'); // Ambil elemen NIS
            if (nisInput) {
                nisInput.addEventListener('input', function(e) {
                    const value = e.target.value;
                    // Hapus semua karakter non-digit
                    const cleanedValue = value.replace(/[^\d]/g, '');

                    if (value !== cleanedValue) {
                        e.target.value = cleanedValue; // Perbarui nilai input
                        e.target.classList.add('shake'); // Tambahkan efek shake

                        // Hapus efek shake setelah beberapa saat
                        setTimeout(() => {
                            e.target.classList.remove('shake');
                        }, 500); // Durasi shake dalam ms

                        showStatus('NIS hanya boleh berisi angka!', 'error'); // Tampilkan pesan error
                    } else {
                        // Jika input valid (hanya angka), pastikan tidak ada shake dan border normal
                        e.target.classList.remove('shake');
                        e.target.style.borderColor = '#e9ecef'; // Kembalikan warna border normal
                    }
                });
            }


            // Add student button event
            const addStudentBtn = document.querySelector('.section-header .btn-primary');
            if (addStudentBtn) {
                addStudentBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openCreateStudentModal();
                });
            }

            // Delete confirmation button
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', confirmDelete);
            }

            // Student form submission
            const studentForm = document.getElementById('studentForm');
            if (studentForm) {
                studentForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const formData = new FormData(studentForm);
                    const studentData = Object.fromEntries(formData);

                    // Validation
                    const requiredFields = studentForm.querySelectorAll('input[required]:not([type="hidden"]), select[required]');
                    let isValid = true;
                    let firstInvalidField = null;

                    // Hapus semua efek error/shake sebelumnya
                    studentForm.querySelectorAll('input, select').forEach(field => {
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

                    // Tambahan validasi final untuk NIS saat submit (hanya angka)
                    // Ini tetap diperlukan karena event 'input' hanya memfilter,
                    // tapi tidak langsung mencegah submit jika user hanya menginput non-angka dan tidak mengetik ulang.
                    const nisInputSubmit = document.getElementById('nis');
                    if (nisInputSubmit && nisInputSubmit.value.trim()) {
                        if (!/^\d+$/.test(nisInputSubmit.value.trim())) {
                            isValid = false;
                            nisInputSubmit.style.borderColor = 'var(--danger-color)';
                            nisInputSubmit.classList.add('shake');
                            if (!firstInvalidField) {
                                firstInvalidField = nisInputSubmit;
                            }
                            showStatus('NIS hanya boleh berisi angka!', 'error');
                        }
                    }


                    if (!isValid) {
                        if (firstInvalidField) {
                            firstInvalidField.focus();
                        }
                        if (!document.querySelector('.status-indicator.show')) {
                             showStatus('Mohon lengkapi semua field yang diperlukan!', 'error');
                        }
                        return;
                    }

                    try {
                        let response;
                        let method;
                        let url;
                        let successMessage;

                        if (currentStudentId) {
                            method = 'PUT';
                            url = `${API_BASE_URL}/${currentStudentId}`;
                            successMessage = 'Data siswa berhasil diperbarui!';
                        } else {
                            method = 'POST';
                            url = API_BASE_URL;
                            successMessage = 'Data siswa berhasil ditambahkan!';
                        }

                        response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            },
                            body: JSON.stringify(studentData),
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
                        closeModal('studentFormModal');
                        await fetchStudents();

                    } catch (error) {
                        console.error('Error submitting student form:', error);
                        showStatus(`Error: ${error.message}`, 'error');
                    }
                });
            }
        });

        // === FUNGSI PENCARIAN ===
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const searchTerm = searchInput.value.toLowerCase();

            displayedStudents = allStudents.filter(student => {
                return Object.values(student).some(value =>
                    String(value).toLowerCase().includes(searchTerm)
                );
            });

            totalItems = displayedStudents.length;
            totalPages = Math.ceil(totalItems / itemsPerPage);
            currentPage = 1;

            renderStudentsPage();
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
        window.editStudent = editStudent;
        window.openDeleteModal = openDeleteModal;
        window.openCreateStudentModal = openCreateStudentModal;
        window.changeEntriesPerPage = changeEntriesPerPage;
    </script>

<style>
/* CSS untuk efek shake */
@keyframes shake {
  0%, 100% { transform: translateX(0); }
  20%, 60% { transform: translateX(-5px); }
  40%, 80% { transform: translateX(5px); }
}

/* Class untuk menerapkan efek shake */
.shake {
  animation: shake 0.3s ease-in-out;
  border-color: var(--danger-color) !important;
}

/* Styling yang sudah ada */
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

.search-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.search-container label {
    color: #666;
    font-weight: 500;
}

#searchInput {
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.9rem;
    width: 250px;
    transition: all 0.3s ease;
}

#searchInput:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}
</style>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection