<?php

require_once(dirname(__DIR__) . "/services/sesion.php");



$errors = $errors ?? [];
$alias = $alias ?? '';
$email = $email ?? '';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="../assets/form.css" />
</head>

<body>
    <h1>Crear cuenta</h1>
    <form action="../register.php" method="post">
        <?php if ($errors !== []): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p>
            <label for="alias">Alias:</label><br />
            <input type="text" id="alias" name="alias" value="<?= htmlspecialchars($alias, ENT_QUOTES, 'UTF-8') ?>"
                minlength="2" maxlength="30" autocomplete="username" required />
        </p>
        <p>
            <label for="email">Correo:</label><br />
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                autocomplete="email" required />
        </p>
        <p>
            <label for="password">Contraseña:</label><br />
            <input type="password" id="password" name="password" minlength="12" maxlength="64" required />
        </p>
        <p>
            <label for="password_confirm">Repite la contraseña:</label><br />
            <input type="password" id="password_confirm" name="password_confirm" minlength="12" maxlength="64"
                required />
        </p>

        <?= csrf_field() ?>

        <button type="submit">Crear cuenta</button>
    </form>
</body>

</html>