@extends('layouts.app')

@section('content')
<div class="w-full px-8 bg-white shadow-md rounded-lg py-8 mt-15">
    <div class="bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-2">Cliente Selecionado</h2>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nome do Cliente</label>
                    <input type="text" name="nome_cliente" value="{{ $cliente->nome_cliente }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">CNPJ</label>
                    <input type="text" name="cnpj" value="{{ $cliente->cnpj }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Razão Social</label>
                    <input type="text" name="razao_social" value="{{ $cliente->razao_social }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Telefone</label>
                    <input type="text" name="telefone" value="{{ $cliente->telefone }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>

               

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Endereço</label>
                    <input type="text" name="endereco" value="{{ $cliente->endereco }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>

               

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Complemento</label>
                    <input type="text" name="complemento" value="{{ $cliente->complemento }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Bairro</label>
                    <input type="text" name="bairro" value="{{ $cliente->bairro }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Cidade</label>
                    <input type="text" name="cidade" value="{{ $cliente->cidade }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Estado</label>
                    <input type="text" name="estado" value="{{ $cliente->estado }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('clientes.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Voltar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar Alterações</button>
            </div>
        </form>
        
    </div>
    
</div>
@endsection
