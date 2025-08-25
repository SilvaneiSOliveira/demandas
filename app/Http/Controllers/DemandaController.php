<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use App\Models\Cliente;
use App\Models\Filial;
use App\Events\DemandaAtualizada;
use App\Models\Anexo;
use App\Models\Atendente;

class DemandaController extends Controller
{
    // Formulário de cadastro
    public function create()
    {
        $clientes = Cliente::orderBy('nome_cliente', 'asc')->get();

        return view('demandas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'nullable|exists:filiais,id',
            'titulo' => 'required|string',
            'descricao' => 'nullable|string',
            'nivel' => 'required|string',
            'classificacao' => 'required|string',
            'data_agendamento' => 'nullable|date',
            'horario_agendamento' => 'nullable|string',
            'tecnico_responsavel' => 'nullable|string',
            'status' => 'required|string|in:Aberta,Em andamento,Concluida',
            'usuario_id' => 'nullable|integer',
            'solicitante' => 'nullable|string',
            'atendente' => 'required|string',
            'resolucao' => 'nullable|string',
        ]);

        Demanda::create($request->all());


        return redirect()->route('demandas.index')->with('success', 'Demanda cadastrada com sucesso!');
    }

    // FILTRO //
    public function index(Request $request)
    {
    $query = Demanda::with(['cliente', 'filial']);

    // Filtro de texto
    if ($request->filled('filtro')) {
        $filtro = $request->input('filtro');

        $query->where(function ($q) use ($filtro) {
            $q->where('titulo', 'like', "%$filtro%")
              ->orWhere('solicitante', 'like', "%$filtro%")
              ->orWhere('status', 'like', "%$filtro%")
              ->orWhereHas('cliente', function ($qCliente) use ($filtro) {
                  $qCliente->where('nome_cliente', 'like', "%$filtro%");
              });
        });
    }

    // Filtros pelos campos do cliente
    if ($request->filled('tipo_suporte')) {
        $query->whereHas('cliente', function($q) use ($request) {
            $q->where('tipo_suporte', 'like', '%' . $request->tipo_suporte . '%');
        });
    }
    
    if ($request->filled('produto')) {
        $query->whereHas('cliente', function($q) use ($request) {
            $q->where('produto', 'like', '%' . $request->produto . '%');
        });
    }

    // Filtro de data agendamento específica
    if ($request->filled('data_agendamento')) {
        $query->whereDate('data_agendamento', $request->input('data_agendamento'));
    }

     // Filtro atendente
    if ($request->filled('atendente')) {
    $query->where('atendente', $request->input('atendente'));
    }

    // Filtro de nível
    if ($request->filled('nivel')) {
    $query->where('nivel', $request->input('nivel'));
    }

    // Filtro de filial
    if ($request->filled('filial')) {
        $query->where('filial_id', $request->input('filial'));
    }

    // Filtro de período
    if ($request->filled('periodo_inicio') && $request->filled('periodo_fim')) {
        $query->whereBetween('data_agendamento', [
            $request->input('periodo_inicio'),
            $request->input('periodo_fim')
        ]);
    } elseif ($request->filled('periodo_inicio')) {
        $query->whereDate('data_agendamento', '>=', $request->input('periodo_inicio'));
    } elseif ($request->filled('periodo_fim')) {
        $query->whereDate('data_agendamento', '<=', $request->input('periodo_fim'));
    }

    // Ordenação
    $demandas = $query
        ->orderByRaw("FIELD(status, 'Em andamento', 'Aberta') DESC")
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $demandas->appends($request->query());

    // Carregar filiais
    $filiais = \App\Models\Filial::orderBy('nome')->get();
    $atendentes = \App\Models\Demanda::select('atendente')// Seguimento do filtro atendente
    ->whereNotNull('atendente')
    ->where('atendente', '!=', '')
    ->distinct()
    ->orderBy('atendente')
    ->pluck('atendente');

    return view('demandas.index', compact('demandas', 'filiais', 'atendentes'));
    }



    public function show($id)
    {
        $demanda = Demanda::with(['cliente.filial'])->findOrFail($id);
        return view('demandas.show', compact('demanda'));
    }

    public function edit($id)
    {
        $demanda = Demanda::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        $filiais = Filial::orderBy('nome')->get();

        return view('demandas.edit', compact('demanda', 'clientes', 'filiais'));
    }

    public function atualizarStatus(Request $request, $id)
    {
    $demanda = Demanda::findOrFail($id);

    $validated = $request->validate([
       'status' => 'required|string',
        'resolucao' => 'nullable|string',
        'nivel' => 'nullable|string',
        'titulo' => 'nullable|string', 
        'classificacao' => 'nullable|string',
        'descricao' => 'nullable|string',
        'data_agendamento' => 'nullable|date',
        'solicitante' => 'nullable|string',
        'atendente' => 'nullable|string',
    ]);

    $dadosParaAtualizar = array_filter($validated, function($value) {
        return $value !== null && $value !== '';
    });

    $demanda->update($dadosParaAtualizar);

    $demanda->load(['cliente', 'filial']);

    // Dispara o evento pro Pusher
    event(new DemandaAtualizada($demanda));

    return redirect()->route('demandas.index')->with('success', 'Demanda Atualizada com sucesso!');
    }



    public function salvarAnexo(Request $request)
    {
    // SALVAR ANEXO Validação básica
    $request->validate([
        'arquivo' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
        'demanda_id' => 'required|exists:demanda,id'
    ]);

    if ($request->hasFile('arquivo')) {
        
        $arquivo = $request->file('arquivo');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $arquivo->storeAs('public/anexos', $nomeArquivo);

        Anexo::create([
            'demanda_id'   => $request->input('demanda_id'),
            'nome_arquivo' => $arquivo->getClientOriginalName(),
            'caminho'      => 'storage/anexos/' . $nomeArquivo, 
        ]);


        return response()->json(['mensagem' => 'Anexo salvo com sucesso!']);
    }

    return response()->json(['erro' => 'Nenhum arquivo foi enviado.'], 400);
    }

}

