@extends($theme->core('client'))
<style>
    header{
        background: var(--bg-header);
    }
    .mt-102{
        margin-top: 102px !important;
    }
</style>
@section('content')
    @if (isset($product))
        <div class="container mb-5">
            <div class="row g-4 mt-102">
                @if ($product->galleries->count())
                    <!-- GALERIA -->
                    <div class="step-actions mt-5 d-flex justify-content-start mb-0 col-12">
                        <a href="{{route('products')}}" class="rounded-2 py-2 px-4 font-changa bg-green bg-button-two color-button-two font-16 font-medium text-decoration-none hover-zoom" rel="noopener noreferrer">

                            <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45458 0L5.2202 0.755682L2.06821 3.90767H10.2316V5.00142H2.06821L5.2202 8.14347L4.45458 8.90909L3.31402e-05 4.45455L4.45458 0Z" fill="var(--color-button-two)"/>
                            </svg>


                            Voltar
                        </a>
                    </div>
                    <div class="col-lg-5 mt-5">
                        <div class="product-gallery p-0 col-12 col-lg-11">
                            <!-- Removido o h-100 do wrapper para evitar conflito de altura relativa -->
                            <div class="custom-gallery-carousel position-relative">
                                
                                <!-- Swiper Principal -->
                                <div class="swiper gallery-top p-0 bg-accent-color rounded-4">
                                    <div class="swiper-wrapper">
                                        @foreach ($product->galleries as $file)                
                                            <div class="swiper-slide">
                                                <div class="w-personlizado h-personlizado m-auto">
                                                    <img src="{{asset('storage/' . $file->file)}}" loading="lazy" alt="Imagem do produto" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Swiper Thumbs -->
                                <div class="mt-3">
                                    <div class="swiper gallery-thumbs">
                                        <div class="swiper-wrapper gap-2">
                                            @foreach ($product->galleries as $file) 
                                                <div class="swiper-slide">
                                                    <img src="{{asset('storage/' . $file->file)}}" loading="lazy" alt="Thumb" />
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Setas de navegação -->
                                <div class="navigation-swiper">
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>

                            @if ($product->path_file != null)        
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
                        <span class="font-changa font-12 bg-dark text-white px-2 rounded-0 font-medium">{{$product->category->title}}</span>
                        <span class="font-changa font-12 bg-dark text-white px-2 rounded-0 font-medium">{{$product->brand->title}}</span>
                    </div>

                    <!-- DESCRIÇÃO -->
                    <div class="product-description">

                        <div class="description rounded-3 mt-4">
                            <div class="color-grey font-changa font-16 font-regular">
                            {!!$product->text!!}
                            </div>
                        </div>
                    </div>

                    <!-- Disponível em: -->
                    <div class="mb-3">
                        <div class="row flex-wrap justify-content-between mt-5">
                            <div class="btn-group m-auto m-lg-0 col-8 col-lg-5 flex-column justify-content-center justify-content-lg-end" role="group">
                                <strong class="font-changa font-20 font-medium color-green text-center text-lg-start d-flex w-100 justify-content-center justify-content-lg-start">Disponível em:</strong>

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
                                <div class="col-12">
                                    @if (!empty($sizes))
                                        @foreach($sizes as $size)
                                            <button class="btn btn-outline-secondary color-grey font-changa font-16 font-regular btn-sm px-3 mt-2 me-2 rounded-2" style="max-width: 80px;">
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
                            </div> 

                            @if (isset($product->link) && $product->link <> null)                                
                                <div class="d-flex flex-wrap justify-content-center justify-content-lg-end mt-3 mt-lg-0 align-items-center col-12 col-lg-6">                               
                                    <div class="w-auto m-auto m-lg-0 mt-3 mt-lg-0 d-flex justify-content-center gap-2 align-items-center btn-header bg-button-two color-button-two rounded-2 py-3 px-3 hover-zoom">       
                                        <a href="{{$product->link}}" target="_blank" rel="noopener noreferrer" class="font-changa font-16 font-medium text-decoration-none">
                                            Comprar agora
                                        </a>
                                        <svg class="ms-2" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-two)"/>
                                        </svg>
                                    </div>
                                </div>                                                       
                            @endif
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