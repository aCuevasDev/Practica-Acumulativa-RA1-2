<?php
//$JSON_SRC = "/var/www/data/" . "usuarios.json";
//TODO ADAPTAR read-json para poderle pasar un json cualquiera y que te devuelva la info
$JSON_SRC = dirname(__DIR__, 2) . '/data/usuarios.json';

function create_user(string $alias, string $email, string $password): array
{
    global $JSON_SRC;

    $handle = @fopen($JSON_SRC, 'r+');

    if ($handle === false) {
        return ['No se pudo abrir el almacén de usuarios.'];
    }

    $locked = false;

    try {
        if (!flock($handle, LOCK_EX)) {
            return ['No se pudo bloquear el almacén de usuarios.'];
        }

        $locked = true;

        $json = stream_get_contents($handle);

        if ($json === false) {
            return ['No se pudo leer el almacén de usuarios.'];
        }

        $users = trim($json) === ''
            ? []
            : json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($users) || !array_is_list($users)) {
            return ['El almacén de usuarios no tiene un formato válido.'];
        }

        if (email_exists($users, $email)) {
            return ['Ese correo ya está registrado.'];
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        if ($hash === false) {
            return ['No se pudo proteger la contraseña.'];
        }

        $users[] = [
            'id' => next_user_id($users),
            'alias' => $alias,
            'email' => $email,
            'password_hash' => $hash,
        ];

        $json = json_encode(
            $users,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );

        if (!rewind($handle)) {
            return ['No se pudo volver al inicio del almacén de usuarios.'];
        }

        $bytes = fwrite($handle, $json);

        if ($bytes !== strlen($json)) {
            return ['No se pudo escribir el almacén completo de usuarios.'];
        }

        if (!ftruncate($handle, strlen($json))) {
            return ['No se pudo recortar el almacén de usuarios.'];
        }

        if (!fflush($handle)) {
            return ['No se pudo volcar el almacén de usuarios a disco.'];
        }
    } catch (JsonException $e) {
        return ['No se pudo procesar el almacén de usuarios.'];
    } finally {
        if ($locked) {
            flock($handle, LOCK_UN);
        }

        fclose($handle);
    }

    return [];
}


function email_exists(array $users, string $email): bool
{
    foreach ($users as $user) {
        if (is_array($user) && strtolower((string) ($user['email'] ?? '')) === $email) {
            return true;
        }
    }

    return false;
}


function next_user_id(array $users): int
{
    $nextId = 1;

    foreach ($users as $user) {
        if (is_array($user) && isset($user['id']) && is_numeric($user['id'])) {
            $nextId = max($nextId, (int) $user['id'] + 1);
        }
    }

    return $nextId;
}
