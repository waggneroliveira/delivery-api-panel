{{-- Google Tag Manager --}}
@if (!empty($seoGoogle?->google_tag_manager))
    <noscript>
        <iframe
            src="https://www.googletagmanager.com/ns.html?id={{ $seoGoogle->google_tag_manager }}"
            height="0"
            width="0"
            style="display:none;visibility:hidden"
        ></iframe>
    </noscript>
@endif


{{-- Meta Pixel --}}
@if (!empty($seoGoogle?->meta_pixel))
    <noscript>
        <img
            height="1"
            width="1"
            style="display:none"
            src="https://www.facebook.com/tr?id={{ $seoGoogle->meta_pixel }}&ev=PageView&noscript=1"
            alt=""
        />
    </noscript>
@endif