<!DOCTYPE html>
<html lang="es">
<head>

  <!-- ── Meta base ── -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajal Lol A.C. — Asistencia Social</title>
  <meta name="description" content="Ajal Lol A.C. — Organización de Asistencia Social sin fines de lucro que apoya a comunidades mayas de Yucatán desde el año 2000.">
  <meta name="keywords"    content="Ajal Lol, asistencia social, Yucatán, voluntariado, donaciones, comunidades mayas">
  <meta name="author"      content="Ajal Lol A.C.">
  <meta name="theme-color" content="#8b2252">

  <!-- ── Open Graph ── -->
  <meta property="og:title"       content="Ajal Lol A.C. — Asistencia Social en Yucatán">
  <meta property="og:description" content="Organización sin fines de lucro que transforma vidas en comunidades mayas de Yucatán desde el año 2000.">
  <meta property="og:image"       content="{{ asset('assets/img/logo.webp') }}">
  <meta property="og:type"        content="website">
  <meta property="og:locale"      content="es_MX">

  <!-- ── Favicons ── -->
  <link rel="icon"             href="{{ asset('assets/img/logo.webp') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/logo.webp') }}">

  <!-- ── Preconnect para fuentes (cargadas en el CSS) ── -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  {{-- Las fuentes (Playfair Display + Inter) las importa visualpage.css --}}

  <!-- ── Bootstrap Icons 1.11 ── -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- ── Font Awesome 6 ── -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ── Bootstrap 5.3 ── -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

  <!-- ── CSS propio ── -->
<link href="{{ asset('assets/css/index.css') }}" rel="stylesheet">

</head>

<body class="index-page">

<!-- ======================================================
     PRELOADER
     ====================================================== -->
<div id="preloader" role="status" aria-label="Cargando página">
  <div class="preloader-leaf"></div>
</div>

<!-- ======================================================
     OVERLAY para nav móvil
     ====================================================== -->
<div class="nav-overlay" id="nav-overlay" aria-hidden="true"></div>

<!-- ======================================================
     HEADER
     ====================================================== -->
<header id="header" class="header sticky-top">

  <!-- Topbar -->
  <div class="topbar" role="complementary" aria-label="Información de contacto rápido">
    <div class="container">

      <address class="contact-info" style="font-style:normal">
        <i class="bi bi-envelope" aria-hidden="true">
          <a href="/cdn-cgi/l/email-protection#82e3e8e3eeafeeedeec2eaedf6efe3ebeeace1edef"><span class="__cf_email__" data-cfemail="8beae1eae7a6e7e4e7cbe3e4ffe6eae2e7a5e8e4e6">[email&#160;protected]</span></a>
        </i>
        <i class="bi bi-telephone" aria-hidden="true">
          <a href="tel:+529991773532">+52 999 177 3532</a>
        </i>
      </address>

      <div class="social-links" role="list" aria-label="Redes sociales">
        <a href="https://www.facebook.com/p/Ajal-Lol-AC-100064161455063/"
           aria-label="Visitar Facebook de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-facebook" aria-hidden="true"></i>
        </a>
        <a href="https://www.instagram.com/ajal_lol/?hl=es-la"
           aria-label="Visitar Instagram de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-instagram" aria-hidden="true"></i>
        </a>
        <a href="https://mx.linkedin.com/in/ajal-lol-a-c-103b811a0"
           aria-label="Visitar LinkedIn de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-linkedin" aria-hidden="true"></i>
        </a>
      </div>

    </div>
  </div>
  <!-- /Topbar -->

  <!-- Branding + Navegación -->
  <div class="branding">
    <div class="container">

      <a href="#hero" class="logo" aria-label="Ajal Lol A.C. — Ir al inicio">
        <img src="{{ asset('assets/img/logo.webp') }}" alt="Logotipo Ajal Lol" width="90" height="54">
      </a>

      <nav id="navmenu" class="navmenu" aria-label="Navegación principal">
        <ul role="menubar">
          <li role="none"><a href="#hero"      class="active" role="menuitem">Inicio</a></li>
          <li role="none"><a href="#about"                    role="menuitem">Nosotros</a></li>
          <li role="none"><a href="#services"                 role="menuitem">Actividades</a></li>
          <li role="none"><a href="#portfolio"                role="menuitem">Proyectos</a></li>
          <li role="none"><a href="#team"                     role="menuitem">Comité</a></li>
          <li role="none"><a href="#contact"                  role="menuitem">Contacto</a></li>
        </ul>
      </nav>

      <button class="mobile-nav-toggle d-xl-none bi bi-list"
              aria-label="Abrir menú de navegación"
              aria-expanded="false"
              aria-controls="navmenu"></button>

    </div>
  </div>
  <!-- /Branding -->

</header>
<!-- /HEADER -->

<main id="main" class="main">

<!-- ======================================================
     HERO
     ====================================================== -->
<section id="hero" class="hero section" aria-label="Presentación principal">

  <!-- Círculos decorativos flotantes -->
  <div class="hero-circle hero-circle-1" aria-hidden="true"></div>
  <div class="hero-circle hero-circle-2" aria-hidden="true"></div>
  <div class="hero-circle hero-circle-3" aria-hidden="true"></div>

  <div class="container">
    <div class="hero-content">
      <p class="hero-eyebrow">Organización sin fines de lucro</p>
      <h1>
        Portal informativo de
        <em>Ajal Lol A.C.</em>
      </h1>
      <p>Transformando vidas en las comunidades mayas de Yucatán desde el año 2000, con amor, compromiso e interculturalidad.</p>

      <div class="hero-buttons">
        <a href="#about" class="btn-rose">
          <i class="bi bi-heart-fill" aria-hidden="true"></i>
          Conoce más
        </a>
        <a href="https://www.youtube.com/watch?v=lRM7kJdDUM4"
           class="btn-ghost" target="_blank" rel="noopener noreferrer"
           aria-label="Ver video de Ajal Lol en YouTube">
          <span class="play-icon" aria-hidden="true"><i class="bi bi-play-fill"></i></span>
          Ver video
        </a>
      </div>
    </div>
  </div>

  <div class="hero-scroll" aria-hidden="true">
    <div class="hero-scroll-line"></div>
    <span>Scroll</span>
  </div>

</section>

<!-- ======================================================
     NOSOTROS
     ====================================================== -->
<section id="about" class="about section light-bg">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Nosotros</h2>
      <p class="sub">
        <span>Conoce más</span>&nbsp;sobre nuestra historia
      </p>
    </div>

    <div class="about-grid">

      <div class="about-img-wrapper" data-anim="fade-right">
        <img src="{{ asset('assets/img/MIS.jpg') }}"
             alt="Integrantes de Ajal Lol A.C. en actividad comunitaria"
             loading="lazy" width="600" height="500">
        <div class="about-img-badge">
          <i class="bi bi-calendar3" aria-hidden="true"></i>&nbsp; Fundada en el año 2000
        </div>
      </div>

      <div class="about-content" data-anim="fade-left">
        <span class="eyebrow">Nuestra historia</span>
        <h2 style="font-size:clamp(1.8rem,3.5vw,2.6rem)">Así comenzó Ajal Lol</h2>

        <p class="intro">
          La organización fue fundada en el año 2000 por 5 mujeres que compartían
          la inquietud de buscar una manera de ayudar a las personas de escasos
          recursos. Actualmente el comité directivo lo conforman 8 mujeres y su
          trabajo es apoyado por 35 colaboradores y voluntarios.
        </p>

        <p>
          Para nosotros como asociación es muy importante el papel que jugamos en
          la sociedad. Siempre hemos buscado que nuestras acciones tengan un impacto
          positivo llegando al mayor número posible de beneficiarios. A través de
          nuestras campañas de salud hemos ayudado a las personas a cambiar hábitos
          alimenticios, detectar enfermedades a tiempo, promover el cuidado de la
          salud, mejorar su higiene y dar valor al cuidado físico y emocional.
        </p>
      </div>

    </div>
  </div>

</section>

<!-- ======================================================
     ESTADÍSTICAS
     ====================================================== -->
<section id="stats" class="section" aria-label="Estadísticas de impacto">

  <div class="container">
    <div class="stats-grid" data-anim="fade-up">

      <div class="stat-item">
        <i class="bi bi-emoji-smile" aria-hidden="true"></i>
        <span class="num purecounter" data-end="7451" data-duration="1"
              aria-label="7451 beneficiarios atendidos">0</span>
        <p>Beneficiarios atendidos</p>
      </div>

      <div class="stat-item">
        <i class="bi bi-journal-richtext" aria-hidden="true"></i>
        <span class="num purecounter" data-end="5" data-duration="1"
              aria-label="5 proyectos activos">0</span>
        <p>Proyectos activos</p>
      </div>

      <div class="stat-item">
        <i class="bi bi-clock-history" aria-hidden="true"></i>
        <span class="num purecounter" data-end="1463" data-duration="1"
              aria-label="1463 horas de apoyo">0</span>
        <p>Horas de apoyo</p>
      </div>

      <div class="stat-item">
        <i class="bi bi-people-fill" aria-hidden="true"></i>
        <span class="num purecounter" data-end="35" data-duration="1"
              aria-label="35 voluntarios activos">0</span>
        <p>Voluntarios activos</p>
      </div>

    </div>
  </div>

</section>

<!-- ======================================================
     ALIADOS
     ====================================================== -->
<section id="clients" class="section light-bg" aria-label="Nuestros aliados y patrocinadores">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Aliados</h2>
      <p class="sub">Organizaciones que <span>confían</span> en nosotros</p>
    </div>
  </div>

  <div class="marquee-wrapper" aria-label="Carrusel de aliados">
    <div class="marquee-track" role="list">
      <img src="{{ asset('assets/img/logos/Days.png') }}"                     alt="Days"               role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/image_2024_7_31_201.png') }}"      alt="Aliado"             role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/DIFY.png') }}"                     alt="DIFY"               role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/logo-kekenv3.png') }}"             alt="Keken"              role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/marinaTri.png') }}"                alt="Mariana Trinitaria" role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/mentors.png') }}"                  alt="Mentors"            role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/oxxo.png') }}"                     alt="OXXO"               role="listitem" loading="lazy">
      <img src="{{ asset('assets/img/logos/imagews-removebg-preview.png') }}" alt="Aliado"             role="listitem" loading="lazy">
    </div>
  </div>

</section>

<!-- ======================================================
     ACTIVIDADES
     ====================================================== -->
<section id="services" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Actividades</h2>
      <p class="sub">Nuestras <span>Actividades 2023</span></p>
    </div>

    <div class="activities-grid" role="list">

      <article class="activity-card" data-anim="fade-up" data-delay="0" role="listitem">
        <div class="icon" aria-hidden="true"><i class="fas fa-tooth"></i></div>
        <h3>Jornada dental</h3>
        <p>Por segundo año consecutivo, se realizaron jornadas de servicios dentales con el apoyo de la Fundación Smile y Global Dental. Un equipo de 35 dentistas brindó servicios gratuitos, atendiendo a 159 pacientes de varios municipios.</p>
      </article>

      <article class="activity-card" data-anim="fade-up" data-delay="80" role="listitem">
        <div class="icon" aria-hidden="true"><i class="bi bi-heart-pulse-fill"></i></div>
        <h3>Jornada de salud</h3>
        <p>Realizamos 2 jornadas de salud en Hoctún con detección gratuita de niveles de azúcar, presión arterial, peso, talla, vista y orientación psicológica, beneficiando a 300 personas.</p>
      </article>

      <article class="activity-card" data-anim="fade-up" data-delay="160" role="listitem">
        <div class="icon" aria-hidden="true"><i class="bi bi-easel"></i></div>
        <h3>Talleres de capacitación</h3>
        <p>Con el apoyo de Mentors International, se realizaron cursos de administración básica para pequeños emprendedores en varios municipios, beneficiando a 150 personas.</p>
      </article>

      <article class="activity-card" data-anim="fade-up" data-delay="0" role="listitem">
        <div class="icon" aria-hidden="true"><i class="bi bi-tree"></i></div>
        <h3>Reforestación</h3>
        <p>El Ayuntamiento de Mérida donó 1,666 plantas forestales y maderables a 11 localidades para reforestar predios de producción y traspatio.</p>
      </article>

      <article class="activity-card" data-anim="fade-up" data-delay="80" role="listitem">
        <div class="icon" aria-hidden="true"><i class="bi bi-feather"></i></div>
        <h3>Cría de pavos de engorda</h3>
        <p>Como seguimiento al proyecto iniciado en 2022 con donativos de OXXO que benefició a 350 familias, en 2023 se pudo continuar con el programa de engorda de pavos de traspatio.</p>
      </article>

      <article class="activity-card" data-anim="fade-up" data-delay="160" role="listitem">
        <div class="icon" aria-hidden="true"><i class="bi bi-droplet-half"></i></div>
        <h3>Entrega de tinacos</h3>
        <p>Gracias a la gestión de Ajal Lol y la aportación de Mariana Trinitaria, se llevaron programas de abastecimiento de agua a varias comunidades, beneficiando a más de 400 familias.</p>
      </article>

    </div>
  </div>

</section>

<!-- ======================================================
     PROYECTOS / PORTAFOLIO
     ====================================================== -->
<section id="portfolio" class="section light-bg">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Proyectos</h2>
      <p class="sub">Nuestros <span>proyectos 2024</span></p>
    </div>

    <div class="portfolio-filters" role="tablist" aria-label="Filtrar proyectos" data-anim="fade-up">
      <button class="active" data-filter="*"          role="tab" aria-selected="true">Todo</button>
      <button data-filter=".filter-dental"            role="tab" aria-selected="false">Jornadas dentales</button>
      <button data-filter=".filter-mayo"              role="tab" aria-selected="false">Jornadas de salud</button>
      <button data-filter=".filter-pavo"              role="tab" aria-selected="false">Proyectos productivos</button>
      <button data-filter=".filter-adulto"            role="tab" aria-selected="false">Adulto Mayor</button>
    </div>

    <div class="portfolio-grid" data-anim="fade-up" data-delay="100" role="list">

      <div class="portfolio-item filter-dental" role="listitem">
        <img src="{{ asset('assets/img/img_proy/dental1.jpg') }}" alt="Jornada dental — atención a paciente" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Jornada dental</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen de jornada dental"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-dental" role="listitem">
        <img src="{{ asset('assets/img/img_proy/dental2.jpg') }}" alt="Jornada dental — equipo de voluntarios" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Jornada dental</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen de jornada dental"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-mayo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/may1.jpg') }}" alt="Celebración 10 de mayo con madres de familia" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Celebración del 10 de mayo</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen del 10 de mayo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-mayo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/may2.jpg') }}" alt="Celebración 10 de mayo — actividades" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Celebración del 10 de mayo</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen del 10 de mayo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-pavo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/pavo1.jpg') }}" alt="Programa de engorda de pavo en comunidad maya" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Engorda de pavo</h3>
          <p>Programa en 15 localidades del Estado de Yucatán</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de engorda de pavo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-pavo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/pavo2.jpg') }}" alt="Familias beneficiadas por programa de engorda de pavo" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Engorda de pavo</h3>
          <p>Programa en 15 localidades del Estado de Yucatán</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de engorda de pavo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-pavo" role="listitem">
        <img src="{{ asset('assets/img/img_proy/pavo4.jpg') }}" alt="Entrega de aves en localidades de Yucatán" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Engorda de pavo</h3>
          <p>Programa en 15 localidades del Estado de Yucatán</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de engorda de pavo"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-adulto" role="listitem">
        <img src="{{ asset('assets/img/img_proy/act1.jpg') }}" alt="Día del Adulto Mayor — celebración" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Día del Adulto Mayor</h3>
          <button class="zoom-btn" aria-label="Ampliar imagen del Día del Adulto Mayor"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

      <div class="portfolio-item filter-adulto" role="listitem">
        <img src="{{ asset('assets/img/img_proy/act2.jpg') }}" alt="Activación física para adultos mayores — 27 de agosto" loading="lazy">
        <div class="portfolio-info">
          <h3 style="color:var(--white);font-family:var(--font-display);font-size:1.05rem;font-weight:700">Día del Adulto Mayor</h3>
          <p>Activación física — 27 de agosto</p>
          <button class="zoom-btn" aria-label="Ampliar imagen de activación física"><i class="bi bi-zoom-in" aria-hidden="true"></i></button>
        </div>
      </div>

    </div>
  </div>

  <!-- Lightbox -->
  <div id="lightbox" class="lightbox-overlay"
       role="dialog" aria-modal="true" aria-label="Imagen ampliada">
    <button id="lightbox-close" class="lightbox-close" aria-label="Cerrar imagen">
      <i class="bi bi-x-lg" aria-hidden="true"></i>
    </button>
    <img id="lightbox-img" class="lightbox-img" src="" alt="Imagen del proyecto ampliada">
  </div>

</section>

<!-- ======================================================
     EQUIPO DIRECTIVO
     ====================================================== -->
<section id="team" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Directiva</h2>
      <p class="sub"><span>Comité</span> Directivo</p>
    </div>

    <div class="team-grid" role="list">

      <article class="team-card" data-anim="zoom-in" data-delay="0" role="listitem">
        <div class="member-img">
          <img src="{{ asset('assets/img/team/1.png') }}"
               alt="Fotografía de LEG. Jenevy Ríos Pech, Presidenta" loading="lazy">
        </div>
        <div class="member-info">
          <h3>LEG. Jenevy Ríos Pech</h3>
          <span>Presidenta</span>
        </div>
      </article>

      <article class="team-card" data-anim="zoom-in" data-delay="100" role="listitem">
        <div class="member-img">
          <img src="{{ asset('assets/img/team/4.png') }}"
               alt="Fotografía de Br. Mirna El Pech, Secretaria" loading="lazy">
        </div>
        <div class="member-info">
          <h3>Br. Mirna El Pech</h3>
          <span>Secretaria</span>
        </div>
      </article>

      <article class="team-card" data-anim="zoom-in" data-delay="200" role="listitem">
        <div class="member-img">
          <img src="{{ asset('assets/img/team/3.png') }}"
               alt="Fotografía de Ing. Paula Guadalupe Pech Puc, Tesorera" loading="lazy">
        </div>
        <div class="member-info">
          <h3>Ing. Paula Guadalupe Pech Puc</h3>
          <span>Tesorera</span>
        </div>
      </article>

    </div>
  </div>

</section>

<!-- ======================================================
     MISIÓN / VISIÓN / OBJETIVO / VALORES
     ====================================================== -->
<section id="pricing" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Nuestra Identidad</h2>
      <p class="sub">Los <span>principios</span> que nos guían</p>
    </div>

    <div class="mvov-grid">

      <div class="mvov-card" data-anim="fade-up" data-delay="0">
        <h3><i class="bi bi-bullseye" aria-hidden="true"></i> Misión</h3>
        <ul>
          <li>Impulsar programas que aporten positivamente al desarrollo integral de las familias en situación vulnerable.</li>
        </ul>
      </div>

      <div class="mvov-card" data-anim="fade-up" data-delay="100">
        <h3><i class="bi bi-eye" aria-hidden="true"></i> Visión</h3>
        <ul>
          <li>Ser un referente a nivel nacional como organización que apoya el desarrollo integral en materia de salud y capacitación para el trabajo.</li>
        </ul>
      </div>

      <div class="mvov-card" data-anim="fade-up" data-delay="200">
        <h3><i class="bi bi-flag" aria-hidden="true"></i> Objetivo General</h3>
        <ul>
          <li>Contribuir al mejoramiento de la calidad de vida de las personas que viven en situación vulnerable de las comunidades mayas de Yucatán.</li>
        </ul>
      </div>

      <div class="mvov-card" data-anim="fade-up" data-delay="300">
        <h3><i class="bi bi-heart" aria-hidden="true"></i> Valores</h3>
        <ul>
          <li><strong>Solidaridad:</strong> ser empáticos y atender las necesidades de cada beneficiario.</li>
          <li><strong>Igualdad:</strong> apoyo con amor y respeto, sin distinción.</li>
          <li><strong>Compromiso:</strong> trato digno y trabajo social con pasión.</li>
          <li><strong>Interculturalidad:</strong> apertura para convivir y aprender.</li>
        </ul>
      </div>

    </div>
  </div>

</section>

<!-- ======================================================
     PREGUNTAS FRECUENTES
     ====================================================== -->
<section id="faq" class="section light-bg">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Preguntas Frecuentes</h2>
      <p class="sub">Resolvemos tus <span>dudas</span></p>
    </div>

    <div class="faq-list" data-anim="fade-up" data-delay="100">

      <div class="faq-item">
        <button class="faq-question" aria-expanded="false">
          ¿Te interesa apoyar como colaborador?
          <i class="bi bi-chevron-right" aria-hidden="true"></i>
        </button>
        <div class="faq-answer" role="region">
          <p>En Ajal Lol creemos en el trabajo en equipo y en la participación activa de nuestra comunidad. Si te interesa apoyar como colaborador, esta es tu oportunidad para aportar tus ideas, tiempo y talento, y ser parte de un proyecto que busca generar un impacto positivo y duradero.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" aria-expanded="false">
          ¿Estás interesado en donar?
          <i class="bi bi-chevron-right" aria-hidden="true"></i>
        </button>
        <div class="faq-answer" role="region">
          <p>Desde el corazón, te invitamos a donar. Tu apoyo nos permite seguir ayudando, acompañando y generando esperanza donde más se necesita. Cada donación, por pequeña que sea, transforma vidas.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" aria-expanded="false">
          ¿Eres profesionista y quisieras aportar con tus conocimientos?
          <i class="bi bi-chevron-right" aria-hidden="true"></i>
        </button>
        <div class="faq-answer" role="region">
          <p>Si eres un profesional y deseas aportar tus conocimientos y servicios, ¡te damos la bienvenida! Tu experiencia es valiosa para nuestro equipo en áreas como educación, salud, tecnología o cualquier campo que nos ayude a alcanzar nuestros objetivos.</p>
        </div>
      </div>

    </div>
  </div>

</section>

<!-- ======================================================
     CONTACTO
     ====================================================== -->
<section id="contact" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Contacto</h2>
      <p class="sub">¡<span>Comunícate</span> con nosotros!</p>
    </div>

    <div class="contact-layout">

      <!-- Información de contacto -->
      <div class="contact-info-card" data-anim="fade-right">
        <h3>¿Cómo llegar a nosotros?</h3>

        <address style="font-style:normal">
          <div class="info-item">
            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
            <div>
              <strong>Dirección</strong>
              <p>Calle 24 # 99 x 21 y 19 Col. Centro<br>Hoctún, Yucatán.</p>
              <p style="margin-top:.4rem;font-size:.82rem;color:rgba(255,255,255,.5)">
                Lun–Vie · 9:00 a.m. – 1:00 p.m.
              </p>
            </div>
          </div>

          <div class="info-item">
            <i class="bi bi-telephone-fill" aria-hidden="true"></i>
            <div>
              <strong>Teléfono</strong>
              <p><a href="tel:+529991773532">+52 999 177 3532</a></p>
            </div>
          </div>

          <div class="info-item">
            <i class="bi bi-envelope-fill" aria-hidden="true"></i>
            <div>
              <strong>Correo electrónico</strong>
              <p><a href="/cdn-cgi/l/email-protection#2e4f444f42034241426e46415a434f4742004d4143"><span class="__cf_email__" data-cfemail="7a1b101b16571615163a12150e171b131654191517">[email&#160;protected]</span></a></p>
            </div>
          </div>
        </address>

        <div class="contact-map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.135541053421!2d-89.20775672497321!3d20.866586380742497!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f5691c180ca0e89%3A0x5b9e1228aa43b3ff!2sAjal-Lol%20AC!5e0!3m2!1ses-419!2smx!4v1721704139683!5m2!1ses-419!2smx"
            title="Mapa de ubicación de Ajal Lol A.C. en Hoctún, Yucatán"
            allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <!-- Formulario -->
      <div class="contact-form-card" data-anim="fade-left">
        <h3>Envíanos un mensaje</h3>

        <form id="contact-form" novalidate aria-label="Formulario de contacto">

          <div class="form-row">
            <div class="form-group">
              <label for="name-field">Nombre completo</label>
              <input type="text" id="name-field" name="name"
                     placeholder="Tu nombre" required
                     autocomplete="name">
            </div>
            <div class="form-group">
              <label for="email-field">Correo electrónico</label>
              <input type="email" id="email-field" name="email"
                     placeholder="tu@correo.com" required
                     autocomplete="email">
            </div>
          </div>

          <div class="form-group">
            <label for="phone-field">
              Teléfono <span style="font-weight:400;color:var(--text-light)">(opcional)</span>
            </label>
            <input type="tel" id="phone-field" name="phone"
                   placeholder="+52 999 000 0000"
                   autocomplete="tel">
          </div>

          <div class="form-group">
            <label for="subject-field">Asunto</label>
            <input type="text" id="subject-field" name="subject"
                   placeholder="¿En qué podemos ayudarte?" required>
          </div>

          <div class="form-group">
            <label for="message-field">Mensaje</label>
            <textarea id="message-field" name="message"
                      placeholder="Escribe tu mensaje aquí…" required></textarea>
          </div>

          <button type="submit" class="form-submit">
            <i class="bi bi-send" aria-hidden="true"></i> Enviar mensaje
          </button>

          <p class="form-status" id="js-form-status" role="alert" aria-live="polite"></p>
        </form>
      </div>

    </div>
  </div>

</section>

</main>

<!-- ======================================================
     FOOTER
     ====================================================== -->
<footer id="footer" class="footer" role="contentinfo">

  <!-- Donaciones -->
  <div class="footer-donate">
    <div class="container">
      <h2 class="footer-donate-title" style="font-family:var(--font-display);font-size:2rem;color:var(--white);font-style:italic;margin-bottom:.8rem">
        ¡Tu apoyo transforma vidas!
      </h2>
      <p>Te invitamos a hacer una donación a través de PayPal para ayudarnos a continuar con nuestra labor. Cada aporte, por pequeño que sea, nos acerca más a lograr nuestros objetivos.</p>
      <a href="https://youtu.be/hPr-Yc92qaY?si=MI_Uwro92RhtAPxH"
         class="btn-paypal" target="_blank" rel="noopener noreferrer"
         aria-label="Donar a Ajal Lol a través de PayPal">
        <i class="bi bi-paypal" aria-hidden="true"></i> Donar con PayPal
      </a>
      <p class="thanks">¡Gracias por tu generosidad y por formar parte de esta causa!</p>
    </div>
  </div>

  <!-- Cuerpo del footer -->
  <div class="container footer-main">

    <div class="footer-about">
      <span class="sitename">Ajal-lol A.C.</span>
      <address style="font-style:normal">
        <p>Calle 24 # 99 x 21 y 19 Col. Centro, Hoctún, Yucatán.<br>
           Lun–Vie · 9:00 a.m. – 1:00 p.m.</p>
        <p style="margin-top:.75rem">
          <i class="bi bi-telephone" aria-hidden="true"></i>&nbsp;
          <a href="tel:+529991773532" style="color:inherit">+52 999 177 3532</a><br>
          <i class="bi bi-envelope" aria-hidden="true"></i>&nbsp;
          <a href="/cdn-cgi/l/email-protection#5e3f343f32733231321e36312a333f3732703d3133" style="color:inherit"><span class="__cf_email__" data-cfemail="0e6f646f62236261624e66617a636f6762206d6163">[email&#160;protected]</span></a>
        </p>
      </address>
    </div>

    <nav class="footer-links" aria-label="Mapa del sitio">
      <h4>Enlaces útiles</h4>
      <ul>
        <li><a href="#hero"><i class="bi bi-chevron-right" aria-hidden="true"></i> Inicio</a></li>
        <li><a href="#about"><i class="bi bi-chevron-right" aria-hidden="true"></i> Nosotros</a></li>
        <li><a href="#services"><i class="bi bi-chevron-right" aria-hidden="true"></i> Actividades</a></li>
        <li><a href="#portfolio"><i class="bi bi-chevron-right" aria-hidden="true"></i> Proyectos</a></li>
        <li><a href="#team"><i class="bi bi-chevron-right" aria-hidden="true"></i> Directiva</a></li>
        <li><a href="#contact"><i class="bi bi-chevron-right" aria-hidden="true"></i> Contacto</a></li>
      </ul>
    </nav>

    <div class="footer-social">
      <h4>Síguenos</h4>
      <p style="font-size:.88rem;color:rgba(255,255,255,.5);margin-bottom:.5rem">
        Mantente informado de nuestras actividades.
      </p>
      <div class="social-row" role="list" aria-label="Redes sociales">
        <a href="https://www.facebook.com/p/Ajal-Lol-AC-100064161455063/"
           aria-label="Facebook de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-facebook" aria-hidden="true"></i>
        </a>
        <a href="https://www.instagram.com/ajal_lol/?hl=es-la"
           aria-label="Instagram de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-instagram" aria-hidden="true"></i>
        </a>
        <a href="https://mx.linkedin.com/in/ajal-lol-a-c-103b811a0"
           aria-label="LinkedIn de Ajal Lol" role="listitem"
           target="_blank" rel="noopener noreferrer">
          <i class="bi bi-linkedin" aria-hidden="true"></i>
        </a>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    <div class="container">
      <p>©{{ date('Y') }} <span>Ajal-lol A.C.</span> — Todos los derechos reservados</p>
    </div>
  </div>

</footer>

<!-- ======================================================
     SCROLL TOP
     ====================================================== -->
<a href="#" id="scroll-top" aria-label="Volver al inicio de la página">
  <i class="bi bi-arrow-up-short" aria-hidden="true"></i>
</a>

<!-- ── Bootstrap 5.3 JS ── -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ── JS propio ── -->
<script src="{{ asset('assets/js/editpage/index.js') }}"></script>

</body>
</html>
