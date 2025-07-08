<div class="col-auto p-0">
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
            <img src="{{asset('images/logoMts.png')}}" alt="Logo" class="sidebar-logo">
            <h2>MTS AR-RIYADL</h2>
            </div>
        </div>

    <ul>
        <li data-tooltip="Dashboard">
            <a href="{{ route('dashboard') }}" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> 
                <span>Dashboard</span>
            </a>
        </li>
        
        @can('user-list')
        <li class="has-submenu {{ Request::is('admin/management-user*') ? 'submenu-active' : '' }}" data-tooltip="User Management">
            <a href="#" class="submenu-toggle">
                <i class="fas fa-users-cog"></i> 
                <span>Manajemen User</span> 
                <i class="fas fa-chevron-down submenu-indicator"></i>
            </a>
            <ul class="submenu">
                <li data-tooltip="Data User">
                    <a href="{{ route('user.index') }}" class="{{ Request::is('admin/management-user/user') ? 'active' : '' }}">
                        <i class="fas fa-user"></i> 
                        <span>Data User</span>
                    </a>
                </li>
                <li data-tooltip="Data Role">
                    <a href="{{ route('role.index') }}" class="{{ Request::is('admin/management-user/role') ? 'active' : '' }}">
                        <i class="fas fa-user-tag"></i> 
                        <span>Data Role</span>
                    </a>
                </li>
                <li data-tooltip="Data Permission">
                    <a href="{{ route('data.permission') }}" class="{{ Request::is('admin/management-user/permission') ? 'active' : '' }}">
                        <i class="fas fa-shield-alt"></i> 
                        <span>Data Permission</span>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        @can('user-list')
            <li class="has-submenu {{ Request::is('admin/master-data*') ? 'submenu-active' : '' }}" data-tooltip="Master Data">
                <a href="#" class="submenu-toggle">
                    <i class="fas fa-database"></i> 
                    <span>Master Data</span> 
                    <i class="fas fa-chevron-down submenu-indicator"></i>
                </a>
                <ul class="submenu">
                    <li data-tooltip="Data Siswa">
                        <a href="{{ route('dashboard.siswa') }}" class="{{ Request::is('admin/master-data/siswa') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate"></i> 
                            <span>Data Siswa</span>
                        </a>
                    </li>
                    <li data-tooltip="Data Kelas">
                        <a href="{{ route('dashboard.kelas') }}" class="{{ Request::is('admin/master-data/kelas') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard"></i> 
                            <span>Data Kelas</span>
                        </a>
                    </li>
                    <li data-tooltip="Tindakan">
                        <a href="{{ route('dashboard.tindakan') }}" class="{{ Request::is('admin/master-data/tindakan') ? 'active' : '' }}">
                            <i class="fas fa-gavel"></i> 
                            <span>Tindakan</span>
                        </a>
                    </li>
                    <li data-tooltip="Kategori Kasus">
                        <a href="{{ route('dashboard.kasus') }}" class="{{ Request::is('admin/master-data/kasus') ? 'active' : '' }}">
                            <i class="fas fa-folder-open"></i> 
                            <span>Kategori Kasus</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

    @can('user-list')
        <li class="has-submenu {{ Request::is('admin/laporan*') ? 'submenu-active' : '' }}" data-tooltip="Manajemen Laporan">
            <a href="#" class="submenu-toggle">
                <i class="fas fa-clipboard-list"></i> 
                <span>Manajemen Laporan</span> 
                <i class="fas fa-chevron-down submenu-indicator"></i>
            </a>
            <ul class="submenu">
                <li data-tooltip="Laporan Masuk">
                    <a href="{{ route('laporan-masuk.index') }}" class="{{ Request::is('admin/laporan/laporan-masuk') ? 'active' : '' }}">
                        <i class="fas fa-inbox"></i> 
                        <span>Laporan Masuk</span>
                    </a>
                </li>
                <li data-tooltip="Verifikasi Laporan">
                    <a href="{{ route('verifikasi.index') }}" class="{{ Request::is('admin/laporan/verifikasi') ? 'active' : '' }}">
                        <i class="fas fa-check-square"></i> 
                        <span>Verifikasi Laporan</span>
                    </a>
                </li>
                <li data-tooltip="Proses Laporan">
                    <a href="{{ route('proses.index') }}" class="{{ Request::is('admin/laporan/proses') ? 'active' : '' }}">
                        <i class="fas fa-hourglass-half"></i> 
                        <span>Proses Laporan</span>
                    </a>
                </li>
                <li data-tooltip="Laporan Selesai & Feedback">
                    <a href="{{ route('selesai.index') }}" class="{{ Request::is('admin/laporan/selesai') ? 'active' : '' }}">
                        <i class="fas fa-check-double"></i> 
                        <span>Laporan Selesai</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan

<li data-tooltip="History laporan">
    <a href="{{ route('history.index') }}" class="{{ Request::is('admin/history*') ? 'active' : '' }}">
        <i class="fas fa-history"></i> 
        <span>History laporan</span>
    </a>
</li>
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> 
                <span>Keluar</span>
            </button>
        </form>
    </div>
    </nav>
</div>

<script>

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.toggle('mobile-open');
    } else {
        sidebar.classList.toggle('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.submenu-toggle').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;

            document.querySelectorAll('.has-submenu').forEach(menu => {
                if (menu !== parent) {
                    menu.classList.remove('submenu-active');
                }
            });
            
            parent.classList.toggle('submenu-active');
        });
    });

    // Active state management
    document.querySelectorAll('.sidebar ul li a:not(.submenu-toggle)').forEach(link => {
        link.addEventListener('click', function() {
            // Hapus active dari semua link
            document.querySelectorAll('.sidebar ul li a').forEach(l => l.classList.remove('active'));
            // Tambah active ke link yang diklik
            this.classList.add('active');
        });
    });

    // Tutup sidebar saat klik di luar (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle');
            
            if (sidebar && toggleBtn && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
        }
    });

    // Auto-close submenu when sidebar collapsed
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (sidebar.classList.contains('active')) {
                        // Tutup semua submenu saat sidebar collapsed
                        document.querySelectorAll('.has-submenu').forEach(menu => {
                            menu.classList.remove('submenu-active');
                        });
                    }
                }
            });
        });
        
        observer.observe(sidebar, {
            attributes: true,
            attributeFilter: ['class']
        });
    }
});

// Fungsi untuk set active menu berdasarkan current route
function setActiveMenu() {
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.sidebar ul li a:not(.submenu-toggle)');
    
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href)) {
            link.classList.add('active');
            
            // Jika ini submenu, buka parent menu
            const parentSubmenu = link.closest('.submenu');
            if (parentSubmenu) {
                parentSubmenu.closest('.has-submenu').classList.add('submenu-active');
            }
        }
    });
}

// Panggil fungsi set active menu saat halaman dimuat
document.addEventListener('DOMContentLoaded', setActiveMenu);

// Smooth scrolling untuk navigasi (optional)
document.querySelectorAll('.sidebar a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>