<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Traemos usuarios Y roles (para el select)
        $users = User::with('rol')->get();
        $roles = Role::all(); 
        
        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.crear_usuario', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol_id' => ['required', 'exists:roles,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'is_active' => true, // Nacen activos
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    // --- NUEVAS FUNCIONES ---

    public function updateRole(Request $request, User $user)
    {
        // Evitar que uno mismo se quite el rol de admin y se bloquee
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $request->validate(['rol_id' => 'required|exists:roles,id']);
        
        $user->update(['rol_id' => $request->rol_id]);

        return back()->with('success', 'Rol actualizado.');
    }

    public function toggleStatus(User $user)
{
    if ($user->id === Auth::id()) {
        return back()->with('error', 'No puedes desactivar tu propia cuenta.');
    }

    // Cambia de true a false, o de false a true
    $user->update(['is_active' => !$user->is_active]);

    return back()->with('success', 'El estado del usuario ha sido actualizado.');
}
}