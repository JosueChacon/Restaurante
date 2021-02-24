<?php

namespace App\Http\Controllers;

use App\Persona;
use App\Trabajador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function CrearAdmin()
    {
        $persona = new Persona();
        $persona->nombres = 'Jose';
        $persona->apellidos = 'Paredes Aguilar';
        $persona->direccion = 'Ciudad de dios';
        $persona->celular = '987654321';
        $persona->dni = '87654321';
        $persona->email = 'admin@gmail.com';
        $persona->save();        

        $user = new User();
        $user->name = 'admin123';
        $user->password = Hash::make('password');
        $user->idtipousuario = 1;
        $user->idpersona = $persona->idpersona;
        $user->save();
        
        $trabajador = new Trabajador();
        $trabajador->idpersona = $persona->idpersona;
        $trabajador->idcargo = 1;
        $trabajador->save();

        return "OK";
    }
}
