@extends('layouts.main_ds')
@section('content')

        <main id="content" class="content">
            <header>
                <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
                <h1 class="header-title">Selamat Datang di Dashboard</h1>
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
                            <a href="#" class="profile-item">
                                <i class="fa-solid fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="#" class="profile-item">
                                <i class="fa-solid fa-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                            <a href="#" class="profile-item">
                                <i class="fa-solid fa-question-circle"></i>
                                <span>Bantuan</span>
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
            
            <div class="alert">
                <div class="alert-icon">⚠️</div>
                <div class="alert-content">
                    Ada <b>15 laporan</b> yang belum diverifikasi dan <b>8 laporan</b> yang belum diproses!
                </div>
            </div>
            
            <!-- Statistik Laporan - Layout 3 per baris -->
            <div class="statistics-section">
                <div class="stats-header">
                    <h3 class="section-title">Statistik Laporan</h3>
                    <div class="stats-summary">
                        <span class="total-reports">Total: <strong>156</strong> Laporan</span>
                        <span class="completion-rate">Tingkat Penyelesaian: <strong>70.5%</strong></span>
                    </div>
                </div>
                
                <div class="stats-grid">
                    <!-- Baris 1: 3 Card pertama -->
                    <div class="stat-card new">
                        <div class="stat-indicator"></div>
                        <div class="stat-info">
                            <div class="stat-icon">
                                <i class="fa-solid fa-file-text"></i>
                            </div>
                            <div class="stat-details">
                                <h4>Laporan Baru</h4>
                                <span class="stat-number">23</span>
                                <span class="stat-trend positive">Hari ini</span>
                            </div>
                        </div>
                        <div class="stat-progress">
                            <div class="progress-bar new-progress" style="width: 14.7%"></div>
                        </div>
                    </div>
                    
                    <div class="stat-card pending">
                        <div class="stat-indicator"></div>
                        <div class="stat-info">
                            <div class="stat-icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>  
                            <div class="stat-details">
                                <h4>Belum Diverifikasi</h4>
                                <span class="stat-number">15</span>
                                <span class="stat-trend warning">Perlu perhatian</span>
                            </div>
                        </div>
                        <div class="stat-progress">
                            <div class="progress-bar pending-progress" style="width: 9.6%"></div>
                        </div>
                    </div>
                    
                    <div class="stat-card processing">
                        <div class="stat-indicator"></div>
                        <div class="stat-info">
                            <div class="stat-icon">
                                <i class="fa-solid fa-cogs"></i>
                            </div>
                            <div class="stat-details">
                                <h4>Sedang Diproses</h4>
                                <span class="stat-number">23</span>
                                <span class="stat-trend">Dalam penanganan</span>
                            </div>
                        </div>
                        <div class="stat-progress">
                            <div class="progress-bar processing-progress" style="width: 14.7%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="stats-grid stats-grid-2">
                    <!-- Baris 2: 2 Card terakhir -->
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
                    
                    <div class="stat-card completed">
                        <div class="stat-indicator"></div>
                        <div class="stat-info">
                            <div class="stat-icon">
                                <i class="fa-solid fa-check-circle"></i>
                            </div>
                            <div class="stat-details">
                                <h4>Total Laporan Selesai</h4>
                                <span class="stat-number">110</span>
                                <span class="stat-trend positive">Berhasil diselesaikan</span>
                            </div>
                        </div>
                        <div class="stat-progress">
                            <div class="progress-bar completed-progress" style="width: 70.5%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Laporan Berdasarkan Tingkat Keparahan - Compact Version -->
            <div class="severity-section">
                <div class="severity-header">
                    <h3 class="section-title">Kategori Berdasarkan Tingkat Keparahan</h3>
                </div>
                <div class="severity-cards">
                    <div class="severity-card low">
                        <div class="severity-icon">
                            <i class="fa-solid fa-thumbs-up"></i>
                        </div>
                        <div class="severity-info">
                            <h4>Tingkat Ringan</h4>
                            <p class="severity-count">32</p>
                            <small>Kasus tidak memerlukan tindakan darurat</small>
                        </div>
                    </div>
                    <div class="severity-card medium">
                        <div class="severity-icon">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                        </div>
                        <div class="severity-info">
                            <h4>Tingkat Sedang</h4>
                            <p class="severity-count">78</p>
                            <small>Kasus memerlukan perhatian khusus</small>
                        </div>
                    </div>
                    <div class="severity-card high">
                        <div class="severity-icon">
                            <i class="fa-solid fa-exclamation-circle"></i>
                        </div>
                        <div class="severity-info">
                            <h4>Tingkat Berat</h4>
                            <p class="severity-count">46</p>
                            <small>Kasus memerlukan tindakan segera</small>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
            document.getElementById("content").classList.toggle("active");
        }
        
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
        
        // Add animation for stat cards
        document.addEventListener("DOMContentLoaded", function() {
            const statCards = document.querySelectorAll('.stat-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                            
                            // Animate progress bars
                            const progressBar = entry.target.querySelector('.progress-bar');
                            if (progressBar) {
                                progressBar.style.animation = 'fillProgress 1.5s ease-out forwards';
                            }
                        }, index * 100);
                    }
                });
            });
            
            statCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });
    </script>
@push('styles')
<link rel="stylesheet" href="{{asset('css/ds_admin.css')}}">
@endpush
@endsection