<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    

    <!-- Scripts e Estilos -->
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])

    
</head>
        <body class="font-sans antialiased">
        {{-- LOADING PERSONALIZADO --}}
       <div id="loading" class="fixed inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center z-[9999] no-loading-page" style="display: none;">
                <div class="w-16 h-16 border-4 border-t-blue-500 border-white rounded-full animate-spin"></div>
                <h1 class="text-2xl font-bold tracking-widest">Demandas</h1>
                <p class="text-sm text-gray-300">Carregando, só um instante...</p>
            </div>
        </div>

       <div class="flex h-screen bg-gray-100 overflow-hidden">
            @include('layouts.navigation') <!-- Menu lateral -->

            <!-- Conteúdo principal com ID pra animar a margem -->
            <div id="wrapper" class="flex-1 flex flex-col transition-all duration-300 pl-64">
                @isset($header)
                    <header class="bg-white shadow mb-4 rounded p-4">
                        <div class="w-full mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 p-6 overflow-auto">
                    @yield('content')
                </main>
            </div>
       </div>





    {{-- LOADING SCRIPT --}}
    <script>
        function mostrarLoading() {
            document.getElementById("loading").style.display = "flex";
        }

        function esconderLoading() {
            document.getElementById("loading").style.display = "none";
        }

        // Mostrar loading ao clicar em links ou botões
        document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('a, button[type="submit"]').forEach(el => {
        el.addEventListener('click', (e) => {
            // Se for link com target="_blank", ignora
                    if (el.tagName === 'A' && el.target === '_blank') {
                        return;
                    }
                    // Se tiver o atributo data-no-loading, ignora
                    if (el.hasAttribute('data-no-loading')) {
                        return;
                    }

                    mostrarLoading();
                });
            });
        });


    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const botaoColapsar = document.getElementById("botao-colapsar-menu"); 
    const menu = document.getElementById("menu-lateral");
    const conteudo = document.getElementById("conteudo-principal");

        if (botaoColapsar) {
            botaoColapsar.addEventListener("click", function () {
                menu.classList.toggle("w-64");
                menu.classList.toggle("w-16");
            });
        }
    });

    </script>

@yield('scripts')
</body>
</html>
