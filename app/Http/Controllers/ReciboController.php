<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Cliente;
use App\DRecibo;
use App\Movimiento;
use App\Parametro;
use App\Pedido;
use App\Recibo;
use App\Reserva;
use App\Tipo;
use App\TipoPago;
use App\Traits\util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ReciboController extends Controller
{
    use util;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cajero', ['except' => [
            'listarRecibosxCliente', 'detallesRec',
        ]]);
        $this->middleware('cliente', ['only' => [
            'listarRecibosxCliente', 'detallesRec',
        ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect()->route('consultas.recibos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caja = Caja::where('estado_delete', '=', '1')
            ->where('id', '=', Auth::id())->first();

        $movimiento = Movimiento::where('estado_delete', '=', '1')
            ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
            ->where('idcaja', '=', $caja['idcaja'])->first();
        if ($movimiento == null) {
            return redirect()->route('aperturarcaja')
                ->with('error', 'Aperture caja para emitir recibos');
        } else {
            if ($movimiento->estado == 'CERRADA') {
                return redirect()->route('home')
                    ->with('error', 'La caja ya ha sido cerrada, no puede emitir recibos');
            }
        }

        $parametro = Parametro::first();
        $tipo = Tipo::all();
        $clientes = Cliente::where('estado', '=', '1')->get();
        $now = date('Y-m-d');
        $pedidos_atendidos = Pedido::where('estado_delete', '=', '1')
            ->where('estado', '=', 'Atendido')
            ->whereRaw('date(fecha) =' . "'$now'")
            ->get();


        $reservas = Reserva::where('estado_delete', '=', '1')
            ->where('estado', '=', 'OCUPADA')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')->get();
        $tipopago = TipoPago::all();
        return view('trabajador.caja.cobranza.create', compact(
            'parametro',
            'tipo',
            'clientes',
            'pedidos_atendidos',
            'reservas',
            'tipopago'
        ));
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
        $arr = explode('_', $request->idcliente);
        $recibo = new Recibo();
        $recibo->nrorecibo = $request->nrorecibo;
        $recibo->fecha = date('Y-m-d H:i:s');
        $recibo->tipo_id = 1; //$request->tipo_id;
        $recibo->idcliente = $arr[0];
        $recibo->idtrabajador = auth()->user()->Persona->Trabajador->idtrabajador;
        $recibo->total = $request->total_env;
        $recibo->estado = 1;
        $recibo->idtipopago = $request->idtipopago;
        $recibo->save();

        $idpedido = $request->get('idpedido');
        $monto = $request->get('monto');
        $reserva = $request->get('reserva');

        $cont = 0;
        while ($cont < count($idpedido)) {
            $detalle = new DRecibo();
            $detalle->idrecibo = $recibo->idrecibo;
            $detalle->idpedido = $idpedido[$cont];
            $detalle->monto = $monto[$cont];
            $detalle->save();

            $pedido = Pedido::findorfail($idpedido[$cont]);
            $pedido->estado = "Pagado";
            $pedido->save();

            //Liberando mesa
            $reserva = Reserva::findorfail($reserva[$cont]);
            $reserva->estado = "LIBRE";
            $reserva->save();

            $cont++;
        }

        //Actualizar parámetro
        $dat = explode('-', $request->nrorecibo);
        $numeracion = Parametro::formato($dat[1] + 1);
        Parametro::ActualizarNumero($recibo->tipo_id, $numeracion);

        return redirect()->route('consultas.recibos')->with('good', 'Recibo Registrado');
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

    public function detallesRecibo($idrecibo)
    {
        $recibo = Recibo::findorfail($idrecibo);
        return view('trabajador.caja.consultas.detallesRecibo', compact('recibo'));
    }

    public function ListarRecibos()
    {
        $idtrabajador = auth()->user()->Persona->Trabajador->idtrabajador;
        $recibos_x_t = Recibo::where('estado', '=', '1')
            ->where('idtrabajador', '=', $idtrabajador)
            ->orderBy('fecha', 'DESC')
            ->paginate(5);

        return view('trabajador.caja.consultas.index', compact('recibos_x_t'));
    }

    public function BuscarTipo($id)
    {
        return Parametro::findorfail($id);
    }

    public function BuscarPedidoDatos($id)
    {
        return Pedido::findorfail($id);
    }

    public function ventasdiarias()
    {
        $now = date('Y-m-d');
        $recibos_x_t = Recibo::where('estado', '=', '1')
            ->where('idtrabajador', '=', auth()->user()->Persona->Trabajador->idtrabajador)
            ->whereRaw('date(fecha)=' . "'$now'")
            ->paginate(10);
        $total = 0;
        $efectivo = 0;
        $tarjeta = 0;
        foreach ($recibos_x_t as $item) {
            $total += $item->total;
            $efectivo += $item->efectivo;
            $tarjeta += $item->tarjeta;
        }
        return view('trabajador.caja.consultas.ventasdiarias', compact('recibos_x_t', 'total', 'efectivo', 'tarjeta'));
    }

    public function listarRecibosxCliente()
    {
        $idcliente = auth()->user()->Persona->Cliente->idcliente;
        $recibos = Recibo::where('estado', '=', '1')
            ->where('idcliente', '=', $idcliente)
            ->orderBy('fecha', 'DESC')
            ->paginate(5);
        return view('cliente.consultas.recibos', compact('recibos'));
    }

    public function detallesRec($idrecibo)
    {
        $recibo = Recibo::findorfail($idrecibo);
        return view('cliente.consultas.detallesRec', compact('recibo'));
    }


    //
    public function CobrarPedido($id)
    {
        $pedido = Pedido::findorfail($id);
        if ($pedido->estado == "Pagado") {
            return redirect()->route('home')->with('error', 'El pedido ya ha sido pagado');
        }

        $plantilla = $this->ObtenerPlantilla();
        $trabajador = auth()->user()->Persona->Trabajador;
        $cargo = $trabajador->Cargo;
        if ($cargo->descripcion == "ADMINISTRADOR") {
            $pedido = Pedido::findorfail($id);
            return view('cajero.cobrarpedido', compact('plantilla', 'pedido'));
        }

        $caja = Caja::where('estado_delete', '=', '1')
            ->where('id', '=', Auth::id())->first();

        $movimiento = Movimiento::where('estado_delete', '=', '1')
            ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
            ->where('idcaja', '=', $caja['idcaja'])->first();
        if ($movimiento == null) {
            return redirect()->route('aperturarcaja')
                ->with('error', 'Aperture caja para emitir recibos');
        } else {
            if ($movimiento->estado == 'CERRADA') {
                return redirect()->route('home')
                    ->with('error', 'La caja ya ha sido cerrada, no puede emitir recibos');
            }
        }

        $pedido = Pedido::findorfail($id);
        return view('cajero.cobrarpedido', compact('plantilla', 'pedido'));
    }

    public function Cobrado(Request $request, $id)
    {
        // return $request->all();
        $pedido = Pedido::findorfail($id);

        $arr = explode('_', $request->idcliente);
        $recibo = new Recibo();
        $parametro = Parametro::first();
        $recibo->nrorecibo = $parametro->serie . '-' . $parametro->numeracion;
        $recibo->fecha = date('Y-m-d H:i:s');
        $recibo->tipo_id = 1; //$request->tipo_id;
        // $recibo->idcliente = $arr[0];
        $recibo->idcliente = $pedido->idcliente;
        $recibo->idtrabajador = auth()->user()->Persona->Trabajador->idtrabajador;
        // $recibo->total = $request->total_env;
        $recibo->total = $pedido->Total($pedido->DPedido);
        $recibo->estado = 1;
        // $recibo->idtipopago = 1; //$request->idtipopago;
        $recibo->efectivo = $request->efectivo;
        $recibo->tarjeta = $request->tarjeta;

        if ($recibo->efectivo == $recibo->total) $recibo->idtipopago = 1;
        else if ($recibo->tarjeta == $recibo->total) $recibo->idtipopago = 2;
        else $recibo->idtipopago = 3;

        $recibo->save();

        // $idpedido = $request->get('idpedido');
        // $monto = $request->get('monto');
        // $reserva = $request->get('reserva');

        // $cont = 0;
        // while ($cont < count($idpedido)) {
        $detalle = new DRecibo();
        $detalle->idrecibo = $recibo->idrecibo;
        // $detalle->idpedido = $idpedido[$cont];
        $detalle->idpedido = $pedido->idpedido;
        $detalle->monto = $pedido->Total($pedido->DPedido);
        $detalle->save();

        // $pedido = Pedido::findorfail($idpedido[$cont]);
        $pedido->estado = "Pagado";
        $pedido->save();

        //Liberando mesa
        $reserva = Reserva::findorfail($pedido->Reserva->reserva_id);
        $reserva->estado = "LIBRE";
        $reserva->save();

        //     $cont++;
        // }

        //Actualizar parámetro
        $dat = explode('-', $parametro->serie . '-' . $parametro->numeracion);
        $numeracion = Parametro::formato($dat[1] + 1);
        Parametro::ActualizarNumero($recibo->tipo_id, $numeracion);

        $trabajador = auth()->user()->Persona->Trabajador;
        $cargo = $trabajador->Cargo;
        if ($cargo->descripcion == "ADMINISTRADOR") {
            return redirect()->route('home')->with('good', 'Pedido Cobrado');
        }

        return redirect()->route('consultas.recibos')->with('good', 'Recibo Registrado');
    }
}
