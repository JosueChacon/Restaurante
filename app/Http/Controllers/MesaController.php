<?php

namespace App\Http\Controllers;

use App\Mesa;
use App\Reserva;
use App\Traits\util;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    use util;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mesas = Mesa::where('estado', '=', '1')
            ->orderBy('nromesa', 'DESC')
            ->get();
            // ->paginate(5);
        return view('trabajador.abastecimiento.mesas.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('trabajador.abastecimiento.mesas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $mesa = new Mesa();
        $mesa->nromesa = $request->nromesa;
        $mesa->estado = 1;
        $mesa->save();
        return redirect()->route('mesas.index')->with('good', 'Mesa Registrada');
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
        $mesa = Mesa::findorfail($id);
        return view('trabajador.abastecimiento.mesas.show', compact('mesa'));
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
        $mesa = Mesa::findorfail($id);
        return view('trabajador.abastecimiento.mesas.edit', compact('mesa'));
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
        $mesa = Mesa::findorfail($id);
        $mesa->nromesa = $request->nromesa;
        $mesa->save();
        return redirect()->route('mesas.index')->with('good', 'Registro Actualizado');
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
        $mesa = Mesa::findorfail($id);
        $mesa->estado = 0;
        $mesa->save();
        return redirect()->route('mesas.index')->with('good', 'Registro Eliminado');
    }

    public function liberarMesa($mesa_id)
    {
        $mesa = Mesa::findorfail($mesa_id);
        $now = date('Y-m-d');
        $reserva = Reserva::whereRaw('date(fecha)=' . "'$now'")
            ->where('mesa_id', '=', $mesa_id)
            ->where('estado', '=', 'OCUPADA')
            ->first();

        if ($reserva == null) {
            return redirect()->route('home')->with('error', 'No puede liberar, la MESA ' . $mesa->nromesa . ' ya está LIBRE');
        }
        return view('trabajador.ventas.local.mesas.liberarMesa', compact('mesa', 'reserva'));
    }

    public function liberar($reserva_id)
    {
        $reserva = Reserva::findorfail($reserva_id);
        $reserva->estado = "LIBRE";
        $reserva->save();
        $mesa = Mesa::findorfail($reserva->mesa_id);
        return redirect()->route('home')->with('good', 'La MESA ' . $mesa->nromesa . ' ha sido liberada');
    }
}
