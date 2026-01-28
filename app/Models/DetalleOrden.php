<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = 'detalles_orden';

    // --- DESPROTECCIÓN TOTAL ---
    protected $guarded = [];
    // ---------------------------

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}