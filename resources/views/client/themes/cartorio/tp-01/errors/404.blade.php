@extends('client.core.client')
@section('content')
    <style>
        #footer{
            display: none;
        }
        @media (max-width: 476px) {
            .call-to-action i {
                height: 40px;
                width: 40px;
                font-size: 1.125rem;
            }
            .call-to-action {
                height: 40px;
                font-size: 0.938rem;
                width: 230px;
                padding-left: 0 !important;
                gap: 8px !important;
            }
        }
    </style>
    <div class="container-fluid d-flex align-items-center justify-content-center h-100 pb-4">
        <div class="text-center">
            <!-- Ícone ou imagem do erro -->
            <div class="mb-0">
                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 5rem;"></i>
            </div>
            
            <!-- Título e mensagem -->
            <h1 class="display-1 fw-bold emphasis poppins-bold">404</h1>
            <h2 class="mb-4 poppins-bold title-blue">Página não encontrada</h2>
            <p class="lead mb-4 text-center title-blue poppins-medium">
                Desculpe, a página que você está procurando não existe ou foi movida.
            </p>
            
            <!-- Botão de ação -->
            <div class="d-grid gap-2 d-md-flex justify-content-center">
                <a href="{{route('index')}}" class="text-white py-2 px-3 poppins-medium rounded-3 background-red d-flex justify-content-start gap-2 align-items-center">
                    <i class="bi bi-house-fill me-2 d-flex justify-content-center align-items-center"></i>Voltar para o Início
                </a>
            </div>
        </div>
    </div>
@endsection