@extends($theme->core('client'))

@section('content')
    <div class="container py-4">
        <div class="row g-4">
            <!-- BARRA LATERAL ESQUERDA COM ANÚNCIO -->
            <div class="col-lg-3 order-lg-1 order-2">
                <div class="sidebar-card">
                    <div class="d-flex align-items-center mb-3 px-2">
                        <i class="bi bi-file-earmark-text fs-5 text-primary me-2"></i>
                        <h6 class="fw-bold mb-0">Navegação</h6>
                    </div>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-dark" href="#aceitacao" style="cursor: pointer"
                            ><i class="bi bi-check2-square"></i> Aceitação</a
                        >
                        <a class="nav-link text-dark" href="#uso" style="cursor: pointer"
                            ><i class="bi bi-cpu"></i> Uso do Serviço</a
                        >
                        <a class="nav-link text-dark" href="#propriedade" style="cursor: pointer"
                            ><i class="bi bi-c-circle"></i> Propriedade</a
                        >
                        <a class="nav-link text-dark" href="#limitacao" style="cursor: pointer"
                            ><i class="bi bi-exclamation-triangle"></i> Isenção de Responsabilidade</a
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

            <!-- CONTEÚDO PRINCIPAL DOS TERMOS DE USO -->
            <div class="col-lg-6 order-lg-2 order-1">
                <div class="privacy-card">
                    <!-- Cabeçalho -->
                    <div class="privacy-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <h1><i class="bi bi-file-earmark-text text-primary me-2"></i>Termos de Uso</h1>
                            <span class="badge-lgpd"><i class="bi bi-shield-check"></i> Acesso Livre & Gratuito</span>
                        </div>
                        <p class="text-muted mb-0">
                            Por favor, leia atentamente os termos e condições para a utilização do site e das ferramentas do
                            GerarFácil.
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

                    <!-- Seção 1 - Aceitação dos Termos -->
                    <div class="privacy-section" id="aceitacao">
                        <h2><i class="bi bi-check2-square me-2"></i> 1. Aceitação dos Termos</h2>
                        <p>
                            Ao acessar e utilizar o site <strong>GerarFácil</strong>, você concorda expressamente em cumprir
                            e respeitar todos os termos, condições e avisos contidos nesta página.
                        </p>
                        <p class="mt-2">
                            Se você não concordar com qualquer trecho destes Termos de Uso, recomendamos que interrompa a
                            utilização do site e de suas ferramentas imediatamente.
                        </p>
                    </div>

                    <!-- Seção 2 - Descrição dos Serviços e Processamento Local -->
                    <div class="privacy-section" id="uso">
                        <h2><i class="bi bi-cpu me-2"></i> 2. Descrição dos Serviços</h2>
                        <p>
                            O GerarFácil disponibiliza gratuitamente um conjunto de utilitários online, tais como
                            calculadoras, conversores, geradores e validadores de dados.
                        </p>
                        <ul>
                            <li>
                                <strong>Processamento Local:</strong> Todas as nossas ferramentas operam
                                <strong>100% no lado do cliente (client-side)</strong>. As informações inseridas ou geradas
                                são processadas diretamente no seu navegador de internet.
                            </li>
                            <li>
                                <strong>Proposta de Testes:</strong> Ferramentas como o gerador de CPF/CNPJ e cartão de
                                crédito têm finalidade estritamente voltada a
                                <strong>testes de software e desenvolvimento técnico</strong>.
                            </li>
                        </ul>
                        <div class="alert alert-light mt-3 border rounded-3">
                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                            <strong>Importante:</strong> É terminantemente proibido utilizar os geradores de dados para fins
                            ilícitos, fraudes, falsificação ou cadastros indevidos em serviços de terceiros.
                        </div>
                    </div>

                    <!-- Seção 3 - Condições de Uso e Conduta -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-shield-slash me-2"></i> 3. Uso Permitido e Restrições</h2>
                        <p>Ao utilizar nossas ferramentas, você se compromete a:</p>
                        <ul>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Usar as ferramentas apenas para fins
                                legítimos, pessoais, acadêmicos ou de desenvolvimento de sistemas.
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Não tentar sobrecarregar, violar ou
                                comprometer a infraestrutura do site através de ataques cibernéticos ou bots abusivos.
                            </li>
                            <li>
                                <i class="bi bi-check-lg text-primary me-1"></i> Não utilizar o site para disseminar
                                qualquer tipo de material malicioso.
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

                    <!-- Seção 4 - Propriedade Intelectual -->
                    <div class="privacy-section" id="propriedade">
                        <h2><i class="bi bi-c-circle me-2"></i> 4. Propriedade Intelectual</h2>
                        <p>
                            A marca <strong>GerarFácil</strong>, logotipo, layout, estrutura de design, código-fonte e
                            scripts proprietários são de propriedade exclusiva e protegidos pelas leis de propriedade
                            intelectual.
                        </p>
                        <p>
                            A reprodução não autorizada do design ou do código da plataforma sem consentimento prévio é
                            estritamente proibida.
                        </p>
                    </div>

                    <!-- Seção 5 - Isenção de Responsabilidade -->
                    <div class="privacy-section" id="limitacao">
                        <h2><i class="bi bi-exclamation-triangle me-2"></i> 5. Isenção e Limitação de Responsabilidade</h2>
                        <p>
                            As ferramentas são fornecidas <strong>"como estão" (as is)</strong> e
                            <strong>"conforme disponíveis"</strong>, sem garantias de qualquer tipo, expressas ou
                            implícitas.
                        </p>
                        <div class="row g-2 mt-2">
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-x-circle-fill text-danger me-2"></i> Não nos responsabilizamos por
                                    decisões financeiras tomadas com base em nossas calculadoras.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-x-circle-fill text-danger me-2"></i> Não garantimos isenção total de
                                    erros operacionais nos algoritmos.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-x-circle-fill text-danger me-2"></i> O usuário é integralmente
                                    responsável pelos dados inseridos e resultados obtidos.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-x-circle-fill text-danger me-2"></i> Não nos responsabilizamos por
                                    indisponibilidades temporárias do site.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 6 - Links para Terceiros e Anúncios -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-box-arrow-up-right me-2"></i> 6. Links e Anúncios de Terceiros</h2>
                        <p>
                            O site pode conter links para serviços externos ou exibir banners de plataformas de anúncios
                            (como o Google AdSense). O GerarFácil não possui controle sobre o conteúdo, políticas de
                            privacidade ou práticas de sites de terceiros, não assumindo qualquer responsabilidade sobre
                            eles.
                        </p>
                    </div>

                    <!-- Seção 7 - Alterações nos Termos -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-pencil-square me-2"></i> 7. Modificações destes Termos</h2>
                        <p>
                            Reservamo-nos o direito de alterar ou atualizar estes Termos de Uso a qualquer momento, sem
                            aviso prévio. A data da última atualização será sempre informada no início desta página. O uso
                            continuado da plataforma após alterações significa a aceitação dos novos termos.
                        </p>
                    </div>

                    <!-- Seção 8 - Legislação e Foro -->
                    <div class="privacy-section">
                        <h2><i class="bi bi-journals me-2"></i> 8. Legislação Aplicável</h2>
                        <p>
                            Estes Termos de Uso são regidos e interpretados de acordo com as leis da República Federativa do
                            Brasil, em especial pelo Código Civil e pelo Marco Civil da Internet (Lei nº 12.965/2014).
                        </p>
                    </div>

                    <!-- Seção 9 - Contato -->
                    <div class="privacy-section d-none" id="contato">
                        <h2><i class="bi bi-envelope-paper me-2"></i> 9. Contato</h2>
                        <p>Caso tenha dúvidas ou precise falar conosco a respeito dos Termos de Uso, entre em contato:</p>
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
                            <i class="bi bi-printer"></i> Imprimir termos
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