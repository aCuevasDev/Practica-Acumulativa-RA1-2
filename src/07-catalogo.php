<?php
require_once(__DIR__ . "/services/read-json.php");

foreach ($songs as $song) {
    var_dump($song->get_associative_array());
}


if (empty($songs)) {
    echo 'Todavía no hay canciones';
}
