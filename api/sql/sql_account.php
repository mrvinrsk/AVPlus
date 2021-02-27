<?php
$servername = "localhost";
$username = "webshop";
$password = "webshop_schule_serv";
$database = "SchuleAV";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Verbunden!";
} catch (PDOException $e) {
    //"Fehler: $e";
}
?>