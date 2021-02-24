<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='reserva_id';
    protected $table='reserva';
    protected $fillable = [
        'mesa_id', 'idcliente', 'fecha', 'estado','estado_delete', 'idpedido'
    ];

    public function Mesa(){
        return $this->hasOne('App\Mesa', 'mesa_id', 'mesa_id');
    }

    public function Cliente(){
        return $this->hasOne('App\Cliente', 'idcliente', 'idcliente');
    }

    public function Pedido(){
        return $this->hasOne('App\Pedido', 'idpedido', 'idpedido');
    }

    protected $dates = [
        'fecha',
    ];

    public function formato($val){
        if ($val<10) return "000000000".$val;
        else if ($val<100) return "00000000".$val;   
        else if ($val<1000) return "0000000".$val;   
        else if ($val<10000) return "000000".$val;   
        else if ($val<100000) return "00000".$val;   
        else if ($val<1000000) return "0000".$val; 
        else if ($val<10000000) return "000".$val;   
        else if ($val<100000000) return "00".$val;   
        else if ($val<1000000000) return "0".$val;  
        else return "".$val;    
    }
}
