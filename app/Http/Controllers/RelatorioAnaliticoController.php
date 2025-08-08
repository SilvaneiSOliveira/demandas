<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use App\Models\Cliente;
use App\Models\Atendente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatorioAnaliticoController extends Controller
{
    public function index()
    {
        // Demandas por mês (últimos 6 meses)
        $meses = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i)->format('M/Y');
        })->reverse()->values();

        $demandasPorMes = $meses->map(function ($mes) {
            return Demanda::whereMonth('created_at', Carbon::createFromFormat('M/Y', $mes)->month)
                          ->whereYear('created_at', Carbon::createFromFormat('M/Y', $mes)->year)
                          ->count();
        });

        // Top 5 clientes com mais demandas
        $topClientes = Demanda::with('cliente')
            ->select('cliente_id', DB::raw('count(*) as total'))
            ->groupBy('cliente_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $nomesClientes = $topClientes->pluck('cliente.nome_cliente');
        $qtdClientes = $topClientes->pluck('total');

        
        // Quantidade por nível (N1 a N4)
        $niveis = ['0','1', '2', '3', '4'];
        $qtdPorNivel = collect($niveis)->map(function ($nivel) {
            return Demanda::where('nivel', $nivel)->count();
        });

        // Atendimentos presenciais x remotos
        $qtdPresenciais = Demanda::where('classificacao', 'presencial')->count();
        $qtdRemotos = Demanda::where('classificacao', 'remoto')->count();

        // Técnicos com mais atendimentos (top 5)
        $topAtendentes = Demanda::select('atendente', DB::raw('count(*) as total'))
                        ->groupBy('atendente')
                        ->orderByDesc('total')
                        ->take(5)
                        ->with('atendente') 
                        ->get();

        $nomesAtendentes = $topAtendentes->pluck('atendente');
        $qtdAtendentes = $topAtendentes->pluck('total');
        
        return view('relatorios.analitico', compact(
            'meses', 'demandasPorMes',
            'nomesClientes', 'qtdClientes',
            'niveis', 'qtdPorNivel',
            'qtdPresenciais', 'qtdRemotos',
            'nomesAtendentes', 'qtdAtendentes'
        ));
    }
}

