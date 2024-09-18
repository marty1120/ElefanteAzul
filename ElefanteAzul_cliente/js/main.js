document.addEventListener("DOMContentLoaded", function() {
    fetchTiposLavado();
    fetchCitas();
});

function fetchTiposLavado() {
    fetch('http://localhost/elefanteazul/public/api/tipo_lavado')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta de la API de tipos de lavado:', data); // Verificar el contenido de la respuesta
        const select = document.getElementById('tipo_lavado');
        if (!select) {
            console.error('Elemento con id "tipo_lavado" no encontrado');
            return;
        }
        // Asegúrate de que 'data' contiene la clave 'data' y es un array
        if (data && Array.isArray(data.data)) {
            data.data.forEach(tipo => {
                console.log('Procesando tipo de lavado:', tipo); // Añadir depuración para cada tipo de lavado
                let option = new Option(`${tipo.descripcion} - ${tipo.precio}€`, tipo.id);
                select.add(option);
            });
        } else {
            console.error('Error: Formato de datos incorrecto', data);
        }
    })
    .catch(error => console.error('Error en fetchTiposLavado:', error));
}

function fetchCitas() {
    fetch('http://localhost/elefanteazul/public/api/citas')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta de la API de citas:', data); // Verificar el contenido de la respuesta
        const list = document.getElementById('citasList');
        if (!list) {
            console.error('Elemento con id "citasList" no encontrado en el DOM');
            return;
        }
        list.innerHTML = ''; // Clear current list
        if (Array.isArray(data)) {
            data.forEach(cita => {
                console.log('Procesando cita:', cita); // Añadir depuración para cada cita
                let item = document.createElement('div');
                item.textContent = `${cita.nombre} - ${cita.fecha_cita}`;
                list.appendChild(item);
            });
        } else {
            console.error('Error: Formato de datos incorrecto', data);
        }
    })
    .catch(error => console.error('Error en fetchCitas:', error));
}
