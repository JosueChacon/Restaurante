<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;

class CPedidoController extends Controller
{
    public function listaConfirmados()
    {
        $now = date('Y-m-d');
        $pedidos = Pedido::where('estado_delete', '=', '1')
            ->where('estado', '=', 'Confirmado')
            ->whereRaw('date(fecha) =' . "'$now'")
            ->paginate(8);
        return view('cocinero.atencion.listaConfirmados', compact('pedidos'));
    }

    public function mostrarPedido($id)
    {
        $pedido = pedido::findorfail($id);
        $detalles = $pedido->DPedido()->get();
        return view('cocinero.atencion.mostrarPedido', compact('pedido', 'detalles'));
    }

    public function atender($id)
    {
        // return "holA";
        $pedido = pedido::findorfail($id);
        $pedido->estado = 'Atendido';
        $pedido->save();
        $mesa = $pedido->Reserva->Mesa;
        return redirect()->route('home.listaConfirmados')->with('datos', 'El pedido de la MESA ' . $mesa['nromesa'] . ' fue atendido.');
    }
}
