<!-- HTML - Update HTML sidebar Anda dengan struktur ini -->
<div class="col-auto p-0">
  <nav id="sidebar" class="sidebar">
      <div class="sidebar-header">
          <div class="logo-container">
            <img src="{{asset('images/logoMts.png')}}" alt="Logo" class="sidebar-logo">
            <h2>Dashboard</h2>
          </div>
      </div>
      
      <ul>
          <li data-tooltip="Dashboard">
              <a href="{{ route('dashboard') }}" class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                  <i class="fa-solid fa-chart-line"></i> 
                  <span>Dashboard</span>
              </a>
          </li>
          
          @can('user-list')
          <li class="has-submenu {{ Request::is('admin/management-user*') ? 'submenu-active' : '' }}" data-tooltip="User Management">
              <a href="#" class="submenu-toggle">
                  <i class="fa-solid fa-users"></i> 
                  <span>User Management</span> 
                  <i class="fa-solid fa-chevron-down submenu-indicator"></i>
              </a>
              <ul class="submenu">
                  <li data-tooltip="Data User">
                      <a href="{{ route('user.index') }}" class="{{ Request::is('admin/management-user/user') ? 'active' : '' }}">
                          <i class="fa-solid fa-user"></i> 
                          <span>Data User</span>
                      </a>
                  </li>
                  <li data-tooltip="Data Role">
                      <a href="{{ route('role.index') }}" class="{{ Request::is('admin/management-user/role') ? 'active' : '' }}">
                          <i class="fa-solid fa-tasks"></i> 
                          <span>Data Role</span>
                      </a>
                  </li>
                  <li data-tooltip="Data Permission">
                      <a href="{{ route('data.permission') }}">
                          <i class="fa-solid fa-lock"></i> 
                          <span>Data Permission</span>
                      </a>
                  </li>
              </ul>
          </li>
          @endcan

          <li data-tooltip="Master Data">
              <a href="#" class="">
                  <i class="fa-solid fa-database"></i> 
                  <span>Master Data</span>
              </a>
          </li>

          <li data-tooltip="Kategori Kasus">
              <a href="{{ route('kategori.kategori') }}" class="">
                  <i class="fa-solid fa-tags"></i> 
                  <span>Kategori Kasus</span>
              </a>
          </li>

          <li data-tooltip="Tindakan">
              <a href="#" class="">
                  <i class="fa-solid fa-hands-helping"></i> 
                  <span>Tindakan</span>
              </a>
          </li>
          
          <!-- Uncomment jika diperlukan -->
          {{-- 
          <li data-tooltip="History Laporan">
              <a href="{{ route('dashboard_Admin/History_laporan/history')}}">
                  <i class="fa-solid fa-history"></i> 
                  <span>History Laporan</span>
              </a>
          </li>
          <li data-tooltip="Lihat Feedback">
              <a href="{{ route('dashboard_Admin/Lihat_feedback/lihatfeedback')}}">
                  <i class="fa-solid fa-comments"></i> 
                  <span>Lihat Feedback</span>
              </a>
          </li>
          <li data-tooltip="Kelola Guru BK">
              <a href="{{ route('dashboard_Admin/KelolaBK/kelolabk') }}">
                  <i class="fa-solid fa-user-tie"></i> 
                  <span>Kelola Guru BK</span>
              </a>
          </li> 
          --}}
      </ul>
      
     <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-sign-out-alt"></i> 
                <span>Keluar</span>
            </button>
        </form>
    </div>
  </nav>
</div>

<script>
// JavaScript - Ganti script sidebar lama Anda dengan ini

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.toggle('mobile-open');
    } else {
        sidebar.classList.toggle('active');
    }
}

// Submenu toggle dengan animasi smooth
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.submenu-toggle').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            
            // Tutup submenu lain
            document.querySelectorAll('.has-submenu').forEach(menu => {
                if (menu !== parent) {
                    menu.classList.remove('submenu-active');
                }
            });
            
            // Toggle submenu yang diklik
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

// Fungsi untuk set active menu berdasarkan current route (optional)
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
</script>