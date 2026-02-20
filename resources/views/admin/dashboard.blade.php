<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/theme-init.js') }}"></script>

    <script>
        (function () {
            const state = localStorage.getItem('sidebarState');
            if (state === 'collapsed' && window.innerWidth > 768) {
                document.documentElement.classList.add('sidebar-start-collapsed');
            }
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" id="toggleBtn">
                <i class="fa fa-bars"></i>
            </button>
            <h2 style="text-transform: capitalize;">
                {{ session('rol') ?? 'Panel' }}
            </h2>

            <!-- Botón de notificaciones en móvil -->
            <button class="mobile-notification-btn notification-trigger" style="position: relative;">
                <i class="fa fa-bell"></i>
                <span class="notification-badge" style="display: none;">0</span>
            </button>
        </div>

        <nav class="menu">
            <div class="menu-top">

                <a href="{{ url('/admin/home') }}">
                    <i class="fa fa-house"></i>
                    <span>Inicio</span>
                </a>

                <a href="{{ url('/admin/page') }}">
                    <i class="fa fa-globe"></i>
                    <span>Página</span>
                </a>

                <a href="{{ url('/admin/report') }}">
                    <i class="fa fa-chart-line"></i>
                    <span>Informe</span>
                </a>

                <a href="{{ url('/admin/manual') }}">
                    <i class="fa fa-book"></i>
                    <span>Manual</span>
                </a>

                @if(session('rol') === 'administrador')
                <a href="{{ url('/admin/users') }}">
                    <i class="fa fa-users"></i>
                    <span>Usuarios</span>
                </a>
                @endif

                <a href="{{ url('/admin/forms') }}">
                    <i class="fa fa-file-lines"></i>
                    <span>Formularios</span>
                </a>

            </div>

            <div class="menu-bottom">
                <!-- NOTIFICACIONES -->
                <a href="#" class="notification-trigger" style="position: relative;">
                    <i class="fa fa-bell"></i>
                    <span>Notificaciones</span>
                    <span class="notification-badge" style="display: none;">0</span>
                </a>

                <!-- AJUSTES -->
                <a href="{{ url('/admin/settings') }}">
                    <i class="fa fa-gear"></i>
                    <span>Ajustes</span>
                </a>
            </div>
        </nav>
    </aside>

    {{-- ============================================================
         PANEL DE NOTIFICACIONES — FUERA DEL SIDEBAR
         En expandido: se posiciona encima del sidebar (mismo lugar)
         En colapsado: sale como flyout desde el borde del sidebar
    ============================================================ --}}
    <div class="notifications-panel" id="notificationsPanel">
        <div class="notifications-panel-header">
            <h3><i class="fa fa-bell"></i> Notificaciones</h3>
            <button class="notifications-panel-close" id="closeNotifications">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <div class="notifications-panel-content" id="notificationsList">
            <div class="notification-empty">
                <div class="notif-check-wrap">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <p class="notif-empty-title">Cargando...</p>
            </div>
        </div>

        <div class="notifications-panel-footer">
            <button class="btn-mark-read" id="markAllRead">
                <i class="fa fa-check"></i> Marcar leídas
            </button>
            <button class="btn-clear-all" id="clearAll">
                <i class="fa fa-trash"></i> Limpiar todo
            </button>
        </div>
    </div>

    <!-- OVERLAY -->
    <div class="notifications-overlay" id="notificationsOverlay"></div>

    <!-- CONTENIDO -->
    <main class="main" id="main">
        <div class="content">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    @stack('scripts')

    <script>
        @if(auth()->check())
            const initialNotificationCount = {{ 
                \App\Models\Notification::where('user_id', auth()->id())
                    ->where('read', false)
                    ->count() 
            }};
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof updateNotificationCount === 'function') {
                    updateNotificationCount(initialNotificationCount);
                }
            });
        @endif
    </script>

</body>
</html>