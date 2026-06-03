<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Asignacion;
use App\Models\Baja;
use App\Models\EstadoActivo;
use App\Models\Mantenimiento;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteGeneralPdfController extends Controller
{
    public function export()
    {
        $resumen = [
            'total_activos' => Activo::count(),

            'activos_disponibles' => Activo::query()
                ->whereHas('estado', fn ($query) => $query->where('nombre', 'Disponible'))
                ->count(),

            'activos_en_uso' => Activo::query()
                ->whereHas('estado', fn ($query) => $query->where('nombre', 'En uso'))
                ->count(),

            'activos_en_mantenimiento' => Activo::query()
                ->whereHas('estado', fn ($query) => $query->where('nombre', 'En mantenimiento'))
                ->count(),

            'activos_dados_de_baja' => Activo::query()
                ->whereHas('estado', fn ($query) => $query->whereIn('nombre', ['Dado de baja', 'Baja']))
                ->count(),

            'asignaciones_vigentes' => Asignacion::whereNull('fecha_retorno')->count(),
            'mantenimientos' => Mantenimiento::count(),
            'bajas' => Baja::count(),
        ];

        $activosPorEstado = EstadoActivo::query()
            ->withCount('activos')
            ->orderBy('nombre')
            ->get();

        $activosPorCategoria = Activo::query()
            ->selectRaw('categorias.nombre as categoria, COUNT(*) as total')
            ->leftJoin('categorias', 'activos.categoria_id', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderBy('categorias.nombre')
            ->get();

        $ultimasAsignaciones = Asignacion::with(['activo', 'responsable', 'ubicacion'])
            ->orderByDesc('fecha_asignacion')
            ->limit(10)
            ->get();

        $ultimosMantenimientos = Mantenimiento::with(['activo', 'tecnico'])
            ->orderByDesc('fecha')
            ->limit(10)
            ->get();

        $ultimasBajas = Baja::with(['activo', 'autorizadoPor'])
            ->orderByDesc('fecha')
            ->limit(10)
            ->get();

        $pdf = Pdf::loadView('pdf.reporte-general', [
            'resumen' => $resumen,
            'activosPorEstado' => $activosPorEstado,
            'activosPorCategoria' => $activosPorCategoria,
            'ultimasAsignaciones' => $ultimasAsignaciones,
            'ultimosMantenimientos' => $ultimosMantenimientos,
            'ultimasBajas' => $ultimasBajas,
            'generadoPor' => auth()->user()?->name ?? 'Usuario no identificado',
            'fechaGeneracion' => now()->format('Y-m-d H:i:s'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('reporte_general_inventario_ti.pdf');
    }
}
