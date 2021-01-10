<?php
session_start();
require_once "../api/sql/sql_account.php";
require_once "../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

$artikelnummer = $_GET['id'];
$article = $sql->result("SELECT * FROM Artikel WHERE Artikelnummer = $artikelnummer;");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | <?php $article['Titel'] ?></title>
</head>
<body>

</body>
</html>