<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plato;
use App\TipoPlato;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PlatoController extends Controller
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
    public function index(Request $request)
    {
        //
        if (auth()->user()->Persona->Trabajador == null)
            return redirect('/');

        $buscarpor=$request->buscarpor;
        $platos=Plato::where('estado','=','1')
            ->where('nombre', 'like','%'.$buscarpor.'%')
            ->get();
        return view('trabajador.abastecimiento.plato.index', compact('platos', 'buscarpor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (auth()->user()->Persona->Trabajador == null)
            return redirect('/');

        $tipos=TipoPlato::where('estado','=','1')->get();
        return view('trabajador.abastecimiento.plato.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $data=request()->validate([                                    
            'foto'=>['required','image',],        
        ],
        [
            'foto.required'=>'Seleccione una imagen', 
            'foto.image'=>'El tipo de doc no es admitido',   
        ]);    
                
        $plato=new Plato();
        $plato->nombre=$request->nombre;
        $plato->idtipoplato=$request->idtipoplato;
        $plato->p_costo=$request->p_costo;
        $plato->p_venta=$request->p_venta;        
        $plato->estado='1';                        
        $plato->save();   
        
        $file = $request->file('foto');
        $nombre = $plato->id. auth()->user()->id.'.'.$file->getClientOriginalExtension();
        Storage::disk('img-plato')->put($nombre,  File::get($file));

        $plato->foto=$nombre;
        $plato->save();

        return redirect()->route('plato.index');        
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
        if (auth()->user()->Persona->Trabajador == null)
            return redirect('/');
        //
        $plato=Plato::findOrfail($id);        
        $tipos=TipoPlato::where('estado','=','1')->get();
        return view('trabajador.abastecimiento.plato.edit', compact('plato', 'tipos'));
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
        $plato=Plato::findOrfail($id);        
        $plato->nombre=$request->nombre;
        $plato->idtipoplato=$request->idtipoplato;
        $plato->p_costo=$request->p_costo;
        $plato->p_venta=$request->p_venta;       
        if ($request->foto != null){
            $file = $request->file('foto');
            $nombre = $plato->id.auth()->user()->id.'.'.$file->getClientOriginalExtension();
            Storage::disk('img-plato')->put($nombre,  File::get($file));
            $plato->foto=$nombre;
        }
        $plato->save();                   
        return redirect()->route('plato.index');
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
        $plato=Plato::findOrfail($id);
        $plato->estado='0';
        $plato->save();
        
        return redirect()->route('plato.index');
    }

    public function confirmar($id){
        if (auth()->user()->Persona->Trabajador == null)
            return redirect('/');
        //
        $plato=Plato::findOrfail($id);
        $tipoplato=TipoPlato::findOrfail($plato->idtipoplato);
        return view('trabajador.abastecimiento.plato.confirmar', compact('plato', 'tipoplato'));
    }
}
