<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\Recibo;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function imprimirRecibo($idrecibo)
    {
        $recibo = Recibo::findorfail($idrecibo);
        $persona = auth()->user()->Persona;
        if ($persona->Cliente != null) {
            //Recibo por cliente
            if ($persona->Cliente->idcliente == $recibo->idcliente) {
                $pdf = PDF::loadView('reportes.ImprimirRecibo', compact('recibo'));
                $pdf->setpaper([0, 0, 200, 450]);
                return $pdf->stream('Recibo-' . $recibo->nrorecibo . '.pdf');
            } else {
                return redirect()->route('home')->with('error', 'El recibo no le pertenece');
            }
        } else if ($persona->Trabajador != null) {
            //Recibo por trabajador
            $pdf = PDF::loadView('reportes.ImprimirRecibo', compact('recibo'));
            $pdf->setpaper([0, 0, 200, 450]);
            return $pdf->stream('Recibo-' . $recibo->nrorecibo . '.pdf');
        }
    }

    public function imprimirPedido($idpedido)
    {
        $pedido = Pedido::findorfail($idpedido);
        $persona = auth()->user()->Persona;
        $cont = 1;
        if ($persona->Trabajador != null) {
            $pdf = PDF::loadView('reportes.pedido', compact('pedido', 'cont'));
            return $pdf->stream('Pedido-' . $pedido->formato($pedido->idpedido) . '.pdf');
        } else if ($persona->Cliente->idcliente == $pedido->idcliente) {
            $pdf = PDF::loadView('reportes.pedido', compact('pedido', 'cont'));
            return $pdf->stream('Pedido-' . $pedido->formato($pedido->idpedido) . '.pdf');
        }
        return redirect()->route('home')->with('error', 'El pedido no le pertenece');
    }

    public function imprimirtVentasDiarias()
    {
        $persona = auth()->user()->Persona;
        $cont = 1;
        if ($persona->Cliente != null) {
            return redirect()->route('home')->with('error', 'No tiene acceso a esta función');
        }
        $now = date('Y-m-d');
        $recibos_x_t = Recibo::where('estado', '=', '1')
            ->where('idtrabajador', '=', $persona->Trabajador->idtrabajador)
            ->whereRaw('date(fecha)=' . "'$now'")
            ->get();
        $total = 0;
        $efectivo = 0;
        $tarjeta = 0;
        foreach ($recibos_x_t as $item) {
            $total += $item->total;
            $efectivo += $item->efectivo;
            $tarjeta += $item->tarjeta;
        }
        $pdf = PDF::loadView('reportes.ImprimirVentasDiarias', compact('recibos_x_t', 'cont', 'total', 'efectivo', 'tarjeta'));        
        $pdf->setpaper([0, 0, 200, 450]);
        return $pdf->stream('Ventas-de-' . $now . '.pdf');
    }

    public function imprimirVentasTotalesDiarias()
    {
        $persona = auth()->user()->Persona;
        if ($persona->Trabajador != null) {
            if ($persona->Trabajador->Cargo->descripcion == 'ADMINISTRADOR') {
                $now = date('Y-m-d');
                $recibos_x_t = Recibo::where('estado', '=', '1')
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
                $pdf = PDF::loadView('reportes.ImprimirVentasDiarias', compact('recibos_x_t', 'total', 'efectivo', 'tarjeta'));
                $pdf->setpaper([0, 0, 200, 450]);
                return $pdf->stream('Ventas-de-' . $now . '.pdf');
            }
        }
        return redirect()->route('home')->with('error', 'No tiene acceso a esta función');
    }
}
