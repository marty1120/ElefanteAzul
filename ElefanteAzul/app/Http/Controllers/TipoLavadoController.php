<?php

namespace App\Http\Controllers;

use App\Models\TipoLavado;
use Illuminate\Http\Request;

class TipoLavadoController extends Controller
{
    public function index()
    {
        return view('tipo_lavado.index');
    }

    // Muestra el formulario para crear un nuevo tipo de lavado
    public function create()
    {
        return view('tipo_lavado.create');
    }

    // Crea un nuevo tipo de lavado
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|unique:tipo_lavado,descripcion',
            'precio' => 'required|numeric|min:0',
            'tiempo' => 'required|integer|min:1'
        ]);

        $tipo = TipoLavado::create($validated);
        return redirect()->route('tipo_lavado.index');
    }

    // Obtener todos los tipos de lavado
    public function getTipoLavados()
    {
        $tipos = TipoLavado::all();
        return response()->json(['data' => $tipos]);
    }

    // Eliminar un tipo de lavado
    public function destroy($id)
    {
        $tipoLavado = TipoLavado::find($id);
        if ($tipoLavado) {
            $tipoLavado->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tipo de lavado no encontrado']);
        }
    }
}
