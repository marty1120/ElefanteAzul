<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $usuarioGoogle = Socialite::driver('google')->user();
            $existeUsuario = Usuario::where('google_id', $usuarioGoogle->id)->first();

            if ($existeUsuario) {
                Auth::login($existeUsuario);
                return redirect()->route('citas.index');
            } else {
                $datos = array();
                $datos['username'] = $usuarioGoogle->email;
                $datos['google_id'] = $usuarioGoogle->id;
                $datos['password'] = Hash::make('password');
                $nuevoUsuario = Usuario::create($datos);

                return redirect()->route('usuarios.login')->withErrors([
                    'google' => 'El usuario de Google no existe en la base de datos pero te hemos registrado, intenta loguearte de nuevo',
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('usuarios.login')->withErrors([
                'google' => $e->getMessage()
            ]);
        }
    }
}
