<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Validar credenciales
        $request->authenticate();

        // 2. --- SEGURIDAD: Verificar si está activo ---
        if (!$request->user()->is_active) {

            // Si no está activo, lo sacamos inmediatamente
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Le mandamos un error en la pantalla de login
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Tu cuenta ha sido desactivada. No tienes acceso.',
            ]);
        }
        // ---------------------------------------------

        $request->session()->regenerate();

        // 3. Redirección por rol...
        $rol = $request->user()->rol_id;

        if ($rol === 1) {
            return redirect()->intended(route('dashboard'));
        } elseif ($rol === 2) {
            return redirect()->route('mesero.dashboard');
        } elseif ($rol === 3) {
            return redirect()->route('cocinero.dashboard');
        }

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
