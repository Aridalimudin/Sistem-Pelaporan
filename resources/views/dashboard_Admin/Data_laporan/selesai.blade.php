@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Laporan Selesai</h1>
        <div class="user-info">
            <i class="fa-solid fa-user-circle"></i>
        </div>
    </header>
    
    <div class="card">
        <div class="card-header">
            <div class="search-filter-container">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search..." class="search-input">
                    <button class="search-btn"><i class="fa-solid fa-search"></i></button>
                </div>
                <div class="filter-container">
                    <button class="filter-btn">
                        <i class="fa-solid fa-filter"></i> All Filters
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pelapor</th>
                            <th>ID</th>
                            <th>Urgensi</th>
                            <th>Di verifikasi</th>
                            <th>Tindaklanjut</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="LaporanTable">
                        <tr>
                            <td>Anonim</td>
                            <td>P2WQ13</td>
                            <td>Berat</td>
                            <td>Siti Rohimah</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-view" onclick="viewReport('P2WQ13')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Anonim</td>
                            <td>N3KA01</td>
                            <td>Berat</td>
                            <td>Siti Rohimah</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-view" onclick="viewReport('N3KA01')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Indra</td>
                            <td>C0H104</td>
                            <td>Sedang</td>
                            <td>Siti Rohimah</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-view" onclick="viewReport('C0H104')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Anonim</td>
                            <td>G8K147</td>
                            <td>Sedang</td>
                            <td>Siti Rohimah</td>
                            <td>SP2</td>
                            <td>
                                <button class="btn-view" onclick="viewReport('G8K147')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Nisa</td>
                            <td>L9MM74</td>
                            <td>Sedang</td>
                            <td>Siti Rohimah</td>
                            <td>SP1</td>
                            <td>
                                <button class="btn-view" onclick="viewReport('L9MM74')"><i class="fa-solid fa-eye"></i></button>
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
            <div class="modal-body">
                <div class="laporan-detail">
                    <div class="detail-item">
                        <strong>ID Laporan:</strong>
                        <span id="detailId"></span>
                    </div>
                    <div class="detail-item">
                        <strong>Pelapor:</strong>
                        <span id="detailPelapor"></span>
                    </div>
                    <div class="detail-item">
                        <strong>Urgensi:</strong>
                        <span id="detailUrgensi"></span>
                    </div>
                    <div class="detail-item">
                        <strong>Diverifikasi Oleh:</strong>
                        <span id="detailVerifikator"></span>
                    </div>
                    <div class="detail-item">
                        <strong>Jenis Tindaklanjut:</strong>
                        <span id="detailTindaklanjut"></span>
                    </div>
                    <div class="detail-item">
                        <strong>Deskripsi Masalah:</strong>
                        <p id="detailDeskripsi"></p>
                    </div>
                    <div class="detail-item">
                        <strong>Tindakan yang Dilakukan:</strong>
                        <p id="detailTindakan"></p>
                    </div>
                    <div class="detail-item">
                        <strong>Bukti Tindaklanjut:</strong>
                        <div id="detailBukti" class="bukti-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification -->
    <div class="notification" id="notification"></div>
</main>

<script>
    // Data laporan yang sudah selesai
    let laporanSelesai = [
        { 
            pelapor: 'Anonim', 
            id: 'P2WQ13', 
            urgensi: 'Berat', 
            verifikator: 'Siti Rohimah', 
            tindaklanjut: 'SP1',
            deskripsi: 'Laporan mengenai pelanggaran kedisiplinan pada tanggal 28 Desember 2024',
            tindakan: 'Telah dilakukan pemberian Surat Peringatan Pertama (SP1) pada tanggal 5 Januari 2025',
            bukti: ['bukti_p2wq13_1.jpg', 'bukti_p2wq13_2.jpg']
        },
        { 
            pelapor: 'Anonim', 
            id: 'N3KA01', 
            urgensi: 'Berat', 
            verifikator: 'Siti Rohimah', 
            tindaklanjut: 'SP1',
            deskripsi: 'Laporan mengenai keterlambatan pengumpulan tugas secara berulang',
            tindakan: 'Telah dilakukan pemberian Surat Peringatan Pertama (SP1) pada tanggal 6 Januari 2025',
            bukti: ['bukti_n3ka01.jpg']
        },
        { 
            pelapor: 'Indra', 
            id: 'C0H104', 
            urgensi: 'Sedang', 
            verifikator: 'Siti Rohimah', 
            tindaklanjut: 'SP1',
            deskripsi: 'Laporan mengenai ketidakhadiran tanpa keterangan selama 3 hari berturut-turut',
            tindakan: 'Telah dilakukan pemberian Surat Peringatan Pertama (SP1) pada tanggal 7 Januari 2025',
            bukti: ['bukti_c0h104.jpg']
        },
        { 
            pelapor: 'Anonim', 
            id: 'G8K147', 
            urgensi: 'Sedang', 
            verifikator: 'Siti Rohimah', 
            tindaklanjut: 'SP2',
            deskripsi: 'Laporan mengenai pelanggaran tata tertib sekolah untuk kedua kalinya',
            tindakan: 'Telah dilakukan pemberian Surat Peringatan Kedua (SP2) pada tanggal 8 Januari 2025',
            bukti: ['bukti_g8k147.jpg']
        },
        { 
            pelapor: 'Nisa', 
            id: 'L9MM74', 
            urgensi: 'Sedang', 
            verifikator: 'Siti Rohimah', 
            tindaklanjut: 'SP1',
            deskripsi: 'Laporan mengenai ketidakpatuhan terhadap instruksi guru',
            tindakan: 'Telah dilakukan pemberian Surat Peringatan Pertama (SP1) pada tanggal 9 Januari 2025',
            bukti: ['bukti_l9mm74_1.jpg', 'bukti_l9mm74_2.jpg']
        },
    ];
    
    // View report details
    function viewReport(id) {
        const report = laporanSelesai.find(item => item.id === id);
        if (report) {
            // Tampilkan detail laporan di modal
            document.getElementById('detailId').textContent = report.id;
            document.getElementById('detailPelapor').textContent = report.pelapor;
            document.getElementById('detailUrgensi').textContent = report.urgensi;
            document.getElementById('detailVerifikator').textContent = report.verifikator;
            document.getElementById('detailTindaklanjut').textContent = report.tindaklanjut;
            document.getElementById('detailDeskripsi').textContent = report.deskripsi;
            document.getElementById('detailTindakan').textContent = report.tindakan;
            
            // Tampilkan bukti
            const buktiContainer = document.getElementById('detailBukti');
            buktiContainer.innerHTML = '';
            
            if (report.bukti && report.bukti.length > 0) {
                report.bukti.forEach(bukti => {
                    // Di implementasi nyata, gunakan URL gambar yang sebenarnya
                    buktiContainer.innerHTML += `
                        <div class="bukti-item">
                            <img src="/images/bukti/${bukti}" alt="Bukti ${report.id}" class="bukti-img">
                            <p>${bukti}</p>
                        </div>
                    `;
                });
            } else {
                buktiContainer.innerHTML = '<p>Tidak ada bukti yang diunggah</p>';
            }
            
            // Tampilkan modal
            document.getElementById('detailModal').style.display = 'block';
        }
    }
    
    // Close detail modal
    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
    
    // Show notification
    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `notification ${type} show`;
        
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }
    
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        
        const filteredData = laporanSelesai.filter(item => 
            item.pelapor.toLowerCase().includes(searchTerm) || 
            item.id.toLowerCase().includes(searchTerm) ||
            item.urgensi.toLowerCase().includes(searchTerm) ||
            item.verifikator.toLowerCase().includes(searchTerm) ||
            item.tindaklanjut.toLowerCase().includes(searchTerm)
        );
        
        const tableBody = document.getElementById('LaporanTable');
        tableBody.innerHTML = '';
        
        filteredData.forEach((item) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.pelapor}</td>
                <td>${item.id}</td>
                <td>${item.urgensi}</td>
                <td>${item.verifikator}</td>
                <td>${item.tindaklanjut}</td>
                <td>
                    <button class="btn-view" onclick="viewReport('${item.id}')"><i class="fa-solid fa-eye"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    });
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Jika diperlukan inisialisasi lainnya
    });
</script>

@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
<style>
    /* Main container */
    .content {
        padding: 20px;
        background-color: #f5f5f5;
    }
    
    /* Header styles */
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .header-title {
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    /* Card styles */
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    
    .card-header {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .search-filter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-body {
        padding: 15px;
    }
    
    /* Search styles */
    .search-container {
        display: flex;
        align-items: center;
    }
    
    .search-input {
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        width: 200px;
    }
    
    .search-btn {
        background: transparent;
        border: none;
        padding: 6px 10px;
        cursor: pointer;
        margin-left: -35px;
    }
    
    /* Filter styles */
    .filter-btn {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #ddd;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .filter-btn i {
        margin-right: 5px;
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
        background-color: #f8f8f8;
        padding: 10px 12px;
        text-align: left;
        font-weight: 600;
        border: 1px solid #ddd;
    }
    
    .table td {
        padding: 10px 12px;
        border: 1px solid #ddd;
    }
    
    .table tr:hover {
        background-color: #f9f9f9;
    }
    
    /* Button styles */
    .btn-view {
        background-color: #2196F3;
        color: white;
        border: none;
        width: 25px;
        height: 25px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Table footer */
    .table-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-top: 12px;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        gap: 5px;
    }
    
    .page-btn {
        border: 1px solid #ddd;
        background: white;
        padding: 4px 8px;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .page-btn.active {
        background: #4CAF50;
        color: white;
        border-color: #4CAF50;
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
        margin: 5% auto;
        width: 90%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .modal-header {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        background: white;
        z-index: 1;
    }
    
    .modal-body {
        padding: 15px;
    }
    
    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #999;
    }
    
    /* Detail Laporan styles */
    .laporan-detail {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .detail-item {
        margin-bottom: 8px;
    }
    
    .detail-item strong {
        display: block;
        margin-bottom: 4px;
        color: #555;
    }
    
    .bukti-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 8px;
    }
    
    .bukti-item {
        width: 150px;
        text-align: center;
    }
    
    .bukti-img {
        width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        object-fit: cover;
        margin-bottom: 5px;
    }
    
    /* Notification */
    .notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 12px 15px;
        border-radius: 4px;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 2000;
    }
    
    .notification.success {
        background-color: #4CAF50;
    }
    
    .notification.error {
        background-color: #F44336;
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
        from { transform: translateY(-30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .search-filter-container {
            flex-direction: column;
            gap: 8px;
        }
        
        .search-input {
            width: 100%;
        }
        
        .filter-container {
            align-self: flex-end;
        }
        
        .bukti-container {
            justify-content: center;
        }
    }
</style>
@endpush
@endsection