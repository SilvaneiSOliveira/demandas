<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    // Listar clientes com paginação
    public function index(Request $request)
{
    $query = Cliente::query();

    if ($request->filled('filtro')) {
        $filtro = $request->input('filtro');
        $query->where('nome', 'like', "%$filtro%")
              ->orWhere('email', 'like', "%$filtro%");
    }

    $clientes = $query->paginate(10); // Aqui é a paginação

    return view('clientes.index', compact('clientes'));
}

    // Mostrar formulário de criação
    public function create()
    {
        return view('clientes.create');
    }

    // Salvar novo cliente
   
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'nome_cliente' => 'required|string|max:255|unique:clientes,nome_cliente',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:clientes,cnpj',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'produto' => 'nullable|array',
            'contato_nome' => 'nullable|array',
            'contato_cargo' => 'nullable|array',
            'contato_telefone' => 'nullable|array',
        ]);

        // Convertendo arrays em string separada por vírgula
        $validated['produto'] = $request->has('produto') ? implode(',', $request->produto) : null;
        $validated['contato_nome'] = $request->has('contato_nome') ? implode(',', $request->contato_nome) : null;
        $validated['contato_cargo'] = $request->has('contato_cargo') ? implode(',', $request->contato_cargo) : null;
        $validated['contato_telefone'] = $request->has('contato_telefone') ? implode(',', $request->contato_telefone) : null;

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso !');
    } catch (\Exception $e) {
        Log::error('Erro ao cadastrar cliente: ' . $e->getMessage());
        return back()->withErrors($e->getMessage());

    }
}

    // Mostrar dados de um cliente específico
    public function show($id)
{
    $cliente = Cliente::findOrFail($id);
    return view('clientes.show', compact('cliente'));
}


    // Mostrar formulário de edição
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    // Atualizar cliente
   public function update(Request $request, $id)
{
    try {
        $cliente = Cliente::findOrFail($id);

        $validated = $request->validate([
            'nome_cliente' => 'required|string|max:255|unique:clientes,nome_cliente,' . $cliente->id,
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:20|unique:clientes,cnpj,' . $cliente->id,
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:2',
            'produto' => 'nullable|array',
            'contato_nome' => 'nullable|array',
            'contato_cargo' => 'nullable|array',
            'contato_telefone' => 'nullable|array',
        ]);

        $validated['produto'] = $request->has('produto') ? implode(',', $request->produto) : null;
        $validated['contato_nome'] = $request->has('contato_nome') ? implode(',', $request->contato_nome) : null;
        $validated['contato_cargo'] = $request->has('contato_cargo') ? implode(',', $request->contato_cargo) : null;
        $validated['contato_telefone'] = $request->has('contato_telefone') ? implode(',', $request->contato_telefone) : null;

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso, véi!');
    } catch (\Exception $e) {
        Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
        return back()->withErrors('Eita! Não conseguimos atualizar. Tente mais tarde.');
    }
}

    // Deletar cliente
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();

            return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso, viu?');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cliente: ' . $e->getMessage());
            return back()->withErrors('Num deu pra deletar o cliente. Verifique se ele tá ligado a alguma demanda.');
        }
    }
}
