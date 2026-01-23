<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Traemos las categorías que tengan productos que coincidan con la búsqueda
        $categorias = Categoria::whereHas('productos', function ($query) use ($search) {
                if ($search) {
                    $query->where('nombre', 'like', "%{$search}%");
                }
            })
            ->with(['productos' => function ($query) use ($search) {
                if ($search) {
                    $query->where('nombre', 'like', "%{$search}%");
                }
            }])
            ->get();

        // Si es búsqueda AJAX (tiempo real)
        if ($request->ajax()) {
            return view('menu.partials.menu-list', compact('categorias'))->render();
        }

        return view('menu.index', compact('categorias'));
    }

    // Pantalla para editar un producto
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('menu.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'categoria_id' => 'required|exists:categorias,id',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:2048',
    ]);

    $data = $request->except('imagen');

    if ($request->hasFile('imagen')) {
        $path = $request->file('imagen')->store('productos', 'public');
        $data['imagen'] = $path;
    }

    $producto->update($data);

    return redirect()->route('menu.index')->with('success', 'Producto actualizado.');
}

    public function toggleStatus(Producto $producto)
    {
        $producto->update(['is_active' => !$producto->is_active]);
        return back()->with('success', 'Estado del producto actualizado.');
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('menu.create', compact('categorias'));
    }

    // 2. Guardar el nuevo platillo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('imagen');

        // Procesar imagen si la subieron
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        // Crear producto (nace activo por defecto según la migración)
        Producto::create($data);

        return redirect()->route('menu.index')->with('success', 'Platillo creado correctamente.');
    }
}