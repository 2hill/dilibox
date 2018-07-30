<?php
session_start();
/**
 * Created by IntelliJ IDEA.
 * User: jam
 * Date: 24/07/2018
 * Time: 16:57
 */
require '../config/boot.php';

if (!isset($_SESSION['loggedIn'])) {
    header('Location: ../index.php');
}
/* formatting and inserting allowed files in DB */
if (isset($_POST['submit'])) {
    $filename = $_FILES['document']['name'];

        /*formatting*/

    if ($filename != '') {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'gif'];

        if (in_array($ext, $allowed)) {

            $records = $pdo->prepare('select max(id) as id from files');
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);


            if (count($results) >= 0) {
                $row = $results;
                $filename = ($row['id'] + 1) . '-' . $filename;
            } else
                $filename = '1' . '-' . $filename;

            $path = '../documents/';

            $created = @date('Y-m-d H:i:s');
            move_uploaded_file($_FILES['document']['tmp_name'], ($path . $filename));

            /*inserting*/

            $sql = "INSERT INTO files (filename, created) VALUES (:filename, :created)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':created', $created);
            $stmt->execute();
            header("Location: upload.php?tf=success");
        } else {
            header("Location: upload.php?tf=error");
        }
    } else
        header("Location: upload.php");
}
