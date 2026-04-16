<section id="services" class="section">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Actividades</h2>
      <p class="sub">Nuestras <span class="year-label-inline">Actividades 2023</span></p>
    </div>

    {{-- ── Selector de años ── --}}
    <div class="year-selector" data-anim="fade-up" role="tablist" aria-label="Seleccionar año de actividades">

      {{-- Años anteriores como "..." --}}
      <div class="year-selector__dots" id="yearDots">
        <button class="year-btn year-btn--dots" id="dotsToggle" aria-expanded="false" aria-haspopup="listbox" title="Ver años anteriores">
          <span>···</span>
        </button>
        {{-- Dropdown de años anteriores --}}
        <div class="year-dropdown" id="yearDropdown" role="listbox" aria-label="Años anteriores">
          <button class="year-dropdown__item" data-year="2020" role="option">2020</button>
          <button class="year-dropdown__item" data-year="2021" role="option">2021</button>
          <button class="year-dropdown__item" data-year="2022" role="option">2022</button>
        </div>
      </div>

      <div class="year-selector__divider" aria-hidden="true"></div>

      {{-- Años principales visibles --}}
      <button class="year-btn" data-year="2023" role="tab" aria-selected="true">2023</button>
      <button class="year-btn" data-year="2024" role="tab" aria-selected="false">2024</button>
      <button class="year-btn" data-year="2025" role="tab" aria-selected="false">2025</button>

    </div>

    {{-- ── Grid de actividades ── --}}
    <div class="activities-grid" role="list" id="activitiesGrid">

      {{-- Las tarjetas se renderizan dinámicamente según el año activo --}}
      {{-- Por defecto se muestran las de 2023 --}}

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