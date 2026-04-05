<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'correo', 'clave', 'perfil', 'estatus', 'foto'];

    protected $hidden = ['clave', 'remember_token'];

    // Laravel Auth usa estos métodos para identificar el campo de contraseña
    public function getAuthPasswordName()
    {
        return 'clave';
    }

    public function getAuthPassword()
    {
        return $this->clave;
    }

    // relationships
    public function comandas()
    {
        return $this->hasMany(Comanda::class, 'mesero_id');
    }
}
