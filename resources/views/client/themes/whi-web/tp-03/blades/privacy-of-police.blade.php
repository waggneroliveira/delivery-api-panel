@extends($theme->core('client'))

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <!-- BARRA LATERAL ESQUERDA COM ANÚNCIO -->
            <div class="col-lg-3 order-lg-1 order-2">
                <div class="sidebar-card">
                    <div class="d-flex align-items-center mb-3 px-2">
                        <i class="bi bi-shield-lock fs-5 text-primary me-2"></i>
                        <h6 class="fw-bold mb-0">Privacidade</h6>
                    </div>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-dark" href="#introducao" style="cursor: pointer"
                            ><i class="bi bi-info-circle"></i> Introdução</a
                        >
                        <a class="nav-link text-dark" href="#dados" style="cursor: pointer"
                            ><i class="bi bi-database"></i> Dados coletados</a
                        >
                        <a class="nav-link text-dark" href="#cookies" style="cursor: pointer"
                            ><i class="bi bi-cookie"></i> Cookies</a
                        >
                        <a class="nav-link text-dark" href="#direitos" style="cursor: pointer"
                            ><i class="bi bi-person-arms-up"></i> Seus direitos</a
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

            <!-- CONTEÚDO PRINCIPAL DA POLÍTICA DE PRIVACIDADE -->
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="privacy-card">
                    <!-- Cabeçalho -->
                    <div class="privacy-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <h1><i class="bi bi-shield-lock text-primary me-2"></i>Política de Privacidade</h1>
                            <span class="badge-lgpd"><i class="bi bi-check-circle"></i> Em conformidade com a LGPD</span>
                        </div>
                        <p class="text-muted mb-0">
                            A GerarFácil respeita sua privacidade e protege seus dados. Leia atentamente esta política.
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

                    <!-- Seção 1 - Introdução -->
                    <div class="privacy-section" id="introducao">
                        <h2><i class="bi bi-info-circle me-2"></i> 1. Introdução</h2>
                        <p>
                            Bem-vindo à GerarFácil. Esta Política de Privacidade explica como coletamos, usamos, armazenamos
                            e protegemos suas informações ao utilizar nosso site e ferramentas online.
                        </p>
                        <p class="mt-2">
                            <strong>Princípio fundamental:</strong> Todas as nossas ferramentas funcionam
                            <strong>100% offline no seu navegador</strong>. Isso significa que os dados que você insere
                            (números, textos, CPFs, senhas, etc.)
                            <strong>NUNCA são enviados para nossos servidores</strong>. Tudo é processado localmente no seu
                            dispositivo.
                        </p>
                    </div>

                    <!-- Seção 2 - Dados coletados -->
                    <div class="privacy-section" id="dados">
                        <h2><i class="bi bi-database me-2"></i> 2. Quais dados coletamos?</h2>
                        <p>
                            <strong>Não coletamos dados pessoais sensíveis</strong> através das ferramentas. No entanto,
                            para melhorar nossa experiência e cumprir requisitos legais, podemos coletar:
                        </p>
                        <ul>
                            <li>
                                <strong>Dados de uso anônimos:</strong> Quais ferramentas são mais acessadas, tempo de
                                permanência (via Google Analytics).
                            </li>
                            <li>
                                <strong>Endereço de IP (anonimizado):</strong> Para fins de segurança e análise de tráfego.
                            </li>
                            <li>
                                <strong>Cookies técnicos:</strong> Pequenos arquivos para lembrar suas preferências (ex:
                                última ferramenta usada).
                            </li>
                            <li>
                                <strong>Informações do navegador:</strong> Tipo de navegador, sistema operacional, resolução
                                de tela (para otimização do site).
                            </li>
                        </ul>
                        <div class="alert alert-light mt-3 border rounded-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <strong>Importante:</strong> Os dados que você INSERE nas ferramentas (números, textos, CPFs
                            gerados, senhas) <strong>NÃO SÃO ARMAZENADOS</strong> em nossos servidores. Todo o processamento
                            é feito localmente no seu computador ou celular.
                        </div>
                    </div>

                    <!-- Seção 3 - Como usamos os dados -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-gear me-2"></i> 3. Como usamos seus dados?</h2>
                        <p>Utilizamos as informações coletadas exclusivamente para:</p>
                        <ul>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Melhorar e otimizar nossas ferramentas e
                                layout.
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Analisar estatísticas de uso (quais
                                ferramentas são mais populares).
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Exibir anúncios relevantes (através do
                                Google AdSense).
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Garantir a segurança e integridade do site.
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Cumprir obrigações legais quando exigido.
                            </li>
                        </ul>
                    </div>

                    <!-- ÁREA PARA ANÚNCIO (dentro do conteúdo) -->
                    @if (isset($announcements['center-content']) && $announcements['center-content']->isNotEmpty())                        
                        <div class="ad-container my-4">
                            <p><i class="bi bi-megaphone"></i> PUBLICIDADE</p>
                            @if (!isset($announcements['center-content'])) 
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
                    @endif

                    <!-- Seção 4 - Cookies -->
                    <div class="privacy-section" id="cookies">
                        <h2><i class="bi bi-cookie me-2"></i> 4. Uso de Cookies</h2>
                        <p>Utilizamos cookies para melhorar sua experiência. Os cookies utilizados são:</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome do Cookie</th>
                                        <th>Finalidade</th>
                                        <th>Duração</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>tool_preference</code></td>
                                        <td>Lembrar sua última ferramenta usada</td>
                                        <td>30 dias</td>
                                    </tr>
                                    <tr>
                                        <td><code>_ga</code> (Google Analytics)</td>
                                        <td>Analisar tráfego e comportamento anônimo</td>
                                        <td>2 anos</td>
                                    </tr>
                                    <tr>
                                        <td><code>_gid</code> (Google Analytics)</td>
                                        <td>Identificar sessões únicas</td>
                                        <td>24 horas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>
                            Você pode desabilitar os cookies nas configurações do seu navegador a qualquer momento. No
                            entanto, algumas funcionalidades do site podem ser afetadas.
                        </p>
                    </div>

                    <!-- Seção 5 - Publicidade e Parceiros -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-advertising me-2"></i> 5. Publicidade e Parceiros</h2>
                        <p>
                            Este site pode exibir anúncios de parceiros como o <strong>Google AdSense</strong>. Esses
                            serviços podem utilizar cookies para personalizar anúncios com base em seus interesses.
                        </p>
                        <p>
                            Para mais informações sobre como o Google utiliza dados de anúncios, acesse:
                            <a href="https://policies.google.com/technologies/ads" target="_blank"
                                >Política de Anúncios do Google</a
                            >.
                        </p>
                        <p>
                            Você pode optar por desativar a personalização de anúncios acessando:
                            <a href="https://adssettings.google.com" target="_blank">Configurações de anúncios do Google</a
                            >.
                        </p>
                    </div>

                    <!-- Seção 6 - Seus direitos (LGPD) -->
                    <div class="privacy-section" id="direitos">
                        <h2><i class="bi bi-person-arms-up me-2"></i> 6. Seus direitos (LGPD - Lei 13.709/2018)</h2>
                        <p>Como titular de dados, você tem os seguintes direitos:</p>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Confirmar a existência de
                                    tratamento
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Acessar seus dados
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Corrigir dados incompletos ou
                                    errados
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Solicitar anonimização ou
                                    eliminação
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Revogar consentimento a
                                    qualquer momento
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> Solicitar portabilidade dos
                                    dados
                                </div>
                            </div>
                        </div>
                        <p class="mt-3">
                            Para exercer qualquer um desses direitos, entre em contato pelo e-mail:
                            <strong>privacidade@gerarfacil.com.br</strong>
                        </p>
                    </div>

                    <!-- Seção 7 - Segurança -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-shield-check me-2"></i> 7. Segurança dos dados</h2>
                        <p>
                            Adotamos medidas técnicas e organizacionais para proteger seus dados contra acesso não
                            autorizado, perda ou divulgação:
                        </p>
                        <ul>
                            <li>
                                <i class="bi bi-lock-fill text-primary me-1"></i> <strong>Conexão HTTPS:</strong> Todo o
                                tráfego é criptografado.
                            </li>
                            <li>
                                <i class="bi bi-browser-edge text-primary me-1"></i>
                                <strong>Processamento local:</strong> Seus dados inseridos nas ferramentas nunca trafegam
                                pela rede.
                            </li>
                            <li>
                                <i class="bi bi-calendar-check text-primary me-1"></i>
                                <strong>Atualizações regulares:</strong> Mantemos o site e dependências atualizadas.
                            </li>
                        </ul>
                    </div>

                    <!-- Seção 8 - Links para terceiros -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-box-arrow-up-right me-2"></i> 8. Links para sites de terceiros</h2>
                        <p>
                            Nosso site pode conter links para sites de parceiros ou redes sociais. Não nos responsabilizamos
                            pelas práticas de privacidade desses sites. Recomendamos que você leia as políticas de
                            privacidade de cada site que visitar.
                        </p>
                    </div>

                    <!-- Seção 9 - Crianças e adolescentes -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-people-fill me-2"></i> 9. Dados de crianças e adolescentes</h2>
                        <p>
                            Nossas ferramentas não são direcionadas a menores de 13 anos. Não coletamos intencionalmente
                            dados de crianças. Se você é responsável e acredita que uma criança forneceu dados em nosso
                            site, entre em contato para que possamos removê-los.
                        </p>
                    </div>

                    <!-- Seção 10 - Alterações nesta política -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-pencil-square me-2"></i> 10. Alterações nesta Política de Privacidade</h2>
                        <p>
                            Podemos atualizar esta política periodicamente para refletir mudanças em nossas práticas ou na
                            legislação. Recomendamos que você revise esta página regularmente.
                        </p>
                        <p>
                            Quando alterações significativas forem feitas, publicaremos um aviso no site ou enviaremos uma
                            notificação (se você tiver se inscrito).
                        </p>
                    </div>

                    <!-- Seção 11 - Contato -->
                    <div class="privacy-section d-none" id="contato">
                        <h2><i class="bi bi-envelope-paper me-2"></i> 11. Contato</h2>
                        <p>
                            Se você tiver dúvidas sobre esta Política de Privacidade ou sobre como tratamos seus dados,
                            entre em contato:
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
                            <i class="bi bi-printer"></i> Imprimir política
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