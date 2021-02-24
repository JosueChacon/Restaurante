<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Persona;

class Trabajador extends Model
{
    //    
    protected $table='trabajadores';
    protected $primaryKey='idtrabajador';
    public $timestamps=false;
    protected $fillable = [
        'idpersona','idcargo',
    ];

    public function Persona(){
        return $this->hasOne('App\Persona','idpersona','idpersona');
    }
    public function Cargo(){
        return $this->hasOne('App\Cargo','idcargo','idcargo');
    }
}
