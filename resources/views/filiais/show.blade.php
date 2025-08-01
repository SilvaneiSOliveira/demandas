@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Visualizar Filial</h2>

    <form id="formFilial" action="{{ route('filiais.update', $filial->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome">Nome da Filial:</label>
            <input type="text" name="nome_filial" class="form-control" value="{{ $filial->nome_filial }}" disabled>
        </div>

        <div class="mb-3">
            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" class="form-control" value="{{ $filial->endereco }}" disabled>
        </div>

        <div class="mb-3">
            <label for="cliente_id">Cliente:</label>
            <input type="text" class="form-control" value="{{ $filial->cliente->nome_cliente }}" disabled>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-warning" onclick="habilitarCampos()">Editar</button>
            <button type="submit" class="btn btn-success" disabled id="btnSalvar">Salvar</button>

            <form action="{{ route('filiais.destroy', $filial->id) }}" method="POST" onsubmit="return confirm('Confirma exclusão?')" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Excluir</button>
            </form>
        </div>
    </form>
</div>

<script>
    function habilitarCampos() {
        const inputs = document.querySelectorAll('#formFilial input');
        inputs.forEach(input => input.removeAttribute('disabled'));

        document.getElementById('btnSalvar').removeAttribute('disabled');
    }
</script>
@endsection
