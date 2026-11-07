<?php
// no voy a reaprovechar 10-formulario.php porque lo hice para que devolviese una respuesta http como se pedía en el ejercicio y ahora se me pide que la toque otra vez y la adapte para validar 
// y estoy cansado jefe, esto en realidad debería ir en el modelo de cancion pero ya me ha mareado tanto esta práctica que lo voy a dejar aquí
require_once(dirname(__FILE__) . "/class/Cancion.php");
require_once __DIR__ . '/class/Response.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = is_string($_POST['title']) ? trim($_POST['title']) : '';
    $artist = is_string($_POST['artist']) ? trim($_POST['artist']) : '';
    $category = is_string($_POST['category']) ? trim($_POST['category']) : '';
    $duration = filter_var($_POST['duration'], FILTER_VALIDATE_INT) ? trim($_POST['duration']) : 0;
    $src = is_string($_POST['src']) ? trim($_POST['src']) : '';
} else {
    return new Exception('Wrong request method');
}

if ((empty($title) || empty($artist) || empty($category))) {
    return new Exception('Fields: title, artist and category must be valid and not empty');
}

if (!($duration > 0 && $duration < 1800)) {
    return new Exception('Invalid duration :' . $duration . ' Must be between 0 and 1800');
}

$song = new Cancion()->populate_cancion(uniqid(), $title, $artist, $duration, 0, $src, $category);

echo var_dump($song);