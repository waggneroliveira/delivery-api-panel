@php($themeManager = app(\App\Services\ThemeManager::class))
@extends($themeManager->core('client'))
@section('content')
    <style>
        .announcement{
            display: none;
        }
    </style>

    <script>
        setTimeout(function() {
            window.location.href = '/noticias';
        }, 2500);
    </script>

@endsection