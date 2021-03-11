<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Traits\util;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    use util;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plantilla = $this->ObtenerPlantilla();
        $categorias = Categoria::where('estado', '=', '1')->get();
        return view('trabajador.abastecimiento.categorias.index', compact('plantilla', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plantilla = $this->ObtenerPlantilla();
        return view('trabajador.abastecimiento.categorias.create', compact('plantilla'));
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
                'descripcion' => 'required',
                'descripcion' => 'max:50'
            ],
            [
                'descripcion.required' => 'Ingrese descripción',
                'descripcion.max' => 'Máx. 50 dígitos',
            ]
        );

        $categoria = new Categoria();
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return redirect()->route('categoria.index')->with('good', 'Categoría Agregada');
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
        $plantilla = $this->ObtenerPlantilla();
        $categoria = Categoria::findorfail($id);
        return view('trabajador.abastecimiento.categorias.edit', compact('plantilla', 'categoria'));
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
                'descripcion' => 'required',
                'descripcion' => 'max:50'
            ],
            [
                'descripcion.required' => 'Ingrese descripción',
                'descripcion.max' => 'Máx. 50 dígitos',
            ]
        );

        $categoria = Categoria::findorfail($id);
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return redirect()->route('categoria.index')->with('good', 'Categoría Modificada');;
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
        $categoria = Categoria::findorfail($id);
        $categoria->estado = 0;
        $categoria->save();
        return redirect()->route('categoria.index')->with('good', 'Categoría Eliminada');;
    }

    public function confirmar($id)
    {
        $plantilla = $this->ObtenerPlantilla();
        $categoria = Categoria::findOrfail($id);
        return view('trabajador.abastecimiento.categorias.confirmar', compact('plantilla', 'categoria'));
    }
}
