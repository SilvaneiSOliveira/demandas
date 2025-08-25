@extends('layouts.app')

@section('content')
<style> 
    .no-loading-page {
        display: none !important;
    }
</style>
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
    <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">📊 Relatórios de Demandas</h2>
    
    {{-- Filtros --}}
    <form method="GET" action="{{ route('relatorios.create') }}" class="mb-6">
            <div class="flex flex-wrap gap-4"> 
                {{-- Cliente --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-medium mb-1">Cliente</label>
                    <select name="cliente_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Todos os clientes</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome_cliente }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Status --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Todos os status</option>
                        <option value="aberta" {{ request('status') == 'aberta' ? 'selected' : '' }}>Aberta</option>
                        <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
                        <option value="concluida" {{ request('status') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>

                {{-- Filial --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-medium mb-1">Filial</label>
                    <select name="filial_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Todas as filiais</option>
                        @foreach ($filiais as $filial)
                            <option value="{{ $filial->id }}" {{ request('filial_id') == $filial->id ? 'selected' : '' }}>
                                {{ $filial->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Classificação --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-medium mb-1">Classificação</label>
                    <select name="classificacao" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Todas</option>
                        <option value="presencial" {{ request('classificacao') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                        <option value="remoto" {{ request('classificacao') == 'remoto' ? 'selected' : '' }}>Remoto</option>
                    </select>
                </div>

                {{-- Data Inicial --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-medium mb-1">Data Início</label>
                    <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                {{-- Data Final --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 font-medium mb-1">Data Fim</label>
                    <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
               
            </div>

            <div class="flex justify-end mt-4 gap-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    🔍 Filtrar
                </button>
                <a href="{{ route('relatorios.create') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    🧹 Limpar Filtros
                </a>
            </div>
            
            @if(count($relatorios))
                <div class="flex gap-4 mt-4">
                    <a href="{{ route('relatorios.ver_pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        🧾Exportar PDF
                    </a>
                    <a href="{{ route('relatorios.exportar.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        📁 Exportar Excel
                    </a>
                </div>
            @endif
    </form>

    {{-- Tabela de Resultados --}}
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Cliente</th>
                    <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Filial</th>
                    <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Status</th>
                    <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Data de Abertura</th>
                    <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Classificação</th>
                    <th class="bg-gray-700 text-white px-4 py-2 text-left text-sm font-medium border border-gray-300">Descrição</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($relatorios as $index => $demanda)
                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                        <td class="px-4 py-2 border border-gray-300">{{ $demanda->cliente->nome_cliente ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $demanda->filial->nome ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $demanda->status }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ \Carbon\Carbon::parse($demanda->created_at)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $demanda->classificacao }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $demanda->descricao }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500 border border-gray-300">Nenhuma demanda encontrada com os filtros aplicados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação centralizada em cima --}}
    <div class="mt-6 flex justify-center">
        {{ $relatorios->links('vendor.pagination.custom') }}
    </div>

    {{-- Texto "Mostrando X até Y de Z resultados" centralizado embaixo --}}
    <div class="mt-2 text-center text-sm text-gray-600">
        Mostrando 
        <span class="font-medium">{{ $relatorios->firstItem() }}</span> 
        até 
        <span class="font-medium">{{ $relatorios->lastItem() }}</span> 
        de 
        <span class="font-medium">{{ $relatorios->total() }}</span> resultados
    </div>
</div>
@endsection