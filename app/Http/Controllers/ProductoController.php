<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productos = Producto::where('estado', '=', '1')->paginate(5);
        return view('trabajador.abastecimiento.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorias = Categoria::where('estado', '=', '1')->get();
        return view('trabajador.abastecimiento.productos.create', compact('categorias'));
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
        $data = request()->validate(
            [
                'nombre' => 'required',
                'nombre' => 'max:50',
                'p_costo' => 'required',
                'p_venta' => 'required',
                'stock' => 'required'
            ],
            [
                'nombre.required' => 'Ingrese descripción',
                'nombre.max' => 'Máx. 50 dígitos',
                'p_costo.required' => 'Ingrese precio costo',
                'p_venta.required' => 'Ingrese precio venta',
                'stock.required' => 'Ingrese stock',
            ]
        );

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->idcategoria = $request->idcategoria;
        $producto->p_costo = $request->p_costo;
        $producto->p_venta = $request->p_venta;
        $producto->stock = $request->stock;
        $producto->save();
        return redirect()->route('producto.index')->with('good', 'Producto Agregado');;
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
        $categorias = Categoria::where('estado', '=', '1')->get();
        $producto = Producto::findorfail($id);
        return view('trabajador.abastecimiento.productos.edit', compact('categorias', 'producto'));
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
        $data = request()->validate(
            [
                'nombre' => 'required',
                'nombre' => 'max:50',
                'p_costo' => 'required',
                'p_venta' => 'required',
                'stock' => 'required'
            ],
            [
                'nombre.required' => 'Ingrese descripción',
                'nombre.max' => 'Máx. 50 dígitos',
                'p_costo.required' => 'Ingrese precio costo',
                'p_venta.required' => 'Ingrese precio venta',
                'stock.required' => 'Ingrese stock',
            ]
        );

        $producto = Producto::findorfail($id);
        $producto->nombre = $request->nombre;
        $producto->idcategoria = $request->idcategoria;
        $producto->p_costo = $request->p_costo;
        $producto->p_venta = $request->p_venta;
        $producto->stock = $request->stock;
        $producto->save();
        return redirect()->route('producto.index')->with('good', 'Producto Modificado');;
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
        $producto = Producto::findorfail($id);
        $producto->estado = 0;
        $producto->save();
        return redirect()->route('producto.index')->with('good', 'Producto Eliminado');
    }

    public function confirmar($id)
    {
        $producto = Producto::findOrfail($id);
        return view('trabajador.abastecimiento.productos.confirmar', compact('producto'));
    }
}
