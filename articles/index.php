<?php
session_start();
require_once "../api/sql/sql_account.php";
require_once "../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

$artikelnummer = $_GET['id'];
$article = $sql->result("SELECT * FROM Artikel WHERE Artikelnummer = $artikelnummer;");

$v = $sql->result("SELECT * FROM Kunde WHERE Kundennummer = " . $article['Verkaeufer'] . ";");
$seller = $v['Vorname'] . " " . $v['Nachname'];

$k = $sql->result("SELECT * FROM Artikelkategorie WHERE KategorieID = " . $article['Kategorie'] . ";");
$kategorie = $k['Bezeichnung'];


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | <?php echo $article['Titel']; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>

<div class="container-lg mt-3 mt-lg-5">
    <div class="row">
        <div class="col-9">
            <h1 class="text-primary"><?php echo $article['Titel']; ?></h1>
            <h5 class="text-secondary mb-3 mb-lg-4">
                <div style="display: inline;" class="text-primary"><?php echo $kategorie; ?></div>
                ; Verkauf durch
                <a class="text-primary" href="../users/?id=<?php echo $article['Verkaeufer']; ?>"><?php echo $seller; ?></a>
            </h5>
        </div>
        <div class="col-3">
            <form method="post" name="add" class="position-relative top-50 start-50 translate-middle">
                <button type="submit" class="btn btn-primary">In den Warenkorb</button>
            </form>
        </div>
    </div>

    <p class="text-muted"><?php echo(($article['Beschreibung']) != "" ? $article['Beschreibung'] : "<i>Für dieses Produkt ist keine Beschreibung verfügbar. Zu genaueren Informationen versuchen Sie sich bitte im Internet über dieses Produkt zu informieren oder den Verkäufer zu kontaktieren.</i>"); ?></p>
</div>

</body>
</html>