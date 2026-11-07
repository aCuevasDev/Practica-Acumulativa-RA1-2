<?php

require_once(dirname(__DIR__) . "/services/sesion.php");

$errors = $errors ?? [];
$email = $email ?? '';
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Entrar</title>
    <link rel="stylesheet" href="../assets/form.css" />
</head>

<body>
    <h1>Entrar</h1>
    <form action="../login.php" method="post">
        <?php if ($errors !== []): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p>
            <label for="email">Correo:</label><br />
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                autocomplete="username" required />
        </p>
        <p>
            <label for="password">Contraseña:</label><br />
            <input type="password" id="password" name="password" required />
        </p>

        <?= csrf_field() ?>

        <button type="submit">Entrar</button>
    </form>
    <p><a href="../register.php">Crear cuenta</a></p>
</body>

</html>