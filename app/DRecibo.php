<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DRecibo extends Model
{
    //
    public $timestamps=false;
    protected $table='d_recibo';
    protected $fillable = [
        'idrecibo', 'idpedido', 'monto',    
    ];

    public function Pedido(){
        return $this->hasOne('App\Pedido','idpedido','idpedido');
    }
}
