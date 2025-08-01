@extends('layouts.app')

@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">

    <div class="bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Cadastro de Cliente</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <!-- DADOS DO CLIENTE -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">🧾 Dados do Cliente</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome do Cliente.<span class="text-red-500">*</span></label>
                        <input type="text" name="nome_cliente" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Razão Social.</label>
                        <input type="text" name="razao_social" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cnpj.</label>
                        <input type="text" name="cnpj" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Endereço.</label>
                        <input type="text" name="endereco" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bairro.</label>
                        <input type="text" name="bairro" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cidade.</label>
                        <input type="text" name="cidade" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado (UF).</label>
                        <input type="text" name="estado" maxlength="2" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- PRODUTO -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">💻 Produto Utilizado</h3>
                <label class="block text-sm font-medium text-gray-700 mb-1">Selecione os Produtos</label>
                <select name="produto[]" multiple class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="Consys">Consys</option>
                    <option value="Fórmula Certa">Fórmula Certa</option>
                    <option value="Gf">Gf</option>
                    <option value="Infraestrutura">Infraestrutura</option>
                    <option value="Sim">Sim</option>
                    <option value="Sorted">Sorted</option>
                    <option value="Outros">Outros</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Segure Ctrl (ou Command) para selecionar mais de um.</p>
            </div>

            <!-- CONTATOS -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">📞 Contatos</h3>
                <div id="contatos-wrapper" class="space-y-4">
                    <div class="contato-item flex flex-wrap gap-4 items-end">
                        <input type="text" name="contato_nome[]" placeholder="Nome" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <input type="text" name="contato_cargo[]" placeholder="Cargo" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <input type="text" name="contato_telefone[]" placeholder="Telefone" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="remover-contato text-red-600 font-bold">✖</button>
                    </div>
                </div>

                <button type="button" id="adicionar-contato" class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    + Adicionar Contato
                </button>
            </div>

            <!-- BOTÃO -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    💾 Salvar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('adicionar-contato').addEventListener('click', function () {
        const wrapper = document.getElementById('contatos-wrapper');
        const novaDiv = document.createElement('div');
        novaDiv.classList.add('contato-item', 'flex', 'flex-wrap', 'gap-4', 'items-end');

        novaDiv.innerHTML = `
            <input type="text" name="contato_nome[]" placeholder="Nome" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <input type="text" name="contato_cargo[]" placeholder="Cargo" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <input type="text" name="contato_telefone[]" placeholder="Telefone" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
@endsection
