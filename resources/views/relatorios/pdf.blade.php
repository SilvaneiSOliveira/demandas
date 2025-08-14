<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Demandas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Relatório de Demandas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Filial</th>
                <th>Título</th>
                <th>Status</th>
                <th>Data de Criação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($relatorios as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ $d->cliente->nome_cliente ?? '' }}</td>
                    <td>{{ $d->filial->nome ?? '' }}</td>
                    <td>{{ $d->titulo }}</td>
                    <td>{{ $d->status }}</td>
                    <td>{{ $d->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Rodapé fixo -->
    <div style="position: relative; font-weight: 600; font-size: 14px; margin-top: 4px;">
        <div style="float: left;">
            Gerado em {{ $dataGeracao }}
        </div>
        <div style="float: right;">
            Total de demandas: {{ $totalDemandas }}
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>