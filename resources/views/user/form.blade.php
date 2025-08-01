<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
        class="w-full px-2 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="mb-4">
    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
    <select name="tipo" required
        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="admin" {{ old('tipo', $user->tipo ?? '') == 'admin' ? 'selected' : '' }}>Administrador</option>
        <option value="tecnico" {{ old('tipo', $user->tipo ?? '') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
        <option value="user" {{ old('tipo', $user->tipo ?? '') == 'user' ? 'selected' : '' }}>Usuário</option>
    </select>
</div>

<div class="mb-4">
    <label for="ativo" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
    <select name="ativo"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="1" {{ old('ativo', $user->ativo ?? 1) == 1 ? 'selected' : '' }}>Ativo</option>
        <option value="0" {{ old('ativo', $user->ativo ?? 1) == 0 ? 'selected' : '' }}>Inativo</option>
    </select>
</div>

@if (!isset($user))
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
        <input type="password" name="password" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
@endif
