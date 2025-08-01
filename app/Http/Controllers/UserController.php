<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Listar usuários
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    // Exibir formulário de criação
    public function create()
    {
        return view('user.create');
    }

    // Armazenar novo usuário
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'tipo' => 'required|string',
        'ativo' => 'required|boolean',
    ]);
        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'is_admin' => $request->tipo === 'admin' ? true : false,
        'ativo' => $request->ativo,
    ]);

    return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
}

    // Exibir formulário de edição
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.create', compact('user'));
    }

    // Atualizar usuário
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'tipo' => 'required',
            'ativo' => 'required|boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->tipo === 'admin' ? true : false;
        $user->ativo = $request->ativo;

        // Só atualiza a senha se for informada
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:6'
            ]);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    // Excluir usuário
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}
