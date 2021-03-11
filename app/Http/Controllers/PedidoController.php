<?php

namespace App\Http\Controllers;

use App\DPedido;
use App\Pedido;
use App\Programacion;
use App\Trabajador;
use App\Traits\util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    use util;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cliente', ['except' => [
            'listaPedidos', 'detalles', 'listaPendientes', 'atender', 'atendido', 'anular', 'anulado',
            'pedidosAtendidos'
        ]]);
        $this->middleware('trabajador', ['only' => [
            'listaPedidos', 'detalles', 'listaPendientes', 'atender', 'atendido', 'anular', 'anulado',
            'pedidosAtendidos'
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
        return redirect()->route('pedidosCliente.inicio');
    }

    public function inicio()
    {
        $pedidos = auth()->user()->Persona->Cliente->Pedidos()->orderBy('fecha', 'DESC')->paginate(5);
        return view('cliente.consultas.index', compact('pedidos'));
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
        $prog = programacion::where('estado', '=', '1')->orderBy('fecha', 'DESC')->first();
        if ($prog != null) {
            if ($prog->fecha->format('Y-m-d') != $now) {
                $prog = null;
            } else {
                $pedido = Pedido::latest('idpedido')->first();
                $nropedido = "0000000001";
                if ($pedido != null) {
                    $nropedido = $pedido->formato($pedido->idpedido + 1);
                }

                return view('cliente.operaciones.pedido_cli.create', compact('prog', 'nropedido'));
            }
        }
        return redirect()->route('pedidosCliente.inicio')->with('error', 'No hay una programación para hoy, no puede hacer pedidos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // DB::Transaction(function() {

        // });
        $pedido = new Pedido();
        $pedido->idcliente = auth()->user()->Persona->Cliente->idcliente;
        $pedido->fecha = date_create();
        $pedido->estado = "Pendiente";
        $pedido->estado_delete = 1;
        $pedido->lugar = "DELIVERY";
        // $pedido->observacion = $request->obs;
        $pedido->save();
        $idpedido = $pedido->idpedido;
        $i = 0;

        foreach ($request->idplato as $item) {
            $detalle = new DPedido();
            $detalle->idpedido = $idpedido;
            $detalle->idplato = $item;
            $detalle->p_venta = $request->p_venta[$i];
            $detalle->cantidad = $request->cantidad[$i];
            $i++;
            $detalle->save();
        }
        return redirect()->route('pedidosCliente.inicio')->with('good', 'Su pedido ha sido enviado, nos comunicaremos muy pronto con usted');
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
        $pedido = pedido::findorfail($id);
        $pedido->estado = 'Anulado';
        $pedido->save();
        return redirect()->route('pedidosCliente.inicio')->with('good', 'El pedido fue anulado');
    }

    public function confirmar($id)
    {
        $now = date('Y-m-d');
        $pedido = pedido::findorfail($id);

        if ($pedido->fecha->format('Y-m-d') != $now) {
            return redirect()->route('pedidosCliente.inicio')->with('error', 'No se puede anular, el pedido no se registró hoy.');
        } else if ($pedido->estado == 'Atendido') {
            return redirect()->route('pedidosCliente.inicio')->with('error', 'No se puede anular, el pedido ya fue atendido.');
        } else if ($pedido->estado == 'Anulado') {
            return redirect()->route('pedidosCliente.inicio')->with('error', 'No se puede anular, el pedido ya fue anulado.');
        } else if ($pedido->estado == 'Pagado') {
            return redirect()->route('pedidosCliente.inicio')->with('error', 'No se puede anular, el pedido ya fue pagado.');
        } else if ($pedido->estado == 'Confirmado') {
            return redirect()->route('pedidosCliente.inicio')->with('error', 'No se puede anular, el pedido ya fue confirmado.');
        } else {
            return view('cliente.operaciones.pedido_cli.confirmar', compact('pedido'));
        }
    }

    public function detalles_pedido($id)
    {
        $pedido = pedido::findorfail($id);
        return view('cliente.operaciones.pedido_cli.detalles', compact('pedido'));
    }

    public function listaPedidos(Request $request)
    {
        $plantilla = $this->ObtenerPlantilla();
        $cbxtipo = $request->cbxtipo;
        $idtrabajador = $request->idtrabajador;

        $pedidos = pedido::where('estado_delete', '=', '1')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->where('estado', '=', 'Confirmado')->orderBy('fecha', 'DESC')
            ->get();

        if ($idtrabajador != null && $cbxtipo != null) {
            if ($cbxtipo == 'Confirmado') $estado = 'Confirmado';
            else if ($cbxtipo == 'Atendido') $estado = 'Atendido';
            else $estado = 'Pagado';

            if ($idtrabajador == 0) {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->where('estado', '=', $estado)->orderBy('fecha', 'DESC')
                    ->get();
            } else {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->where('estado', '=', $estado)->orderBy('fecha', 'DESC')
                    ->where('idtrabajador', '=', $idtrabajador)
                    ->get();
            }
        }

        $meseros = Trabajador::where('idcargo', '=', '2')->where('estado', '=', '1')->get();        
        return view('trabajador.consultas.pedidos', compact('plantilla', 'pedidos', 'cbxtipo', 'idtrabajador', 'meseros'));
    }

    public function detalles($id)
    {
        $plantilla = $this->ObtenerPlantilla();
        $pedido = pedido::findorfail($id);
        return view('trabajador.consultas.detalles', compact('plantilla', 'pedido'));
    }

    public function listaPendientes()
    {
        $now = date('Y-m-d');
        $pedidos = pedido::where('estado_delete', '=', '1')
            ->where('estado', '=', 'Pendiente')
            ->whereRaw('date(fecha) =' . "'$now'")
            ->paginate(8);
        return view('trabajador.atencion.listaPendientes', compact('pedidos'));
    }

    public function atender($id)
    {
        $pedido = pedido::findorfail($id);
        $detalles = $pedido->DPedido()->paginate(5);
        return view('trabajador.atencion.atender', compact('pedido', 'detalles'));
    }

    public function atendido(Request $request, $id)
    {
        //
        $pedido = pedido::findorfail($id);
        $pedido->estado = 'Confirmado';
        $pedido->save();
        return redirect()->route('home.atencion')->with('datos', 'Pedido Confirmado, puede ver detalles en "Consultas"');
    }

    public function anular($id)
    {
        $now = date('Y-m-d');
        $pedido = pedido::findorfail($id);
        if ($pedido->estado == 'Pendiente' && $pedido->fecha->format('Y-m-d') == $now) {
            return view('trabajador.atencion.anular', compact('pedido'));
        } else {
            return redirect()->route('home.atencion')->with('error', 'El pedido no se puede anular');
        }
    }

    public function anulado($id)
    {
        $pedido = pedido::findorfail($id);
        $pedido->estado = 'Anulado';
        $pedido->save();
        return redirect()->route('home.atencion')->with('datos', 'EL PEDIDO FUE ANULADO');
    }

    public function pedidosAtendidos()
    {
        $now = date('Y-m-d');
        $pedidos = Pedido::where('estado_delete', '=', '1')
            ->where('estado', '=', 'Confirmado')
            ->whereRaw('date(fecha) =' . "'$now'")
            ->get();
        return view('trabajador.caja.consultas.pedidosAtendidos', compact('pedidos'));
    }
}
