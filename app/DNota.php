<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DNota extends Model
{
    protected $table = 'd_nota';
    public $timestamps = false;
    protected $fillable = [
        'idnota',
        'idproducto',
        'correlativo',
        'cantidad',
        'p_costo',
    ];

    protected $casts = [        
        'idnota' => 'int',
        'idproducto' => 'int',
        'correlativo' => 'int',
        'cantidad' => 'int',
        'p_costo'=>'float'
    ];

    public function Producto()
    {
        return $this->hasOne('App\Producto', 'id', 'idproducto');
    }
}
