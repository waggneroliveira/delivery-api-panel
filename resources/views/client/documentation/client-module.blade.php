<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Documentação arquitetural · Client & Admin</title>
  <!-- Font Awesome para ícones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #f1f5f9;
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      padding: 2rem 1.5rem;
      color: #0b1a33;
      line-height: 1.5;
    }

    .doc-wrapper {
      max-width: 1280px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 2rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
      padding: 2.5rem 2.8rem;
      transition: all 0.2s;
    }

    /* cabeçalho hero */
    .hero-header {
      background: linear-gradient(145deg, #0b1a33 0%, #1e2f4b 100%);
      border-radius: 1.75rem;
      padding: 2rem 2.5rem;
      margin-bottom: 2.5rem;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      color: #f0f4fe;
    }

    .hero-header h1 {
      font-weight: 600;
      font-size: 2.2rem;
      letter-spacing: -0.02em;
      color: white;
      margin-bottom: 0.25rem;
    }

    .hero-header p {
      font-size: 1.05rem;
      opacity: 0.8;
      max-width: 600px;
    }

    .hero-badge-group {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-top: 0.75rem;
    }

    .badge-hero {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(4px);
      padding: 0.4rem 1rem;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 500;
      border: 1px solid rgba(255, 255, 255, 0.12);
      color: #e2eaff;
    }

    .badge-hero i {
      margin-right: 6px;
      color: #8bb3ff;
    }

    .version-tag {
      background: #2d4a78;
      padding: 0.3rem 1.2rem;
      border-radius: 40px;
      font-weight: 500;
      font-size: 0.9rem;
      border: 1px solid #4a6a9b;
      color: #d6e5ff;
    }

    /* grade de cards */
    .grid-2col {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.8rem;
      margin: 2rem 0 1.8rem;
    }

    .card-doc {
      background: #fafcff;
      border: 1px solid #e6edf5;
      border-radius: 1.5rem;
      padding: 1.5rem 1.8rem 1.8rem;
      box-shadow: 0 4px 12px rgba(0, 20, 40, 0.02);
      transition: box-shadow 0.2s, transform 0.1s;
    }

    .card-doc:hover {
      box-shadow: 0 12px 28px -8px rgba(0, 32, 64, 0.08);
      border-color: #cdddee;
    }

    .card-doc h2 {
      font-size: 1.4rem;
      font-weight: 600;
      letter-spacing: -0.01em;
      color: #0b1a33;
      margin-bottom: 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .card-doc h2 i {
      color: #2a5c9a;
      font-size: 1.3rem;
      width: 1.8rem;
    }

    .card-doc ul {
      list-style: none;
      padding-left: 0;
    }

    .card-doc li {
      padding: 0.4rem 0 0.4rem 1.8rem;
      position: relative;
      border-bottom: 1px solid #f0f4fa;
      font-size: 0.98rem;
    }

    .card-doc li:last-child {
      border-bottom: none;
    }

    .card-doc li::before {
      content: "▹";
      position: absolute;
      left: 0;
      color: #2a5c9a;
      font-weight: 600;
    }

    .flow-row {
      background: #f0f6fe;
      border-radius: 80px;
      padding: 0.8rem 1.8rem;
      display: inline-flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 0.6rem 0.2rem;
      font-weight: 500;
      font-size: 0.95rem;
      border: 1px solid #d6e3f5;
      margin: 0.5rem 0 0.2rem;
    }

    .flow-row span {
      background: white;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.02);
    }

    .flow-row i {
      color: #5d7fa3;
      font-size: 0.8rem;
      margin: 0 0.1rem;
    }

    code {
      background: #eaf0f8;
      padding: 0.15rem 0.6rem;
      border-radius: 12px;
      font-size: 0.85rem;
      color: #1c3d66;
      font-weight: 500;
      border: 1px solid #dae3ef;
    }

    .slide-example {
      background: #f8faff;
      border-radius: 1.2rem;
      padding: 1rem 1.2rem 1.2rem;
      border: 1px solid #e2ecf9;
      margin: 1rem 0 0.4rem;
    }

    .slide-header {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-weight: 500;
      color: #1f3d64;
      margin-bottom: 0.6rem;
    }

    .slide-header i {
      color: #2a5c9a;
    }

    .code-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 0.8rem;
    }

    .code-snip {
      background: #0b1a33;
      color: #e0edff;
      border-radius: 14px;
      padding: 0.8rem 1rem;
      font-family: 'JetBrains Mono', 'Fira Code', monospace;
      font-size: 0.7rem;
      line-height: 1.5;
      overflow-x: auto;
      white-space: pre-wrap;
      border: 1px solid #2a3f60;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .code-snip .kw { color: #b3cfff; }
    .code-snip .fn { color: #8bb3ff; }
    .code-snip .str { color: #b3e0b3; }
    .code-snip .com { color: #6a8bb0; }

    .badge-stack {
      display: flex;
      flex-wrap: wrap;
      gap: 0.4rem 0.3rem;
      margin: 0.5rem 0 0.2rem;
    }

    .badge-stack .badge {
      background: #eaf1fb;
      padding: 0.2rem 0.9rem;
      border-radius: 30px;
      font-size: 0.7rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.02em;
      color: #1e4a7a;
      border: 1px solid #d3e2f5;
    }

    hr {
      border: none;
      border-top: 1px solid #e2eaf3;
      margin: 2rem 0 0.5rem;
    }

    .footer-meta {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      align-items: center;
      margin-top: 2rem;
      font-size: 0.9rem;
      color: #3d5779;
    }

    .footer-meta i {
      margin-right: 0.3rem;
      color: #4a7bb5;
    }

    .route-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.3rem 1rem;
      margin: 0.3rem 0 0.2rem;
    }

    .route-list code {
      background: #eef4fc;
    }

    @media (max-width: 680px) {
      .doc-wrapper { padding: 1.5rem; }
      .hero-header { flex-direction: column; align-items: flex-start; gap: 0.8rem; }
      .hero-header h1 { font-size: 1.8rem; }
    }
  </style>
</head>
<body>
<div class="doc-wrapper">

  <!-- HERO -->
  <div class="hero-header">
    <div>
      <h1><i class="fas fa-cubes" style="margin-right: 12px; color: #7ba3ff;"></i>Documentação arquitetural</h1>
      <p>Separação clara entre fluxo <strong>Client</strong> (público) e <strong>Admin</strong> (gestão), com camadas bem definidas.</p>
      <div class="hero-badge-group">
        <span class="badge-hero"><i class="fas fa-layer-group"></i> Presentation</span>
        <span class="badge-hero"><i class="fas fa-briefcase"></i> Business</span>
        <span class="badge-hero"><i class="fas fa-database"></i> Data</span>
        <span class="badge-hero"><i class="fas fa-code-branch"></i> Contracts</span>
        <span class="badge-hero"><i class="fas fa-arrow-right-arrow-left"></i> DTO</span>
      </div>
    </div>
    <div class="version-tag"><i class="fas fa-tag"></i> v2.0 · reorganização</div>
  </div>

  <!-- VISÃO GERAL + FLUXO -->
  <div class="grid-2col">
    <div class="card-doc">
      <h2><i class="fas fa-sitemap"></i> Visão geral</h2>
      <p style="margin-bottom: 0.8rem;">O projeto foi reestruturado para reduzir acoplamento e facilitar a evolução. As camadas <strong>Presentation</strong>, <strong>Business</strong> e <strong>Data</strong> são a base, com contratos e DTOs para desacoplamento.</p>
      <div class="flow-row">
        <span><i class="fas fa-route"></i> Route</span>
        <i class="fas fa-chevron-right"></i>
        <span><i class="fas fa-gamepad"></i> Controller</span>
        <i class="fas fa-chevron-right"></i>
        <span><i class="fas fa-cogs"></i> Service</span>
        <i class="fas fa-chevron-right"></i>
        <span><i class="fas fa-folder-open"></i> Repository</span>
        <i class="fas fa-chevron-right"></i>
        <span><i class="fas fa-table"></i> Model</span>
      </div>
      <p style="margin-top: 0.8rem; font-size: 0.95rem;"><i class="fas fa-check-circle" style="color: #2a7a4a;"></i> Fluxo previsível, manutenção simplificada e onboarding mais rápido.</p>
    </div>

    <div class="card-doc">
      <h2><i class="fas fa-code"></i> Camadas adotadas</h2>
      <ul>
        <li><strong>Presentation</strong> – Controllers, requests e validação de entrada.</li>
        <li><strong>Business</strong> – Services com regras de negócio específicas.</li>
        <li><strong>Data</strong> – Repositórios, acesso e persistência.</li>
        <li><strong>DTO</strong> – Objetos de transferência entre camadas.</li>
        <li><strong>Contracts</strong> – Interfaces para abstração e testes.</li>
      </ul>
      <div class="badge-stack">
        <span class="badge"><i class="far fa-file-code"></i> Controllers</span>
        <span class="badge"><i class="fas fa-vial"></i> Services</span>
        <span class="badge"><i class="fas fa-database"></i> Repositories</span>
        <span class="badge"><i class="fas fa-cube"></i> DTOs</span>
      </div>
    </div>
  </div>

  <!-- EXEMPLOS DE CÓDIGO (SLIDES) -->
  <div class="card-doc" style="margin-bottom: 1.8rem;">
    <h2><i class="fas fa-images"></i> Exemplos de código · slides</h2>
    <p style="margin-bottom: 0.5rem;">Trechos reais da estrutura, organizados por camada (Presentation, Business, Data).</p>

    <div class="slide-example">
      <div class="slide-header"><i class="fas fa-display"></i> Presentation – Controller (Client)</div>
      <div class="code-grid">
        <div class="code-snip"><span class="kw">class</span> <span class="fn">HomeController</span> {
  <span class="kw">public</span> <span class="fn">index</span>() {
    <span class="kw">return</span> <span class="str">'view::home'</span>;
  }
}</div>
        <div class="code-snip"><span class="kw">class</span> <span class="fn">ProductController</span> {
  <span class="kw">public</span> <span class="fn">show</span>(<span class="str">$id</span>) {
    <span class="kw">return</span> ProductService::<span class="fn">get</span>(<span class="str">$id</span>);
  }
}</div>
      </div>
    </div>

    <div class="slide-example">
      <div class="slide-header"><i class="fas fa-cogs"></i> Business – Service (Admin)</div>
      <div class="code-grid">
        <div class="code-snip"><span class="kw">class</span> <span class="fn">BlogService</span> {
  <span class="kw">public</span> <span class="fn">store</span>(<span class="str">$data</span>) {
    <span class="kw">return</span> BlogRepository::<span class="fn">create</span>(<span class="str">$data</span>);
  }
}</div>
        <div class="code-snip"><span class="kw">class</span> <span class="fn">ProductService</span> {
  <span class="kw">public</span> <span class="fn">update</span>(<span class="str">$id</span>, <span class="str">$data</span>) {
    <span class="kw">return</span> ProductRepository::<span class="fn">update</span>(<span class="str">$id</span>, <span class="str">$data</span>);
  }
}</div>
      </div>
    </div>

    <div class="slide-example">
      <div class="slide-header"><i class="fas fa-database"></i> Data – Repository & DTO</div>
      <div class="code-grid">
        <div class="code-snip"><span class="kw">interface</span> <span class="fn">BlogRepository</span> {
  <span class="kw">public</span> <span class="fn">getAll</span>();
  <span class="kw">public</span> <span class="fn">find</span>(<span class="str">$id</span>);
}</div>
        <div class="code-snip"><span class="kw">class</span> <span class="fn">ProductDTO</span> {
  <span class="kw">public</span> <span class="str">$name</span>;
  <span class="kw">public</span> <span class="str">$price</span>;
  <span class="kw">public</span> <span class="fn">toArray</span>() { <span class="kw">return</span> [ ... ]; }
}</div>
      </div>
    </div>
    <p style="font-size: 0.85rem; margin-top: 0.5rem; color: #2a4e7a;"><i class="fas fa-arrow-right"></i> Os contratos (interfaces) garantem abstração e testes futuros.</p>
  </div>

  <!-- MÓDULOS: CLIENT E ADMIN -->
  <div class="grid-2col">
    <div class="card-doc">
      <h2><i class="fas fa-user-circle"></i> Módulo Client</h2>
      <ul>
        <li>Controllers de páginas públicas reorganizados em <strong>Presentation</strong>.</li>
        <li>Home, Blog, Produtos, Contato, Sobre, Eventos com responsabilidades separadas.</li>
        <li>Validação e tratamento movidos para requests e services.</li>
        <li>Documentação pública em <code>/client-documentation</code>.</li>
      </ul>
      <div style="margin-top: 0.8rem; background: #eaf2fc; border-radius: 30px; padding: 0.2rem 1rem; display: inline-block; font-size:0.85rem;">
        <i class="fas fa-route" style="color: #1f4a7a;"></i> rotas: <code>/</code> <code>/produtos</code> <code>/blog</code>
      </div>
    </div>

    <div class="card-doc">
      <h2><i class="fas fa-user-tie"></i> Módulo Admin</h2>
      <ul>
        <li>Dashboard e rotas administrativas com controllers de apresentação.</li>
        <li>Blog, Product, User já iniciados com camada Business.</li>
        <li>Criação, edição, exclusão e ordenação seguem o novo padrão.</li>
        <li>Consistência entre fluxo público e painel administrativo.</li>
      </ul>
      <div style="margin-top: 0.8rem; background: #eaf2fc; border-radius: 30px; padding: 0.2rem 1rem; display: inline-block; font-size:0.85rem;">
        <i class="fas fa-shield-alt" style="color: #1f4a7a;"></i> rotas: <code>/admin/dashboard</code> <code>/admin/blog</code>
      </div>
    </div>
  </div>

  <!-- ROTAS PÚBLICAS + IMPLEMENTADO -->
  <div class="grid-2col">
    <div class="card-doc">
      <h2><i class="fas fa-check-double"></i> Já implementado</h2>
      <ul>
        <li>Estrutura modular para Client e Admin.</li>
        <li>Controllers de presentation para rotas principais.</li>
        <li>Services com regras de negócio (Blog, Product, User, Dashboard).</li>
        <li>Rotas do painel e área pública apontando para a nova organização.</li>
      </ul>
      <div style="margin-top: 0.5rem;"><span class="badge-hero" style="background: #d9e8fc; color:#12345a;"><i class="fas fa-rocket"></i> em evolução</span></div>
    </div>

    <div class="card-doc">
      <h2><i class="fas fa-map-pin"></i> Rotas públicas</h2>
      <div class="route-list">
        <code>/</code> <code>/produtos</code> <code>/contato</code> <code>/blog</code>
        <code>/sobre</code> <code>/eventos</code> <code>/client-documentation</code>
      </div>
      <p style="margin-top: 0.7rem; font-size:0.9rem;"><i class="fas fa-info-circle" style="color: #2a5c9a;"></i> A rota <code>/client-documentation</code> exibe esta própria documentação.</p>
    </div>
  </div>

  <!-- PRÓXIMOS PASSOS -->
  <div class="card-doc" style="margin-top: 0.8rem; border-left: 4px solid #2a5c9a;">
    <h2 style="margin-bottom: 0.2rem;"><i class="fas fa-forward"></i> Próximos passos</h2>
    <p style="font-size: 1rem;">Expandir o padrão para os demais módulos administrativos, mantendo <strong>Client</strong> e <strong>Admin</strong> com estrutura consistente, escalável e de fácil evolução. <i class="fas fa-arrow-trend-up" style="color: #1f6b3b; margin-left: 6px;"></i></p>
    <div style="display: flex; gap: 0.8rem; flex-wrap: wrap; margin-top: 0.5rem;">
      <span style="background: #eaf2fc; border-radius: 30px; padding: 0.1rem 1rem; font-size:0.8rem;"><i class="fas fa-code-branch"></i> mais testes</span>
      <span style="background: #eaf2fc; border-radius: 30px; padding: 0.1rem 1rem; font-size:0.8rem;"><i class="fas fa-file-signature"></i> documentação de API</span>
      <span style="background: #eaf2fc; border-radius: 30px; padding: 0.1rem 1rem; font-size:0.8rem;"><i class="fas fa-puzzle-piece"></i> módulos de pedidos</span>
    </div>
  </div>

  <hr />

  <div class="footer-meta">
    <span><i class="fas fa-calendar-alt"></i> Atualizado em abril de 2026</span>
    <span><i class="fas fa-code"></i> Arquitetura em camadas · Client + Admin</span>
    <span><i class="fas fa-git-alt"></i> v2.0 — reorganização estrutural</span>
  </div>

</div>
</body>
</html>