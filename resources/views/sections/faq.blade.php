<section id="faq" class="section light-bg">

  <div class="container">
    <div class="section-title" data-anim="fade-up">
      <h2>Preguntas Frecuentes</h2>
      <p class="sub">Resolvemos tus <span>dudas</span></p>
    </div>

    <div class="faq-list" data-anim="fade-up" data-delay="100">

      @forelse($preguntas as $pregunta)
      <div class="faq-item">
        <button class="faq-question" aria-expanded="false">
          {{ $pregunta->titulo_pregunta }}
          <span class="faq-toggle"><i class="bi bi-chevron-right"></i></span>
        </button>
        <div class="faq-answer" role="region">
          <p>{{ $pregunta->texto_respuesta }}</p>
        </div>
      </div>
      @empty
      {{-- Sin preguntas en BD — no mostrar nada o mensaje opcional --}}
      @endforelse

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
      i.querySelector('.faq-question')?.setAttribute('aria-expanded', 'false');
    });
    if (!isOpen) {
      item.classList.add('open');
      btn.setAttribute('aria-expanded', 'true');
    }
  });
});
</script>