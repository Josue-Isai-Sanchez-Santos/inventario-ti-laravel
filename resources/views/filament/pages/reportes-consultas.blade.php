<x-filament-panels::page>
    @php
        $resumen = $this->getResumenGeneral();
        $activosPorEstado = $this->getActivosPorEstado();
        $activosPorCategoria = $this->getActivosPorCategoria();
        $ultimasAsignaciones = $this->getUltimasAsignaciones();
        $ultimosMantenimientos = $this->getUltimosMantenimientos();
        $ultimasBajas = $this->getUltimasBajas();
    @endphp

    <div class="space-y-6">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">Total de activos</div>
                <div class="mt-2 text-3xl font-bold">{{ $resumen['total_activos'] }}</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">Disponibles</div>
                <div class="mt-2 text-3xl font-bold">{{ $resumen['activos_disponibles'] }}</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">En uso</div>
                <div class="mt-2 text-3xl font-bold">{{ $resumen['activos_en_uso'] }}</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">En mantenimiento</div>
                <div class="mt-2 text-3xl font-bold">{{ $resumen['activos_en_mantenimiento'] }}</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">Dados de baja</div>
                <div class="mt-2 text-3xl font-bold">{{ $resumen['activos_dados_de_baja'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">Asignaciones vigentes</div>
                <div class="mt-2 text-2xl font-bold">{{ $resumen['asignaciones_vigentes'] }}</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">Mantenimientos registrados</div>
                <div class="mt-2 text-2xl font-bold">{{ $resumen['mantenimientos'] }}</div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <div class="text-sm text-gray-500 dark:text-gray-400">Bajas registradas</div>
                <div class="mt-2 text-2xl font-bold">{{ $resumen['bajas'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h2 class="mb-4 text-lg font-bold">Activos por estado</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="py-2 text-left">Estado</th>
                                <th class="py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activosPorEstado as $estado)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-2">{{ $estado->nombre }}</td>
                                    <td class="py-2 text-right font-semibold">{{ $estado->activos_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-3 text-gray-500">Sin estados registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h2 class="mb-4 text-lg font-bold">Activos por categoría</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="py-2 text-left">Categoría</th>
                                <th class="py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activosPorCategoria as $item)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-2">{{ $item->categoria ?? 'Sin categoría' }}</td>
                                    <td class="py-2 text-right font-semibold">{{ $item->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-3 text-gray-500">Sin categorías registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <h2 class="mb-4 text-lg font-bold">Últimas asignaciones</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="py-2 text-left">Activo</th>
                            <th class="py-2 text-left">Responsable</th>
                            <th class="py-2 text-left">Ubicación</th>
                            <th class="py-2 text-left">Fecha</th>
                            <th class="py-2 text-left">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasAsignaciones as $asignacion)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="py-2">{{ $asignacion->activo?->nombre ?? 'Sin activo' }}</td>
                                <td class="py-2">{{ $asignacion->responsable?->name ?? 'Sin responsable' }}</td>
                                <td class="py-2">{{ $asignacion->ubicacion?->nombre ?? 'Sin ubicación' }}</td>
                                <td class="py-2">{{ $asignacion->fecha_asignacion?->format('Y-m-d H:i') }}</td>
                                <td class="py-2">
                                    {{ $asignacion->fecha_retorno ? 'Finalizada' : 'Vigente' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-3 text-gray-500">Sin asignaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h2 class="mb-4 text-lg font-bold">Últimos mantenimientos</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="py-2 text-left">Activo</th>
                                <th class="py-2 text-left">Tipo</th>
                                <th class="py-2 text-left">Técnico</th>
                                <th class="py-2 text-left">Fecha</th>
                                <th class="py-2 text-right">Costo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimosMantenimientos as $mantenimiento)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-2">{{ $mantenimiento->activo?->nombre ?? 'Sin activo' }}</td>
                                    <td class="py-2">{{ $mantenimiento->tipo }}</td>
                                    <td class="py-2">
                                        {{ $mantenimiento->tecnico?->name ?? $mantenimiento->tecnico_externo ?? 'Sin técnico' }}
                                    </td>
                                    <td class="py-2">{{ $mantenimiento->fecha?->format('Y-m-d H:i') }}</td>
                                    <td class="py-2 text-right">
                                        ${{ number_format((float) $mantenimiento->costo, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-3 text-gray-500">Sin mantenimientos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h2 class="mb-4 text-lg font-bold">Últimas bajas</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="py-2 text-left">Activo</th>
                                <th class="py-2 text-left">Motivo</th>
                                <th class="py-2 text-left">Autorizado por</th>
                                <th class="py-2 text-left">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimasBajas as $baja)
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <td class="py-2">{{ $baja->activo?->nombre ?? 'Sin activo' }}</td>
                                    <td class="py-2">{{ $baja->motivo }}</td>
                                    <td class="py-2">{{ $baja->autorizadoPor?->name ?? 'Sin usuario' }}</td>
                                    <td class="py-2">{{ $baja->fecha?->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-3 text-gray-500">Sin bajas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-filament-panels::page>
