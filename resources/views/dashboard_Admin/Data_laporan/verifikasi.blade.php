@extends('layouts.main_ds')
@section('content')

<main id="content" class="content">
    <header>
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1 class="header-title">Belum Verifikasi</h1>
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
                            <th>Jenis Kasus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="LaporanTable">
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
    
    <!-- Confirmation Modal -->
    <div class="modal" id="confirmationModal">
        <div class="modal-content confirmation-modal">
        <button class="close-btn" onclick="closeTolakModal()">&times;</button>
            <div class="modal-body">
                <h3>Apakah laporan selesai di validasi??</h3>
                <div class="confirm-buttons">
                    <button id="btnLaporanSelesai" class="btn-confirm-selesai">Laporan Selesai di Verifikasi</button>
                    <button id="btnTolakLaporan" class="btn-confirm-tolak">Tolak Laporan</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Alasan Tolak -->
    <div class="modal" id="tolakModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Alasan Penolakan Laporan</h3>
                <button class="close-btn" onclick="closeTolakModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tolakId">ID Laporan:</label>
                    <input type="text" id="tolakId" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="alasanTolak">Pilih Alasan Penolakan:</label>
                    <select id="alasanTolak" class="form-control">
                        <option value="dataTidakLengkap">Data Tidak Lengkap</option>
                        <option value="tidakSesuaiKriteria">Tidak Sesuai Kriteria</option>
                        <option value="informasiPalsu">Informasi Palsu</option>
                        <option value="duplikat">Laporan Duplikat</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="catatanTolak">Catatan Tambahan:</label>
                    <textarea id="catatanTolak" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeTolakModal()">Batal</button>
                    <button type="button" class="btn-submit" onclick="submitTolakLaporan()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Verifikasi -->
    <div class="modal" id="verifikasiModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Verifikasi Laporan</h3>
                <button class="close-btn" onclick="closeVerifikasiModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="reportId">ID Laporan:</label>
                    <input type="text" id="reportId" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="verifikasiStatus">Status Verifikasi:</label>
                    <select id="verifikasiStatus" class="form-control">
                        <option value="valid">Valid</option>
                        <option value="tidakValid">Tidak Valid</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="verifikasiNote">Catatan:</label>
                    <textarea id="verifikasiNote" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="closeVerifikasiModal()">Batal</button>
                    <button type="button" class="btn-submit" onclick="submitVerifikasi()">Submit</button>
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
    
    // Array untuk menyimpan laporan yang diproses
    let laporanProses = [];
    
    // Array untuk menyimpan history laporan
    let laporanHistory = [];
    
    let currentReportId = null;
    
    // Toggle sidebar
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("active");
    }
    
    // Show confirmation modal
    function showVerifikasiModal(id) {
        currentReportId = id;
        document.getElementById('confirmationModal').style.display = 'block';
        
        // Set up button event listeners
        document.getElementById('btnLaporanSelesai').onclick = function() {
            document.getElementById('confirmationModal').style.display = 'none';
            processLaporanSelesai(id);
        };
        
        document.getElementById('btnTolakLaporan').onclick = function() {
            document.getElementById('confirmationModal').style.display = 'none';
            showTolakModal(id);
        };
    }
    
    // Process "Laporan Selesai" action
    function processLaporanSelesai(id) {
    // Cari token CSRF dengan cara yang lebih aman
    let token = '';
    const csrfElement = document.querySelector('meta[name="csrf-token"]');
    
    if (csrfElement) {
        token = csrfElement.getAttribute('content');
    } else {
        // Fallback jika meta tidak ditemukan
        console.warn('CSRF token tidak ditemukan, menggunakan fallback');
        token = 'fallback_token'; // Anda bisa menyimpan token di variabel global/hidden input
    }
    
    fetch('/api/laporan/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            id_laporan: id,
            status: 'PROSES',
            catatan: 'Laporan terverifikasi'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Cari laporan berdasarkan ID
            const laporan = laporanData.find(item => item.id === id);
            
            if (laporan) {
                // Tambahkan laporan ke daftar proses
                laporanProses.push({
                    ...laporan,
                    statusVerifikasi: 'Valid',
                    waktuVerifikasi: new Date().toLocaleString(),
                    catatan: 'Laporan terverifikasi'
                });
                
                // Hapus dari daftar yang belum diverifikasi
                laporanData = laporanData.filter(item => item.id !== id);
                renderTable();
                
                // Tampilkan notifikasi
                showNotification(`Laporan ${id} berhasil diverifikasi dan masuk menu Proses`, 'success');
                
                // Arahkan ke halaman proses jika diperlukan
                window.location.href = '/dashboard_Admin/History_laporan/history';
            }
        } else {
            showNotification('Gagal memproses laporan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses laporan', 'error');
    });
}
    
    // Show tolak modal
    function showTolakModal(id) {
        document.getElementById('tolakId').value = id;
        document.getElementById('tolakModal').style.display = 'block';
    }
    
    // Close tolak modal
    function closeTolakModal() {
        document.getElementById('tolakModal').style.display = 'none';
        document.getElementById('catatanTolak').value = '';
    }
    
    // Submit penolakan laporan
    function submitTolakLaporan() {
        const id = document.getElementById('tolakId').value;
        const alasan = document.getElementById('alasanTolak').value;
        const catatan = document.getElementById('catatanTolak').value;
        
        // Cari laporan berdasarkan ID
        const laporan = laporanData.find(item => item.id === id);
        
        if (laporan) {
            // Tambahkan laporan ke history
            laporanHistory.push({
                ...laporan,
                statusVerifikasi: 'Ditolak',
                waktuPenolakan: new Date().toLocaleString(),
                alasanPenolakan: alasan,
                catatanPenolakan: catatan
            });
            
            console.log('Laporan History:', laporanHistory);
            
            // Hapus dari daftar yang belum diverifikasi
            laporanData = laporanData.filter(item => item.id !== id);
            renderTable();
            
            // Tampilkan notifikasi
            showNotification(`Laporan ${id} ditolak dan masuk menu History`, 'error');
            
            // Tutup modal
            closeTolakModal();
            
            // Di sini bisa ditambahkan kode untuk mengarahkan ke halaman history
            // window.location.href = '/laporan/history';
        }
    }
    
    // Close verifikasi modal
    function closeVerifikasiModal() {
        document.getElementById('verifikasiModal').style.display = 'none';
        document.getElementById('verifikasiNote').value = '';
        currentReportId = null;
    }
    
    // Submit verification
    function submitVerifikasi() {
        const status = document.getElementById('verifikasiStatus').value;
        const note = document.getElementById('verifikasiNote').value;
        console.log(currentReportId);
        if (currentReportId) {
            // Cari laporan berdasarkan ID
            const laporan = laporanData.find(item => item.id === currentReportId);
            
            if (laporan) {
                if (status === 'valid') {
                    // Tambahkan laporan ke daftar proses
                    laporanProses.push({
                        ...laporan,
                        statusVerifikasi: 'Valid',
                        waktuVerifikasi: new Date().toLocaleString(),
                        catatan: note
                    });
                    
                    showNotification(`Laporan ${currentReportId} berhasil diverifikasi dan masuk menu Proses`, 'success');
                } else {
                    // Tambahkan laporan ke history
                    laporanHistory.push({
                        ...laporan,
                        statusVerifikasi: 'Ditolak',
                        waktuPenolakan: new Date().toLocaleString(),
                        alasanPenolakan: 'Tidak Valid',
                        catatanPenolakan: note
                    });
                    
                    showNotification(`Laporan ${currentReportId} ditolak dan masuk menu History`, 'error');
                }
                
                // Hapus dari daftar yang belum diverifikasi
                laporanData = laporanData.filter(item => item.id !== currentReportId);
                renderTable();
            }
            
            closeVerifikasiModal();
        }
    }
    
    // View report details
    function viewReport(id) {
        const report = laporanData.find(item => item.id === id);
        if (report) {
            // Here you would normally show report details
            console.log(`Viewing report details for ID: ${id}`);
            alert(`Detail Laporan untuk ID ${id}:\n${report.detail}`);
        }
    }
    
    // Fungsi untuk melihat laporan di menu proses
    function viewProcessReports() {
        console.log('Laporan dalam proses:', laporanProses);
        // Di sini bisa ditambahkan kode untuk mengarahkan ke halaman proses
        alert('Mengarahkan ke menu Proses');
        // window.location.href = '/laporan/proses';
    }
    
    // Fungsi untuk melihat history laporan
    function viewHistoryReports() {
        console.log('History laporan:', laporanHistory);
        // Di sini bisa ditambahkan kode untuk mengarahkan ke halaman history
        alert('Mengarahkan ke menu History');
        // window.location.href = '/laporan/history';
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
                    <button class="btn-verifikasi" onclick="showVerifikasiModal('${item.id}')">Tolak / Verifikasi</button>
                    <button class="btn-view" onclick="viewReport('${item.id}')"><i class="fa-solid fa-eye"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
    
    // Show notification
    function showNotification(message, type) {
    const notification = document.getElementById('notification');
    if (!notification) {
        console.error('Elemen notification tidak ditemukan');
        alert(message); // Fallback ke alert jika elemen tidak ditemukan
        return;
    }
    
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
                    <button class="btn-verifikasi" onclick="showVerifikasiModal('${item.id}')">Tolak / Verifikasi</button>
                    <button class="btn-view" onclick="viewReport('${item.id}')"><i class="fa-solid fa-eye"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    });
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        renderTable();
        //addNavigationButtons();
    });

    // Fungsi untuk mengambil data laporan yang belum diverifikasi dari server
    // Update the fetchUnverifiedReports function in the verification page
function fetchUnverifiedReports() {
    // Show loading indicator
    const tableBody = document.getElementById('LaporanTable');
    tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Loading data...</td></tr>';
    
    fetch('/api/laporan/unverified')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update variabel laporanData dengan data dari server
                laporanData = data.data.map((item, index) => {
                    return {
                        no: index + 1,
                        tanggal: formatDate(item.tanggal_lapor),
                        pelapor: item.is_anonim == 1 ? 'Anonim' : item.nama_pelapor,
                        id: item.id_laporan,
                        jeniskasus: item.jeniskasus,
                        detail: item.uraian
                    };
                });
                
                // Render ulang tabel dengan data baru
                renderTable();
            } else {
                tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak Ada Laporan Baru</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            showNotification('Gagal memuat data laporan', 'error');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Error loading data</td></tr>';
        });
}

// Make sure the renderTable function is working properly
function renderTable() {
    const tableBody = document.getElementById('LaporanTable');
    tableBody.innerHTML = '';
    
    if (laporanData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">Tidak Ada Laporan Baru</td></tr>';
        return;
    }
    
    laporanData.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${item.tanggal}</td>
            <td>${item.pelapor}</td>
            <td>${item.id}</td>
            <td>${item.jeniskasus}</td>
            <td>
                <button class="btn-verifikasi" onclick="showVerifikasiModal('${item.id}')">Tolak / Verifikasi</button>
                <button class="btn-view" onclick="viewReport('${item.id}')"><i class="fa-solid fa-eye"></i></button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Fungsi untuk memformat tanggal
function formatDate(dateString) {
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = new Intl.DateTimeFormat('id-ID', { month: 'long' }).format(date);
    const year = date.getFullYear();
    
    return `${day} ${month} ${year}`;
}

// Submit verification dengan API
function submitVerifikasi() {
    const status = document.getElementById('verifikasiStatus').value;
    const note = document.getElementById('verifikasiNote').value;
    
    if (currentReportId) {
        // Kirim permintaan verifikasi ke server
        fetch('/api/laporan/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                id_laporan: currentReportId,
                status: status === 'valid' ? 'PROSES' : 'DITOLAK',
                catatan: note
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cari laporan berdasarkan ID
                const laporan = laporanData.find(item => item.id === currentReportId);
                
                if (laporan) {
                    if (status === 'valid') {
                        // Tambahkan laporan ke daftar proses
                        laporanProses.push({
                            ...laporan,
                            statusVerifikasi: 'Valid',
                            waktuVerifikasi: new Date().toLocaleString(),
                            catatan: note
                        });
                        
                        showNotification(`Laporan ${currentReportId} berhasil diverifikasi dan masuk menu Proses`, 'success');
                    } else {
                        // Tambahkan laporan ke history
                        laporanHistory.push({
                            ...laporan,
                            statusVerifikasi: 'Ditolak',
                            waktuPenolakan: new Date().toLocaleString(),
                            alasanPenolakan: 'Tidak Valid',
                            catatanPenolakan: note
                        });
                        
                        showNotification(`Laporan ${currentReportId} ditolak dan masuk menu History`, 'error');
                    }
                    
                    // Hapus dari daftar yang belum diverifikasi
                    laporanData = laporanData.filter(item => item.id !== currentReportId);
                    renderTable();
                }
                
                closeVerifikasiModal();
            } else {
                showNotification('Gagal memverifikasi laporan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat memverifikasi laporan', 'error');
        });
    }
}

// Fungsi untuk menolak laporan dengan API
function submitTolakLaporan() {
    const id = document.getElementById('tolakId').value;
    const alasan = document.getElementById('alasanTolak').value;
    const catatan = document.getElementById('catatanTolak').value;
    const catatanLengkap = `${alasan}: ${catatan}`;
    
    // Kirim permintaan penolakan ke server
    fetch('/api/laporan/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id_laporan: id,
            status: 'DITOLAK',
            catatan: catatanLengkap
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Cari laporan berdasarkan ID
            const laporan = laporanData.find(item => item.id === id);
            
            if (laporan) {
                // Tambahkan laporan ke history
                laporanHistory.push({
                    ...laporan,
                    statusVerifikasi: 'Ditolak',
                    waktuPenolakan: new Date().toLocaleString(),
                    alasanPenolakan: alasan,
                    catatanPenolakan: catatan
                });
                
                // Hapus dari daftar yang belum diverifikasi
                laporanData = laporanData.filter(item => item.id !== id);
                renderTable();
                
                // Tampilkan notifikasi
                showNotification(`Laporan ${id} ditolak dan masuk menu History`, 'error');
                
                // Tutup modal
                closeTolakModal();
            }
        } else {
            showNotification('Gagal menolak laporan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat menolak laporan', 'error');
    });
}

// Melihat detail laporan
function viewReport(id) {
    fetch(`/api/laporan/detail/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const report = data.data;
                
                // Format detail laporan untuk ditampilkan
                const detailText = `
                ID Laporan: ${report.id_laporan}
                Pelapor: ${report.is_anonim ? 'Anonim' : report.nama_pelapor}
                Telepon: ${report.telepon}
                Jenis Kasus: ${report.jeniskasus}
                Tanggal Kejadian: ${formatDate(report.tanggal_kejadian)}
                Tempat Kejadian: ${report.tempat_kejadian}
                Pelaku: ${report.pelaku}
                Korban: ${report.korban}
                Uraian Kejadian: ${report.uraian}
                `;
                
                alert(detailText);
            } else {
                showNotification('Gagal memuat detail laporan', 'error');
            }
        })
        .catch(error => {
            console.error('Error fetching report details:', error);
            showNotification('Terjadi kesalahan saat memuat detail laporan', 'error');
        });
}

// Process "Laporan Selesai" action dengan API
function processLaporanSelesai(id) {
    console.log('Memproses laporan dengan ID:', id);
    fetch('/api/laporan/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id_laporan: id,
            status: 'PROSES',
            catatan: 'Laporan terverifikasi'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Cari laporan berdasarkan ID
            const laporan = laporanData.find(item => item.id === id);
            
            if (laporan) {
                // Tambahkan laporan ke daftar proses
                laporanProses.push({
                    ...laporan,
                    statusVerifikasi: 'Valid',
                    waktuVerifikasi: new Date().toLocaleString(),
                    catatan: 'Laporan terverifikasi'
                });
                
                // Hapus dari daftar yang belum diverifikasi
                laporanData = laporanData.filter(item => item.id !== id);
                renderTable();
                
                // Tampilkan notifikasi
                showNotification(`Laporan ${id} berhasil diverifikasi dan masuk menu Proses`, 'success');
                window.location.href = '/dashboard_Admin/Data_laporan/proses';
            }
        } else {
            showNotification('Gagal memproses laporan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses laporan', 'error');
    });
}

// Initialize dengan mengambil data dari server
document.addEventListener('DOMContentLoaded', function() {
    fetchUnverifiedReports();
    //addNavigationButtons();
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
    }
    
    .search-filter-container {
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
        border-radius: 5px;
        outline: none;
        width: 220px;
    }
    
    .search-btn {
        background: transparent;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        margin-left: -40px;
    }
    
    /* Filter styles */
    .filter-btn {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #ddd;
        padding: 8px 15px;
        border-radius: 5px;
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
        border: 1px solid #ddd;
    }
    
    .table th {
        background-color: #f0f0f0;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border: 1px solid #ddd;
    }
    
    .table td {
        padding: 12px 15px;
        border: 1px solid #ddd;
    }
    
    .table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Navigation buttons */
   
    
    .nav-btn:hover {
        background-color: #e0e0e0;
    }
    
    /* Button styles */
    .btn-verifikasi {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .btn-verifikasi:hover {
        background-color: #e0e0e0;
    }
    
    .btn-view {
        background-color: #2196F3;
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 5px;
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
    
    /* Confirmation modal styles */
    .confirmation-modal {
        max-width: 400px;
        padding: 20px;
    }
    
    .confirmation-modal h3 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .confirm-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-confirm-selesai {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
    }
    
    .btn-confirm-tolak {
        background-color: #F44336;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
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
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
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
    
    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        border: none;
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
        .search-filter-container {
            flex-direction: column;
            gap: 10px;
        }
        
        .search-input {
            width: 100%;
        }
        
        .filter-container {
            align-self: flex-end;
        }
        
        .nav-buttons {
            margin-top: 10px;
            margin-left: 0;
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
@endpush
@endsection