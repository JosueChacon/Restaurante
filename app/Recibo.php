<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'idrecibo';
    protected $table = 'recibo';
    protected $fillable = [
        'nrorecibo', 'fecha', 'tipo_id', 'idcliente', 'idtrabajador', 'total', 'idtipopago'
    ];

    protected $dates = [
        'fecha',
    ];

    public function Cliente()
    {
        return $this->hasOne('App\Cliente', 'idcliente', 'idcliente');
    }
    public function Trabajador()
    {
        return $this->hasOne('App\Trabajador', 'idtrabajador', 'idtrabajador');
    }
    public function DRecibo()
    {
        return $this->hasMany('App\DRecibo', 'idrecibo', 'idrecibo');
    }
    public function Tipo()
    {
        return $this->hasOne('App\Tipo', 'tipo_id', 'tipo_id');
    }
    public static function Total($recibos)
    {
        $total = 0;
        foreach ($recibos as $item) {
            $total += $item->total;
        }
        return $total;
    }
    public function TipoPago()
    {
        return $this->hasOne('App\TipoPago', 'idtipopago', 'idtipopago');
    }
}
