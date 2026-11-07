<?php
require_once __DIR__ . '/services/sesion.php';
require_once __DIR__ . '/services/register-validation.php';
require_once __DIR__ . '/persistence/users.php';



function render_register_form(array $errors, string $alias, string $email): void
{
    require __DIR__ . '/views/register-form.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    render_register_form([], '', '');
    exit;
}

csrf_check();

$registration = validate_registration($_POST);
$errors = $registration['errors'];

if ($errors === []) {
    $errors = create_user(
        $registration['alias'],
        $registration['email'],
        $registration['password']
    );
}

if ($errors === []) {
    header('Location: login.php', true, 303);
    exit;
}

render_register_form($errors, $registration['alias'], $registration['email']);
