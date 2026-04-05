<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div style="background:#d97706;color:#fff;padding:20px;box-shadow:0 2px 4px rgba(0,0,0,0.2)">
        <h1 style="font-size:1.4rem;font-weight:700;margin:0">Nuestro Menú</h1>
        <p style="font-size:0.8rem;margin:4px 0 0;opacity:0.85">Selecciona una categoría para ver los platos</p>
    </div>

    {{-- Categorías --}}
    <div style="background:#fff;box-shadow:0 1px 3px rgba(0,0,0,0.1);position:sticky;top:0;z-index:10">
        <div class="flex gap-3 overflow-x-auto scrollbar-hide" style="padding:12px 16px">
            @foreach ($categorias as $cat)
                <button
                    wire:click="seleccionar({{ $cat->id }})"
                    class="flex-shrink-0 flex flex-col items-center gap-1 focus:outline-none">

                    <div style="width:64px;height:64px;border-radius:50%;overflow:hidden;border:4px solid {{ $categoriaActiva === $cat->id ? '#d97706' : '#e5e7eb' }}">
                        @if ($cat->foto)
                            <img
                                src="{{ route('resol.img', $cat->foto) }}"
                                alt="{{ $cat->nombre }}"
                                style="width:100%;height:100%;object-fit:cover"
                                onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-size:1.5rem\'>🍽️</div>'">
                        @else
                            <div style="width:100%;height:100%;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-size:1.5rem">🍽️</div>
                        @endif
                    </div>

                    <span style="font-size:0.7rem;font-weight:600;color:{{ $categoriaActiva === $cat->id ? '#d97706' : '#6b7280' }};max-width:64px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                        {{ $cat->nombre }}
                    </span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Productos --}}
    <div style="padding:16px">
        @if ($productos->isEmpty())
            <div style="text-align:center;padding:60px 0;color:#9ca3af">
                <div style="font-size:3rem;margin-bottom:12px">🍽️</div>
                <p>Sin productos disponibles.</p>
            </div>
        @else
            @php $catActiva = $categorias->firstWhere('id', $categoriaActiva); @endphp
            @if ($catActiva)
                <h2 style="font-size:1.1rem;font-weight:700;color:#1f2937;margin-bottom:12px">{{ $catActiva->nombre }}</h2>
            @endif

            <div class="flex flex-col gap-3">
                @foreach ($productos as $producto)
                    <div style="background:#fff;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.08);display:flex;overflow:hidden;border:1px solid #f3f4f6">

                        <div style="width:110px;min-height:110px;flex-shrink:0;background:linear-gradient(135deg,#f59e0b,#ea580c);display:flex;align-items:center;justify-content:center">
                            <span style="color:#fff;font-size:2.5rem;font-weight:700">
                                {{ mb_substr($producto->nombre, 0, 1) }}
                            </span>
                        </div>

                        <div style="display:flex;flex-direction:column;justify-content:center;padding:12px 16px;flex:1">
                            <p style="font-weight:700;color:#1f2937;line-height:1.3;margin:0">{{ $producto->nombre }}</p>
                            <p style="color:#d97706;font-weight:700;font-size:1.1rem;margin:6px 0 0">
                                {{ config('resol.currency_symbol') }} {{ number_format($producto->precio, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div style="text-align:center;color:#d1d5db;font-size:0.75rem;padding:24px 0">
        Los precios incluyen impuestos
    </div>

</div>
