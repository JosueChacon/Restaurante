<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DPedido extends Model
{
    //
    public $timestamps = false;
    protected $table = 'd_pedido';
    protected $fillable = [
        'idpedido', 'idplato', 'p_venta', 'cantidad', 'nombre_tabla', 'estado'
    ];

    public function plato()
    {
        return $this->hasOne('App\Plato', 'id', 'idplato');
    }

    public function Plato_Prod()
    {
        if ($this->nombre_tabla == 'platos') {
            return $this->hasOne('App\Plato', 'id', 'idplato');
        } else {
            return $this->hasOne('App\Producto', 'id', 'idplato');
        }
    }

    public function TipoCat()
    {
        if ($this->nombre_tabla == 'platos') {
            $plato = Plato::findorfail($this->idplato);
            return $plato->tipoplato['descripcion'];
        } else {
            $producto = Producto::findorfail($this->idplato);
            return $producto->Categoria['descripcion'];
        }
    }
}
