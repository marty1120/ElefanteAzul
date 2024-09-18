<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    public $timestamps = false;
    protected $fillable = ['id', 'entrada', 'salida', 'nombre', 'telefono', 'coche', 'matricula', 'tipo_lavado', 'limpieza_llantas', 'precio'];


    public function tipoLavado()
    {
        return $this->belongsTo(TipoLavado::class, 'tipo_lavado', 'id');
    }
}
