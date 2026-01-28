<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';

    protected $guarded = []; 

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleOrden::class, 'orden_id');
    }
}