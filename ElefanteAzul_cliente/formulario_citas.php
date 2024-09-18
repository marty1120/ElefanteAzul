<?php include 'addCita.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - Elefante Azul</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="logo my-4">
            <img src="logo-elefante-azul.png" alt="Logo Elefante Azul">
        </div>
        <h1 class="text-center">Elefante Azul</h1>
        <h2 class="text-center mb-4">Agendar Nueva Cita</h2>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); endif; ?>
        <form action="procesar_cita.php" method="POST" class="mt-3">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($_SESSION['data']['nombre'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required value="<?= htmlspecialchars($_SESSION['data']['telefono'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="coche">Coche (Marca y modelo):</label>
                <input type="text" class="form-control" id="coche" name="coche" required value="<?= htmlspecialchars($_SESSION['data']['coche'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="matricula">Matrícula:</label>
                <input type="text" class="form-control" id="matricula" name="matricula" required value="<?= htmlspecialchars($_SESSION['data']['matricula'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="tipo_lavado">Tipo de lavado:</label>
                <select class="form-control" id="tipo_lavado" name="tipo_lavado" required>
                    <?php foreach ($tiposLavado as $tipo): ?>
                        <option value="<?= htmlspecialchars($tipo['id']) ?>" <?= (isset($_SESSION['data']['tipo_lavado']) && $_SESSION['data']['tipo_lavado'] == $tipo['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo['descripcion']) ?> - <?= htmlspecialchars($tipo['precio']) ?>€
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_cita">Fecha de la cita:</label>
                <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required value="<?= htmlspecialchars($_SESSION['data']['fecha_cita'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="limpieza_llantas">Limpieza de llantas (15€)</label>
                <input type="checkbox" class="form-check-input" id="limpieza_llantas" name="limpieza_llantas" value="15" <?= (isset($_SESSION['data']['llantas']) && $_SESSION['data']['llantas'] == 15) ? 'checked' : '' ?>>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cita</button>
        </form>
        <?php unset($_SESSION['data']); ?>
    </div>

    <script src="js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
