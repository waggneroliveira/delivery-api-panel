@if ($latestNews->count() > 0)  
    <div class="row" id="news-grid">
        @foreach($latestNews as $news)
            @php
                \Carbon\Carbon::setLocale('pt_BR');
                $dataFormatada = \Carbon\Carbon::parse($news->date)->translatedFormat('d \d\e F \d\e Y');
            @endphp
            <article class="col-12 col-sm-12 col-md-6">
                <div class="d-flex flex-column align-items-center bg-white mb-4 overflow-hidden position-relative">
                    <div class="position-absolute mt-2 start-0">
                        <span class="badge rounded-0 badge-primary poppins-semiBold font-10 text-uppercase py-2 px-2 mr-2 background-red">
                            {{ $news->category->title }}
                        </span>
                    </div>
                    <img loading="lazy" class="img-fluid w-100 rounded-1"
                    src="{{ $news->path_image_thumbnail ? asset('storage/' . $news->path_image_thumbnail) : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                    alt="{{ $news->title }}"
                    style="height: 232px;aspect-ratio:1/1;object-fit: cover;">
                    <div class="col-12 my-3 h-100 px-0 d-flex flex-column justify-content-center position-relative">                        
                        <a href="{{ route('blog-inner', $news->slug) }}" class="underline">
                            <h3 class="h6 m-0 poppins-bold font-14 title-blue">
                                {{ Str::limit($news->title, 60) }}
                            </h3>
                        </a>
                        <p class="text-color my-3 poppins-regular font-15">
                                {!! substr(strip_tags($news->text), 0, 200) !!}...
                        </p>

                        <div class="d-flex justify-content-between align-items-center w-100">
                            <p class="text-color mb-0 poppins-regular font-12 col-8">{{$dataFormatada}}</p>
                            
                            <div id="socialLinks-filter-{{$news->id}}" class="social-links home opacity-0">
                                <div class="d-flex gap-2">
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . route('blog-inner', ['slug' => $news->slug])) }}" 
                                    target="_blank" 
                                    class="rounded-circle btn btn-sm bg-whatsapp bg-transparent p-0">
                                        <i class="fab fa-whatsapp text-dark"></i>
                                    </a>

                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog-inner', ['slug' => $news->slug])) }}&text={{ urlencode($news->title) }}" 
                                    target="_blank" 
                                    class="rounded-circle btn btn-sm btn-twiter bg-transparent p-0">
                                        <i class="fab fa-x-twitter text-dark"></i>
                                    </a>

                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog-inner', ['slug' => $news->slug])) }}" 
                                    target="_blank" 
                                    class="rounded-circle btn btn-facebook btn-sm bg-transparent p-0">
                                        <i class="fab fa-facebook-f text-dark"></i>
                                    </a>
                                </div>
                            </div>  

                            <button id="btnShare-filter-{{$news->id}}" 
                                    data-target="socialLinks-filter-{{$news->id}}"
                                    class="share-button d-flex">
                                <svg width="18" height="20" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841ZM19.7148 18.4846C21.3788 18.4846 22.7326 19.8779 22.7326 21.5905C22.7326 23.303 21.3788 24.6963 19.7148 24.6963C18.0508 24.6963 16.697 23.303 16.697 21.5905C16.697 21.0605 16.8273 20.5611 17.0556 20.1231C17.0556 20.1231 17.0594 20.1167 17.0618 20.1167C17.0618 20.1129 17.0618 20.1065 17.068 20.1039C17.583 19.1397 18.5732 18.4859 19.7136 18.4859L19.7148 18.4846ZM19.7148 1.30799C21.3788 1.30799 22.7326 2.70127 22.7326 4.41383C22.7326 6.12639 21.3788 7.51967 19.7148 7.51967C18.0508 7.51967 16.697 6.12639 16.697 4.41383C16.697 2.70127 18.0508 1.30799 19.7148 1.30799ZM4.28845 16.1081C2.62444 16.1081 1.27065 14.7149 1.27065 13.0023C1.27065 11.2897 2.62444 9.89646 4.28845 9.89646C5.95247 9.89646 7.30626 11.2897 7.30626 13.0023C7.30626 13.5348 7.17596 14.0355 6.94393 14.4735C6.94393 14.4735 6.94393 14.4773 6.94021 14.4799C6.94021 14.4799 6.94021 14.4863 6.93648 14.4863C6.42524 15.4504 5.42758 16.1081 4.28724 16.1081L4.28845 16.1081Z" fill="#282828"/>
                                </svg>
                            </button>                                                                                                      
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif