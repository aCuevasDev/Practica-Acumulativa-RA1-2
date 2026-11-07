<?php
//$JSON_SRC = "/var/www/data/" . "usuarios.json";
$JSON_SRC = dirname(__DIR__) . '/data/usuarios.json';
function create_user(string $alias, string $email, string $password): array
{
    global $JSON_SRC;
    try {
        $json = file_get_contents($JSON_SRC);

        $users = trim($json) === ''
            ? []
            : json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        return ['No se pudo leer el almacén de usuarios.'];
    }

    if (!is_array($users)) {
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

    try {
        $json = json_encode(
            $users,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );
    } catch (JsonException $e) {
        return ['No se pudo preparar el registro.'];
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

