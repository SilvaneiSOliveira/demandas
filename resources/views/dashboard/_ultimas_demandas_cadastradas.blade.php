@forelse($ultimasDemandas as $demanda)
    <tr class="bg-white border-t text-sm text-gray-800" data-id="{{ $demanda->id }}">
        <td class="px-4 py-2">{{ $demanda->id }}</td>
        <td class="px-4 py-2">{{ $demanda->solicitante ?? 'Não Informado' }}</td>
        <td class="px-4 py-2">{{ $demanda->cliente->nome_cliente ?? '-' }} / {{ $demanda->filial->nome ?? '-' }}</td>
        <td class="px-4 py-2">{{ $demanda->cliente->produto ?? '-' }}</td>
        <td class="px-4 py-2">
            <span class="text-xs font-semibold px-3 py-1 rounded-full text-white
                @if(strtolower($demanda->status) == 'aberta') bg-red-500
                @elseif(strtolower($demanda->status) == 'andamento' || strtolower($demanda->status) == 'em andamento') bg-yellow-500
                @elseif(strtolower($demanda->status) == 'concluida' || strtolower($demanda->status) == 'concluída') bg-green-600
                @else bg-blue-600
                @endif">
                {{ ucfirst($demanda->status) }}
            </span>
        </td>
        <td class="px-4 py-2">
            <span class="text-xs font-bold px-3 py-1 rounded-full text-white
                @if($demanda->nivel == '1') bg-red-500
                @elseif($demanda->nivel == '2') bg-yellow-500
                @elseif($demanda->nivel == '3') !bg-orange-500
                @elseif($demanda->nivel == '4') bg-blue-600
                @else bg-gray-500
                @endif">
                {{ $demanda->nivel }}
            </span>
        </td>
        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($demanda->data_agendamento)->format('d/m/Y') }}</td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center text-gray-500 py-4">Nenhuma demanda cadastrada.</td>
    </tr>
@endforelse
