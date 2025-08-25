<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\Cliente;
use App\Models\ContatoFilial; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Uf;


class FilialController extends Controller
{
    // Listar filiais com paginação
    public function index(Request $request)
{
    $query = Filial::with('cliente');

    if ($request->filled('filtro')) {
        $filtro = $request->input('filtro');
        $query->where('nome', 'like', "%$filtro%")
              ->orWhere('cidade', 'like', "%$filtro%")
               ->orWhereHas('cliente', function ($q) use ($filtro) {
              $q->where('nome_cliente', 'like', "%$filtro%");
          });
    }

    $filiais = $query->orderBy('nome', 'asc')->paginate(13); // Aqui define a paginação

    return view('filiais.index', compact('filiais'));
}

 // Mostrar formulário de criação
public function create()
{
    
    $clientes = Cliente::orderBy('nome_cliente')->get(); 
    $ufs = Uf::orderBy('uf')->get(); 
    return view('filiais.create', compact('clientes', 'ufs')); 
}
    
   // Salvar nova Filial
    public function store(Request $request)
{
    try {
         $validated = $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'nome' => 'required|string|max:255',
        'razao_social' => 'nullable|string|max:255',
        'cnpj' => 'nullable|string|max:225',
        'endereco' => 'required|string|max:225',
        'cidade' => 'required|string|max:225',
        'estado' => 'required|string|max:2',
        'bairro' => 'required|string|max:225',
        'produto' => 'nullable|array',
        'produto.*' => 'string|max:255',
        'contatos_filial' => 'nullable|array',
        'contatos_filial.*.nome' => 'required_with:contatos_filial|string|max:255',
        'contatos_filial.*.cargo' => 'nullable|string|max:255',
        'contatos_filial.*.telefone' => 'nullable|string|max:20',
        'contatos_filial.*.email' => 'nullable|email|max:255',
        'tipo_suporte' => 'nullable|array',
        'tipo_suporte.*' => 'string|max:255',
    ]);

    // Cria a Filial
    $filial = Filial::create([
        'cliente_id' => $validated['cliente_id'],
        'nome' => $validated['nome'],
        'razao_social' => $validated['razao_social'],
        'cnpj' => $validated['cnpj'],
        'endereco' => $validated['endereco'],
        'cidade' => $validated['cidade'],
        'estado' => $validated['estado'],
        'bairro' => $validated['bairro'],
        'produto' => !empty($validated['produto']) ? json_encode($validated['produto']) : null,
        'tipo_suporte' => !empty($validated['tipo_suporte']) ? json_encode($validated['tipo_suporte']) : null,
        'ativo' => true, // sempre ativo no cadastro

    ]);

     // Salva os contatos
            if (!empty($validated['contatos_filial'])) {
                foreach ($validated['contatos_filial'] as $contatoData) {
                    $filial->contatos_filial()->create([
                        'nome' => $contatoData['nome'],
                        'cargo' => $contatoData['cargo'] ?? null,
                        'telefone' => $contatoData['telefone'] ?? null,
                        'email' => $contatoData['email'] ?? null,
                    ]);
                }
            }
                return redirect()->route('filiais.index')->with('success', 'Filial cadastrado com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar filial: ' . $e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }

    // Mostrar dados de uma filial específico
    public function show($id)
    {
        $filial = Filial::with('contatos_filial')->findOrFail($id);
        return view('filiais.show', compact('filial'));
    }
    
    // Mostrar formulário de edição
public function edit($id)
{
    $filial = Filial::findOrFail($id);
    $contatos_filial = ContatoFilial::where('filial_id', $id)->get();
    $cliente = $filial->cliente;
    $ufs = Uf::orderBy('uf')->get();
    
    return view('filiais.edit', compact('filial', 'contatos_filial', 'cliente', 'ufs'));
}

   // Atualizar Filial
   public function update(Request $request, $id)
{
    
    try {
        $filial = Filial::findOrFail($id);

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:225',
            'endereco' => 'required|string|max:225',
            'cidade' => 'required|string|max:225',
            'estado' => 'required|string|max:2',
            'bairro' => 'required|string|max:225',
            'produto' => 'nullable|array',
            'produto.*' => 'string|max:255',
            'contatos_filial' => 'nullable|array',
            'contatos_filial.*.nome' => 'required_with:contatos_filial|string|max:255',
            'contatos_filial.*.cargo' => 'nullable|string|max:255',
            'contatos_filial.*.telefone' => 'nullable|string|max:20',
            'contatos_filial.*.email' => 'nullable|email|max:255',
            'tipo_suporte' => 'nullable|array',
            'tipo_suporte.*' => 'string|max:255',
            'ativo' => 'required|boolean', // 👈 valida status
            
        ]);
        
        // Atualiza os dados da filial
        $filial->update([
            'cliente_id' => $validated['cliente_id'],
            'nome' => $validated['nome'],
            'razao_social' => $validated['razao_social'],
            'cnpj' => $validated['cnpj'],
            'endereco' => $validated['endereco'],
            'cidade' => $validated['cidade'],
            'estado' => $validated['estado'],
            'bairro' => $validated['bairro'],
            'produto' => isset($validated['produto']) ? json_encode($validated['produto']) : null,
            'tipo_suporte' => isset($validated['tipo_suporte']) ? json_encode($validated['tipo_suporte']) : null,
            'ativo' => $validated['ativo'], 
        ]);

       return redirect()->route('filiais.index')->with('success', 'Filial atualizada com sucesso!');

    } catch (\Exception $e) {
        \Log::error('Erro ao atualizar filial: '.$e->getMessage());
        return back()->withErrors('Erro ao atualizar filial. Tente novamente.');
    }
}


    // Deletar Filial
    public function destroy($id)
    {
        try {
            $filial = Filial::findOrFail($id);
            $filial->contatos_filial()->delete(); // Remove os contatos primeiro
            $filial->delete();

            return redirect()->route('filiais.index')->with('success', 'Filial e contatos removidos com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao deletar filial: ' . $e->getMessage());
            return back()->withErrors('Não foi possível deletar a filial. Verifique se há relacionamentos dependentes.');
        }
    }
}