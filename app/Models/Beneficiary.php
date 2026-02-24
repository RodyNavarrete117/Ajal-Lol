<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $table = 'beneficiarios'; // tu tabla real

    protected $primaryKey = 'id_beneficiario'; // tu PK real

    public $timestamps = false; 
    // porque solo tienes created_at, no updated_at manejado por Laravel

    protected $fillable = [
        'id_informe',
        'nombre',
        'curp'
    ];

    // Un beneficiario pertenece a un reporte
    public function report()
    {
        return $this->belongsTo(Report::class, 'id_informe', 'id_informe');
    }
}