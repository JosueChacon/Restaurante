<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='idcargo';
    protected $table='cargos';
    protected $fillable = [
        'descripcion'
    ];    
}
