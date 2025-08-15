@extends('layouts.app')

@section('title', 'Editar Demanda')

@section('content')
<div class="container mt-4">
    <h2>Demanda Selecionada</h2>

    <form action="{{ route('demandas.update', $demanda->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $demanda->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4" required>{{ old('descricao', $demanda->descricao) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="Aberta" {{ $demanda->status == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                <option value="Em andamento" {{ $demanda->status == 'Em andamento' ? 'selected' : '' }}>Em andamento</option>
                <option value="Concluida" {{ $demanda->status == 'Concluida' ? 'selected' : '' }}>Concluída</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="{{ route('demandas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
