<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Parametro extends Model
{
    //
    public $timestamps=false;
    protected $primaryKey='tipo_id';
    protected $table='parametros';
    protected $fillable = [
        'serie', 'numeracion',
    ];

    public function Tipo(){
        return $this->hasOne('App\Tipo','tipo_id');
    }

    public static function ActualizarNumero($tipo_id, $numeracion){ 
        try{ DB::table('parametros')
            ->where('tipo_id', '=', $tipo_id)
            ->update([ 'numeracion' => $numeracion]); 
            return true; 
        }
        catch(Exception $ex){
             return false;
        }
    }

    public static function formato($val){
        if ($val<10) return "0000".$val;
        else if ($val<100) return "000".$val;
        else if ($val<1000) return "00".$val;
        else if ($val<10000) return "0".$val;
        else return $val;        
    }
}
