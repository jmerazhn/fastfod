<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    use HasFactory;

    protected $table = 'comandas';

    protected $fillable = [
        'mesa_id',
        'mesero_id',
        'producto_id',
        'cantidad',
        'precio',
        'descuento',
        'orden',
        'cambios',
        'impresa',
        'estatus',
    ];

    // Solo created_at, sin updated_at
    const UPDATED_AT = null;

    // relationships
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }

    public function mesero()
    {
        return $this->belongsTo(User::class, 'mesero_id');
    }

    public function producto()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
