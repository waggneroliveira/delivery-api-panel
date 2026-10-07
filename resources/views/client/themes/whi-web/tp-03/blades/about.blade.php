@extends($theme->core('client'))

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <!-- BARRA LATERAL ESQUERDA COM ANÚNCIO -->
            <div class="col-lg-3 order-lg-1 order-2">
                <div class="sidebar-card">
                    <div class="d-flex align-items-center mb-3 px-2">
                        <i class="bi bi-info-circle fs-5 text-primary me-2"></i>
                        <h6 class="fw-bold mb-0">Navegação</h6>
                    </div>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-dark" href="#historia" style="cursor: pointer"
                            ><i class="bi bi-rocket-takeoff"></i> Nossa História</a
                        >
                        <a class="nav-link text-dark" href="#diferencial" style="cursor: pointer"
                            ><i class="bi bi-shield-check"></i> Diferencial 100% Local</a
                        >
                        <a class="nav-link text-dark" href="#pilares" style="cursor: pointer"
                            ><i class="bi bi-award"></i> Nossos Pilares</a
                        >
                        <a class="nav-link text-dark" href="#ferramentas" style="cursor: pointer"
                            ><i class="bi bi-grid-fill"></i> O que Oferecemos</a
                        >
                        <a class="nav-link text-dark d-none" href="#contato" style="cursor: pointer"
                            ><i class="bi bi-envelope-paper"></i> Contato</a
                        >
                    </nav>
                    @if (isset($announcements['sidebar-left']) && $announcements['sidebar-left']->isNotEmpty()) 
                        <div class="ad-container mt-4 sidebar-left">
                            <p><i class="bi bi-megaphone"></i> PUBLICIDADE</p>
                            <div class="ad-placeholder overflow-hidden">
                                <!-- Seu anúncio aqui<br>(Google Ads) -->
                                    @includeIf('client.components.announcement.all-announcement', [
                                            'announcements' => $announcements['sidebar-left'] ?? collect()
                                        ]
                                    )
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CONTEÚDO PRINCIPAL DA PÁGINA SOBRE -->
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="privacy-card">
                    <!-- Cabeçalho -->
                    <div class="privacy-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <h1><i class="bi bi-info-circle text-primary me-2"></i>Sobre o GerarFácil</h1>
                            <span class="badge-lgpd"
                                ><i class="bi bi-heart-fill text-danger"></i> 100% Gratuito e Seguro</span
                            >
                        </div>
                        <p class="text-muted mb-0">
                            Desenvolvemos utilitários práticos, rápidos e seguros para simplificar a sua rotina digital sem
                            comprometer seus dados.
                        </p>
                    </div>

                    <!-- Data de atualização -->
                    <div class="update-date mb-4">
                        <i class="bi bi-calendar3 me-2"></i> Última atualização: <strong>24 de Setembro de 2026</strong>
                    </div>

                    <!-- ÁREA PARA ANÚNCIO (dentro do conteúdo) -->
                    @if (isset($announcements['top-center']) && $announcements['top-center']->isNotEmpty())
                        <div class="ad-container mb-4 overflow-hidden">
                            <p><i class="bi bi-google"></i> ANÚNCIO</p>
                            <div class="ad-placeholder" style="min-height: 90px">
                                <!-- Espaço para Banner Adsense -->
                                @includeIf('client.components.announcement.all-announcement', [
                                        'announcements' => $announcements['top-center'] ?? collect()
                                    ]
                                )
                            </div>
                        </div>
                    @endif

                    <!-- Seção 1 - Nossa História -->
                    <div class="privacy-section" id="historia">
                        <h2><i class="bi bi-rocket-takeoff me-2"></i> 1. Nossa História</h2>
                        <p>
                            O <strong>GerarFácil</strong> nasceu com uma missão clara: resolver pequenas tarefas diárias do
                            ambiente digital — como formatar um arquivo JSON, validar um documento de teste ou calcular um
                            financiamento — de forma imediata e descomplicada.
                        </p>
                        <p class="mt-2">
                            Percebemos que a maioria dos utilitários disponíveis na web era lenta, cheia de cadastros
                            desnecessários ou colocava em risco os dados do usuário enviando tudo para servidores
                            desconhecidos. Criamos o GerarFácil para ser exatamente o oposto: **simples, rápido e ultra
                            seguro**.
                        </p>
                    </div>

                    <!-- Seção 2 - O Diferencial 100% Local -->
                    <div class="privacy-section" id="diferencial">
                        <h2><i class="bi bi-shield-check me-2"></i> 2. O Diferencial: Processamento 100% Local</h2>
                        <p>
                            O grande pilar do GerarFácil é a segurança arquitetural. Todas as nossas 15+ ferramentas foram
                            desenvolvidas para rodar utilizando a capacidade de processamento do seu próprio navegador
                            (Client-Side).
                        </p>
                        <div class="alert alert-light mt-3 border rounded-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <strong>O que isso significa na prática?</strong> Quando você gera uma senha, calcula parcelas
                            ou valida um texto, os dados <strong>nunca saem do seu computador ou celular</strong>. Nada é
                            transmitido ou salvo em servidores remotos.
                        </div>
                    </div>

                    <!-- Seção 3 - Nossos Pilares -->
                    <div class="privacy-section" id="pilares">
                        <h2><i class="bi bi-award me-2"></i> 3. Nossos Pilares</h2>
                        <p>Trabalhamos focados em três compromissos fundamentais:</p>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                                    <strong>Velocidade:</strong> Respostas instantâneas sem carregamento de página.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-lock-fill text-primary me-2"></i>
                                    <strong>Privacidade Total:</strong> Sem rastreamento de dados inseridos.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-currency-dollar text-success me-2"></i>
                                    <strong>Gratuidade:</strong> Acesso livre a todas as ferramentas sem cadastro.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-phone-fill text-info me-2"></i> <strong>Acessibilidade:</strong> Design
                                    responsivo para qualquer dispositivo.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ÁREA PARA ANÚNCIO (dentro do conteúdo) -->
                    <div class="ad-container my-4">                        
                        <p><i class="bi bi-megaphone"></i> PUBLICIDADE</p>
                        @if (!isset($announcements['center-content']) && $announcements['center-content']->isNotEmpty()) 
                            <div class="ad-placeholder" style="min-height: 90px">Seu anúncio aqui</div>
                        @else
                            <div class="ad-placeholder overflow-hidden" style="min-height: 90px">
                                <!-- Seu anúncio aqui<br>(Google Ads) -->
                                @includeIf('client.components.announcement.all-announcement', [
                                        'announcements' => $announcements['center-content'] ?? collect()
                                    ]
                                )
                            </div>
                        @endif
                    </div>

                    <!-- Seção 4 - O que oferecemos -->
                    <div class="privacy-section" id="ferramentas">
                        <h2><i class="bi bi-grid-fill me-2"></i> 4. O que Oferecemos?</h2>
                        <p>Nossa suíte de ferramentas inclui soluções divididas em diversas áreas técnicas e cotidianas:</p>
                        <ul>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> <strong>Financeiro:</strong> Calculadoras
                                de Juros Compostos, Porcentagem e Financiamentos (Tabelas Price e SAC).
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i>
                                <strong>Desenvolvimento:</strong> Formatador/Validador JSON, Gerador de UUID, Gerador de
                                Senhas Seguras.
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i>
                                <strong>Testes de Software:</strong> Geradores e Validadores de CPF/CNPJ e validação de
                                cartões (Algoritmo de Luhn).
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> <strong>Produtividade:</strong> Contador de
                                Palavras e Caracteres, Conversor de Unidades e Sorteador Online.
                            </li>
                        </ul>
                    </div>

                    <!-- Seção 5 - Como Mantemos o Projeto -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-heart me-2"></i> 5. Como Mantemos o Projeto Gratuito?</h2>
                        <p>
                            Para manter o site 100% gratuito e em constante evolução sem cobrar assinaturas, utilizamos
                            exibições discretas de anúncios de parceiros (como o Google AdSense).
                        </p>
                        <p>
                            Buscamos sempre manter o equilíbrio entre a rentabilidade do projeto e uma navegação limpa, sem
                            atrapalhar a usabilidade do usuário.
                        </p>
                    </div>

                    <!-- Seção 6 - Contato e Suporte -->
                    <div class="privacy-section d-none" id="contato">
                        <h2><i class="bi bi-envelope-paper me-2"></i> 6. Fale Conosco</h2>
                        <p>
                            Sugestões de novas ferramentas, relatórios de bugs ou dúvidas técnicas são sempre bem-vindos.
                            Entre em contato com a nossa equipe:
                        </p>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <i class="bi bi-envelope-fill text-primary me-2"></i>
                                    <strong class="fs-6">E-mail:</strong>
                                    <a href="mailto:atendimento@whi.dev.br">atendimento@whi.dev.br</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <i class="bi bi-whatsapp text-success me-2"></i>
                                    <strong>WhatsApp:</strong> (71) 9 9276-8360
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rodapé da política -->
                    <hr class="my-4" />
                    <div class="text-center">
                        <p class="small text-muted">
                            <i class="bi bi-heart-fill text-danger"></i> GerarFácil - Ferramentas online gratuitas que
                            respeitam sua privacidade.
                        </p>
                        <a href="index.html" class="btn btn-outline-primary btn-sm me-2"
                            ><i class="bi bi-arrow-left"></i> Voltar para o site</a
                        >
                        <button class="btn btn-sm btn-light" onclick="window.print();">
                            <i class="bi bi-printer"></i> Imprimir página
                        </button>
                    </div>
                </div>

                <!-- ÁREA PARA ANÚNCIO (abaixo do conteúdo principal) -->
                @if (isset($announcements['center-bottom']) && $announcements['center-bottom']->isNotEmpty())
                    <div class="ad-container mt-3">
                        <p><i class="bi bi-google"></i> ANÚNCIO RESPONSIVO</p>
                        <div class="ad-placeholder overflow-hidden" style="min-height: 100px">
                            <!-- Espaço para Banner Adsense -->
                            @includeIf('client.components.announcement.all-announcement',[
                                    'announcements' => $announcements['center-bottom'] ?? collect()
                                ]
                            )
                        </div>
                    </div>
                @endif
            </div>

            <!-- BARRA LATERAL DIREITA COM ANÚNCIO -->
            @if (isset($announcements['sidebar-right']) && $announcements['sidebar-right']->isNotEmpty())                
                <div class="col-lg-3 order-lg-3 order-3">
                    <div class="sidebar-card" style="background: white">
                        <div class="ad-container mb-3 sidebar-right">
                            <p><i class="bi bi-display"></i> DESTAQUE</p>
                            <div class="ad-placeholder overflow-hidden" style="min-height: 250px">
                                <!-- Anúncio 300x250 -->  
                                @includeIf('client.components.announcement.all-announcement',[
                                        'announcements' => $announcements['sidebar-right'] ?? collect()
                                    ]
                                )
                            </div>
                        </div>
                        <div class="mt-3 p-2 bg-light rounded-4 text-center small text-muted">
                            <i class="bi bi-shield-check text-success"></i> Processamento 100% local<br />Seus dados nunca saem
                            do seu dispositivo                        
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection