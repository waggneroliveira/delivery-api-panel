@extends('client.core.client')
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