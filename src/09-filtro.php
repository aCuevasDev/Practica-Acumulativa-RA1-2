<?php
require_once(__DIR__ . "/services/read-json.php");
require_once __DIR__ . '/class/ResponseBuilder.php';

/** @var Cancion[] $songs */
//$songs;

$category = $_GET['category'] ?? 'all';
//$allowed = ['todas', 'electronica', 'rock', 'bandas-sonoras'];
$allowed = ['all', 'electronic', 'rock', 'soundtrack'];

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

ResponseBuilder::make()
    ->status($httpCode)
    ->append(['songs' => $filteredSongs])
    ->send();


function hasCategory(Cancion $song): bool
{
    global $category;
    return strtolower($song->category) === strtolower($category);
}