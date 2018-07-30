<?php
require_once("safe.php");
try {
    $pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=utf8;', db_user, db_password);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
