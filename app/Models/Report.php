<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'informe'; // tu tabla real

    protected $primaryKey = 'id_informe'; // tu PK real

    protected $fillable = [
        'nombre_organizacion',
        'evento',
        'lugar',
        'fecha',
        'numero_telefonico'
    ];

    // Un reporte tiene muchos beneficiarios
    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class, 'id_informe', 'id_informe');
    }
}