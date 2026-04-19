<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InicioEstadistica extends Model
{
    protected $table      = 'inicio_estadisticas';
    protected $primaryKey = 'id_estadistica';

    protected $fillable = [
        'id_pagina',
        'ano',
        'beneficiarios',
        'proyectos',
        'horas_apoyo',
        'voluntarios',
    ];

    protected $casts = [
        'ano'           => 'integer',
        'beneficiarios' => 'integer',
        'proyectos'     => 'integer',
        'horas_apoyo'   => 'integer',
        'voluntarios'   => 'integer',
    ];

    public function pagina()
    {
        return $this->belongsTo(Pagina::class, 'id_pagina', 'id_pagina');
    }
}