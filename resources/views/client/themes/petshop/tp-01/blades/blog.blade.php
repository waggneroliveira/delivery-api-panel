

@extends($theme->core('client'))
@section('content')
   <div class="banner-inner blog container-fluid d-flex justify-content-center align-items-center flex-column position-relative" style="--banner-bg: url('../images/banner-blog.png');">
      <span class="color-yellow font-changa font-16 font-bold position-relative z-3 text-center">Blog </span>
      <h1 class="font-mobi font-changa font-40 font-bold text-white position-relative z-3 mt-2">Artigo Animal</h1>
      <p class="font-changa font-15 font-regular text-white position-relative z-3">Conheça um pouco sobre a gente aqui!</p>
   </div>
   <section id="news" class="pb-5">
      <div class="container p-3 p-lg-0">
         <div class="row mt-0 mt-lg-5 justify-content-between flex-column-reverse flex-lg-row">
            <div class="blog-content col-12 col-lg-8 mt-5 mt-lg-0">
               <div class="row g-4">
                  <div class="col-12">
                     @if (Route::currentRouteName() == 'blog-search')
                        <a href="{{ route('blog') }}" class="col-12 col-lg-2 text-center text-decoration-none d-block bg-green font-changa font-medium text-white py-2 font-15 rounded-2">Limpar filtro</a>
                     @endif
                  </div>

                  @foreach($blogAll as $blog)
                     <div class="col-6 col-md-6 col-lg-4 m-0 mb-2 mb-lg-0 mt-0 mt-lg-4">
                        <article class="post-card">
                              <a href="{{route('blog-inner', ['slug' => $blog->slug])}}">
                                 <img src="{{asset('storage/' . $blog->path_image_thumbnail)}}" alt="{{$blog->title}}">
                                 <div class="post-overlay">
                                    <h5 class="font-changa font-18 font-bold text-white mb-2 mb-lg-3">
                                       {{$blog->title}}
                                    </h5>
                                    <p class="font-16 font-regular text-white mb-1 mb-lg-3">
                                       {{substr(strip_tags($blog->text), 0, 100)}}
                                    </p>
                                    <span class="date font-16 font-regular text-white">
                                       {{ $blog->date->translatedFormat('d M Y') }}
                                    </span>
                                 </div>
                              </a>
                        </article>
                     </div>
                  @endforeach
         
               </div>
      
            </div>
      
            <aside class="col-12 col-lg-4 mb-3 mb-lg-0 d-flex justify-content-baseline align-items-end flex-column">
      
               <!-- Busca -->
               <div class="card border-0 shadow-sm mb-4 bg-grey-light col-12 col-lg-10">
                  <div class="card-body p-4">
                        <form action="{{route('blog-search')}}" class="position-relative" method="post">
                           @csrf
                           <input
                           type="search" name="search"
                              class="form-control rounded-3 ps-4 pe-5"
                              placeholder="Pesquise aqui..."
                           >
                           <button
                              type="submit"
                              class="btn position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 bg-transparent"
                           >
                              <i class="bi bi-search"></i>
                           </button>
                        </form>
                  </div>
               </div>
      
               <!-- Categorias -->
               @if ($blogCategories->count())               
                  <div class="card border-0 shadow-sm mb-4 bg-grey-light px-3 col-12 col-lg-10">
                     <div class="card-body">
                           <h5 class="font-changa font-24 font-bold mb-3 color-green">Categories</h5>
         
                           <ul class="list-unstyled mb-0">
                              @foreach ($blogCategories as $blogCategory)                           
                                 <li class="py-2 border-bottom">
                                    <a href="{{route('blog', ['category' => $blogCategory->slug])}}" class="d-flex justify-content-between d-flex text-decoration-none text-reset">
                                       <span class="font-changa font-16 font-semibold">{{$blogCategory->title}}</span>
                                       <span class="color-yellow font-changa font-16 font-semibold">{{$blogCategory->blogs->count()}}</span>
                                    </a>
                                 </li>
                              @endforeach
                           </ul>
                     </div>
                  </div>
               @endif

               <!-- Relacionados -->
               @if ($blogSeeAlso->count())               
                  <div class="card border-0 shadow-sm col-12 col-lg-10 relacionados bg-grey-light">
                     <div class="card-body">
                           <h5 class="font-changa color-green font-24 font-bold mb-3">Veja também</h5>
         
                           @foreach ($blogSeeAlso as $blogSeeToo)              
                              <div class="d-flex mb-3">
                                 <a href="{{route('blog-inner', ['slug' => $blogSeeToo->slug])}}" class="d-flex text-decoration-none text-reset">
                                    <div class="image me-2 rounded">
                                       <img src="{{asset('storage/' . $blogSeeToo->path_image_thumbnail)}}" class="me-3" alt="{{$blogSeeToo->title}}">
                                    </div>
                                    <div class="col-9">
                                       <h6 class="font-changa font-16 font-semibold">
                                          {{$blogSeeToo->title}}
                                       </h6>
                                       <small class="color-grey font-changa font-16 font-regular">{{ $blogSeeToo->date->translatedFormat('d M Y') }}</small>
                                    </div>
                                 </a>
                              </div>
                           @endforeach
                     </div>
                  </div>
               @endif
      
            </aside>
         </div>
      </div>
   </section>
@endsection