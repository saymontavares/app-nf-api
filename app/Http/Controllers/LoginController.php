<?php

namespace App\Http\Controllers;

use App\Usuarios;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
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

    public function Login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (!$token = $this->jwt->claims(['email' => $request->email])->attempt($request->only('email', 'password'))) {
            return response()->json([
                    'user' => ['Usuário não encontrado.']
                ]
            , 401);
        }

        return response()->json(compact('token'));
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
        $usuario->password = Hash::make($request->password);
        $usuario->status = "A";
        $usuario->verificado = 0;
        $usuario->save();

        return response()->json($usuario);
    }
}
