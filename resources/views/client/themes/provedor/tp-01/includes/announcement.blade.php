<div class="col-12">
    <div class="swiper announcement w-75">
        <div class="swiper-wrapper">
            @foreach ($announcements as $announcement)                
                <div class="swiper-slide py-5">
                    <div class="image rounded-3 overflow-hidden">
                        @if(isset($announcement))
                            <style>
                                @media (max-width: 576px) {
                                    .hide-on-mobile-if-no-mobile-image,
                                    .swiper.announcement {
                                        display: none !important;
                                    }
                                }
                            </style>

                            @php
                                $hideOnMobile = empty($announcement->path_image_mobile) ? 'hide-on-mobile-if-no-mobile-image' : '';
                            @endphp

                            @if (!empty($announcement->link))
                                <a href="{{ $announcement->link }}" target="_blank" rel="nofollow noopener noreferrer">
                                    <picture>
                                        @if ($announcement->path_image_mobile)
                                            <source media="(max-width: 576px)" srcset="{{ asset('storage/' . $announcement->path_image_mobile) }}">
                                        @endif
                                        <img src="{{ asset('storage/' . $announcement->path_image) }}" alt="Anuncio-{{ $announcement->id }}" class="w-100 {{ $hideOnMobile }}">
                                    </picture>
                                </a>
                            @else
                                <picture>
                                    @if ($announcement->path_image_mobile)
                                        <source media="(max-width: 576px)" srcset="{{ asset('storage/' . $announcement->path_image_mobile) }}">
                                    @endif
                                    <img src="{{ asset('storage/' . $announcement->path_image) }}" alt="Anuncio-{{ $announcement->id }}" class="w-100 {{ $hideOnMobile }}">
                                </picture>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
