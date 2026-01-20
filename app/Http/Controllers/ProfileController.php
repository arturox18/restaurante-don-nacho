<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    // 1. Obtenemos los datos validados (Nombre, Email, Password vacío...)
    $validatedData = $request->validated();

    // 2. ¡IMPORTANTE! Quitamos el password de esta lista.
    // Si no lo quitamos, 'fill' intentará guardar un NULL en la base de datos y dará error.
    if (array_key_exists('password', $validatedData)) {
        unset($validatedData['password']);
    }

    // 3. Llenamos los datos básicos (Nombre y Correo) usando la lista limpia
    $request->user()->fill($validatedData);

    // Si cambió el correo, reseteamos la verificación
    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    // 4. Actualizar Foto (Si subieron una nueva)
    if ($request->hasFile('profile_photo')) {
        // Borrar foto anterior si quisieras, aquí solo guardamos la nueva
        $path = $request->file('profile_photo')->store('profiles', 'public');
        $request->user()->profile_photo = $path;
    }

    // 5. Actualizar Contraseña SOLO si el usuario escribió algo
    if ($request->filled('password')) {
        $request->user()->password = Hash::make($request->password);
    }

    // 6. Guardar todo
    $request->user()->save();

    return Redirect::route('profile.show')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
