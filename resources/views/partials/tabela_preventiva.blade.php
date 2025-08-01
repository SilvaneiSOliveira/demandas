<table class="w-full text-sm text-left border">
    <thead>
        <tr>
            <th class="border p-2">Filial</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Data Visita</th>
            <th class="border p-2">Observações</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($preventivas as $p)
        @php
            $status = strtoupper(trim($p->status)); // garante que vai comparar certo
            $classeStatus = match ($status) {
                'OK' => 'bg-green-600 text-white font-semibold',
                'PENDENTE' => 'bg-yellow-500 text-white font-semibold',
                default => 'bg-white text-black',
            };
        @endphp

        <tr>
            <td class="border p-2">
                {{ $p->filial }}
                <input type="hidden" name="filial[]" value="{{ $p->filial }}">
            </td>

            <td class="border p-2">
                <input 
                    type="text" 
                    name="status[{{ $p->filial }}]" 
                    value="{{ $p->status }}"
                    class="w-full px-3 py-2 border rounded {{ $classeStatus }}"
                >
            </td>

            <td class="border p-2">
                <input 
                    type="date" 
                    name="data[{{ $p->filial }}]" 
                    value="{{ $p->data }}"
                    class="w-full px-3 py-2 border rounded"
                >
            </td>

            <td class="border p-2">
                <input 
                    type="text" 
                    name="observacoes[{{ $p->filial }}]" 
                    value="{{ $p->observacoes }}"
                    class="w-full px-3 py-2 border rounded"
                >
            </td>
        </tr>
@endforeach


    </tbody>

   
</table>
