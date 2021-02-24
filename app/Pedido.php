<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'idpedido';
    protected $fillable = [
        'idcliente', 'fecha', 'estado', 'estado_delete', 'idtrabajador',
    ];

    protected $dates = [
        'fecha',
    ];

    public function DPedido()
    {
        return $this->hasMany('App\DPedido', 'idpedido')->where('estado_delete', '=', '1');
    }

    public function DPedidoPendiente()
    {
        return $this->hasMany('App\DPedido', 'idpedido')->where('estado_delete', '=', '1')
            ->where('estado', '=', 'pendiente');
    }

    public function Total($detalles)
    {
        $total = 0;
        foreach ($detalles as $item) {
            $total += $item->p_venta * $item->cantidad;
        }
        return $total;
    }

    public function Cliente()
    {
        return $this->belongsTo('App\Cliente', 'idcliente', 'idcliente');
    }

    public function formato($val)
    {
        if ($val < 10) return "000000000" . $val;
        else if ($val < 100) return "00000000" . $val;
        else if ($val < 1000) return "0000000" . $val;
        else if ($val < 10000) return "000000" . $val;
        else if ($val < 100000) return "00000" . $val;
        else if ($val < 1000000) return "0000" . $val;
        else if ($val < 10000000) return "000" . $val;
        else if ($val < 100000000) return "00" . $val;
        else if ($val < 1000000000) return "0" . $val;
        else return "" . $val;
    }

    public function Reserva()
    {
        return $this->belongsTo('App\Reserva', 'idpedido', 'idpedido');
    }

    public function Trabajador()
    {
        return $this->hasOne('App\Trabajador', 'idtrabajador', 'idtrabajador');
    }
}
