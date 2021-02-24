<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Programacion;
use App\Plato;
use App\DProgramacion;
use Illuminate\Support\Facades\DB;

class ProgramacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['mostrarProgramacion']]);
        $this->middleware('cliente', ['only' => ['mostrarProgramacion']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //    
        $prog = Programacion::where('estado', '=', '1')
            ->orderBy('fecha', 'DESC')
            ->paginate(5);
        return view('trabajador.abastecimiento.programacion.index', compact('prog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //                
        $now = date('Y-m-d');
        $programacion = programacion::where('estado', '=', '1')->orderBy('fecha', 'DESC')->first();
        if ($programacion != null) {
            if ($programacion->fecha->format('Y-m-d') == $now) {
                return redirect()->route('programacion.index')->with('error', 'Solo se permite una programación por día');
            }
        }
        $platos = plato::where('estado', '=', '1')->get();

        return view('trabajador.abastecimiento.programacion.create', compact('platos'));
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
        $programacion = new Programacion();
        $programacion->fecha = date_create();
        $programacion->idtrabajador = Auth::user()->Persona->Trabajador->idtrabajador;
        $programacion->estado = 1;
        $programacion->save();

        $idprogramacion = $programacion->idprogramacion;
        $i = 0;
        foreach ($request->idplato as $item) {
            $detalle = new DProgramacion();
            $detalle->idprogramacion = $idprogramacion;
            $detalle->idplato = $item;
            $detalle->stock = $request->cantidad[$i];
            $detalle->estado = 1;
            $detalle->save();
            $i++;
        }

        return redirect()->route('programacion.index')->with('good', 'Se registro correctamente la programación');
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
        $msj = null;
        $programacion = Programacion::findorfail($id);
        //Requisitos para editar una programación
        if ($programacion->estado == 1 && $programacion->fecha->format('Y-m-d') == date('Y-m-d')) {
            $msj = 'ok';
        }

        if ($msj == null) {
            $msj = 'Error: No puede hacer cambios en la programación seleccionada';
            return redirect()->route('programacion.index')->with('error', $msj);
        }

        $platos = plato::where('estado', '=', '1')->get();
        return view('trabajador.abastecimiento.programacion.edit', compact('platos', 'programacion'));
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
        $programacion = Programacion::findorfail($id);
        $listaA = $programacion->DProgramacion;

        $idplatos = $request->get('idplato');
        $cantidad  = $request->get('cantidad');
        foreach ($listaA as $item) {
            $encontrado = false;
            foreach ($idplatos as $i => $idplato) {
                if ($item->Plato->id == $idplato) {
                    $encontrado = true;
                    DB::update(
                        'update d_programacions set stock = ? where idprogramacion = ? and idplato = ?',
                        [$cantidad[$i], $id, $idplato]
                    );
                    array_splice($idplatos, $i, 1);
                    array_splice($cantidad, $i, 1);
                }
            }
            if (!$encontrado) {
                DB::update(
                    'update d_programacions set estado = 0 where idprogramacion = ? and idplato = ?',
                    [$id, $item->Plato->id]
                );
            }
        }

        foreach ($idplatos as $i => $idplato) {
            $detalle = DProgramacion::where('idprogramacion', '=', $id)->where('idplato', '=', $idplato)->first();
            if ($detalle != null) {
                DB::update(
                    'update d_programacions set stock = ?, estado = 1 where idprogramacion = ? and idplato = ?',
                    [$cantidad[$i], $id, $idplato]
                );
            } else {
                $detalle = new DProgramacion();
                $detalle->idprogramacion = $id;
                $detalle->idplato = $idplato;
                $detalle->stock = $cantidad[$i];
                $detalle->estado = 1;
                $detalle->save();
            }
        }

        return redirect()->route('programacion.index')->with('good', 'Programación actualizada con éxito');
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
        $prog = programacion::findorfail($id);
        $prog->estado = 0;
        $prog->save();
        return redirect()->route('programacion.index')->with('good', 'La programación se eliminó');
    }

    public function confirmar($id)
    {
        // 
        $now = date('Y-m-d');
        $prog = programacion::findorfail($id);

        $idtrabajador = auth()->user()->Persona->Trabajador->idtrabajador;
        if ($idtrabajador != $prog->idtrabajador) {
            return redirect()->route('programacion.index')->with('error', 'No puede eliminar una programación que usted no registró');
        }

        if ($prog->fecha->format('Y-m-d') == $now)
            return view('trabajador.abastecimiento.programacion.confirm', compact('prog'));
        else
            return redirect()->route('programacion.index')->with('error', 'No puede eliminar una programación que se no registró hoy');
    }

    public function detalles($id)
    {
        //
        $prog = programacion::findorfail($id);
        $detalles = $prog->DProgramacion()->paginate(5);
        return view('trabajador.abastecimiento.programacion.detalles', compact('prog', 'detalles'));
    }

    //ROL: CLIENTE
    public function mostrarProgramacion(Request $request)
    {
        //        
        $platos = Plato::where('estado', '=', '1')->get();
        $buscarpor = $request->buscarpor;
        $now = date('Y-m-d');
        $prog = programacion::where('estado', '=', '1')->orderBy('fecha', 'DESC')->first();
        if ($prog != null) {
            if ($prog->fecha->format('Y-m-d') != $now)
                $prog = null;
            else
                $detalles = $prog->DProgramacion_buscar($buscarpor, $prog->idprogramacion);
        }
        return view('cliente.operaciones.programacion_cli.index', compact('detalles', 'buscarpor', 'platos'));
    }
}
