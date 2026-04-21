<div class="p-4"
     x-data="{}"
     @descargar-pdf.window="window.open($event.detail.url, '_blank')">

    {{-- ===== Datos del cliente ===== --}}
    <div class="bg-white rounded-xl shadow p-4 mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- Buscador de cliente --}}
            <div class="sm:col-span-2 lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Cliente</label>
                <div class="relative">
                    <div class="flex gap-2">
                        <input wire:model="busquedaCliente"
                               wire:focus="$set('mostrarSugerencias', true)"
                               type="text"
                               placeholder="Buscar por nombre o empresa..."
                               autocomplete="off"
                               class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @if($clienteNombre)
                            <button wire:click="limpiarCliente"
                                    class="px-2 text-gray-400 hover:text-red-500 transition"
                                    title="Quitar cliente">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>

                    {{-- Sugerencias --}}
                    @if($mostrarSugerencias && $sugerencias->isNotEmpty())
                        <div class="absolute z-50 left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg mt-1 max-h-48 overflow-y-auto">
                            @foreach($sugerencias as $cli)
                                <button wire:click="seleccionarCliente({{ $cli->id }})"
                                        class="w-full text-left px-4 py-2.5 hover:bg-blue-50 text-sm border-b last:border-0">
                                    <span class="font-medium text-gray-800">{{ $cli->nombre }}</span>
                                    @if($cli->razon_social)
                                        <span class="text-gray-400 ml-2">— {{ $cli->razon_social }}</span>
                                    @endif
                                    @if($cli->rfc)
                                        <span class="text-gray-400 ml-2 text-xs">RTN: {{ $cli->rfc }}</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @elseif($mostrarSugerencias && strlen($busquedaCliente) >= 2)
                        <div class="absolute z-50 left-0 right-0 bg-white border border-gray-200 rounded-xl shadow mt-1 px-4 py-2.5 text-sm text-gray-400">
                            No se encontraron clientes
                        </div>
                    @endif

                    {{-- Chip cliente seleccionado --}}
                    @if($clienteNombre)
                        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-0.5 text-xs text-gray-600 bg-blue-50 rounded-lg px-3 py-2">
                            <span class="font-semibold text-blue-700">{{ $clienteNombre }}</span>
                            @if($clienteEmpresa) <span>{{ $clienteEmpresa }}</span> @endif
                            @if($clienteRtn)     <span>RTN: {{ $clienteRtn }}</span> @endif
                            @if($clienteCorreo)  <span>{{ $clienteCorreo }}</span>  @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- N° cotización y validez --}}
            <div class="flex gap-3">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">N° Cotización</label>
                    <input wire:model.lazy="numeroCotizacion" type="text"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="w-24">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Validez (días)</label>
                    <input wire:model.lazy="validezDias" type="number" min="1"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

        </div>
    </div>

    {{-- ===== Cuerpo principal ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Panel categorías + productos --}}
        <div class="lg:col-span-2">

            {{-- Pills de categorías --}}
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($categorias as $cat)
                    <button wire:click="seleccionarCategoria({{ $cat->id }})"
                            class="px-4 py-2 rounded-full text-sm font-semibold border transition
                                   {{ $categoriaActiva == $cat->id
                                       ? 'bg-blue-600 text-white border-blue-600'
                                       : 'bg-white text-gray-700 border-gray-300 hover:border-blue-400' }}">
                        {{ $cat->nombre }}
                    </button>
                @endforeach
            </div>

            {{-- Grid de productos --}}
            @if($categoriaActiva)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @forelse($productsList as $product)
                        <button wire:click="agregarProducto({{ $product->id }})"
                                class="bg-white rounded-xl shadow p-4 text-left hover:shadow-md transition active:scale-95">
                            <div class="font-semibold text-gray-800 text-sm leading-tight">{{ $product->nombre }}</div>
                            <div class="text-blue-600 font-bold mt-1">{{ $currency }}{{ number_format($product->precio, 2) }}</div>
                        </button>
                    @empty
                        <p class="col-span-3 text-gray-500 text-sm text-center py-6">Sin productos en esta categoría</p>
                    @endforelse
                </div>
            @else
                <p class="text-gray-400 text-sm text-center py-8">Selecciona una categoría para ver los productos</p>
            @endif
        </div>

        {{-- Panel derecho: items + totales --}}
        <div class="flex flex-col gap-4">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h3 class="font-bold text-gray-700 mb-3 text-lg">Cotización</h3>

                {{-- Lista de ítems --}}
                <div class="flex-1 space-y-2 mb-4">
                    @forelse($items as $idx => $item)
                        <div wire:key="item-{{ $idx }}" class="bg-gray-50 rounded-lg px-3 py-2">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 leading-tight">{{ $item['nombre'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $currency }}{{ number_format($item['precio'], 2) }} c/u (sin ISV)</p>
                                </div>
                                <div class="flex items-center gap-1 ml-2">
                                    <button wire:click="cambiarCantidad({{ $idx }}, {{ $item['cantidad'] - 1 }})"
                                            class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm flex items-center justify-center">−</button>
                                    <span class="w-6 text-center font-semibold text-sm">{{ $item['cantidad'] }}</span>
                                    <button wire:click="cambiarCantidad({{ $idx }}, {{ $item['cantidad'] + 1 }})"
                                            class="w-7 h-7 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold text-sm flex items-center justify-center">+</button>
                                    <button wire:click="quitarItem({{ $idx }})"
                                            class="w-7 h-7 rounded-full bg-red-100 hover:bg-red-200 text-red-600 font-bold text-sm flex items-center justify-center ml-1">×</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm text-center py-4">Sin productos</p>
                    @endforelse
                </div>

                {{-- Notas --}}
                <div class="mb-3">
                    <textarea wire:model.lazy="notas" rows="2"
                              placeholder="Notas o condiciones..."
                              class="w-full text-xs border border-gray-300 rounded-lg px-3 py-2 resize-none focus:outline-none focus:ring-1 focus:ring-blue-400"></textarea>
                </div>

                {{-- Totales --}}
                <div class="border-t pt-3">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Subtotal</span>
                        <span>{{ $currency }}{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>ISV 15%</span>
                        <span>{{ $currency }}{{ number_format($isv, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-gray-800 mb-4">
                        <span>Total</span>
                        <span>{{ $currency }}{{ number_format($total, 2) }}</span>
                    </div>

                    <button wire:click="generarPdf"
                            wire:loading.attr="disabled"
                            @if(empty($items)) disabled @endif
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold py-3 rounded-xl transition">
                        <span wire:loading.remove wire:target="generarPdf">Generar PDF</span>
                        <span wire:loading wire:target="generarPdf">Generando...</span>
                    </button>

                    @if(!empty($items))
                        <button wire:click="limpiar"
                                class="w-full mt-2 text-sm text-gray-500 hover:text-red-500 py-1 transition">
                            Limpiar todo
                        </button>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
