@extends('layouts.app')

@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">

    <div class="bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Cadastro de Filial</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('filiais.store') }}" method="POST">
            @csrf

            <!-- DADOS DA FILIAL -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">🏢 Dados da Filial</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome da Filial <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente Vinculado <span class="text-red-500">*</span></label>
                       <select name="cliente_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                            <option value="">Selecione um Cliente</option>
                            @foreach($clientes as $cliente)
                               <option value="{{ $cliente->id }}" {{ (isset($filial) && $filial->cliente_id == $cliente->id) ? 'selected' : '' }}>
                                    {{ $cliente->nome_cliente }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                        <input type="text" name="cnpj" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Razão Social</label>
                        <input type="text" name="razao_social" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Endereço</label>
                        <input type="text" name="endereco" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado (UF)</label>
                        <input type="text" name="estado" maxlength="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cidade</label>
                        <input type="text" name="cidade" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bairro</label>
                        <input type="text" name="bairro" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-8 mb-8">
        <!-- TIPO DE SUPORTE -->
        <div class="flex-1 min-w-[300px]">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">💻 Tipo de Suporte</h3>
            <label class="block text-sm font-medium text-gray-700 mb-2">Selecione o Tipo</label>
            
            <div class="relative">
                <div class="w-full p-3 border border-gray-300 rounded-md cursor-pointer bg-white hover:border-gray-400 transition-colors"
                    onclick="toggleDropdown('supportDropdown', 'supportIcon')" id="supportButton">
                    <div class="flex justify-between items-center">
                        <span id="supportSelectedText" class="text-gray-500">Clique para selecionar...</span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform" id="supportIcon">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Dropdown com checkboxes -->
                <div id="supportDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    <div class="p-2">
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="Rede e Computadores" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Rede e Computadores</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="Consys" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Consys</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="Formula Certa" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Formula Certa</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="Sorted" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Sorted</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="Sim" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Sim</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="GF" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">GF</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="tipo_suporte[]" value="Seleção Municipal" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Seleção Municipal</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUTO UTILIZADO -->
        <div class="flex-1 min-w-[300px]">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">💻 Produto Utilizado</h3>
            <label class="block text-sm font-medium text-gray-700 mb-2">Selecione os Produtos</label>
            
            <div class="relative">
                <div class="w-full p-3 border border-gray-300 rounded-md cursor-pointer bg-white hover:border-gray-400 transition-colors"
                    onclick="toggleDropdown('productDropdown', 'productIcon')" id="productButton">
                    <div class="flex justify-between items-center">
                        <span id="productSelectedText" class="text-gray-500">Clique para selecionar produtos...</span>
                        <svg class="w-4 h-4 text-gray-400 transform transition-transform" id="productIcon">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Dropdown com checkboxes -->
                <div id="productDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                    <div class="p-2">
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Formula Certa" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Formula Certa</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Rede e Computadores" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Rede e Computadores</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Sim" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Sim</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Sorted" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Sorted</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Outros" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Outros</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Sgf" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Sgf</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Check" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Check</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Scgpc" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Scgpc</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Popular" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Popular</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Wbalwin" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Wbalwin</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Wcentcom" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Wcentcom</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Bkmysql" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Bkmysql</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Webtele" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Webtele</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Abcfarma" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Abcfarma</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Valid" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Valid</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Integra Consys" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Integra Consys</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Ifood Consys" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Ifood Consys</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Farmacisa App" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Farmacias App</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Nexxtera" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Nexxtera</span>
                        </label>
                         <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Scanntech" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Scanntech</span>
                        </label>
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded cursor-pointer">
                            <input type="checkbox" name="produto[]" value="Gf" class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                            <span class="text-sm">Gf</span>
                        </label>
                        
                    </div>    
                </div>
            </div>
        </div>
    </div>

            <!-- CONTATOS -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">📞 Contatos</h3>
                <div id="contatos-wrapper" class="space-y-4">
                    <div class="contato-item flex flex-wrap gap-4 items-end">
                <input type="text" name="contatos_filial[0][nome]" placeholder="Nome" 
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            
            <select name="contatos_filial[0][cargo]" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Selecione o cargo</option>
                <option value="Atendente">Atendente</option>
                <option value="Financeiro">Financeiro</option>
                <option value="Almoxarife">Almoxarife</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Ge">Ge</option>
                <option value="Adm">Adm</option>
                <option value="Diretor">Diretor</option>
                <option value="Propietario">Propietario</option>
            </select>
            
            <input type="text" name="contatos_filial[0][telefone]" placeholder="Telefone" 
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            
            <input type="text" name="contatos_filial[0][email]" placeholder="E-mail" 
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            
            <button type="button" class="remover-contato text-red-600 font-bold">✖</button>
        </div>
    </div>

    <button type="button" id="adicionar-contato" class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        + Adicionar Contato
    </button>
</div>
            <!-- BOTÃO -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('filiais.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    ❌ Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    💾 Salvar Filial
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    document.getElementById('adicionar-contato').addEventListener('click', function () {
        const wrapper = document.getElementById('contatos-wrapper');
        const novaDiv = document.createElement('div');
        novaDiv.classList.add('contato-item', 'flex', 'flex-wrap', 'gap-4', 'items-end');

        novaDiv.innerHTML = `
            <input type="text" name="contato_nome[]" placeholder="Nome" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <select name="contato_cargo[]" placeholder="Cargo" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione o cargo</option>
                    <option value="Atendente">Atendente</option>
                    <option value="Financeiro">Financeiro</option>
                    <option value="Almoxarife">Almoxarife</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Ge">Ge</option>
                    <option value="Adm">Adm</option>
                    <option value="Diretor">Diretor</option>
                    option value="Propietario">Propietario</option>
            </select>
            <input type="text" name="contato_telefone[]" placeholder="Telefone" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <input type="text" name="contato_email[]" placeholder="E-mail" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <button type="button" class="remover-contato text-red-600 font-bold">✖</button>
        `;

        wrapper.appendChild(novaDiv);
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remover-contato')) {
            e.target.parentElement.remove();
        }
    });
</script>

<script>
 function showSelected() {
            const checkboxes = document.querySelectorAll('input[name="produto[]"]:checked');
            const selected = Array.from(checkboxes).map(cb => cb.value);
            
            const selectedDiv = document.getElementById('selectedProducts');
            const selectedList = document.getElementById('selectedList');
            
            if (selected.length > 0) {
                selectedList.innerHTML = selected.join(', ');
            } else {
                selectedList.innerHTML = 'Nenhum produto selecionado';
            }
            selectedDiv.classList.remove('hidden');
        }

        function clearAll() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = false);
            updateSelectedText();
        }

        // Função para toggle do dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            const icon = document.getElementById('dropdownIcon');
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Atualizar texto do select
        function updateSelectedText() {
            const checkboxes = document.querySelectorAll('input[name="produto[]"]:checked');
            const selectedText = document.getElementById('selectedText');
            
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

        // Event listeners para os checkboxes
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedText);
        });

        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(event) {
            const selectButton = document.getElementById('selectButton');
            const dropdown = document.getElementById('dropdown');
            
            if (!selectButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
                document.getElementById('dropdownIcon').style.transform = 'rotate(0deg)';
            }
        });

        // Adicionar ícone SVG
        document.getElementById('dropdownIcon').innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
        
        function toggleDropdown(dropdownId, iconId) {
            const dropdown = document.getElementById(dropdownId);
            const icon = document.getElementById(iconId);
            
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        function selectAll(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        }

        function clearAll(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
        </script>

@endsection
