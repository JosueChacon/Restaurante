<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Persona;
use Illuminate\Http\Request;

class MClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('trabajador.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $persona = new Persona();
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->direccion = $request->direccion;
        $persona->celular = $request->celular;
        $persona->estado = 1;
        $persona->dni = $request->dni;
        $persona->email = $request->email;
        $persona->save();

        $cliente = new Cliente();
        $cliente->idpersona = $persona->idpersona;
        $cliente->save();
        return redirect()->route('consultas.clientes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cliente = Cliente::findorfail($id);
        return view('trabajador.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cliente = Cliente::findorfail($id);
        $persona = $cliente->Persona;
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->direccion = $request->direccion;
        $persona->celular = $request->celular;
        $persona->estado = 1;
        $persona->dni = $request->dni;
        $persona->email = $request->email;
        $persona->save();        
        return redirect()->route('consultas.clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
