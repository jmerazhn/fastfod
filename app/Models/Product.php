<?php

namespace App\Models;

use App\Traits\CartTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use CartTrait;

    protected $table = 'productos';

    protected $fillable = ['nombre', 'precio', 'costo', 'categoria_id', 'icono', 'inventario', 'stock'];

    public $timestamps = false;

    // Para que toArray() incluya los acesores que usa Cart::validate()
    protected $appends = ['name', 'price', 'livestock'];

    // relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    // Accesores para compatibilidad con CartTrait y vistas
    public function getNameAttribute()
    {
        return $this->nombre;
    }

    public function getPriceAttribute()
    {
        return $this->precio;
    }

    public function getLiveStockAttribute()
    {
        if (!$this->inventario) return 999;
        $stockCart = $this->countInCart($this->id);
        return $this->stock - $stockCart;
    }
}
