@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cadastrar Novo Usuário</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        @include('user.form')

        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>
@endsection


