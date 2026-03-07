<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\DetalleOrden;
use Illuminate\Support\Facades\Auth;

class MeseroController extends Controller
{
    public function index()
    {
        $mesas = Mesa::all();
        return view('mesero.dashboard', compact('mesas'));
    }

    public function catalogo(Mesa $mesa)
    {
        $categorias = \App\Models\Categoria::all(); 
        $productos = \App\Models\Producto::all(); 
        return view('mesero.categorias', compact('mesa', 'categorias', 'productos'));
    }

    public function platillos(Mesa $mesa, Categoria $categoria)
    {
        $productos = $categoria->productos()->where('is_active', true)->get();
        return view('mesero.platillos', compact('mesa', 'categoria', 'productos'));
    }
    
    public function detalle(Mesa $mesa, Producto $producto)
{
    $producto->load(['gruposOpciones.opciones']);
    
    return view('mesero.detalle', compact('mesa', 'producto'));
}

    public function agregar(Request $request, Mesa $mesa, Producto $producto)
    {
        $orden = \App\Models\Orden::firstOrCreate(
            ['mesa_id' => $mesa->id, 'estatus' => 'pendiente'],
            ['usuario_id' => Auth::id(), 'total' => 0]
        );

        $textoOpciones = [];
        $costoExtraTotal = 0;

        if ($request->has('opciones')) {
            foreach ($request->opciones as $grupoId => $valor) {
                if (is_array($valor)) {
                    $opcionesElegidas = \App\Models\Opcion::whereIn('id', $valor)->get();
                    foreach ($opcionesElegidas as $op) {
                        $textoOpciones[] = $op->nombre;
                        $costoExtraTotal += $op->precio_extra;
                    }
                } else {
                    $opcionElegida = \App\Models\Opcion::find($valor);
                    if ($opcionElegida) {
                        $textoOpciones[] = $opcionElegida->nombre;
                        $costoExtraTotal += $opcionElegida->precio_extra;
                    }
                }
            }
        }

        $costoManual = $request->input('costo_manual', 0);
        if ($costoManual > 0) {
            $costoExtraTotal += $costoManual;
            $textoOpciones[] = "Extra manual ($" . number_format($costoManual, 2) . ")";
        }

        $notaFinal = implode(', ', $textoOpciones);
        if ($request->notas) {
            $notaFinal .= ($notaFinal ? ". " : "") . "Nota: " . $request->notas;
        }

        $precioFinal = $producto->precio + $costoExtraTotal;

        \App\Models\DetalleOrden::create([
            'orden_id' => $orden->id,
            'producto_id' => $producto->id,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $precioFinal,
            'notas' => $notaFinal,
            'costo_extra' => $costoExtraTotal
        ]);

        return redirect()->route('mesero.carrito', $mesa);
    }

    public function carrito(Mesa $mesa)
    {
        $orden = \App\Models\Orden::where('mesa_id', $mesa->id)
            ->whereIn('estatus', ['pendiente', 'cocinando', 'listo']) 
            ->with('detalles.producto')
            ->latest() // Por si hubiera varias, toma la última
            ->first();

        return view('mesero.carrito', compact('mesa', 'orden'));
    }

    public function historial(Request $request)
    {
        $query = \App\Models\Orden::where('usuario_id', \Illuminate\Support\Facades\Auth::id())
            ->where('estatus', 'pagado')
            ->with(['mesa', 'detalles.producto']) 
            ->orderBy('created_at', 'desc');

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

        $ordenes = $query->paginate(10)->withQueryString();

        return view('mesero.historial', compact('ordenes'));
    }

    public function confirmarOrden(Mesa $mesa)
    {
        $orden = Orden::where('mesa_id', $mesa->id)
            ->where('estatus', 'pendiente')
            ->first();

        if ($orden) {
            $total = $orden->detalles->sum(function ($detalle) {
                return $detalle->cantidad * $detalle->precio_unitario;
            });

            $orden->update([
                'estatus' => 'cocinando',
                'total' => $total
            ]);

            $mesa->update(['estado' => 'ocupada']);
        }

        return redirect()->route('mesero.dashboard')->with('success', 'Orden enviada a cocina');
    }

    public function misOrdenes()
    {
        $ordenes = \App\Models\Orden::where('usuario_id', \Illuminate\Support\Facades\Auth::id())
            ->whereIn('estatus', ['pendiente', 'cocinando', 'listo'])
            ->with(['mesa', 'detalles'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mesero.mis-ordenes', compact('ordenes'));
    }

    public function ticket(Mesa $mesa)
    {
        $orden = \App\Models\Orden::where('mesa_id', $mesa->id)
            ->whereIn('estatus', ['pendiente', 'cocinando', 'listo'])
            ->latest()
            ->firstOrFail();
        $orden->update(['estatus' => 'pagado']);
        $mesa->update(['estado' => 'disponible']);
        return view('mesero.ticket', compact('orden', 'mesa'));
    }
}
