<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
    'nombre',
    'imagen',
    'precio', 
    'descripcion', 
    'categoria_id', 
    'is_active'
];

public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

public function gruposOpciones()
{
    return $this->belongsToMany(GrupoOpcion::class, 'producto_grupo_opcion');
}
}
