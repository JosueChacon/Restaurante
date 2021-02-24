<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $primaryKey = 'idnota';
    protected $table = 'nota';
    public $timestamps = false;
    protected $fillable = [
        'idtrabajador',
        'fecha',
        'estado',
        'total',
    ];

    protected $dates = [
        'fecha',
    ];

    protected $casts = [
        'idtrabajador' => 'int',
        'estado' => 'int',
        'total' => 'float'
    ];

    public function Trabajador()
    {
        return $this->hasOne('App\Trabajador', 'idtrabajador', 'idtrabajador');
    }

    public function DNota()
    {
        return $this->hasMany('App\DNota', 'idnota', 'idnota');
    }
}
