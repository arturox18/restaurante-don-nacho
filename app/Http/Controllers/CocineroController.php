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
        
        return view('cocinero.ticket', compact('orden'));
    }
}