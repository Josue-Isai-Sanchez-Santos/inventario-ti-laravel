<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Auditoría de eventos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
            border-bottom: 1px solid #333;
            padding-bottom: 8px;
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
            margin-bottom: 12px;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #333;
            padding: 4px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #eaeaea;
            font-weight: bold;
        }

        .small {
            font-size: 8px;
            word-break: break-word;
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
                <div class="subtitle">Reporte de Auditoría y Trazabilidad</div>
            </td>

            <td style="width:20%; border:none; text-align:right;">
                <img src="{{ public_path('images/logos/Logo_escuela.jpg') }}" style="height:55px;">
            </td>
        </tr>
    </table>
</div>

    <div class="meta">
        <strong>Fecha de generación:</strong> {{ $fechaGeneracion }}<br>
        <strong>Generado por:</strong> {{ $generadoPor }}<br>
        <strong>Total de eventos:</strong> {{ $eventos->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Tabla</th>
                <th>Registro</th>
                <th>IP</th>
                <th>Fecha</th>
                <th>Antes</th>
                <th>Después</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventos as $evento)
                <tr>
                    <td>{{ $evento->id_evento }}</td>
                    <td>{{ $evento->usuario?->name ?? 'Sistema' }}</td>
                    <td>{{ $evento->accion }}</td>
                    <td>{{ $evento->tabla }}</td>
                    <td>{{ $evento->registro_id }}</td>
                    <td>{{ $evento->ip }}</td>
                    <td>{{ $evento->created_at }}</td>
                    <td class="small">{{ Str::limit($evento->antes, 300) }}</td>
                    <td class="small">{{ Str::limit($evento->despues, 300) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
