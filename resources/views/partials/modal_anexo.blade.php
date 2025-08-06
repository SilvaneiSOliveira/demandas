<div id="modalAnexo" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 md:w-1/2">
        <h2 class="text-xl font-semibold mb-4">Anexar Arquivo</h2>
        
        <form action="{{ route('demanda.anexar', $demanda->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="anexo" class="mb-4" required>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="fecharModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enviar</button>
            </div>
        </form>

        <div class="mt-4 flex justify-between items-center">
            <p><strong>Anexos:</strong> {{ $demanda->anexos->count() }} arquivo(s)</p>

            @if($demanda->anexos->count() > 0)
                <button type="button" onclick="abrirModalAnexos()" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                    Visualizar Anexos
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Modal Visualização Anexos -->
<div id="modalAnexos" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 md:w-2/3 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Arquivos Anexados</h2>
            <button onclick="fecharModalAnexos()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        </div>

        <ul class="divide-y divide-gray-300">
            @foreach ($demanda->anexos as $anexo)
                <li class="flex justify-between items-center py-2">
                    <span>{{ $anexo->nome_arquivo }}</span>
                    <a href="{{ asset('storage/' . $anexo->caminho) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Abrir</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
