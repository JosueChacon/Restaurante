<?php

namespace App\Http\Controllers;

use App\Mesa;
use App\Pedido;
use App\Reserva;
use App\Trabajador;
use App\Traits\util;
use Illuminate\Http\Request;

class MostradorController extends Controller
{
    use util;

    public function  __construct()
    {
        $this->middleware('auth');
    }

    public function VerMostrador()
    {
        $mesas = Mesa::where('estado', '=', '1')->orderby('nromesa', 'DESC')->get();
        $reservas = Reserva::where('estado_delete', '=', '1')->where('estado', '=', 'OCUPADA')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')->get();
        $plantilla = $this->ObtenerPlantilla();
        return view('trabajador.p_trabajador', compact('mesas', 'reservas', 'plantilla'));
    }

    public function CobranzaPedidos(Request $request)
    {
        $plantilla = $this->ObtenerPlantilla();
        $idtrabajador = $request->idtrabajador;

        $pedidos = pedido::where('estado_delete', '=', '1')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->whereraw("(estado = 'Atendido' or estado = 'Confirmado')")
            ->orderby('fecha', 'desc')
            ->get();

        if ($idtrabajador != null) {
            if ($idtrabajador == 0) {
                $pedidos = Pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->whereraw("(estado = 'Atendido' or estado = 'Confirmado')")
                    ->orderby('fecha', 'desc')
                    ->get();
            } else {
                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->whereraw("(estado = 'Atendido' or estado = 'Confirmado')")
                    ->orderby('fecha', 'desc')
                    ->where('idtrabajador', '=', $idtrabajador)
                    ->get();
            }
        }

        $meseros = Trabajador::where('idcargo', '=', '2')->where('estado', '=', '1')->get();
        return view('cajero.index', compact('plantilla', 'pedidos', 'idtrabajador', 'meseros'));
    }
}
