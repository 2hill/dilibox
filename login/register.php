<?php
session_start();

require '../config/boot.php';

$message = '';
$email = (isset($_POST['email']) ? $_POST['email'] : null);

$result = $pdo->prepare("SELECT * FROM users WHERE email='$email'");
$result->bindParam(':email', $_POST['email']);
$result->execute();
$num_rows = $result->fetchColumn();

                        /* Verifying rules for user registration*/
if ($num_rows > 0) {
    $message = 'Utilisateur  existant! Veuillez réesayer';
    header("refresh:2; url=register.php");

} elseif (!empty($_POST['email']) && !empty($_POST['password'])) {

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $message = 'Le mot de passe doit etre identique, veuillez réesayer';

    } else {

        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':email', $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        $message = 'Compte crée...redirection';
        header("refresh:2; url=../index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription Dilibox</title>
    <link rel="stylesheet" type="text/css" href="../css/style_login.css">
</head>
<body>
<?php if (!empty($message)): ?>
    <p><?= $message ?></p>
<?php endif; ?>
<h1>Inscription</h1>
<a href="../index.php" class="logcolor">Connexion</a>
<form action="register.php" method="POST">
    <input type="text" placeholder="identifiant" name="email" required>
    <input type="password" placeholder="Mot de passe" name="password" required>
    <input type="password" placeholder="Confirmer" name="confirm_password" required>
    <input type="submit">
</form>
</body>
</html>
