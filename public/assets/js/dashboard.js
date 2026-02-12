document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebarTitle = document.querySelector('.sidebar h2');

    // Mapeo de rutas a nombres de página e iconos
    const pageNames = {
        '/admin/home': 'Inicio',
        '/admin/page': 'Página',
        '/admin/report': 'Informe',
        '/admin/manual': 'Manual',
        '/admin/users': 'Usuarios',
        '/admin/forms': 'Formularios',
        '/admin/settings': 'Ajustes'
    };

    const pageIcons = {
        '/admin/home': '\uf015',      // fa-house
        '/admin/page': '\uf0ac',      // fa-globe
        '/admin/report': '\uf201',    // fa-chart-line
        '/admin/manual': '\uf02d',    // fa-book
        '/admin/users': '\uf0c0',     // fa-users
        '/admin/forms': '\uf15c',     // fa-file-lines
        '/admin/settings': '\uf013'   // fa-gear
    };

    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Detectar página actual y marcar link activo
    function setActivePage() {
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.menu a');
        
        menuLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;
            
            if (linkPath === currentPath) {
                link.classList.add('active');
                
                // Actualizar título e icono en móvil
                if (isMobile()) {
                    if (pageNames[linkPath]) {
                        sidebarTitle.textContent = pageNames[linkPath];
                    }
                    if (pageIcons[linkPath]) {
                        sidebarTitle.setAttribute('data-page-icon', pageIcons[linkPath]);
                    }
                }
            } else {
                link.classList.remove('active');
            }
            
            // Agregar data-title para tooltip en desktop
            if (pageNames[linkPath]) {
                link.setAttribute('data-title', pageNames[linkPath]);
            }
        });
    }

    // Ejecutar al cargar
    setActivePage();

    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        
        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
        } else {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                localStorage.setItem('sidebarState', 'expanded');
            }
        }
    });

    // Cerrar menú al hacer click fuera en móvil
    document.addEventListener('click', function(e) {
        if (isMobile() && sidebar.classList.contains('mobile-open')) {
            if (!sidebar.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });

    // Cerrar menú al hacer click en un enlace en móvil
    const menuLinks = document.querySelectorAll('.menu a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (isMobile()) {
                sidebar.classList.remove('mobile-open');
            }
        });
    });

    // Recuperar estado guardado solo en desktop
    if (!isMobile()) {
        const savedState = localStorage.getItem('sidebarState');
        if (savedState === 'collapsed') {
            sidebar.classList.add('collapsed');
            main.classList.add('expanded');
        }
    }
    
    // Manejar cambio de tamaño de ventana
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (isMobile()) {
                sidebar.classList.remove('collapsed');
                main.classList.remove('expanded');
                setActivePage(); // Actualizar título e icono móvil
            } else {
                sidebar.classList.remove('mobile-open');
                
                // Restaurar texto original en desktop
                const originalRole = sidebarTitle.getAttribute('data-original-text');
                if (originalRole) {
                    sidebarTitle.textContent = originalRole;
                }
                sidebarTitle.removeAttribute('data-page-icon');
                
                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                    sidebar.classList.add('collapsed');
                    main.classList.add('expanded');
                }
            }
        }, 250);
    });
    
    // Guardar texto original del título
    sidebarTitle.setAttribute('data-original-text', sidebarTitle.textContent);
});