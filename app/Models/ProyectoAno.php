<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoAno extends Model
{
    protected $table      = 'proyecto_anos';
    protected $primaryKey = 'id_ano'; // ← decirle cuál es la PK
    protected $fillable   = ['id_pagina', 'ano', 'subtitulo', 'visible'];

    public function imagenes()
    {
        return $this->hasMany(ProyectoImagen::class, 'id_ano');
    }
}