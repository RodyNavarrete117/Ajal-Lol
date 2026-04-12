<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoCategoria extends Model
{
    protected $table      = 'proyecto_categorias';
    protected $primaryKey = 'id_categoria'; // ← PK correcta
    protected $fillable   = ['nombre', 'orden'];
    public $timestamps    = false;
}