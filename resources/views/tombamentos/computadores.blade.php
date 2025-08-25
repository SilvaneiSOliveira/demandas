@extends('layouts.app')

@section('content')
<style> 
    .no-loading-page {
        display: none !important;
    }
</style>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 border-b pb-2">Computadores</h2>
        <a href="{{ route('tombamentos.computadores.create') }}"
           class="bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-2 px-4 rounded shadow transition duration-200">
           Cadastrar Computador
        </a>
    </div>

    {{-- Campo de busca por TAG --}}
    <form method="GET" action="{{ route('tombamentos.computadores.index') }}" class="mb-6 flex gap-0">
        <input type="text" name="tag" placeholder="Buscar pela TAG"
               value="{{ request('tag') }}"
               class="flex-1 border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <input type="text" name="cliente" placeholder="Buscar pela Cliente"
               value="{{ request('cliente') }}"
               class="flex-1 border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">

                <input type="text" name="filial" placeholder="Buscar por filial"
               value="{{ request('filial') }}"
               class="flex-1 border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
        <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 rounded-r font-medium transition duration-200">
            🔍 Buscar
        </button>
    </form>

    {{-- Tabela de computadores --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-800 border-b border-gray-400">
                    <th class="px-4 py-2 border-r border-gray-400">TAG</th>
                    <th class="px-4 py-2 border-r border-gray-400">CLIENTE</th>
                    <th class="px-4 py-2 border-r border-gray-400">FILIAL</th>
                    <th class="px-4 py-2 border-r border-gray-400">LOCAL</th>
                    <th class="px-4 py-2 border-r border-gray-400">PROCESSADOR</th>
                    <th class="px-4 py-2 border-r border-gray-400">RAM</th>
                    <th class="px-4 py-2 border-r border-gray-400">ARMAZENAMENTO</th>
                    <th class="px-4 py-2 border-r border-gray-400">SISTEMA</th>
                    <th class="px-4 py-2">OBSERVAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($computadores as $pc)
                    <tr class="@if($loop->even) bg-gray-50 @else bg-white @endif border-b border-gray-300 hover:bg-blue-50 cursor-pointer transition duration-200"
                        ondblclick="abrirModalComputador({{ $pc->id }})">
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->tag }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->cliente->nome_cliente ?? '-' }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->filial->nome ?? '-' }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->local ?? '-' }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->processador }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->memoria_ram }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->armazenamento }}</td>
                        <td class="px-4 py-2 border-r border-gray-300">{{ $pc->sistema_operacional }}</td>
                        <td class="px-4 py-2">{{ $pc->observacao }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">Nenhum computador encontrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Incluir o modal --}}
@include('partials.modal_computador')

{{-- Scripts do Modal --}}
<script>
    let modoEdicao = false;

    function abrirModalComputador(computadorId) {
        document.getElementById('modalComputador').classList.remove('hidden');
        
        // Buscar dados do computador
        fetch(`{{ url('tombamentos/computadores') }}/${computadorId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                preencherModal(data);
            })
            .catch(error => {
                console.error('Erro ao buscar computador:', error);
                alert('Erro ao carregar dados do computador');
            });
    }

    function fecharModalComputador() {
        document.getElementById('modalComputador').classList.add('hidden');
        desabilitarEdicao();
    }

    function preencherModal(computador) {
    document.getElementById('computadorId').value = computador.id;
    document.getElementById('modalTag').value = computador.tag || '';
    document.getElementById('modalLocal').value = computador.local || '';
    document.getElementById('modalProcessador').value = computador.processador || '';
    document.getElementById('modalMemoriaRam').value = computador.memoria_ram || '';
    document.getElementById('modalArmazenamento').value = computador.armazenamento || '';
    document.getElementById('modalSistemaOperacional').value = computador.sistema_operacional || '';
    document.getElementById('modalObservacao').value = computador.observacao || '';

    // Última alteração
    document.getElementById("modalUsuarioAlteracao").textContent = computador.usuario_alteracao ?? "—";
    document.getElementById("modalUltimaAlteracao").textContent = computador.ultima_alteracao
        ? new Date(computador.ultima_alteracao).toLocaleString('pt-BR')
        : "—";

    // Carregar opções dos selects
    carregarClientes(computador.cliente_id);
    carregarFiliais(computador.filial_id);
}

    function carregarClientes(clienteSelecionado = null) {
        const clientes = @json($clientes ?? []);
        const select = document.getElementById('modalClienteId');
        select.innerHTML = '<option value="">Selecione o cliente</option>';
        
        clientes.forEach(cliente => {
            const option = document.createElement('option');
            option.value = cliente.id;
            option.textContent = cliente.nome_cliente;
            if (parseInt(cliente.id) === parseInt(clienteSelecionado)) {
                option.selected = true;
            }
            select.appendChild(option);
        });
    }

    function carregarFiliais(filialSelecionada = null) {
        const filiais = @json($filiais ?? []);
        const select = document.getElementById('modalFilialId');
        select.innerHTML = '<option value="">-- Sem filial --</option>';
        
        filiais.forEach(filial => {
            const option = document.createElement('option');
            option.value = filial.id;
            option.textContent = filial.nome;
            if (parseInt(filial.id) === parseInt(filialSelecionada)) {
                option.selected = true;
            }
            select.appendChild(option);
        });
    }

    function habilitarEdicao() {
        modoEdicao = true;
        
        // Habilitar todos os campos
        const campos = document.querySelectorAll('#formComputador input, #formComputador select, #formComputador textarea');
        campos.forEach(campo => {
            campo.disabled = false;
            campo.classList.remove('bg-gray-100');
            campo.classList.add('bg-white');
        });

        // Trocar botões
        document.getElementById('btnEditar').style.display = 'none';
        document.getElementById('btnSalvar').style.display = 'block';
    }

    function desabilitarEdicao() {
        modoEdicao = false;
        
        // Desabilitar todos os campos
        const campos = document.querySelectorAll('#formComputador input, #formComputador select, #formComputador textarea');
        campos.forEach(campo => {
            campo.disabled = true;
            campo.classList.remove('bg-white');
            campo.classList.add('bg-gray-100');
        });

        // Trocar botões
        document.getElementById('btnEditar').style.display = 'block';
        document.getElementById('btnSalvar').style.display = 'none';
    }

    // Submit do formulário
    document.getElementById('formComputador').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const computadorId = document.getElementById('computadorId').value;

        // Usar a rota correta do Laravel
        fetch(`{{ url('tombamentos/computadores') }}/${computadorId}`, {
            method: 'POST', // Laravel vai interpretar como PUT devido ao _method
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: (() => {
                // Adicionar _method=PUT para Laravel interpretar corretamente
                formData.append('_method', 'PUT');
                return formData;
            })()
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Computador atualizado com sucesso!');
                fecharModalComputador();
                location.reload(); // Recarregar a página para mostrar as alterações
            } else {
                alert('Erro ao atualizar: ' + (data.message || 'Erro desconhecido'));
                if (data.errors) {
                    console.error('Erros de validação:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao salvar alterações');
        });
    });
</script>
@endsection