<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\Cliente; 
use Illuminate\Http\Request;

class FilialController extends Controller
{
    public function create()
    {
        $clientes = Cliente::all();
        return view('filiais.create', compact('clientes'));
    }

    public function store(Request $request)
{
    // Validação opcional
    $request->validate([
        'nome' => 'required|string|max:255',
        'razao_social' => 'nullable|string|max:255',
        'cnpj' => 'nullable|string|max:225',
        'endereco' => 'required|string|max:225',
        'cidade' => 'required|string|max:225',
        'estado' => 'required|string|max:2',
        'bairro' => 'required|string|max:225'
    ]);

    // Cria a filial
    Filial::create($request->all());

    // Redireciona com mensagem de sucesso
    return redirect()->route('filiais.index')->with('success', 'Filial cadastrada com sucesso!');
}


    public function index(Request $request)
{
    $query = Filial::with('cliente');

    if ($request->filled('filtro')) {
        $filtro = $request->input('filtro');
        $query->where('nome', 'like', "%$filtro%")
              ->orWhere('cidade', 'like', "%$filtro%");
    }

    $filiais = $query->paginate(12); // 👈 Aqui define a paginação

    return view('filiais.index', compact('filiais'));
}


    public function edit($id)
    {
        $filial = Filial::findOrFail($id);
        $clientes = Cliente::all();

        return view('filiais.edit', compact('filial', 'clientes'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'razao_social' => 'required|string|max:255',
        'cnpj' => 'required|string|max:225',
        'endereco' => 'required|string|max:225',
        'cidade' => 'required|string|max:225',
        'estado' => 'required|string|max:2',
        'bairro' => 'required|string|max:225'
    ]);

    $filial = Filial::findOrFail($id);
    $filial->update($request->all());

    return redirect()->route('filiais.index')->with('success', 'Filial atualizada com sucesso!');
}

}
