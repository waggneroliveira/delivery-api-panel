@extends($theme->core('client'))
@section('content')
    <section class="hero">
        <div class="container h-100">
            <div class="row align-items-center min-vh-50 py-5">
                <div class="col-lg-6 position-relative z-2">
                    <span class="badge-soft mb-3">OS MELHORES PRODUTOS</span>
                    <h1>Tecnologia que <span>move o seu mundo</span></h1>
                    <p class="lead opacity-75">
                        Produtos desejados, marcas confiáveis e condições especiais para você.
                    </p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="produtos.blade.php" class="btn-sf">Ver ofertas →</a>
                        <a href="#" class="btn btn-outline-light rounded-3 px-4">Comprar agora</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img
                        class="hero-product"
                        src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=600&q=80"
                        alt="Produto em destaque"
                    />
                </div>
            </div>
        </div>
    </section>

    <section class="benefit-strip">
        <div class="container">
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="benefit text-center">
                        <i>🚚</i><strong class="d-block">Frete grátis</strong
                        ><small class="text-secondary">Para todo o Brasil</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="benefit text-center">
                        <i>💳</i><strong class="d-block">Até 10x sem juros</strong
                        ><small class="text-secondary">No cartão</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="benefit text-center">
                        <i>↩️</i><strong class="d-block">7 dias para devolução</strong
                        ><small class="text-secondary">Troca garantida</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="benefit text-center">
                        <i>🔒</i><strong class="d-block">Compra segura</strong
                        ><small class="text-secondary">Dados protegidos</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">Explore por categoria</h2>
            <div class="row g-3">
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="produtos.blade.php" class="category-card d-block"
                        ><div class="category-icon">📱</div>
                        <strong>Eletrônicos</strong
                        ><small class="d-block text-secondary mt-1">127 produtos</small></a
                    >
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="produtos.blade.php" class="category-card d-block"
                        ><div class="category-icon">🏠</div>
                        <strong>Casa & Decoração</strong
                        ><small class="d-block text-secondary mt-1">184 produtos</small></a
                    >
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="produtos.blade.php" class="category-card d-block"
                        ><div class="category-icon">🔧</div>
                        <strong>Ferramentas</strong
                        ><small class="d-block text-secondary mt-1">95 produtos</small></a
                    >
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="produtos.blade.php" class="category-card d-block"
                        ><div class="category-icon">⚽</div>
                        <strong>Esportes</strong
                        ><small class="d-block text-secondary mt-1">76 produtos</small></a
                    >
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="produtos.blade.php" class="category-card d-block"
                        ><div class="category-icon">💄</div>
                        <strong>Beleza & Saúde</strong
                        ><small class="d-block text-secondary mt-1">112 produtos</small></a
                    >
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="produtos.blade.php" class="category-card d-block"
                        ><div class="category-icon">🚗</div>
                        <strong>Automotivo</strong
                        ><small class="d-block text-secondary mt-1">80 produtos</small></a
                    >
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="promo-card promo-primary">
                        <h3 class="fw-bold">Ofertas da semana</h3>
                        <p>Descontos imperdíveis em produtos selecionados.</p>
                        <a class="btn btn-light btn-sm fw-bold" href="produtos.blade.php">Aproveitar agora</a
                        ><img
                            src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80"
                            alt=""
                        />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="promo-card promo-light">
                        <h3 class="fw-bold">Lançamentos</h3>
                        <p>Confira os produtos mais recentes.</p>
                        <a href="produtos.blade.php" class="btn-sf-outline btn-sm">Ver lançamentos</a
                        ><img
                            src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=600&q=80"
                            alt=""
                        />
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="promo-card promo-light">
                        <h3 class="fw-bold">Mais vendidos</h3>
                        <p>Os favoritos dos clientes.</p>
                        <a href="produtos.blade.php" class="btn-sf-outline btn-sm">Ver mais</a
                        ><img
                            src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=600&q=80"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="section-title mb-0">Destaques para você</h2>
                <a href="produtos.blade.php" class="text-primary fw-bold small">Ver todos →</a>
            </div>
            <div class="row g-3">
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
                        <h3 class="fs-6 fw-bold mt-1 mb-2">Smartphone Samsung Galaxy S24 128GB 5G - Preto</h3>
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
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="promo-card promo-primary d-flex align-items-center">
                <div class="position-relative z-2 col-lg-6">
                    <h2 class="fw-bold">Ferramentas profissionais</h2>
                    <p>Equipamentos para quem exige desempenho.</p>
                    <a class="btn btn-light fw-bold" href="produtos.blade.php">Ver ferramentas</a>
                </div>
                <img
                    src="https://images.unsplash.com/photo-1606220945770-b5b6c2c55bf1?auto=format&fit=crop&w=600&q=80"
                    alt="Ferramentas"
                />
            </div>
        </div>
    </section>
@endsection
