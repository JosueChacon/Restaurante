<?php

namespace App;

use App\Cliente;
use App\Trabajador;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    public $timestamps = false;
    protected $primaryKey = 'idpersona';
    protected $fillable = [
        'nombres', 'apellidos', 'direccion', 'celular', 'estado',
    ];

    public function Trabajador()
    {
        return $this->belongsTo('App\Trabajador', 'idpersona', 'idpersona');
    }

    public function Cliente()
    {
        return $this->belongsTo('App\Cliente', 'idpersona', 'idpersona');
    }
    public function nombrecompleto($persona)
    {
        return $persona->nombres . ' ' . $persona->apellidos;
    }
    public function User()
    {
        return $this->belongsTo('App\User', 'idpersona', 'idpersona');
    }

    //
    public function nombres_apellidos()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
