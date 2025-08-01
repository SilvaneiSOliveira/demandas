@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Usuário</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        @include('user.form', ['user' => $user])

        <div>
            <label for="ativo" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="ativo" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="1" {{ (old('ativo', $user->ativo ?? 1) == 1) ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ (old('ativo', $user->ativo ?? 1) == 0) ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition">
                Atualizar
            </button>
        </div>
    </form>
</div>
@endsection

