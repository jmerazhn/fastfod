<div>
    <!-- Encabezado mesa -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Mesa {{ $mesa->numero }}</h2>
            <p class="text-sm text-gray-500">{{ $mesa->lugar }}</p>
        </div>
        <a href="{{ route('mesas') }}" class="text-blue-600 text-sm hover:underline">← Mesas</a>
    </div>

    @if($notificacion)
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-medium {{ str_contains($notificacion, 'correctamente') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ $notificacion }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Panel categorías / productos -->
        <div class="lg:col-span-2">
            <div class="flex flex-wrap gap-2 mb-4">
                @foreach($categorias as $cat)
                    <button wire:click="seleccionarCategoria({{ $cat->id }})"
                            class="px-4 py-2 rounded-full text-sm font-semibold border transition {{ $categoriaActiva == $cat->id ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:border-blue-400' }}">
                        {{ $cat->nombre }}
                    </button>
                @endforeach
            </div>

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

        <!-- Panel derecho -->
        <div class="flex flex-col gap-4">

            <!-- Comanda ya enviada -->
            @if($comandaAbierta->isNotEmpty())
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
                        Enviado a cocina
                    </h3>
                    <button wire:click="reimprimir"
                            wire:loading.attr="disabled"
                            wire:target="reimprimir"
                            class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium px-3 py-1 rounded-lg flex items-center gap-1">
                        <span wire:loading.remove wire:target="reimprimir">🖨 Reimprimir</span>
                        <span wire:loading wire:target="reimprimir">Imprimiendo...</span>
                    </button>
                </div>
                <div class="space-y-1">
                    @foreach($comandaAbierta as $linea)
                        <div wire:key="comanda-{{ $linea->id }}"
                             x-data="{ editando: false, cantidad: {{ $linea->cantidad }}, cambios: @js($linea->cambios ?? '') }"
                             class="py-2 border-b border-gray-100 last:border-0">

                            {{-- Vista normal --}}
                            <div x-show="!editando" class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm text-gray-800">{{ $linea->orden }}</span>
                                    @if($linea->cambios)
                                        <p class="text-xs text-amber-600 italic">{{ $linea->cambios }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 ml-2 shrink-0">
                                    <span class="text-sm font-semibold text-gray-600">× {{ $linea->cantidad }}</span>
                                    <button @click="editando = true"
                                            class="text-xs text-blue-500 hover:text-blue-700 px-1">✏️</button>
                                    <button @click="confirmarEliminarLinea({{ $linea->id }}, '{{ addslashes($linea->orden) }}')"
                                            class="text-xs text-red-400 hover:text-red-600 px-1">✕</button>
                                </div>
                            </div>

                            {{-- Modo edición --}}
                            <div x-show="editando" style="display:none" class="space-y-2">
                                <span class="text-sm font-medium text-gray-800">{{ $linea->orden }}</span>
                                <div class="flex items-center gap-2">
                                    <label class="text-xs text-gray-500">Cant.</label>
                                    <button @click="cantidad = Math.max(1, cantidad - 1)"
                                            class="w-7 h-7 rounded-full bg-gray-200 text-gray-700 font-bold text-sm flex items-center justify-center">−</button>
                                    <input x-model.number="cantidad" type="number" min="1"
                                           class="w-12 text-center text-sm border border-gray-300 rounded-lg py-1 focus:outline-none focus:ring-1 focus:ring-blue-400">
                                    <button @click="cantidad++"
                                            class="w-7 h-7 rounded-full bg-gray-200 text-gray-700 font-bold text-sm flex items-center justify-center">+</button>
                                </div>
                                <input x-model="cambios" type="text" placeholder="Indicaciones..."
                                       class="w-full text-xs border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400">
                                <div class="flex gap-2">
                                    <button @click="@this.guardarEdicion({{ $linea->id }}, cantidad, cambios); editando = false"
                                            class="flex-1 text-xs bg-blue-600 hover:bg-blue-700 text-white py-1 rounded-lg">
                                        Guardar
                                    </button>
                                    <button @click="editando = false"
                                            class="flex-1 text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 py-1 rounded-lg">
                                        Cancelar
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Carrito (nuevos productos) -->
            <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                <h3 class="font-bold text-gray-700 mb-3 text-lg">
                    {{ $comandaAbierta->isNotEmpty() ? 'Agregar más' : 'Comanda' }}
                </h3>

                <div class="flex-1 overflow-y-auto space-y-2 mb-4">
                    @forelse($contentCart as $item)
                        <div wire:key="cart-{{ $item->id }}"
                             x-data="{ abierto: @js(!empty($item->changes)) }"
                             class="bg-gray-50 rounded-lg px-3 py-2">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <button @click="abierto = !abierto"
                                            class="text-sm font-medium text-gray-800 text-left w-full hover:text-blue-600">
                                        {{ $item->name }}
                                    </button>
                                    <p class="text-xs text-gray-500">{{ $currency }}{{ number_format($item->price, 2) }} c/u</p>
                                    @if($item->changes)
                                        <p class="text-xs text-amber-600 italic">{{ $item->changes }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1 ml-2">
                                    <button wire:click="disminuir({{ $item->id }})"
                                            class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-sm flex items-center justify-center">−</button>
                                    <span class="w-6 text-center font-semibold text-sm">{{ $item->qty }}</span>
                                    <button wire:click="aumentar({{ $item->id }})"
                                            class="w-7 h-7 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold text-sm flex items-center justify-center">+</button>
                                    <button wire:click="quitar({{ $item->id }})"
                                            class="w-7 h-7 rounded-full bg-red-100 hover:bg-red-200 text-red-600 font-bold text-sm flex items-center justify-center ml-1">×</button>
                                </div>
                            </div>
                            <div x-show="abierto" x-transition class="mt-2 flex gap-2">
                                <input wire:model="notas.{{ $item->id }}"
                                       type="text"
                                       placeholder="Indicaciones especiales..."
                                       class="flex-1 text-xs border border-gray-300 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400">
                                <button wire:click="guardarNota({{ $item->id }})"
                                        @click="abierto = false"
                                        class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-lg">
                                    OK
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm text-center py-4">Sin productos</p>
                    @endforelse
                </div>

                <div class="border-t pt-3">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>Artículos</span>
                        <span>{{ $itemsCart }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-gray-800 mb-4">
                        <span>Total</span>
                        <span>{{ $currency }}{{ number_format($totalCart, 2) }}</span>
                    </div>

                    <button wire:click="enviarComanda"
                            wire:loading.attr="disabled"
                            class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white font-bold py-3 rounded-xl transition">
                        <span wire:loading.remove wire:target="enviarComanda">Enviar Comanda</span>
                        <span wire:loading wire:target="enviarComanda">Enviando...</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal ticket (visible en pantalla, oculto al imprimir) --}}
    @if($mostrarTicket)
    <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 print:hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6">
            <h3 class="text-center font-bold text-gray-800 text-lg mb-1">Comanda enviada</h3>
            <p class="text-center text-sm text-gray-500 mb-4">Mesa {{ $mesa->numero }} · {{ auth()->user()->nombre }}</p>

            <div class="border-t border-dashed border-gray-300 pt-3 space-y-2 mb-3">
                @foreach($ticketItems as $linea)
                    <div class="flex justify-between text-sm">
                        <div class="flex-1">
                            <span class="font-medium text-gray-800">{{ $linea['cantidad'] }}× {{ $linea['nombre'] }}</span>
                            @if(!empty($linea['cambios']))
                                <p class="text-xs text-amber-600 italic">{{ $linea['cambios'] }}</p>
                            @endif
                        </div>
                        <span class="text-gray-600 ml-2">{{ $currency }}{{ number_format($linea['precio'] * $linea['cantidad'], 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-dashed border-gray-300 pt-3 flex justify-between font-bold text-gray-800 mb-5">
                <span>Total</span>
                <span>{{ $currency }}{{ number_format(collect($ticketItems)->sum(fn($l) => $l['precio'] * $l['cantidad']), 2) }}</span>
            </div>

            <div class="flex gap-3">
                <button onclick="window.print()"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl text-sm">
                    🖨 Imprimir
                </button>
                <button wire:click="cerrarTicket"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 rounded-xl text-sm">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    {{-- Contenido solo para impresión --}}
    <div class="hidden print:block font-mono text-xs text-black p-4">
        <p class="text-center font-bold text-base mb-1">{{ config('app.name') }}</p>
        <p class="text-center mb-1">Mesa {{ $mesa->numero }}</p>
        <p class="text-center mb-1">Mesero: {{ auth()->user()->nombre }}</p>
        <p class="text-center mb-3">{{ now()->format('d/m/Y H:i') }}</p>
        <p class="border-t border-dashed border-black mb-2"></p>
        @foreach($ticketItems as $linea)
            <div class="mb-1">
                <span>{{ $linea['cantidad'] }}x {{ $linea['nombre'] }}</span>
                <span class="float-right">{{ $currency }}{{ number_format($linea['precio'] * $linea['cantidad'], 2) }}</span>
                @if(!empty($linea['cambios']))
                    <br><span class="pl-4 italic">* {{ $linea['cambios'] }}</span>
                @endif
            </div>
        @endforeach
        <p class="border-t border-dashed border-black mt-2 mb-1"></p>
        <div class="flex justify-between font-bold">
            <span>TOTAL</span>
            <span>{{ $currency }}{{ number_format(collect($ticketItems)->sum(fn($l) => $l['precio'] * $l['cantidad']), 2) }}</span>
        </div>
    </div>
    @endif

    <script>
        function confirmarEliminarLinea(id, nombre) {
            swal({
                title: '¿Eliminar producto?',
                text: nombre,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    @this.eliminarLinea(id)
                }
            })
        }
    </script>

</div>
