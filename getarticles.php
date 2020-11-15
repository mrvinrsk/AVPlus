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

        if (strlen($beschreibung) > 50) {
            $beschreibung = substr($beschreibung, 0, 85) . " [...]";
        }

        echo "<div class='article'>";
        echo "<span class='article_title'><a href='./article/?id=" . $article['Artikelnummer'] . "'>" . $article['Titel'] . "</a></span></br>";
        echo "<span class='article_description'>" . $beschreibung . "</span></br>";
        echo "<span class='article_seller'>Verkauft von <a href='./user/?id=" . $article['Kundennummer'] . "'>" . $article['Vorname'] . "</a></span>";
        echo "</div>";
    }
}
?>