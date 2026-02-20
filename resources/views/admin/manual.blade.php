@extends('admin.dashboard')

@section('title', 'Manual')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admincss/manual.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="manual-container">
    <!-- Hero Section -->
    <div class="manual-hero">
        <h1>
            <i class="fas fa-book-open"></i>
            Manual del Administrador
        </h1>
        <p>Guía completa para el uso del panel de administración. Aprende a gestionar usuarios, configurar el sistema y aprovechar todas las funcionalidades disponibles.</p>
    </div>

    <!-- Navegación Rápida -->
    <div class="quick-nav">
        <h3><i class="fas fa-link"></i> Navegación Rápida</h3>
        <div class="quick-nav-grid">
            <a href="#dashboard" class="quick-nav-item">
                <i class="fas fa-chart-line"></i>
                Dashboard
            </a>
            <a href="#usuarios" class="quick-nav-item">
                <i class="fas fa-users"></i>
                Usuarios
            </a>
            <a href="#formularios" class="quick-nav-item">
                <i class="fas fa-envelope"></i>
                Formularios
            </a>
            <a href="#ajustes" class="quick-nav-item">
                <i class="fas fa-cog"></i>
                Configuración
            </a>
            <a href="#seguridad" class="quick-nav-item">
                <i class="fas fa-shield-alt"></i>
                Seguridad
            </a>
        </div>
    </div>

    <!-- Sección 1: Dashboard -->
    <div class="manual-section" id="dashboard">
        <h3>
            <span class="section-number">1</span>
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
                <li>Inicio - Volver al panel principal</li>
                <li>Página - Gestión de contenido del sitio web</li>
                <li>Informe - Reportes y análisis del sistema</li>
                <li>Manual - Esta guía de usuario</li>
                <li>Usuarios - Administración de cuentas (solo administradores)</li>
                <li>Formularios - Ver mensajes de contacto</li>
                <li>Ajustes - Configuración personal y del sistema</li>
            </ul>
        </div>

        <!-- Placeholder para imagen del Dashboard -->
        <div class="image-placeholder">
            <i class="fas fa-image"></i>
            <p>Captura de pantalla del Dashboard</p>
        </div>

        <div class="tip-box">
            <strong><i class="fas fa-lightbulb"></i> Consejo:</strong>
            Las estadísticas se actualizan automáticamente cada vez que accedes al dashboard. No es necesario recargar la página manualmente.
        </div>
    </div>

    <!-- Sección 2: Gestión de Usuarios -->
    <div class="manual-section" id="usuarios">
        <h3>
            <span class="section-number">2</span>
            Gestión de Usuarios
        </h3>
        
        <p>Esta sección te permite administrar todas las cuentas de usuario del sistema. <strong>Solo disponible para usuarios con rol de Administrador.</strong></p>

        <div class="info-box">
            <strong><i class="fas fa-info-circle"></i> Importante:</strong>
            Los usuarios con rol de "Editor" no podrán ver ni acceder a esta sección. Es exclusiva para administradores.
        </div>

        <h4 style="margin-top: 30px; color: #2d3748; font-size: 1.2rem;">Funcionalidades Principales:</h4>

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

        <!-- Placeholder para imagen de Gestión de Usuarios -->
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
            - Asigna contraseñas seguras de al menos 8 caracteres<br>
            - Revisa periódicamente los usuarios activos<br>
            - No compartas credenciales de administrador<br>
            - Cambia contraseñas cada 90 días
        </div>
    </div>

    <!-- Sección 3: Formularios de Contacto -->
    <div class="manual-section" id="formularios">
        <h3>
            <span class="section-number">3</span>
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

        <!-- Placeholder para imagen de Formularios -->
        <div class="image-placeholder">
            <i class="fas fa-image"></i>
            <p>Captura de pantalla de los Formularios de Contacto</p>
        </div>

        <div class="tip-box">
            <strong><i class="fas fa-lightbulb"></i> Gestión Eficiente:</strong>
            - Revisa los formularios diariamente<br>
            - Responde a las solicitudes en un plazo de 24-48 horas<br>
            - Exporta los datos semanalmente como respaldo<br>
            - Elimina mensajes spam para mantener la base de datos limpia
        </div>
    </div>

    <!-- Sección 4: Configuración y Ajustes -->
    <div class="manual-section" id="ajustes">
        <h3>
            <span class="section-number">4</span>
            Configuración y Ajustes
        </h3>
        
        <p>Personaliza tu cuenta y configura preferencias del sistema desde esta sección. Disponible para todos los usuarios.</p>

        <h4 style="margin-top: 30px; color: #2d3748; font-size: 1.2rem;">Pestañas Disponibles:</h4>

        <div class="feature-list">
            <h4><i class="fas fa-lock"></i> Seguridad:</h4>
            <ul>
                <li><strong>Cambiar Contraseña:</strong> Actualiza tu contraseña actual por una nueva</li>
                <li><strong>Indicador de Fortaleza:</strong> Visualiza qué tan segura es tu nueva contraseña</li>
                <li><strong>Mantener Sesión:</strong> Opción para cerrar sesión automáticamente después del cambio</li>
                <li><strong>Validaciones:</strong> Sistema de validación que verifica contraseña actual y coincidencia</li>
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
                <li><em>Nota: Las preferencias se guardan localmente en tu navegador</em></li>
            </ul>
        </div>

        <!-- Placeholder para imagen de Configuración -->
        <div class="image-placeholder">
            <i class="fas fa-image"></i>
            <p>Captura de pantalla de la Configuración</p>
        </div>

        <div class="warning-box">
            <strong><i class="fas fa-exclamation-triangle"></i> Seguridad de Contraseñas:</strong>
            - Usa al menos 8 caracteres<br>
            - Combina mayúsculas, minúsculas y números<br>
            - Incluye caracteres especiales (@, #, $, etc.)<br>
            - No reutilices contraseñas de otras plataformas<br>
            - Cambia tu contraseña regularmente
        </div>
    </div>

    <!-- Sección 5: Seguridad y Mejores Prácticas -->
    <div class="manual-section" id="seguridad">
        <h3>
            <span class="section-number">5</span>
            Seguridad y Mejores Prácticas
        </h3>
        
        <p>Recomendaciones para mantener el sistema seguro y proteger la información de los usuarios.</p>

        <div class="feature-list">
            <h4><i class="fas fa-shield-alt"></i> Recomendaciones de Seguridad:</h4>
            <ul>
                <li>Cierra sesión al terminar de usar el sistema, especialmente en computadoras compartidas</li>
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
            Si encuentras problemas técnicos o necesitas ayuda adicional, contacta al equipo de soporte técnico proporcionando:
            <ul style="margin-top: 12px; padding-left: 25px;">
                <li>Descripción detallada del problema</li>
                <li>Pantallazos si es posible</li>
                <li>Navegador y versión que estás usando</li>
                <li>Pasos para reproducir el error</li>
            </ul>
        </div>
    </div>

    <!-- Resumen Final -->
    <div class="manual-section summary-section">
        <h3 style="color: #1a202c;">
            <span class="section-number" style="background: #2d3748;">
                <i class="fas fa-clipboard-check"></i>
            </span>
            Resumen
        </h3>
        <p>Este manual cubre las funcionalidades principales del panel de administración. Cada sección está diseñada para facilitar la gestión del sistema de manera intuitiva y segura.</p>
        
        <div class="tip-box">
            <strong><i class="fas fa-bullseye"></i> Próximos Pasos:</strong>
            Explora cada sección del panel para familiarizarte con las herramientas. No dudes en experimentar, ya que la mayoría de las acciones críticas solicitan confirmación antes de ejecutarse.
        </div>

        <p style="text-align: center; margin-top: 35px; color: #718096; font-style: italic;">
            <i class="fas fa-calendar-alt"></i> Última actualización: {{ date('d/m/Y') }}<br>
            <i class="fas fa-code-branch"></i> Versión del manual: 1.0
        </p>
    </div>
</div>
@endsection