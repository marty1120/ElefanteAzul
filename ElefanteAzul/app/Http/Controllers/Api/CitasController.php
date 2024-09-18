<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\TipoLavado;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Cita::with('tipoLavado')->get();
        return response()->json($citas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'required|regex:/^\d{9}$/',
            'coche' => 'required|string',
            'matricula' => 'required|regex:/^[0-9]{4}[A-Z]{3}$/',
            'tipo_lavado' => 'required|exists:tipo_lavado,id',
            'fecha_cita' => 'required|date',
            'llantas' => 'nullable|numeric' // Permitir valor nulo o numérico
        ]);

        // Agregar UUID antes de guardar
        $validated['id'] = (string) Str::uuid();
        $fechaCita = $request->input('fecha_cita');
        
        // Generar hora de entrada aleatoria
        $horaEntrada = mt_rand(8, 17); // entre las 8 AM y 5 PM
        $minutoEntrada = mt_rand(0, 59);
        
        // Generar hora de salida basada en la hora de entrada + duración del lavado
        $tipoLavado = TipoLavado::find($validated['tipo_lavado']);
        $duracionLavado = $tipoLavado->tiempo;
        $horaSalida = $horaEntrada + floor($duracionLavado / 60);
        $minutoSalida = $minutoEntrada + ($duracionLavado % 60);
        
        if ($minutoSalida >= 60) {
            $horaSalida++;
            $minutoSalida -= 60;
        }
        
        $validated['entrada'] = $fechaCita . ' ' . str_pad($horaEntrada, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutoEntrada, 2, '0', STR_PAD_LEFT);
        $validated['salida'] = $fechaCita . ' ' . str_pad($horaSalida, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutoSalida, 2, '0', STR_PAD_LEFT);

        // Calcular el precio total
        $precioTotal = $tipoLavado->precio;
        if ($request->filled('llantas')) {
            $precioTotal += $request->llantas;
        }
        $validated['precio'] = $precioTotal;

        // Crear la cita
        $cita = Cita::create($validated);
        
        return response()->json($cita, 201);
    }
}
