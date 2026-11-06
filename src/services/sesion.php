<?php
ini_set('session.use_strict_mode', '1');
session_name('JUKEBOXSESSID');
session_set_cookie_params([
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => false,
]);

session_start();

// Token CSRF asociado a la sesión.
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

function csrf_token(): string
{
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="'
        . htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8')
        . '">';
}

function csrf_check(): void
{
    $recibido = $_POST['csrf'] ?? null;

    if (!is_string($recibido) || !hash_equals($_SESSION['csrf'], $recibido)) {
        http_response_code(403);
        exit('Token CSRF inválido.');
    }
}

