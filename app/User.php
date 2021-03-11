<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'idtipousuario', 'idpersona', 'foto',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRutaFoto()
    {
        if ($this->foto)
            return '/img/foto-user/' . $this->foto;
        return 'img/foto-user/user.png';
    }

    public function TipoUsuario()
    {
        return $this->hasOne('App\TipoUsuario', 'idtipousuario', 'idtipousuario');
    }

    public function Persona()
    {
        return $this->hasOne('App\Persona', 'idpersona', 'idpersona');
    } 

    public function Caja()
    {
        return $this->hasOne('App\Caja', 'id', 'id');
    }
}
