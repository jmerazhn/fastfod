<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Menu extends Component
{
    public ?int $categoriaActiva = null;

    public function mount()
    {
        $this->categoriaActiva = Category::orderBy('nombre')->value('id');
    }

    public function seleccionar(int $id)
    {
        $this->categoriaActiva = $id;
    }

    public function render()
    {
        $categorias = Category::orderBy('nombre')->get();

        $productos = $this->categoriaActiva
            ? Product::where('categoria_id', $this->categoriaActiva)
                     ->orderBy('nombre')
                     ->get()
            : collect();

        return view('livewire.menu.component', compact('categorias', 'productos'))
            ->layout('layouts.menu');
    }
}
