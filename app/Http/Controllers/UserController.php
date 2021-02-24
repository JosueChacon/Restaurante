<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Persona;
use App\Cliente;

class UserController extends Controller
{
    //    
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function mostrarLogin()
    {
        return view('index');
    }

    public function verificarDatos(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $userEstado = User::where('name', '=', $request->name)->first();
        if ($userEstado != null){
            if ($userEstado->estado == 0) {
            return back()
                ->withErrors(['name' => 'Usuario no válido'])
                ->withInput(request(['name']));
            }
        }       

        if (Auth::attempt($data)) {
            $con = 'OK';
        }

        $name = $request->get('name');
        $query = User::where('name', '=', $name)->where('estado', '=', '1')->get();
        if ($query->count() != 0) {
            $hashp = $query[0]->password;
            $password = $request->get('password');
            if (password_verify($password, $hashp)) {
                return redirect()->route('home');
            } else {
                return back()
                    ->withErrors(['password' => 'Contraseña no válida'])
                    ->withInput(request(['name']));
            }
        } else {
            return back()
                ->withErrors(['name' => 'Usuario no válido'])
                ->withInput(request(['name']));
        }
    }

    public function mostrarFrmRegistro()
    {
        return view('registro');
    }

    public function Registro(Request $request)
    {
        $data = request()->validate(
            [
                'name' => ['unique:users'],
                'password' => ['min:8', 'confirmed'],
            ],
            [
                'name.unique' => 'El usuario ingresado no está disponible',
                'password.min' => 'Debe ingresar por lo menos 8 caracteres'
            ]
        );

        $persona = new Persona();
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->direccion = $request->direccion;
        $persona->celular = $request->celular;
        $persona->estado = '1';

        if ($persona->save()) {
            $idpersona = $persona->idpersona;
            $cliente = new Cliente();
            $cliente->idpersona = $idpersona;
            $cliente->estado = '1';
            $cliente->save();

            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->idtipousuario = 2; //2: CLIENTE
            $user->idpersona = $idpersona;
            $user->save();
        }

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
