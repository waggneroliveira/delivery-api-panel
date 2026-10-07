@if($products->isEmpty())
    <div class="col-12 mt-5 text-center">
        <div class="alert alert-warning font-changa">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Nenhum produto encontrado para 
            <strong>{{ $title }}</strong>.
        </div>

        <div class="step-actions mt-3 d-flex justify-content-center">
            <a href="{{ route('products') }}" class="hover-zoom rounded-pill px-4 py-2 font-changa bg-button-two color-button-two font-15 font-medium text-decoration-none" rel="noopener noreferrer">
                Limpar filtros
                <svg class="ms-2" width="9" height="13" viewBox="0 0 9 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.78794 12.474L8.02494 6.237L1.78794 -1.90735e-06L0.02079 1.76715L4.46985 6.237L0 10.7068L1.78794 12.474Z" fill="var(--color-button-two)"/>
                </svg>
            </a>
        </div>
    </div>
@else
    @foreach ($products as $product)
        <div class="col-6 col-sm-6 col-lg-4 mb-4">
            <div class="product-card bg-accent-color shadow-sm rounded-3 p-2 p-lg-3 position-relative">
                <div class="image position-relative mb-0">
                    <img src="{{asset('storage/' . $product->path_image)}}" alt="{{$product->title}}" loading="lazy">
                </div>
                <div class="pt-3 pb-3 pb-lg-4">
                    <h6 class="font-changa font-18 font-semibold text-dark">{{$product->title}}</h6>
                    <p class="color-grey font-changa font-16 font-regular mb-0">{{substr(strip_tags($product->description), 0, 70)}}</p>
                </div>
                <a href="{{ route('client.product', ['category' => $product->category->slug, 'slug' => $product->slug]) }}" class="col-12">
                    <span class="bg-button-two color-button-two rounded-2 py-2 py-lg-3 px-2 px-lg-3 btn-view font-changa font-16 font-medium col-9 col-lg-8 d-flex align-items-center justify-content-center">
                        Comprar agora
                        <svg class="ms-2" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.77699 8.90909L5.01136 8.15341L8.16335 5.00142H0V3.90767H8.16335L5.01136 0.765624L5.77699 -7.15256e-07L10.2315 4.45454L5.77699 8.90909Z" fill="var(--color-button-two)"/>
                        </svg>
                    </span>                                    
                </a>
            </div>
        </div>
    @endforeach
@endif