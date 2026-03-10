<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'asistenciabeneficiarios';

    protected $primaryKey = 'id_asistenciabeneficiario';

    public $timestamps = false;

    protected $fillable = [
        'id_informe',
        'asistencianombrebeneficiario',
        'asistenciaedadbeneficiario',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'id_informe', 'id_informe');
    }
}