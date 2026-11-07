<?php
require_once __DIR__ . '/services/acceso.php';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inicio</title>
    <link rel="stylesheet" href="assets/form.css" />
</head>

<body>
    <h1>Hola, <?= htmlspecialchars($_SESSION['alias'], ENT_QUOTES, 'UTF-8') ?></h1>
    <p><a href="12-catalogo-json.php">Ir al catálogo</a></p>

    <form action="logout.php" method="post">
        <?= csrf_field() ?>
        <button type="submit">Salir</button>
    </form>
</body>

</html>