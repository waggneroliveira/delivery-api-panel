{{-- Carrossel para MOBILE --}}
<div class="col-12 d-block d-sm-none">
    <div class="swiper announcement-mobile w-100">
        <div class="swiper-wrapper">
            @foreach ($announcements->where('exhibition', 'mobile') as $announcement)
                <div class="swiper-slide py-0">
                    <div class="image rounded-0 overflow-hidden">
                        @if (!empty($announcement->link))
                            <a href="{{ $announcement->link }}" target="_blank" rel="nofollow noopener noreferrer">
                                <img src="{{ asset('storage/' . $announcement->path_image) }}"
                                     alt="Anuncio-{{ $announcement->id }}" class="w-100">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $announcement->path_image) }}"
                                 alt="Anuncio-{{ $announcement->id }}" class="w-100">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Carrossel para DESKTOP --}}
<div class="col-12 d-none d-sm-block">
    <div class="swiper announcement-desktop w-100">
        <div class="swiper-wrapper">
            @foreach ($announcements->where('exhibition', 'horizontal') as $announcement)
                <div class="swiper-slide py-0">
                    <div class="image rounded-0 overflow-hidden">
                        @if (!empty($announcement->link))
                            <a href="{{ $announcement->link }}" target="_blank" rel="nofollow noopener noreferrer">
                                <img src="{{ asset('storage/' . $announcement->path_image) }}"
                                     alt="Anuncio-{{ $announcement->id }}" class="w-100">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $announcement->path_image) }}"
                                 alt="Anuncio-{{ $announcement->id }}" class="w-100">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .swiper.announcement-mobile{
            width: 95% !important;
        }
    }
</style>