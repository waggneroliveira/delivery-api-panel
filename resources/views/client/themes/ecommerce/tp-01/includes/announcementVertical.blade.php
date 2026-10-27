
<div class="swiper announcementVertical">
    <div class="swiper-wrapper">
        @foreach ($announcementVerticals as $announcement)  
            @if ($announcement->path_image != null)                
                <div class="swiper-slide">
                    <div class="text-center px-0 overflow-hidden">
                        @if(isset($announcement) && !empty($announcement->link))
                            <a href="{{ $announcement->link }}" target="_blank" rel="nofollow noopener noreferrer">
                                <img loading="lazy" src="{{ asset('storage/' . $announcement->path_image) }}" alt="Anuncio-{{ $announcement->id }}" class="img-fluid w-100 annun">
                            </a>
                        @else
                            <img loading="lazy" src="{{ asset('storage/' . $announcement->path_image) }}" alt="Anuncio-{{ $announcement->id }}" class="img-fluid w-100 annun">
                        @endif
                    </div>
                </div>
            @endif              
        @endforeach
    </div>
</div>
