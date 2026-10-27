<?php
require_once(__DIR__ . "/07-catalogo.php");
require_once __DIR__ . '/class/Response.php';

/** @var Cancion[] $songs */
//$songs;

$category = $_GET['category'] ?? 'todas';
$allowed = ['todas', 'electronica', 'rock', 'bandas-sonoras'];

if (strtolower($category) === 'todas') {
    $httpCode = 200;
    $filteredSongs = $songs;
} else if (in_array($category, $allowed)) {
    $httpCode = 200;
    $filteredSongs = array_filter($songs, 'hasCategory');
} else {
    $httpCode = 400;
    $filteredSongs = [];
}

Response::send($httpCode, ['songs' => $filteredSongs]);


function hasCategory(Cancion $song): bool
{
    return strtolower($song->category) === strtolower($category);
}