<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'correo'   => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'correo.required'   => 'El correo es requerido',
            'password.required' => 'La contraseña es requerida',
        ]);

        $mesero = User::where('correo', $request->correo)
                      ->orWhere('nombre', $request->correo)
                      ->first();

        if ($mesero && $mesero->clave === md5($request->password)) {
            Auth::guard('web')->login($mesero, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/mesas');
        }

        $usuario = Usuario::where('correo', $request->correo)
                          ->orWhere('nombre', $request->correo)
                          ->first();

        if ($usuario && $usuario->clave === md5($request->password)) {
            Auth::guard('admin')->login($usuario, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        throw ValidationException::withMessages([
            'correo' => 'Las credenciales no son correctas.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
