<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='tipo_id';
    protected $table='tipo';
    protected $fillable = [
        'descripcion',
    ];    
}
