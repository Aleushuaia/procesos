<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        // Allow bypassing password in local/dev for convenience via env or default
        $bypass = env('LOGIN_NO_PASSWORD', true);

        if ($bypass) {
            $data = $request->validate([
                'email' => 'required|email',
            ], [
                'email.required' => 'El email es requerido',
                'email.email' => 'El email debe ser válido',
            ]);

            $user = \App\Models\User::where('email', $data['email'])->first();

            if ($user) {
                Auth::login($user, $request->filled('remember'));
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', '¡Bienvenido! (bypass)');
            }

            return back()->withInput($request->only('email'))->withErrors(['auth' => 'Usuario no encontrado.']);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser válido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', '¡Bienvenido!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['auth' => 'Las credenciales no son válidas.']);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Sesión cerrada correctamente');
    }
}
