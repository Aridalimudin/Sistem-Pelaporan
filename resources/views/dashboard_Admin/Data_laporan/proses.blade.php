@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Laporan Di Proses</h1>
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
                            <th>No</th>
                            <th>Tanggal Lapor</th>
                            <th>Pelapor</th>
                            <th>ID</th>
                            <th>JEnis Kasus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="LaporanTable">
                        <tr>
                            <td>1</td>
                            <td>01 Januari 2025</td>
                            <td>Anonim</td>
                            <td>P2WQ13</td>
                            <td>Berat</td>
                            <td>
                                <button class="btn-tindakan" onclick="showTindakanModal('P2WQ13')">Beri Tindakan</button>
                                <button class="btn-view" onclick="viewReport('P2WQ13')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>02 Januari 2025</td>
                            <td>Anonim</td>
                            <td>N3KA01</td>
                            <td>Berat</td>
                            <td>
                                <button class="btn-tindakan" onclick="showTindakanModal('N3KA01')">Beri Tindakan</button>
                                <button class="btn-view" onclick="viewReport('N3KA01')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>03 Januari 2025</td>
                            <td>Indra</td>
                            <td>C0H104</td>
                            <td>Sedang</td>
                            <td>
                                <button class="btn-tindakan" onclick="showTindakanModal('C0H104')">Beri Tindakan</button>
                                <button class="btn-view" onclick="viewReport('C0H104')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>04 Januari 2025</td>
                            <td>Anonim</td>
                            <td>G8K147</td>
                            <td>Sedang</td>
                            <td>
                                <button class="btn-tindakan" onclick="showTindakanModal('G8K147')">Beri Tindakan</button>
                                <button class="btn-view" onclick="viewReport('G8K147')"><i class="fa-solid fa-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>05 Januari 2025</td>
                            <td>Nisa</td>
                            <td>L9MM74</td>
                            <td>Sedang</td>
                            <td>
                                <button class="btn-tindakan" onclick="showTindakanModal('L9MM74')">Beri Tindakan</button>
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
    
    <!-- Modal Tindakan -->
    <div class="modal" id="tindakanModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Tindakan</h3>
                <button class="close-btn" onclick="closeTindakanModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tindakanId">ID Laporan:</label>
                    <input type="text" id="tindakanId" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="jenisTindakan">Jenis Tindakan:</label>
                    <select id="jenisTindakan" class="form-control">
                        <option value="perbaikan">Perbaikan</option>
                        <option value="penyelidikan">Penyelidikan</option>
                        <option value="monitoring">Monitoring</option>
                        <option value="penanganan">Penanganan Langsung</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deskripsiTindakan">Deskripsi Tindakan:</label>
                    <textarea id="deskripsiTindakan" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="buktiTindakan">Foto Bukti Tindakan (opsional):</label>
                    <input type="file" id="buktiTindakan" class="form-control">
                    <div id="previewBukti" class="preview-image"></div>
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeTindakanModal()">Batal</button>
                    <button type="button" class="btn-submit" onclick="submitTindakan()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Notification -->
    <div class="notification" id="notification"></div>
</main>

<script>
    // Global variables
    let laporanData = [];

    document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/laporan/laporan/proses')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                laporanData = result.data.map((item, index) => ({
                    no: index + 1,
                    tanggal: new Date(item.tanggal_lapor).toLocaleDateString('id-ID', {
                        day: '2-digit', month: 'long', year: 'numeric'
                    }),
                    pelapor: item.is_anonim ? 'Anonim' : (item.nama_pelapor ?? '-'),
                    id: item.id_laporan,
                    jeniskasus: item.jeniskasus,
                    detail: item.uraian
                }));

                renderTable();
            } else {
                showNotification('Gagal ambil data laporan', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showNotification('Terjadi kesalahan saat memuat data', 'error');
        });
        });
    
    // Array untuk menyimpan laporan yang ditindaklanjuti
    let laporanDitindaklanjuti = [];
    
    let currentReportId = null;
    
    // Show tindakan modal
    function showTindakanModal(id) {
        currentReportId = id;
        document.getElementById('tindakanId').value = id;
        document.getElementById('tindakanModal').style.display = 'block';
    }
    
    // Close tindakan modal
    function closeTindakanModal() {
        document.getElementById('tindakanModal').style.display = 'none';
        document.getElementById('deskripsiTindakan').value = '';
        document.getElementById('buktiTindakan').value = '';
        document.getElementById('previewBukti').innerHTML = '';
        currentReportId = null;
    }
    
    // Submit tindakan
    function submitTindakan() {
        const id = document.getElementById('tindakanId').value;
        const jenis = document.getElementById('jenisTindakan').value;
        const deskripsi = document.getElementById('deskripsiTindakan').value;
        
        // Get file if uploaded
        const fileInput = document.getElementById('buktiTindakan');
        const hasBukti = fileInput.files && fileInput.files[0];
        
        // Validasi input
        if (!deskripsi.trim()) {
            showNotification('Deskripsi tindakan harus diisi', 'error');
            return;
        }
        
        // Cari laporan berdasarkan ID
        const laporan = laporanData.find(item => item.id === id);
        
        if (laporan) {
            // Tambahkan laporan ke daftar yang ditindaklanjuti
            laporanDitindaklanjuti.push({
                ...laporan,
                jenisTindakan: jenis,
                deskripsiTindakan: deskripsi,
                waktuTindakan: new Date().toLocaleString(),
                bukti: hasBukti ? fileInput.files[0].name : null
            });
            
            console.log('Laporan Ditindaklanjuti:', laporanDitindaklanjuti);
            
            // Hapus dari daftar yang belum ditindaklanjuti
            laporanData = laporanData.filter(item => item.id !== id);
            renderTable();
            
            // Tampilkan notifikasi
            showNotification(`Tindakan untuk laporan ${id} berhasil dicatat`, 'success');
            
            // Tutup modal
            closeTindakanModal();
        }
    }
    
    // Preview bukti foto
    document.getElementById('buktiTindakan').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('previewBukti');
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview Bukti" style="max-width: 100%; max-height: 200px;">`;
            }
            
            reader.readAsDataURL(file);
        }
    });
    
    // View report details
    function viewReport(id) {
        const report = laporanData.find(item => item.id === id);
        if (report) {
            // Here you would normally show report details
            console.log(`Viewing report details for ID: ${id}`);
            alert(`Detail Laporan untuk ID ${id}:\n${report.detail}`);
        }
    }
    
    // Render table with data
    function renderTable() {
        const tableBody = document.getElementById('LaporanTable');
        tableBody.innerHTML = '';
        
        laporanData.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.tanggal}</td>
                <td>${item.pelapor}</td>
                <td>${item.id}</td>
                <td>${item.jeniskasus}</td>
                <td>
                    <button class="btn-tindakan" onclick="showTindakanModal('${item.id}')">Beri Tindakan</button>
                    <button class="btn-view" onclick="viewReport('${item.id}')"><i class="fa-solid fa-eye"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });
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
        
        const filteredData = laporanData.filter(item => 
            item.tanggal.toLowerCase().includes(searchTerm) || 
            item.pelapor.toLowerCase().includes(searchTerm) ||
            item.id.toLowerCase().includes(searchTerm) ||
            item.jeniskasus.toLowerCase().includes(searchTerm)
        );
        
        const tableBody = document.getElementById('LaporanTable');
        tableBody.innerHTML = '';
        
        filteredData.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.tanggal}</td>
                <td>${item.pelapor}</td>
                <td>${item.id}</td>
                <td>${item.jeniskasus}</td>
                <td>
                    <button class="btn-tindakan" onclick="showTindakanModal('${item.id}')">Beri Tindakan</button>
                    <button class="btn-view" onclick="viewReport('${item.id}')"><i class="fa-solid fa-eye"></i></button>
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
    .btn-tindakan {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
        padding: 5px 8px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-tindakan:hover {
        background-color: #e0e0e0;
    }
    
    .btn-view {
        background-color: #2196F3;
        color: white;
        border: none;
        width: 25px;
        height: 25px;
        border-radius: 4px;
        cursor: pointer;
        margin-left: 5px;
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
        margin: 10% auto;
        width: 90%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s;
    }
    
    .modal-header {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    
    .form-group {
        margin-bottom: 12px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
    }
    
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
    }
    
    .preview-image {
        margin-top: 8px;
        text-align: center;
    }
    
    .form-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 15px;
    }
    
    .btn-cancel {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .btn-submit {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
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
    }
</style>
@endpush
@endsection


