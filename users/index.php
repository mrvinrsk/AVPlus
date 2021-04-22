<?php
session_start();
require_once "../api/sql/sql_account.php";
require_once "../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

$kundennummer = $_GET['id'];
$user = $sql->result("SELECT * FROM Kunde WHERE Kundennummer = $kundennummer;");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Nutzer: <?php echo $user['Vorname'] . " " . $user['Nachname']; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>

<?php
include_once "../api/elements/navbar.php";
?>

<main role="main" class="container-lg mt-3 mt-lg-5">
    <h2 class="text-primary"><?php echo $user['Vorname'] . " " . $user['Nachname']; ?></h2>

    <?php
    $rangStmt = $sql->result("SELECT Rang.Bezeichnung FROM Kunde, Rang WHERE Rang.RangID = Kunde.Rang AND Kundennummer = " . $user['Kundennummer'] . ";");
    $rang = $rangStmt["Bezeichnung"];
    ?>

    <h6 class="text-secondary">Registriert
        seit <?php echo(($user['Registrierung'] != null ? date('d.m.Y', strtotime($user['Registrierung'])) : "<i>Unbekannt</i>")); ?>
        (<?php echo $rang; ?>)
    </h6>

    <div class="mt-4 mt-lg-5">

        <h4 class="text-primary mb3 mb-lg-3">Produkte</h4>

        <?php
        $a = $pdo->prepare("SELECT * FROM Artikel WHERE Verkaeufer = $kundennummer;");

        if ($a->execute()) {
            while ($article = $a->fetch()) {
                $beschreibung = $article['Beschreibung'];

                $maxDescLength = 80;
                if (strlen($beschreibung) > $maxDescLength) {
                    $beschreibung = substr($beschreibung, 0, $maxDescLength) . " [...]";
                }

                $katID = $article['Kategorie'];
                $k = $sql->result("SELECT Bezeichnung FROM Artikelkategorie WHERE KategorieID = $katID;");
                $kategorie = $k['Bezeichnung'];

                ?>

                <div class="card mb-2" style="">
                    <div class="card-body">
                        <h6 class="card-title"><a
                                    href="../articles/?id=<?php echo $article['Artikelnummer']; ?>"><?php echo $article['Titel']; ?></a>
                        </h6>
                        <p class="card-subtitle mb-2 text-muted"><?php echo $kategorie; ?></p>
                        <p class="card-text"><?php echo(($article['Beschreibung'] != "") ? $beschreibung : "<i class='text-muted'>Es wurde keine Beschreibung für dieses Produkt angegeben.</i>"); ?></p>
                        <!--<p class="card-text text-secondary"><?php echo number_format((float)$article['Preis'], 2, ',', '.') . "€"; ?></p>-->
                        <!--<a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>-->
                    </div>
                </div>

                <?php
            }
        }
        ?>

    </div>
</main>

<?php
include_once "../api/elements/footer.php";
?>

</body>
</html>
