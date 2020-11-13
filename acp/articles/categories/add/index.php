<?php
include_once "../../../../api/sql/sql_account.php";
include_once "../../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

if (isset($_POST['create'])) {
    $bezeichnung = $_POST['title'];

    if ($sql->rows("SELECT LOWER(Bezeichnung) FROM Artikelkategorie WHERE Bezeichnung = LOWER('$bezeichnung');") == 0) {
        $sql->execute("INSERT INTO Artikelkategorie(Bezeichnung) VALUES('$bezeichnung');");
    } else {
        $alreadyExists = true;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Kategorie hinzufügen</title>

    <link rel="stylesheet" href="../../../acp_src/sass/formstyle.css">
</head>
<body>

<form method="post">
    <h1>Kategorie erstellen</h1>

    <input type="text" name="title" required placeholder="Bezeichnung" id="title" active
           value="<?php (isset($_POST['title']) ? $_POST['title'] : "") ?>">
    <?php
    if (isset($alreadyExists)) {
        echo "<span class='error_msg'>Diese Kategorie gibt es bereits!</span>";
    }
    ?>

    </br>
    <input name="create" type="submit" value="Kategorie speichern">
</form>

</body>
</html>
