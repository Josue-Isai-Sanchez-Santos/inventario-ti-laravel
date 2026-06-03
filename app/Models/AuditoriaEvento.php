<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditoriaEvento extends Model
{
    protected $table = 'auditoria_eventos';

    protected $primaryKey = 'id_evento';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'accion',
        'tabla',
        'registro_id',
        'antes',
        'despues',
        'ip',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}
