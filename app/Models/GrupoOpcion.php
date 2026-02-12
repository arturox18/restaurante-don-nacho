<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoOpcion extends Model
{
    protected $table = 'grupos_opciones';
    protected $fillable = ['nombre', 'es_multiple', 'es_obligatorio', 'maximo_opciones'];

    public function opciones()
    {
        return $this->hasMany(Opcion::class, 'grupo_opcion_id');
    }
}