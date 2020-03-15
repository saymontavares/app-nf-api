<?php

namespace App\Http\Controllers;

use App\Usuarios;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class UsuariosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function getAllUsuarios()
    {
        return response()->json(Usuarios::all());
    }

    public function setNewUser(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required'
        ]);

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

    public function getUserAuth(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $usuario = Auth::user();
        return response()->json($usuario);
    }
}
