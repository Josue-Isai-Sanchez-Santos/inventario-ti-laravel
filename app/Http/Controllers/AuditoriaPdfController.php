<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaEvento;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditoriaPdfController extends Controller
{
    public function export()
    {
        $eventos = AuditoriaEvento::with('usuario')
            ->orderByDesc('created_at')
            ->get();

        $generadoPor = auth()->user()?->name ?? 'Usuario no identificado';
        $fechaGeneracion = now()->format('Y-m-d H:i:s');

        $pdf = Pdf::loadView('pdf.auditoria', [
            'eventos' => $eventos,
            'generadoPor' => $generadoPor,
            'fechaGeneracion' => $fechaGeneracion,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('auditoria_eventos.pdf');
    }
}
