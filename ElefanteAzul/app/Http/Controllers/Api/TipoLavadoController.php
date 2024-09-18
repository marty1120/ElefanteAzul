<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoLavado;
use Illuminate\Http\Request;

class TipoLavadoController extends Controller
{
    public function index()
    {
        $tipos = TipoLavado::all();
        return response()->json(['data' => $tipos], 200);
    }

    public function verificarDescripcion(Request $request)
    {
        $descripcion = $request->input('descripcion');
        $existe = TipoLavado::where('descripcion', $descripcion)->exists();
        return response()->json(['existe' => $existe], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|unique:tipo_lavado,descripcion',
            'precio' => 'required|numeric|min:0',
            'tiempo' => 'required|integer|min:1'
        ]);

        $tipo = TipoLavado::create($validated);
        return response()->json(['success' => true, 'tipoLavado' => $tipo], 201);
    }

    public function destroy($id)
    {
        $tipoLavado = TipoLavado::find($id);
        if ($tipoLavado) {
            $tipoLavado->delete();
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Tipo de lavado no encontrado'], 404);
        }
    }
}
