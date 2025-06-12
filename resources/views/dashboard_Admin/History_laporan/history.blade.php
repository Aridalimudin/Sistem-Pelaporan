@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">History Laporan</h1>
        <div class="user-info">
            <i class="fa-solid fa-user-circle"></i>
        </div>
    </header>
    
    <div class="card">
        <div class="card-header">
            <h3>History Data Laporan</h3>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search..." class="search-input">
                <button class="search-btn"><i class="fa-solid fa-search"></i></button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>ID</th>
                            <th>History</th>
                            <th>Penindak</th>
                            <th>Alasan</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="HistoryTable">
                        <!-- Table content will be generated dynamically by JavaScript -->
                    </tbody>
                </table>
            </div>
            
            <div class="table-footer">
                <div class="pagination">
                    <button class="page-btn">Previous</button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">Next</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Konfirmasi Hapus</h3>
                <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data laporan ini?</p>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
                    <button type="button" class="btn-delete" onclick="confirmDelete()">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Global variables
    let historyData = [];

    function fetchHistoryData() {
        fetch('/api/laporan/history')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Data dari API:", data.data);
                    historyData = data.data;
                    renderTable();
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak Ada Laporan Baru</td></tr>';
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showNotification('Terjadi kesalahan saat mengambil data', 'error');
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchHistoryData(); // ambil data saat halaman dimuat
    });

    let deleteId = null;
    
    // Toggle sidebar
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("active");
    }
    
    // Show delete confirmation
    function deleteReport(id) {
        deleteId = id;
        document.getElementById('deleteModal').style.display = 'block';
    }
    
    // Close delete modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        deleteId = null;
    }
    
    // Confirm delete
    function confirmDelete() {
        if (deleteId !== null) {
            historyData = historyData.filter(item => item.id !== deleteId);
            renderTable();
            closeDeleteModal();
            showNotification('Data laporan berhasil dihapus', 'success');
        }
    }
    
    // Kembalikan data
    function kembalikanData(id) {
    if (confirm("Apakah Anda yakin ingin mengembalikan laporan ini?")) {
        fetch('/laporan/kembalikan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Penting agar tidak ditolak oleh Laravel
            },
            body: JSON.stringify({ id_laporan: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Laporan berhasil dikembalikan', 'success');
                location.reload(); // Refresh halaman untuk update data
            } else {
                showNotification('Gagal mengembalikan laporan: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengembalikan laporan.', 'error');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Error loading data</td></tr>';
        });
    }
}
    
    // View data
    function viewData(id) {
        // Implement view functionality
        showNotification('Melihat detail laporan', 'success');
    }
    
    // Render table with data
    function renderTable() {
    const tableBody = document.getElementById('HistoryTable');
    tableBody.innerHTML = '';

    if (historyData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak Ada Laporan Baru</td></tr>';
        return;
    }

    historyData.forEach((item) => {
        const row = document.createElement('tr');
        row.innerHTML =  `
            <td>${item.pelapor || 'Anonim'}</td>
            <td>${item.id}</td>
            <td>${item.status || '-'}</td>
            <td>${item.orang_penindak || '-'}</td>
            <td>${item.alasan || '-'}</td>
            <td>${item.catatan || '-'}</td>
            <td>
                <button class="btn-kembalikan" onclick="kembalikanData('${item.id}')">Kembalikan</button>
                <button class="btn-view" onclick="viewData('${item.id}')"><i class="fa-solid fa-eye"></i></button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

    
    // Show notification
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerText = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }, 100);
    }
    
    // Search functionality
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        const filteredData = historyData.filter(item => 
            (item.user?.name || '').toLowerCase().includes(searchTerm) || 
            (item.id || '').toLowerCase().includes(searchTerm) ||
            (item.updated_by?.name || '').toLowerCase().includes(searchTerm) ||
            (item.alasan || '').toLowerCase().includes(searchTerm)
        );
        
        const tableBody = document.getElementById('HistoryTable');
        tableBody.innerHTML = '';
        
        filteredData.forEach((item) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.user?.name || '-'}</td>
                <td>${item.id}</td>
                <td>${item.status || '-'}</td>
                <td>${item.updated_by?.name || '-'}</td>
                <td>${item.alasan || '-'}</td>
                <td>${item.catatan || '-'}</td>
                <td>
                    <button class="btn-kembalikan" onclick="kembalikanData('${item.id}')">Kembalikan</button>
                    <button class="btn-view" onclick="viewData('${item.id}')"><i class="fa-solid fa-eye"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    });
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderTable();
    });
</script>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
<style>
    /* Card styles */
    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    
    .card-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-body {
        padding: 20px;
    }
    
    /* Search styles */
    .search-container {
        display: flex;
        align-items: center;
    }
    
    .search-input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px 0 0 5px;
        outline: none;
    }
    
    .search-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }
    
    /* Table styles */
    .table-responsive {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
    }
    
    .table th, .table td {
        border: 1px solid #ddd;
    }
    
    .table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
    }
    
    .table td {
        padding: 12px 15px;
    }
    
    .table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Button styles */
    .btn-kembalikan, .btn-delete, .btn-view {
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 5px;
        transition: var(--transition);
    }
    
    .btn-kembalikan {
        background-color: var(--accent-color);
        color: white;
    }
    
    .btn-delete {
        background-color: var(--danger-color);
        color: white;
    }
    
    .btn-view {
        background-color: var(--primary-color);
        color: white;
    }
    
    /* Table footer */
    .table-footer {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 15px;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        gap: 5px;
    }
    
    .page-btn {
        border: 1px solid #ddd;
        background: white;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .page-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }
    
    .modal-content {
        background: white;
        margin: 10% auto;
        width: 90%;
        max-width: 500px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s;
    }
    
    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #999;
    }
    
    .form-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn-cancel {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    /* Notification */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 2000;
    }
    
    .notification.success {
        background-color: var(--success-color);
    }
    
    .notification.error {
        background-color: var(--danger-color);
    }
    
    .notification.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .search-container {
            width: 100%;
            margin-top: 10px;
        }
        
        .search-input {
            width: 100%;
        }
        
        .table-footer {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
@endpush
@endsection