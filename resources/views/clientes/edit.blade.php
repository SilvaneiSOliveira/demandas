@extends('layouts.app')

@section('content')
        <div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
            <div class="bg-white shadow-md rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Cliente Selecionado</h2>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <form id="formContainer" action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                <div class="mb-4 flex justify-end items-center"> 
            
                <!-- STATUS -->
            <div class="flex items-center gap-2"> 
                <label for="ativo" class="text-sm font-medium text-gray-700">
                    Status
                </label>
                <select name="ativo" id="ativo" 
                        class="w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="1" {{ $cliente->ativo ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ !$cliente->ativo ? 'selected' : '' }}>Desativado</option>
                </select>
            </div>

        </div>

            <!-- DADOS DO CLIENTE -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">🧾 Dados do Cliente</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome do Cliente *</label>
                        <input type="text" name="nome_cliente" value="{{ $cliente->nome_cliente }}" required 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Razão Social</label>
                        <input type="text" name="razao_social" value="{{ $cliente->razao_social }}" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                        <input type="text" name="cnpj" value="{{ $cliente->cnpj }}" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Endereço</label>
                        <input type="text" name="endereco" value="{{ $cliente->endereco }}" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Complemento</label>
                        <input type="text" name="complemento" value="{{ $cliente->complemento }}" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bairro</label>
                        <input type="text" name="bairro" value="{{ $cliente->bairro }}" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cidade</label>
                        <input type="text" name="cidade" value="{{ $cliente->cidade }}" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado (UF)</label>
                        <input type="text" name="estado" value="{{ $cliente->estado }}" maxlength="2" 
                               class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- TIPO DE SUPORTE E PRODUTOS -->
            <div class="flex flex-wrap gap-8 mb-8">
                <!-- TIPO DE SUPORTE -->
                <div class="flex-1 min-w-[300px]">
                    <h3 class="text-lg font-semibold text-gray-600 mb-4">💻 Tipo de Suporte</h3>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selecione o Tipo</label>
                    
                    <div class="relative">
                        <div class="w-full p-3 border border-gray-300 rounded-md cursor-pointer bg-white hover:border-gray-400 transition-colors"
                            onclick="toggleDropdown('supportDropdown', 'supportIcon')" id="supportButton">
                            <div class="flex justify-between items-center">
                                <span id="supportSelectedText" class="text-gray-700">
                                    @php
                                        $tiposSuporte = is_string($cliente->tipo_suporte) ? json_decode($cliente->tipo_suporte, true) : $cliente->tipo_suporte;
                                        $tiposSuporte = $tiposSuporte ?? [];
                                    @endphp
                                    @if(count($tiposSuporte) > 0)
                                        {{ count($tiposSuporte) == 1 ? $tiposSuporte[0] : count($tiposSuporte) . ' tipos selecionados' }}
                                    @else
                                        Clique para selecionar...
                                    @endif
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transform transition-transform" id="supportIcon">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <div id="supportDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                            <div class="p-2">
                                @php
                                    $tiposSupporte = ['Rede e Computadores', 'Consys', 'Formula Certa', 'Sorted', 'Sim', 'GF', 'Seleção Municipal'];
                                    $tiposSelecionados = is_string($cliente->tipo_suporte) ? json_decode($cliente->tipo_suporte, true) : $cliente->tipo_suporte;
                                    $tiposSelecionados = $tiposSelecionados ?? [];
                                @endphp
                                @foreach($tiposSupporte as $tipo)
                                    <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" name="tipo_suporte[]" value="{{ $tipo }}" 
                                               {{ in_array($tipo, $tiposSelecionados) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                                        <span class="text-sm">{{ $tipo }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRODUTOS -->
                <div class="flex-1 min-w-[300px]">
                    <h3 class="text-lg font-semibold text-gray-600 mb-4">📦 Produtos Utilizados</h3>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selecione os Produtos</label>
                    
                    <div class="relative">
                        <div class="w-full p-3 border border-gray-300 rounded-md cursor-pointer bg-white hover:border-gray-400 transition-colors"
                            onclick="toggleDropdown('productDropdown', 'productIcon')" id="productButton">
                            <div class="flex justify-between items-center">
                                <span id="productSelectedText" class="text-gray-700">
                                    @php
                                        $produtosCliente = is_string($cliente->produto) ? json_decode($cliente->produto, true) : $cliente->produto;
                                        $produtosCliente = $produtosCliente ?? [];
                                    @endphp
                                    @if(count($produtosCliente) > 0)
                                        {{ count($produtosCliente) == 1 ? $produtosCliente[0] : count($produtosCliente) . ' produtos selecionados' }}
                                    @else
                                        Clique para selecionar produtos...
                                    @endif
                                </span>
                                <svg class="w-4 h-4 text-gray-400 transform transition-transform" id="productIcon">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>

                        <div id="productDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                            <div class="p-2">
                                @php
                                    $produtos = ['Formula Certa', 'Rede e Computadores', 'Sim', 'Sorted', 'Outros', 'Sgf', 'Check', 'Scgpc', 'Popular', 'Wbalwin', 'Wcentcom', 'Bkmysql', 'Webtele', 'Abcfarma', 'Valid', 'Integra Consys', 'Ifood Consys', 'Farmacias App', 'Nexxtera', 'Scanntech', 'Gf'];
                                    $produtosSelecionados = is_string($cliente->produto) ? json_decode($cliente->produto, true) : $cliente->produto;
                                    $produtosSelecionados = $produtosSelecionados ?? [];
                                @endphp
                                @foreach($produtos as $produto)
                                    <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" name="produto[]" value="{{ $produto }}" 
                                               {{ in_array($produto, $produtosSelecionados) ? 'checked' : '' }}
                                               class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3"
                                               onchange="updateProductText()">
                                        <span class="text-sm">{{ $produto }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTATOS EXISTENTES DA TABELA CONTATOS -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-600">📞 Contatos</h3>
                    <button type="button" onclick="openAddContactModal()" 
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        + Adicionar Contato
                    </button>
                </div>

                @if($contatos && count($contatos) > 0)
                    <div class="space-y-4">
                        @foreach($contatos as $contato)
                            <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 flex-1">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Nome</label>
                                            <p class="text-gray-800 font-medium">{{ $contato->nome }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Cargo</label>
                                            <p class="text-gray-800">{{ $contato->cargo ?? 'Não informado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">Telefone</label>
                                            <p class="text-gray-800">{{ $contato->telefone ?? 'Não informado' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-500">E-mail</label>
                                            <p class="text-gray-800">{{ $contato->email ?? 'Não informado' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <button type="button" onclick="editContact({{ $contato->id }})" 
                                                class="text-blue-600 hover:text-blue-800 px-2 py-1 rounded">
                                            ✏️
                                        </button>
                                        <button type="button" onclick="deleteContact({{ $contato->id }})" 
                                                class="text-red-600 hover:text-red-800 px-2 py-1 rounded">
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 p-6 rounded-lg text-center">
                        <p class="text-gray-500 mb-4">Nenhum contato cadastrado para este cliente</p>
                        <button type="button" onclick="openAddContactModal()" 
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Cadastrar Primeiro Contato
                        </button>
                    </div>
                @endif
            </div>

            <!-- BOTÕES PRINCIPAIS -->
            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('clientes.index') }}" 
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    ❌ Voltar
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    💾 Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL PARA ADICIONAR CONTATO -->
<div id="addContactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Adicionar Novo Contato</h3>
            <button onclick="closeAddContactModal()" class="text-gray-500 hover:text-gray-700">✖</button>
        </div>
        
        <form id="addContactForm" action="{{ route('contatos.store') }}" method="POST">
            @csrf
            <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                    <input type="text" name="nome" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
                    <select name="cargo" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecione o cargo</option>
                        <option value="Atendente">Atendente</option>
                        <option value="Financeiro">Financeiro</option>
                        <option value="Almoxarife">Almoxarife</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Ge">Gerente</option>
                        <option value="Adm">Administrativo</option>
                        <option value="Diretor">Diretor</option>
                        <option value="Propietario">Proprietário</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                    <input type="text" name="telefone" placeholder="(00) 00000-0000"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                    <input type="email" name="email" placeholder="contato@empresa.com"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeAddContactModal()" 
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" 
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    💾 Salvar Contato
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL PARA EDITAR CONTATO -->
<div id="editContactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Editar Contato</h3>
            <button onclick="closeEditContactModal()" class="text-gray-500 hover:text-gray-700">✖</button>
        </div>
        
        <form id="editContactForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nome *</label>
                    <input type="text" name="nome" id="edit_nome" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cargo</label>
                    <select name="cargo" id="edit_cargo" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecione o cargo</option>
                        <option value="Atendente">Atendente</option>
                        <option value="Financeiro">Financeiro</option>
                        <option value="Almoxarife">Almoxarife</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Ge">Gerente</option>
                        <option value="Adm">Administrativo</option>
                        <option value="Diretor">Diretor</option>
                        <option value="Propietario">Proprietário</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                    <input type="text" name="telefone" id="edit_telefone"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                    <input type="email" name="email" id="edit_email"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditContactModal()" 
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    💾 Atualizar Contato
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    // Função principal para controlar o status do cliente
    function toggleClientStatus(isActive) {
        const formContainer = document.getElementById('formContainer');
        const overlay = document.getElementById('disabledOverlay');
        const clientInputs = document.querySelectorAll('.client-input');
        const clientButtons = document.querySelectorAll('.client-button');
        const statusSelect = document.getElementById('ativo');

        if (!isActive) {
            // Cliente desativado - bloqueia tudo
            formContainer.classList.add('form-disabled');
            overlay.classList.remove('hidden');
            
            // Desabilita todos os campos exceto o select de status
            clientInputs.forEach(input => {
                input.disabled = true;
                input.style.pointerEvents = 'none';
            });
            
            clientButtons.forEach(button => {
                button.disabled = true;
                button.style.pointerEvents = 'none';
            });
            
            // Mantém apenas o select de status ativo
            statusSelect.disabled = false;
            statusSelect.style.pointerEvents = 'auto';
            statusSelect.style.opacity = '1';
            
        } else {
            // Cliente ativo - libera tudo
            formContainer.classList.remove('form-disabled');
            overlay.classList.add('hidden');
            
            // Habilita todos os campos
            clientInputs.forEach(input => {
                input.disabled = false;
                input.style.pointerEvents = 'auto';
            });
            
            clientButtons.forEach(button => {
                button.disabled = false;
                button.style.pointerEvents = 'auto';
            });
        }
    }

    // Event listener para mudança de status
    document.getElementById('ativo').addEventListener('change', function() {
        const isActive = this.value === '1';
        toggleClientStatus(isActive);
        
        // Mostra notificação visual
        if (!isActive) {
            showNotification('Cliente desativado - Formulário bloqueado para edição', 'warning');
        } else {
            showNotification('Cliente ativado - Formulário liberado para edição', 'success');
        }
    });

    // Função para mostrar notificações
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all transform translate-x-0 ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-300' : 
            'bg-yellow-100 text-yellow-800 border border-yellow-300'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="mr-2">${type === 'success' ? '✅' : '⚠️'}</span>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove após 3 segundos
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Inicialização quando a página carrega
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('ativo');
        const isActive = statusSelect.value === '1';
        toggleClientStatus(isActive);
    });

    // Função para toggle do dropdown (modificada para respeitar o status)
    function toggleDropdown(dropdownId, iconId) {
        const formContainer = document.getElementById('formContainer');
        if (formContainer.classList.contains('form-disabled')) {
            return; // Não permite abrir dropdown se desativado
        }
        
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(iconId);
        
        dropdown.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }


    // Função para toggle do dropdown
    function toggleDropdown(dropdownId, iconId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(iconId);
        
        dropdown.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Atualizar texto dos produtos selecionados
    function updateProductText() {
        const checkboxes = document.querySelectorAll('input[name="produto[]"]:checked');
        const selectedText = document.getElementById('productSelectedText');
        
        if (checkboxes.length === 0) {
            selectedText.textContent = 'Clique para selecionar produtos...';
            selectedText.className = 'text-gray-500';
        } else if (checkboxes.length === 1) {
            selectedText.textContent = checkboxes[0].value;
            selectedText.className = 'text-gray-700';
        } else {
            selectedText.textContent = `${checkboxes.length} produtos selecionados`;
            selectedText.className = 'text-gray-700';
        }
    }

    // Modal para adicionar contato
    function openAddContactModal() {
        document.getElementById('addContactModal').classList.remove('hidden');
    }

    function closeAddContactModal() {
        document.getElementById('addContactModal').classList.add('hidden');
        document.getElementById('addContactForm').reset();
    }

    // Modal para editar contato
    function editContact(contactId) {
        // Fazer requisição AJAX para buscar dados do contato
        fetch(`/contatos/${contactId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit_nome').value = data.nome || '';
                document.getElementById('edit_cargo').value = data.cargo || '';
                document.getElementById('edit_telefone').value = data.telefone || '';
                document.getElementById('edit_email').value = data.email || '';
                
                document.getElementById('editContactForm').action = `/contatos/${contactId}`;
                document.getElementById('editContactModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar dados do contato');
            });
    }

    function closeEditContactModal() {
        document.getElementById('editContactModal').classList.add('hidden');
        document.getElementById('editContactForm').reset();
    }

    // Excluir contato
    function deleteContact(contactId) {
        if (confirm('Tem certeza que deseja excluir este contato?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/contatos/${contactId}`;
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = '{{ csrf_token() }}';
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Fechar modais ao clicar fora
    document.addEventListener('click', function(e) {
        if (e.target.id === 'addContactModal') {
            closeAddContactModal();
        }
        if (e.target.id === 'editContactModal') {
            closeEditContactModal();
        }
    });

    // Fechar dropdowns ao clicar fora
    document.addEventListener('click', function(event) {
        const supportButton = document.getElementById('supportButton');
        const supportDropdown = document.getElementById('supportDropdown');
        const productButton = document.getElementById('productButton');
        const productDropdown = document.getElementById('productDropdown');
        
        if (!supportButton.contains(event.target) && !supportDropdown.contains(event.target)) {
            supportDropdown.classList.add('hidden');
            document.getElementById('supportIcon').classList.remove('rotate-180');
        }
        
        if (!productButton.contains(event.target) && !productDropdown.contains(event.target)) {
            productDropdown.classList.add('hidden');
            document.getElementById('productIcon').classList.remove('rotate-180');
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('ativo');
    const formContainer = document.getElementById('formContainer');
    
    function updateStatusColors() {
        const isActive = statusSelect.value === '1';
        
        // Remove classes anteriores
        statusSelect.classList.remove('status-ativo', 'status-desativado');
        
        // Adiciona a classe correta
        if (isActive) {
            statusSelect.classList.add('status-ativo');
            formContainer?.classList.remove('disabled');
        } else {
            statusSelect.classList.add('status-desativado');
            formContainer?.classList.add('disabled');
        }
    }
    
    updateStatusColors();
    statusSelect.addEventListener('change', updateStatusColors);
});

</script>

@endsection