<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TipoPlato;

class TipoPlatoController extends Controller
{
    public function __construct(){
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
        $tipos=TipoPlato::where('estado','=','1')->get();
        return view('trabajador.abastecimiento.tipoplato.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //        
        return view('trabajador.abastecimiento.tipoplato.create');
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
        $data=request()->validate([                                    
            'foto'=>['required','image'],
        ],
        [
            'foto.required'=>'Seleccione una imagen', 
            'foto.image'=>'El tipo de documento no es admitido',    
        ]);              

        $tipoplato=new TipoPlato();
        $tipoplato->descripcion=$request->descripcion;   
        $tipoplato->estado='1';                  
        $tipoplato->save();   
        
        $file = $request->file('foto');
        $nombre = $tipoplato->id.auth()->user()->id.'.'.$file->getClientOriginalExtension(); //81.png
        \Storage::disk('img-tipoplato')->put($nombre,  \File::get($file));

        $tipoplato->foto=$nombre;
        $tipoplato->save();

        return redirect()->route('tipoplato.index');
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
        $tipoplato=TipoPlato::findOrfail($id);
        return view('trabajador.abastecimiento.tipoplato.edit', compact('tipoplato'));
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
        $tipoplato=TipoPlato::findOrfail($id);
        $tipoplato->descripcion=$request->descripcion;                   
        if ($request->foto != null){            
            $file = $request->file('foto');
            $nombre = $tipoplato->id. auth()->user()->id.'.'.$file->getClientOriginalExtension();
            \Storage::disk('img-tipoplato')->put($nombre,  \File::get($file));
            $tipoplato->foto=$nombre;
        }
        $tipoplato->save();
        return redirect()->route('tipoplato.index');
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
        $tipoplato=TipoPlato::findOrfail($id);
        $tipoplato->estado='0';
        $tipoplato->save();
        
        return redirect()->route('tipoplato.index');
    }

    public function confirmar($id){        
        $tipoplato=TipoPlato::findOrfail($id);
        return view('trabajador.abastecimiento.tipoplato.confirmar', compact('tipoplato'));
    }
}
