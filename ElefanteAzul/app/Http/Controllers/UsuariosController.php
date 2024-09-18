<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('citas.index');
        }

        return view('usuarios.login');
    }

    public function authenticate(Request $request)
    {
        $datos = $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        if (Auth::attempt(['username' => $datos['username'], 'password' => $datos['password']])) {
            $request->session()->regenerate();
            return redirect()->route('citas.index');
        }

        return back()->withErrors([
            'username' => 'El usuario y la contraseña no son correctos',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('usuarios.login');
    }
}
