<?php

namespace App\Services;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ComandaPrintService
{
    /**
     * Imprime un grupo de ítems en la impresora correspondiente.
     *
     * @param  array        $items   [['nombre'=>'', 'cantidad'=>1, 'cambios'=>'']]
     * @param  int|string   $mesa
     * @param  string       $mesero
     * @param  string       $lugar   'BARRA' | 'COCINA'
     */
    public function imprimir(array $items, $mesa, string $mesero, string $lugar): void
    {
        try {
            $connector = $this->resolverConector($lugar);
        } catch (\Exception $e) {
            \Log::warning("ComandaPrintService: no se pudo conectar a impresora ($lugar): " . $e->getMessage());
            return;
        }

        try {
            $printer = new Printer($connector);

            // Encabezado centrado
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->setTextSize(2, 1);
            $printer->text(strtoupper($lugar) . "\n");
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(false);
            $printer->text("Mesa: $mesa\n");
            $printer->text("Mesero: $mesero\n");
            $printer->text(now()->format('d/m/Y H:i') . "\n");

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text(str_repeat('-', 40) . "\n");

            foreach ($items as $item) {
                $printer->setEmphasis(true);
                $printer->text("{$item['cantidad']}x {$item['nombre']}\n");
                $printer->setEmphasis(false);
                if (!empty(trim($item['cambios']))) {
                    $printer->text("  * {$item['cambios']}\n");
                }
            }

            $printer->text(str_repeat('-', 40) . "\n");
            $printer->feed(4);
            $printer->cut();
            $printer->close();

        } catch (\Exception $e) {
            \Log::error("ComandaPrintService error ($lugar): " . $e->getMessage());
        }
    }

    private function resolverConector(string $lugar)
    {
        if (strtoupper($lugar) === 'COCINA') {
            $ip   = config('resol.printer_cocina_ip');
            $port = (int) config('resol.printer_cocina_port', 9100);

            if (empty($ip)) {
                \Log::info('ComandaPrintService: COCINA sin IP, redirigiendo a impresora BARRA.');
                $lugar = 'BARRA';
            } else {
                return new NetworkPrintConnector($ip, $port);
            }
        }

        // BARRA — impresora local Windows
        $name = config('resol.printer_barra');

        if (empty($name)) {
            throw new \RuntimeException('PRINTER_BARRA no configurado en .env');
        }

        return new WindowsPrintConnector($name);
    }
}
