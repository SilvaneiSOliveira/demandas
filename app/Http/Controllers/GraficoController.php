<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Demanda;

class GraficoController extends Controller
{
    public function index()
    {
        // Totais por status
        $abertas = Demanda::where('status', 'aberta')->count();
        $andamento = Demanda::whereIn('status', ['em andamento', 'andamento'])->count();
        $concluidas = Demanda::whereIn('status', ['concluída', 'concluida'])->count();
        $total = Demanda::count();

        // Últimas demandas (com cliente e filial já carregados)
       $ultimasDemandas = Demanda::with(['cliente', 'filial'])
            ->whereIn(DB::raw('LOWER(status)'), ['aberta', 'em andamento', 'andamento'])
            ->orderByRaw("CASE 
                WHEN LOWER(status) = 'aberta' THEN 0 
                WHEN LOWER(status) IN ('em andamento', 'andamento') THEN 1 
                ELSE 2 
            END")
            ->orderBy('created_at', 'desc')
            ->limit(10) // Aumentei para 10 já que agora filtra apenas as ativas
            ->get();


        // Labels: nome do cliente
        $labelsUltimasDemandas = $ultimasDemandas->map(function ($demanda) {
            return $demanda->cliente->nome_cliente ?? 'Sem Cliente';
        })->toArray();

        // Cada demanda vale 1 pra contagem
        $valoresUltimasDemandas = array_fill(0, count($ultimasDemandas), 1);

        return view('relatorios.graficos', compact(
            'abertas',
            'andamento',
            'concluidas',
            'total',
            'ultimasDemandas',
            'labelsUltimasDemandas',
            'valoresUltimasDemandas'
        ));

        $dadosDemandas = DB::table('demandas')
            ->select(DB::raw('DATE(created_at) as data'), DB::raw('COUNT(*) as total'))
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        $labelsUltimasDemandas = $dadosDemandas->pluck('data');
        $valoresUltimasDemandas = $dadosDemandas->pluck('total');

        return view('graficos.blade', compact('labelsUltimasDemandas', 'valoresUltimasDemandas'));
    }


}