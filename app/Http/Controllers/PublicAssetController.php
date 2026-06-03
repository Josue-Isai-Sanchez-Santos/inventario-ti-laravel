<?php

namespace App\Http\Controllers;

use App\Models\Activo;

class PublicAssetController extends Controller
{
    public function show(string $token)
    {
        $activo = Activo::with([
            'categoria',
            'estado',
            'asignaciones' => function ($query) {
                $query->whereNull('fecha_retorno')
                    ->with('ubicacion')
                    ->latest('fecha_asignacion');
            },
        ])
            ->where('qr_token', $token)
            ->first();

        if (! $activo) {
            return response()
                ->view('public.asset-not-found', [
                    'institutionName' => env('INSTITUTION_NAME', 'Institución educativa'),
                    'systemName' => config('app.name'),
                ], 404);
        }

        $ubicacionVigente = $activo->asignaciones->first()?->ubicacion;

        return view('public.asset', [
            'activo' => $activo,
            'ubicacionVigente' => $ubicacionVigente,
            'institutionName' => env('INSTITUTION_NAME', 'Institución educativa'),
            'systemName' => config('app.name'),
        ]);
    }
}
