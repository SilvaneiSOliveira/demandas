@extends('layouts.app')

@section('title', 'Detalhes da Demanda')


@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Detalhes da Demanda</h2>
    
@if(session('success'))
    <div id="mensagem-sucesso" class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 transition-opacity duration-1000">
        {{ session('success') }}
    </div>
@endif

    <form action="{{ route('demandas.atualizarStatus', $demanda->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">    
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                <input type="text" value="{{ $demanda->id }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nivel</label>
                <input type="text" value="{{ $demanda->nivel }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" value="{{ $demanda->titulo }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" rows="4">{{ $demanda->descricao }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-md px-3 py-2">
                    <option value="Aberta" {{ $demanda->status == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="Em andamento" {{ $demanda->status == 'Em andamento' ? 'selected' : '' }}>Em andamento</option>
                    <option value="Concluída" {{ $demanda->status == 'Concluída' ? 'selected' : '' }}>Concluída</option>
                </select>
            </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Criação</label>
                <input type="text" 
                    value="{{ $demanda->created_at->timezone('America/Bahia')->format('d/m/Y H:i') }}" 
                    disabled 
                    class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>

        
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Agendamento</label>
                <input type="text" 
                    value="{{ $demanda->data_agendamento ? \Carbon\Carbon::parse($demanda->data_agendamento)->timezone('America/Bahia')->format('d/m/Y H:i') : 'Sem data' }}" 
                    disabled 
                    class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solicitante</label>
                <input type="text" value="{{ $demanda->solicitante }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                <input type="text" value="{{ $demanda->cliente->nome_cliente }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filial</label>
                <input type="text" value="{{ $demanda->filial->nome ?? 'N/A' }}" disabled class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
            </div>
        </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Resolução</label>
                <textarea name="resolucao" rows="4" class="w-full border rounded px-3 py-2">{{ old('resolucao', $demanda->resolucao ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6 space-x-4">
            <a href="{{ route('demandas.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">Voltar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

<script>
    setTimeout(function () {
        const mensagem = document.getElementById('mensagem-sucesso');
        if (mensagem) {
            mensagem.style.opacity = '0';
            setTimeout(() => mensagem.remove(), 1000);
        }
    }, 3000);
</script>