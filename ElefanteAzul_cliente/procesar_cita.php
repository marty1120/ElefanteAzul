<?php
$urlApi = "http://localhost/elefanteazul/public/api/citas";

$data = [
    'nombre' => $_POST['nombre'],
    'telefono' => $_POST['telefono'],
    'coche' => $_POST['coche'],
    'matricula' => $_POST['matricula'],
    'tipo_lavado' => $_POST['tipo_lavado'],
    'fecha_cita' => $_POST['fecha_cita'],
    'llantas' => isset($_POST['limpieza_llantas']) ? 15 : 0,
];

$ch = curl_init($urlApi);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    die('Error en la solicitud: ' . curl_error($ch));
}
curl_close($ch);

if ($statusCode == 201) {
    header('Location: citasexitosa.php');
    exit();
} else {
    $responseArray = json_decode($response, true);
    if ($responseArray && isset($responseArray['message'])) {
        // Persistencia de datos en caso de error
        session_start();
        $_SESSION['error'] = $responseArray['message'];
        $_SESSION['data'] = $_POST;
        header('Location: formulario_citas.php');
        exit();
    } else {
        die('Error al crear la cita: respuesta de la API inválida');
    }
}
?>
