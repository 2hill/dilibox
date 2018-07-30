<?php

session_start();

require 'config/boot.php';

if (!empty($_POST['email']) && !empty($_POST['password'])):

    $records = $pdo->prepare('SELECT id,email,password,role FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $message = '';

                    /*Verifying login credentials*/
    if (count($results) > 0) {
        if (password_verify($_POST['password'], $results['password'])) {
            $_SESSION['loggedIn'] = true;
            header("Location: filemanager/upload.php");
        } elseif ($results['email'] !== $_POST['email']) {
            $message = 'Compte inexistant, veuillez vous inscrire';
            header("refresh:2; url=login/register.php");
        } else {
            $message = 'Mauvais identifiant/ mot de passe';
        }
    }
endif;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login DiliBox</title>
    <link rel="stylesheet" type="text/css" href="css/style_login.css">
    <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>
<?php if (!empty($message)): ?>
    <p><?= $message ?></p>
<?php endif; ?>
<h1>Connexion</h1>
<a href="login/register.php" class="logcolor">Inscription</a>
<form action="index.php" method="POST">
    <input type="text" placeholder="identifiant" name="email" required>
    <input type="password" placeholder="Mot de passe" name="password" required>
    <input type="submit">
</form>
</body>
</html>



