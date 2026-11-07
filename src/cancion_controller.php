<?php
require_once __DIR__ . '/services/acceso.php';
require_once __DIR__ . '/services/song-validation.php';
require_once __DIR__ . '/persistence/songs.php';

$values = [
    'title' => '',
    'artist' => '',
    'category' => '',
    'duration' => '',
    'src' => '',
];
$errors = [];
$statusCode = 200;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $validation = validate_song($_POST);
    $values = $validation['values'];
    $errors = $validation['errors'];

    if ($errors === []) {
        $song = new Cancion()->populate_cancion(null, $values['title'], $values['artist'], $values['duration'], 100, $values['src'], $values['category']);
        $errors = create_song(
            $song
        );

        if ($errors === []) {
            header('Location: canciones.php', true, 303);
            exit;
        }

        $statusCode = 500;
    } else {
        $statusCode = 400;
    }
} elseif ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit('Método no permitido.');
}

http_response_code($statusCode);

$formAction = 'cancion_controller.php';
$submitLabel = 'Guardar canción';
$formTitle = 'Añadir canción';

require __DIR__ . '/views/song-form.php';
