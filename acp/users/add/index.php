<?php
if (isset($_POST['create'])) {
    include_once "../../../api/sql/sql_account.php";
    include_once "../../../api/sql/mysql_api.php";
    $sql = new MySQLAPI($pdo);

    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $geburtstag = $_POST['geburtstag'];

    $mail = $_POST['email'];
    $pw = $_POST['passwort'];
    $hashed_password = hash('sha256', $pw);

    $sql->execute("INSERT INTO Kunde(Vorname, Nachname, Geburtstag, Registrierung, Rang) VALUES('$vorname', '$nachname', '$geburtstag', NOW(), )");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Nutzer hinzufügen</title>

    <link rel="stylesheet" href="../../acp_src/sass/formstyle.css">
</head>
<body>

<form method="post">
    <h1>Kunden erstellen</h1>

    <input type="text" name="vorname" placeholder="Vorname">
    <input type="text" name="nachname" placeholder="Nachname">
    <input type="date" name="geburtstag" placeholder="Geburtsdatum">

    <input type="email" name="email" placeholder="E-Mail">
    <input type="password" name="passwort" placeholder="Passwort">

    <input type="submit" name="create" value="Kunden anlegen">
</form>

</body>
</html>
