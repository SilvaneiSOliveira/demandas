<!DOCTYPE html>
<html lang="pt-br">
<head>
    {{-- Cabeçalho normal --}}
</head>
<body>

    {{-- Aqui o loading --}}
    <x-loading />

    {{-- Aqui vai o conteúdo da página --}}
    <main>
        @yield('content')
    </main>

    {{-- Scripts --}}
    <script>
        function mostrarLoading() {
            document.getElementById("loading").style.display = "block";
        }

        function esconderLoading() {
            document.getElementById("loading").style.display = "none";
        }

        // Exemplo: mostra loading ao clicar em qualquer link
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mostrarLoading();
            });
        });
    </script>

</body>
</html>
