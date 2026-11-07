<?php
require_once __DIR__ . '/services/sesion.php';
require_once __DIR__ . '/persistence/users.php';


function render_login_form(array $errors, string $email): void
{
    require __DIR__ . '/views/login-form.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    render_login_form([], '');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido.');
}

csrf_check();

$emailInput = $_POST['email'] ?? null;
$passwordInput = $_POST['password'] ?? null;

$email = is_string($emailInput) ? strtolower(trim($emailInput)) : '';
$password = is_string($passwordInput) ? $passwordInput : '';

$errors = [];

if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || $password === '') {
    $errors[] = 'Credenciales no válidas';
}

$user = null;

if ($errors === []) {
    try {
        $user = find_user_by_email(read_users(), $email);
    } catch (Throwable $e) {
        $errors[] = 'No se pudo iniciar sesión. Inténtalo más tarde.';
    }
}

if ($errors === [] && (
    $user === null
    || !is_string($user['password_hash'] ?? null)
    || !password_verify($password, $user['password_hash'])
)) {
    $errors[] = 'Credenciales no válidas';
}

if ($errors === []) {
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['alias'] = $user['alias'];
    header('Location: home.php', true, 303);
    exit;
}

render_login_form($errors, $email);
