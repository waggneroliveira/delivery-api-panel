@extends($theme->core('client'))

@section('content')
<style>
    header{
        background: var(--bg-header);
    }
</style>
<div class="banner-inner blog container-fluid d-flex justify-content-start align-items-center position-relative" style="--banner-bg: url({{asset('build/client/images/themes/ecommerce/banner-product.png')}});">
    <div class="container">
        <h1 class="font-mobi font-changa font-40 font-bold text-white position-relative z-3 mt-2 text-uppercase">Nossos Produtos</h1>
    </div>
</div>

<div class="container">
    <div class="row mt-5 justify-content-between">
        <div class="col-12 col-lg-3">

            <aside class="filter-aside col-12 col-lg-11">
                <!-- Categorias -->
                @if (isset($productCategories) && $productCategories->count())                    
                    <div class="filter-box mb-4 bg-secondary-color rounded-4 overflow-hidden">
                        <div class="filter-title filter-toggle bg-grey-medium d-flex justify-content-center align-items-center py-1">
                            <i class="bi bi-list"></i>
                            <span class="font-changa font-20 font-semibold color-green ms-2">Categorias</span>
                        </div>

                        <ul class="filter-list pb-2">
                            <li data-category="all" class="filter-item text-center text-white font-changa font-16 font-medium py-2 pb-0 filter-item {{ request('category') == null || request('category') == 'all' ? 'active' : '' }}">Todos</li>
                            @foreach ($productCategories as $category)                            
                                <li data-category="{{$category->slug}}" class="filter-item text-center text-white font-changa font-16 font-medium py-2 pb-0 {{ request('category') == $category->slug ? 'active' : '' }}">{{$category->title}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Marcas -->
                @if (isset($brands) && $brands->count())                    
                    <div class="filter-box mb-4 bg-secondary-color rounded-4 overflow-hidden">
                        <div class="filter-title filter-toggle bg-grey-medium d-flex justify-content-center align-items-center py-1">
                            <i class="bi bi-list"></i>
                            <span class="font-changa font-20 font-semibold color-green ms-2">Marcas</span>
                        </div>

                        <ul class="filter-list pb-2">
                            <li data-brand="all" class="text-center color-grey font-changa font-16 text-white font-medium py-2 pb-0 filter-brand {{ request('brand') == null || request('brand') == 'all' ? 'active' : '' }}" data-brand="all">Todas</li>
                            @foreach ($brands as $brand)                            
                                <li data-brand="{{$brand->slug}}" class="text-center color-grey font-changa font-16 text-white font-medium py-2 pb-0 filter-brand {{ request('brand') == $brand->slug ? 'active' : '' }}">{{$brand->title}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </aside>
            <script>
                document.querySelectorAll('.filter-toggle').forEach(title => {
                    title.addEventListener('click', () => {
                        const box = title.closest('.filter-box');
                        box.classList.toggle('active');
                    });
                });
            </script>

        </div>
        @if (isset($brands) && isset($productCategories))
            <div class="col-12 col-lg-9 {{ !$brands->count() && !$productCategories->count() ? 'w-100' : '' }}">
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-8">
                        <h2 id="products-title" class="about-title font-changa font-28 font-bold text-dark">{{$title}}</h2>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="search-wrapper w-100 justify-content-end">
                            <form action="">
                                <input 
                                    type="text" 
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control search-input font-changa font-16 font-medium color-grey search-field"
                                    placeholder="Pesquisar..."
                                >
                            </form>
                            <div class="bg-button-two color-button-two px-2 py-1 rounded-3">
                                <i class="bi bi-search search-icon text-white font-20"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Produtos -->
                <div id="products-container" class="row g-4 products mt-4 mb-5">
                    @include('client.themes.ecommerce.tp-02.includes.products')
                </div>
            </div>
        @endif
    </div>
</div>

<script>

    function applyFilters(params) {

        const url = new URL(window.location.href);

        Object.keys(params).forEach(key => {
            if (params[key]) {
                url.searchParams.set(key, params[key]);
            } else {
                url.searchParams.delete(key);
            }
        });

        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('products-container').innerHTML = data.html;
            document.getElementById('products-title').innerText = data.title;
            history.pushState({}, '', url);
        });
    }

    // Categoria
    document.querySelectorAll('.filter-item').forEach(item => {
        item.addEventListener('click', function () {

            const category = this.getAttribute('data-category');
            const brand = new URLSearchParams(window.location.search).get('brand');
            const search = new URLSearchParams(window.location.search).get('search');

            applyFilters({
                category: category === 'all' ? null : category,
                brand: brand,
                search: search
            });

        });
    });

    // Marca
    document.querySelectorAll('.filter-brand').forEach(item => {
        item.addEventListener('click', function () {

            const brand = this.getAttribute('data-brand');
            const category = new URLSearchParams(window.location.search).get('category');
            const search = new URLSearchParams(window.location.search).get('search');

            applyFilters({
                brand: brand === 'all' ? null : brand,
                category: category,
                search: search
            });

        });
    });

    // Search com debounce
    let debounceTimer;

    document.querySelector('.search-field').addEventListener('keyup', function() {

        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {

            const search = this.value;
            const category = new URLSearchParams(window.location.search).get('category');
            const brand = new URLSearchParams(window.location.search).get('brand');

            applyFilters({
                search: search.length ? search : null,
                category: category,
                brand: brand
            });

        }, 400);

    });

    document.querySelectorAll('.filter-item').forEach(el => el.classList.remove('active'));
    this.classList.add('active');
</script>
@endsection