<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\User;

class AdminController extends Controller
{
    public function historial(Request $request)
    {
        // Traemos TODAS las órdenes pagadas del restaurante
        $query = Orden::where('estatus', 'pagado')
                    ->with(['mesa', 'usuario', 'detalles.producto'])
                    ->orderBy('created_at', 'desc');

        // --- FILTROS DE FECHA ---
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

        // --- FILTRO POR MESERO ---
        if ($request->filled('mesero_id')) {
            $query->where('usuario_id', $request->mesero_id);
        }

        // Calculamos el TOTAL de dinero generado con esos filtros (antes de paginar)
        $totalIngresos = (clone $query)->sum('total');

        // Paginamos de 15 en 15
        $ordenes = $query->paginate(15)->withQueryString();
        
        // Traemos a los meseros (asumiendo que rol_id 2 es Mesero) para el filtro select
        $meseros = User::where('rol_id', 2)->get();

        return view('historial', compact('ordenes', 'totalIngresos', 'meseros'));
    }
}