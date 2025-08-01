@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Cards de status -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
   
    <div class="bg-red-500 p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Demandas Abertas</h2>
        <p class="text-3xl font-bold text-white">{{ $abertas }}</p>
    </div>

    <div class="bg-yellow-500 p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Demandas Pendentes</h2>
        <p class="text-3xl font-bold text-white">{{ $andamento }}</p>
    </div>

   <div class="bg-green-600 p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Demandas Concluídas</h2>
        <p class="text-3xl font-bold text-white">{{ $concluidas }}</p>
   </div>

   <div class="bg-black p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Total de Demandas</h2>
        <p class="text-3xl font-bold text-white">{{ $total }}</p>
   </div>
</div>

    <!-- Últimas Demandas -->
<div class="bg-white rounded-2xl shadow p-4 mb-6">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Últimas Demandas</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300 rounded-xl">
            <thead>
                <tr class="bg-gray-700 text-white text-left text-sm">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">SOLICITANTE</th>
                    <th class="px-4 py-2">CLIENTE / FILIAL</th>
                    <th class="px-4 py-2">PRODUTO</th>
                    <th class="px-4 py-2">STATUS</th>
                    <th class="px-4 py-2">NÍVEL</th>
                    <th class="px-4 py-2">AGENDAMENTO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimasDemandas as $demanda)
                    <tr class="bg-white border-t text-sm text-gray-800">
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
                    <tr><td colspan="7" class="text-center text-gray-500 py-4">Nenhuma demanda cadastrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


   
    <!-- Gráfico Evolução das Demandas -->
<div class="bg-white rounded-2xl shadow p-4 mb-6">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Evolução das Demandas</h2>
    <canvas id="graficoEvolucaoDemandas" height="100"></canvas>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('graficoEvolucaoDemandas');

        if (ctx) {
            const graficoEvolucaoDemandas = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labelsUltimasDemandas ?? []) !!}, // Ex: ['2025-07-25', '2025-07-26', ...]
                    datasets: [{
                        label: 'Demandas por dia',
                        data: {!! json_encode($valoresUltimasDemandas ?? []) !!}, // Ex: [3, 5, 2, ...]
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        tooltip: { mode: 'index', intersect: false },
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Qtd. Demandas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Data'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection



