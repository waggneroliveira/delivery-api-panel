@if ($announcements->isNotEmpty())
    <div class="swiper announcement-swiper">
        <div class="swiper-wrapper">

            @foreach ($announcements as $item)
                <div class="swiper-slide">

                    @if ($item->link)
                        <a
                            href="{{ $item->link }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="d-block w-100"
                        >
                    @endif

                    <picture class="d-block w-100">
                        @if ($item->path_image_mobile)
                            <source
                                media="(max-width: 767.98px)"
                                srcset="{{ asset('storage/' . $item->path_image_mobile) }}"
                            >
                        @endif

                        <img
                            src="{{ asset('storage/' . $item->path_image) }}"
                            class="d-block w-100"
                            width="355"
                            height="433"
                            alt="Anúncio"
                            fetchpriority="high"
                        >
                    </picture>

                    @if ($item->link)
                        </a>
                    @endif

                </div>
            @endforeach

        </div>
    </div>
@endif