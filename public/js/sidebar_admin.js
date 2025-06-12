document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar function
    const toggleSidebar = document.querySelector('.toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    }
    
    // Handle submenu toggles
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const parent = this.closest('.has-submenu');
            
            // Close other open submenus
            document.querySelectorAll('.has-submenu').forEach(item => {
                if (item !== parent && item.classList.contains('submenu-active')) {
                    item.classList.remove('submenu-active');
                }
            });
            
            // Toggle current submenu
            parent.classList.toggle('submenu-active');
        });
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            // If click is outside sidebar and sidebar is active
            if (!sidebar.contains(e.target) && 
                !e.target.classList.contains('toggle-btn') && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                content.classList.remove('active');
            }
        }
    });
    
    // Handle responsive behavior
    function handleResize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            content.classList.remove('active');
        }
    }
    
    // Initial call and resize listener
    window.addEventListener('resize', handleResize);
    
    // Add active class to current page link
    const currentLocation = window.location.href;
    const menuLinks = document.querySelectorAll('.menu-link, .submenu-link');
    
    menuLinks.forEach(link => {
        if (link.href === currentLocation) {
            link.classList.add('active');
            
            // If it's a submenu item, open its parent
            const submenuParent = link.closest('.has-submenu');
            if (submenuParent) {
                submenuParent.classList.add('submenu-active');
            }
        }
    });
});