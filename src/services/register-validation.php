<?php

function validate_registration(array $input): array
{
    $alias = '';
    $email = '';
    $password = '';
    $errors = [];

    $aliasInput = $input['alias'] ?? null;

    if (!is_string($aliasInput)) {
        $errors[] = 'El alias no es válido.';
    } else {
        $alias = trim($aliasInput);
        $aliasLength = mb_strlen($alias, 'UTF-8');

        if ($aliasLength < 2 || $aliasLength > 30) {
            $errors[] = 'El alias debe tener entre 2 y 30 caracteres.';
        }
    }

    $emailInput = $input['email'] ?? null;

    if (!is_string($emailInput)) {
        $errors[] = 'El correo no es válido.';
    } else {
        $email = strtolower(trim($emailInput));

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'El correo no tiene un formato válido.';
        }
    }

    $passwordInput = $input['password'] ?? null;
    $passwordConfirmInput = $input['password_confirm'] ?? null;
    $password = is_string($passwordInput) ? $passwordInput : '';

    if (!is_string($passwordInput) || !is_string($passwordConfirmInput)) {
        $errors[] = 'Las contraseñas no son válidas.';
    } else {
        $passwordLength = mb_strlen($password, 'UTF-8');

        if ($passwordLength < 12 || $passwordLength > 64) {
            $errors[] = 'La contraseña debe tener entre 12 y 64 caracteres.';
        } elseif (strlen($password) > 72) {
            $errors[] = 'La contraseña no puede superar los 72 bytes.';
        }

        if ($password !== $passwordConfirmInput) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
    }

    return [
        'alias' => $alias,
        'email' => $email,
        'password' => $password,
        'errors' => $errors,
    ];
}
