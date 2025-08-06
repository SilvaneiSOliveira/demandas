<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anexo;
use Illuminate\Support\Facades\Storage;

class AnexoController extends Controller
{

    public function salvar(Request $request, $id)
    {
        $request->validate([
            'anexo' => 'required|file|max:10240', // 10MB
        ]);

        if ($request->hasFile('anexo')) {
            $arquivo = $request->file('anexo');
            $nomeArquivo = time().'_'.$arquivo->getClientOriginalName();
            $caminho = $arquivo->storeAs('anexos', $nomeArquivo, 'public');

            Anexo::create([
                'demanda_id'   => $id,
                'nome_arquivo' => $arquivo,
                'caminho'      => $caminho,
            ]);

            return redirect()->back()->with('success', 'Arquivo anexado com sucesso!');
        }

        return redirect()->back()->with('error', 'Nenhum arquivo foi enviado.');
    }

    public function listar($demandaId)
    {
        $anexos = Anexo::where('demanda_id', $demandaId)->get();
        return response()->json($anexos);
    }

    public function baixar($id)
    {
        $anexo = Anexo::findOrFail($id);
        return Storage::download($anexo->caminho, $anexo->nome_arquivo);
    }

    public function deletar($id)
    {
        $anexo = Anexo::findOrFail($id);
        Storage::delete($anexo->caminho);
        $anexo->delete();

        return response()->json(['mensagem' => 'Anexo excluído com sucesso!']);
    }

    public function anexar(Request $request, $id)
{
    if ($request->hasFile('anexo')) {
        $arquivo = $request->file('anexo');
        $nomeArquivo = time() . '_' . $arquivo->getClientOriginalName();
        $caminho = $arquivo->storeAs('anexos', $nomeArquivo, 'public');

        // Salva no banco (supondo que o model Anexo já esteja criado)
        Anexo::create([
            'demanda_id' => $id,
            'nome_arquivo' => $arquivo->getClientOriginalName(),
            'caminho' => $caminho,
        ]);

        return redirect()->back()->with('success', 'Arquivo anexado com sucesso!');
    }

    return redirect()->back()->with('error', 'Nenhum arquivo foi enviado.');
}

}
