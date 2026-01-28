<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'opciones';
    protected $fillable = ['grupo_opcion_id', 'nombre', 'precio_extra'];
}
