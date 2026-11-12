<?php
require_once(dirname(__FILE__) . "/class/Cancion.php");
require_once __DIR__ . '/class/ResponseBuilder.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = is_string($_POST['title']) ? trim($_POST['title']) : '';
    $artist = is_string($_POST['artist']) ? trim($_POST['artist']) : '';
    $category = is_string($_POST['category']) ? trim($_POST['category']) : '';
    $duration = filter_var($_POST['duration'], FILTER_VALIDATE_INT) ? trim($_POST['duration']) : 0;
    $src = is_string($_POST['src']) ? trim($_POST['src']) : '';
} else {
    ResponseBuilder::make()
        ->status(400)
        ->append('Wrong Request Method')
        ->send();
}

if ((empty($title) || empty($artist) || empty($category))) {
    ResponseBuilder::make()
        ->status(400)
        ->append('Fields: title, artist and category must be valid and not empty')
        ->send();
}

if (!($duration > 0 && $duration < 1800)) {
    ResponseBuilder::make()
        ->status(400)
        ->append('Invalid duration :' . $duration . ' Must be between 0 and 1800')
        ->send();
}

$song = new Cancion()->populate_cancion(uniqid(), $title, $artist, $duration, 0, $src, $category);

echo var_dump($song);