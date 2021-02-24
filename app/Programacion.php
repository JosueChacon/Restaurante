<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DProgramacion;

class Programacion extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='idprogramacion';
    protected $fillable = [
        'fecha', 'idtrabajador','estado'
    ];
    
    protected $dates = [
        'fecha',
    ];

    public function Trabajador(){
        return $this->hasOne('App\Trabajador', 'idtrabajador', 'idtrabajador');
    }
    
    public function DProgramacion(){
        return $this->hasMany('App\DProgramacion','idprogramacion')->where('estado','=','1');
    }    

    public function DProgramacion_buscar($buscarpor, $idprogramacion){      
        $detalles = DProgramacion::join('platos','d_programacions.idplato','=','platos.id')
            ->where('platos.nombre', 'like','%'.$buscarpor.'%')          
            ->where('d_programacions.idprogramacion','=',$idprogramacion)
            ->get();
        return $detalles;
    }
}
