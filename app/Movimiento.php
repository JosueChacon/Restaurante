<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $primaryKey = 'idmovimiento';
    protected $table = 'movimientos';
    public $timestamps = false;
    protected $fillable = [
        'monto_inicio',
        'fecha_inicio',
        'monto_cierre',
        'fecha_cierre',
        'estado',
        'estado_delete',
        'idcaja',
        'id',
        'monto_tarjeta'
    ];

    protected $dates = [
        'fecha_inicio', 'fecha_cierre'
    ];

    protected $casts = [
        'monto_inicio' => 'float',
        'monto_cierre' => 'float',
        'estado' => 'string',
        'estado_delete' => 'int',
        'idcaja' => 'int',
        'id' => 'int',
        'monto_tarjeta'=>'float'
    ];

    public function Caja()
    {
        return $this->hasOne('App\Caja', 'idcaja', 'idcaja');
    }

    public function Usuario()
    {
        return $this->hasOne('App\User', 'id', 'id');
    }
}
