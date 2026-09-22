document.addEventListener('DOMContentLoaded', () => {
    // --- SIDEBAR TOGGLE ---
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    const sidebarLabels = document.querySelectorAll('.sidebar-label');
    const brandTitle = document.getElementById('brand-title');

    let isCollapsed = false;

    function toggleSidebar() {
        isCollapsed = !isCollapsed;
        if (isCollapsed) {
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-16');
            sidebarTexts.forEach(el => el.classList.add('hidden'));
            sidebarLabels.forEach(el => el.classList.add('hidden'));
            brandTitle.classList.add('hidden');
        } else {
            sidebar.classList.remove('w-16');
            sidebar.classList.add('w-64');
            sidebarTexts.forEach(el => el.classList.remove('hidden'));
            sidebarLabels.forEach(el => el.classList.remove('hidden'));
            brandTitle.classList.remove('hidden');
        }
    }

    toggleBtn?.addEventListener('click', toggleSidebar);

    // --- DRAWER INTERACTION ---
    const drawer = document.getElementById('detail-drawer');
    const overlay = document.getElementById('drawer-overlay');
    const closeDrawerBtn = document.getElementById('close-drawer');
    const rows = document.querySelectorAll('.doc-row');

    function openDrawer() {
        overlay.classList.remove('hidden');
        drawer.classList.remove('translate-x-full');
    }

    function closeDrawer() {
        overlay.classList.add('hidden');
        drawer.classList.add('translate-x-full');
    }

    rows.forEach(row => {
        row.addEventListener('click', () => {
            openDrawer();
        });
    });

    closeDrawerBtn?.addEventListener('click', closeDrawer);
    overlay?.addEventListener('click', closeDrawer);

    // --- KEYBOARD SHORTCUTS ---
    const searchInput = document.getElementById('global-search');

    document.addEventListener('keydown', (e) => {
        // Focus Search bar with '/'
        if (e.key === '/' && document.activeElement !== searchInput) {
            e.preventDefault();
            searchInput?.focus();
        }

        // Close Drawer with 'Esc'
        if (e.key === 'Escape') {
            closeDrawer();
        }

        // Toggle Sidebar with Ctrl+B or Cmd+B
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
            e.preventDefault();
            toggleSidebar();
        }
    });
});
