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
        // Guardamos la mesa en sesión para recordarla
        session(['mesa_activa' => $mesa->id]);

        $categorias = Categoria::all();
        return view('mesero.categorias', compact('mesa', 'categorias'));
    }

    // Pantalla 3: Ver platillos de una categoría
    public function platillos(Mesa $mesa, Categoria $categoria)
    {
        // Cargamos los productos activos de esa categoría
        $productos = $categoria->productos()->where('is_active', true)->get();
        return view('mesero.platillos', compact('mesa', 'categoria', 'productos'));
    }
    
    public function detalle(Mesa $mesa, Producto $producto)
{
    // Cargamos el producto con sus grupos y las opciones de esos grupos
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

        // 1. Sumar Opciones Dinámicas (Checkboxes/Radios)
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

        // 2. NUEVO: Sumar Costo Extra Manual
        $costoManual = $request->input('costo_manual', 0);
        if ($costoManual > 0) {
            $costoExtraTotal += $costoManual;
            $textoOpciones[] = "Extra manual ($" . number_format($costoManual, 2) . ")";
        }

        // Notas
        $notaFinal = implode(', ', $textoOpciones);
        if ($request->notas) {
            $notaFinal .= ($notaFinal ? ". " : "") . "Nota: " . $request->notas;
        }

        // 3. Precio Final Unitario
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

    // PANTALLA 3: Carrito
    public function carrito(Mesa $mesa)
    {
        // Buscamos la orden que esté 'pendiente'
        $orden = Orden::where('mesa_id', $mesa->id)
            ->where('estatus', 'pendiente')
            ->with('detalles.producto')
            ->first();

        return view('mesero.carrito', compact('mesa', 'orden'));
    }

    // ACCIÓN: Mandar a Cocina
    public function confirmarOrden(Mesa $mesa)
    {
        $orden = Orden::where('mesa_id', $mesa->id)
            ->where('estatus', 'pendiente')
            ->first();

        if ($orden) {
            // Calculamos el total sumando los detalles
            $total = $orden->detalles->sum(function ($detalle) {
                return $detalle->cantidad * $detalle->precio_unitario;
            });

            // Actualizamos estatus a 'cocinando' y guardamos el total
            $orden->update([
                'estatus' => 'cocinando',
                'total' => $total
            ]);

            $mesa->update(['estado' => 'ocupada']);
        }

        return redirect()->route('mesero.dashboard')->with('success', 'Orden enviada a cocina');
    }
}
