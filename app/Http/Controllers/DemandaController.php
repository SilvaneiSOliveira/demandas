<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demanda;
use App\Models\Cliente;
use App\Models\Filial;
use App\Events\DemandaAtualizada;

class DemandaController extends Controller
{
    // Formulário de cadastro
    public function create()
    {
        $clientes = Cliente::all(); 
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
        ]);

        Demanda::create($request->all());


        return redirect()->route('demandas.index')->with('success', 'Demanda cadastrada com sucesso!');
    }

    // PAGINÇÃO
    public function index(Request $request)
    {
        $query = Demanda::with(['cliente', 'filial']);

        if ($request->filled('filtro')) {
            $filtro = $request->input('filtro');
            $query->where('titulo', 'like', "%$filtro%")
                  ->orWhere('solicitante', 'like', "%$filtro%");
        }

        $demandas = $query->orderBy('created_at', 'desc')->paginate(10);

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

    // Recarrega a demanda com os relacionamentos que você quer enviar no broadcast
    $demanda->load(['cliente', 'filial']);

    // Dispara o evento pro Pusher
    event(new DemandaAtualizada($demanda));

    return redirect()->back()->with('success', 'Demanda atualizada com sucesso!');
}


}

