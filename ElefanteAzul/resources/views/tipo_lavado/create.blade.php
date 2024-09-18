@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Nuevo Tipo de Lavado</h2>
    <form id="tipoLavadoForm">
        @csrf
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion" name="descripcion" class="form-control" required>
            <div id="descripcionError" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" class="form-control" required>
            <div id="precioError" class="text-danger"></div>
        </div>
        <div class="form-group">
            <label for="tiempo">Tiempo (en minutos):</label>
            <input type="number" id="tiempo" name="tiempo" class="form-control" required>
            <div id="tiempoError" class="text-danger"></div>
        </div>
        <button type="button" onclick="submitForm()" class="btn btn-primary">Registrar</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('descripcion').addEventListener('input', function() {
        const descripcion = this.value;
        const descripcionError = document.getElementById('descripcionError');
        descripcionError.textContent = '';

        if (descripcion) {
            fetch('{{ route('api.tipo_lavado.verificar') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ descripcion })
            })
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    descripcionError.textContent = 'Ya existe un tipo de lavado con esa descripción.';
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
});

function submitForm() {
    const descripcion = document.getElementById('descripcion').value;
    const precio = document.getElementById('precio').value;
    const tiempo = document.getElementById('tiempo').value;

    document.getElementById('descripcionError').textContent = '';
    document.getElementById('precioError').textContent = '';
    document.getElementById('tiempoError').textContent = '';

    let valid = true;
    if (!descripcion) {
        document.getElementById('descripcionError').textContent = 'La descripción no puede estar vacía.';
        valid = false;
    }
    if (!precio || precio <= 0) {
        document.getElementById('precioError').textContent = 'El precio debe ser un número positivo.';
        valid = false;
    }
    if (!tiempo || tiempo <= 0) {
        document.getElementById('tiempoError').textContent = 'El tiempo debe ser un número positivo.';
        valid = false;
    }

    if (valid) {
        fetch('{{ route('api.tipo_lavado.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ descripcion, precio, tiempo })
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error en la solicitud');
            }
        })
        .then(data => {
            if (data.success) {
                alert('Tipo de lavado registrado exitosamente.');
                window.location.href = '{{ route('tipo_lavado.index') }}';
            } else {
                alert('Error al registrar el tipo de lavado.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
</script>
@endsection
