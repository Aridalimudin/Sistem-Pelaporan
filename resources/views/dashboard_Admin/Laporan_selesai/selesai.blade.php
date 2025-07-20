@extends('layouts.main_ds')

@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Kelola Penyelesaian Laporan</h1>
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
            <h2>Data Penyelesaian Kasus</h2>
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
                                <button class="btn-action btn-detail" data-url="{{route('proses.prosesAccept', $value->id)}}" data-report='@json($value)' onclick="viewDetail(this)" title="Lihat Detail">
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

@include('dashboard_Admin.Laporan_selesai.detail')

@push('scripts')
@if(Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showAlert("{{ Session::get('success') }}", "success");
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showAlert("{{ Session::get('error') }}", "error");
        });
    </script>
@endif
<script>
    let currentPage = 1;
    let entriesPerPage = 10;
    let allRows = [];
    let filteredRows = [];
    let sortDirection = {};

    $(document).ready(function(){
        initializeTable();

        $("#btnAccept").on("click", function(){
            if(confirm('Apakah Anda yakin akan menyelesaikan laporan ini?')){
                let id = $(this).attr('data-id');
                $("#form-proses").submit();
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

        $("#operation_id").on("change", function(){
            if($(this).val() != ""){
                $("#btnAccept").attr('disabled', false)
            }else{
                $("#btnAccept").attr('disabled', true)
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
        const toastLiveExample = document.getElementById('liveToast');
        const toastMessage = document.getElementById('toastMessage');
        const toast = new bootstrap.Toast(toastLiveExample);

        toastMessage.textContent = message;
        toastLiveExample.classList.remove('bg-success', 'bg-danger');
        if (type === 'success') {
            toastLiveExample.classList.add('bg-success');
        } else if (type === 'error') {
            toastLiveExample.classList.add('bg-danger');
        } else {
            toastLiveExample.classList.add('bg-primary');
        }
        toast.show();
    }

    function viewDetail(element) {
        let reporter = $(element).data('report');
        let url = $(element).data('url');
        let reporter_detail = reporter.reporter_detail;
        $("#detailTanggal").text(reporter.formatted_created_date);
        $("#detailNIS").text(reporter.student.nis);
        $("#detailEmail").text(reporter.student.email);
        $("#detailUraian").text(reporter.description);
        $("#form-proses").attr('action', url);
        

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
                const fileSize = 'N/A'; // Anda bisa mendapatkan ukuran file dari backend jika diperlukan

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

        if(reporter_detail){
            $("#detailTanggalKejadian").text(reporter_detail.formatted_report_date);
            $("#detailLokasiKejadian").text(reporter_detail.location);
            $("#detailInfoTambahan").text(reporter_detail.description || 'Tidak ada informasi tambahan.');
            $("#detailTindakan").text(reporter_detail.notes_by_student || 'Tidak ada tindakan yang diharapkan.');


            let victims = reporter_detail.victims;
            let htmlVictims = "";
            if(victims.length > 0){
                victims.forEach(row => {
                htmlVictims += ` <div class="detail-item">
                        <div class="detail-label">Nama Korban</div>
                        <div class="detail-value" id="detailNamaKorban">${row.name+' '+row.classroom}</div>
                    </div>`;
                });
            } else {
                htmlVictims = `<div class="info-placeholder"><p>Tidak ada korban terdaftar.</p></div>`;
            }

        const actionTaken = reporter.operation ? reporter.operation.name : 'Belum ada informasi penindakan.';
        const completionNotes = reporter.reason ? `<p>${reporter.reason}</p>` : '<p>Tidak ada catatan tambahan dari pihak sekolah.</p>';
        const completionDate = reporter.formatted_updated_date || 'Tanggal tidak tersedia';
        const evidenceFile = reporter.file;
        const evidenceUrl = reporter.url_file;

        $("#detailTindakanPenyelesaian").text(actionTaken);
        $("#detailTanggalPenyelesaian").text(completionDate);
        $("#detailCatatanPenyelesaian").html(completionNotes);

        const buktiPenyelesaianContainer = $("#buktiPenyelesaianContainer");
    buktiPenyelesaianContainer.empty();
    if (evidenceFile && evidenceUrl) {
        const fileName = evidenceFile.split('/').pop();
        const buktiHtml = `
            <div class="bukti-grid">
                <a href="${evidenceUrl}" target="_blank" class="bukti-item" title="Lihat/Unduh Bukti">
                    <div class="bukti-info">
                        <span class="bukti-name">${fileName}</span>
                        <span class="bukti-size">Klik untuk melihat</span>
                    </div>
                </a>
            </div>`;
        buktiPenyelesaianContainer.html(buktiHtml);
    } else {
        const placeholderHtml = `
            <div class="bukti-placeholder">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 14.899A7 7 0 1115.71 8h1.79a4.5 4.5 0 012.5 8.242M12 12v9" stroke="currentColor" stroke-width="2"/><path d="M8 17l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <p>Tidak ada bukti penyelesaian yang dilampirkan</p>
            </div>`;
        buktiPenyelesaianContainer.html(placeholderHtml);
    }
        

            let perpetrators = reporter_detail.perpetrators;
            let htmlPerpetrators = "";
            if(perpetrators.length > 0){
                perpetrators.forEach(row => {
                htmlPerpetrators += ` <div class="detail-item">
                        <div class="detail-label">Nama Pelaku</div>
                        <div class="detail-value" id="detailNamaPelaku">${row.name+' '+row.classroom}</div>
                    </div>`;
                });
            } else {
                htmlPerpetrators = `<div class="info-placeholder"><p>Tidak ada pelaku terdaftar.</p></div>`;
            }

            let witnesses = reporter_detail.witnesses;
            let htmlWitnesses = "";
            if(witnesses.length > 0){
                witnesses.forEach(row => {
                htmlWitnesses += ` <div class="detail-item">
                        <div class="detail-label">Nama Saksi</div>
                        <div class="detail-value" id="detailNamaSaksi">${row.name+' '+row.classroom}</div>
                    </div>`;
                });
            } else {
                htmlWitnesses = `<div class="info-placeholder"><p>Tidak ada saksi terdaftar.</p></div>`;
            }

            $("#detail-korban").html(htmlVictims);
            $("#detail-pelaku").html(htmlPerpetrators);
            $("#detail-saksi").html(htmlWitnesses);
        } else {
             // Jika tidak ada reporter_detail (belum dilengkapi)
            $("#detailTanggalKejadian").text('N/A');
            $("#detailLokasiKejadian").text('N/A');
            $("#detailInfoTambahan").html('<div class="info-placeholder"><p>Belum dilengkapi.</p></div>');
            $("#detailTindakan").html('<div class="info-placeholder"><p>Belum dilengkapi.</p></div>');
            $("#detail-korban").html('<div class="info-placeholder"><p>Belum dilengkapi.</p></div>');
            $("#detail-pelaku").html('<div class="info-placeholder"><p>Belum dilengkapi.</p></div>');
            $("#detail-saksi").html('<div class="info-placeholder"><p>Belum dilengkapi.</p></div>');
        }


        // --- Mengisi Ulasan Pelapor ---
        const feedbackContentDiv = document.getElementById('feedbackContent');
        const adminRating = reporter.rating;
        const adminComment = reporter.comment; // Pastikan ini sesuai dengan nama kolom di DB Anda

        // PERBAIKI MAPPING INI agar sesuai dengan yang Anda inginkan
        const ratingTextsMap = {
            1: 'Sangat Tidak Puas',
            2: 'Tidak Puas',
            3: 'Cukup Puas',
            4: 'Puas',
            5: 'Sangat Puas'
        };
        const adminSatisfactionLevel = (adminRating !== null) ? (ratingTextsMap[adminRating] || 'Rating tidak valid') : null;
        const adminHasFeedback = (adminRating !== null);

        let feedbackHtml = '';
        if (adminHasFeedback) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<span class="fa fa-star ${i <= adminRating ? 'checked' : ''}"></span>`;
            }

            feedbackHtml = `
                <div class="feedback-content">
                    <div class="feedback-grid">
                        <div class="feedback-item satisfaction">
                            <div class="feedback-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" fill="currentColor"/>
                                </svg>
                                Tingkat Kepuasan
                            </div>
                            <div class="feedback-value">${adminSatisfactionLevel}</div>
                        </div>

                        <div class="feedback-item rating">
                            <div class="feedback-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" fill="currentColor"/>
                                </svg>
                                Rating Kepuasan
                            </div>
                            <div class="feedback-value">
                                <div class="star-display" id="star-display-js">
                                    ${starsHtml}
                                    <span class="rating-text">${adminRating}/5</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="feedback-item comment">
                        <div class="feedback-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V2zm-4 9H8V9h8v2zm0-4H8V5h8v2z" fill="currentColor"/>
                            </svg>
                            Saran atau Komentar
                        </div>
                        <div class="feedback-value">${adminComment || 'Tidak ada komentar tambahan.'}</div>
                    </div>
                </div>
            `;
        } else {
            feedbackHtml = `
                <div class="feedback-placeholder">
                    <p>Pelapor belum mengisi ulasan.</p>
                </div>
            `;
        }
        feedbackContentDiv.innerHTML = feedbackHtml;

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