@extends('layouts.app')

@section('content')
    <div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Consulta de Demandas</h2>

            {{-- Filtro --}}
            <form action="{{ route('demandas.index') }}" method="GET" class="mb-6">
                <div class="flex flex-col md:flex-row gap-4 items-center">
                    <input type="text" name="filtro" value="{{ request('filtro') }}"
                        placeholder="Buscar: título, status, cliente ou solicitante"
                        class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                     <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Buscar
                    </button>

                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <button id="btn-mais-filtros" 
                            type="button" 
                           class="bg-blue-300 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                            <span id="texto-btn">Mais Filtros</span>
                            <svg id="seta-filtros" class="w-4 h-4 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <a href="{{ route('demandas.create') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        + Cadastrar Demanda
                    </a>
                </div>

                {{-- Filtros Avançados (Div Expansível) --}}
                <div id="filtros-avancados" class="hidden mt-6 p-6 bg-gray-50 border border-gray-200 rounded-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Filtros Avançados</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- Filial --}}
                        <div class="flex flex-col">
                            <label for="filial" class="text-sm font-medium text-gray-700 mb-2">Filial</label>
                            <select name="filial" id="filial" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Todas as filiais</option>
                                @foreach($filiais as $filial)
                                    <option value="{{ $filial->id }}" {{ request('filial') == $filial->id ? 'selected' : '' }}>
                                        {{ $filial->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Período Início --}}
                        <div class="flex flex-col">
                            <label for="periodo_inicio" class="text-sm font-medium text-gray-700 mb-2">Período - Início</label>
                            <input type="date" name="periodo_inicio" id="periodo_inicio" 
                                value="{{ request('periodo_inicio') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Período Fim --}}
                        <div class="flex flex-col">
                            <label for="periodo_fim" class="text-sm font-medium text-gray-700 mb-2">Período - Fim</label>
                            <input type="date" name="periodo_fim" id="periodo_fim" 
                                value="{{ request('periodo_fim') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Nível --}}
                        <div class="flex flex-col">
                            <label for="nivel" class="text-sm font-medium text-gray-700 mb-2">Nível</label>
                            <select name="nivel" id="nivel" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Todos os níveis</option>
                                <option value="0" {{ request('nivel') == '0' ? 'selected' : '' }}>Nenhum</option>
                                <option value="1" {{ request('nivel') == '1' ? 'selected' : '' }}>Nível 1</option>
                                <option value="2" {{ request('nivel') == '2' ? 'selected' : '' }}>Nível 2</option>
                                <option value="3" {{ request('nivel') == '3' ? 'selected' : '' }}>Nível 3</option>
                                <option value="4" {{ request('nivel') == '4' ? 'selected' : '' }}>Nível 4</option>
                            </select>
                        </div>

                        {{-- Atendente --}}
                        <div class="flex flex-col">
                            <label for="atendente" class="text-sm font-medium text-gray-700 mb-2">Atendente</label>
                            <select name="atendente" id="atendente" 
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Todos os atendentes</option>
                                @foreach($atendentes as $atendente)
                                    <option value="{{ $atendente }}" {{ request('atendente') == $atendente ? 'selected' : '' }}>
                                        {{ $atendente }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Data Agendamento --}}
                        <div class="flex flex-col">
                            <label for="data_agendamento" class="text-sm font-medium text-gray-700 mb-2">Data Agendamento</label>
                            <input type="date" name="data_agendamento" id="data_agendamento" 
                                value="{{ request('data_agendamento') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                         {{-- Tipo Suporte --}}
                        <div class="flex flex-col">
                            <label for="tipo_suporte" class="text-sm font-medium text-gray-700 mb-2">Tipo Suporte</label>
                            <input name="tipo_suporte" id="tipo_suporte" 
                                value="{{ request('tipo_suporte') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        {{-- Produtos --}}
                        <div class="flex flex-col">
                            <label for="produto" class="text-sm font-medium text-gray-700 mb-2">Produtos</label>
                            <input name="produto" id="produto" 
                                value="{{ request('produto') }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- Botões de ação dos filtros --}}
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="limparFiltrosAvancados()" 
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                            Limpar Filtros
                        </button>
                        <button type="submit" 
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            Aplicar Filtros
                        </button>
                    </div>
                </div>
            </form>

            {{-- Mensagem de sucesso --}}
            @if (session('success'))
                <div id="mensagem-sucesso" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Lista de Demandas --}}
            @if ($demandas->count() > 0)
                <div class="overflow-x-auto">
                   <table class="min-w-full divide-y divide-gray-200 border border-gray-300 bg-white shadow rounded-lg overflow-hidden">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-left font-medium">Id</th>
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
                                    <td class="border border-gray-300 px-4 py-2">{{ $demanda->id }}</td>
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
                                            'Concluida' => 'status-concluida',
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

    {{-- JavaScript para controlar os filtros --}}
    <script>
        // Controle do botão "Mais Filtros"
        document.getElementById('btn-mais-filtros').addEventListener('click', function() {
            const filtrosAvancados = document.getElementById('filtros-avancados');
            const textoBotao = document.getElementById('texto-btn');
            const setaFiltros = document.getElementById('seta-filtros');
            
            if (filtrosAvancados.classList.contains('hidden')) {
                // Mostrar filtros
                filtrosAvancados.classList.remove('hidden');
                filtrosAvancados.style.maxHeight = '0px';
                filtrosAvancados.style.opacity = '0';
                
                // Animação suave
                setTimeout(() => {
                    filtrosAvancados.style.maxHeight = '800px';
                    filtrosAvancados.style.opacity = '1';
                }, 10);
                
                textoBotao.textContent = 'Menos Filtros';
                setaFiltros.style.transform = 'rotate(180deg)';
            } else {
                // Esconder filtros
                filtrosAvancados.style.maxHeight = '0px';
                filtrosAvancados.style.opacity = '0';
                
                setTimeout(() => {
                    filtrosAvancados.classList.add('hidden');
                }, 300);
                
                textoBotao.textContent = 'Mais Filtros';
                setaFiltros.style.transform = 'rotate(0deg)';
            }
        });

        // Função para limpar filtros avançados
        function limparFiltrosAvancados() {
            // Limpar todos os campos dos filtros avançados
            document.getElementById('filial').value = '';
            document.getElementById('periodo_inicio').value = '';
            document.getElementById('periodo_fim').value = '';
            document.getElementById('nivel').value = '';
            document.getElementById('atendente').value = '';
            document.getElementById('data_agendamento').value = '';
            document.getElementById('status_filtro').value = '';

            
            // Feedback visual
            mostrarNotificacao('Filtros avançados limpos!', 'info');
        }

        // Função para mostrar notificações
        function mostrarNotificacao(mensagem, tipo = 'info') {
            const notificacao = document.createElement('div');
            notificacao.className = `fixed top-4 right-4 px-4 py-3 rounded-lg text-white font-medium z-50 transition-all duration-300 transform translate-x-full`;
            
            if (tipo === 'info') {
                notificacao.classList.add('bg-blue-500');
            } else if (tipo === 'success') {
                notificacao.classList.add('bg-green-500');
            }
            
            notificacao.textContent = mensagem;
            document.body.appendChild(notificacao);
            
            // Animação de entrada
            setTimeout(() => {
                notificacao.classList.remove('translate-x-full');
            }, 100);
            
            // Remover após 3 segundos
            setTimeout(() => {
                notificacao.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notificacao);
                }, 300);
            }, 3000);
        }

        // Script para mensagem de sucesso (mantendo o original)
        setTimeout(function () {
            const mensagem = document.getElementById('mensagem-sucesso');
            if (mensagem) {
                mensagem.style.transition = 'opacity 0.5s ease';
                mensagem.style.opacity = 0;
                setTimeout(() => mensagem.remove(), 500);
            }
        }, 5000);

        // Verificar se há filtros aplicados e mostrar a div automaticamente
        document.addEventListener('DOMContentLoaded', function() {
            const filtrosAplicados = [
                '{{ request("filial") }}',
                '{{ request("periodo_inicio") }}',
                '{{ request("periodo_fim") }}',
                '{{ request("nivel") }}',
                '{{ request("atendente") }}',
                '{{ request("data_agendamento") }}',
                '{{ request("status_filtro") }}'
            ].some(filtro => filtro.length > 0);

            if (filtrosAplicados) {
                document.getElementById('btn-mais-filtros').click();
            }
        });
    </script>
@endsection