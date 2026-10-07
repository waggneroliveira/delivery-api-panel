@extends('admin.core.auth')
@section('content')
    <div class="account-pages d-flex justify-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">

                        <div class="card-body p-3 px-xl-4">
                            
                            <div class="text-center">
                                <div class="auth-brand">
                                    <a href="https://www.whi.dev.br/" target="_blank" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('build/admin/images/whi-black-horizontal.png')}}" alt="Logo WHI" height="50">
                                        </span>
                                    </a>
                
                                    <a href="https://www.whi.dev.br/" target="_blank" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="{{asset('build/admin/images/whi-green-horizontal.png')}}" alt="Logo WHI" height="50">
                                        </span>
                                    </a>
                                </div>
                                <h5 class="fw-bold mt-3 mb-1">Redefinir senha</h5>
                                <p class="text-muted small mb-4">Digite seu e-mail para receber instruções</p>
                            </div>

                            <form action="{{route('password.email')}}" method="POST">
                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger border-0 rounded-3" role="alert" style="background: #fee2e2; color: #991b1b;">
                                        @foreach ($errors->all() as $error)
                                            <p class="mb-0 small"><i class="mdi mdi-alert-circle"></i> {{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
        
                                @if(session('success'))
                                    <div class="alert alert-success border-0 rounded-3" role="alert" style="background: #d1fae5; color: #065f46;">
                                        <p class="mb-0 small"><i class="mdi mdi-check-circle"></i> {{ session('success') }}</p>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label fw-semibold small">E-mail</label>
                                    <input class="form-control" name="email" type="email" id="emailaddress" required placeholder="seu@email.com" style="border-radius: 8px;" value="{{ old('email') }}">
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary py-2 fw-semibold" type="submit" style="border-radius: 8px;">
                                        <i class="mdi mdi-email-send-outline me-1"></i> Enviar instruções
                                    </button>
                                </div>

                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted small mb-0">
                                    <i class="mdi mdi-lock-check-outline"></i>
                                    Link válido por 60 minutos
                                </p>
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="text-center mt-3">
                        <p class="text-muted small">
                            <i class="mdi mdi-arrow-left"></i>
                            <a href="{{route('admin.login')}}" class="text-decoration-none fw-semibold">Voltar para o login</a>
                        </p>
                    </div>

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
            border-color: #0073FA
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
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
            color: #0073FA
            transition: all 0.2s;
            font-weight: 500;
        }

        a:hover {
            color: #0b5ed7;
        }

        .form-check-input:checked {
            background-color: #0073FA
            border-color: #0073FA
        }

        .auth-brand {
            margin-bottom: 0.5rem;
        }

        .text-muted {
            color: #94a3b8 !important;
        }

        .alert {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
        }

        .alert i {
            margin-right: 0.5rem;
        }

        .btn i {
            font-size: 1.1rem;
            vertical-align: middle;
        }
    </style>
    
@endsection