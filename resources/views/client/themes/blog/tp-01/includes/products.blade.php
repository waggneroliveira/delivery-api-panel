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
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="product-card bg-white shadow-sm rounded-3">
                <div class="image position-relative mb-0">
                    <img src="{{asset('storage/' . $product->path_image)}}" alt="{{$product->title}}">
                </div>
                <div class="py-3">
                    <h6 class="font-changa font-18 font-semibold primary-color">{{$product->title}}</h6>
                    <p class="color-grey font-changa font-16 font-regular mb-0">{{$product->description}}</p>
                </div>
                <a href="{{ route('client.product', ['category' => $product->category->slug, 'slug' => $product->slug]) }}" class="col-12">
                    <span class="bg-button-two color-button-two btn-view font-changa font-16 font-medium col-10 col-lg-5 hover-zoom">Ver Produto</span>
                </a>
            </div>
        </div>
    @endforeach
@endif