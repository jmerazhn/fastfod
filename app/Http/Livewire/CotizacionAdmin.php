<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Product;
use Livewire\Component;

class CotizacionAdmin extends Component
{
    // Datos del cliente
    public string $clienteNombre  = '';
    public string $clienteEmpresa = '';
    public string $clienteCorreo  = '';
    public string $clienteRtn     = '';
    public string $notas          = '';

    // Búsqueda de cliente
    public string $busquedaCliente  = '';
    public bool   $mostrarSugerencias = false;
    public int    $validezDias;

    // Selección de productos
    public ?int  $categoriaActiva = null;
    public array $items           = [];   // [['id','nombre','precio','cantidad']]

    // Número correlativo manual (se puede editar)
    public string $numeroCotizacion = '';

    public function mount()
    {
        $this->validezDias       = config('resol.cotizacion_validez', 15);
        $this->numeroCotizacion  = 'COT-' . now()->format('Ymd') . '-001';
    }

    public function render()
    {
        $productsList = $this->categoriaActiva
            ? Product::where('categoria_id', $this->categoriaActiva)->orderBy('nombre')->get()
            : collect();

        $sugerencias = collect();
        if ($this->mostrarSugerencias && strlen($this->busquedaCliente) >= 2) {
            $sugerencias = Cliente::where('nombre', 'like', '%' . $this->busquedaCliente . '%')
                ->orWhere('razon_social', 'like', '%' . $this->busquedaCliente . '%')
                ->orderBy('nombre')
                ->limit(8)
                ->get();
        }

        return view('livewire.cotizacion.component', [
            'categorias'   => Category::orderBy('nombre')->get(),
            'productsList' => $productsList,
            'sugerencias'  => $sugerencias,
            'subtotal'     => $this->subtotal(),
            'isv'          => $this->isv(),
            'total'        => $this->total(),
        ])->layout('layouts.admin');
    }

    public function updatedBusquedaCliente(): void
    {
        $this->mostrarSugerencias = strlen($this->busquedaCliente) >= 2;
    }

    public function seleccionarCliente(int $id): void
    {
        $cliente = Cliente::findOrFail($id);
        $this->clienteNombre  = $cliente->nombre;
        $this->clienteEmpresa = $cliente->razon_social ?? '';
        $this->clienteCorreo  = $cliente->correo ?? '';
        $this->clienteRtn     = $cliente->rfc ?? '';
        $this->busquedaCliente   = $cliente->nombre;
        $this->mostrarSugerencias = false;
    }

    public function limpiarCliente(): void
    {
        $this->clienteNombre     = '';
        $this->clienteEmpresa    = '';
        $this->clienteCorreo     = '';
        $this->clienteRtn        = '';
        $this->busquedaCliente   = '';
        $this->mostrarSugerencias = false;
    }

    public function seleccionarCategoria(int $id): void
    {
        $this->categoriaActiva = $id;
    }

    public function agregarProducto(int $productId): void
    {
        // Si ya está en la lista solo sube la cantidad
        foreach ($this->items as &$item) {
            if ($item['id'] === $productId) {
                $item['cantidad']++;
                return;
            }
        }

        $product = Product::findOrFail($productId);
        $this->items[] = [
            'id'         => $product->id,
            'nombre'     => $product->nombre,
            'precio'     => (float) $product->precio / 1.15,  // sin ISV
            'cantidad'   => 1,
        ];
    }

    public function cambiarCantidad(int $index, int $cantidad): void
    {
        if ($cantidad <= 0) {
            $this->quitarItem($index);
            return;
        }
        if (isset($this->items[$index])) {
            $this->items[$index]['cantidad'] = $cantidad;
        }
    }

    public function quitarItem(int $index): void
    {
        array_splice($this->items, $index, 1);
        $this->items = array_values($this->items);
    }

    public function limpiar(): void
    {
        $this->items          = [];
        $this->notas          = '';
        $this->limpiarCliente();
    }

    public function generarPdf(): void
    {
        if (empty($this->items)) {
            return;
        }

        session()->put('cotizacion_pdf_data', [
            'numeroCotizacion' => $this->numeroCotizacion,
            'fecha'            => now()->format('d/m/Y'),
            'fechaVence'       => now()->addDays($this->validezDias)->format('d/m/Y'),
            'clienteNombre'    => $this->clienteNombre,
            'clienteEmpresa'   => $this->clienteEmpresa,
            'clienteCorreo'    => $this->clienteCorreo,
            'clienteRtn'       => $this->clienteRtn,
            'notas'            => $this->notas,
            'items'            => $this->items,
            'validezDias'      => $this->validezDias,
            'subtotal'         => $this->subtotal(),
            'isv'              => $this->isv(),
            'total'            => $this->total(),
            'negocio'          => $this->datosEmpresa(),
            'currency'         => config('resol.currency_symbol', 'L'),
        ]);

        $this->dispatchBrowserEvent('descargar-pdf', [
            'url' => route('admin.cotizacion.pdf'),
        ]);
    }

    // --- Cálculos ---
    // precio en items ya está sin ISV (precio_resol / 1.15)

    private function subtotal(): float
    {
        return round(collect($this->items)->sum(fn($i) => $i['precio'] * $i['cantidad']), 2);
    }

    private function isv(): float
    {
        return round($this->subtotal() * 0.15, 2);
    }

    private function total(): float
    {
        return round($this->subtotal() + $this->isv(), 2);
    }

    private function datosEmpresa(): array
    {
        $empresa = Empresa::first();

        $logoBase64 = null;
        $logoFile   = config('resol.negocio_logo', '');
        if ($logoFile) {
            $logoPath = public_path($logoFile);
            if (file_exists($logoPath)) {
                $mime       = mime_content_type($logoPath);
                $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));
            }
        }

        if (!$empresa) {
            return [
                'nombre'      => config('resol.negocio_nombre'),
                'rtn'         => config('resol.negocio_rtn'),
                'direccion'   => config('resol.negocio_direccion'),
                'telefono'    => config('resol.negocio_telefono'),
                'correo'      => config('resol.negocio_correo'),
                'logo_base64' => $logoBase64,
            ];
        }

        return [
            'nombre'      => $empresa->razon_social ?: $empresa->nombre,
            'rtn'         => $empresa->rfc ?? '',
            'direccion'   => $empresa->direccion,
            'telefono'    => $empresa->telefono ?? '',
            'correo'      => $empresa->correo ?? '',
            'logo_base64' => $logoBase64,
        ];
    }
}
