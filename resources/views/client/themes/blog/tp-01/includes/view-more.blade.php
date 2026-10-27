@if ($blogRelacionados->count() > 0)
    <!-- Veja Também / Posts Relacionados Start -->
    <div class="related-posts-widget mb-0 overflow-hidden">
        <div class="related-posts-card p-3">

            {{-- Cabeçalho do Widget --}}
            <div class="related-posts-header pb-3 mb-3 border-bottom d-flex align-items-center gap-2">
                <div class="related-icon-badge">
                    <i class="bi bi-newspaper text-dark"></i>
                </div>
                <h4 class="m-0 poppins-bold font-18 title-aside">Veja também</h4>
            </div>

            {{-- Lista de Posts Relacionados --}}
            <div class="related-posts-list d-flex flex-column gap-2">
                @foreach($blogRelacionados as $index => $relacionado)
                    @php
                        if ($relacionado->path_image_thumbnail) {
                            if (\Illuminate\Support\Str::startsWith($relacionado->path_image_thumbnail, ['http://', 'https://'])) {
                                $imagemRelacionadoUrl = $relacionado->path_image_thumbnail;
                            } else {
                                $imagemRelacionadoUrl = asset('storage/' . $relacionado->path_image_thumbnail);
                            }
                        } else {
                            $imagemRelacionadoUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';
                        }
                    @endphp

                    <article class="related-post-item {{ $index >= 5 ? 'rel-item d-none' : '' }}">
                        <a href="{{ route('blog-inner', ['slug' => $relacionado->slug]) }}" class="related-post-link">
                            {{-- Thumbnail --}}
                            <div class="related-post-thumb">
                                <img loading="lazy"
                                     src="{{ $imagemRelacionadoUrl }}"
                                     alt="{{ $relacionado->title ?? 'Post relacionado' }}">
                            </div>

                            {{-- Conteúdo / Título --}}
                            <div class="related-post-info">
                                <h5 class="related-post-title poppins-semiBold">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($relacionado->title), 65) }}
                                </h5>
                                @if(isset($relacionado->date))
                                    <span class="related-post-date">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($relacionado->date)->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            {{-- Botão Expandir / Ver Mais --}}
            @if(count($blogRelacionados) > 5)
                <div class="text-center mt-3 pt-2 border-top">
                    <button type="button" id="btn-ver-mais" class="btn btn-ver-mais bg-button-one color-button-one w-100 poppins-medium font-13">
                        <span>Ver mais conteúdos</span>
                        <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                </div>
            @endif

        </div>
    </div>
    <!-- Veja Também End -->
@endif

<style>
    /* ===================================
       ESTILOS DO WIDGET VEJA TAMBÉM
    =================================== */

    .related-icon-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    /* Links e Cards da Lista */
    .related-post-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px;
        text-decoration: none !important;
        background: rgb(254 245 240);
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
    }

    .related-post-link:hover {
        border-color: #cbd5e1;
        transform: translateX(3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Thumbnail da notícia */
    .related-post-thumb {
        width: 54px;
        height: 54px;
        overflow: hidden;
        flex-shrink: 0;
        background: #cbd5e1;
    }

    .related-post-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .related-post-link:hover .related-post-thumb img {
        transform: scale(1.08);
    }

    /* Título e Meta */
    .related-post-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
        min-width: 0; /* Garante que o text-overflow funcione se necessário */
    }

    .related-post-title {
        font-size: 13px;
        line-height: 1.35;
        color: #1e293b;
        margin: 0;
        transition: color 0.2s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-post-date {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 3px;
    }

    /* Botão Ver Mais */
    .btn-ver-mais {
        border-radius: 0px;
        padding: 8px 16px;
        transition: all 0.2s ease;
    }

    .btn-ver-mais:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #cbd5e1;
    }
</style>

<script defer>
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("btn-ver-mais");
        if (!btn) return;

        btn.addEventListener("click", function () {
            const hiddenItems = document.querySelectorAll(".rel-item");
            const isExpanding = hiddenItems[0].classList.contains("d-none");

            if (isExpanding) {
                hiddenItems.forEach(el => el.classList.remove("d-none"));
                btn.querySelector("span").textContent = "Recolher conteúdos";
                btn.querySelector("i").className = "bi bi-chevron-up ms-1";
            } else {
                hiddenItems.forEach(el => el.classList.add("d-none"));
                btn.querySelector("span").textContent = "Ver mais conteúdos";
                btn.querySelector("i").className = "bi bi-chevron-down ms-1";
            }
        });
    });
</script>