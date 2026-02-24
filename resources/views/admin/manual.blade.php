@extends('admin.dashboard')

@section('title', 'Manual')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/manual.css') }}">
@endpush

@section('content')
<div class="manual-container">

    <!-- Hero -->
    <div class="manual-hero">
        <h1>
            <i class="fas fa-book-open"></i>
            Manual del Administrador
        </h1>
        <p>Guía completa para el uso del panel de administración. Selecciona una sección para comenzar.</p>
    </div>

    <!-- Navegación principal -->
    <div class="quick-nav">
        <h3><i class="fas fa-th-large"></i> ¿Qué sección quieres consultar?</h3>
        <div class="quick-nav-grid">
            <a href="#" class="quick-nav-item" data-target="dashboard">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="#" class="quick-nav-item" data-target="usuarios">
                <i class="fas fa-users"></i> Usuarios
            </a>
            <a href="#" class="quick-nav-item" data-target="formularios">
                <i class="fas fa-envelope"></i> Formularios
            </a>
            <a href="#" class="quick-nav-item" data-target="ajustes">
                <i class="fas fa-cog"></i> Configuración
            </a>
            <a href="#" class="quick-nav-item" data-target="seguridad">
                <i class="fas fa-shield-alt"></i> Seguridad
            </a>
            <a href="#" class="quick-nav-item" data-target="resumen">
                <i class="fas fa-clipboard-check"></i> Resumen
            </a>
        </div>
    </div>

    <!-- Área de contenido -->
    <div class="manual-sections-wrapper">

        <!-- Estado vacío — visible por defecto -->
        <div class="manual-empty-state" id="manualEmptyState">
            <div class="empty-icon">
                <i class="fas fa-hand-pointer"></i>
            </div>
            <h4>Selecciona una sección</h4>
            <p>Usa los botones de arriba para explorar el manual.</p>
        </div>

        <!-- ================================================
             SECCIONES — ocultas por defecto (sin .visible)
        ================================================ -->

        <!-- Dashboard -->
        <div class="manual-section" id="dashboard">
            <h3>
                <div class="section-number">1</div>
                Panel de Inicio (Dashboard)
            </h3>

            <p>El Dashboard es la primera pantalla que verás al iniciar sesión. Proporciona una vista general del sistema con estadísticas en tiempo real y accesos directos a las funciones principales.</p>

            <div class="feature-list">
                <h4><i class="fas fa-chart-bar"></i> Estadísticas Disponibles:</h4>
                <ul>
                    <li><strong>Total de Usuarios:</strong> Número total de usuarios registrados en el sistema</li>
                    <li><strong>Páginas Activas:</strong> Cantidad de páginas publicadas (próximamente)</li>
                    <li><strong>Formularios Recibidos:</strong> Contactos y solicitudes recibidas</li>
                </ul>
            </div>

            <div class="feature-list">
                <h4><i class="fas fa-rocket"></i> Accesos Rápidos:</h4>
                <ul>
                    <li>Inicio — Volver al panel principal</li>
                    <li>Página — Gestión de contenido del sitio web</li>
                    <li>Informe — Reportes y análisis del sistema</li>
                    <li>Manual — Esta guía de usuario</li>
                    <li>Usuarios — Administración de cuentas (solo administradores)</li>
                    <li>Formularios — Ver mensajes de contacto</li>
                    <li>Ajustes — Configuración personal y del sistema</li>
                </ul>
            </div>

            <div class="image-placeholder">
                <i class="fas fa-image"></i>
                <p>Captura de pantalla del Dashboard</p>
            </div>

            <div class="tip-box">
                <strong><i class="fas fa-lightbulb"></i> Consejo:</strong>
                Las estadísticas se actualizan automáticamente cada vez que accedes al dashboard. No es necesario recargar la página manualmente.
            </div>
        </div>

        <!-- Usuarios -->
        <div class="manual-section" id="usuarios">
            <h3>
                <div class="section-number">2</div>
                Gestión de Usuarios
            </h3>

            <p>Esta sección te permite administrar todas las cuentas de usuario del sistema. <strong>Solo disponible para usuarios con rol de Administrador.</strong></p>

            <div class="info-box">
                <strong><i class="fas fa-info-circle"></i> Importante:</strong>
                Los usuarios con rol de "Editor" no podrán ver ni acceder a esta sección. Es exclusiva para administradores.
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h5>Agregar Usuario</h5>
                    <p>Click en "Agregar nuevo usuario" para crear una cuenta. Completa nombre, correo, rol y contraseña.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h5>Editar Usuario</h5>
                    <p>Click en el botón "Editar" para modificar la información. Puedes cambiar nombre, correo y rol.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h5>Eliminar Usuario</h5>
                    <p>Click en "Borrar" para eliminar una cuenta. Se solicitará confirmación antes de proceder.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h5>Buscar Usuario</h5>
                    <p>Usa la barra de búsqueda para filtrar por nombre o correo electrónico rápidamente.</p>
                </div>
            </div>

            <div class="feature-list">
                <h4><i class="fas fa-user-tag"></i> Roles Disponibles:</h4>
                <ul>
                    <li><strong>Administrador:</strong> Acceso completo a todas las funciones, incluida la gestión de usuarios</li>
                    <li><strong>Editor:</strong> Acceso limitado, puede ver formularios y gestionar contenido, pero no usuarios</li>
                </ul>
            </div>

            <div class="image-placeholder">
                <i class="fas fa-image"></i>
                <p>Captura de pantalla de la Gestión de Usuarios</p>
            </div>

            <div class="warning-box">
                <strong><i class="fas fa-exclamation-triangle"></i> Advertencia:</strong>
                Al eliminar un usuario, también se eliminará su rol asignado. Esta acción no se puede deshacer. Asegúrate de hacer respaldos periódicos.
            </div>

            <div class="tip-box">
                <strong><i class="fas fa-lightbulb"></i> Mejores Prácticas:</strong>
                Asigna contraseñas seguras de al menos 8 caracteres. Revisa periódicamente los usuarios activos. No compartas credenciales de administrador. Cambia contraseñas cada 90 días.
            </div>
        </div>

        <!-- Formularios -->
        <div class="manual-section" id="formularios">
            <h3>
                <div class="section-number">3</div>
                Formularios de Contacto
            </h3>

            <p>Visualiza y gestiona todos los mensajes recibidos a través del formulario de contacto del sitio web. Incluye solicitudes de colaboración, donaciones e información general.</p>

            <div class="feature-list">
                <h4><i class="fas fa-list-check"></i> Información Visible:</h4>
                <ul>
                    <li>Nombre completo del remitente</li>
                    <li>Correo electrónico de contacto</li>
                    <li>Número de teléfono (opcional)</li>
                    <li>Asunto del mensaje</li>
                    <li>Mensaje completo</li>
                    <li>Fecha y hora de envío</li>
                </ul>
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h5>Ver Detalles</h5>
                    <p>Click en el ícono del ojo para ver el mensaje completo en un modal.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h5>Filtrar por Fecha</h5>
                    <p>Usa los filtros: Hoy, Esta semana, Este mes para organizar los mensajes.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h5>Buscar Mensajes</h5>
                    <p>Busca por nombre, correo o asunto usando la barra de búsqueda.</p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <h5>Exportar Datos</h5>
                    <p>Click en "Exportar" para descargar todos los formularios en formato CSV.</p>
                </div>
            </div>

            <div class="image-placeholder">
                <i class="fas fa-image"></i>
                <p>Captura de pantalla de los Formularios de Contacto</p>
            </div>

            <div class="tip-box">
                <strong><i class="fas fa-lightbulb"></i> Gestión Eficiente:</strong>
                Revisa los formularios diariamente. Responde a las solicitudes en un plazo de 24-48 horas. Exporta los datos semanalmente como respaldo. Elimina mensajes spam para mantener la base de datos limpia.
            </div>
        </div>

        <!-- Ajustes -->
        <div class="manual-section" id="ajustes">
            <h3>
                <div class="section-number">4</div>
                Configuración y Ajustes
            </h3>

            <p>Personaliza tu cuenta y configura preferencias del sistema desde esta sección. Disponible para todos los usuarios.</p>

            <div class="feature-list">
                <h4><i class="fas fa-lock"></i> Seguridad:</h4>
                <ul>
                    <li><strong>Cambiar Contraseña:</strong> Actualiza tu contraseña actual por una nueva</li>
                    <li><strong>Indicador de Fortaleza:</strong> Visualiza qué tan segura es tu nueva contraseña</li>
                    <li><strong>Mantener Sesión:</strong> Opción para cerrar sesión automáticamente después del cambio</li>
                    <li><strong>Validaciones:</strong> Sistema que verifica contraseña actual y coincidencia</li>
                </ul>
            </div>

            <div class="feature-list">
                <h4><i class="fas fa-user-circle"></i> Perfil:</h4>
                <ul>
                    <li><strong>Nombre Completo:</strong> Actualiza tu nombre de usuario</li>
                    <li><strong>Correo Electrónico:</strong> Modifica tu email de contacto</li>
                    <li><strong>Rol Asignado:</strong> Visualiza tu rol actual (solo lectura)</li>
                    <li><strong>Sincronización:</strong> Los cambios se reflejan inmediatamente en el sistema</li>
                </ul>
            </div>

            <div class="feature-list">
                <h4><i class="fas fa-bell"></i> Notificaciones:</h4>
                <ul>
                    <li><strong>Email:</strong> Activa/desactiva notificaciones por correo</li>
                    <li><strong>Colaboradores:</strong> Alertas cuando lleguen nuevas solicitudes</li>
                    <li><strong>Cambios:</strong> Notificaciones sobre modificaciones en la plataforma</li>
                    <li>Las preferencias se guardan localmente en tu navegador</li>
                </ul>
            </div>

            <div class="feature-list">
                <h4><i class="fas fa-palette"></i> Apariencia:</h4>
                <ul>
                    <li><strong>Modo Oscuro / Claro / Automático:</strong> Elige el tema visual de la interfaz</li>
                    <li><strong>Modo Rendimiento:</strong> Desactiva animaciones para mejorar velocidad en equipos lentos</li>
                </ul>
            </div>

            <div class="image-placeholder">
                <i class="fas fa-image"></i>
                <p>Captura de pantalla de la Configuración</p>
            </div>

            <div class="warning-box">
                <strong><i class="fas fa-exclamation-triangle"></i> Seguridad de Contraseñas:</strong>
                Usa al menos 8 caracteres. Combina mayúsculas, minúsculas y números. Incluye caracteres especiales (@, #, $, etc.). No reutilices contraseñas de otras plataformas.
            </div>
        </div>

        <!-- Seguridad -->
        <div class="manual-section" id="seguridad">
            <h3>
                <div class="section-number">5</div>
                Seguridad y Mejores Prácticas
            </h3>

            <p>Recomendaciones para mantener el sistema seguro y proteger la información de los usuarios.</p>

            <div class="feature-list">
                <h4><i class="fas fa-shield-alt"></i> Recomendaciones de Seguridad:</h4>
                <ul>
                    <li>Cierra sesión al terminar, especialmente en computadoras compartidas</li>
                    <li>No compartas tus credenciales con terceros</li>
                    <li>Verifica que la URL sea correcta antes de iniciar sesión</li>
                    <li>Mantén tu navegador actualizado a la última versión</li>
                    <li>Habilita la autenticación de dos factores si está disponible</li>
                    <li>Reporta cualquier actividad sospechosa inmediatamente</li>
                </ul>
            </div>

            <div class="feature-list">
                <h4><i class="fas fa-tasks"></i> Checklist de Mantenimiento:</h4>
                <ul>
                    <li>Revisar formularios de contacto diariamente</li>
                    <li>Exportar respaldo de datos semanalmente</li>
                    <li>Auditar usuarios activos mensualmente</li>
                    <li>Actualizar contraseñas cada 90 días</li>
                    <li>Verificar estadísticas del dashboard regularmente</li>
                </ul>
            </div>

            <div class="info-box">
                <strong><i class="fas fa-headset"></i> Soporte Técnico:</strong>
                Si encuentras problemas técnicos, contacta al equipo de soporte proporcionando: descripción detallada del problema, pantallazos si es posible, navegador y versión que estás usando, y pasos para reproducir el error.
            </div>
        </div>

        <!-- Resumen -->
        <div class="manual-section summary-section" id="resumen">
            <h3>
                <div class="section-number" style="border-radius:50%;">
                    <i class="fas fa-clipboard-check" style="font-size:0.95rem;"></i>
                </div>
                Resumen
            </h3>

            <p>Este manual cubre las funcionalidades principales del panel de administración. Cada sección está diseñada para facilitar la gestión del sistema de manera intuitiva y segura.</p>

            <div class="tip-box">
                <strong><i class="fas fa-bullseye"></i> Próximos Pasos:</strong>
                Explora cada sección del panel para familiarizarte con las herramientas. No dudes en experimentar, ya que la mayoría de las acciones críticas solicitan confirmación antes de ejecutarse.
            </div>

            <p style="text-align:center; margin-top:22px; font-style:italic; font-size:0.87rem; color:var(--mn-text-sub);">
                <i class="fas fa-calendar-alt"></i> Última actualización: {{ date('d/m/Y') }}
                &nbsp;&nbsp;
                <i class="fas fa-code-branch"></i> Versión 1.0
            </p>
        </div>

    </div><!-- /.manual-sections-wrapper -->
</div><!-- /.manual-container -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const navItems   = document.querySelectorAll('.quick-nav-item[data-target]');
    const sections   = document.querySelectorAll('.manual-section');
    const emptyState = document.getElementById('manualEmptyState');

    let currentTarget = null;

    function showSection(targetId) {
        // If same section clicked again — deselect (toggle off)
        if (currentTarget === targetId) {
            hideAll();
            currentTarget = null;
            return;
        }

        currentTarget = targetId;

        // Hide empty state
        if (emptyState) emptyState.style.display = 'none';

        // Hide all sections, then show target
        sections.forEach(s => s.classList.remove('visible'));

        const target = document.getElementById(targetId);
        if (target) {
            // Small delay so the animation re-triggers if switching sections
            requestAnimationFrame(() => {
                target.classList.add('visible');
            });
        }

        // Update nav active state
        navItems.forEach(n => {
            n.classList.toggle('nav-active', n.dataset.target === targetId);
        });
    }

    function hideAll() {
        sections.forEach(s => s.classList.remove('visible'));
        navItems.forEach(n => n.classList.remove('nav-active'));
        if (emptyState) emptyState.style.display = '';
        currentTarget = null;
    }

    // Bind nav clicks
    navItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            showSection(this.dataset.target);
        });
    });

});
</script>
@endpush