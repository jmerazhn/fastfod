<div wire:poll.10s>
    <h2 class="text-xl font-bold text-gray-700 mb-4">Selecciona una Mesa</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach($mesas as $mesa)
            @php $ocupada = $mesa->comandasAbiertas->count() > 0; @endphp
            <a href="{{ route('comanda', $mesa->id) }}"
               class="{{ $ocupada ? 'bg-orange-400 text-white' : 'bg-white text-gray-800' }} block rounded-xl shadow p-5 text-center transition hover:scale-105">
                <div class="text-4xl font-bold mb-1">{{ $mesa->numero }}</div>
                <div class="text-sm font-medium">{{ $mesa->lugar }}</div>
                @if($ocupada)
                    <div class="text-xs mt-1 opacity-80">{{ $mesa->comandasAbiertas->count() }} producto(s)</div>
                @else
                    <div class="text-xs mt-1 opacity-60">Libre</div>
                @endif
            </a>
        @endforeach
    </div>
</div>
