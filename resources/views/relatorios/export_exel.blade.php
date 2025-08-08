<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Filial</th>
            <th>Atendente</th>
            <th>Data/Atendimento</th>
            <th>Status</th>
            <th>Solicitante</th>   
        </tr>
    </thead>
    <tbody>
        @foreach ($demandas as $demanda)
            <tr>
                <td>{{ $demanda->cliente->nome}}</td>
                <td>{{ $demanda->filial->nome}}</td>
                <td>{{ $demanda->atendente }}</td>
                <td>{{ \Carbon\Carbon::parse($demanda->data_agendamento)->format('d/m/Y') }}</td>
                <td>{{ $demanda->status}}</td>
                <td>{{ $demanda->solicitante }}</td>    
            </tr>
        @endforeach
    </tbody>
</table>
