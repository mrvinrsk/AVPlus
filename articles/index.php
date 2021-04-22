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


if (isset($_POST['buy'])) {
    include_once "../api/functionality/site_api.php";

    $_SESSION['wk'] = addToCart((isset($_SESSION['wk']) ? $_SESSION['wk'] : array()), $artikelnummer, $_POST['a'], true);
}
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
</head>
<body>

<?php
include_once "../api/elements/navbar.php";
?>

<main role="main" class="container-lg mt-3 mt-lg-5">
    <div class="row mb-5 mb-lg-4">
        <div class="col-12 col-lg-9  mb-1 mb-lg-0">
            <h1 class="text-primary"><?php echo $article['Titel']; ?></h1>
            <h5 class="text-secondary mb-3 mb-lg-4">
                <span class="text-primary"><?php echo $kategorie; ?></span>; Verkauf durch <a class="text-primary"
                                                                                              href="../users/?id=<?php echo $article['Verkaeufer']; ?>"><?php echo $seller; ?></a>
            </h5>
        </div>

        <div class="row col-12 col-lg-3 mt-2 mt-lg-1">
            <div class="col-12 col-lg-12">
                <h2 class="text-primary text-center text-lg-center"><?php echo number_format(((float)$article['Preis']), 2, ',', '.') . '€'; ?></h2>
            </div>

            <div class="col-12 col-lg-12">
                <form method="post" name="add" class="position-relative top-50 start-50 translate-middle">
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary" name="buy"><i class="bi bi-cart-plus-fill"></i> In
                            den Warenkorb
                        </button>
                        <input type="number" class="form-control text-center" name="a"
                               value="<?php echo((isset($_POST['a']) ? $_POST['a'] : 1)); ?>" min="1"/>
                        <span class="input-group-text" id="basic-addon2">x</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <p class="text-muted"><?php echo(($article['Beschreibung']) != "" ? $article['Beschreibung'] : "<i>Für dieses Produkt ist keine Beschreibung verfügbar. Zu genaueren Informationen versuchen Sie sich bitte im Internet über dieses Produkt zu informieren oder den Verkäufer zu kontaktieren.</i>"); ?></p>
</main>

<?php
include_once "../api/elements/footer.php";
?>

</body>
</html>
