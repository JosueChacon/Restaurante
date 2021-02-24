<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idtipopago';
    protected $table = 'tipopago';
    protected $fillable = [
        'descripcion',
    ];
}
