<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'producto';
    protected $fillable = [
        'nombre', 'idcategoria', 'p_costo', 'p_venta', 'foto', 'stock', 'estado'
    ];

    protected $casts = [
        'nombre' => 'string',
        'p_costo' => 'float',
        'p_venta' => 'float',
        'foto' => 'string',
        'stock' => 'int',
        'estado' => 'int',
    ];

    public function Categoria()
    {
        return $this->hasOne('App\Categoria', 'idcategoria', 'idcategoria');
    }

    public static function DescontarStock($idproducto, $cantidad)
    {
        DB::update(
            'update producto set stock = stock - ? where id = ?',
            [$cantidad, $idproducto]
        );
    }

    public static function AumentarStock($idproducto, $cantidad, $p_costo)
    {
        DB::update(
            'update producto set stock = stock + ?, p_costo = ? where id = ?',
            [$cantidad, $p_costo, $idproducto]
        );
    }

    public static function AumentarSoloStock($idproducto, $cantidad)
    {
        DB::update(
            'update producto set stock = stock + ? where id = ?',
            [$cantidad, $idproducto]
        );
    }
}
