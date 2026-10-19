<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <title>{{env('APP_NAME')}} - Logout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <meta name="author" content="WHI - Web de Alta Inspiração">
        <meta name="description" content="Painel gerenciador de conteúdo {{env('APP_NAME')}}">
        <meta name="copyright" content="© 2024 WHI - Web de Alta Inspiração." />
        <meta name="robots" content="none">
        <meta name="googlebot" content="noarchive">

        <!-- Bootstrap css -->
        <link href="{{ asset('build/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <!-- App css -->
        <link href="{{ asset('build/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons css -->
        <link href="{{ asset('build/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- Material Design Icons -->
        <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
    </head>

    <body class="authentication-bg d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    
                    <!-- Card Principal -->
                    <div class="card border-0" style="border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,0.08); background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                        
                        <div class="card-body p-5 text-center">
                            
                            <!-- Logo -->
                            <div class="auth-brand">
                                <a href="https://www.whi.dev.br/" target="_blank" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <img src="{{asset('build/admin/images/whi-black-horizontal.png')}}" alt="Logo WHI" height="80">
                                    </span>
                                </a>
            
                                <a href="https://www.whi.dev.br/" target="_blank" class="logo logo-light text-center">
                                    <span class="logo-lg">
                                        <img src="{{asset('build/admin/images/whi-green-horizontal.png')}}" alt="Logo WHI" height="80">
                                    </span>
                                </a>
                            </div>

                            <!-- Ícone de Sucesso -->
                            <div class="mb-4">
                                <div class="mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                                    <i class="mdi mdi-check-bold text-white" style="font-size: 2.5rem;"></i>
                                </div>
                            </div>

                            <!-- Título -->
                            <h3 class="fw-bold mb-2" style="color: #1e293b;">Logout realizado!</h3>
                            
                            <!-- Subtítulo -->
                            <p class="text-muted mb-4" style="font-size: 0.95rem;">
                                Sua sessão foi encerrada com sucesso.
                            </p>

                            <!-- Mensagem adicional -->
                            <div class="alert alert-info border-0 rounded-3" role="alert" style="background: #eff6ff; color: #0073FA; border-left: 4px solid #3b82f6 !important;">
                                <i class="mdi mdi-information-outline me-1"></i>
                                Você será redirecionado em <strong id="contador">3</strong> segundos
                            </div>

                            <!-- Botão de ação -->
                            <a href="{{route('admin.login')}}" class="btn btn-primary py-2 px-4 fw-semibold" style="border-radius: 12px; background: linear-gradient(135deg, #0d6efd, #0b5ed7); border: none; transition: all 0.3s;">
                                <i class="mdi mdi-login me-1"></i>
                                Fazer login novamente
                            </a>

                            <!-- Divisor -->
                            <hr class="my-4" style="border-color: #e2e8f0;">

                            <!-- Rodapé -->
                            <div class="d-flex justify-content-center gap-4">
                                <a href="https://www.whi.dev.br/" target="_blank" class="text-muted text-decoration-none small" style="transition: all 0.2s;">
                                    <i class="mdi mdi-web me-1"></i> whi.dev.br
                                </a>
                                <span class="text-muted small">•</span>
                                <a href="mailto:contato@whi.dev.br" class="text-muted text-decoration-none small" style="transition: all 0.2s;">
                                    <i class="mdi mdi-email-outline me-1"></i> contato
                                </a>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- Mensagem de segurança -->
                    <div class="text-center mt-3">
                        <p class="text-muted small mb-0">
                            <i class="mdi mdi-shield-check-outline"></i>
                            Ambiente seguro • Sessão encerrada
                        </p>
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->

        <style>
            .card {
                animation: slideUp 0.6s ease-out;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(13, 110, 253, 0.35);
            }

            .text-muted a:hover {
                color: #0d6efd !important;
            }

            .alert-info {
                background: #eff6ff;
                color: #0073FA;
                border-left: 4px solid #3b82f6 !important;
            }

            /* Animação do ícone */
            .mdi-check-bold {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
                100% {
                    transform: scale(1);
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let segundos = 3;
                const contador = document.getElementById('contador');
                
                // Atualiza o contador a cada segundo
                const interval = setInterval(function() {
                    segundos--;
                    if (segundos <= 0) {
                        clearInterval(interval);
                        window.location.href = '{{route("admin.login")}}';
                    } else {
                        contador.textContent = segundos;
                    }
                }, 2000);
            });
        </script>

    </body>
</html>