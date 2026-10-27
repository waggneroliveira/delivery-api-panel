@extends($theme->core('client'))
@section('content')
  <div class="container">
      <nav class="breadcrumb mb-2">Início &nbsp;›&nbsp; Eletrônicos</nav>
      <div class="row g-4">
          <aside class="col-lg-3">
              <div class="filters p-3 sticky-lg-top" style="top: 20px">
                  <h5 class="fw-bold mb-3">Filtros</h5>
                  <div class="mb-4">
                      <div class="filter-title mb-2">Categorias</div>
                      <div class="small lh-lg">
                          Smartphones (48) ›<br />Notebooks (36) ›<br />Fones de Ouvido (42) ›<br />Smartwatches
                          (28) ›<br />Acessórios (120) ›<br />Áudio (38) ›
                      </div>
                  </div>
                  <hr />
                  <div class="mb-4">
                      <div class="filter-title mb-3">Faixa de preço</div>
                      <div class="range-line mb-3"></div>
                      <div class="d-flex justify-content-between small">
                          <span>R$ 59</span><span>R$ 7.999</span>
                      </div>
                  </div>
                  <hr />
                  <div class="mb-4">
                      <div class="filter-title mb-2">Marcas</div>
                      <div class="form-check small">
                          <input class="form-check-input" type="checkbox" /><label class="form-check-label"
                              >Samsung</label
                          >
                      </div>
                      <div class="form-check small">
                          <input class="form-check-input" type="checkbox" /><label class="form-check-label"
                              >Apple</label
                          >
                      </div>
                      <div class="form-check small">
                          <input class="form-check-input" type="checkbox" /><label class="form-check-label"
                              >Xiaomi</label
                          >
                      </div>
                      <div class="form-check small">
                          <input class="form-check-input" type="checkbox" /><label class="form-check-label"
                              >Motorola</label
                          >
                      </div>
                      <div class="form-check small">
                          <input class="form-check-input" type="checkbox" /><label class="form-check-label"
                              >Philips</label
                          >
                      </div>
                  </div>
                  <hr />
                  <div>
                      <div class="filter-title mb-2">Avaliação</div>
                      <div class="stars lh-lg">★★★★★<br />★★★★☆<br />★★★☆☆<br />★★☆☆☆</div>
                  </div>
              </div>
          </aside>

          <section class="col-lg-9">
              <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-3">
                  <div>
                      <h1 class="section-title mb-1">Eletrônicos</h1>
                      <p class="text-secondary mb-0">312 produtos encontrados</p>
                  </div>
                  <div class="d-flex gap-2 align-items-center">
                      <span class="small">Ordenar por:</span
                      ><select class="form-select form-select-sm" style="width: 160px">
                          <option>Mais vendidos</option>
                          <option>Menor preço</option>
                          <option>Maior preço</option>
                          <option>Novidades</option>
                      </select>
                  </div>
              </div>
              <div class="d-flex flex-wrap gap-2 mb-3">
                  <span class="badge text-bg-light border p-2">Smartphones ×</span
                  ><span class="badge text-bg-light border p-2">Em estoque ×</span
                  ><a class="small align-self-center" href="#">Limpar filtros</a>
              </div>
              <div class="row g-3 product-grid">
                  <div class="col-6 col-lg-3">
                      <article class="product-card">
                          <span class="discount">-23%</span>
                          <button class="wishlist">♡</button>
                          <img
                              src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                              class="product-img"
                              alt="Smartphone Samsung Galaxy S24 128GB 5G - Preto"
                          />
                          <div class="small text-secondary">Eletrônicos</div>
                          <h3 class="fs-6 fw-bold mt-1 mb-2">
                              Smartphone Samsung Galaxy S24 128GB 5G - Preto
                          </h3>
                          <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                          <div class="old-price">R$ 4.599,00</div>
                          <div class="d-flex align-items-center justify-content-between gap-2">
                              <div>
                                  <div class="price">R$ 3.499,00</div>
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

                  <div class="col-6 col-lg-3">
                      <article class="product-card">
                          <span class="discount">-10%</span>
                          <button class="wishlist">♡</button>
                          <img
                              src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=600&q=80"
                              class="product-img"
                              alt="Smartwatch Apple Watch Series 9"
                          />
                          <div class="small text-secondary">Eletrônicos</div>
                          <h3 class="fs-6 fw-bold mt-1 mb-2">Smartwatch Apple Watch Series 9</h3>
                          <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                          <div class="old-price">R$ 4.599,00</div>
                          <div class="d-flex align-items-center justify-content-between gap-2">
                              <div>
                                  <div class="price">R$ 2.699,00</div>
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
                              src="https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?auto=format&fit=crop&w=600&q=80"
                              class="product-img"
                              alt="Fone de Ouvido Galaxy Buds2 Pro"
                          />
                          <div class="small text-secondary">Eletrônicos</div>
                          <h3 class="fs-6 fw-bold mt-1 mb-2">Fone de Ouvido Galaxy Buds2 Pro</h3>
                          <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                          <div class="old-price">R$ 4.599,00</div>
                          <div class="d-flex align-items-center justify-content-between gap-2">
                              <div>
                                  <div class="price">R$ 899,00</div>
                                  <div class="small text-secondary">10x sem juros</div>
                              </div>
                              <button class="cart-mini">🛒</button>
                          </div>
                      </article>
                  </div>

                  <div class="col-6 col-lg-3">
                      <article class="product-card">
                          <span class="discount">-12%</span>
                          <button class="wishlist">♡</button>
                          <img
                              src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=600&q=80"
                              class="product-img"
                              alt="Caixa de Som Bluetooth"
                          />
                          <div class="small text-secondary">Eletrônicos</div>
                          <h3 class="fs-6 fw-bold mt-1 mb-2">Caixa de Som Bluetooth</h3>
                          <div class="stars mb-2">★★★★★ <span class="text-secondary">(245)</span></div>
                          <div class="old-price">R$ 4.599,00</div>
                          <div class="d-flex align-items-center justify-content-between gap-2">
                              <div>
                                  <div class="price">R$ 699,00</div>
                                  <div class="small text-secondary">10x sem juros</div>
                              </div>
                              <button class="cart-mini">🛒</button>
                          </div>
                      </article>
                  </div>
              </div>
              <nav class="mt-4">
                  <ul class="pagination justify-content-center">
                      <li class="page-item"><a class="page-link" href="#">‹</a></li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">…</a></li>
                      <li class="page-item"><a class="page-link" href="#">13</a></li>
                      <li class="page-item"><a class="page-link" href="#">›</a></li>
                  </ul>
              </nav>
          </section>
      </div>
  </div>
@endsection