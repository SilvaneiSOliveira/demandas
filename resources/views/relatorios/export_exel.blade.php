<table>
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Técnico</th>
            <th>Data</th>
            <th>Solicitante</th>
            <th>resolucao</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($demandas as $demanda)
            <tr>
                <td>{{ $demanda->empresa->nome ?? '' }}</td>
                <td>{{ $demanda->atendente->nome ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($demanda->data_agendamento)->format('d/m/Y') }}</td>
                <td>{{ $demanda->solicitante }}</td>
                <td>{{ $demanda->resolucao }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
