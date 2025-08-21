<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png"/>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Demandas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background-image: url('{{ asset('images/fundo_login.jpg') }}');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }

            .overlay {
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                width: 100%;
                max-width: 380px;
                padding: 2.5rem;
            }

            .login-logo {
                display: block;
                margin: 0 auto 2rem auto;
                max-height: 70px;
                width: auto;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <div class="overlay">
            <!-- Apenas a logo (que já contém o nome "Demandas") -->
            <img src="{{ asset('images/log.png') }}" alt="Demandas" class="login-logo">
            
            
            {{ $slot }}
        </div>
    </body>
</html>