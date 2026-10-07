@extends('admin.core.auth')
@section('content')
    <div class="account-pages d-flex justify-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">

                        <div class="card-body py-3 px-xl-4">
                            
                            <div class="text-center">
                                <div class="auth-brand mb-0">
                                    <a href="https://www.whi.dev.br/" target="_blank" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('build/admin/images/whi-green-horizontal.png')}}" alt="Logo WHI" height="50">
                                        </span>
                                    </a>
                
                                    <a href="https://www.whi.dev.br/" target="_blank" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('build/admin/images/whi-green-horizontal.png')}}" alt="Logo WHI" height="50">
                                        </span>
                                    </a>                                    
                                </div>
                                <h5 class="fw-bold mt-3 mb-1">Acessar conta</h5>
                                <p class="text-muted small mb-3">Informe seus dados para continuar</p>
                            </div>

                            <form action="{{route('admin.user.authenticate')}}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label fw-semibold small">E-mail</label>
                                    <input class="form-control" type="email" id="emailaddress" name="email" required placeholder="seu@email.com" value="{{ old('email') }}" style="border-radius: 8px;">
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold small">Senha</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Digite sua senha" required style="border-radius: 8px 0 0 8px;">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" style="border-radius: 0 8px 8px 0; border-left: 0;">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>                                

                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox"
                                            class="form-check-input"
                                            id="checkbox-signin"
                                            name="remember">

                                        <label class="form-check-label small" for="checkbox-signin">
                                            Manter conectado
                                        </label>
                                    </div>
                                    <a href="{{route('password.request')}}" class="small text-decoration-none">Esqueceu a senha?</a>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary py-2 fw-semibold" type="submit" style="border-radius: 8px;">
                                        Entrar
                                    </button>
                                </div>

                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted small mb-0">
                                    <i class="mdi mdi-lock-check-outline"></i>
                                    Ambiente seguro
                                </p>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <!-- Material Design Icons -->
    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        .account-pages{
            height: 100vh;
        }
        body{
            overflow-y: hidden;
        }   
        .card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.04);
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.1) !important;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
        }

        .form-control:focus {
            border-color: #0073FA;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .input-group .form-control:focus {
            border-right: none;
            box-shadow: none;
        }

        .input-group .form-control:focus + .toggle-password {
            border-color: #0073FA;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
            border-left: none;
        }

        .toggle-password {
            background: white;
            border: 1px solid #e2e8f0;
            border-left: none;
            color: #94a3b8;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }

        .toggle-password:hover {
            background: #f8fafc;
            color: #0073FA;
        }

        .toggle-password i {
            font-size: 1.2rem;
        }

        .btn-primary {
            background: #0073FA;
            border: none;
            transition: all 0.3s;
            font-size: 0.95rem;
            padding: 0.7rem;
        }

        .btn-primary:hover {
            background: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        a {
            color: #0073FA;
            transition: all 0.2s;
        }

        a:hover {
            color: #0b5ed7;
        }

        .form-check-input:checked {
            background-color: #0073FA;
            border-color: #0073FA;
        }

        .auth-brand {
            margin-bottom: 0.5rem;
        }

        .text-muted {
            color: #94a3b8 !important;
        }    
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const icon = toggleBtn.querySelector('i');

            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.className = 'mdi mdi-eye-off';
                } else {
                    passwordInput.type = 'password';
                    icon.className = 'mdi mdi-eye';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const checkbox = document.getElementById('checkbox-signin');

            if (!checkbox) return;

            checkbox.checked = localStorage.getItem('remember_login') === 'true';

            checkbox.addEventListener('change', function () {
                localStorage.setItem('remember_login', this.checked);
            });

        });
    </script>
@endsection