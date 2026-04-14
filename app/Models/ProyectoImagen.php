<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoImagen extends Model
{
    protected $table      = 'proyecto_imagenes';
    protected $primaryKey = 'id_imagen'; // ← PK correcta
    protected $fillable = ['id_ano', 'id_categoria', 'titulo', 'image_path', 'description', 'event_date'];
    protected $casts      = ['event_date' => 'date'];

    public function ano()
    {
        return $this->belongsTo(ProyectoAno::class, 'id_ano', 'id_ano');
    }

    public function categoria()
    {
        return $this->belongsTo(ProyectoCategoria::class, 'id_categoria', 'id_categoria');
    }
}