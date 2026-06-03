<?php

namespace App\Filament\Pages;

use App\Models\Activo;
use App\Models\Asignacion;
use App\Models\Baja;
use App\Models\EstadoActivo;
use App\Models\Mantenimiento;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class ReportesConsultas extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Reportes';

    protected static ?string $navigationLabel = 'Reportes y consultas';

    protected static ?string $title = 'Reportes y consultas';

    protected string $view = 'filament.pages.reportes-consultas';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasPermission('reportes.ver') ?? false;
    }

    public function getResumenGeneral(): array
    {
        return [
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
    }

    public function getActivosPorEstado()
    {
        return EstadoActivo::query()
            ->withCount('activos')
            ->orderBy('nombre')
            ->get();
    }

    public function getActivosPorCategoria()
    {
        return Activo::query()
            ->selectRaw('categorias.nombre as categoria, COUNT(*) as total')
            ->leftJoin('categorias', 'activos.categoria_id', '=', 'categorias.id_categoria')
            ->groupBy('categorias.nombre')
            ->orderBy('categorias.nombre')
            ->get();
    }

    public function getUltimasAsignaciones()
    {
        return Asignacion::with(['activo', 'responsable', 'ubicacion'])
            ->orderByDesc('fecha_asignacion')
            ->limit(5)
            ->get();
    }

    public function getUltimosMantenimientos()
    {
        return Mantenimiento::with(['activo', 'tecnico'])
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();
    }

    public function getUltimasBajas()
    {
        return Baja::with(['activo', 'autorizadoPor'])
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargarPdf')
                ->label('Descargar PDF general')
                ->icon('heroicon-o-document-arrow-down')
                ->url(route('reportes.general.pdf'))
                ->openUrlInNewTab(),
        ];
    }
}
