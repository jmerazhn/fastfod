<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CotizacionPdfController extends Controller
{
    public function descargar(Request $request)
    {
        $data = $request->session()->pull('cotizacion_pdf_data');

        if (!$data) {
            abort(404, 'No hay datos de cotización.');
        }

        $pdf = Pdf::loadView('admin.cotizacion-pdf', $data)
            ->setPaper('letter', 'portrait');

        $filename = 'Cotizacion-' . $data['numeroCotizacion'] . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
