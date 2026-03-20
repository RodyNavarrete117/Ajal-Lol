<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'informe';

    protected $primaryKey = 'id_informe';

    protected $fillable = [
        'nombre_organizacion',
        'evento',
        'lugar',
        'fecha',
    ];

    // Un reporte tiene muchos beneficiarios (tabla reportebeneficiarios)
    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class, 'id_informe', 'id_informe');
    }

    // Un reporte tiene muchos registros de asistencia (tabla asistenciabeneficiarios)
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'id_informe', 'id_informe');
    }
}