<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $primaryKey = 'idcaja';
    protected $table = 'caja';
    public $timestamps = false;
    protected $fillable = [        
        'id',
        'estado_delete'
    ];

    protected $casts = [       
        'id' => 'int',
        'estado_delete' => 'int'
    ];

    public function Usuario()
    {
        return $this->hasOne('App\User', 'id', 'id');
    }
}
