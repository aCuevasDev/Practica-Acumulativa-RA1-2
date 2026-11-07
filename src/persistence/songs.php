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

        return write_songs($handle, $songs);
    } catch (JsonException | UnexpectedValueException $e) {
        return ['No se pudo procesar el almacén de canciones.'];
    } finally {
        if ($locked) {
            flock($handle, LOCK_UN);
        }

        fclose($handle);
    }

}


function find_song_position(array $songs, string $id): ?int
{
    foreach ($songs as $position => $song) {
        if (is_array($song) && (string) ($song['id'] ?? '') === $id) {
            return $position;
        }
    }

    return null;
}


function update_song(string $id, Cancion $song): array
{
    global $SONGS_JSON_SRC;

    $handle = @fopen($SONGS_JSON_SRC, 'r+');

    if ($handle === false) {
        return ['found' => false, 'errors' => ['No se pudo abrir el almacén de canciones.']];
    }

    $locked = false;
    $found = false;
    $errors = [];

    try {
        if (!flock($handle, LOCK_EX)) {
            return ['found' => false, 'errors' => ['No se pudo bloquear el almacén de canciones.']];
        }

        $locked = true;
        $json = stream_get_contents($handle);

        if ($json === false) {
            return ['found' => false, 'errors' => ['No se pudo leer el almacén de canciones.']];
        }

        $store = decode_songs($json);
        $position = find_song_position($store['songs'], $id);

        if ($position === null) {
            return ['found' => false, 'errors' => []];
        }

        $found = true;
        $store['songs'][$position]['name'] = $song->name;
        $store['songs'][$position]['author'] = $song->author;
        $store['songs'][$position]['category'] = $song->category;
        $store['songs'][$position]['duration'] = $song->duration;
        $store['songs'][$position]['file'] = $song->file;
        $errors = write_songs($handle, $store);
    } catch (JsonException | UnexpectedValueException $e) {
        $errors = ['No se pudo procesar el almacén de canciones.'];
    } finally {
        if ($locked) {
            flock($handle, LOCK_UN);
        }

        fclose($handle);
    }

    return ['found' => $found, 'errors' => $errors];
}


function delete_song(string $id): array
{
    global $SONGS_JSON_SRC;

    $handle = @fopen($SONGS_JSON_SRC, 'r+');

    if ($handle === false) {
        return ['found' => false, 'errors' => ['No se pudo abrir el almacén de canciones.']];
    }

    $locked = false;
    $found = false;
    $errors = [];

    try {
        if (!flock($handle, LOCK_EX)) {
            return ['found' => false, 'errors' => ['No se pudo bloquear el almacén de canciones.']];
        }

        $locked = true;
        $json = stream_get_contents($handle);

        if ($json === false) {
            return ['found' => false, 'errors' => ['No se pudo leer el almacén de canciones.']];
        }

        $songs = decode_songs($json);
        $position = find_song_position($songs['songs'], $id);

        if ($position === null) {
            return ['found' => false, 'errors' => []];
        }

        $found = true;
        unset($songs['songs'][$position]);
        $songs['songs'] = array_values($songs['songs']);
        $errors = write_songs($handle, $songs);
    } catch (JsonException | UnexpectedValueException $e) {
        $errors = ['No se pudo procesar el almacén de canciones.'];
    } finally {
        if ($locked) {
            flock($handle, LOCK_UN);
        }

        fclose($handle);
    }

    return ['found' => $found, 'errors' => $errors];
}


function write_songs($handle, array $store): array
{
    try {
        $json = json_encode(
            $store,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );
    } catch (JsonException $e) {
        return ['No se pudo procesar el almacén de canciones.'];
    }

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
