{{-- @extends($theme->core('client')) --}}
@extends('client.themes.ecommerce.tp-01.core.client')

@section('content')
    <div class="container">
      <nav class="breadcrumb mb-4">Início › Eletrônicos › Smartphones › Samsung Galaxy S24</nav>
      <div class="row g-4">
          <div class="col-lg-6">
              <div class="detail-gallery p-3">
                  <div class="row g-3">
                      <div class="col-2 d-flex flex-column gap-2">
                          <img
                              class="thumb active"
                              src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                              alt=""
                          />
                          <img
                              class="thumb"
                              src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                              alt=""
                          />
                          <img
                              class="thumb"
                              src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                              alt=""
                          />
                          <img
                              class="thumb"
                              src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                              alt=""
                          />
                      </div>
                      <div class="col-10">
                          <img
                              class="detail-main-img"
                              src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                              alt="Samsung Galaxy S24"
                          />
                      </div>
                  </div>
              </div>
              <div class="info-card mt-3">
                  <strong>Calcule o frete e prazo de entrega</strong>
                  <div class="input-group mt-2">
                      <input class="form-control" placeholder="Digite seu CEP" /><button
                          class="btn btn-outline-primary"
                      >
                          Calcular
                      </button>
                  </div>
              </div>
          </div>

          <div class="col-lg-6">
              <div class="buy-box">
                  <span class="badge bg-success-subtle text-success mb-2">Novo</span>
                  <h1 class="detail-title h2">Smartphone Samsung Galaxy S24 128GB 5G - Preto</h1>
                  <div class="stars mb-3">★★★★★ <span class="text-secondary">4.8 (245 avaliações)</span></div>
                  <p class="text-secondary">
                      Desempenho poderoso, câmera de alta resolução e bateria inteligente para o seu dia a
                      dia.
                  </p>
                  <div class="row g-2 small mb-3">
                      <div class="col-6 col-lg-3">📱 <strong>Tela 6.2"</strong></div>
                      <div class="col-6 col-lg-3">📷 <strong>Câmera tripla</strong></div>
                      <div class="col-6 col-lg-3">🔋 <strong>4000mAh</strong></div>
                      <div class="col-6 col-lg-3">💾 <strong>128GB</strong></div>
                  </div>
                  <hr />
                  <div class="old-price">R$ 4.599,00</div>
                  <div class="detail-price">R$ 3.499,00</div>
                  <div class="small text-secondary mb-3">ou 10x de R$ 349,90 sem juros</div>
                  <div class="mb-3">
                      <strong>Cor: Preto</strong>
                      <div class="d-flex gap-2 mt-2">
                          <span class="color-dot bg-dark"></span
                          ><span class="color-dot" style="background: #b8c7bd"></span
                          ><span class="color-dot" style="background: #d9d8e8"></span>
                      </div>
                  </div>
                  <div class="text-success small fw-bold mb-3">✓ Em estoque</div>
                  <div class="d-flex gap-2 mb-2">
                      <div class="qty d-flex align-items-center">
                          <button>-</button><span class="px-3">1</span><button>+</button>
                      </div>
                      <button class="btn-sf flex-grow-1">🛒 Adicionar ao carrinho</button>
                  </div>
                  <button class="btn btn-outline-primary w-100 py-2 fw-bold">Comprar agora</button>
              </div>
          </div>
      </div>

      <section class="py-4">
          <div class="row g-3">
              <div class="col-6 col-lg-3">
                  <div class="info-card text-center">
                      <div class="fs-4">🚚</div>
                      <strong>Frete grátis</strong
                      ><small class="d-block text-secondary">Para todo o Brasil</small>
                  </div>
              </div>
              <div class="col-6 col-lg-3">
                  <div class="info-card text-center">
                      <div class="fs-4">↩️</div>
                      <strong>Devolução grátis</strong
                      ><small class="d-block text-secondary">Até 7 dias</small>
                  </div>
              </div>
              <div class="col-6 col-lg-3">
                  <div class="info-card text-center">
                      <div class="fs-4">🔒</div>
                      <strong>Compra segura</strong
                      ><small class="d-block text-secondary">Dados protegidos</small>
                  </div>
              </div>
              <div class="col-6 col-lg-3">
                  <div class="info-card text-center">
                      <div class="fs-4">👤</div>
                      <strong>Atendimento</strong
                      ><small class="d-block text-secondary">Suporte especializado</small>
                  </div>
              </div>
          </div>
      </section>

      <section class="info-card mb-5">
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#desc">
                      Descrição
                  </button>
              </li>
              <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#spec">Especificações</button>
              </li>
              <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">
                      Avaliações (245)
                  </button>
              </li>
              <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faq">
                      Perguntas Frequentes
                  </button>
              </li>
          </ul>
          <div class="tab-content pt-4">
              <div class="tab-pane fade show active" id="desc">
                  <h4 class="fw-bold">Samsung Galaxy S24 5G</h4>
                  <p class="text-secondary">
                      Design elegante, desempenho de ponta e recursos inteligentes para transformar sua
                      rotina. Processador potente, câmera de alta resolução e tela AMOLED vibrante.
                  </p>
                  <ul class="text-secondary">
                      <li>Processador de alta performance</li>
                      <li>Câmera tripla com alta resolução</li>
                      <li>Tela Dynamic AMOLED 2X</li>
                      <li>Bateria de 4000mAh</li>
                      <li>Resistência à água e poeira IP68</li>
                  </ul>
              </div>
              <div class="tab-pane fade" id="spec">
                  <div class="row">
                      <div class="col-md-6">
                          Memória: <strong>8GB RAM</strong><br />Armazenamento: <strong>128GB</strong>
                      </div>
                      <div class="col-md-6">
                          Tela: <strong>6.2"</strong><br />Conectividade: <strong>5G</strong>
                      </div>
                  </div>
              </div>
              <div class="tab-pane fade" id="reviews">
                  <p>★★★★★ <strong>4.8/5</strong> baseado em 245 avaliações.</p>
              </div>
              <div class="tab-pane fade" id="faq">
                  <p>
                      <strong>Qual o prazo de entrega?</strong><br />O prazo é calculado de acordo com seu
                      CEP.
                  </p>
              </div>
          </div>
      </section>

      <section class="pb-5">
          <div class="d-flex justify-content-between mb-3">
              <h2 class="section-title">Produtos relacionados</h2>
              <a href="produtos.blade.php" class="text-primary fw-bold">Ver todos →</a>
          </div>
          <div class="row g-3">
              <div class="col-6 col-lg-3">
                  <article class="product-card">
                      <span class="discount">Novo</span>
                      <button class="wishlist">♡</button>
                      <img
                          src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80"
                          class="product-img"
                          alt="Smartphone Motorola Edge 40 Neo 256GB 5G"
                      />
                      <div class="small text-secondary">Eletrônicos</div>
                      <h3 class="fs-6 fw-bold mt-1 mb-2">Smartphone Motorola Edge 40 Neo 256GB 5G</h3>
                      <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                      <div class="old-price">R$ 4.599,00</div>
                      <div class="d-flex align-items-center justify-content-between gap-2">
                          <div>
                              <div class="price">R$ 2.299,00</div>
                              <div class="small text-secondary">10x sem juros</div>
                          </div>
                          <button class="cart-mini">🛒</button>
                      </div>
                  </article>
              </div>

              <div class="col-6 col-lg-3">
                  <article class="product-card">
                      <span class="discount">-18%</span>
                      <button class="wishlist">♡</button>
                      <img
                          src="https://images.unsplash.com/photo-1591337676887-a217a6970a8a?auto=format&fit=crop&w=600&q=80"
                          class="product-img"
                          alt="iPhone 14 128GB Meia-noite"
                      />
                      <div class="small text-secondary">Eletrônicos</div>
                      <h3 class="fs-6 fw-bold mt-1 mb-2">iPhone 14 128GB Meia-noite</h3>
                      <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                      <div class="old-price">R$ 4.599,00</div>
                      <div class="d-flex align-items-center justify-content-between gap-2">
                          <div>
                              <div class="price">R$ 4.899,00</div>
                              <div class="small text-secondary">10x sem juros</div>
                          </div>
                          <button class="cart-mini">🛒</button>
                      </div>
                  </article>
              </div>

              <div class="col-6 col-lg-3">
                  <article class="product-card">
                      <span class="discount">Novo</span>
                      <button class="wishlist">♡</button>
                      <img
                          src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80"
                          class="product-img"
                          alt="Notebook Dell Inspiron 15"
                      />
                      <div class="small text-secondary">Eletrônicos</div>
                      <h3 class="fs-6 fw-bold mt-1 mb-2">Notebook Dell Inspiron 15</h3>
                      <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                      <div class="old-price">R$ 4.599,00</div>
                      <div class="d-flex align-items-center justify-content-between gap-2">
                          <div>
                              <div class="price">R$ 2.599,00</div>
                              <div class="small text-secondary">10x sem juros</div>
                          </div>
                          <button class="cart-mini">🛒</button>
                      </div>
                  </article>
              </div>

              <div class="col-6 col-lg-3">
                  <article class="product-card">
                      <span class="discount">-15%</span>
                      <button class="wishlist">♡</button>
                      <img
                          src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80"
                          class="product-img"
                          alt="Headphone Bluetooth"
                      />
                      <div class="small text-secondary">Eletrônicos</div>
                      <h3 class="fs-6 fw-bold mt-1 mb-2">Headphone Bluetooth</h3>
                      <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                      <div class="old-price">R$ 4.599,00</div>
                      <div class="d-flex align-items-center justify-content-between gap-2">
                          <div>
                              <div class="price">R$ 339,00</div>
                              <div class="small text-secondary">10x sem juros</div>
                          </div>
                          <button class="cart-mini">🛒</button>
                      </div>
                  </article>
              </div>
          </div>
      </section>
    </div>
@endsection