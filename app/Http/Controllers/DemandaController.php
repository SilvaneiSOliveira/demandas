<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use App\Models\Cliente;
use App\Models\Filial;
use App\Events\DemandaAtualizada;
use App\Models\Anexo;

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
            'status' => 'required|string',
            'usuario_id' => 'nullable|integer',
            'solicitante' => 'nullable|string',
            'atendente' => 'required|string',
        ]);

        Demanda::create($request->all());


        return redirect()->route('demandas.index')->with('success', 'Demanda cadastrada com sucesso!');
    }

    // FILTRO
public function index(Request $request)
{
    $query = Demanda::with(['cliente', 'filial']);

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

    // Ordenar com prioridade: Aberta > Em andamento > outros, depois created_at desc
    $demandas = $query
        ->orderByRaw("FIELD(status, 'Em andamento', 'Aberta') DESC")
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('demandas.index', compact('demandas'));
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
        'resolucao' => 'nullable|string'
    ]);

    $demanda->update([
        'status' => $validated['status'],
        'resolucao' => $validated['resolucao']
    ]);

    $demanda->load(['cliente', 'filial']);

    // Dispara o evento pro Pusher
    event(new DemandaAtualizada($demanda));

    return redirect()->back()->with('success', 'Demanda atualizada com sucesso!');
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

