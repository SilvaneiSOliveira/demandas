@extends('layouts.app')

@section('title', 'Detalhes da Demanda')

@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Demanda Selecionada</h2>
    
    @if(session('success'))
        <div id="mensagem-sucesso" class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 transition-opacity duration-1000">
            {{ session('success') }}
        </div>
    @endif

    <form id="formDemanda" action="{{ route('demandas.atualizarStatus', $demanda->id) }}" method="POST">
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
                    <select name="nivel" id="nivel" class="campo-editavel w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 bg-gray-100" disabled required>
                        <option value="">Selecione o nível</option>
                        <option value="0" @if(isset($demanda) && $demanda->nivel == 0) selected @endif>Nenhum</option>
                        <option value="1" @if(isset($demanda) && $demanda->nivel == 1) selected @endif>Nível 1 -> Crítico</option>
                        <option value="2" @if(isset($demanda) && $demanda->nivel == 2) selected @endif>Nível 2 -> Alto</option>
                        <option value="3" @if(isset($demanda) && $demanda->nivel == 3) selected @endif>Nível 3 -> Moderado</option>
                        <option value="4" @if(isset($demanda) && $demanda->nivel == 4) selected @endif>Nível 4 -> Baixo</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ $demanda->titulo }}" class="campo-editavel w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" disabled>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Classificação</label>
                <select name="classificacao" id="classificacao" class="campo-editavel w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 bg-gray-100" disabled>
                    <option value="Remoto" {{ $demanda->classificacao == 'Remoto' ? 'selected' : '' }}>Remoto</option>
                    <option value="Presencial" {{ $demanda->classificacao == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Técnico</label>
                <select name="atendente" id="atendente" class="campo-editavel w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 bg-gray-100" disabled>
                    <option value="Carlos Eduardo" @if(isset($demanda) && $demanda->atendente == 'Carlos Eduardo') selected @endif>Carlos Eduardo</option>       
                    <option value="Claudio Carvalho" @if(isset($demanda) && $demanda->atendente == 'Claudio Carvalho') selected @endif>Claudio Carvalho</option>
                    <option value="José Iago" @if(isset($demanda) && $demanda->atendente == 'José Iago') selected @endif>José Iago</option>
                    <option value="Tauan Costa" @if(isset($demanda) && $demanda->atendente == 'Tauan Costa') selected @endif>Tauan Costa</option>
                    <option value="Tiago Ribeiro" @if(isset($demanda) && $demanda->atendente == 'Tiago Ribeiro') selected @endif>Tiago Ribeiro</option>                    
                    <option value="Silvanei Santana" @if(isset($demanda) && $demanda->atendente == 'Silvanei Santana') selected @endif>Silvanei Santana</option>                    
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                <textarea name="descricao" id="descricao" class="campo-editavel w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" rows="4" disabled>{{ $demanda->descricao }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="campo-editavel w-full border-gray-300 rounded-md px-3 py-2 bg-gray-100" disabled>
                    <option value="Aberta" {{ $demanda->status == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="Em andamento" {{ $demanda->status == 'Em andamento' ? 'selected' : '' }}>Em andamento</option>
                    <option value="Concluida" {{ $demanda->status == 'Concluida' ? 'selected' : '' }}>Concluída</option>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data Agendamento (atendimento)</label>
                    <input type="datetime-local" name="data_agendamento" id="data_agendamento"
                        value="{{ $demanda->data_agendamento ? \Carbon\Carbon::parse($demanda->data_agendamento)->format('Y-m-d\TH:i') : '' }}"
                        class="campo-editavel w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" disabled>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Solicitante</label>
                <input type="text" name="solicitante" id="solicitante" value="{{ $demanda->solicitante }}" class="campo-editavel w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" disabled>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <input type="text" value="{{ $demanda->cliente->nome_cliente }}" class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" disabled>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filial</label>
                    <input type="text" value="{{ $demanda->filial->nome ?? 'N/A' }}" class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" disabled>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Resolução</label>
                <textarea name="resolucao" id="resolucao" rows="4" class="campo-editavel w-full border rounded px-3 py-2 bg-gray-100" disabled>{{ old('resolucao', $demanda->resolucao ?? '') }}</textarea>
            </div>
        </div>
        
        <div class="flex justify-end mt-6 space-x-4">
            <a href="{{ route('demandas.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">Voltar</a>
            
            <button type="button" id="btnEditarSalvar" onclick="toggleEdicao()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                ✏️ Editar
            </button>
            
            <button type="button" id="btnCancelar" onclick="cancelarEdicao()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition hidden">
                ❌ Cancelar
            </button>
        </div>
    </form>

    <button onclick="abrirModal()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 mt-4">
        📎 Anexar arquivos
    </button>
    
    @include('partials.modal_anexo')
</div>

@endsection

<script>
    let modoEdicao = false;
    let valoresOriginais = {};

    // Armazena os valores originais quando a página carrega
    document.addEventListener('DOMContentLoaded', function() {
        armazenarValoresOriginais();
    });

    function armazenarValoresOriginais() {
        const camposEditaveis = document.querySelectorAll('.campo-editavel');
        camposEditaveis.forEach(campo => {
            if (campo.tagName === 'SELECT') {
                valoresOriginais[campo.id] = campo.value;
            } else {
                valoresOriginais[campo.id] = campo.value;
            }
        });
    }

    function toggleEdicao() {
        const btnEditarSalvar = document.getElementById('btnEditarSalvar');
        const btnCancelar = document.getElementById('btnCancelar');
        const camposEditaveis = document.querySelectorAll('.campo-editavel');
        
        if (!modoEdicao) {
            // Entrar em modo de edição
            modoEdicao = true;
            btnEditarSalvar.innerHTML = '💾 Salvar Alterações';
            btnEditarSalvar.onclick = salvarAlteracoes;
            btnCancelar.classList.remove('hidden');
            
            // Habilitar campos
            camposEditaveis.forEach(campo => {
                campo.disabled = false;
                campo.classList.remove('bg-gray-100');
                campo.classList.add('bg-white');
            });
            
        } else {
            // Sair do modo de edição (não deveria chegar aqui, pois será salvarAlteracoes)
            modoEdicao = false;
            btnEditarSalvar.innerHTML = '✏️ Editar';
            btnEditarSalvar.onclick = toggleEdicao;
            btnCancelar.classList.add('hidden');
            
            // Desabilitar campos
            camposEditaveis.forEach(campo => {
                campo.disabled = true;
                campo.classList.add('bg-gray-100');
                campo.classList.remove('bg-white');
            });
        }
    }

    function salvarAlteracoes() {
        // Submeter o formulário
        document.getElementById('formDemanda').submit();
    }

    function cancelarEdicao() {
        const btnEditarSalvar = document.getElementById('btnEditarSalvar');
        const btnCancelar = document.getElementById('btnCancelar');
        const camposEditaveis = document.querySelectorAll('.campo-editavel');
        
        // Restaurar valores originais
        camposEditaveis.forEach(campo => {
            if (valoresOriginais[campo.id] !== undefined) {
                campo.value = valoresOriginais[campo.id];
            }
            
            // Desabilitar campos
            campo.disabled = true;
            campo.classList.add('bg-gray-100');
            campo.classList.remove('bg-white');
        });
        
        // Resetar botões
        modoEdicao = false;
        btnEditarSalvar.innerHTML = '✏️ Editar';
        btnEditarSalvar.onclick = toggleEdicao;
        btnCancelar.classList.add('hidden');
    }

    // Script para mensagem de sucesso
    setTimeout(function () {
        const mensagem = document.getElementById('mensagem-sucesso');
        if (mensagem) {
            mensagem.style.opacity = '0';
            setTimeout(() => mensagem.remove(), 1000);
        }
    }, 3000);

    // Funções para modal
    function abrirModal() {
        document.getElementById('modalAnexo').classList.remove('hidden');
    }

    function fecharModal() {
        document.getElementById('modalAnexo').classList.add('hidden');
    }

    function abrirModalAnexos() {
        document.getElementById('modalAnexos').classList.remove('hidden');
    }

    function fecharModalAnexos() {
        document.getElementById('modalAnexos').classList.add('hidden');
    }
</script>