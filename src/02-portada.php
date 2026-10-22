<?php
ob_start();
require_once("01-bienvenida.php");
$mensajeBienvenida = trim(ob_get_clean());
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jukebox | Portada</title>
</head>

<body>
    <h1><?= htmlspecialchars($mensajeBienvenida, ENT_QUOTES, 'UTF-8') ?></h1>
    <h3>WIP | En Construcción</h3>
</body>

</html>