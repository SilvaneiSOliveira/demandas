@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-cyan-700 tracking-tight flex items-center gap-2">
            ⚙️ Cadastrar Computador
        </h2>
    </div>

    {{-- Mensagem de erro de validação --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 shadow">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl shadow-lg p-8 transition hover:shadow-xl">
        <form action="{{ route('tombamentos.computadores.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Cliente --}}
                <div>
                    <label for="cliente_id" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        👤 Cliente <span class="text-red-500">*</span>
                    </label>
                    <select name="cliente_id" id="cliente_id" required 
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Selecione o cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome_cliente }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filial --}}
                <div>
                    <label for="filial_id" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        🏢 Filial
                    </label>
                    <select name="filial_id" id="filial_id"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">-- Sem filial --</option>
                    </select>
                </div>

                {{-- TAG --}}
                <div>
                    <label for="tag" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        🔖 TAG <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tag" id="tag" value="{{ old('tag') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Local --}}
                <div>
                    <label for="local" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        📍 Local <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="local" id="local" value="{{ old('local') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Processador --}}
                <div>
                    <label for="processador" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        ⚡ Processador <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="processador" id="processador" value="{{ old('processador') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Memória RAM --}}
                <div>
                    <label for="memoria_ram" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        💾 Memória RAM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="memoria_ram" id="memoria_ram" value="{{ old('memoria_ram') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Armazenamento --}}
                <div>
                    <label for="armazenamento" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        📂 Armazenamento <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="armazenamento" id="armazenamento" value="{{ old('armazenamento') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Sistema Operacional --}}
                <div>
                    <label for="sistema_operacional" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        🖥️ Sistema Operacional <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="sistema_operacional" id="sistema_operacional" value="{{ old('sistema_operacional') }}" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">
                </div>

                {{-- Observação --}}
                <div class="md:col-span-2">
                    <label for="observacao" class="flex items-center gap-2 font-semibold text-slate-800 mb-1">
                        📝 Observação
                    </label>
                    <textarea name="observacao" id="observacao" rows="3"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500">{{ old('observacao') }}</textarea>
                </div>
            </div>

            {{-- Botões --}}
            <div class="flex gap-4 pt-4">
                <button type="submit" 
                    class="flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition">
                    💾 Salvar
                </button>
                <a href="{{ route('tombamentos.computadores.index') }}" 
                    class="flex items-center gap-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition">
                    ← Voltar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const clienteSelect = document.getElementById('cliente_id');
    const filialSelect = document.getElementById('filial_id');
    
    clienteSelect.addEventListener('change', function() {
        const clienteId = this.value;
        filialSelect.innerHTML = '<option value="">-- Sem filial --</option>';
        
        if (clienteId) {
            fetch(`/tombamentos/clientes/${clienteId}/filiais`)
                .then(response => response.json())
                .then(filiais => {
                    filiais.forEach(filial => {
                        const option = document.createElement('option');
                        option.value = filial.id;
                        option.textContent = filial.nome;
                        filialSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar filiais:', error);
                });
        }
    });
});
</script>
