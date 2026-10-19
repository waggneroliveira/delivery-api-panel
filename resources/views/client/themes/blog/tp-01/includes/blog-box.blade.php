@foreach($blogAll as $blog)
    <div class="col-12 col-sm-6 col-lg-4 mt-0 mb-4">
        <article class="card h-100 border-0 rounded-0 custom-blog-card">
            <a href="{{ route('blog-inner', ['slug' => $blog->slug]) }}" class="text-decoration-none d-flex flex-column h-100">
                
                <!-- Container da Imagem Perfeitamente Quadrada (Ratio 1x1) -->
                <div class="position-relative overflow-hidden custom-img-wrapper m-auto">
                    <img
                        src="{{ $blog->path_image_thumbnail ? asset('storage/' . $blog->path_image_thumbnail) : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                        alt="{{ $blog->title }}" 
                        class="img-fluid object-fit-cover custom-blog-img w-100 h-100" 
                        loading="lazy"
                     >
                    <!-- Tag de Data Estilizada -->
                    <div class="position-absolute bottom-0 start-0 m-3">
                        <span class="custom-badge font-12 font-semibold text-uppercase tracking-wider">                          
                            
                           {{ $blog->category->title }}
                        </span>
                    </div>
                </div>

                <!-- Conteúdo do Card em Bloco Quadrado -->
                <div class="card-body p-3 d-flex flex-column justify-content-between flex-grow-1 custom-card-body">
                    <div>
                        <h3 class="card-title font-16 font-bold mb-1 custom-title">
                           {{ $blog->title }}
                        </h3>

                        <small>
                           {{ \Carbon\Carbon::parse($blog->date)->translatedFormat('d \d\e F \d\e Y') }}
                           
                        </small>

                        @if ($blog->text <> null)                            
                            <p class="card-text font-12 font-regular my-3 custom-excerpt">
                                {{ substr(strip_tags($blog->text),0 ,60) }}
                            </p>
                        @endif
                    </div>

                    <!-- Rodapé do Card / Ação -->
                    <div class="pt-3 border-top custom-border-top d-flex align-items-center justify-content-between font-14 font-semibold custom-link">
                        <span>Ler artigo</span>
                        <i class="bi bi-arrow-right custom-arrow"></i>
                    </div>
                </div>

            </a>
        </article>
    </div>
@endforeach

<style>
   /* Variáveis da Paleta de Cores do Projeto */
   :root {
      --bg-body-color: #fcf2e6;
      --bg-card-color: #f0e0d0;
      --text-dark-color: #272a33;
   }

   body {
      background-color: var(--bg-body-color);
   }

   /* Card Quadrado em Bloco Solido */
   .custom-blog-card {
      background-color: var(--bg-card-color);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
   }

   .custom-blog-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(39, 42, 51, 0.08) !important;
   }

   /* Imagem e Enquadramento Quadrado (Ratio 1x1) */
   .custom-img-wrapper {
      background-color: #e5d3c0;
      height: 200px;
      width: 100%;
   }

   .custom-blog-img {
      transition: transform 0.4s ease;
   }

   .custom-blog-card:hover .custom-blog-img {
      transform: scale(1.05);
   }

   /* Badge de Data Flutuante */
   .custom-badge {
      background-color: var(--text-dark-color);
      color: var(--bg-body-color);
      padding: 6px 12px;
   }

   /* Tipografia e Textos */
   .custom-card-body {
      color: var(--text-dark-color);
   }

   .custom-title {
      color: var(--text-dark-color);
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      line-height: 1.3;
   }

   .custom-excerpt {
      color: rgba(39, 42, 51, 0.75);
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      line-height: 1.5;
   }

   /* Borda e Link */
   .custom-border-top {
      border-color: rgba(39, 42, 51, 0.12) !important;
   }

   .custom-link {
      color: var(--text-dark-color);
   }

   .custom-arrow {
      transition: transform 0.25s ease;
   }

   .custom-blog-card:hover .custom-arrow {
      transform: translateX(6px);
   }
</style>