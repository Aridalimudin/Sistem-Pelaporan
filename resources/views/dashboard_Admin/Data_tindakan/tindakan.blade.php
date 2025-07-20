@extends('layouts.main_ds')

@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Kelola Laporan Baru</h1>
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
            <h2>Data Kasus Baru</h2>
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

@include('dashboard_Admin.Data_tindakan.detail')

@push('scripts')
<script>
    // Table functionality variables
    let currentPage = 1;
    let entriesPerPage = 10; // Default entries per page
    let allRows = []; // Stores all initial table rows
    let filteredRows = []; // Stores rows after search/filter
    let sortDirection = {}; // Stores sorting direction for each column
    let currentReportIdToReject = null; // To store the ID of the report being rejected
    let currentActionType = null; // To store 'approve' or 'reject'
    let currentReportIdForAction = null; // To store the ID for the current action

    $(document).ready(function(){
        // Initialize table
        initializeTable();

        // When the main "Tolak Laporan" button is clicked
        $("#btnReject").on("click", function(){
            currentReportIdToReject = $(this).attr('data-id'); // Store the ID
            $('#rejectReasonSelect').val(''); // Reset select
            $('#otherReasonText').val(''); // Reset textarea
            $('#otherReasonContainer').hide(); // Hide custom reason field
            $('#rejectReasonError').hide(); // Hide error message
            $("#modal-reject-reason").modal('show'); // Show the reason selection modal
        });

        // When a reason is selected in the rejection modal
        $('#rejectReasonSelect').on('change', function() {
            if ($(this).val() === 'Lainnya') {
                $('#otherReasonContainer').show();
                $('#otherReasonText').focus();
            } else {
                $('#otherReasonContainer').hide();
                $('#otherReasonText').val(''); // Clear custom reason if another option is chosen
            }
            $('#rejectReasonError').hide(); // Hide error when a selection is made
        });

        // When the "Tolak Laporan" button inside the reason modal is clicked
        $("#confirmRejectBtn").on("click", function(){
            let reason = $('#rejectReasonSelect').val();
            let customReason = $('#otherReasonText').val().trim();
            let finalReason = '';

            if (reason === 'Lainnya') {
                if (customReason === '') {
                    $('#rejectReasonError').text('Mohon masukkan alasan lainnya.').show();
                    return;
                }
                finalReason = customReason;
            } else if (reason === '') {
                $('#rejectReasonError').text('Mohon pilih alasan penolakan.').show();
                return;
            } else {
                finalReason = reason;
            }

            currentActionType = 'reject';
            currentReportIdForAction = currentReportIdToReject; // Use the ID stored from btnReject click
            showConfirmationModal(`Apakah Anda yakin akan menolak laporan ini dengan alasan: "${finalReason}"?`, () => {
                // This callback runs if user confirms in generic modal
                performRejectAction(currentReportIdToReject, finalReason);
                $('#modal-reject-reason').modal('hide'); // Hide reason modal after confirming in generic modal
            });
        });


        $("#btnAccept").on("click", function(){
            currentActionType = 'approve';
            currentReportIdForAction = $(this).attr('data-id');
            showConfirmationModal('Apakah Anda yakin akan menerima laporan ini?', () => {
                performAcceptAction(currentReportIdForAction);
            });
        });

        $('#confirmActionButton').on('click', function() {
            $('#confirmationModal').modal('hide'); // Hide the confirmation modal
        });
    });

    // New function to show the custom confirmation modal
    function showConfirmationModal(message, callback) {
        $('#confirmationMessage').text(message);
        $('#confirmActionButton').off('click').on('click', function() {
            $('#confirmationModal').modal('hide');
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
        $('#confirmationModal').modal('show');
    }

    // Function to perform the actual reject action via AJAX
    function performRejectAction(id, reason) {
        $.ajax({
            url: '{{route("laporan-masuk.reject")}}',
            method: 'POST',
            data: {
                "id" : id,
                "reason": reason,
                "_token" : "{{csrf_token()}}"
            },
            dataType: 'json',
            beforeSend: function() {
                // You might want to disable buttons or show a loading indicator here
                $("#btnReject").prop('disabled', true).text('Processing...');
                $("#confirmRejectBtn").prop('disabled', true).text('Processing...');
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
                $("#confirmRejectBtn").prop('disabled', false).text('Tolak Laporan');
            }
        });
    }

    // Function to perform the actual accept action via AJAX
    function performAcceptAction(id) {
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

    /**
     * Initializes the table by capturing all rows and updating the display.
     */
    function initializeTable() {
        allRows = Array.from(document.querySelectorAll('.table-row'));
        filteredRows = [...allRows]; // Initially, all rows are filtered rows
        updateTable();

        // Check if there are no reports and display the message
        if (allRows.length === 0) {
            const tableBody = document.getElementById('tableBody');
            if (tableBody) {
            }
        }
    }

    /**
     * Changes the number of entries displayed per page.
     * @param {string} value - The new number of entries per page.
     */
    function changeEntriesPerPage(value) {
        entriesPerPage = parseInt(value);
        currentPage = 1; // Reset to the first page when entries per page changes
        updateTable();
    }

    /**
     * Filters table rows based on the search input.
     */
    function searchTable() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();

        if (searchTerm === '') {
            filteredRows = [...allRows]; // If search is empty, show all original rows
        } else {
            filteredRows = allRows.filter(row => {
                const cells = row.querySelectorAll('td');
                return Array.from(cells).some(cell =>
                    cell.textContent.toLowerCase().includes(searchTerm)
                );
            });
        }

        currentPage = 1; // Reset to the first page after a search
        updateTable();

        // Display "No reports" message if filteredRows is empty after search
        const tbody = document.getElementById('tableBody');
        if (filteredRows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Tidak ada laporan yang cocok dengan pencarian Anda.</td></tr>';
        }
    }

    /**
     * Sorts the table by the specified column index.
     * @param {number} columnIndex - The index of the column to sort.
     */
    function sortTable(columnIndex) {
        // Toggle sort direction
        const isAscending = sortDirection[columnIndex] !== 'asc';
        sortDirection[columnIndex] = isAscending ? 'asc' : 'desc';

        // Update sort icons for all headers
        document.querySelectorAll('.sort-icon').forEach((icon, index) => {
            if (index === columnIndex) {
                icon.className = `fa-solid fa-sort-${isAscending ? 'up' : 'down'} sort-icon active`;
            } else {
                icon.className = 'fa-solid fa-sort sort-icon'; // Reset other icons
            }
        });

        // Sort the filtered rows
        filteredRows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();

            // Handle numerical sorting if applicable
            const aNum = parseFloat(aValue);
            const bNum = parseFloat(bValue);

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? aNum - bNum : bNum - aNum;
            }

            // Default to string comparison
            return isAscending
                ? aValue.localeCompare(bValue)
                : bValue.localeCompare(aValue);
        });

        currentPage = 1; // Reset to first page after sorting
        updateTable();
    }

    /**
     * Changes the current page by a given direction (+1 for next, -1 for previous).
     * @param {number} direction - The direction to change the page.
     */
    function changePage(direction) {
        const totalPages = Math.ceil(filteredRows.length / entriesPerPage);

        if (direction === -1 && currentPage > 1) {
            currentPage--;
        } else if (direction === 1 && currentPage < totalPages) {
            currentPage++;
        }

        updateTable();
    }

    /**
     * Navigates to a specific page number.
     * @param {number} page - The page number to navigate to.
     */
    function goToPage(page) {
        currentPage = page;
        updateTable();
    }

    /**
     * Updates the table display based on current page, entries per page, and filters.
     */
    function updateTable() {
        const tbody = document.getElementById('tableBody');
        // Clear previous content of tbody, will be repopulated with filtered/paginated rows
        tbody.innerHTML = '';

        const totalPages = Math.ceil(filteredRows.length / entriesPerPage);
        const startIndex = (currentPage - 1) * entriesPerPage;
        const endIndex = startIndex + entriesPerPage;

        if (filteredRows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Tidak ada laporan yang tersedia.</td></tr>';
        } else {
            for (let i = startIndex; i < endIndex && i < filteredRows.length; i++) {
                tbody.appendChild(filteredRows[i]);
            }
        }


        // Update pagination information text
        const showing = filteredRows.length === 0 ? 0 : startIndex + 1;
        const to = Math.min(endIndex, filteredRows.length);
        document.getElementById('paginationInfo').textContent =
            `Menampilkan ${showing} sampai ${to} dari ${filteredRows.length} data`;

        // Update pagination buttons and page numbers
        updatePagination(totalPages);
    }

    /**
     * Updates the pagination controls (buttons and page numbers).
     * @param {number} totalPages - The total number of pages.
     */
    function updatePagination(totalPages) {
        const paginationNumbers = document.getElementById('paginationNumbers');
        if (!paginationNumbers) return;

        let numbersHtml = '';
        const maxPageNumbersToShow = 5; // How many page numbers to show at once
        let startPage = Math.max(1, currentPage - Math.floor(maxPageNumbersToShow / 2));
        let endPage = Math.min(totalPages, startPage + maxPageNumbersToShow - 1);

        // Adjust startPage if we are at the end of total pages
        if (endPage - startPage + 1 < maxPageNumbersToShow) {
            startPage = Math.max(1, endPage - maxPageNumbersToShow + 1);
        }

        // Add first page and ellipsis if needed
        if (startPage > 1) {
            numbersHtml += `<button class="page-number" onclick="goToPage(1)">1</button>`;
            if (startPage > 2) {
                numbersHtml += `<span class="pagination-ellipsis">...</span>`;
            }
        }

        // Add page numbers
        for (let i = startPage; i <= endPage; i++) {
            numbersHtml += `
                <button class="page-number ${i === currentPage ? 'active' : ''}"
                        onclick="goToPage(${i})">${i}</button>
            `;
        }

        // Add last page and ellipsis if needed
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                numbersHtml += `<span class="pagination-ellipsis">...</span>`;
            }
            numbersHtml += `<button class="page-number" onclick="goToPage(${totalPages})">${totalPages}</button>`;
        }

        paginationNumbers.innerHTML = numbersHtml;

        // Update button states (Previous/Next)
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    }

    /**
     * Displays an alert message using Bootstrap Toast.
     * @param {string} message - The message to display.
     * @param {string} type - The type of alert ('success' or 'error').
     */
    function showAlert(message, type = 'info') {
        const toastLiveExample = document.getElementById('liveToast');
        const toastMessage = document.getElementById('toastMessage');
        const toast = new bootstrap.Toast(toastLiveExample);

        toastMessage.textContent = message;
        toastLiveExample.classList.remove('bg-success', 'bg-danger'); // Clear previous types
        if (type === 'success') {
            toastLiveExample.classList.add('bg-success');
        } else if (type === 'error') {
            toastLiveExample.classList.add('bg-danger');
        } else {
            // Default to a neutral color if 'info' or other type
            toastLiveExample.classList.add('bg-primary'); // You might want to define bg-info or bg-primary in your CSS
        }
        toast.show();
    }


    /**
     * Populates and displays the detail modal for a reporter.
     * @param {HTMLElement} element - The button element that triggered the view.
     */
    function viewDetail(element) {
        let reporter = $(element).data('report'); // Use .data() for data attributes

        $("#detailTanggal").text(reporter.formatted_created_date);
        $("#detailNIS").text(reporter.student.nis);
        $("#detailEmail").text(reporter.student.email);
        $("#detailUraian").text(reporter.description);

        // Populate keywords
        const keywordsContainer = $("#detailKataKunci");
        if (reporter.crime && reporter.crime.length > 0) {
            let html = "";
            reporter.crime.forEach(function (item) {
                // You'll need to map your 'item.name' to the appropriate class (severity-high, severity-medium, location, category, time)
                // For now, I'll use a generic class or you can add logic based on `item.name` or another property in your `crime` object.
                let keywordClass = '';
                let iconSvg = '';

                // Example of adding logic for keyword classes and icons based on keyword name
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
                    keywordClass = 'category'; // Default class if no match
                    iconSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'; // Generic tag icon
                }


                html += `<span class="keyword-tag ${keywordClass}">${iconSvg} ${item.name}</span>`;
            });
            keywordsContainer.html(html);
        } else {
            keywordsContainer.html('<span class="text-muted">Tidak ada kata kunci</span>');
        }

        // Populate evidence files (images/videos)
        const buktiGrid = $("#detailBukti .bukti-grid"); // Target the .bukti-grid inside #detailBukti
        buktiGrid.empty(); // Clear previous content

        if (reporter.reporter_file && reporter.reporter_file.length > 0) {
            let htmlMedia = "";
            reporter.reporter_file.forEach(function (file) {
                const fileName = file.file.split('/').pop(); // Get file name from URL
                const fileSize = 'N/A'; // Or a default like 'Unknown size'

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

        // Update status indicator in the footer
        const statusDot = $("#detailStatusDot");
        const statusText = $("#detailStatusText");
        statusDot.removeClass('pending approved rejected'); // Clear existing classes
        let statusMessage = '';

        if (reporter.status == 0) { // Assuming 0 is 'pending' or 'new'
            statusDot.addClass('pending');
            statusMessage = 'Menunggu Review';
            $("#btnReject").show();
            $("#btnAccept").show();
        } else if (reporter.status == 1) { // Assuming 1 is 'approved'
            statusDot.addClass('approved');
            statusMessage = 'Laporan Diterima';
            $("#btnReject").hide();
            $("#btnAccept").hide();
        } else if (reporter.status == 2) { // Assuming 2 is 'rejected'
            statusDot.addClass('rejected');
            statusMessage = 'Laporan Ditolak';
            $("#btnReject").hide();
            $("#btnAccept").hide();
        }
        statusText.text(`Status: ${statusMessage}`);


        $("#btnReject").attr('data-id', reporter.id);
        $("#btnAccept").attr('data-id', reporter.id);
        $("#modal-detail").modal('show'); // Assuming you have a Bootstrap modal or similar
    }

    // --- Utility Functions (unchanged from your original) ---

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
            imageModal.style.display = 'flex'; // Use 'flex' for centering
        }
    }

    function closeImageModal() {
        const imageModal = document.getElementById('imageModal');
        if (imageModal) {
            imageModal.style.display = 'none';
            document.getElementById('modalImage').src = ''; // Clear image src
        }
    }

    // Close profile menu when clicking outside
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