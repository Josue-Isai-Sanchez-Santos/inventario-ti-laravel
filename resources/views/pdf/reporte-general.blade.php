<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte general de inventario TI</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }

        h1 {
            margin: 0;
            font-size: 18px;
        }

        .subtitle {
            font-size: 10px;
            margin-top: 4px;
        }

        .meta {
            margin-bottom: 14px;
            font-size: 9px;
        }

        .summary {
            width: 100%;
            margin-bottom: 16px;
        }

        .summary td {
            border: 1px solid #333;
            padding: 7px;
            width: 20%;
            text-align: center;
        }

        .summary .label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }

        .summary .value {
            font-size: 16px;
            font-weight: bold;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 16px;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th, td {
            border: 1px solid #333;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #eaeaea;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
    <table style="width:100%; border:none; margin-bottom:8px;">
        <tr>
            <td style="width:20%; border:none; text-align:left;">
                <img src="{{ public_path('images/logos/IHE.jpg') }}" style="height:55px;">
            </td>

            <td style="width:60%; border:none; text-align:center;">
                <h1>Sistema de Inventario de Activos TI</h1>
                <div class="subtitle">Reporte general de activos, asignaciones, mantenimientos y bajas</div>
            </td>

            <td style="width:20%; border:none; text-align:right;">
                <img src="{{ public_path('images/logos/Logo_escuela.jpg') }}" style="height:55px;">
            </td>
        </tr>
    </table>
</div>

    <div class="meta">
        <strong>Fecha de generación:</strong> {{ $fechaGeneracion }}<br>
        <strong>Generado por:</strong> {{ $generadoPor }}
    </div>

    <table class="summary">
        <tr>
            <td>
                <span class="label">Total activos</span>
                <span class="value">{{ $resumen['total_activos'] }}</span>
            </td>
            <td>
                <span class="label">Disponibles</span>
                <span class="value">{{ $resumen['activos_disponibles'] }}</span>
            </td>
            <td>
                <span class="label">En uso</span>
                <span class="value">{{ $resumen['activos_en_uso'] }}</span>
            </td>
            <td>
                <span class="label">Mantenimiento</span>
                <span class="value">{{ $resumen['activos_en_mantenimiento'] }}</span>
            </td>
            <td>
                <span class="label">Dados de baja</span>
                <span class="value">{{ $resumen['activos_dados_de_baja'] }}</span>
            </td>
        </tr>
    </table>

    <table class="summary">
        <tr>
            <td>
                <span class="label">Asignaciones vigentes</span>
                <span class="value">{{ $resumen['asignaciones_vigentes'] }}</span>
            </td>
            <td>
                <span class="label">Mantenimientos</span>
                <span class="value">{{ $resumen['mantenimientos'] }}</span>
            </td>
            <td>
                <span class="label">Bajas</span>
                <span class="value">{{ $resumen['bajas'] }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Activos por estado</div>
    <table>
        <thead>
            <tr>
                <th>Estado</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activosPorEstado as $estado)
                <tr>
                    <td>{{ $estado->nombre }}</td>
                    <td class="right">{{ $estado->activos_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Activos por categoría</div>
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activosPorCategoria as $item)
                <tr>
                    <td>{{ $item->categoria ?? 'Sin categoría' }}</td>
                    <td class="right">{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Últimas asignaciones</div>
    <table>
        <thead>
            <tr>
                <th>Activo</th>
                <th>Responsable</th>
                <th>Ubicación</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ultimasAsignaciones as $asignacion)
                <tr>
                    <td>{{ $asignacion->activo?->nombre ?? 'Sin activo' }}</td>
                    <td>{{ $asignacion->responsable?->name ?? 'Sin responsable' }}</td>
                    <td>{{ $asignacion->ubicacion?->nombre ?? 'Sin ubicación' }}</td>
                    <td>{{ $asignacion->fecha_asignacion }}</td>
                    <td>{{ $asignacion->fecha_retorno ? 'Finalizada' : 'Vigente' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Últimos mantenimientos</div>
    <table>
        <thead>
            <tr>
                <th>Activo</th>
                <th>Tipo</th>
                <th>Técnico</th>
                <th>Fecha</th>
                <th class="right">Costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ultimosMantenimientos as $mantenimiento)
                <tr>
                    <td>{{ $mantenimiento->activo?->nombre ?? 'Sin activo' }}</td>
                    <td>{{ $mantenimiento->tipo }}</td>
                    <td>{{ $mantenimiento->tecnico?->name ?? $mantenimiento->tecnico_externo ?? 'Sin técnico' }}</td>
                    <td>{{ $mantenimiento->fecha }}</td>
                    <td class="right">${{ number_format((float) $mantenimiento->costo, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Últimas bajas</div>
    <table>
        <thead>
            <tr>
                <th>Activo</th>
                <th>Motivo</th>
                <th>Autorizado por</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ultimasBajas as $baja)
                <tr>
                    <td>{{ $baja->activo?->nombre ?? 'Sin activo' }}</td>
                    <td>{{ $baja->motivo }}</td>
                    <td>{{ $baja->autorizadoPor?->name ?? 'Sin usuario' }}</td>
                    <td>{{ $baja->fecha }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
