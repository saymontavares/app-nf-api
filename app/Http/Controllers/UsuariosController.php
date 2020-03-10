<?php

namespace App\Http\Controllers;

use App\Usuarios;

use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAllUsuarios()
    {
        return response()->json(Usuarios::all());
    }

    public function setNewUser(Request $request)
    {
        $usuario = new Usuarios;
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->status = "A";
        $usuario->verificado = 0;
        $usuario->save();

        return response()->json($usuario);
    }

    public function updateUser(Request $request, $id)
    {
        $usuario = Usuarios::find($id);
        $usuario->nome = $request->nome;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        
        return response()->json($usuario);

    }
}
