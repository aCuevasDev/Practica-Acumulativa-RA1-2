<?php
require_once(dirname(__DIR__) . "/class/Cancion.php");
$SONGS_JSON_SRC = dirname(__DIR__) . '/PracticaJS/Practica2/songs.json';


function create_song(Cancion $song): array
{
    global $SONGS_JSON_SRC;

    $handle = @fopen($SONGS_JSON_SRC, 'r+');

    if ($handle === false) {
        return ['No se pudo abrir el almacén de canciones.'];
    }

    $locked = false;

    try {
        if (!flock($handle, LOCK_EX)) {
            return ['No se pudo bloquear el almacén de canciones.'];
        }

        $locked = true;

        $json = stream_get_contents($handle);

        if ($json === false) {
            return ['No se pudo leer el almacén de canciones.'];
        }

        $songs = decode_songs($json);
        $newId = next_song_id($songs['songs']);

        $songs['songs'][] = [
            'id' => (string) $newId,
            'name' => $song->name,
            'author' => $song->author,
            'picture' => 'songs/covers/placeholder.svg',
            'file' => $song->file,
            'duration' => $song->duration,
            'category' => $song->category,
        ];

        $json = json_encode(
            $songs,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );

        if (!rewind($handle)) {
            return ['No se pudo volver al inicio del almacén de canciones.'];
        }

        $bytes = fwrite($handle, $json);

        if ($bytes !== strlen($json)) {
            return ['No se pudo escribir el almacén completo de canciones.'];
        }

        if (!ftruncate($handle, strlen($json))) {
            return ['No se pudo recortar el almacén de canciones.'];
        }

        if (!fflush($handle)) {
            return ['No se pudo volcar el almacén de canciones a disco.'];
        }
    } catch (JsonException | UnexpectedValueException $e) {
        return ['No se pudo procesar el almacén de canciones.'];
    } finally {
        if ($locked) {
            flock($handle, LOCK_UN);
        }

        fclose($handle);
    }

    return [];
}


function read_songs(): array
{
    global $SONGS_JSON_SRC;

    $handle = @fopen($SONGS_JSON_SRC, 'rb');

    if ($handle === false) {
        throw new RuntimeException('No se pudo abrir el almacén de canciones.');
    }

    $locked = false;

    try {
        if (!flock($handle, LOCK_SH)) {
            throw new RuntimeException('No se pudo bloquear el almacén de canciones.');
        }

        $locked = true;

        $json = stream_get_contents($handle);

        if ($json === false) {
            throw new RuntimeException('No se pudo leer el almacén de canciones.');
        }

        if (trim($json) === '') {
            return [];
        }

        return decode_songs($json)['songs'];
    } finally {
        if ($locked) {
            flock($handle, LOCK_UN);
        }

        fclose($handle);
    }
}


function decode_songs(string $json): array
{
    $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

    if (
        !is_array($data)
        || !isset($data['songs'])
        || !is_array($data['songs'])
        || !array_is_list($data['songs'])
    ) {
        throw new UnexpectedValueException('El almacén de canciones no tiene un formato válido.');
    }

    return $data;
}


function next_song_id(array $songs): int
{
    $nextId = 1;

    foreach ($songs as $song) {
        if (is_array($song) && isset($song['id']) && is_numeric($song['id'])) {
            $nextId = max($nextId, (int) $song['id'] + 1);
        }
    }

    return $nextId;
}
