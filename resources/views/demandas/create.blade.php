@extends('layouts.app')

@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
    <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">➕ Cadastrar Nova Demanda</h2>

    <form action="{{ route('demandas.store') }}" method="POST">
        @csrf

        {{-- Cliente e Filial --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Cliente *</label>
                <select name="cliente_id" id="cliente_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome_cliente }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Filial</label>
                <select name="filial_id" id="filial_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                    <option value="">Selecione uma filial</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Solicitante</label>
                <input type="text" name="solicitante" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Nível da Demanda *</label>
                <select name="nivel" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="">Selecione o nível</option>
                    <option value="0">Nenhum</option>
                    <option value="1">Nível 1 -> Crítico</option>
                    <option value="2">Nível 2 -> Alto</option>
                    <option value="3">Nível 3 -> Moderado</option>
                    <option value="3">Nível 4 -> Baixo</option>
                </select>
            </div>
        </div>

        {{-- Detalhes da Demanda --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label class="block text-gray-700 font-medium mb-1">Descrição *</label>
                <textarea name="descricao" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Status *</label>
                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="Aberta">Aberta</option>
                    <option value="Em andamento">Em andamento</option>
                    <option value="Concluida">Concluida</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Atendente *</label>
                <select name="atendente" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="">Selecione</option>
                    <option value="Claudio Carvalho" @if(auth()->user()->name == 'Claudio Carvalho') selected @endif>Claudio Carvalho</option>
                    <option value="Tauan Bastos" @if(auth()->user()->name == 'Tauan Bastos') selected @endif>Tauan Bastos</option>
                    <option value="Tiago Ribeiro" @if(auth()->user()->name == 'Tiago Ribeiro') selected @endif>Tiago Ribeiro</option>
                    <option value="Jose Iago" @if(auth()->user()->name == 'José Iago') selected @endif>José Iago</option>
                    <option value="Silvanei Santana" @if(auth()->user()->name == 'Silvanei Santana') selected @endif>Silvanei Santana</option>
                    <option value="Carlos Eduardo" @if(auth()->user()->name == 'Carlos Eduardo') selected @endif>Carlos Eduardo</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Título *</label>
                <input type="text" name="titulo" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Data Agendamento (Atendimento)*</label>
                <input type="date" name="data_agendamento" id="data_agendamento" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Classificação *</label>
                <select name="classificacao" id="classificacao" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                    <option value="Remoto" selected>Remoto</option>
                    <option value="Presencial">Presencial</option>
                </select>
            </div>
        </div>

        {{-- Botões --}}
        <div class="flex justify-between mt-6">
            <a href="{{ route('demandas.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                ❌ Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                💾 Salvar Demanda
            </button>
        </div>
    </form>
</div>

{{-- Script para carregar filiais do cliente --}}
<script>
    document.getElementById('cliente_id').addEventListener('change', function () {
        const clienteId = this.value;
        const filialSelect = document.getElementById('filial_id');

        filialSelect.innerHTML = '<option value="">Carregando...</option>';

        fetch(`/filiais-por-cliente/${clienteId}`)
            .then(response => response.json())
            .then(data => {
                filialSelect.innerHTML = '<option value="">Selecione uma filial</option>';
                data.forEach(filial => {
                    const option = document.createElement('option');
                    option.value = filial.id;
                    option.text = filial.nome;
                    filialSelect.appendChild(option);
                });
            });
    });

    // Script para manipular a data de agendamento baseado na classificação
    document.addEventListener('DOMContentLoaded', function() {
        const classificacaoSelect = document.getElementById('classificacao');
        const dataAgendamentoInput = document.getElementById('data_agendamento');
        
        // Função para formatar a data no formato YYYY-MM-DD
        function formatDate(date) {
            const d = new Date(date);
            let month = '' + (d.getMonth() + 1);
            let day = '' + d.getDate();
            const year = d.getFullYear();

            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;

            return [year, month, day].join('-');
        }

        // Definir data atual quando for Remoto
        function setCurrentDate() {
            if (classificacaoSelect.value === 'Remoto') {
                dataAgendamentoInput.value = formatDate(new Date());
            }
        }

        // Chamar a função ao carregar a página
        setCurrentDate();

        // Ouvir mudanças no select de classificação
        classificacaoSelect.addEventListener('change', function() {
            if (this.value === 'Remoto') {
                // Preencher com data atual
                setCurrentDate();
            } else {
                // Limpar o campo para preenchimento manual
                dataAgendamentoInput.value = '';
            }
        });
    });
</script>
@endsection