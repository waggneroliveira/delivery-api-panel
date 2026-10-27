<section class="columnists-section py-5 bg-accent-color mt-4 position-relative">
  <div class="container">
    
    <!-- Cabeçalho da Seção -->
    <div class="d-flex align-items-end justify-content-between mb-4">
      <div>
        <span class="text-dark fw-bold text-uppercase tracking-wider small py-1 px-3" style="background: rgb(254 245 240);">Opinião & Especialistas</span>
        <h2 class="fw-bold mb-0 mt-2 display-6">Nossos Colunistas</h2>
      </div>
      
      <!-- Navegação Customizada do Swiper -->
      <div class="d-none d-md-flex gap-2">
        <button class="btn btn-outline-primary rounded-circle columnist-prev d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;" aria-label="Anterior">
          <i class="bi bi-arrow-left"></i>
        </button>
        <button class="btn btn-outline-primary rounded-circle columnist-next d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;" aria-label="Próximo">
          <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    <!-- Carrossel Swiper -->
    <div class="swiper columnist-swiper pb-4">
      <div class="swiper-wrapper">

        <!-- Card Colunista 1 -->
        <div class="swiper-slide">
          <div class="card h-100 border-0 shadow-sm rounded-0 p-3 columnist-card">
            <div class="d-flex align-items-center mb-3">
              <div class="position-relative flex-shrink-0">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Ana Silva" class="rounded-circle object-fit-cover">
                <span class="position-absolute bottom-0 end-0 bg-primary rounded-circle border border-2 border-white d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                  <i class="bi bi-check-lg text-white" style="font-size: 10px;"></i>
                </span>
              </div>
              <div class="ms-3">
                <h5 class="card-title mb-0 fw-bold fs-6">Ana Silva</h5>
                <!-- Redes sociais no lugar da badge -->
                <div class="d-flex gap-2 mt-1">
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-linkedin"></i></a>
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-twitter-x"></i></a>
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-instagram"></i></a>
                </div>
              </div>
            </div>
            
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <span class="text-muted small d-block mb-1"><i class="bi bi-journal-text me-1"></i>Última Coluna</span>
                <a href="#" class="text-decoration-none text-dark fw-semibold columnist-article-title font-16">
                  O impacto do Deep Learning no desenvolvimento moderno de softwares
                </a>
              </div>
              <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                <span class="text-muted small">Quintas-feiras</span>
                <button type="button" 
                        class="btn btn-sm btn-link text-dark p-0 fw-semibold text-decoration-none btn-columnist-modal"
                        data-bs-toggle="modal" 
                        data-bs-target="#columnistModal"
                        data-name="Ana Silva"
                        data-img="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80"
                        data-bio="Especialista em Inteligência Artificial e Engenharia de Software com mais de 10 anos de experiência no mercado de tecnologia."
                        data-linkedin="https://linkedin.com"
                        data-twitter="https://twitter.com"
                        data-instagram="https://instagram.com">
                  Ver perfil <i class="bi bi-chevron-right small"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Colunista 2 -->
        <div class="swiper-slide">
          <div class="card h-100 border-0 shadow-sm rounded-0 p-3 columnist-card">
            <div class="d-flex align-items-center mb-3">
              <div class="position-relative flex-shrink-0">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" alt="Carlos Eduardo" class="rounded-circle object-fit-cover">
              </div>
              <div class="ms-3">
                <h5 class="card-title mb-0 fw-bold fs-6">Carlos Eduardo</h5>
                <!-- Redes sociais -->
                <div class="d-flex gap-2 mt-1">
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-linkedin"></i></a>
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-twitter-x"></i></a>
                </div>
              </div>
            </div>
            
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <span class="text-muted small d-block mb-1"><i class="bi bi-journal-text me-1"></i>Última Coluna</span>
                <a href="#" class="text-decoration-none text-dark fw-semibold columnist-article-title font-16">
                  Como preparar sua startup para captar investimento em 2026
                </a>
              </div>
              <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                <span class="text-muted small">Segundas-feiras</span>
                <button type="button" 
                        class="btn btn-sm btn-link text-dark p-0 fw-semibold text-decoration-none btn-columnist-modal"
                        data-bs-toggle="modal" 
                        data-bs-target="#columnistModal"
                        data-name="Carlos Eduardo"
                        data-img="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80"
                        data-bio="Consultor financeiro, investidor anjo e colunista focado em ecossistemas de inovação e venture capital."
                        data-linkedin="https://linkedin.com"
                        data-twitter="https://twitter.com">
                  Ver perfil <i class="bi bi-chevron-right small"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Colunista 3 -->
        <div class="swiper-slide">
          <div class="card h-100 border-0 shadow-sm rounded-0 p-3 columnist-card">
            <div class="d-flex align-items-center mb-3">
              <div class="position-relative flex-shrink-0">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=150&q=80" alt="Mariana Costa" class="rounded-circle object-fit-cover">
              </div>
              <div class="ms-3">
                <h5 class="card-title mb-0 fw-bold fs-6">Mariana Costa</h5>
                <!-- Redes sociais -->
                <div class="d-flex gap-2 mt-1">
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-linkedin"></i></a>
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-instagram"></i></a>
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-globe"></i></a>
                </div>
              </div>
            </div>
            
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <span class="text-muted small d-block mb-1"><i class="bi bi-journal-text me-1"></i>Última Coluna</span>
                <a href="#" class="text-decoration-none text-dark fw-semibold columnist-article-title font-16">
                  A acessibilidade como pilar fundamental no Design System
                </a>
              </div>
              <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                <span class="text-muted small">Sextas-feiras</span>
                <button type="button" 
                        class="btn btn-sm btn-link text-dark p-0 fw-semibold text-decoration-none btn-columnist-modal"
                        data-bs-toggle="modal" 
                        data-bs-target="#columnistModal"
                        data-name="Mariana Costa"
                        data-img="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80"
                        data-bio="Product Designer e pesquisadora de acessibilidade digital, apaixonada por criar experiências inclusivas."
                        data-linkedin="https://linkedin.com"
                        data-instagram="https://instagram.com"
                        data-website="https://marianacosta.design">
                  Ver perfil <i class="bi bi-chevron-right small"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Card Colunista 4 -->
        <div class="swiper-slide">
          <div class="card h-100 border-0 shadow-sm rounded-0 p-3 columnist-card">
            <div class="d-flex align-items-center mb-3">
              <div class="position-relative flex-shrink-0">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80" alt="Lucas Mendes" class="rounded-circle object-fit-cover">
              </div>
              <div class="ms-3">
                <h5 class="card-title mb-0 fw-bold fs-6">Lucas Mendes</h5>
                <!-- Redes sociais -->
                <div class="d-flex gap-2 mt-1">
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-linkedin"></i></a>
                  <a href="#" class="text-secondary hover-primary"><i class="bi bi-twitter-x"></i></a>
                </div>
              </div>
            </div>
            
            <div class="card-body p-0 d-flex flex-column justify-content-between">
              <div>
                <span class="text-muted small d-block mb-1"><i class="bi bi-journal-text me-1"></i>Última Coluna</span>
                <a href="#" class="text-decoration-none text-dark fw-semibold columnist-article-title font-16">
                  Gestão de tempo para equipes assíncronas e remotas
                </a>
              </div>
              <div class="mt-3 pt-3 border-top d-flex align-items-center justify-content-between">
                <span class="text-muted small">Quartas-feiras</span>
                <button type="button" 
                        class="btn btn-sm btn-link text-dark p-0 fw-semibold text-decoration-none btn-columnist-modal"
                        data-bs-toggle="modal" 
                        data-bs-target="#columnistModal"
                        data-name="Lucas Mendes"
                        data-img="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80"
                        data-bio="Agilista e mentor de liderança remota, ajudando empresas a otimizarem fluxos de trabalho distribuídos."
                        data-linkedin="https://linkedin.com"
                        data-twitter="https://twitter.com">
                  Ver perfil <i class="bi bi-chevron-right small"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Paginação para telas menores -->
      <div class="swiper-pagination d-md-none mt-3"></div>
    </div>

  </div>
</section>

<!-- Modal de Perfil do Colunista -->
<div class="modal fade" id="columnistModal" tabindex="-1" aria-labelledby="columnistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-0 overflow-hidden" style="background: rgb(254 245 240);">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body text-center p-4">
        <img id="modalColumnistImg" src="" alt="" class="rounded-circle object-fit-cover mb-3 shadow-sm" width="100" height="100">
        <h4 id="modalColumnistName" class="fw-bold mb-2"></h4>
        <p id="modalColumnistBio" class="text-muted small mb-4 px-2"></p>
        
        <!-- Redes Sociais no Modal -->
        <div id="modalColumnistSocials" class="d-flex justify-content-center gap-3 fs-5">
          <!-- Preenchido via JavaScript -->
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.columnist-swiper .swiper-slide img {
    height: 64px;
    width: 64px;
}

/* Efeito Hover nos Links de Redes Sociais */
.hover-primary {
    transition: color 0.2s ease;
}
.hover-primary:hover {
    color: var(--secondary-color) !important;
}
.btn-outline-primary{
    color:#272a33 !important;
    border-color:#272a33 !important;
}
/* Efeito Hover nos Cards */
.columnist-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    background: rgb(254 245 240);
}

.columnist-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08) !important;
}

.columnist-article-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
    line-height: 20px;
}

.columnist-article-title:hover {
    color: var(--secondary-color) !important;
}

/* Customização da Paginação no Mobile */
.columnist-swiper .swiper-pagination-bullet-active {
    background-color: var(--secondary-color);
    width: 20px;
    border-radius: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Swiper Init
  const columnistSwiper = new Swiper('.columnist-swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    grabCursor: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    navigation: {
      nextEl: '.columnist-next',
      prevEl: '.columnist-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      576: { slidesPerView: 2, spaceBetween: 20 },
      992: { slidesPerView: 3, spaceBetween: 24 },
      1200: { slidesPerView: 4, spaceBetween: 24 },
    },
  });

  // Lógica do Modal Dinâmico
  const columnistModal = document.getElementById('columnistModal');
  if (columnistModal) {
    columnistModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      
      const name = button.getAttribute('data-name');
      const img = button.getAttribute('data-img');
      const bio = button.getAttribute('data-bio');
      
      const linkedin = button.getAttribute('data-linkedin');
      const twitter = button.getAttribute('data-twitter');
      const instagram = button.getAttribute('data-instagram');
      const website = button.getAttribute('data-website');

      // Preenche os campos estáticos
      document.getElementById('modalColumnistName').textContent = name;
      document.getElementById('modalColumnistImg').src = img;
      document.getElementById('modalColumnistImg').alt = name;
      document.getElementById('modalColumnistBio').textContent = bio;

      // Monta as redes sociais ativas
      const socialsContainer = document.getElementById('modalColumnistSocials');
      socialsContainer.innerHTML = '';

      if (linkedin) {
        socialsContainer.innerHTML += `<a href="${linkedin}" target="_blank" rel="noopener" class="text-secondary hover-primary"><i class="bi bi-linkedin"></i></a>`;
      }
      if (twitter) {
        socialsContainer.innerHTML += `<a href="${twitter}" target="_blank" rel="noopener" class="text-secondary hover-primary"><i class="bi bi-twitter-x"></i></a>`;
      }
      if (instagram) {
        socialsContainer.innerHTML += `<a href="${instagram}" target="_blank" rel="noopener" class="text-secondary hover-primary"><i class="bi bi-instagram"></i></a>`;
      }
      if (website) {
        socialsContainer.innerHTML += `<a href="${website}" target="_blank" rel="noopener" class="text-secondary hover-primary"><i class="bi bi-globe"></i></a>`;
      }
    });
  }
});
</script>