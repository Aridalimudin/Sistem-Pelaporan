@extends('layouts.main_ds')

@section('content')

<main id="content" class="content">
    <header class="dashboard-header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <div class="header-content">
            <h1 class="header-title">Dashboard Pelaporan Sekolah</h1>
            <p class="header-subtitle">Sistem Monitoring dan Pelaporan Kasus Sekolah</p>
        </div>
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
                            <small>{{ Auth::user()->roles->first()->name ?? 'No Role' }}</small>
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

    <div class="dashboard-container">
        
        <div class="metrics-section">
            <div class="metrics-grid">
                <div class="metric-card total-reports">
                    <div class="metric-icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div class="metric-content">
                        <h3>Total Laporan</h3>
                        <div class="metric-number">202</div>
                        <div class="metric-change positive">
                            <i class="fa-solid fa-arrow-up"></i>
                            <span>+12 dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <div class="metric-card active-cases">
                    <div class="metric-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="metric-content">
                        <h3>Kasus Aktif</h3>
                        <div class="metric-number">46</div>
                        <div class="metric-change neutral">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            <span>Sedang ditangani</span>
                        </div>
                    </div>
                </div>

                <div class="metric-card resolved-cases">
                    <div class="metric-icon">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <div class="metric-content">
                        <h3>Kasus Selesai</h3>
                        <div class="metric-number">156</div>
                        <div class="metric-change positive">
                            <i class="fa-solid fa-percentage"></i>
                            <span>77% tingkat penyelesaian</span>
                        </div>
                    </div>
                </div>

                <div class="metric-card students-protected">
                    <div class="metric-icon">
                        <i class="fa-solid fa-shield-alt"></i>
                    </div>
                    <div class="metric-content">
                        <h3>Siswa Terlindungi</h3>
                        <div class="metric-number">1,247</div>
                        <div class="metric-change neutral">
                            <i class="fa-solid fa-users"></i>
                            <span>Total siswa dalam sistem</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="statistics-section">
            <div class="stats-header">
                <h3 class="section-title">Statistik Status Laporan</h3>
            </div>

            <div class="stats-grid">
                <div class="stat-card not-accepted">
                    <div class="stat-indicator"></div>
                    <div class="stat-info">
                        <div class="stat-icon">
                            <i class="fa-solid fa-file-excel"></i>
                        </div>
                        <div class="stat-details">
                            <h4>Belum di Accept</h4>
                            <span class="stat-number">15</span>
                            <span class="stat-trend warning">Menunggu persetujuan</span>
                        </div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar not-accepted-progress" style="width: 9.6%"></div>
                    </div>
                </div>
                
                <div class="stat-card pending">
                    <div class="stat-indicator"></div>
                    <div class="stat-info">
                        <div class="stat-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div> 
                        <div class="stat-details">
                            <h4>Belum Melengkapi Data</h4>
                            <span class="stat-number">23</span>
                            <span class="stat-trend warning">Perlu verifikasi</span>
                        </div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar pending-progress" style="width: 14.7%"></div>
                    </div>
                </div>
                
                <div class="stat-card unprocessed">
                    <div class="stat-indicator"></div>
                    <div class="stat-info">
                        <div class="stat-icon">
                            <i class="fa-solid fa-pause-circle"></i>
                        </div>
                        <div class="stat-details">
                            <h4>Belum Diproses</h4>
                            <span class="stat-number">8</span>
                            <span class="stat-trend warning">Segera tangani</span>
                        </div>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar unprocessed-progress" style="width: 5.1%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan per Kelas di bawah card statistik status laporan --}}
        <div class="class-reports-section"> 
            <div class="chart-card">
                <div class="card-header">
                    <h3>Laporan per Kelas</h3>
                    <div class="card-actions">
                        <button class="btn-refresh" onclick="refreshChart('classChart')">
                            <i class="fa-solid fa-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="classChart"></canvas>
                </div>
            </div>
        </div>

        <div class="analytics-row">
            <div class="analytics-left">
                <div class="chart-card">
                    <div class="card-header">
                        <h3>Distribusi Tingkat Keparahan</h3>
                        <div class="card-actions">
                            <button class="btn-refresh" onclick="refreshChart('severityChart')">
                                <i class="fa-solid fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="severityChart"></canvas>
                    </div>
                </div>

                {{-- The "Status Pemrosesan Laporan" chart was here and has been removed --}}
            </div>

            <div class="analytics-right">
                <div class="chart-card">
                    <div class="card-header">
                        <h3>Kategori Kasus</h3>
                    </div>
                    <div class="category-list">
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-color bullying-verbal"></div>
                                <span class="category-name">Bullying Verbal</span>
                            </div>
                            <div class="category-stats">
                                <span class="category-count">91</span>
                                <span class="category-percentage">45%</span>
                            </div>
                        </div>
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-color bullying-physical"></div>
                                <span class="category-name">Bullying Fisik</span>
                            </div>
                            <div class="category-stats">
                                <span class="category-count">65</span>
                                <span class="category-percentage">32%</span>
                            </div>
                        </div>
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-color harassment-verbal"></div>
                                <span class="category-name">Pelecehan Verbal</span>
                            </div>
                            <div class="category-stats">
                                <span class="category-count">30</span>
                                <span class="category-percentage">15%</span>
                            </div>
                        </div>
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-color harassment-physical"></div>
                                <span class="category-name">Pelecehan Fisik</span>
                            </div>
                            <div class="category-stats">
                                <span class="category-count">16</span>
                                <span class="category-percentage">8%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-reports-section">
            <div class="section-header">
                <h3 class="section-title">Laporan Terbaru Membutuhkan Perhatian</h3>
                <a href="{{ route('laporan-masuk.index') }}" class="view-all-btn">Lihat Semua</a>
            </div>
            <div class="reports-container">
                <div class="report-item urgent">
                    <div class="report-status">
                        <span class="status-badge high">Berat</span>
                        <span class="time-ago">2 jam yang lalu</span>
                    </div>
                    <div class="report-content">
                        <h4>Kasus Pelecehan Seksual - Kelas XI IPA 2</h4>
                        <p>Laporan dari siswa perempuan tentang tindakan tidak pantas oleh teman sekelas</p>
                        <div class="report-meta">
                            <span class="reporter">Anonim</span>
                            <span class="category">Pelecehan Seksual</span>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="action-btn primary">Accept</button>
                        <button class="action-btn secondary">Detail</button>
                    </div>
                </div>
                
                <div class="report-item moderate">
                    <div class="report-status">
                        <span class="status-badge medium">Sedang</span>
                        <span class="time-ago">5 jam yang lalu</span>
                    </div>
                    <div class="report-content">
                        <h4>Bullying Verbal - Kelas X IPS 1</h4>
                        <p>Siswa dilaporkan sering mengalami intimidasi dan ejekan dari sekelompok teman</p>
                        <div class="report-meta">
                            <span class="reporter">Ahmad Fauzi</span>
                            <span class="category">Bullying</span>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="action-btn primary">Accept</button>
                        <button class="action-btn secondary">Detail</button>
                    </div>
                </div>
                
                <div class="report-item low">
                    <div class="report-status">
                        <span class="status-badge low">Ringan</span>
                        <span class="time-ago">1 hari yang lalu</span>
                    </div>
                    <div class="report-content">
                        <h4>Konflik Antar Siswa - Kelas IX A</h4>
                        <p>Pertengkaran kecil yang perlu mediasi untuk mencegah eskalasi</p>
                        <div class="report-meta">
                            <span class="reporter">Siti Nurhaliza</span>
                            <span class="category">Konflik</span>
                        </div>
                    </div>
                    <div class="report-actions">
                        <button class="action-btn primary">Accept</button>
                        <button class="action-btn secondary">Detail</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-actions-section">
            <div class="section-header">
                <h3 class="section-title">Aksi Cepat</h3>
            </div>
            <div class="quick-actions-grid">

                <a href="{{ route('dashboard.siswa') }}" class="quick-action-card">
                    <div class="action-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="action-content">
                        <h4>Kelola Siswa</h4>
                        <p>Tambah atau edit data siswa</p>
                    </div>
                </a>
                <a href="#" class="quick-action-card">
                    <div class="action-icon">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div class="action-content">
                        <h4>Export Data</h4>
                        <p>Unduh laporan dalam format Excel</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
</div>

<script>
// Sidebar Toggle
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("content").classList.toggle("active");
}

// Profile Dropdown
function toggleProfile() {
    const profileMenu = document.getElementById('profileMenu');
    profileMenu.classList.toggle('show');
}

// Close profile dropdown when clicking outside
document.addEventListener('click', function(event) {
    const profileDropdown = document.querySelector('.profile-dropdown');
    const profileMenu = document.getElementById('profileMenu');
    
    if (!profileDropdown.contains(event.target)) {
        profileMenu.classList.remove('show');
    }
});

// Chart Refresh
function refreshChart(chartId) {
    const button = event.target.closest('.btn-refresh');
    button.classList.add('loading');
    
    // Simulate data loading
    setTimeout(() => {
        button.classList.remove('loading');
        // Dalam aplikasi nyata, Anda akan mengambil data baru dan memperbarui grafik
        // Contoh: if (window.myChartInstance) { window.myChartInstance.update(); }
    }, 1000);
}

// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Grafik Distribusi Tingkat Keparahan (Pie Chart)
    const severityCanvas = document.getElementById('severityChart');
    if (severityCanvas) { // Pastikan elemen canvas ditemukan
        const severityCtx = severityCanvas.getContext('2d');
        // Simpan instance chart agar bisa diakses jika perlu (misal: refresh)
        window.severityChartInstance = new Chart(severityCtx, {
            type: 'doughnut',
            data: {
                labels: ['Ringan', 'Sedang', 'Berat'],
                datasets: [{
                    data: [32, 78, 46],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                    borderWidth: 0,
                    cutout: '60%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    datalabels: { // Konfigurasi datalabels untuk pie/doughnut chart
                        color: '#fff', // Warna teks label putih agar kontras
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value, context) => {
                            // Hitung total data untuk persentase
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${percentage}% (${value})`;
                        },
                        display: 'auto', // Tampilkan label secara otomatis agar tidak tumpang tindih
                        textShadowBlur: 4,
                        textShadowColor: 'rgba(0,0,0,0.6)' // Tambahkan shadow agar lebih mudah dibaca
                    }
                },
            },
            plugins: [ChartDataLabels] // <<< REGISTRASI PLUGIN DI SINI UNTUK CHART INI
        });
    } else {
        console.warn("Element with ID 'severityChart' not found. Chart will not be rendered.");
    }

    // Grafik Laporan per Kelas (Vertical Bar Chart)
    const classCanvas = document.getElementById('classChart');
    if (classCanvas) { // Pastikan elemen canvas ditemukan
        const classCtx = classCanvas.getContext('2d');
        const classData = [8, 6, 5, 4]; // Data jumlah laporan per kelas
        const classLabels = ['XI IPA 2', 'X IPS 1', 'XII IPA 1', 'IX A'];

        window.myClassChart = new Chart(classCtx, {
            type: 'bar', // DIUBAH KE TIPE 'bar' (grafik batang vertikal)
            data: {
                labels: classLabels,
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: classData,
                    backgroundColor: [ // Gunakan warna yang bervariasi untuk setiap batang
                        'rgba(255, 99, 132, 0.8)', // Merah
                        'rgba(54, 162, 235, 0.8)', // Biru
                        'rgba(255, 206, 86, 0.8)', // Kuning
                        'rgba(75, 192, 192, 0.8)'  // Hijau Kebiruan
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8, // Sudut batang yang membulat
                    barThickness: 40, // Lebar batang tetap agar tidak terlalu kurus/gemuk
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y', // MENJADIKAN INI KEMBALI HORIZONTAL UNTUK LEBIH BISA MEMBANDINGKAN (sesuai gambar awal)
                scales: {
                    x: { // Sumbu X untuk nilai (jumlah laporan)
                        beginAtZero: true,
                        grid: {
                            display: false // Sembunyikan garis grid X
                        },
                        ticks: {
                            precision: 0, // Pastikan label sumbu X adalah bilangan bulat
                            font: {
                                size: 12
                            }
                        },
                        title: { // Tambahkan judul sumbu X
                            display: true,
                            text: 'Jumlah Laporan',
                            color: '#495057',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    },
                    y: { // Sumbu Y untuk kategori (kelas)
                        grid: {
                            display: false // Sembunyikan garis grid Y
                        },
                        ticks: {
                            font: {
                                size: 13, // Ukuran font untuk label sumbu Y
                                weight: '600'
                            },
                            color: '#495057'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend
                    },
                    datalabels: { // Konfigurasi plugin datalabels
                        anchor: 'end', // Posisikan label di ujung setiap batang
                        align: 'end', // Ratakan label ke ujung batang
                        offset: 4, // Jarak label dari batang
                        formatter: (value, context) => value, // Tampilkan nilai numerik
                        color: '#495057', // Warna teks label
                        font: {
                            weight: 'bold',
                            size: 13
                        }
                    },
                    tooltip: { // Perbaikan pada tooltip
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                if (label) {
                                    return `${label}: ${context.parsed.x} Laporan`;
                                }
                                return `${context.parsed.x} Laporan`;
                            }
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // <<< REGISTRASI PLUGIN DI SINI UNTUK CHART INI
        });
    } else {
        console.warn("Element with ID 'classChart' not found. Chart will not be rendered.");
    }

    // Animasi untuk kartu metrik
    const metricCards = document.querySelectorAll('.metric-card');
    metricCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<style>
#content {
    flex-grow: 1;
    overflow-x: hidden;
    transition: margin-left 0.3s ease, width 0.3s ease; 
}

/* Gaya Utama Dashboard */
.dashboard-container {
    padding: 20px;
    background: #f8f9fa;
    min-height: calc(100vh - 80px);
}

.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 30px;
    background: white;
    border-bottom: 1px solid #e9ecef;
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-content {
    flex: 1;
    margin-left: 20px;
}

.header-title {
    font-size: 24px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.header-subtitle {
    font-size: 14px;
    color: #6c757d;
    margin: 4px 0 0 0;
}

/* Bagian Metrik */
.metrics-section {
    margin-bottom: 30px;
}

.metrics-grid {
    display: grid;
    /* Memaksa 4 kolom yang sama rata untuk tampilan desktop besar */
    grid-template-columns: repeat(4, 1fr); 
    gap: 20px;
}

.metric-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.metric-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.metric-card.total-reports::before {
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.metric-card.active-cases::before {
    background: linear-gradient(90deg, #f093fb, #f5576c);
}

.metric-card.resolved-cases::before {
    background: linear-gradient(90deg, #4facfe, #00f2fe);
}

.metric-card.students-protected::before {
    background: linear-gradient(90deg, #43e97b, #38f9d7);
}

.metric-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.metric-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    flex-shrink: 0;
}

.total-reports .metric-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.active-cases .metric-icon {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

.resolved-cases .metric-icon {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
}

.students-protected .metric-icon {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
}

.metric-content h3 {
    font-size: 14px;
    color: #6c757d;
    margin: 0 0 8px 0;
    font-weight: 600;
}

.metric-number {
    font-size: 32px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 8px 0;
}

.metric-change {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 500;
}

.metric-change.positive {
    color: #28a745;
}

.metric-change.neutral {
    color: #6c757d;
}

.metric-change.negative {
    color: #dc3545;
}

/* Baris Analitik */
.analytics-row {
    display: grid;
    /* PERBAIKAN DI SINI: Membuat kedua kolom sama besar */
    grid-template-columns: repeat(2, 1fr); 
    gap: 30px;
    margin-bottom: 30px;
}

.analytics-left {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.analytics-right {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.chart-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e9ecef;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.btn-refresh {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 8px 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6c757d;
}

.btn-refresh:hover {
    background: #e9ecef;
    color: #495057;
}

.btn-refresh.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.chart-container {
    position: relative;
    height: 350px; /* Tinggi default untuk chart */
    width: 100%; /* Pastikan mengambil lebar penuh */
}

/* KATEGORI KASUS: Pastikan tinggi card ini menyesuaikan dengan chart di sampingnya */
.category-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    /* Mungkin perlu penyesuaian tinggi di sini jika tidak otomatis pas */
    /* Misalnya: height: 100%; min-height: 250px; */
}


.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid #f1f3f4;
}

.category-item:last-child {
    border-bottom: none;
}

.category-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.category-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.category-color.bullying-verbal {
    background: #007bff;
}

.category-color.bullying-physical {
    background: #28a745;
}

.category-color.harassment-verbal {
    background: #ffc107;
}

.category-color.harassment-physical {
    background: #dc3545;
}

.category-name {
    font-weight: 500;
    color: #495057;
}

.category-stats {
    display: flex;
    align-items: center;
    gap: 12px;
}

.category-count {
    font-weight: 600;
    color: #2c3e50;
}

.category-percentage {
    font-size: 12px;
    color: #6c757d;
    background: #f8f9fa;
    padding: 2px 8px;
    border-radius: 12px;
}

/* Tabel Laporan Terbaru */
.recent-reports-section {
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h3 {
    font-size: 20px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.view-all-btn {
    color: #007bff;
    text-decoration: none;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.view-all-btn:hover {
    background: #007bff;
    color: white;
}

.reports-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.report-item {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    border: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
}

.report-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.report-status {
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 120px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
}

.status-badge.high {
    background: #fee;
    color: #dc3545;
}

.status-badge.medium {
    background: #fff3cd;
    color: #856404;
}

.status-badge.low {
    background: #d4edda;
    color: #155724;
}

.time-ago {
    font-size: 12px;
    color: #6c757d;
    text-align: center;
}

.report-content {
    flex: 1;
}

.report-content h4 {
    margin: 0 0 8px 0;
    font-size: 16px;
    color: #495057;
}

.report-content p {
    margin: 0 0 12px 0;
    color: #6c757d;
    font-size: 14px;
    line-height: 1.5;
}

.report-meta {
    display: flex;
    gap: 20px;
    font-size: 12px;
    color: #6c757d;
}

.report-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn.primary {
    background: #007bff;
    color: white;
}

.action-btn.primary:hover {
    background: #0056b3;
}

.action-btn.secondary {
    background: #f8f9fa;
    color: #6c757d;
    border: 1px solid #dee2e6;
}

.action-btn.secondary:hover {
    background: #e9ecef;
}

/* Aksi Cepat */
.quick-actions-section {
    margin-bottom: 30px;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

.quick-action-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.action-content h4 {
    margin: 0 0 8px 0;
    font-size: 16px;
    color: #495057;
    font-weight: 600;
}

.action-content p {
    margin: 0;
    font-size: 14px;
    color: #6c757d;
    line-height: 1.4;
}

/* Animasi */
@keyframes fillProgress {
    from {
        width: 0%;
    }
    to {
        width: var(--progress-width, 100%);
    }
}

/* Desain Responsif */
@media (max-width: 1200px) { /* Untuk layar yang lebih kecil dari 1200px */
    .metrics-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Kembali ke layout fleksibel */
    }
    /* PERBAIKAN RESPONSIVE UNTUK analytics-row */
    .analytics-row {
        grid-template-columns: 1fr; /* Tumpuk kembali ke satu kolom di layar yang lebih kecil */
    }
}

@media (max-width: 768px) {
    .metrics-grid {
        grid-template-columns: 1fr; /* Tumpuk kartu di layar yang lebih kecil */
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    /* analytics-row sudah ditumpuk di breakpoint 1200px */
    
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    
    .report-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .report-status {
        flex-direction: row;
        min-width: auto;
        width: 100%;
        justify-content: space-between;
    }
    
    .report-actions {
        width: 100%;
        justify-content: flex-end;
    }

    .chart-container {
        height: 300px; /* Tinggi sedikit lebih kecil di layar kecil */
    }
}

@media (max-width: 480px) {
    .metric-card {
        padding: 16px;
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
    }
    .metric-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
        margin-bottom: 10px;
    }
    .metric-number {
        font-size: 28px;
    }
    
    .chart-card {
        padding: 16px;
    }
    
    .report-item {
        padding: 16px;
    }
    
    .quick-action-card {
        padding: 16px;
    }

    .chart-container {
        height: 250px; /* Tinggi lebih kecil lagi di ponsel */
    }
}       

/* Peningkatan Bagian Statistik */
.statistics-section {
    margin-bottom: 30px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
}

.stat-indicator {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.stat-card.not-accepted .stat-indicator {
    background: linear-gradient(90deg, #dc3545, #e83e8c);
}

.stat-card.pending .stat-indicator {
    background: linear-gradient(90deg, #ffc107, #fd7e14);
}

.stat-card.unprocessed .stat-indicator {
    background: linear-gradient(90deg, #6f42c1, #e83e8c);
}

.stat-info {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.stat-card.not-accepted .stat-icon {
    background: linear-gradient(135deg, #dc3545, #e83e8c);
}

.stat-card.pending .stat-icon {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.stat-card.unprocessed .stat-icon {
    background: linear-gradient(135deg, #6f42c1, #e83e8c);
}

.stat-details h4 {
    margin: 0 0 8px 0;
    font-size: 16px;
    color: #495057;
    font-weight: 600;
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #495057;
    display: block;
    margin-bottom: 4px;
}

.stat-trend {
    font-size: 12px;
    font-weight: 500;
}

.stat-trend.warning {
    color: #856404;
}

.stat-progress {
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 1.5s ease;
}

.not-accepted-progress {
    background: linear-gradient(90deg, #dc3545, #e83e8c);
}

.pending-progress {
    background: linear-gradient(90deg, #ffc107, #fd7e14);
}

.unprocessed-progress {
    background: linear-gradient(90deg, #6f42c1, #e83e8c);
}

/* Gaya Tambahan */
.severity-header, .stats-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.stats-summary {
    color: #6c757d;
    font-size: 14px;
}

.stats-summary strong {
    color: #495057;
}

/* CSS baru untuk penempatan laporan per kelas */
.class-reports-section {
    margin-top: 30px; /* Jarak dari section sebelumnya */
    margin-bottom: 30px;
}
</style>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection