<?php

const ALLOWED_SONG_CATEGORIES = ['electronic', 'rock', 'soundtrack'];

function validate_song(array $input): array
{
    $values = [
        'title' => '',
        'artist' => '',
        'category' => '',
        'duration' => '',
        'src' => '',
    ];
    $errors = [];

    $titleInput = $input['title'] ?? null;

    if (!is_string($titleInput)) {
        $errors[] = 'El título no es válido.';
    } else {
        $values['title'] = trim($titleInput);

        if ($values['title'] === '') {
            $errors[] = 'El título es obligatorio.';
        } elseif (mb_strlen($values['title'], 'UTF-8') > 80) {
            $errors[] = 'El título no puede superar los 80 caracteres.';
        }
    }

    $artistInput = $input['artist'] ?? null;

    if (!is_string($artistInput)) {
        $errors[] = 'El artista no es válido.';
    } else {
        $values['artist'] = trim($artistInput);

        if ($values['artist'] === '') {
            $errors[] = 'El artista es obligatorio.';
        }
    }

    $categoryInput = $input['category'] ?? null;
    $category = is_string($categoryInput) ? trim($categoryInput) : '';

    if (!in_array($category, ALLOWED_SONG_CATEGORIES, true)) {
        $errors[] = 'La categoría no es válida.';
    } else {
        $values['category'] = $category;
    }

    $durationInput = $input['duration'] ?? null;

    if (!is_string($durationInput)) {
        $errors[] = 'La duración no es válida.';
    } else {
        $values['duration'] = trim($durationInput);
        $duration = filter_var($values['duration'], FILTER_VALIDATE_INT);

        if ($duration === false || $duration < 1 || $duration > 1800) {
            $errors[] = 'La duración debe ser un entero entre 1 y 1800 segundos.';
        } else {
            $values['duration'] = $duration;
        }
    }

    $srcInput = $input['src'] ?? null;
    $src = is_string($srcInput) ? trim($srcInput) : '';
    if ($src === '') {
        $errors[] = 'El campo de audio no puede estar vacío';
    }

    return [
        'values' => $values,
        'errors' => $errors,
    ];
}
