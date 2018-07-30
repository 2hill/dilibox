<?php
session_start();
/**
 * Created by IntelliJ IDEA.
 * User: jam
 * Date: 24/07/2018
 * Time: 17:08
 */
require '../config/boot.php';

if (!isset($_SESSION['loggedIn'])) {
    header('Location: ../index.php');
}
$records = $pdo->prepare('SELECT filename FROM files');
$records->execute();
?>
                <!-- User Interface displaying uploaded files -->
<!DOCTYPE html>
<html>
<head>
    <title>Dilibox File Management</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="../css/bootstrap.css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<br/>
<div class="d-flex justify-content-center">
    <a href="../login/logout.php" class="btn btn-primary">Déconnexion</a>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 well">
            <form action="insertfile.php" method="post" enctype="multipart/form-data">
                <legend class="d-flex justify-content-center">Sélectionner un document:</legend>
                <div class="form-group">
                    <input type="file" name="document"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Envoyer" class="btn btn-info"/>
                </div>
                <?php if (isset($_GET['tf'])) { ?>
                    <div class="alert alert-success text-center">
                        <?php if ($_GET['tf'] == 'success') {
                            echo "Fichier téléchargé avec succes!";
                        } else {
                            echo 'Extension Invalide!';
                        } ?>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Afficher</th>
                    <th>Télécharger</th>
                </tr>
                </thead>
                <tbody>
                <!-- Iterate and display each added document -->
                <?php
                $i = 1;
                while ($row = $records->fetch(PDO::FETCH_BOTH)) { ?>
                    <tr>
                        <td> <?php echo $i++; ?>
                        <td><?php echo $row['filename']; ?></td>
                        <td><a href="../documents/<?php echo $row['filename']; ?>" target="_blank">Voir</a></td>
                        <td><a href="../documents/<?php echo $row['filename']; ?>" download>Télécharger</a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
