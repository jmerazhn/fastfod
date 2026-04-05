<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        $user = User::where('correo', $request->correo)
                    ->orWhere('nombre', $request->correo)
                    ->first();

        if (!$user || $user->clave !== md5($request->password)) {
            throw ValidationException::withMessages([
                'correo' => 'Las credenciales no son correctas.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
