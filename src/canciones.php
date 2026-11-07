<?php
require_once __DIR__ . '/services/acceso.php';
require_once __DIR__ . '/persistence/songs.php';
require_once __DIR__ . '/class/Cancion.php';

try {
    $songs = read_songs();
} catch (Exception $e) {
    http_response_code(500);
    exit('No se pudo leer el catálogo de canciones.');
}

function song_duration(array $song): string
{
    $cancion = new Cancion();
    $cancion->populate_cancion(
        $song['id'] ?? '',
        $song['name'] ?? '',
        $song['author'] ?? '',
        (int) ($song['duration'] ?? 0),
        0,
        $song['file'] ?? '',
        $song['category'] ?? ''
    );

    return $cancion->duracionLegible();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Catálogo de canciones</title>
    <link rel="stylesheet" href="assets/canciones.css" />
</head>

<body>
    <header class="catalog-header">
        <h1>Catálogo de canciones</h1>
        <nav>
            <a href="home.php">Inicio</a>
            <a href="cancion_controller.php">Añadir canción</a>
        </nav>
    </header>

    <?php if ($songs === []): ?>
        <p class="empty">Todavía no hay canciones.</p>
    <?php else: ?>
        <ul class="song-list">
            <?php foreach ($songs as $song): ?>
                <?php
                if (!is_array($song)) {
                    continue;
                }

                $id = (string) ($song['id'] ?? '');
                $title = (string) ($song['name'] ?? '');
                $artist = (string) ($song['author'] ?? '');
                $category = (string) ($song['category'] ?? '');
                $file = (string) ($song['file'] ?? '');
                ?>
                <li class="song-card">
                    <h2><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h2>
                    <p><strong>Artista:</strong> <?= htmlspecialchars($artist, ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Categoría:</strong> <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Duración:</strong> <?= htmlspecialchars(song_duration($song), ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Audio:</strong> <code><?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?></code></p>
                    <div class="song-actions">
                        <a href="cancion-editar.php?id=<?= urlencode($id) ?>">Editar</a>
                        <a class="delete-link" href="cancion-eliminar.php?id=<?= urlencode($id) ?>">Eliminar</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>