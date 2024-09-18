@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Listado de Citas</h1>
        <div>
            @if (Auth::check())
                <span class="mr-3">Bienvenido, {{ Auth::user()->username }}</span>
                <form action="{{ route('usuarios.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            @endif
        </div>
    </div>

    <a href="{{ route('citas.create') }}" class="btn btn-primary my-3">Agendar Nueva Cita</a>
    <a href="{{ route('tipo_lavado.create') }}" class="btn btn-secondary my-3">Registrar Nuevo Tipo de Lavado</a> 
    <a href="{{ route('tipo_lavado.index') }}" class="btn btn-info my-3">Ver Tipos de Lavado</a>
    
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Fecha y Hora</th>
                <th>Modelo de coche y Matrícula</th>
                <th>Tipo de Lavado</th>
                <th>Precio Total</th>
                <th>Contacto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
                <tr>
                    <td>{{ date('d/m/Y H:i', strtotime($cita->entrada)) }} - {{ date('H:i', strtotime($cita->salida)) }}</td>
                    <td>{{ $cita->coche }} {{ $cita->matricula }}</td>
                    <td>{{ optional($cita->tipoLavado)->descripcion }}</td>
                    <td>{{ number_format($cita->precio, 2) }}€</td>
                    <td>{{ $cita->nombre }}, {{ $cita->telefono }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
