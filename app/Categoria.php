<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps=false;
    protected $primaryKey='idcategoria';
    protected $table='categoria';
    protected $fillable = [
        'descripcion', 'estado',
    ];
}
