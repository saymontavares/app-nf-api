<?php

namespace App\Http\Controllers;

use App\Usuarios;

use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\RecoverPass;
use App\Events\LoginEvent;

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

        // register event
        event(new LoginEvent($request->user()));

        return response()->json(compact('token'));
    }

    public function setNewUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required'
        ]);

        $usuario = new Usuarios;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->status = "A";
        $usuario->verificado = 0;
        $usuario->save();

        return response()->json($usuario);
    }

    public function recoverPass(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $usuario = Usuarios::where('email', $request->email)->first();
        if (!$usuario) {
            return response()->json([
                    'user' => ['Usuário não encontrado.']
                ]
            , 401);
        }

        // reset pass
        $newpass = Str::random(6);
        $usuario->password = Hash::make($newpass);
        $usuario->save(); // update
        $usuario->newpass = $newpass;
        
        // send email new pass
        Mail::to($usuario)->send(new RecoverPass($usuario));
    }
}
