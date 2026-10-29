<?php
require_once(__DIR__ . "/services/read-json.php");
require_once __DIR__ . '/class/Response.php';

/** @var Cancion[] $songs */
//$songs;

$category = $_GET['category'] ?? 'all';
//$allowed = ['todas', 'electronica', 'rock', 'bandas-sonoras'];
$allowed = ['all', 'electronic', 'rock', 'soundtrack'];

// TODO SWITCH??
// if (!is_a($category, 'string')) {
//     $httpCode = 400;
//     $filteredSongs = [];
// } else 

$httpCode = 400;
$filteredSongs = [];

if (is_string($category)) {
    if (strtolower($category) === 'all') {
        $httpCode = 200;
        $filteredSongs = $songs;
    } else if (in_array($category, $allowed)) {
        $httpCode = 200;
        $filteredSongs = array_values(array_filter($songs, 'hasCategory'));
    }
}

Response::send($httpCode, ['songs' => $filteredSongs]);


function hasCategory(Cancion $song): bool
{
    global $category;
    return strtolower($song->category) === strtolower($category);
}