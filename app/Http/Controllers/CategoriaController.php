<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        Categoria::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('menu.index')->with('success', 'Categoría creada correctamente.');
    }
}