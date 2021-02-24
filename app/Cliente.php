<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='idcliente';
    protected $table='clientes';
    protected $fillable = [
        'idpersona', 'estado',
    ];

    public function Persona(){
        return $this->hasOne('App\Persona', 'idpersona', 'idpersona');
    } 

    public function Pedidos(){
        return $this->hasMany('App\Pedido', 'idcliente', 'idcliente')
            ->where('estado_delete','=','1')
            ->orderBy('fecha', 'DESC');        
    }
    public function nombrecompleto($cliente){
        return $cliente->Persona->nombres.' '.$cliente->Persona->apellidos;
    }    
}
