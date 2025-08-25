<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contato;
use Illuminate\Support\Facades\Log;
use App\Models\Uf;

class ClienteController extends Controller
{
    // Listar clientes com paginação
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('filtro')) {
            $filtro = $request->input('filtro');
            $query->where('nome_cliente', 'like', "%$filtro%")
                  ->orWhere('cnpj', 'like', "%$filtro%")
                  ->orWhere('razao_social', 'like', "%$filtro%");
        }

        $clientes = $query->orderBy('nome_cliente', 'asc')->paginate(10); // 👈 Aqui define a paginação
        return view('clientes.index', compact('clientes'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        $ufs = Uf::orderBy('uf')->get();
        return view('clientes.create', compact('ufs'));
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
                'estado' => 'nullable|exists:ufs,uf',
                'produto' => 'nullable|array',
                'produto.*' => 'string|max:255',
                'contatos' => 'nullable|array',
                'contatos.*.nome' => 'nullable|string|max:255',
                'contatos.*.cargo' => 'nullable|string|max:255',
                'contatos.*.telefone' => 'nullable|string|max:20',
                'contatos.*.email' => 'nullable|email|max:255',
                'tipo_suporte' => 'nullable|array',
                'tipo_suporte.*' => 'string|max:255',
            ]);
            

            // Cria o cliente
            $cliente = Cliente::create([
                'nome_cliente' => $validated['nome_cliente'],
                'razao_social' => $validated['razao_social'],
                'cnpj' => $validated['cnpj'],
                'endereco' => $validated['endereco'],
                'bairro' => $validated['bairro'],
                'cidade' => $validated['cidade'],
                'estado' => $validated['estado'],
                'produto' => !empty($validated['produto']) ? json_encode($validated['produto']) : null,
                'tipo_suporte' => !empty($validated['tipo_suporte']) ? json_encode($validated['tipo_suporte']) : null,
                'ativo' => true, // sempre ativo no cadastro
            ]);

            // Salva os contatos
            if (!empty($validated['contatos'])) {
            foreach ($validated['contatos'] as $contatoData) {
                if (!empty($contatoData['nome'])) { // 👈 Adicione esta linha
                    $cliente->contatos()->create([
                        'nome' => $contatoData['nome'],
                        'cargo' => $contatoData['cargo'] ?? null,
                        'telefone' => $contatoData['telefone'] ?? null,
                        'email' => $contatoData['email'] ?? null,
                    ]);
                }
            }
        }


            return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar cliente: ' . $e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }

    // Mostrar dados de um cliente específico
    public function show($id)
    {
        $cliente = Cliente::with('contatos')->findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    // Mostrar formulário de edição
   public function edit($id)
{
    $cliente = Cliente::findOrFail($id);
    $contatos = Contato::where('cliente_id', $id)->get();
    $ufs = Uf::orderBy('uf')->get();
    
    return view('clientes.edit', compact('cliente', 'contatos', 'ufs'));
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
            'estado' => 'nullable|exists:ufs,uf',
            'produto' => 'nullable|array',
            'produto.*' => 'string|max:255',
            'contatos' => 'nullable|array',
            'contatos.*.nome' => 'nullable|string|max:255',
            'contatos.*.cargo' => 'nullable|string|max:255',
            'contatos.*.telefone' => 'nullable|string|max:20',
            'contatos.*.email' => 'nullable|email|max:255',
            'tipo_suporte' => 'nullable|array',
            'tipo_suporte.*' => 'string|max:255',
            'ativo' => 'required|boolean', // 👈 valida status
        ]);

        // Atualiza o cliente
        $cliente->update([
            'nome_cliente' => $validated['nome_cliente'],
            'razao_social' => $validated['razao_social'],
            'cnpj' => $validated['cnpj'],
            'endereco' => $validated['endereco'],
            'bairro' => $validated['bairro'],
            'cidade' => $validated['cidade'],
            'estado' => $validated['estado'],
            'produto' => !empty($validated['produto']) ? json_encode($validated['produto']) : null,
            'tipo_suporte' => !empty($validated['tipo_suporte']) ? json_encode($validated['tipo_suporte']) : null,
            'ativo' => $validated['ativo'], 
        ]);

        // Atualiza os contatos (primeiro remove os existentes)
        $cliente->contatos()->delete();

        if (!empty($validated['contatos'])) {
            foreach ($validated['contatos'] as $contatoData) {
                if (!empty($contatoData['nome'])) { // 👈 Adicione esta verificação
                    $cliente->contatos()->create([
                        'nome' => $contatoData['nome'],
                        'cargo' => $contatoData['cargo'] ?? null,
                        'telefone' => $contatoData['telefone'] ?? null,
                        'email' => $contatoData['email'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    } catch (\Exception $e) {
        \Log::error('Erro ao atualizar cliente: ' . $e->getMessage());
        return back()->withErrors('Erro ao atualizar cliente. Tente novamente.');
    }
}

    // Deletar cliente
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->contatos()->delete(); // Remove os contatos primeiro
            $cliente->delete();

            return redirect()->route('clientes.index')->with('success', 'Cliente e contatos removidos com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar cliente: ' . $e->getMessage());
            return back()->withErrors('Não foi possível deletar o cliente. Verifique se há relacionamentos dependentes.');
        }
    }
}