<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Filial;
use App\Models\Demanda;
use App\Models\Relatorio;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RelatoriosExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class RelatorioController extends Controller
{
    public function create(Request $request)
    {
        $clientes = Cliente::all();
        $filiais = Filial::all();

        $relatorios = Demanda::with(['cliente', 'filial'])
            ->when($request->cliente_id, fn($query) => $query->where('cliente_id', $request->cliente_id))
            ->when($request->filial_id, fn($query) => $query->where('filial_id', $request->filial_id))
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->when($request->data_inicio, fn($query) => $query->whereDate('created_at', '>=', $request->data_inicio))
            ->when($request->data_fim, fn($query) => $query->whereDate('created_at', '<=', $request->data_fim))
            ->orderBy('created_at', 'desc')
            ->paginate(13);

        return view('relatorios.create', compact('clientes', 'filiais', 'relatorios'));
    }



    //EXPORTAR PARA PDF
    
    public function exportarPdf(Request $request)
{
    $relatorios = Demanda::with(['cliente', 'filial'])
        ->when($request->cliente_id, fn($q) => $q->where('cliente_id', $request->cliente_id))
        ->when($request->filial_id, fn($q) => $q->where('filial_id', $request->filial_id))
        ->when($request->data_inicio, fn($q) => $q->whereDate('created_at', '>=', $request->data_inicio))
        ->when($request->data_fim, fn($q) => $q->whereDate('created_at', '<=', $request->data_fim))
        ->get();

         $totalDemandas = $relatorios->count();
         $dataGeracao = Carbon::now()->format('d/m/Y \a\s H:i');

    $pdf = Pdf::loadView('relatorios.pdf', compact('relatorios', 'totalDemandas', 'dataGeracao'));
    return $pdf->stream('relatorio_demandas.pdf');

    
}
public function visualizarPdf(Request $request)
{
    $url = route('relatorios.exportar.pdf', $request->query());
    return view('layouts.visualizar_pdf', compact('url'));
}


    //EXPORTAR PARA EXEL

    public function exportarExcel(Request $request)
    {
        $demandas = $this->filtrarDemandas($request); 
        return Excel::download(new RelatoriosExport($demandas), 'relatorios.xlsx');
    }

    //FILTRAR DEMANDAS

    private function filtrarDemandas(Request $request)
    {
        $query = Demanda::with(['cliente', 'filial', 'atendente',]);

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('filial_id')) {
            $query->where('filial_id', $request->filial_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function index()
{
    return view('relatorios.analitico'); 
}


}
