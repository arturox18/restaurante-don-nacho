<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::all();
        return view('mesas.index', compact('mesas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:mesas,nombre',
        ]);

        Mesa::create([
            'nombre' => $request->nombre,
            'estado' => 'disponible'
        ]);

        return back()->with('success', 'Mesa agregada correctamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();
        return back()->with('success', 'Mesa eliminada correctamente.');
    }
}