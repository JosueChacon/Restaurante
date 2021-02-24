<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DProgramacion extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'idprogramacion', 'idplato', 'stock', 'estado',
    ];

    public function plato()
    {
        return $this->hasOne('App\Plato', 'id', 'idplato');
    }

    public static function DescontarStock($idprogramacion, $idplato, $cantidad)
    {
        DB::update(
            'update d_programacions set stock = stock - ? where idprogramacion = ? and idplato = ?',
            [$cantidad, $idprogramacion, $idplato]
        );
    }

    public static function AumentarStock($idprogramacion, $idplato, $cantidad)
    {
        DB::update(
            'update d_programacions set stock = stock + ? where idprogramacion = ? and idplato = ?',
            [$cantidad, $idprogramacion, $idplato]
        );
    }
}
