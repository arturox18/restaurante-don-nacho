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
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            // Movemos físicamente a la vitrina pública
            $imagen->move(public_path('storage/productos'), $nombreImagen);
            
            // Guardamos la ruta en la base de datos
            $data['imagen'] = 'productos/' . $nombreImagen;
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

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            $imagen->move(public_path('storage/productos'), $nombreImagen);
            $data['imagen'] = 'productos/' . $nombreImagen;
        }

        // Crear producto
        Producto::create($data);

        return redirect()->route('menu.index')->with('success', 'Platillo creado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen && file_exists(public_path('storage/' . $producto->imagen))) {
            unlink(public_path('storage/' . $producto->imagen));
        }

        $producto->delete();

        return redirect()->route('menu.index')->with('success', 'Platillo eliminado correctamente.');
    }
}