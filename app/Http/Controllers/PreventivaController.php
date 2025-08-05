<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Filial;
use App\Models\Preventiva;

class PreventivaController extends Controller

{

    public function index()
    {
        return view('tombamentos.preventivas');
}


public function salvar(Request $request)
{
    $filiais = $request->input('filial');

    if (!$filiais || !is_array($filiais)) {
        return response()->json(['erro' => 'Nenhuma filial enviada'], 400);
    }

    foreach ($filiais as $id) {
        Preventiva::updateOrCreate(
            [
                'cliente' => $request->input('cliente'),
                'filial' => $id,
            ],
            [
                'status' => $request->input("status.$id"),
                'data' => $request->input("data.$id"),
                'observacoes' => $request->input("observacoes.$id"),
                'ultima_alteracao' => $request->input("ultima_alteracao.$id"),
                'usuario_alteracao' => auth()->user()->name,
                'data_alteracao' => now(),
            ]
        );
    }

    // Sempre retorna algo pro JS
    return response()->json([
        'success' => true,
        'mensagem' => 'Preventiva salva com sucesso!'
    ]);
}

   
    


    public function filiais($cliente)
    {
        $preventivas = Preventiva::where('cliente', $cliente)->get();
        return view('partials.tabela_preventiva', compact('preventivas'));
    }


}
