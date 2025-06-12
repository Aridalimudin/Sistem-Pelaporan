@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Data Laporan</h1>
        <div class="user-info">
            <i class="fa-solid fa-user-circle"></i>
        </div>
    </header>
    
    <div class="card">
        <div class="card-header">
            <h3>Data Laporan</h3>
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
                            <th>No</th>
                            <th>ID</th>
                            <th>Laporan & saran</th>
                            <th>Hasil kinerja</th>
                            <th>Tindakan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="LaporanTable">
                        <tr>
                            <td>1</td>
                            <td>123456</td>
                            <td>Lorem ipsum dolor</td>
                            <td>Kurang baik</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-detail" onclick="showDetail('123456')">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>123457</td>
                            <td>Lorem ipsum dolor</td>
                            <td>Baik</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-detail" onclick="showDetail('123457')">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>123458</td>
                            <td>Lorem ipsum dolor</td>
                            <td>Sangat baik</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-detail" onclick="showDetail('123458')">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>123459</td>
                            <td>Lorem ipsum dolor</td>
                            <td>Tidak baik</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-detail" onclick="showDetail('123459')">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>123460</td>
                            <td>Lorem ipsum dolor</td>
                            <td>Baik</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-detail" onclick="showDetail('123460')">Detail</button>
                            </td>
                        </tr>
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
    
    <!-- Modal Detail Laporan -->
    <div class="modal" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Laporan</h3>
                <button class="close-btn" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button class="btn-close" onclick="closeDetailModal()">Tutup</button>
            </div>
        </div>
    </div>
</main>

<script>
    // Global variables
    let laporanData = [
        { no: 1, id: '123456', laporan: 'Lorem ipsum dolor', hasil: 'Kurang baik', tindakan: 'SP1', detail: 'Detail laporan untuk ID 123456...' },
        { no: 2, id: '123457', laporan: 'Lorem ipsum dolor', hasil: 'Baik', tindakan: 'SP1', detail: 'Detail laporan untuk ID 123457...' },
        { no: 3, id: '123458', laporan: 'Lorem ipsum dolor', hasil: 'Sangat baik', tindakan: 'SP1', detail: 'Detail laporan untuk ID 123458...' },
        { no: 4, id: '123459', laporan: 'Lorem ipsum dolor', hasil: 'Tidak baik', tindakan: 'SP1', detail: 'Detail laporan untuk ID 123459...' },
        { no: 5, id: '123460', laporan: 'Lorem ipsum dolor', hasil: 'Baik', tindakan: 'SP1', detail: 'Detail laporan untuk ID 123460...' }
    ];
    
    // Toggle sidebar
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("active");
    }
    
    // Show detail modal
    function showDetail(id) {
        const laporan = laporanData.find(item => item.id === id);
        if (laporan) {
            document.getElementById('detailContent').innerHTML = `
                <div class="detail-item">
                    <strong>ID:</strong> ${laporan.id}
                </div>
                <div class="detail-item">
                    <strong>Laporan & saran:</strong> ${laporan.laporan}
                </div>
                <div class="detail-item">
                    <strong>Hasil kinerja:</strong> ${laporan.hasil}
                </div>
                <div class="detail-item">
                    <strong>Tindakan:</strong> ${laporan.tindakan}
                </div>
                <div class="detail-item">
                    <strong>Detail tambahan:</strong> ${laporan.detail}
                </div>
            `;
            document.getElementById('detailModal').style.display = 'block';
        }
    }
    
    // Close detail modal
    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
    
    // Render table with data
    function renderTable() {
        const tableBody = document.getElementById('LaporanTable');
        tableBody.innerHTML = '';
        
        laporanData.forEach((item) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.no}</td>
                <td>${item.id}</td>
                <td>${item.laporan}</td>
                <td>${item.hasil}</td>
                <td>${item.tindakan}</td>
                <td>
                    <button class="btn-detail" onclick="showDetail('${item.id}')">Detail</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
    
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        const filteredData = laporanData.filter(item => 
            item.id.toLowerCase().includes(searchTerm) || 
            item.laporan.toLowerCase().includes(searchTerm) ||
            item.hasil.toLowerCase().includes(searchTerm) ||
            item.tindakan.toLowerCase().includes(searchTerm)
        );
        
        const tableBody = document.getElementById('LaporanTable');
        tableBody.innerHTML = '';
        
        filteredData.forEach((item) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.no}</td>
                <td>${item.id}</td>
                <td>${item.laporan}</td>
                <td>${item.hasil}</td>
                <td>${item.tindakan}</td>
                <td>
                    <button class="btn-detail" onclick="showDetail('${item.id}')">Detail</button>
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
    }
    
    .table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
    }
    
    .table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Button styles */
    .btn-detail {
        background-color: #ccc;
        color: #333;
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
        width: 100%;
    }
    
    .btn-detail:hover {
        background-color: #bbb;
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
        max-width: 600px;
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
    
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
    }
    
    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #999;
    }
    
    .btn-close {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    .detail-item {
        margin-bottom: 10px;
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