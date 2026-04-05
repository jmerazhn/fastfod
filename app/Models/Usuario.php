<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'correo', 'clave', 'perfil', 'estatus', 'foto', 'permisos'];

    protected $hidden = ['clave', 'remember_token'];

    public function getAuthPasswordName()
    {
        return 'clave';
    }

    public function getAuthPassword()
    {
        return $this->clave;
    }
}
