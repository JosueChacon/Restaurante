<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    //
    protected $table = 'mesa';
    protected $primaryKey = 'mesa_id';
    public $timestamps = false;
    protected $fillable = [
        'nromesa', 'estado'
    ];

    public function compruebaEstadoMesa($mesa_id)
    {
        $now = date('Y-m-d');
        $reserva = Reserva::whereRaw('date(fecha)=' . "'$now'")
            ->where('mesa_id', '=', $mesa_id)
            ->where('estado', '=', 'OCUPADA')
            ->first();

        if ($reserva != null)
            return "OCUPADA";
        else
            return "LIBRE";
    }

    public function PedidoActivo()
    {
        $reserva = Reserva::whereRaw('date(fecha)="' . date('Y-m-d') . '"')
            ->where('mesa_id', '=', $this->mesa_id)
            ->where('estado', '=', 'OCUPADA')
            ->first();
        if ($reserva != null)
            return $reserva->Pedido->idpedido;
        else
            return 0;
    }
}
