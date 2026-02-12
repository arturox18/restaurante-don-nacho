<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;

class CocineroController extends Controller
{
    public function index()
    {
        $ordenes = Orden::where('estatus', 'cocinando')
                        ->with(['mesa', 'usuario', 'detalles.producto'])
                        ->orderBy('updated_at', 'asc')
                        ->get();

        return view('cocinero.dashboard', compact('ordenes'));
    }

    public function terminarOrden(Orden $orden)
    {
        $orden->update(['estatus' => 'listo']);
        
        return back()->with('success', 'Orden marcada como lista.');
    }
}