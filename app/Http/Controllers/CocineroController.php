<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;

class CocineroController extends Controller
{
    public function index()
    {
        $ordenes = Orden::where('estatus', 'cocinando')
            ->with(['mesa', 'usuario', 'detalles' => function($query) {
                $query->whereIn('estado', ['pendiente', 'en_cocina'])->with('producto');
            }])
            ->orderBy('updated_at', 'asc')
            ->get();

        return view('cocinero.dashboard', compact('ordenes'));
    }

    public function terminarOrden(Orden $orden)
    {
        // 1. MAGIA: Marcamos todos los platillos que estaban pendientes o cocinándose como 'listos'
        $orden->detalles()->whereIn('estado', ['pendiente', 'en_cocina'])->update(['estado' => 'listo']);
        
        // 2. Marcamos la orden completa como lista
        $orden->update(['estatus' => 'listo']);
        
        return back()->with('success', 'Orden marcada como lista.');
    }

    public function historial(Request $request)
    {
        $query = \App\Models\Orden::whereIn('estatus', ['listo', 'pagado'])
                        ->with(['mesa', 'usuario', 'detalles.producto'])
                        ->orderBy('updated_at', 'desc');

        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }
        
        if ($request->filled('mes')) {
            $anio = date('Y', strtotime($request->mes));
            $mesNumero = date('m', strtotime($request->mes));
            $query->whereYear('created_at', $anio)->whereMonth('created_at', $mesNumero);
        }

        if ($request->filled('anio')) {
            $query->whereYear('created_at', $request->anio);
        }

        $ordenes = $query->paginate(12)->withQueryString();

        return view('cocinero.historial', compact('ordenes'));
    }

    public function ticketCocina(Orden $orden)
    {
        $orden->load(['mesa', 'usuario', 'detalles.producto']);
        
        // 1. Rescatamos SOLAMENTE los platillos nuevos que no se han impreso (pendientes)
        $detallesNuevos = $orden->detalles()->where('estado', 'pendiente')->get();

        // 2. Inmediatamente los marcamos como 'en_cocina' para que no vuelvan a salir en el futuro
        $orden->detalles()->where('estado', 'pendiente')->update(['estado' => 'en_cocina']);
        
        // 3. Mandamos SOLO esos platillos nuevos a la vista del ticket
        return view('cocinero.ticket', compact('orden', 'detallesNuevos'));
    }
}