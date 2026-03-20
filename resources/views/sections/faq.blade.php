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
          <span class="faq-toggle"><i class="bi bi-chevron-right"></i></span>
        </button>
        <div class="faq-answer" role="region">
          <p>En Ajal Lol creemos en el trabajo en equipo y en la participación activa de nuestra comunidad. Si te interesa apoyar como colaborador, esta es tu oportunidad para aportar tus ideas, tiempo y talento, y ser parte de un proyecto que busca generar un impacto positivo y duradero.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" aria-expanded="false">
          ¿Estás interesado en donar?
          <span class="faq-toggle"><i class="bi bi-chevron-right"></i></span>
        </button>
        <div class="faq-answer" role="region">
          <p>Desde el corazón, te invitamos a donar. Tu apoyo nos permite seguir ayudando, acompañando y generando esperanza donde más se necesita. Cada donación, por pequeña que sea, transforma vidas.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question" aria-expanded="false">
          ¿Eres profesionista y quisieras aportar con tus conocimientos?
          <span class="faq-toggle"><i class="bi bi-chevron-right"></i></span>
        </button>
        <div class="faq-answer" role="region">
          <p>Si eres un profesional y deseas aportar tus conocimientos y servicios, ¡te damos la bienvenida! Tu experiencia es valiosa para nuestro equipo en áreas como educación, salud, tecnología o cualquier campo que nos ayude a alcanzar nuestros objetivos.</p>
        </div>
      </div>

    </div>
  </div>

</section>
<script>
document.querySelectorAll('.faq-question').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var item = btn.closest('.faq-item');
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item').forEach(function(i) {
      i.classList.remove('open');
    });
    if (!isOpen) {
      item.classList.add('open');
    }
  });
});
</script>