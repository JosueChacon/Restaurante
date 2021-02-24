<?php

namespace App\Http\Controllers;

use App\DNota;
use App\Nota;
use App\Producto;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $notas = Nota::where('estado', '=', '1')
            ->orderby('fecha', 'desc')->paginate(5);
        return view('administrador.notas.index', compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $productos = Producto::where('estado', '=', '1')->get();
        return view('administrador.notas.create', compact('productos'));
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
        $nota = new Nota();
        $nota->idtrabajador = auth()->user()->Persona->Trabajador->idtrabajador;
        $nota->fecha = date('Y-m-d H:i:s');
        $nota->total = $request->total;
        $nota->save();

        $idsproductos = $request->get('idsproducto');
        $cantidades = $request->get('cantidades');
        $precios = $request->get('precios');
        foreach ($idsproductos as $i => $idproducto) {
            $detalle = new DNota();
            $detalle->idnota = $nota->idnota;
            $detalle->idproducto = $idproducto;
            $detalle->correlativo = count(DNota::all()) + 1;
            $detalle->cantidad = $cantidades[$i];
            $detalle->p_costo = $precios[$i];
            $detalle->save();

            //Aumentar stock y actualizar precio
            Producto::AumentarStock($idproducto, $cantidades[$i], $precios[$i]);
        }
        return redirect()->route('NotaIngreso.index')->with('good', 'Nota de ingreso registrada');
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
        $nota = Nota::findorfail($id);      
        return view('administrador.notas.show', compact('nota'));
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
