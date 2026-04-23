<section id="hero" class="hero section" aria-label="Presentación principal">

  <div class="hero-circle hero-circle-1"></div>
  <div class="hero-circle hero-circle-2"></div>
  <div class="hero-circle hero-circle-3"></div>

  <div class="container">
    <div class="hero-content">

      @if(!empty($hero_data->eyebrow))
      <p class="hero-eyebrow">{{ $hero_data->eyebrow }}</p>
      @endif

      <h1>
        {{ $hero_data->titulo_principal ?: 'Título no disponible' }}
        @if(!empty($hero_data->titulo_em))
        <em>{{ $hero_data->titulo_em }}</em>
        @endif
      </h1>

      <p>{{ $hero_data->descripcion ?: 'Texto no disponible' }}</p>

      <div class="hero-buttons">

        <!-- BOTÓN CONOCE MÁS -->
        <a href="#about" class="btn-rose">
          <i class="bi bi-heart-fill"></i>
          Conoce más
        </a>

        <!-- BOTÓN VER VIDEOS -->
        @if($hero_videos->isNotEmpty())
        <button id="openVideosModal" class="btn-rose-outline">
          <i class="bi bi-play-circle"></i>
          Ver videos
        </button>
        @endif

      </div>
    </div>
  </div>

  <!-- MODAL -->
  @if($hero_videos->isNotEmpty())
  <div id="videosModal" class="videos-modal">
    <div class="videos-modal-content">

      <button id="closeVideosModal" class="videos-close">&times;</button>

      <h3>Videos</h3>

      <div class="videos-grid">
        @foreach($hero_videos as $video)
          <div class="video-item" data-url="{{ $video->youtube_url }}">
            <img src="https://img.youtube.com/vi/{{ preg_replace('/.*v=([^&]+)/', '$1', $video->youtube_url) }}/0.jpg">
            <p>{{ $video->titulo }}</p>
          </div>
        @endforeach
      </div>

      <div id="videoPlayer"></div>

    </div>
  </div>
  @endif

  <div class="hero-scroll">
    <div class="hero-scroll-line"></div>
    <span>Scroll</span>
  </div>
<script>
document.addEventListener("DOMContentLoaded", () => {

  const modal = document.getElementById("videosModal");
  const openBtn = document.getElementById("openVideosModal");
  const closeBtn = document.getElementById("closeVideosModal");
  const player = document.getElementById("videoPlayer");

  if(openBtn){
    openBtn.addEventListener("click", () => {
      modal.classList.add("active");
    });
  }

  if(closeBtn){
    closeBtn.addEventListener("click", () => {
      modal.classList.remove("active");
      player.innerHTML = "";
    });
  }

  document.querySelectorAll(".video-item").forEach(item => {
    item.addEventListener("click", () => {
      const url = item.dataset.url;
      const videoId = url.split("v=")[1]?.split("&")[0];

      player.innerHTML = `
        <iframe src="https://www.youtube.com/embed/${videoId}" allowfullscreen></iframe>
      `;
    });
  });

});
</script>
</section>