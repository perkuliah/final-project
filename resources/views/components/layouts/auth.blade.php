<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('brutalist/style.css') }}">
        @livewireStyles
        <title>@yield('title', 'Login')</title>
    </head>
    <body>
        
        {{ $slot }}

        <script src="{{ asset('brutalist/script.js') }}"></script>
        <script src="{{ asset('brutalist/form-utils.js') }}"></script>
        @livewireScripts
    </body>
</html>
