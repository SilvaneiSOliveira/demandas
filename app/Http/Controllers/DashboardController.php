<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
       
        return view('dashboard');
    }
    
    public function graficos()
    {
        
        return redirect()->route('relatorios.graficos');
    }

    public function getData()
    {
        $abertas = Demanda::where('status', 'Aberta')->count();
        $andamento = Demanda::where('status', 'Andamento')->count();
        $concluidas = Demanda::where('status', 'Concluída')->count();
        $total = Demanda::count();
        $ultimasDemandas = Demanda::latest()->take(5)->get();
        
        // Ajuste conforme sua lógica para o gráfico
        $labels = $ultimasDemandas->pluck('cliente.nome')->toArray();
        $valores = array_fill(0, count($labels), 1); // Exemplo simples
        
        return response()->json([
            'abertas' => $abertas,
            'andamento' => $andamento,
            'concluidas' => $concluidas,
            'total' => $total,
            'tabela' => view('partials.tabela-demandas', ['ultimasDemandas' => $ultimasDemandas])->render(),
            'labels' => $labels,
            'valores' => $valores
        ]);
    }

    public function contadores()
    {
        return response()->json([
            'abertas' => Demanda::where('status', 'Aberta')->count(),
            'andamento' => Demanda::where('status', 'Em Andamento')->count(),
            'concluidas' => Demanda::where('status', 'Concluída')->count(),
            'total' => Demanda::count()
        ]);
    }

    public function ultimasDemandas()
{
    $ultimasDemandas = Demanda::with(['cliente', 'filial', 'atendente'])
        ->whereIn(DB::raw('LOWER(status)'), ['aberta', 'em andamento', 'andamento']) // FILTRO APENAS ABERTAS E EM ANDAMENTO
        ->orderByRaw("CASE 
            WHEN LOWER(status) = 'aberta' THEN 0 
            WHEN LOWER(status) IN ('em andamento', 'andamento') THEN 1 
            ELSE 2 
        END") // PRIORIZA ABERTAS NO TOPO
        ->orderBy('created_at', 'desc')
        ->limit(10) // Aumentei de 6 para 10 já que agora filtra apenas as ativas
        ->get();

    $html = view('dashboard._ultimas_demandas_cadastradas', compact('ultimasDemandas'))->render();

    return response()->json(['html' => $html]);
}

}
