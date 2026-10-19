

@extends($theme->core('client'))
@section('content')
   <section id="news" class="pb-5">
      <div class="container p-3 p-lg-0">
         <div class="row mt-0 mt-lg-4 justify-content-between flex-column-reverse flex-lg-row">
            <div class="blog-content col-12 col-lg-9 mt-5 mt-lg-0">
               <div class="row g-4">                  
                  <div class="d-flex justify-content-between align-items-center {{Route::currentRouteName() == 'blog' || Route::currentRouteName() == 'blog-search' ? 'mb-4' : 'mb-0'}}">
                     @if (Route::currentRouteName() == 'blog')
                        <div class="badge bg-accent-color px-3 py-2 rounded-0">
                           <h2 class="font-28 text-dark mb-0">Categoria: {{ $blogAll->first()?->category?->title }}</h2>
                        </div>
                     @endif
                     @if (Route::currentRouteName() == 'blog-search')
                        <a href="{{ route('blogAll') }}" class="col-12 col-lg-2 text-center text-decoration-none d-block bg-button-one color-button-one font-changa font-medium py-2 font-15 rounded-0">Limpar filtro</a>
                     @endif
                  </div>

                  @if($blogAll->hasPages())
                     <div class="row mt-0 mb-3 p-0">
                        <div class="col-12 d-flex justify-content-end p-0">
                              {{ $blogAll->links() }}
                        </div>
                     </div>
                  @endif

                  <!-- Tags Start -->
                     @include('client.themes.blog.tp-01.includes.blog-box')  
                  <!-- Tags End --> 

                  @if($blogAll->hasPages())
                     <div class="row mt-0 p-0">
                        <div class="col-12 d-flex justify-content-end p-0">
                              {{ $blogAll->links() }}
                        </div>
                     </div>
                  @endif

                  @if (isset($announcements['center-bottom']) && $announcements['center-bottom']->isNotEmpty())
                     <div class="ad-container mt-3 mb-0 bg-transparent border-0">
                        <div class="ad-placeholder overflow-hidden bg-transparent">
                           <!-- Espaço para Banner Adsense -->
                           @includeIf('client.components.announcement.all-announcement',[
                                    'announcements' => $announcements['center-bottom'] ?? collect()
                                 ]
                           )
                        </div>
                     </div>
                  @endif
               </div>
      
            </div>
      
            <aside class="col-lg-3 col-12">
      
               <!-- Tags Start -->
                  @include('client.themes.blog.tp-01.includes.category-aside')  
               <!-- Tags End -->

               <!-- Relacionados -->
                  @include('client.themes.blog.tp-01.includes.view-see-also')  
               <!-- Relacionados End -->


               <!-- Ads Start -->
                  @if ($announcements->count())                        
                     <div class="mb-0">
                           <div class="ad-placeholder overflow-hidden px-3" style="min-height: 250px">
                              <!-- Anúncio 300x250 -->  
                              @includeIf('client.components.announcement.all-announcement',[
                                       'announcements' => $announcements['sidebar-right'] ?? collect()
                                 ]
                              )
                           </div>
                     </div>
                  @endif
               <!-- Ads End -->

               <!-- Newsletter Start -->
                  @include('client.themes.blog.tp-01.includes.newsletter')
               <!-- Newsletter End -->
      
            </aside>
         </div>
      </div>
   </section>

   <style>
      .hidden div span span[aria-current="page"] span,
      .relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-r-md.leading-5 {
         background: var(--bg-button-one) !important;
      }
   </style>
@endsection