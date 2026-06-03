<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Support\QrGenerator;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivoPdfController extends Controller
{
    public function qrPdf(Activo $activo)
    {
        if (! $activo->qrExiste()) {
            QrGenerator::generarParaActivo($activo->qr_token);
        }

        $qrPath = storage_path('app/public/'.$activo->qr_image_path);
        $qrDataUri = null;

        if (file_exists($qrPath)) {
            $qrDataUri = 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($qrPath));
        }

        $pdf = Pdf::loadView('pdf.activo-qr', [
            'activo' => $activo,
            'publicUrl' => $activo->public_url,
            'qrDataUri' => $qrDataUri,
        ]);

        return $pdf->download('activo_qr_'.$activo->codigo_inventario.'.pdf');
    }
}
