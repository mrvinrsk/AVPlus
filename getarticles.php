<?php
include_once "api/sql/sql_account.php";
include_once "api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

$query = "SELECT Artikel.Artikelnummer, Artikel.Titel, Artikel.Beschreibung, Artikel.Preis, Artikel.Kategorie, Kunde.Vorname, Kunde.Nachname, Kunde.Kundennummer, Artikelkategorie.Bezeichnung FROM Artikel, Kunde, Artikelkategorie WHERE Kunde.Kundennummer = Artikel.Verkaeufer AND Artikel.Kategorie = Artikelkategorie.KategorieID";

if (isset($_POST['q'])) {
    $search = $_POST['q'];
    $filter = $_POST['f'];

    $query .= " AND (";

    switch (strtolower($filter)) {
        case 'title':
            $query .= "Artikel.Titel LIKE '%$search%'";
            break;

        case 'category':
            $query .= "Artikelkategorie.Bezeichnung LIKE '%$search%'";
            break;

        case 'seller':
            $query .= "Kunde.Vorname LIKE '%$search%' OR Kunde.Nachname LIKE '%$search%' OR CONCAT(Kunde.Vorname, ' ', Kunde.Nachname) LIKE '%$search%'";
            break;
    }

    $query .= ")";
}

$query .= ";";

$dataStatement = $pdo->prepare($query);

if ($dataStatement->execute()) {
    while ($article = $dataStatement->fetch()) {
        $beschreibung = $article['Beschreibung'];

        $maxDescLength = 80;
        if (strlen($beschreibung) > $maxDescLength) {
            $beschreibung = substr($beschreibung, 0, $maxDescLength) . " [...]";
        }

        $katID = $article['Kategorie'];
        $k = $sql->result("SELECT Bezeichnung FROM Artikelkategorie WHERE KategorieID = $katID;");
        $kategorie = $k['Bezeichnung'];
        ?>

        <div class="card mb-2 bg-light text-dark">
            <div class="card-body">
                <h6 class="card-title"><a
                            href="./articles/?id=<?php echo $article['Artikelnummer']; ?>"><?php echo $article['Titel']; ?></a>
                </h6>
                <p class="card-subtitle mb-2 text-muted"><?php echo $kategorie; ?></p>
                <p class="card-text"><?php echo(($article['Beschreibung'] != "") ? $beschreibung : "<i class='text-muted'>Es wurde keine Beschreibung für dieses Produkt angegeben.</i>"); ?></p>
                <!--<p class="card-text text-secondary"><?php echo number_format((float)$article['Preis'], 2, ',', '.') . " EUR"; ?></p>-->
                <!--<a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>-->
            </div>
        </div>

        <?php
    }
}
?>
