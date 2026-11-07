<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Eliminar canción</title>
    <link rel="stylesheet" href="assets/form.css" />
</head>

<body>
    <h1>Eliminar canción</h1>
    <form action="cancion-eliminar.php" method="post">
        <p>¿Seguro que quieres eliminar «<?= htmlspecialchars($songTitle, ENT_QUOTES, 'UTF-8') ?>»?</p>
        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $songId, ENT_QUOTES, 'UTF-8') ?>" />
        <?= csrf_field() ?>
        <button type="submit">Confirmar eliminación</button>
    </form>
    <p><a href="canciones.php">Cancelar</a></p>
</body>

</html>
