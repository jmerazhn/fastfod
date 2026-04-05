<?php

namespace App\Http\Livewire;

use App\Models\Mesa;
use Livewire\Component;

class Mesas extends Component
{
    public function render()
    {
        $mesas = Mesa::with('comandasAbiertas')->orderBy('numero')->get();

        return view('livewire.mesas.component', compact('mesas'))
            ->layout('layouts.mesero');
    }
}
