<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\TipoLavado;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Cita::with('tipoLavado')->get();
        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        $opcionesLavado = TipoLavado::all();
        return view('citas.create', compact('opcionesLavado'));
    }

    public function store(Request $request)
    {

        
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'fecha_cita' => 'required|date',
            'tipo_lavado' => 'required|exists:tipo_lavado,id',
            'nombre' => 'required|string',
            'telefono' => 'required|regex:/^\d{9}$/',
            'coche' => 'required|string',
            'matricula' => 'required|regex:/^[0-9]{4}[A-Z]{3}$/',
        ]);

        $validatedData['id'] = (string) Str::uuid();
        $fechaCita = $request->input('fecha_cita');
        
        // Generar hora de entrada aleatoria
        $horaEntrada = mt_rand(8, 17); // entre las 8 AM y 5 PM
        $minutoEntrada = mt_rand(0, 59);
        
        // Generar hora de salida basada en la hora de entrada + duración del lavado
        $tipoLavado = TipoLavado::find($validatedData['tipo_lavado']);
        $duracionLavado = $tipoLavado->tiempo;
        $horaSalida = $horaEntrada + floor($duracionLavado / 60);
        $minutoSalida = $minutoEntrada + ($duracionLavado % 60);
        
        if ($minutoSalida >= 60) {
            $horaSalida++;
            $minutoSalida -= 60;
        }
        
        $validatedData['entrada'] = $fechaCita . ' ' . str_pad($horaEntrada, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutoEntrada, 2, '0', STR_PAD_LEFT);
        $validatedData['salida'] = $fechaCita . ' ' . str_pad($horaSalida, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutoSalida, 2, '0', STR_PAD_LEFT);
        
        // Calcula el precio total
        $precioTotal = $tipoLavado->precio;
        if ($request->has('limpiezaLlantas')) {
            $precioTotal += $request->limpiezaLlantas;
        }
        $validatedData['precio'] = $precioTotal;
        try {
            // Crear la cita
            Cita::create($validatedData);
        } catch (\Exception $e) {
            // Manejar la excepción si algo va mal durante la creación de la cita
            report($e);
            return back()->withInput()->withErrors(['error' => 'No se pudo guardar la cita.']);
        }

        return redirect()->route('citas.index');
    }
    
}
