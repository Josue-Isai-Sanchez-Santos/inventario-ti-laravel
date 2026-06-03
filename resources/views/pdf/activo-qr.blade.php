<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha QR del activo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        .row {
            margin-bottom: 12px;
        }

        .label {
            font-weight: bold;
        }

        .qr {
            margin-top: 30px;
            text-align: center;
        }

        .qr img {
            width: 220px;
            height: 220px;
        }

        .url {
            margin-top: 16px;
            word-break: break-all;
            text-align: center;
            font-size: 11px;
        }

        .box {
            border: 1px solid #333;
            padding: 16px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="width:100%; border:none; margin-bottom:20px;">
    <tr>
        <td style="width:20%; border:none; text-align:left;">
            <img src="{{ public_path('images/logos/IHE.jpg') }}" style="height:55px;">
        </td>

        <td style="width:60%; border:none; text-align:center;">
            <h1>Ficha QR del activo</h1>
            <div style="font-size:11px;">Sistema de Inventario de Activos TI</div>
        </td>

        <td style="width:20%; border:none; text-align:right;">
            <img src="{{ public_path('images/logos/Logo_escuela.jpg') }}" style="height:55px;">
        </td>
    </tr>
</table>

        <div class="box">
            <div class="row">
                <span class="label">Nombre del activo:</span>
                {{ $activo->nombre }}
            </div>

            <div class="row">
                <span class="label">Marca:</span>
                {{ $activo->marca ?: 'No especificada' }}
            </div>

            <div class="row">
                <span class="label">Modelo:</span>
                {{ $activo->modelo ?: 'No especificado' }}
            </div>

            <div class="qr">
    @if($qrDataUri)
        <img src="{{ $qrDataUri }}" alt="QR del activo">
    @else
        <div>No se encontró la imagen QR.</div>
    @endif
</div>

<div class="url">
    <span class="label">Liga pública:</span><br>
    {{ $publicUrl }}
</div>
        </div>
    </div>
</body>
</html>
