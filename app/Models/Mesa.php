<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';

    protected $fillable = ['numero', 'lugar'];

    public $timestamps = false;

    // relationships
    public function comandas()
    {
        return $this->hasMany(Comanda::class, 'mesa_id');
    }

    public function comandasAbiertas()
    {
        return $this->hasMany(Comanda::class, 'mesa_id')
                    ->where('estatus', 'Pendiente');
    }
}
