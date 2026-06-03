@php
    $antes = $record->antes ? json_decode($record->antes, true) : null;
    $despues = $record->despues ? json_decode($record->despues, true) : null;

    $antesTexto = json_last_error() === JSON_ERROR_NONE && $antes !== null
        ? json_encode($antes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        : ($record->antes ?: 'Sin datos previos');

    $despuesTexto = json_last_error() === JSON_ERROR_NONE && $despues !== null
        ? json_encode($despues, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        : ($record->despues ?: 'Sin datos nuevos');
@endphp

<div class="space-y-5">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <strong>Usuario:</strong>
            <div>{{ $record->usuario?->name ?? 'Sistema' }}</div>
        </div>

        <div>
            <strong>Acción:</strong>
            <div>{{ $record->accion }}</div>
        </div>

        <div>
            <strong>Tabla:</strong>
            <div>{{ $record->tabla }}</div>
        </div>

        <div>
            <strong>Registro ID:</strong>
            <div>{{ $record->registro_id }}</div>
        </div>

        <div>
            <strong>IP:</strong>
            <div>{{ $record->ip ?: 'No registrada' }}</div>
        </div>

        <div>
            <strong>Fecha:</strong>
            <div>{{ $record->created_at?->format('Y-m-d H:i:s') }}</div>
        </div>
    </div>

    <div>
        <strong>Datos previos:</strong>
        <pre style="white-space: pre-wrap; word-break: break-word; background:#111827; color:#e5e7eb; padding:12px; border-radius:8px; max-height:260px; overflow:auto;">{{ $antesTexto }}</pre>
    </div>

    <div>
        <strong>Datos nuevos:</strong>
        <pre style="white-space: pre-wrap; word-break: break-word; background:#111827; color:#e5e7eb; padding:12px; border-radius:8px; max-height:260px; overflow:auto;">{{ $despuesTexto }}</pre>
    </div>
</div>
