@extends('layouts.app')

@section('content')
<div class="py-4">
    <h1>Agendar Nueva Cita</h1>
    <form action="{{ route('citas.store') }}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>

        <div class="form-group">
            <label for="coche">Coche (Marca y modelo):</label>
            <input type="text" class="form-control" id="coche" name="coche" required>
        </div>

        <div class="form-group">
            <label for="matricula">Matrícula:</label>
            <input type="text" class="form-control" id="matricula" name="matricula" required>
        </div>

        <div class="form-group">
            <label for="tipoLavado">Tipo de lavado:</label>
            <select class="form-control" id="tipo_lavado" name="tipo_lavado">
                @foreach ($opcionesLavado as $opcion)
                    <option value="{{ $opcion->id }}">{{ $opcion->descripcion }} - {{ $opcion->precio }}€</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
        <label for="fecha_cita">Fecha de la cita:</label>
        <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
        </div>


        <div class="form-check mb-3">
           
            <input type="checkbox" class="form-check-input" id="limpiezaLlantas" name="limpiezaLlantas" value="15">
            <label class="form-check-label" for="limpiezaLlantas">Limpieza de llantas (15€)</label>

        </div>

        <button type="submit" class="btn btn-success">Guardar Cita</button>
    </form>
</div>
@endsection
