<style>
    .loading-indicator {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: #021127;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99999;
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .loading-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
    }

    /* Container ampliado para comportar a logo de 170px */
    .brand-spinner-wrapper {
        position: relative;
        width: 240px;
        height: 240px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
        /* Glow sutil atrás do spinner para destacar a marca */
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(124, 58, 237, 0) 70%);
        border-radius: 50%;
    }

    /* Anel Externo ajustado */
    .spinner-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: rgba(255, 255, 255, 0.95);
        border-bottom-color: rgba(255, 255, 255, 0.25);
        animation: spin 1.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
    }

    /* Anel Interno ajustado */
    .spinner-ring-inner {
        position: absolute;
        width: 82%;
        height: 82%;
        border-radius: 50%;
        border: 2px solid transparent;
        border-left-color: rgba(255, 255, 255, 0.7);
        border-right-color: rgba(255, 255, 255, 0.2);
        animation: spin-reverse 1.3s linear infinite;
    }

    /* Logo em destaque */
    .brand-logo {
        width: 170px;
        height: auto;
        filter: brightness(0) invert(1);
        opacity: 0.98;
        z-index: 2;
        animation: float 3.5s ease-in-out infinite;
    }

    /* Mensagem */
    .loading-title {
        color: #FFFFFF;
        font-size: 1.15rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        margin: 0 0 10px 0;
        animation: pulse-text 2s ease-in-out infinite;
    }

    /* Pontos de carregamento abaixo do texto */
    .loading-dots {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .loading-dots span {
        width: 6px;
        height: 6px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        animation: dots-bounce 1.4s infinite ease-in-out both;
    }

    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }

    /* Keyframes */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes spin-reverse {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(-360deg); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @keyframes pulse-text {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.75; }
    }

    @keyframes dots-bounce {
        0%, 80%, 100% { transform: scale(0.4); opacity: 0.3; }
        40% { transform: scale(1); opacity: 1; }
    }
</style>

<div id="loading-indicator" class="loading-indicator">
    <div class="loading-content">
        <div class="brand-spinner-wrapper">
            <div class="spinner-ring"></div>
            <div class="spinner-ring-inner"></div>
            <img class="brand-logo" src="{{ asset('build/admin/images/whi-green-horizontal.png') }}" alt="Carregando..." />
        </div>

        <h4 class="loading-title">
            {{ __('dashboard.message_sinc_load') }}
        </h4>

        <div class="loading-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>