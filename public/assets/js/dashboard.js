document.addEventListener('DOMContentLoaded', function() {
    document.documentElement.classList.remove('sidebar-start-collapsed');
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
        '/admin/notifications': 'Notificaciones',
        '/admin/settings': 'Ajustes'
    };

    const pageIcons = {
        '/admin/home': '\uf015',      // fa-house
        '/admin/page': '\uf0ac',      // fa-globe
        '/admin/report': '\uf201',    // fa-chart-line
        '/admin/manual': '\uf02d',    // fa-book
        '/admin/users': '\uf0c0',     // fa-users
        '/admin/forms': '\uf15c',     // fa-file-lines
        '/admin/notifications': '\uf0f3',  // fa-bell
        '/admin/settings': '\uf013'   // fa-gear
    };

    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Detectar página actual y marcar link activo
    function setActivePage() {
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.menu a:not(.notification-trigger)');
        
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

    // 🔹 QUITAR BLOQUEO DE TRANSICIONES DESPUÉS DEL RENDER
    requestAnimationFrame(() => {
        document.documentElement.classList.remove('no-transition');
    });
    
    // ==================== NOTIFICACIONES ====================
    const notificationsPanel = document.getElementById('notificationsPanel');
    const notificationsOverlay = document.getElementById('notificationsOverlay');
    const notificationsList = document.getElementById('notificationsList');
    const notificationBtns = document.querySelectorAll('.notification-trigger');
    const closeNotificationsBtn = document.getElementById('closeNotifications');
    
    // Datos de notificaciones (se llenarán desde el servidor)
    let notificationsData = [];
    
    // Actualizar el contador dinámicamente
    window.updateNotificationCount = function(count) {
        const badges = document.querySelectorAll('.notification-badge');
        badges.forEach(badge => {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        });
    };
    
    // Renderizar notificaciones en el panel
    function renderNotifications(notifications) {
        if (!notificationsList) return;
        
        if (notifications.length === 0) {
            notificationsList.innerHTML = `
                <div class="notification-empty">
                    <i class="fa fa-bell-slash"></i>
                    <p>No tienes notificaciones</p>
                </div>
            `;
            return;
        }
        
        notificationsList.innerHTML = notifications.map(notif => `
            <div class="notification-item ${notif.read ? '' : 'unread'}" data-id="${notif.id}">
                <div class="notification-item-header">
                    <div class="notification-item-title">${notif.title}</div>
                    ${!notif.read ? '<span class="notification-item-badge">Nuevo</span>' : ''}
                </div>
                <div class="notification-item-message">${notif.message}</div>
                <div class="notification-item-time">
                    <i class="fa fa-clock"></i> ${notif.time}
                </div>
            </div>
        `).join('');
        
        // Agregar click listeners a las notificaciones
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() {
                const notifId = this.getAttribute('data-id');
                markAsRead(notifId);
            });
        });
    }
    
    // Abrir panel de notificaciones
    function openNotificationsPanel() {
        if (notificationsPanel && notificationsOverlay) {
            notificationsPanel.classList.add('open');
            notificationsOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Difuminar el main y sidebar
            main?.classList.add('blurred');
            sidebar?.classList.add('blurred');
            
            // Quitar clase active de todos los links del menú
            document.querySelectorAll('.menu a').forEach(link => {
                link.classList.remove('active');
            });
            
            fetchNotificationsDetails();
        }
    }
    
    // Cerrar panel de notificaciones
    function closeNotificationsPanel() {
        if (notificationsPanel && notificationsOverlay) {
            notificationsPanel.classList.remove('open');
            notificationsOverlay.classList.remove('active');
            document.body.style.overflow = '';
            
            // Quitar difuminado
            main?.classList.remove('blurred');
            sidebar?.classList.remove('blurred');
            
            // Restaurar clase active a la página actual
            setActivePage();
        }
    }
    
    // Event listeners para abrir panel
    notificationBtns.forEach(btn => {
        btn?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openNotificationsPanel();
        });
    });
    
    // Event listeners para cerrar panel
    closeNotificationsBtn?.addEventListener('click', closeNotificationsPanel);
    notificationsOverlay?.addEventListener('click', closeNotificationsPanel);
    
    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && notificationsPanel?.classList.contains('open')) {
            closeNotificationsPanel();
        }
    });
    
    // Obtener conteo de notificaciones del servidor
    function fetchNotifications() {
        fetch('/api/notifications/count')
            .then(res => res.json())
            .then(data => window.updateNotificationCount(data.count))
            .catch(err => console.error('Error al obtener notificaciones:', err));
    }
    
    // Obtener detalles de las notificaciones
    function fetchNotificationsDetails() {
        fetch('/api/notifications/list')
            .then(res => res.json())
            .then(data => {
                notificationsData = data.notifications || [];
                renderNotifications(notificationsData);
            })
            .catch(err => {
                console.error('Error al obtener detalles de notificaciones:', err);
                // Mostrar notificaciones de ejemplo si falla
                renderNotifications([]);
            });
    }
    
    // Marcar notificación como leída
    function markAsRead(notificationId) {
        fetch(`/api/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Actualizar visualmente
                const notifElement = document.querySelector(`[data-id="${notificationId}"]`);
                if (notifElement) {
                    notifElement.classList.remove('unread');
                    const badge = notifElement.querySelector('.notification-item-badge');
                    if (badge) badge.remove();
                }
                // Actualizar contador
                fetchNotifications();
            }
        })
        .catch(err => console.error('Error al marcar como leída:', err));
    }
    
    // Marcar todas como leídas
    document.getElementById('markAllRead')?.addEventListener('click', function() {
        fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchNotificationsDetails();
                fetchNotifications();
            }
        })
        .catch(err => console.error('Error:', err));
    });
    
    // Limpiar todas las notificaciones
    document.getElementById('clearAll')?.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que quieres eliminar todas las notificaciones?')) {
            fetch('/api/notifications/clear-all', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    fetchNotificationsDetails();
                    fetchNotifications();
                }
            })
            .catch(err => console.error('Error:', err));
        }
    });
    
    // Llamar al cargar y cada 30 segundos
    fetchNotifications();
    setInterval(fetchNotifications, 30000);
    
});