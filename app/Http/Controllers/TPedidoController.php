<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\DPedido;
use App\DProgramacion;
use App\Mesa;
use App\Pedido;
use App\Producto;
use App\Programacion;
use App\Reserva;
use App\Trabajador;
use App\Traits\util;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TPedidoController extends Controller
{
    use util;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('trabajador');
    }

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
        $plantilla = $this->ObtenerPlantilla();
        $now = date('Y-m-d');
        $prog = Programacion::where('estado', '=', '1')->orderBy('fecha', 'DESC')->first();
        if ($prog != null) {
            if ($prog->fecha->format('Y-m-d') != $now) {
                return redirect()->route('home')->with('error', 'No existe una programación hoy');
            }
        } else {
            return redirect()->route('home')->with('error', 'No existe una programación hoy');
        }

        $clientes = Cliente::where('estado', '=', '1')->get();
        $pedido = Pedido::latest('idpedido')->first();
        $nropedido = "0000000001";
        if ($pedido != null) {
            $nropedido = $pedido->formato($pedido->idpedido + 1);
        }

        $productos = Producto::where('estado', '=', '1')->get();
        return view('trabajador.ventas.delivery.crearPedido', compact('plantilla', 'nropedido', 'clientes', 'prog', 'productos'));
    }

    public function crearPedido($mesa_id)
    {
        $plantilla = $this->ObtenerPlantilla();
        $mesa = Mesa::findorfail($mesa_id);
        $now = date('Y-m-d');
        $reserva = Reserva::whereRaw('date(fecha)=' . "'$now'")
            ->where('mesa_id', '=', $mesa_id)
            ->where('estado', '=', 'OCUPADA')
            ->first();

        if ($reserva != null) {
            // session('fuente') = "Home";                  
            return redirect()->route('AtenderPedido', $reserva->idpedido);
            // return redirect()->route('home')->with('error', 'No puede reservar, la MESA ' . $mesa->nromesa . ' está ocupada, Elija otra mesa');
        }

        $prog = Programacion::where('estado', '=', '1')->orderBy('fecha', 'DESC')->first();
        if ($prog != null) {
            if ($prog->fecha->format('Y-m-d') != $now) {
                return redirect()->route('home')->with('error', 'No existe una programación hoy');
            }
        } else {
            return redirect()->route('home')->with('error', 'No existe una programación hoy');
        }

        $clientes = Cliente::where('estado', '=', '1')->get();
        $pedido = Pedido::latest('idpedido')->first();
        $nropedido = "0000000001";
        if ($pedido != null) {
            $nropedido = $pedido->formato($pedido->idpedido + 1);
        }

        $productos = Producto::where('estado', '=', '1')->get();      
        return view('trabajador.ventas.local.tpedidos.crearPedido', compact('plantilla', 'nropedido', 'mesa', 'clientes', 'prog', 'productos'));
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
        $pedido = new Pedido();
        $pedido->idcliente = $request->idcliente;
        $pedido->fecha = date_create();
        if ($request->lugar == 'LOCAL') $pedido->estado = "Confirmado";
        else $pedido->estado = "Pendiente";
        $pedido->estado_delete = 1;
        $pedido->lugar = $request->lugar;
        $pedido->idtrabajador = $request->idtrabajador;
        $pedido->observacion = $request->obs;
        $pedido->save();

        $idplato = $request->get('idplato');
        $p_venta = $request->get('p_venta');
        $cantidad = $request->get('cantidad');
        $nombre_tabla = $request->get('nombre_tabla');

        $cont = 0;
        while ($cont < count($idplato)) {
            $detalle = new DPedido();
            $detalle->idpedido = $pedido->idpedido;
            $detalle->idplato = $idplato[$cont];
            $detalle->correlativo = count(DPedido::all()) + 1;
            $detalle->p_venta = $p_venta[$cont];
            $detalle->cantidad = $cantidad[$cont];
            $detalle->nombre_tabla = $nombre_tabla[$cont];
            $detalle->save();

            //Descontar stock
            if ($nombre_tabla[$cont] == 'producto') {
                Producto::DescontarStock($idplato[$cont], $cantidad[$cont]);
            } else {
                $programacion = Programacion::where('estado', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->orderby('fecha', 'desc')->first();
                DProgramacion::DescontarStock($programacion->idprogramacion, $idplato[$cont], $cantidad[$cont]);
            }
            $cont++;
        }

        if ($request->isDelivery == null) {
            $reserva = new Reserva();
            $reserva->mesa_id = $request->mesa_id;
            $reserva->idcliente = $request->idcliente;
            $reserva->fecha = date_create();
            $reserva->estado = "OCUPADA";
            $reserva->estado_delete = "1";
            $reserva->idpedido = $pedido->idpedido;
            $reserva->save();
            $mesa = Mesa::findorfail($request->mesa_id);
            return redirect()->route('home')->with('good', 'Pedido registrado y MESA ' . $mesa['nromesa'] . ' reservada');
        } else {
            return redirect()->route('home')->with('good', 'Pedido registrado');
        }
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

    public function VerificarPassword($password)
    {
        $users = User::where('estado', '=', '1')->get();
        $usuario = null;
        foreach ($users as $user) {
            if (password_verify($password, $user['password'])) {
                $usuario = $user;
                break;
            }
        }
        if ($usuario == null) {
            return ['status' => 'clave_no_valida'];
        }
        $trabajador = $usuario->Persona->Trabajador;
        if ($trabajador->Cargo->idcargo != 2) {
            return ['status' => 'usuario_no_valido'];
        }
        return ['status' => 'ok', 'idtrabajador' => $trabajador->idtrabajador];
    }

    public function AtenderPedidos(Request $request)
    {
        $plantilla = $this->ObtenerPlantilla();
        $idtrabajador = $request->idtrabajador;

        $pedidos = pedido::where('estado_delete', '=', '1')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->where('estado', '=', 'Confirmado')->orderBy('fecha', 'DESC')
            ->get();

        if ($idtrabajador != null) {
            if ($idtrabajador == 0) {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->where('estado', '=', 'Confirmado')->orderBy('fecha', 'DESC')
                    ->get();
            } else {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->where('estado', '=', 'Confirmado')->orderBy('fecha', 'DESC')
                    ->where('idtrabajador', '=', $idtrabajador)
                    ->get();
            }
        }

        $meseros = Trabajador::where('idcargo', '=', '2')->where('estado', '=', '1')->get();
        return view('trabajador.atencion.atenderpedidos', compact('plantilla', 'pedidos', 'idtrabajador', 'meseros', 'plantilla'));
    }


    public function Atender($id)
    {
        $plantilla = $this->ObtenerPlantilla();
        $pedido = Pedido::findorfail($id);
        return view('trabajador.atencion.atender', compact('plantilla', 'pedido', 'fuente'));
    }

    public function Atendido(Request $request, $id)
    {
        $pedido = Pedido::findorfail($id);
        $detalles = $request->get('opcion');

        foreach ($pedido->DPedido as $item) {
            DB::update('update d_pedido set estado = "pendiente" where idpedido = ?', [$id]);
        }
        if ($detalles != null) {
            foreach ($detalles as $item) {
                DB::update(
                    'update d_pedido set estado = "atendido" where correlativo = ?',
                    [$item]
                );
            }

            if (count($detalles) == count($pedido->DPedido)) {
                $pedido->estado = 'Atendido';
                $pedido->save();
            }
        }

        return redirect()->route('AtenderPedidos');
    }

    //
    public function ModificarPedidos(Request $request)
    {
        $plantilla = $this->ObtenerPlantilla();
        $idtrabajador = $request->idtrabajador;

        $pedidos = pedido::whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->whereraw('(estado = "Confirmado" or estado = "Atendido")')
            ->where('estado_delete', '=', '1')
            ->orderBy('fecha', 'DESC')
            ->get();

        if ($idtrabajador != null) {
            if ($idtrabajador == 0) {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->whereraw('estado = "Confirmado" or estado = "Atendido"')
                    ->orderBy('fecha', 'DESC')
                    ->get();
            } else {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->whereraw('estado = "Confirmado" or estado = "Atendido"')
                    ->orderBy('fecha', 'DESC')
                    ->where('idtrabajador', '=', $idtrabajador)
                    ->get();
            }
        }

        $meseros = Trabajador::where('idcargo', '=', '2')->where('estado', '=', '1')->get();
        return view('trabajador.atencion.modificarpedidos', compact('plantilla', 'pedidos', 'idtrabajador', 'meseros'));
    }

    public function Modificar($id)
    {
        $plantilla = $this->ObtenerPlantilla();
        $productos = Producto::where('estado', '=', '1')->get();
        $prog = Programacion::where('estado', '=', '1')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->orderby('fecha', 'desc')->first();
        $pedido = Pedido::findorfail($id);
        return view('trabajador.atencion.modificar', compact('plantilla', 'pedido', 'productos', 'prog'));
    }

    public function Modificado(Request $request, $id)
    {               
        $pedido = Pedido::findorfail($id);

        $ids = $request->get('ids');

        if ($ids == null) {
            if (session('fuente') == 'HOME') return redirect()->route('home');
            else return redirect()->route('ModificarPedidos');
        }

        $programacion = Programacion::where('estado', '=', '1')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->orderby('fecha', 'desc')->first();

        //Devolver stock
        $detalles = $pedido->DPedido;
        foreach ($detalles as $detalle) {
            if ($detalle->nombre_tabla == 'producto')
                Producto::AumentarSoloStock($detalle->idplato, $detalle->cantidad);
            else
                DProgramacion::AumentarStock($programacion->idprogramacion, $detalle->idplato, $detalle->cantidad);
        }

        //Eliminar detalles antiguos
        DB::update(
            'update d_pedido set estado_delete=0 where idpedido=?',
            [$id]
        );

        //Agregar detalles nuevos
        $pventa = $request->get('pventa');
        $cantidades = $request->get('cantidades');
        $nombres_tabla = $request->get('nombres_tabla');
        $estados = $request->get('estados');

        foreach ($ids as $i => $idplato) {
            //Insertar
            $detalle = new DPedido();
            $detalle->idpedido = $id;
            $detalle->idplato = $idplato;
            $detalle->correlativo = count(DPedido::all()) + 1;
            $detalle->p_venta = $pventa[$i];
            $detalle->cantidad = $cantidades[$i];
            $detalle->nombre_tabla = $nombres_tabla[$i];
            $detalle->estado = $estados[$i];
            $detalle->save();

            //Descontar stock
            if ($nombres_tabla[$i] == 'producto') {
                Producto::DescontarStock($idplato, $cantidades[$i]);
            } else {
                DProgramacion::DescontarStock($programacion->idprogramacion, $idplato, $cantidades[$i]);
            }
        }

        $detalles = DPedido::where('idpedido', '=', $id)->where('estado', '=', 'pendiente')
            ->where('estado_delete', '=', '1')->get();
        if (count($detalles) > 0) {
            $pedido = Pedido::findorfail($id);
            $pedido->estado = 'Confirmado';
            $pedido->save();
        }

        $mesa = Pedido::findorfail($id)->Reserva->Mesa;
        $mensaje = 'Pedido de MESA ' . $mesa['nromesa'] . ' modificado con éxito';
        if (session('fuente') == 'HOME') return redirect()->route('home')->with('good', $mensaje);
        else return redirect()->route('ModificarPedidos')->with('good', $mensaje);
    }

    public function ImprimirPedido($id)
    {
        $pedido = Pedido::findorfail($id);
        $pdf = PDF::loadView('reportes.ImprimirPedido', compact('pedido'));
        $pdf->setpaper([0, 0, 210, 450]);
        return $pdf->stream('ReciboImpreso_' . date('Ymd') . '.pdf');
    }

    public function ImprimirPedidoEstado($id)
    {
        $pedido = Pedido::findorfail($id);
        $msj = "";
        if (count($pedido->DPedidoPendiente) == 0) {
            $msj = "Nota: pedido atendido en su totalidad";
        }
        $pdf = PDF::loadView('reportes.ImprimirPedidoEstado', compact('pedido', 'msj'));
        $pdf->setpaper([0, 0, 210, 450]);
        return $pdf->stream('ReciboImpreso_' . date('Ymd') . '.pdf');
    }
}
