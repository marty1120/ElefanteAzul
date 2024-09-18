<?php

function obtenerTiposLavado() {
    $urlApi = "http://localhost/elefanteazul/public/api/tipo_lavado";
    
    $ch = curl_init($urlApi);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
    ]);
    
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        die('Error en la solicitud: ' . curl_error($ch));
    }
    curl_close($ch);
    
    if ($statusCode == 200) {
        $responseArray = json_decode($response, true);
        if ($responseArray && isset($responseArray['data'])) {
            return $responseArray['data'];
        } else {
            die('Error al obtener los tipos de lavado: respuesta de la API inválida');
        }
    } else {
        die('Error al obtener los tipos de lavado: código de estado ' . $statusCode);
    }
}

$tiposLavado = obtenerTiposLavado();

?>
