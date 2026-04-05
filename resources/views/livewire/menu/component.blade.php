<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="bg-amber-600 text-white px-5 py-5 shadow-md">
        <h1 class="text-2xl font-bold tracking-wide">Nuestro Menú</h1>
        <p class="text-amber-100 text-sm mt-0.5">Selecciona una categoría para ver los platos</p>
    </div>

    {{-- Categorías --}}
    <div class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex gap-3 overflow-x-auto scrollbar-hide px-4 py-3">
            @foreach ($categorias as $cat)
                <button
                    wire:click="seleccionar({{ $cat->id }})"
                    class="flex-shrink-0 flex flex-col items-center gap-1 focus:outline-none">

                    {{-- Imagen o placeholder --}}
                    <div class="w-16 h-16 rounded-full overflow-hidden border-4 transition-all
                        {{ $categoriaActiva === $cat->id ? 'border-amber-500' : 'border-gray-200' }}">
                        @if ($cat->foto)
                            <img
                                src="{{ route('resol.img', $cat->foto) }}"
                                alt="{{ $cat->nombre }}"
                                class="category-img"
                                onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-amber-100 flex items-center justify-center\'><span class=\'text-2xl\'>🍽️</span></div>'">
                        @else
                            <div class="w-full h-full bg-amber-100 flex items-center justify-center">
                                <span class="text-2xl">🍽️</span>
                            </div>
                        @endif
                    </div>

                    <span class="text-xs font-semibold text-center leading-tight max-w-16 truncate
                        {{ $categoriaActiva === $cat->id ? 'text-amber-600' : 'text-gray-600' }}">
                        {{ $cat->nombre }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Productos --}}
    <div class="px-4 py-4">
        @if ($productos->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <div class="text-5xl mb-3">🍽️</div>
                <p>Sin productos disponibles.</p>
            </div>
        @else
            {{-- Título de categoría activa --}}
            @php $catActiva = $categorias->firstWhere('id', $categoriaActiva); @endphp
            @if ($catActiva)
                <h2 class="text-lg font-bold text-gray-800 mb-3">{{ $catActiva->nombre }}</h2>
            @endif

            <div class="flex flex-col gap-3">
                @foreach ($productos as $producto)
                    <div class="bg-white rounded-2xl shadow-sm flex overflow-hidden border border-gray-100">

                        {{-- Imagen del producto (placeholder con inicial) --}}
                        <div class="w-28 h-28 flex-shrink-0 bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                            <span class="text-white text-4xl font-bold">
                                {{ mb_substr($producto->nombre, 0, 1) }}
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="flex flex-col justify-center px-4 py-3 flex-1">
                            <p class="font-bold text-gray-800 leading-tight">{{ $producto->nombre }}</p>
                            <p class="text-amber-600 font-bold text-lg mt-1">
                                {{ config('resol.currency_symbol') }} {{ number_format($producto->precio, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="text-center text-gray-300 text-xs pb-8 pt-4">
        Los precios incluyen impuestos
    </div>

</div>
