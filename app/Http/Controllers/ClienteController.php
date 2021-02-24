<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Pedido;
use App\DPedido;
use App\Plato;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('trabajador', ['only' => ['mostrarclientes', 'pedidosxclientes']]);
    }

    public function mostrarclientes(Request $request)
    {
        $buscarpor = $request->buscarpor;

        $clientes = cliente::join('personas', 'clientes.idpersona', '=', 'personas.idpersona')
            ->where('clientes.estado', '=', '1')
            ->where('personas.apellidos', 'like', '%' . $buscarpor . '%')
            ->paginate(5);

        return view('trabajador.consultas.clientes', compact('clientes', 'buscarpor'));
    }

    public function pedidosxclientes($id)
    {
        $cliente = Cliente::findorfail($id);
        return view('trabajador.consultas.pedidosxclientes.pedidos', compact('cliente'));
    }

    public function PedidoCodigo($id)
    {
        //#, nombre, tipo_plato, pventa, cantidad, subtotal  
        $pedido = Pedido::findorfail($id);  
        $detalles = $pedido->DPedido;
        $data = [];
        foreach ($detalles as $row) {
            $det = [
                'nombre' => $row->Plato_Prod->nombre,
                'descripcion' => $row->TipoCat(),
                'p_venta' => $row->p_venta,
                'cantidad' => $row->cantidad,
            ];
            array_push($data, $det);
        }
        return $data;
    }
}
