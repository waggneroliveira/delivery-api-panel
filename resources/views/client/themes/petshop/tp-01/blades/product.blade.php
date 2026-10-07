@extends($theme->core('client'))

@section('content')
    @if (isset($product))
        <div class="banner-inner blog container-fluid d-flex justify-content-center align-items-center flex-column position-relative" style="--banner-bg: url('../images/banner-product.png');">
            <span class="color-yellow font-changa font-16 font-bold position-relative z-3 text-center">Produtos </span>
            <h1 class="font-mobi font-changa font-40 font-bold text-white position-relative z-3 mt-2">Catálogo</h1>
            <p class="font-changa text-center font-15 font-regular text-white position-relative z-3">Confira aqui a seleção dos nossos melhores produtos.</p>
        </div>
    
        <div class="container my-5">
            <div class="row g-4">
                @if ($product->galleries->count())
                    <!-- GALERIA -->
                    <div class="col-lg-5">
                        <div class="step-actions mt-4 d-flex justify-content-start mb-3">
                            <a href="{{route('products')}}" class="rounded-3 py-1 px-3 font-changa bg-green bg-button-two color-button-two font-18 font-medium text-decoration-none hover-zoom" rel="noopener noreferrer">
                                <svg class="me-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.23696 0L-3.8147e-05 6.237L6.23696 12.474L8.00411 10.7069L3.55505 6.237L8.0249 1.76715L6.23696 0Z" fill="var(--color-button-two)"/>
                                </svg>

                                Voltar
                            </a>
                        </div>
                        <div class="product-gallery p-0">
                            
                                <div class="custom-gallery-carousel position-relative">
                                    <div class="swiper gallery-top border rounded-4">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->galleries as $file)                                
                                                <div class="swiper-slide d-flex justify-content-center align-items-center"><img src="{{asset('storage/' . $file->file)}}" loading="lazy" alt="Imagem 1" /></div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Fim das setas -->
                                    <div class="mt-3 100 gap-1">
                                        <div class="swiper gallery-thumbs w-100">
                                            <div class="swiper-wrapper d-flex justify-content-center align-items-center">
                                                @foreach ($product->galleries as $file) 
                                                    <div class="swiper-slide thumbs-width"><img src="{{asset('storage/' . $file->file)}}" loading="lazy" alt="Thumb 1" class="w-100 h-100 cover" /></div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Setas de navegação do Swiper -->
                                    <div class="navigation-swiper">
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>
                                    </div>
                                </div>
                            

                            @if ($product->path_file <> null)                        
                                <div class="d-flex justify-content-center mt-4 btn-prod">
                                    <a href="{{asset('storage/' . $product->path_file)}}" class="btn-download-ficha rounded-pill px-4 bg-button-two color-button-two font-changa py-2 font-18 font-medium text-decoration-none">
                                        <svg class="me-2" width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.28975 9.17017C1.30848 9.53072 1.45344 9.87123 1.70426 10.1283L6.49015 15.0333C7.04555 15.6025 7.95515 15.6025 8.51054 15.0333L13.2964 10.1283C14.18 9.22192 13.5749 7.6319 12.2858 7.6319C11.9063 7.6319 11.544 7.78129 11.2752 8.05672L8.92907 10.4621V1.46592C8.92907 1.07699 8.77679 0.708085 8.51947 0.444363C7.53737 -0.533798 6.07158 0.23571 6.07158 1.46592V10.463L3.7246 8.05757C2.88827 7.19959 1.28975 7.66954 1.28975 9.17017ZM0.466453 17.457C-0.547411 18.4961 0.236799 20 1.43064 20H13.5708C14.8526 20 15.465 18.3842 14.5904 17.5136C14.307 17.2315 13.9706 17.0713 13.5708 17.0713L1.43064 17.0705C1.0715 17.0705 0.729482 17.2091 0.466453 17.457Z" fill="var(--color-button-two)"></path>
                                        </svg>
                                        Baixar Ficha Técnica
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif
                <!-- INFO PRODUTO -->
                <div class="col-lg-7 {{ !$product->galleries->count() ? 'w-100' : '' }}">

                    <h2 class="font-mobi font-changa text-center text-lg-start font-48 font-bold color-green">{{$product->title}}</h2>

                    <div class="mb-2 text-center text-lg-start ">
                        <span class="font-changa font-12 bg-button-two color-button-two px-2 rounded-0 font-medium">{{$product->category->title}}</span>
                        <span class="font-changa font-12 bg-button-two color-button-two px-2 rounded-0 font-medium">{{$product->brand->title}}</span>
                    </div>

                    <p class="color-grey text-center text-lg-start font-changa font-16 font-regular">
                        {{$product->description}}
                    </p>

                    <!-- TAMANHOS -->
                    <div class="mb-3">
                        <strong class="font-changa font-20 font-bold color-green text-center text-lg-start d-flex w-100 justify-content-center justify-content-lg-start">Tamanho</strong>

                        <div class="row flex-wrap justify-content-between mt-3">
                            <div class="btn-group m-auto m-lg-0 col-8 col-lg-5 justify-content-center justify-content-lg-start" role="group">
                                @php
                                    if (is_string($product->sizes)) {
                                        $sizes = json_decode($product->sizes, true);
                                    } else {
                                        $sizes = $product->sizes;
                                    }

                                    // Garante que seja array
                                    $sizes = is_array($sizes) ? $sizes : [];

                                    // Remove null, '', false etc
                                    $sizes = collect($sizes)
                                    ->filter()
                                    ->values()
                                    ->toArray();
                                @endphp

                                @if (!empty($sizes))
                                    @foreach($sizes as $size)
                                        <button class="btn btn-outline-secondary color-grey font-changa font-16 font-regular btn-sm me-2 rounded-2" style="max-width: 80px;">
                                            {{ $size }}
                                        </button>
                                    @endforeach
                                @else
                                    <i class="bi bi-exclamation-circle text-muted me-2"></i>
                                    <p class="color-grey text-center text-lg-start font-changa font-16 font-regular">
                                        Não disponível
                                    </p>
                                @endif
                            </div>

                            <div class="d-flex flex-wrap justify-content-center justify-content-lg-end mt-3 mt-lg-0 align-items-center col-12 col-lg-6">
                                @if ($product->path_file <> null && !$product->galleries->count())                        
                                    <div class="d-flex justify-content-center mt-0 btn-prod me-0 me-lg-2">
                                        <a href="{{asset('storage/' . $product->path_file)}}" class="btn-download-ficha rounded-pill py-2 px-4 font-changa bg-button-two color-button-two font-16 font-medium text-decoration-none hover-zoom">
                                            <svg class="me-2" width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.28975 9.17017C1.30848 9.53072 1.45344 9.87123 1.70426 10.1283L6.49015 15.0333C7.04555 15.6025 7.95515 15.6025 8.51054 15.0333L13.2964 10.1283C14.18 9.22192 13.5749 7.6319 12.2858 7.6319C11.9063 7.6319 11.544 7.78129 11.2752 8.05672L8.92907 10.4621V1.46592C8.92907 1.07699 8.77679 0.708085 8.51947 0.444363C7.53737 -0.533798 6.07158 0.23571 6.07158 1.46592V10.463L3.7246 8.05757C2.88827 7.19959 1.28975 7.66954 1.28975 9.17017ZM0.466453 17.457C-0.547411 18.4961 0.236799 20 1.43064 20H13.5708C14.8526 20 15.465 18.3842 14.5904 17.5136C14.307 17.2315 13.9706 17.0713 13.5708 17.0713L1.43064 17.0705C1.0715 17.0705 0.729482 17.2091 0.466453 17.457Z" fill="var(--color-button-two)"></path>
                                            </svg>
                                            Baixar Ficha Técnica
                                        </a>
                                    </div>
                                @endif
                                
                                <div class="w-auto m-auto m-lg-0 mt-3 mt-lg-0 d-flex justify-content-center gap-2 align-items-center btn-header bg-button-two color-button-two rounded-pill py-2 px-3 hover-zoom">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.6741 10.0755C11.5016 9.96226 11.3291 9.90566 11.1565 10.1321L10.4665 11.0377C10.2939 11.1509 10.1789 11.2075 9.94888 11.0943C9.08626 10.6415 7.87859 10.1321 6.84345 8.43396C6.78594 8.20755 6.90096 8.09434 7.01597 7.98113L7.53355 7.18868C7.64856 7.07547 7.59105 6.96226 7.53355 6.84906L6.84345 5.20755C6.67093 4.75472 6.4984 4.81132 6.32588 4.81132H5.86581C5.7508 4.81132 5.52077 4.86792 5.29073 5.09434C4.02556 6.33962 4.54313 8.09434 5.46326 9.22642C5.63578 9.45283 6.78594 11.4906 9.25879 12.566C11.099 13.3585 11.5016 13.2453 12.0192 13.1321C12.6518 13.0755 13.2843 12.566 13.5719 12.0566C13.6294 11.8868 13.9169 11.1509 13.6869 11.0377M9.14377 16.3585C6.78594 16.3585 5.00319 15.1132 5.00319 15.1132L2.1853 15.8491L2.8754 13.1321C2.8754 13.1321 1.72524 11.3774 1.72524 9.16981C1.72524 5.09434 5.11821 1.69811 9.31629 1.69811C13.2268 1.69811 16.5623 4.69811 16.5623 8.88679C16.5623 12.9623 13.2268 16.3019 9.14377 16.3585ZM0 18L4.77316 16.6981C6.15555 17.3947 7.69626 17.7309 9.24823 17.6747C10.8002 17.6184 12.3116 17.1715 13.6382 16.3768C14.9648 15.582 16.0622 14.4658 16.8259 13.1347C17.5895 11.8037 17.9937 10.3022 18 8.77359C18 3.90566 14.0895 0 9.14377 0C7.55639 0.00399723 5.99777 0.417245 4.62313 1.19859C3.24848 1.97993 2.10579 3.10211 1.30885 4.45336C0.511907 5.80461 0.0885224 7.33778 0.0808596 8.9002C0.0731969 10.4626 0.481524 11.9997 1.26518 13.3585" fill="var(--color-button-two)"></path>
                                    </svg>
        
                                    <a href="#" class="font-changa font-16 font-medium text-decoration-none">
                                        Saber mais agora!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr class="my-4">

                    <!-- DESCRIÇÃO -->
                    <div class="product-description">
                        <span class="desc-title bg-button-two color-button-two font-changa font-20 font-medium py-1 px-4 rounded-2 ms-4 position-relative">Descrição</span>

                        <div class="description rounded-3 p-4 mt-1">
                            <div class="color-grey font-changa font-16 font-regular">
                            {!!$product->text!!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <style>
        .product-description .desc-title:before{
            border-top: 15px solid var(--bg-button-two);
        }
    </style>
@endsection