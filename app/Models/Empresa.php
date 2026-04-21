<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';

    public $timestamps = false;

    // Dirección compuesta de los campos disponibles
    public function getDireccionAttribute(): string
    {
        return collect([
            $this->calle,
            $this->numext ? "#{$this->numext}" : null,
            $this->colonia,
            $this->ciudad,
            $this->estado,
        ])->filter()->implode(', ');
    }
}
