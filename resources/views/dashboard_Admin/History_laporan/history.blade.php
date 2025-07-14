@extends('layouts.main_ds')

@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Kelola Penolakan Kasus</h1>
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

    <input type="hidden" id="permissionData" value=''>
    <div class="management-section">
        <div class="section-header">
            <h2>Data Penolakan Kasus</h2>
            <div class="header-actions">
                <div class="filter-container">
                </div>
            </div>
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
                    <input type="text" id="searchInput" placeholder="Search cases..." onkeyup="searchTable()">
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="data-table" id="data-table">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">
                            NO
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th onclick="sortTable(1)">
                            Kode
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th onclick="sortTable(2)">
                            Nama Siswa
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th onclick="sortTable(3)">
                            NIS
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th onclick="sortTable(4)">
                            Kelas
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th onclick="sortTable(5)">
                            Urgensi
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th onclick="sortTable(6)">
                            Status
                            <i class="fa-solid fa-sort sort-icon"></i>
                        </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($reporters as $key => $value)
                        <tr class="table-row" data-index="{{ $key }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value->code }}</td>
                            <td>{{ $value->student?->name }}</td>
                            <td>{{ $value->student?->nis }}</td>
                            <td>{{ $value->student?->classroom }}</td>
                            <td>{!! $value->formatted_urgency !!}</td>
                            <td>{!! $value->formatted_status !!}</td>
                            <td>
                                <button class="btn-action btn-detail" data-report='@json($value)' onclick="viewDetail(this)" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada laporan yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <div class="pagination-info">
                <span id="paginationInfo"></span>
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
</main>

@include('dashboard_Admin.Laporan_verifikasi.detail')

@push('scripts')
<script>
    let currentPage = 1;
    let entriesPerPage = 10;
    let allRows = [];
    let filteredRows = [];
    let sortDirection = {};

    $(document).ready(function(){
        initializeTable();

        $("#btnAccept").on("click", function(){
            if(confirm('Apakah Anda yakin akan meng-approve data ini?')){
                let id = $(this).attr('data-id');
                $.ajax({
                    url: '{{route("laporan-masuk.approve")}}',
                    method: 'POST',
                    data: {
                        "id" : id,
                        "_token" : "{{csrf_token()}}"
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#btnAccept").prop('disabled', true).text('Processing...');
                    },
                    success: function(response) {
                        if (response.status) {
                            showAlert('Data berhasil di-approve!', 'success');
                            location.reload();
                        } else {
                            showAlert('Gagal meng-approve data: ' + (response.message || 'Terjadi kesalahan.'), 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error, xhr.responseText);
                        showAlert('Terjadi kesalahan saat menghubungi server. Mohon coba lagi.', 'error');
                    },
                    complete: function() {
                        $("#btnAccept").prop('disabled', false).html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Terima Laporan');
                    }
                });
            }
        });

        $("#btnReject").on("click", function(){
            if(confirm('Apakah Anda yakin akan me-reject data ini?')){
                let id = $(this).attr('data-id');
                $.ajax({
                    url: '{{route("laporan-masuk.reject")}}',
                    method: 'POST',
                    data: {
                        "id" : id,
                        "_token" : "{{csrf_token()}}"
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#btnReject").prop('disabled', true).text('Processing...');
                    },
                    success: function(response) {
                        if (response.status) {
                            showAlert('Data berhasil di-reject!', 'success');
                            location.reload();
                        } else {
                            showAlert('Gagal me-reject data: ' + (response.message || 'Terjadi kesalahan.'), 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error, xhr.responseText);
                        showAlert('Terjadi kesalahan saat menghubungi server. Mohon coba lagi.', 'error');
                    },
                    complete: function() {
                        $("#btnReject").prop('disabled', false).html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Tolak Laporan');
                    }
                });
            }
        });
    });

    function initializeTable() {
        allRows = Array.from(document.querySelectorAll('.table-row'));
        filteredRows = [...allRows];
        updateTable();
    }

    function changeEntriesPerPage(value) {
        entriesPerPage = parseInt(value);
        currentPage = 1;
        updateTable();
    }

    function searchTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();

        if (searchTerm === '') {
            filteredRows = [...allRows];
        } else {
            filteredRows = allRows.filter(row => {
                const cells = row.querySelectorAll('td');
                return Array.from(cells).some(cell =>
                    cell.textContent.toLowerCase().includes(searchTerm)
                );
            });
        }

        currentPage = 1;
        updateTable();
    }

    function sortTable(columnIndex) {
        const isAscending = sortDirection[columnIndex] !== 'asc';
        sortDirection[columnIndex] = isAscending ? 'asc' : 'desc';

        document.querySelectorAll('.sort-icon').forEach((icon, index) => {
            if (index === columnIndex) {
                icon.className = `fa-solid fa-sort-${isAscending ? 'up' : 'down'} sort-icon active`;
            } else {
                icon.className = 'fa-solid fa-sort sort-icon';
            }
        });

        filteredRows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();

            const aNum = parseFloat(aValue);
            const bNum = parseFloat(bValue);

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? aNum - bNum : bNum - aNum;
            }

            return isAscending
                ? aValue.localeCompare(bValue)
                : bValue.localeCompare(aValue);
        });

        currentPage = 1;
        updateTable();
    }

    function changePage(direction) {
        const totalPages = Math.ceil(filteredRows.length / entriesPerPage);

        if (direction === -1 && currentPage > 1) {
            currentPage--;
        } else if (direction === 1 && currentPage < totalPages) {
            currentPage++;
        }

        updateTable();
    }

    function goToPage(page) {
        currentPage = page;
        updateTable();
    }

    function updateTable() {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';

        const totalPages = Math.ceil(filteredRows.length / entriesPerPage);
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;

        if (filteredRows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Belum ada laporan yang tersedia.</td></tr>';
        } else {
            for (let i = startIndex; i < endIndex && i < filteredRows.length; i++) {
                tbody.appendChild(filteredRows[i]);
            }
        }

        const showing = filteredRows.length === 0 ? 0 : startIndex + 1;
        const to = Math.min(endIndex, filteredRows.length);
        document.getElementById('paginationInfo').textContent =
            `Menampilkan ${showing} sampai ${to} dari ${filteredRows.length} data`;

        updatePagination(totalPages);
    }

    function updatePagination(totalPages) {
        const paginationNumbers = document.getElementById('paginationNumbers');
        if (!paginationNumbers) return;

        let numbersHtml = '';
        const maxPageNumbersToShow = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxPageNumbersToShow / 2));
        let endPage = Math.min(totalPages, startPage + maxPageNumbersToShow - 1);

        if (endPage - startPage + 1 < maxPageNumbersToShow) {
            startPage = Math.max(1, endPage - maxPageNumbersToShow + 1);
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
        if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    }

    function showAlert(message, type = 'info') {
        alert(message);
    }

    function viewDetail(element) {
        let reporter = $(element).data('report');

        $("#detailTanggal").text(reporter.formatted_created_date);
        $("#detailNIS").text(reporter.student.nis);
        $("#detailEmail").text(reporter.student.email);
        $("#detailUraian").text(reporter.description);

        const keywordsContainer = $("#detailKataKunci");
        if (reporter.crime && reporter.crime.length > 0) {
            let html = "";
            reporter.crime.forEach(function (item) {
                let keywordClass = '';
                let iconSvg = '';

                if (item.name.toLowerCase().includes('bullying') || item.name.toLowerCase().includes('intimidasi')) {
                    keywordClass = 'severity-high';
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                } else if (item.name.toLowerCase().includes('kekerasan verbal')) {
                    keywordClass = 'severity-medium';
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                } else if (item.name.toLowerCase().includes('kantin sekolah') || item.name.toLowerCase().includes('area')) {
                    keywordClass = 'location';
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/></svg>';
                } else if (item.name.toLowerCase().includes('siswa')) {
                    keywordClass = 'category';
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                } else if (item.name.toLowerCase().includes('jam')) {
                    keywordClass = 'time';
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><polyline points="12,6 12,12 16,14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                } else {
                    keywordClass = 'category';
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                }

                html += `<span class="keyword-tag ${keywordClass}">${iconSvg} ${item.name}</span>`;
            });
            keywordsContainer.html(html);
        } else {
            keywordsContainer.html('<span class="text-muted">Tidak ada kata kunci</span>');
        }

        const buktiGrid = $("#detailBukti .bukti-grid");
        buktiGrid.empty();

        if (reporter.reporter_file && reporter.reporter_file.length > 0) {
            let htmlMedia = "";
            reporter.reporter_file.forEach(function (file) {
                const fileName = file.file.split('/').pop();
                const fileSize = 'N/A';

                if (isImage(file.file)) {
                    htmlMedia += `
                        <div class="bukti-item">
                            <img src="${file.url_file}" alt="${fileName}" onclick="openImageModal(this.src)">
                            <div class="bukti-info">
                                <span class="bukti-name">${fileName}</span>
                                <span class="bukti-size">${fileSize}</span>
                            </div>
                        </div>`;
                } else if (isVideo(file.file)) {
                    htmlMedia += `
                        <div class="bukti-item">
                            <video controls class="evidence-video">
                                <source src="${file.url_file}" type="video/mp4">
                                Video tidak dapat diputar
                            </video>
                            <div class="bukti-info">
                                <span class="bukti-name">${fileName}</span>
                                <span class="bukti-size">${fileSize}</span>
                            </div>
                        </div>`;
                }
            });
            buktiGrid.html(htmlMedia);
        } else {
            buktiGrid.html(`
                <div class="bukti-placeholder">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="currentColor" stroke-width="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5" stroke="currentColor" stroke-width="2"/>
                        <polyline points="21,15 16,10 5,21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p>Tidak ada bukti yang dilampirkan</p>
                </div>
            `);
        }

        const statusDot = $("#detailStatusDot");
        const statusText = $("#detailStatusText");
        statusDot.removeClass('pending approved rejected');
        let statusMessage = '';

        if (reporter.status == 0) {
            statusDot.addClass('pending');
            statusMessage = 'Menunggu Review';
            $("#btnReject").show();
            $("#btnAccept").show();
        } else if (reporter.status == 1) {
            statusDot.addClass('approved');
            statusMessage = 'Laporan Diterima';
            $("#btnReject").hide();
            $("#btnAccept").hide();
        } else if (reporter.status == 2) {
            statusDot.addClass('rejected');
            statusMessage = 'Laporan Ditolak';
            $("#btnReject").hide();
            $("#btnAccept").hide();
        }
        statusText.text(`Status: ${statusMessage}`);


        $("#btnReject").attr('data-id', reporter.id);
        $("#btnAccept").attr('data-id', reporter.id);
        $("#modal-detail").modal('show');
    }

    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("active");
    }

    function toggleProfile() {
        const profileMenu = document.getElementById('profileMenu');
        profileMenu.classList.toggle('show');
    }

    function isImage(filePath) {
        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.bmp', '.webp'];
        const lowerCasePath = filePath.toLowerCase();
        return imageExtensions.some(ext => lowerCasePath.endsWith(ext));
    }

    function isVideo(filePath) {
        const videoExtensions = ['.mp4', '.webm', '.ogg', '.mov', '.avi', '.mkv'];
        const lowerCasePath = filePath.toLowerCase();
        return videoExtensions.some(ext => lowerCasePath.endsWith(ext));
    }

    function openImageModal(imageSrc) {
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        if (imageModal && modalImage) {
            modalImage.src = imageSrc;
            imageModal.style.display = 'flex';
        }
    }

    function closeImageModal() {
        const imageModal = document.getElementById('imageModal');
        if (imageModal) {
            imageModal.style.display = 'none';
            document.getElementById('modalImage').src = '';
        }
    }

    document.addEventListener('click', function(event) {
        const profileDropdown = document.querySelector('.profile-dropdown');
        const profileMenu = document.getElementById('profileMenu');

        if (profileDropdown && profileMenu && !profileDropdown.contains(event.target)) {
            profileMenu.classList.remove('show');
        }
    });
</script>
@endpush
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


.data-table thead {
    background: linear-gradient(135deg, #667eea 0%, 100%);
    color: white;
}

.data-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    cursor: pointer;
    user-select: none;
    position: relative;
    transition: background-color 0.3s ease;
}

.data-table th:hover {
    background: rgba(49, 48, 51, 0.13);
}

.data-table th:last-child {
    cursor: default;
}

.sort-icon {
    margin-left: 0.5rem;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.sort-icon.active {
    opacity: 1;
    color:rgb(255, 0, 0);
}

.data-table tbody tr {
    border-bottom: 1px solid #f1f3f4;
    transition: background-color 0.3s ease;
}

.data-table tbody tr:hover {
    background-color: #f8f9fa;
}

.data-table tbody tr:last-child {
    border-bottom: none;
}

.data-table td {
    padding: 1rem;
    vertical-align: middle;
}
</style>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection