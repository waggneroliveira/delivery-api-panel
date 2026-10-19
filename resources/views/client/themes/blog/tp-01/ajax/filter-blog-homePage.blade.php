<div class="tab-content">
    <!-- - -->
    <div class="tab-pane fade show active" id="tab1-{{$category->id}}" role="tabpanel">
        <div class="row mt-5">
            <div class="col-sm-6 p-r-25 p-r-15-sr991">

                <div class="featured-blog-container">
                    @foreach($category->blogs as $blog)
                        <div
                            class="featured-blog m-b-30 {{ $loop->first ? '' : 'd-none' }}"
                            data-blog-id="{{ $blog->id }}"
                            data-subcategory-id="{{ $blog->blog_subcategory_id }}"
                        >

                            <a href="#" class="wrap-pic-w hov1 trans-03">
                                <img
                                    src="{{ $blog->path_image ? asset('storage/' . $blog->path_image) : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                                    alt="{{ $blog->title }}"
                                    width="470"
                                    height="290"
                                    style="object-fit: cover;"
                                >
                            </a>

                            <div class="mt-2">
                                <h5 class="p-b-5">
                                    <a href="#" class="poppins-semiBold font-18">
                                        {{ $blog->title }}
                                    </a>
                                </h5>

                                <span class="cl8">
                                    <span class="f1-s-3">
                                        {{ \Carbon\Carbon::parse($blog->date)->locale('pt_BR')->translatedFormat('d \d\e F \d\e Y') }}
                                    </span>
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>


            <div class="col-sm-6 p-r-25 p-r-15-sr991">

                <div class="blog-list-container">

                    @foreach($category->blogs as $blog)
                        <a href="#" class="size-w-1 wrap-pic-w hov1 trans-03">                            
                            <div
                                class="blog-item d-flex gap-3 mb-3 {{ $loop->first ? 'd-none' : '' }}"
                                data-blog-id="{{ $blog->id }}"
                                data-subcategory-id="{{ $blog->blog_subcategory_id }}"
                            >                           
                                <img
                                    loading="lazy"
                                    src="{{ $blog->path_image ? asset('storage/' . $blog->path_image) : 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                                    alt="{{ $blog->title }}"
                                    width="100"
                                    height="75"
                                    style="object-fit: cover;"
                                >

                                <div class="size-w-2">
                                    <h5 class="poppins-bold font-14">
                                        {{ $blog->title }}
                                    </h5>

                                    <span class="cl8">
                                        <small class="font-12">
                                            {{ isset($blog->subcategory->name) ? $blog->subcategory->name . ' - ' : '' }}

                                            {{ \Carbon\Carbon::parse($blog->date)->format('d') }}

                                            {{ ucfirst(mb_substr(\Carbon\Carbon::parse($blog->date)->locale('pt_BR')->translatedFormat('F'), 0, 3)) }}

                                            {{ \Carbon\Carbon::parse($blog->date)->format('Y') }}
                                        </small>
                                    </span>
                                </div>

                        </div>
                        </a>
                    @endforeach

                </div>

            </div>

        </div>
    </div>
</div>
