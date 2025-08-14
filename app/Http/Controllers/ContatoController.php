<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'cliente_id' => 'required|exists:clientes,id'
        ]);

        Contato::create($request->all());

        return redirect()->route('clientes.edit', $request->cliente_id)
                        ->with('success', 'Contato adicionado com sucesso!');
    }

    public function edit(Contato $contato)
    {
        return response()->json($contato);
    }

    public function update(Request $request, Contato $contato)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cargo' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        $contato->update($request->all());

        return redirect()->route('clientes.edit', $contato->cliente_id)
                        ->with('success', 'Contato atualizado com sucesso!');
    }

    public function destroy(Contato $contato)
    {
        $clienteId = $contato->cliente_id;
        $contato->delete();

        return redirect()->route('clientes.edit', $clienteId)
            ->with('success', 'Contato excluído com sucesso!');
    }
}