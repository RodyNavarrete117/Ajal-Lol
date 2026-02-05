document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main');
    const toggleBtn = document.getElementById('toggleBtn');

    function isMobile() {
        return window.innerWidth <= 768;
    }

    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation(); // Evitar que el click se propague
        
        if (isMobile()) {
            // En móvil: alternar clase mobile-open
            sidebar.classList.toggle('mobile-open');
        } else {
            // En desktop: alternar collapsed
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            
            // Guardar estado en localStorage
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
            // Verificar si el click fue fuera del sidebar
            if (!sidebar.contains(e.target)) {
                sidebar.classList.remove('mobile-open');
            }
        }
    });

    // Cerrar menú al hacer click en un enlace del menú en móvil
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
    window.addEventListener('resize', function() {
        if (isMobile()) {
            // Limpiar clases de desktop
            sidebar.classList.remove('collapsed');
            main.classList.remove('expanded');
        } else {
            // Limpiar clases de móvil
            sidebar.classList.remove('mobile-open');
            // Restaurar estado guardado
            const savedState = localStorage.getItem('sidebarState');
            if (savedState === 'collapsed') {
                sidebar.classList.add('collapsed');
                main.classList.add('expanded');
            }
        }
    });
});