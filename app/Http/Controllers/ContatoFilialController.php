<?php

namespace App\Http\Controllers;

use App\Models\ContatoFilial;
use App\Models\Filial;
use Illuminate\Http\Request;

class ContatoFilialController extends Controller
{
    public function store(Request $request)
    {
        // Se estiver salvando contato
        if ($request->has('nome') && !$request->has('cnpj')) {
            $validated = $request->validate([
                'filial_id' => 'required|exists:filiais,id', // Corrigido para usar 'filiais'
                'nome' => 'required|string|max:255',
                'cargo' => 'nullable|string|max:255',
                'telefone' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
            ]);

            ContatoFilial::create($validated);
            return redirect()->back()->with('success', 'Contato adicionado com sucesso!');
        }

        // Se estiver salvando filial
        $validated = $request->validate([
            'filial_id' => 'required|exists:filiais,id', // Corrigido para usar 'filiais'
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'tipo_suporte' => 'nullable|array',
            'produto' => 'nullable|array',
        ]);

        $filial = Filial::findOrFail($validated['filial_id']);
        
        // Remove filial_id do array de dados para update
        unset($validated['filial_id']);
        
        $filial->update($validated);

        return redirect()->back()->with('success', 'Filial atualizada com sucesso!');
    }

    public function edit(ContatoFilial $contato)
    {
        return response()->json([
            'id' => $contato->id,
            'nome' => $contato->nome,
            'cargo' => $contato->cargo,
            'telefone' => $contato->telefone,
            'email' => $contato->email,
        ]);
    }

    public function update(Request $request, ContatoFilial $contato)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $contato->update($validated);

        return redirect()->back()->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(ContatoFilial $contato)
    {
        $contato->delete();

        return redirect()->back()->with('success', 'Contato excluído com sucesso!');
    }
}