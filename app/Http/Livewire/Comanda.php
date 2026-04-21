<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Comanda as ComandaModel;
use App\Models\Mesa;
use App\Models\Product;
use App\Services\ComandaPrintService;
use App\Traits\CartTrait;
use Livewire\Component;

class Comanda extends Component
{
    use CartTrait;

    public Mesa $mesa;

    public ?int $categoriaActiva  = null;
    public string $notificacion   = '';
    public array $notas           = [];
    public array $ticketItems     = [];
    public bool $mostrarTicket    = false;

    public function mount(Mesa $mesa)
    {
        $this->mesa = $mesa;
    }

    public function hydrate()
    {
        // Sincroniza notas con lo que ya está en el carrito (hook correcto, fuera de render)
        foreach ($this->getContentCart() as $item) {
            if (!isset($this->notas[$item->id]) && !empty($item->changes)) {
                $this->notas[$item->id] = $item->changes;
            }
        }
    }

    public function render()
    {
        $productsList = $this->categoriaActiva
            ? Product::where('categoria_id', $this->categoriaActiva)->get()
            : collect();

        return view('livewire.comanda.component', [
            'categorias'     => Category::orderBy('nombre')->get(),
            'productsList'   => $productsList,
            'contentCart'    => $this->getContentCart(),
            'totalCart'      => $this->getTotalCart(),
            'itemsCart'      => $this->getItemsCart(),
            'comandaAbierta' => ComandaModel::where('mesa_id', $this->mesa->id)
                                    ->where('estatus', 'Pendiente')
                                    ->orderBy('created_at')
                                    ->get(),
        ])->layout('layouts.mesero');
    }

    public function seleccionarCategoria(int $categoriaId)
    {
        $this->categoriaActiva = $categoriaId;
    }

    public function agregarProducto(int $productId)
    {
        $product = Product::findOrFail($productId);
        $this->addProductToCart($product, 1);
    }

    public function aumentar(int $productId)
    {
        $product = Product::findOrFail($productId);
        $this->updateQtyCart($product, 1);
    }

    public function disminuir(int $productId)
    {
        $this->decreaseQtyCart($productId);
    }

    public function quitar(int $productId)
    {
        $this->removeProductCart($productId);
    }

    public function guardarNota(int $productId)
    {
        $nota = trim($this->notas[$productId] ?? '');
        $this->addChanges2Product($productId, $nota);
    }

    public function eliminarLinea(int $comandaId)
    {
        ComandaModel::where('id', $comandaId)
            ->where('mesa_id', $this->mesa->id)
            ->delete();
    }

    public function guardarEdicion(int $comandaId, int $cantidad, string $cambios)
    {
        if ($cantidad <= 0) {
            $this->eliminarLinea($comandaId);
            return;
        }

        ComandaModel::where('id', $comandaId)
            ->where('mesa_id', $this->mesa->id)
            ->update([
                'cantidad' => $cantidad,
                'cambios'  => trim($cambios),
            ]);
    }

    public function enviarComanda()
    {
        $items = $this->getContentCart();

        if ($items->isEmpty()) {
            $this->notificacion = 'Agrega productos antes de enviar.';
            return;
        }

        $meseroId = auth()->id();

        // Cargar categorías para saber el lugar de cada producto
        $productIds = $items->pluck('id');
        $productos  = Product::with('category')->whereIn('id', $productIds)->get()->keyBy('id');

        // Guardar en BD y agrupar por lugar para impresión
        $porLugar    = [];
        $primerIdComanda = null;

        foreach ($items as $item) {
            $comanda = ComandaModel::create([
                'mesa_id'     => $this->mesa->id,
                'mesero_id'   => $meseroId,
                'producto_id' => $item->id,
                'cantidad'    => $item->qty,
                'precio'      => $item->price,
                'descuento'   => 0,
                'orden'       => $item->name,
                'cambios'     => $item->changes ?? '',
                'impresa'     => 0,
                'estatus'     => 'Pendiente',
            ]);

            $primerIdComanda = $primerIdComanda ?? $comanda->id;

            $lugar = strtoupper($productos[$item->id]->category->lugar ?? 'BARRA');
            $porLugar[$lugar][] = [
                'nombre'   => $item->name,
                'cantidad' => $item->qty,
                'cambios'  => $item->changes ?? '',
            ];
        }

        // Imprimir en cada impresora según el área
        $fechaComanda = now()->format('d/m/Y H:i');
        $printService = new ComandaPrintService();
        foreach ($porLugar as $lugar => $lineas) {
            $printService->imprimir($lineas, $this->mesa->numero, auth()->user()->nombre, $lugar, $fechaComanda, $primerIdComanda);
        }

        // Guardar items para el ticket en pantalla antes de limpiar el carrito
        $this->ticketItems = $items->map(fn($item) => [
            'nombre'   => $item->name,
            'cantidad' => $item->qty,
            'precio'   => $item->price,
            'cambios'  => $item->changes ?? '',
        ])->values()->toArray();

        $this->clearCart();
        $this->categoriaActiva = null;
        $this->mostrarTicket   = true;
        $this->notificacion    = 'Comanda enviada correctamente.';
    }

    public function cerrarTicket()
    {
        $this->mostrarTicket = false;
        $this->ticketItems   = [];
    }

    public function reimprimir()
    {
        $lineas = ComandaModel::with('producto.category')
            ->where('mesa_id', $this->mesa->id)
            ->where('estatus', 'Pendiente')
            ->get();

        if ($lineas->isEmpty()) {
            $this->notificacion = 'No hay productos enviados para reimprimir.';
            return;
        }

        $porLugar = [];
        foreach ($lineas as $linea) {
            $lugar = strtoupper($linea->producto->category->lugar ?? 'BARRA');
            $porLugar[$lugar][] = [
                'nombre'   => $linea->orden,
                'cantidad' => $linea->cantidad,
                'cambios'  => $linea->cambios ?? '',
            ];
        }

        $fechaComanda = $lineas->first()->created_at
            ? \Carbon\Carbon::parse($lineas->first()->created_at)->format('d/m/Y H:i')
            : now()->format('d/m/Y H:i');

        $printService = new ComandaPrintService();
        foreach ($porLugar as $lugar => $items) {
            $printService->imprimir($items, $this->mesa->numero, auth()->user()->nombre, $lugar, $fechaComanda, $lineas->first()->id);
        }

        $this->notificacion = 'Comanda reimpresa.';
    }

    // Requerido por CartTrait
    public function noty(string $msg)
    {
        $this->notificacion = $msg;
    }
}
