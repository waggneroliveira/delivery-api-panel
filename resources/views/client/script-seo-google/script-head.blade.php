{{-- Google Search Console --}}
@if (!empty($seoGoogle?->search_console))
    <meta
        name="google-site-verification"
        content="{{ $seoGoogle->search_console }}"
    >
@endif


{{-- Google Tag Manager --}}
@if (!empty($seoGoogle?->google_tag_manager))
    <script>
        (function(w,d,s,l,i) {
            w[l] = w[l] || [];

            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });

            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l !== 'dataLayer' ? '&l=' + l : '';

            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;

            f.parentNode.insertBefore(j, f);
        })(
            window,
            document,
            'script',
            'dataLayer',
            '{{ $seoGoogle->google_tag_manager }}'
        );
    </script>
@endif


{{-- Meta Pixel --}}
@if (!empty($seoGoogle?->meta_pixel))
    <script>
        !function(f,b,e,v,n,t,s)
        {
            if (f.fbq) return;

            n = f.fbq = function() {
                n.callMethod
                    ? n.callMethod.apply(n, arguments)
                    : n.queue.push(arguments)
            };

            if (!f._fbq) f._fbq = n;

            n.push = n;
            n.loaded = true;
            n.version = '2.0';
            n.queue = [];

            t = b.createElement(e);
            t.async = true;
            t.src = v;

            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s);
        }(
            window,
            document,
            'script',
            'https://connect.facebook.net/en_US/fbevents.js'
        );

        fbq('init', '{{ $seoGoogle->meta_pixel }}');
        fbq('track', 'PageView');
    </script>
@endif