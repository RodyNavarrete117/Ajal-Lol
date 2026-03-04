<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table      = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public    $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_formulario',
        'titulo',
        'mensaje',
        'leido',
    ];

    protected $casts = [
        'leido'      => 'boolean',
        'created_at' => 'datetime',
    ];
}