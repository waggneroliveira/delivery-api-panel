<link href="{{ asset('build/client/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link rel="preload" href="{{ asset('build/client/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">

<style>
    #footer {
        display: none;
    }

    .error-page-wrapper {
        min-height: 100vh;
        background-color: #FFFFFF;
        color: #000000;
    }

    .error-code {
        font-size: clamp(5rem, 15vw, 9rem);
        font-weight: 800;
        line-height: 1;
        color: #005af9;
        letter-spacing: -2px;
    }

    .error-icon-box {
        width: 80px;
        height: 80px;
        background-color: rgba(0, 90, 249, 0.1);
        color: #005af9;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    .btn-custom-primary {
        background-color: #005af9;
        color: #FFFFFF;
        border: 2px solid #005af9;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
    }

    .btn-custom-primary:hover {
        background-color: #000000;
        border-color: #000000;
        color: #FFFFFF;
        transform: translateY(-2px);
    }

    .text-secondary-custom {
        color: rgba(0, 0, 0, 0.7);
    }
</style>

<div class="error-page-wrapper container-fluid d-flex align-items-center justify-content-center p-4">
    <div class="text-center" style="max-width: 520px;">
        
        <!-- Ícone em destaque sutil -->
        <div class="mb-3">
            <div class="error-icon-box">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
        </div>
        
        <!-- Código 404 e Textos -->
        <h1 class="error-code mb-2">404</h1>
        <h2 class="h3 fw-bold mb-3 text-dark">Página não encontrada</h2>
        <p class="text-secondary-custom mb-4 fs-6">
            Desculpe, a página que você está procurando não existe, foi removida ou está temporariamente indisponível.
        </p>
        
        <!-- Botão de Ação -->
        <div class="d-flex justify-content-center">
            <a href="{{ route('index') }}" class="btn btn-custom-primary rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-house-door-fill"></i>
                <span>Voltar para o Início</span>
            </a>
        </div>

    </div>
</div>