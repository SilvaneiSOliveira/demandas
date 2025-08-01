@extends('layouts.app')

@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
    <div class="bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Consulta de Clientes</h2>

        {{-- Filtro Global --}}
        <form action="{{ route('clientes.index') }}" method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <input type="text" name="filtro" value="{{ request('filtro') }}" placeholder="Buscar por nome, CNPJ ou razão social"
                    class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Buscar</button>
            </div>
        </form>

        {{-- Mensagem de sucesso --}}
            @if (session('success'))
                <div id="mensagem-sucesso" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        <script>
    setTimeout(function () {
        var mensagem = document.getElementById('mensagem-sucesso');
        if (mensagem) {
            mensagem.style.transition = 'opacity 0.5s ease';
            mensagem.style.opacity = 0;

            setTimeout(function () {
                mensagem.remove();
            }, 500); // tempo pra remover do DOM depois de sumir visualmente
        }
    }, 5000); // 5 segundos
</script>

        {{-- Lista de Clientes --}}
        @if ($clientes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Nome</th>
                            <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">CNPJ</th>
                            <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Razão Social</th>
                            <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Cidade</th>
                            <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">UF</th>
                            <th class="bg-gray-700 text-white px-4 py-2 text-center text-sm font-medium border border-gray-300">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($clientes as $index => $cliente)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-2 border border-gray-300">{{ $cliente->nome_cliente }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $cliente->cnpj }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $cliente->razao_social }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $cliente->cidade }}</td>
                                <td class="px-4 py-2 border border-gray-300">{{ $cliente->estado }}</td>
                                <td class="px-4 py-2 border border-gray-300 text-center flex gap-2 justify-center">
                                    <a href="{{ route('clientes.edit', $cliente->id) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                        👁 Visualizar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

            
            {{-- Paginação centralizada em cima --}}
                <div class="mt-6 flex justify-center">
                    {{ $clientes->links('vendor.pagination.custom') }}
                </div>

                {{-- Texto "Mostrando X até Y de Z resultados" centralizado embaixo --}}
                <div class="mt-2 text-center text-sm text-gray-600">
                    Mostrando 
                    <span class="font-medium">{{ $clientes->firstItem() }}</span> 
                    até 
                    <span class="font-medium">{{ $clientes->lastItem() }}</span> 
                    de 
                    <span class="font-medium">{{ $clientes->total() }}</span> resultados
                </div>


        @else
            <div class="text-gray-600 mt-4">Nenhum cliente cadastrado.</div>
        @endif
    </div>
</div>
@endsection
