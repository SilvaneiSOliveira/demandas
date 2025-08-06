@extends('layouts.app')

@section('content')
    <div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Consulta de Demandas</h2>

            {{-- Filtro --}}
            <form action="{{ route('demandas.index') }}" method="GET" class="mb-6">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <input type="text" name="filtro" value="{{ request('filtro') }}"
                        placeholder="Buscar por título, status ou solicitante"
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
                    const mensagem = document.getElementById('mensagem-sucesso');
                    if (mensagem) {
                        mensagem.style.transition = 'opacity 0.5s ease';
                        mensagem.style.opacity = 0;
                        setTimeout(() => mensagem.remove(), 500);
                    }
                }, 5000);
            </script>

            {{-- Lista de Demandas --}}
                    @if ($demandas->count() > 0)
                        <div class="overflow-x-auto">
                           <table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white shadow rounded-lg overflow-hidden">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Título</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Cliente</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Filial</th>                                        
                                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Data Agendamento</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left font-medium">Status</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center font-medium">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($demandas as $demanda)
                                        <tr class="odd:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">{{ $demanda->titulo }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $demanda->cliente->nome_cliente ?? 'Sem cliente' }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $demanda->filial?->nome ?? 'Sem filial' }}</td>                                           
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($demanda->data_agendamento)
                                                    {{ \Carbon\Carbon::parse($demanda->data_agendamento)->timezone('America/Bahia')->format('d/m/Y') }}
                                                @else
                                                    <span class="text-gray-400 italic">Sem data</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-200 px-4 py-2">
                                                @php
                                                    $classeStatus = match($demanda->status) {
                                                    'Aberta' => 'status-aberta',
                                                    'Em andamento' => 'status-andamento',
                                                    'Concluída' => 'status-concluida',
                                                    default => '',
                                                    };
                                                @endphp
                                                    <span class="{{ $classeStatus }}">{{ $demanda->status }}</span>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('demandas.show', $demanda->id) }}"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition-all duration-150">
                                                        👁 Visualizar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                {{-- Paginação centralizada em cima --}}
                <div class="mt-6 flex justify-center">
                    {{ $demandas->links('vendor.pagination.custom') }}
                </div>

                {{-- Texto "Mostrando X até Y de Z resultados" centralizado embaixo --}}
                <div class="mt-2 text-center text-sm text-gray-600">
                    Mostrando 
                    <span class="font-medium">{{ $demandas->firstItem() }}</span> 
                    até 
                    <span class="font-medium">{{ $demandas->lastItem() }}</span> 
                    de 
                    <span class="font-medium">{{ $demandas->total() }}</span> resultados
                </div>



                @else
                    <div class="text-gray-600 mt-4">Nenhuma demanda cadastrada.</div>
                @endif

        </div>
    </div>
@endsection


