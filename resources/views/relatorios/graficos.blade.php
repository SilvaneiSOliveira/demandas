@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Cards de status -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
   
    <div class="bg-red-500 p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Demandas Abertas</h2>
        <p id="abertas" class="text-3xl font-bold text-white">{{ $abertas }}</p>
    </div>

    <div class="bg-yellow-500 p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Em Andamento</h2>
        <p id="andamento" class="text-3xl font-bold text-white">{{ $andamento }}</p>
    </div>

   <div class="bg-green-600 p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Demandas Concluídas</h2>
        <p id="concluidas" class="text-3xl font-bold text-white">{{ $concluidas }}</p>
   </div>

   <div class="bg-black p-4 rounded-2xl shadow text-center">
        <h2 class="text-lg font-semibold text-white">Total de Demandas</h2>
        <p id="total" class="text-3xl font-bold text-white">{{ $total }}</p>
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
                    <th class="px-4 py-2">AGEND / ATEND</th>
                </tr>
            </thead>
            
            <tbody id="tbody-ultimas">
                @include('dashboard._ultimas_demandas_cadastradas', ['ultimasDemandas' => $ultimasDemandas])
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
<!-- Biblioteca Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Biblioteca Axios para requisições AJAX -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ==== GRÁFICO ====
    const ctx = document.getElementById('graficoEvolucaoDemandas');

    if (ctx) {
        const graficoEvolucaoDemandas = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsUltimasDemandas ?? []) !!},
                datasets: [{
                    label: 'Demandas por dia',
                    data: {!! json_encode($valoresUltimasDemandas ?? []) !!},
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
                        title: { display: true, text: 'Qtd. Demandas' }
                    },
                    x: {
                        title: { display: true, text: 'Data' }
                    }
                }
            }
        });
    }

    // ==== FUNÇÕES DE ATUALIZAÇÃO ====
    function atualizarContadores() {
        axios.get('{{ route("dashboard.contadores") }}')
            .then(res => {
                document.querySelector('#abertas').textContent = res.data.abertas;
                document.querySelector('#andamento').textContent = res.data.andamento;
                document.querySelector('#concluidas').textContent = res.data.concluidas;
                document.querySelector('#total').textContent = res.data.total;
            });
    }

    function atualizarUltimasDemandas() {
        axios.get('{{ route("dashboard.ultimas") }}')
            .then(res => {
                document.querySelector('#tbody-ultimas').innerHTML = res.data.html;
            });
    }

    // Atualiza a cada 2 segundos
    setInterval(() => {
        atualizarContadores();
        atualizarUltimasDemandas();
    }, 5000);
});
</script>
@endsection




