<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = ['nombre', 'telefono', 'correo', 'razon_social', 'rfc'];

    // razon_social puede venir vacío; en ese caso mostramos el nombre
    public function getNombreDisplayAttribute(): string
    {
        return $this->razon_social ?: $this->nombre;
    }
}
