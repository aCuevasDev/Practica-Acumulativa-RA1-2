<?php require_once(dirname(__DIR__) . "/services/sesion.php"); ?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Añadir canción</title>
    <link rel="stylesheet" href="../assets/form.css" />
</head>

<body>
    <h1>Añadir canción</h1>
    <form action="../10-formulario.php" method="post">
        <p>
            <label for="title">Título:</label><br />
            <input type="text" id="title" name="title" required />
        </p>
        <p>
            <label for="artist">Artista:</label><br />
            <input type="text" id="artist" name="artist" required />
        </p>
        <p>
            <label for="category">Categoría:</label><br />
            <select id="category" name="category">
                <option value=""></option>
                <option value="electronic">Electrónica</option>
                <option value="rock">Rock</option>
                <option value="soundtrack">Banda sonora</option>
                <option value="all">Todo</option>
            </select>
        </p>
        <p>
            <label for="duration">Duración (segundos):</label><br />
            <input type="number" id="duration" name="duration" min="1" max="1800" required />
        </p>
        <p>
            <label for="src">Archivo (ruta del mp3):</label><br />
            <input type="text" id="src" name="src" placeholder="songs/artista-cancion.mp3" required />
        </p>
        <button type="submit">Enviar</button>
    </form>
    <?= csrf_field() ?>
</body>

</html>