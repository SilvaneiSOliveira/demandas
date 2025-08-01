@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Visualizar Cliente</h2>

    <form id="formCliente" action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="form-control" value="{{ $cliente->nome_cliente }}" disabled>
        </div>

        <div class="mb-3">
            <label for="cnpj">CNPJ:</label>
            <input type="text" name="cnpj" class="form-control" value="{{ $cliente->cnpj }}" disabled>
        </div>

        <!-- Outros campos aqui... -->

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-warning" onclick="habilitarCampos()">Editar</button>
            <button type="submit" class="btn btn-success" disabled id="btnSalvar">Salvar</button>

            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Confirma exclusão?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Excluir</button>
            </form>
        </div>
    </form>
</div>

<script>
    function habilitarCampos() {
        const inputs = document.querySelectorAll('#formCliente input');
        inputs.forEach(input => input.removeAttribute('disabled'));

        document.getElementById('btnSalvar').removeAttribute('disabled');
    }
</script>
@endsection
