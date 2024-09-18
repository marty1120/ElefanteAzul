@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Tipos de Lavado</h2>
    <table id="tipoLavadoTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Tiempo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#tipoLavadoTable').DataTable({
        ajax: '{{ route('api.tipo_lavado.index') }}',
        columns: [
            { data: 'descripcion' },
            { data: 'precio' },
            { data: 'tiempo' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `<button class="btn btn-danger btn-sm" onclick="deleteTipoLavado('${data}')">Eliminar</button>`;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.7/i18n/es-ES.json'
        },
        pageLength: 5,
        lengthMenu: [5, 10, 100],
        order: [[0, 'asc']]
    });
});

function deleteTipoLavado(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este tipo de lavado?')) {
        $.ajax({
            url: `/elefanteazul/public/api/tipo_lavado/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Tipo de lavado eliminado exitosamente.');
                    $('#tipoLavadoTable').DataTable().ajax.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error al eliminar el tipo de lavado.');
            }
        });
    }
}

</script>
@endsection
