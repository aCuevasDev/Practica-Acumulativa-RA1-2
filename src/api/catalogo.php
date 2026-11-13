<?php
require_once dirname(__DIR__) . '/services/sesion.php';
require_once dirname(__DIR__) . '/persistence/songs.php';
require_once dirname(__DIR__) . '/class/Cancion.php';
require_once dirname(__DIR__) . '/class/ResponseBuilder.php';


 if (!isset($_SESSION['usuario_id'])) {
     ResponseBuilder::make()->status(401)->send();
     exit;
 }

 $action = $_GET['action'];
 $method = $_SERVER['REQUEST_METHOD'];

 if (strcasecmp($action, 'list') && strcasecmp($method, 'GET') ) 
{
    read_songs_and_response()
}
 if (strcasecmp($action,'create') && strcasecmp($method,'POST'))
{ 
    $song = new Cancion()->populate_cancion(null, $_POST['title'], $_POST['artist'], $_POST['duration'], 100, $_POST['src'], $_POST['category']);
    validate_song($song); // TODO finish validations
    create_songs_and_response($song)
}
  if (strcasecmp($action,'update') && strcasecmp($method,'POST')) // WHY NOT PUT
{ 
    // TODO
}
   if (strcasecmp($action,'delete') && strcasecmp($method,'POST')) // WHY NOT DELETE
{ 
    // TODO
}


function read_songs_and_response()
{
    try {
    $songs = read_songs();
    $json_response = new JSONResponse(true, $songs);

    ResponseBuilder::make()
        ->status(200)
        ->body($json_response)
        ->send();

    } catch (Exception $e) {
        $json_response = new JSONResponse(false, null, 'No se pudo leer el catálogo de canciones. Error: ' . $e->getMessage());
        ResponseBuilder::make()
            ->status(500)
            ->body($json_response)
            ->send();
    }
}

function create_songs_and_response(Cancion $song)
{
    try {
        $songs = create_song($song);
        $song = end($songs);
        $json_response = new JSONResponse(true, $song);
        ResponseBuilder::make()
                        ->status(200)
                        ->body($json_response)
                        ->send();
    } catch (Exception $e) {
        $json_response = new JSONResponse(false, null, 'Error al crear la canción: ' . $e->getMessage());
        ResponseBuilder::make()
        ->status(500)
        ->body($json_response)
        ->send();
    }
}

?>