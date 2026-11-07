<?php

require_once(dirname(__DIR__) . "/services/sesion.php");
require_once(dirname(__DIR__) . "/services/song-validation.php");

$errors = $errors ?? [];
$values = $values ?? [
    'title' => '',
    'artist' => '',
    'category' => '',
    'duration' => '',
    'src' => '',
];
$formAction = $formAction ?? 'cancion_controller.php';
$submitLabel = $submitLabel ?? 'Guardar canción';
$formTitle = $formTitle ?? 'Añadir canción';

$categoryLabels = [
    'electronic' => 'Electrónica',
    'rock' => 'Rock',
    'soundtrack' => 'Banda sonora',
];
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($formTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/form.css" />
</head>

<body>
    <h1><?= htmlspecialchars($formTitle, ENT_QUOTES, 'UTF-8') ?></h1>
    <form action="<?= htmlspecialchars($formAction, ENT_QUOTES, 'UTF-8') ?>" method="post">
        <?php if ($errors !== []): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p>
            <label for="title">Título:</label><br />
            <input type="text" id="title" name="title" maxlength="80"
                value="<?= htmlspecialchars((string) $values['title'], ENT_QUOTES, 'UTF-8') ?>" required />
        </p>
        <p>
            <label for="artist">Artista:</label><br />
            <input type="text" id="artist" name="artist" maxlength="80"
                value="<?= htmlspecialchars((string) $values['artist'], ENT_QUOTES, 'UTF-8') ?>" required />
        </p>
        <p>
            <label for="category">Categoría:</label><br />
            <select id="category" name="category" required>
                <option value="">Selecciona una categoría</option>
                <?php foreach (ALLOWED_SONG_CATEGORIES as $category): ?>
                    <option value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>"
                        <?= (string) $values['category'] === $category ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoryLabels[$category] ?? $category, ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="duration">Duración (segundos):</label><br />
            <input type="number" id="duration" name="duration" min="1" max="1800" step="1"
                value="<?= htmlspecialchars((string) $values['duration'], ENT_QUOTES, 'UTF-8') ?>" required />
        </p>
        <p>
            <label for="src">Archivo de audio:</label><br />
            <input type="text" id="src" name="src"
                value="<?= htmlspecialchars((string) $values['src'], ENT_QUOTES, 'UTF-8') ?>" required />
        </p>

        <?= csrf_field() ?>

        <button type="submit"><?= htmlspecialchars($submitLabel, ENT_QUOTES, 'UTF-8') ?></button>
    </form>
    <p><a href="canciones.php">Volver al catálogo</a></p>
</body>

</html>
