<?php

namespace App\Http\Controllers;
use App\Models\Computador;
use App\Models\Cliente;
use App\Models\Filial;
use Illuminate\Http\Request;


class ComputadorController extends Controller
{
public function index(Request $request)
{
    $query = Computador::with(['cliente', 'filial']);

    if ($request->filled('tag')) {
        $query->where('tag', 'like', '%' . $request->tag . '%');
    }

   if ($request->filled('cliente')) {
        $query->whereHas('cliente', function($q) use ($request) {
            $q->where('nome_cliente', 'like', '%' . $request->cliente . '%');
        });
    }

    if ($request->filled('filial')) {
        $query->whereHas('filial', function($q) use ($request) {
            $q->where('nome', 'like', '%' . $request->filial . '%');
        });
    }

    $computadores = $query->get();
    
    // Carregar clientes e filiais com namespace completo
    $clientes = \App\Models\Cliente::orderBy('nome_cliente')->get();
    $filiais = \App\Models\Filial::orderBy('nome')->get();

    return view('tombamentos.computadores', compact('computadores', 'clientes', 'filiais'));
}
   
    public function create()
    {
       $clientes = Cliente::all();
       

       return view('tombamentos.computadores_create', compact('clientes',));

    }

  
        public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'nullable|exists:filiais,id',
            'tag' => 'required|unique:computadores,tag',
            'local' => 'required|string',
            'processador' => 'required|string',
            'memoria_ram' => 'required|string',
            'armazenamento' => 'required|string',
            'sistema_operacional' => 'required|string',
            'observacao' => 'nullable|string',
        ]);

       // Cria o computador
        Computador::create([
            'cliente_id' => $request->cliente_id,
            'filial_id' => $request->filial_id,
            'tag' => $request->tag,
            'local' => $request->local,
            'processador' => $request->processador,
            'memoria_ram' => $request->memoria_ram,
            'armazenamento' => $request->armazenamento,
            'sistema_operacional' => $request->sistema_operacional,
            'observacao' => $request->observacao,
    ]);

         return redirect()->route('tombamentos.computadores.index')
            ->with('success', 'Computador cadastrado com sucesso!');
    }

    

   
    public function show($id)
{
    try {
        $computador = Computador::with(['cliente', 'filial'])->findOrFail($id);
        
        return response()->json([
            'id' => $computador->id,
            'cliente_id' => $computador->cliente_id,
            'filial_id' => $computador->filial_id,
            'tag' => $computador->tag,
            'local' => $computador->local,
            'processador' => $computador->processador,
            'memoria_ram' => $computador->memoria_ram,
            'armazenamento' => $computador->armazenamento,
            'sistema_operacional' => $computador->sistema_operacional,
            'observacao' => $computador->observacao,
            'usuario_alteracao' =>$computador->usuario_alteracao,
            'ultima_alteracao' =>$computador->ultima_alteracao,
            'cliente' => $computador->cliente,
            'filial' => $computador->filial,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Computador não encontrado'], 404);
    }
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

   
    public function update(Request $request, $id)
{
    try {
        // Validação dos dados
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'filial_id' => 'nullable|exists:filiais,id',
            'tag' => 'required|string|max:50',
            'local' => 'required|string|max:100',
            'processador' => 'required|string|max:100',
            'memoria_ram' => 'required|string|max:50',
            'armazenamento' => 'required|string|max:50',
            'sistema_operacional' => 'required|string|max:50',
            'observacao' => 'nullable|string|max:500',
        ]);

        // Buscar o computador
        $computador = Computador::findOrFail($id);
        
        // Atualizar os dados
       $computador->update(array_merge($validatedData, [
            'ultima_alteracao' => now(),
            'usuario_alteracao' => auth()->user()->name, 
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Computador atualizado com sucesso!',
            'data' => $computador->load(['cliente', 'filial'])
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Dados inválidos',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro interno do servidor: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getFiliais($clienteId)
{
    try {
        $filiais = Filial::where('cliente_id', $clienteId)->get(['id', 'nome']);
        return response()->json($filiais);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erro ao carregar filiais'], 500);
    }
}
}
