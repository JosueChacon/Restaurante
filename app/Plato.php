<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    //
    public $timestamps=false;
    protected $fillable = [
        'nombre', 'idtipoplato', 'p_costo', 'p_venta', 'foto',
    ];

    public function tipoplato()
    {
        return $this->hasOne('App\TipoPlato','id','idtipoplato');
    }

    public function getRutaFoto(){
        if ($this->foto)
            return '/img/img-plato/'.$this->foto;
        return 'img/img.png';
    }
}
