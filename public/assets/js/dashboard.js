document.addEventListener('DOMContentLoaded', function () {
    // Remove sidebar-start-collapsed AFTER restoring state to avoid flicker
    const sidebar               = document.getElementById('sidebar');
    const main                  = document.getElementById('main');
    const toggleBtn             = document.getElementById('toggleBtn');
    const sidebarTitle          = document.querySelector('.sidebar h2');
    const notificationsPanel    = document.getElementById('notificationsPanel');
    const notificationsOverlay  = document.getElementById('notificationsOverlay');
    const notificationsList     = document.getElementById('notificationsList');
    const closeNotificationsBtn = document.getElementById('closeNotifications');
    const notificationBtns      = document.querySelectorAll('.notification-trigger');

    // ── Helpers ──────────────────────────────────────────────────
    function isMobile() { return window.innerWidth <= 768; }

    function isSidebarCollapsed() {
        return sidebar.classList.contains('collapsed');
    }

    // ── Page metadata ─────────────────────────────────────────────
    const pageNames = {
        '/admin/home':          'Inicio',
        '/admin/page':          'Página',
        '/admin/report':        'Informe',
        '/admin/manual':        'Manual',
        '/admin/users':         'Usuarios',
        '/admin/forms':         'Formularios',
        '/admin/notifications': 'Notificaciones',
        '/admin/settings':      'Ajustes'
    };

    const pageIcons = {
        '/admin/home':          '\uf015',
        '/admin/page':          '\uf0ac',
        '/admin/report':        '\uf201',
        '/admin/manual':        '\uf02d',
        '/admin/users':         '\uf0c0',
        '/admin/forms':         '\uf15c',
        '/admin/notifications': '\uf0f3',
        '/admin/settings':      '\uf013'
    };

    // ── Active page ───────────────────────────────────────────────
    function setActivePage() {
        const currentPath = window.location.pathname;
        document.querySelectorAll('.menu a:not(.notification-trigger)').forEach(link => {
            const linkPath = new URL(link.href).pathname;
            link.classList.toggle('active', linkPath === currentPath);

            if (isMobile() && linkPath === currentPath) {
                if (pageNames[linkPath]) sidebarTitle.textContent = pageNames[linkPath];
                if (pageIcons[linkPath]) sidebarTitle.setAttribute('data-page-icon', pageIcons[linkPath]);
            }

            if (pageNames[linkPath]) link.setAttribute('data-title', pageNames[linkPath]);
        });
    }

    setActivePage();

    // ── Sync body class with sidebar collapsed state ──────────────
    function syncBodyClass() {
        document.body.classList.toggle('sidebar-collapsed', isSidebarCollapsed());
    }

    // ── Toggle sidebar ────────────────────────────────────────────
    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();

        if (isMobile()) {
            sidebar.classList.toggle('mobile-open');
        } else {
            // Close notif panel before toggling
            if (document.body.classList.contains('notif-open')) {
                closeNotificationsPanel(false); // silent close, no page restore
            }

            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
            syncBodyClass();

            localStorage.setItem('sidebarState',
                isSidebarCollapsed() ? 'collapsed' : 'expanded');
        }
    });

    // Close mobile menu on outside click
    document.addEventListener('click', function (e) {
        if (isMobile() && sidebar.classList.contains('mobile-open') && !sidebar.contains(e.target)) {
            sidebar.classList.remove('mobile-open');
        }
    });

    // Close mobile menu on link click
    document.querySelectorAll('.menu a').forEach(link => {
        link.addEventListener('click', function () {
            if (isMobile()) sidebar.classList.remove('mobile-open');
        });
    });

    // Restore sidebar state on desktop — sin animación todavía
    if (!isMobile()) {
        const savedState = localStorage.getItem('sidebarState');
        if (savedState === 'collapsed') {
            sidebar.classList.add('collapsed');
            main.classList.add('expanded');
        }
    }

    syncBodyClass(); // initial body class

    // Quitar sidebar-start-collapsed en doble rAF:
    // primer frame → browser pinta el estado colapsado sin transiciones
    // segundo frame → se habilitan las transiciones normalmente
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            document.documentElement.classList.remove('sidebar-start-collapsed');
        });
    });

    // Handle resize
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (isMobile()) {
                sidebar.classList.remove('collapsed');
                main.classList.remove('expanded');
                setActivePage();
            } else {
                sidebar.classList.remove('mobile-open');
                const orig = sidebarTitle.getAttribute('data-original-text');
                if (orig) sidebarTitle.textContent = orig;
                sidebarTitle.removeAttribute('data-page-icon');

                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                    sidebar.classList.add('collapsed');
                    main.classList.add('expanded');
                }
            }
            syncBodyClass();
        }, 250);
    });

    sidebarTitle.setAttribute('data-original-text', sidebarTitle.textContent);

    // no-transition ya no se usa — manejado por sidebar-start-collapsed

    // ── NOTIFICATIONS ─────────────────────────────────────────────

    let notificationsData = [];

    // Update badge count
    window.updateNotificationCount = function (count) {
        document.querySelectorAll('.notification-badge').forEach(badge => {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        });
    };

    // Render
    function renderNotifications(notifications) {
        if (!notificationsList) return;

        if (notifications.length === 0) {
            notificationsList.innerHTML = `
                <div class="notification-empty">
                    <div class="notif-check-wrap">
                        <i class="fa fa-check"></i>
                    </div>
                    <p class="notif-empty-title">¡Estás al día!</p>
                    <p class="notif-empty-sub">No tienes notificaciones nuevas por ahora.</p>
                </div>`;
            return;
        }

        notificationsList.innerHTML = notifications.map(n => `
            <div class="notification-item ${n.read ? '' : 'unread'}" data-id="${n.id}">
                <div class="notification-item-header">
                    <div class="notification-item-title">${n.title}</div>
                    ${!n.read ? '<span class="notification-item-badge">Nuevo</span>' : ''}
                </div>
                <div class="notification-item-message">${n.message}</div>
                <div class="notification-item-time">
                    <i class="fa fa-clock"></i> ${n.time}
                </div>
            </div>`).join('');

        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function () {
                markAsRead(this.getAttribute('data-id'));
            });
        });
    }

    // Open
    function openNotificationsPanel() {
        if (!notificationsPanel) return;

        // Sync collapsed class on body before opening
        syncBodyClass();

        document.body.classList.add('notif-open');

        // Show overlay for: collapsed flyout or mobile (not expanded sidebar)
        if (isSidebarCollapsed() || isMobile()) {
            notificationsOverlay.classList.add('active');
        }

        // Remove active state from menu links
        document.querySelectorAll('.menu a').forEach(l => l.classList.remove('active'));

        fetchNotificationsDetails();
    }

    // Close
    function closeNotificationsPanel(restorePage = true) {
        if (!notificationsPanel) return;

        document.body.classList.remove('notif-open');
        notificationsOverlay.classList.remove('active');

        if (restorePage) setActivePage();
    }

    // Toggle on trigger click
    notificationBtns.forEach(btn => {
        btn?.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (document.body.classList.contains('notif-open')) {
                closeNotificationsPanel();
            } else {
                openNotificationsPanel();
            }
        });
    });

    closeNotificationsBtn?.addEventListener('click', () => closeNotificationsPanel());
    notificationsOverlay?.addEventListener('click', () => closeNotificationsPanel());

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && document.body.classList.contains('notif-open')) {
            closeNotificationsPanel();
        }
    });

    // ── API ───────────────────────────────────────────────────────
    function fetchNotifications() {
        fetch('/api/notifications/count')
            .then(r => r.json())
            .then(d => window.updateNotificationCount(d.count))
            .catch(() => {});
    }

    function fetchNotificationsDetails() {
        if (!notificationsList) return;

        notificationsList.innerHTML = `
            <div class="notification-empty">
                <div class="notif-check-wrap">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <p class="notif-empty-title">Cargando...</p>
            </div>`;

        fetch('/api/notifications/list')
            .then(r => r.json())
            .then(d => {
                notificationsData = d.notifications || [];
                renderNotifications(notificationsData);
            })
            .catch(() => renderNotifications([]));
    }

    function markAsRead(id) {
        fetch(`/api/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
            .then(r => r.json())
            .then(d => {
                if (d.success) {
                    const el = document.querySelector(`[data-id="${id}"]`);
                    if (el) {
                        el.classList.remove('unread');
                        el.querySelector('.notification-item-badge')?.remove();
                    }
                    fetchNotifications();
                }
            })
            .catch(() => {});
    }

    document.getElementById('markAllRead')?.addEventListener('click', function () {
        fetch('/api/notifications/read-all', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        }).then(r => r.json()).then(d => {
            if (d.success) { fetchNotificationsDetails(); fetchNotifications(); }
        }).catch(() => {});
    });

    document.getElementById('clearAll')?.addEventListener('click', function () {
        if (!confirm('¿Estás seguro de que quieres eliminar todas las notificaciones?')) return;

        fetch('/api/notifications/clear-all', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        }).then(r => r.json()).then(d => {
            if (d.success) { fetchNotificationsDetails(); fetchNotifications(); }
        }).catch(() => {});
    });

    fetchNotifications();
    setInterval(fetchNotifications, 30000);
});