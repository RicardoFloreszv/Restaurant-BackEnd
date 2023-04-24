<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Los request nos permiten tener validaciones mas avanzadas para los Forms.



    public function register(RegistroRequest $request) {
        
    //Validar el registro  (Recibir la informacion del formulario de registro y se almacena en data)
        $data = $request->validated();

     //Si pasa la validacion ahora crearemos el usuario

        //Acceder al model de User y asignar informacion.
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        //Retornar una respuesta  (un token y la informacion del usuario.)
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function login(LoginRequest $request) {
        
    //Validar el registro  (Recibir la informacion del formulario de login)
        $data = $request->validated();

    //Revisar Password
        //Esto lo utilizamos cuando el usuario quiere iniciar sesion y su correo o su password son incorrectos. Debemos de retornar un mensaje y darle el error 422 para que caiga en el catch error
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['El email o el password son incorrectos']
            ], 422);                                                                   //Debemos darle el codigo de error 422 ya que el defoult es 200 (200 es que esta todo bien) y de esta manera ahora si al intentar iniciar sesion con una cuenta o un passsword NO valido cae en el "catch error" y se muestra el error.
        }

    //Autenticar el usuario (Cuando el usuario Inicia sesion con su correo y password correctas.)
        
        $user = Auth::user();           //Trae la informacion del usuario

        //Retornar una respuesta  (un token y la informacion del usuario.)
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request) {
        
        //Nos traemos la informacion del usuario que esta haciendo la peticion
        $user = $request->user();

        //Eliminamos el token cuando el usuario haga un logout
        $user->currentAccessToken()->delete();

        return [
            'user' => null
        ];
    }
}
