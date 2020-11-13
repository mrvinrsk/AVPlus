<?php
include_once "../../api/sql/sql_account.php";
include_once "../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);


echo '<tr id="header-line">';
echo '<th>Artikelnummer</th>';
echo '<th>Produkt</th>';
echo '<th>Kategorie</th>';
echo '<th>Produktdetails</th>';
echo '<th>Preis</th>';
echo '<th>Verkäufer</th>';
echo '<th></th>';
echo '</tr>';

echo '<tr id="add"><td colspan="7">Füge <a href="add/">hier</a> einen neuen Artikel hinzu.</td></tr>';

$query = "SELECT Artikel.Artikelnummer, Artikel.Titel, Artikel.Beschreibung, Artikel.Preis, Artikel.Kategorie, Kunde.Vorname, Kunde.Nachname, Kunde.Kundennummer, Artikelkategorie.Bezeichnung FROM Artikel, Kunde, Artikelkategorie WHERE Kunde.Kundennummer = Artikel.Verkaeufer AND Artikel.Kategorie = Artikelkategorie.KategorieID";

if (isset($_POST['q'])) {
    $search = $_POST['q'];
    $filter = $_POST['f'];

    $query .= " AND (";

    switch (strtolower($filter)) {
        case 'id':
            $query .= "Artikel.Artikelnummer LIKE '%$search%'";
            break;

        case 'title':
            $query .= "Artikel.Titel LIKE '%$search%'";
            break;

        case 'price':
            $query .= "Artikel.Preis LIKE '%$search%'";
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
            $beschreibung = substr($beschreibung, 0, 50) . " [...]";
        }

        echo "<tr>";
        echo "<td>" . $article['Artikelnummer'] . "</td>";
        echo "<td>" . $article['Titel'] . "</td>";
        echo "<td>" . $article['Bezeichnung'] . "</td>";
        echo "<td>" . $beschreibung . "</td>";
        echo "<td>" . $article['Preis'] . "</td>";
        echo "<td>" . $article['Vorname'] . " " . $article['Nachname'] . " (" . $article['Kundennummer'] . ")</td>";
        echo "<td id='seperator'><a href='edit/index.php?id=" . $article['Artikelnummer'] . "'>Verwalten</a></td>";
        echo "</tr>";
    }
}
?>