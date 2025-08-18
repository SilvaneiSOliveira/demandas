@extends('layouts.app')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold mb-4">Relatório Analítico</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Demandas por mês -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-2">Demandas por Mês</h3>
      <canvas id="mesChart"></canvas>
    </div>

    <!-- Top 5 clientes -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-2">Top 5 Clientes com Mais Demandas</h3>
      <canvas id="clientesChart"></canvas>
    </div>

    <!-- Níveis -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-2">Quantidade por Nível</h3>
      <canvas id="nivelChart"></canvas>
    </div>

    <!-- Tipo de atendimento -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-2">Tipo de Atendimento</h3>
      <canvas id="tipoChart"></canvas>
    </div>

    <!-- Técnicos com mais atendimentos -->
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold mb-2">Técnicos com Mais Atendimentos</h3>
      <canvas id="atendentesChart"></canvas>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Demandas por mês
  new Chart(document.getElementById('mesChart'), {
    type: 'line',
    data: {
      labels: @json($meses),
      datasets: [{
        label: 'Demandas',
        data: @json($demandasPorMes),
        borderColor: '#3b82f6',
        backgroundColor: 'rgba(59,130,246,0.2)',
        fill: true,
        tension: 0.4
      }]
    }
  });

  // Top 5 clientes
  new Chart(document.getElementById('clientesChart'), {
    type: 'bar',
    data: {
    labels: {!! json_encode($nomesClientes) !!},
    datasets: [{
    label: 'Top 5 clientes com mais demandas',
    data: {!! json_encode($qtdClientes) !!},
        backgroundColor: '#10b981'
      }]
    }
  });

  // Quantidade por nível
 new Chart(document.getElementById('nivelChart'), {
  type: 'bar',
  data: {
    labels: @json($niveis),
    datasets: [{
      label: 'Demandas',
      data: @json($qtdPorNivel),
      backgroundColor: [
        '#6b7280', // cinza - nível 0
        '#ef4444', // vermelho - nível 1
        '#facc15', // amarelo - nível 2
        '#fb923c', // laranja - nível 3
        '#3b82f6'  // azul - nível 4
      ]
    }]
  },
  options: {
    indexAxis: 'y'
  }
});


  // Tipo de atendimento
  new Chart(document.getElementById('tipoChart'), {
    type: 'bar',
    data: {
      labels: ['Presencial', 'Remoto'],
      datasets: [{
        label: 'Demandas',
        data: [{{ $qtdPresenciais }}, {{ $qtdRemotos }}],
        backgroundColor: ['#6366f1', '#06b6d4']
      }]
    },
    options: {
      plugins: {
        legend: { display: false }
      }
    }
  });

  // Técnicos com mais atendimentos
  new Chart(document.getElementById('atendentesChart'), {
    type: 'bar',
    data: {
      labels: @json($nomesAtendentes),
      datasets: [{
        label: 'Atendimentos',
        data: @json($qtdAtendentes),
        backgroundColor: 'rgba(59,130,246,0.2)',
        borderColor: '#3b82f6'
      }]
    }
  });
</script>
@endsection
