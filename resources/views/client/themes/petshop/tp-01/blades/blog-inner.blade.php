

@extends($theme->core('client'))
@section('content')
   <div class="banner-inner blog container-fluid d-flex justify-content-center align-items-center flex-column position-relative" style="--banner-bg: url('../images/banner-blog.png');">
      <span class="color-yellow font-changa font-16 font-bold position-relative z-3 text-center">Blog </span>
      <h1 class="font-mobi font-changa font-40 font-bold text-white position-relative z-3 mt-2">Artigo Animal</h1>
      <p class="font-changa font-15 font-regular text-white position-relative z-3">Conheça um pouco sobre a gente aqui!</p>
   </div>
   <section id="news" >
      <div class="container p-3 p-lg-0">
         <div class="row mt-0 mt-lg-5 justify-content-between flex-column-reverse flex-lg-row">
            <div class="blog-content col-12 col-lg-8 mt-5 mt-lg-0">
               <div class="row g-4">
                  <div class="position-relative mb-3">
                     <article>
                           <img class="img-fluid rounded-3 w-100 image-inner d-flex justify-content-center align-items-center mb-4" src="{{asset('storage/' . $blogInner->path_image)}}" alt="{{$blogInner->title}}" loading="lazy">
                           <h2 class="mb-3 font-changa font-30 font-bold">{{$blogInner->title}}</h2>

                           <div class="color-grey font-changa font-16 font-regular">
                              {!! $blogInner->text !!}
                           </div>                         
                     </article>

                     <div class="d-flex justify-content-between align-items-center">
                           <a href="{{route('blogAll')}}" class="bg-button-two color-button-two font-medium font-changa font-16 d-flex justify-content-between text-decoration-none align-items-center gap-2 py-2 px-3 rounded-3 hover-zoom">
                              <svg width="15" height="15" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1926 2.20441L2.32113 10.6069C2.05923 10.7927 2.05923 11.2059 2.32113 11.3917L14.1926 19.7941C14.4739 19.9924 14.8716 19.8011 14.8716 19.4017V2.59536C14.8716 2.19742 14.4725 2.00613 14.1926 2.20441ZM1.09904 8.87649L12.9705 0.474006C14.6832 -0.737844 17 0.519764 17 2.59681V19.4032C17 21.4803 14.6831 22.7378 12.9705 21.526L1.09904 13.1221C-0.365655 12.085 -0.367038 9.91502 1.09904 8.87649Z" fill="var(--color-button-two)"></path>
                              </svg>
                              Voltar
                           </a>

                           <div class="position-relative d-flex justify-content-center align-items-end flex-column">
                              <a id="shareBtn" class="hover-zoom font-medium font-changa font-16 d-flex justify-content-around align-items-center bg-button-two color-button-two py-2 px-3 rounded-3">
                                 <svg class="me-2" width="18" height="20" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841ZM19.7148 18.4846C21.3788 18.4846 22.7326 19.8779 22.7326 21.5905C22.7326 23.303 21.3788 24.6963 19.7148 24.6963C18.0508 24.6963 16.697 23.303 16.697 21.5905C16.697 21.0605 16.8273 20.5611 17.0556 20.1231C17.0556 20.1231 17.0594 20.1167 17.0618 20.1167C17.0618 20.1129 17.0618 20.1065 17.068 20.1039C17.583 19.1397 18.5732 18.4859 19.7136 18.4859L19.7148 18.4846ZM19.7148 1.30799C21.3788 1.30799 22.7326 2.70127 22.7326 4.41383C22.7326 6.12639 21.3788 7.51967 19.7148 7.51967C18.0508 7.51967 16.697 6.12639 16.697 4.41383C16.697 2.70127 18.0508 1.30799 19.7148 1.30799ZM4.28845 16.1081C2.62444 16.1081 1.27065 14.7149 1.27065 13.0023C1.27065 11.2897 2.62444 9.89646 4.28845 9.89646C5.95247 9.89646 7.30626 11.2897 7.30626 13.0023C7.30626 13.5348 7.17596 14.0355 6.94393 14.4735C6.94393 14.4735 6.94393 14.4773 6.94021 14.4799C6.94021 14.4799 6.94021 14.4863 6.93648 14.4863C6.42524 15.4504 5.42758 16.1081 4.28724 16.1081L4.28845 16.1081Z" fill="var(--color-button-two)"></path>
                                 </svg>
                                 Compartilhar
                              </a>
                              <div id="socialLinks" class="socialLinks mt-2 opacity-0">
                                 <div class="d-flex gap-2">
                                       <a href="" target="_blank" class="d-flex justify-content-center align-items-center p-0 btn btn-sm bg-whatsapp"><i class="fab fa-whatsapp text-white"></i></a>    
                                       <a href="" target="_blank" class="d-flex justify-content-center align-items-center p-0 btn btn-sm btn-twiter"><i class="fab fa-x-twitter text-white"></i></a>
                                       <a href="" target="_blank" class="d-flex justify-content-center align-items-center p-0 btn btn-facebook btn-sm"><i class="fab fa-facebook-f text-white"></i></a>
                                 </div>
                              </div>
                           </div>
                     </div>
                     
                  </div>      
               </div>
      
            </div>
      
            <aside class="col-12 col-lg-4 mb-3 mb-lg-0 d-flex justify-content-baseline align-items-end flex-column">
      
               <!-- Busca -->
               <div class="card border-0 shadow-sm mb-4 bg-grey-light col-12 col-lg-10">
                  <div class="card-body p-4">
                        <form class="position-relative">
                           <input
                              type="text"
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
                                    <a href="{{route('blog', ['category' => $blogCategory->slug])}}" class="d-flex justify-content-between text-decoration-none text-reset">
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
               @if ($blogRelacionados->count())               
                  <div class="card border-0 shadow-sm col-12 col-lg-10 relacionados bg-grey-light">
                     <div class="card-body">
                           <h5 class="font-changa font-24 font-bold mb-3 color-green">Relacionados</h5>
         
                           @foreach ($blogRelacionados as $relacionado)  
                              <div class="mb-3">
                                 <a href="{{route('blog-inner', ['slug' => $relacionado->slug])}}" class="d-flex text-decoration-none text-reset">
                                    <div class="image me-2 rounded">
                                       <img src="{{asset('storage/' . $relacionado->path_image)}}" class="me-3" alt="{{$relacionado->title}}">
                                    </div>
                                    <div class="col-9">
                                       <h6 class="font-changa font-16 font-semibold">
                                          {{$relacionado->title}}
                                       </h6>
                                       <small class="color-grey font-changa font-16 font-regular">{{ $relacionado->date->translatedFormat('d M Y') }}</small>
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