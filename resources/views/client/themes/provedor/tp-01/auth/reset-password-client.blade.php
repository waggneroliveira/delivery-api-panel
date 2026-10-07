@extends('client.core.client')
@section('content')
<div class="authentication-bg authentication-bg-pattern">
    <style>
        .announcement{
            display: none;
        }
    </style>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern header-color">
                        <div class="card-body p-4">                            
                            <div class="text-center w-100 m-auto">
                                <div class="auth-brand">
                                    <div class="logo-img px-3 py-2 rounded-2 d-flex justify-content-center align-items-center">
                                        <a href="{{route('blog')}}">
                                            <img src="{{asset('build/client/images/logo.svg')}}" alt="Sindacs-BA" title="Sindacs-BA" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                                <p class="text-white montserrat-regular font-15 mb-4 mt-3">Por favor, preencha os campos abaixo para redefinir sua senha.</p>
                            </div>

                            <form action="{{route('client-password.update')}}" method="POST">
                                @csrf

                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach                                        
                                @endif
                                <input type="hidden" name="token" value="{{$token}}">
                                <div class="mb-3">
                                    <label for="email" class="form-label text-white montserrat-medium font-15">E-mail</label>
                                    <input class="form-control montserrat-regular" name="email" type="email" required="" id="email" placeholder="Digite seu E-mail">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label text-white montserrat-medium font-15">Nova Senha</label>
                                    <input class="form-control montserrat-regular" name="password" type="password" required="" id="password" placeholder="Digite a nova senha">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label text-white montserrat-medium font-15">Confirmar Nova Senha</label>
                                    <input class="form-control montserrat-regular" name="password_confirmation" type="password" required="" id="password_confirmation" placeholder="Digite a nova senha">
                                </div>
        
                                <div class="text-center d-grid">
                                    <button class="btn text-white montserrat-medium rounded-3 font-15 background-red" type="submit"> Alterar Senha </button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            {{-- <p class="text-white-50">Voltar para <a href="{{route('admin.login')}}" class="text-white ms-1"><b>Login</b></a></p> --}}
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->  
</div>
@endsection