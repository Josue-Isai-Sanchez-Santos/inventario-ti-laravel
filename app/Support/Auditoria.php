<?php

namespace App\Support;

use App\Models\AuditoriaEvento;

class Auditoria
{
    public static function registrar(
        string $accion,
        string $tabla,
        int $registroId,
        array|string|null $antes = null,
        array|string|null $despues = null
    ): void {
        AuditoriaEvento::create([
            'usuario_id' => auth()->id(),
            'accion' => $accion,
            'tabla' => $tabla,
            'registro_id' => $registroId,
            'antes' => self::normalizarDato($antes),
            'despues' => self::normalizarDato($despues),
            'ip' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'created_at' => now(),
        ]);
    }

    protected static function normalizarDato(array|string|null $dato): ?string
    {
        if ($dato === null) {
            return null;
        }

        if (is_array($dato)) {
            return json_encode($dato, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $decoded = json_decode($dato, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        return $dato;
    }
}
