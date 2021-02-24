<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPlato extends Model
{
    //
    public $timestamps=false;
    protected $fillable = [
        'descripcion', 'foto'
    ];

    public function getRutaFoto(){
        if ($this->foto)
            return '/img/img-tipoplato/'.$this->foto;
        return 'img/img.png';
    }  
}
