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

$query = "SELECT Artikel.Artikelnummer, Kunde.Kundennummer, Kunde.Vorname, Kunde.Nachname, Artikel.Titel, Artikel.Beschreibung, Artikel.Preis, Kategorie.Bezeichnung FROM Kunde, Artikel, Artikelkategorie WHERE Kunde.Kundennummer = Artikel.Verkaeufer AND Artikel.Kategorie = Artikelkategorie.KategorieID";

if (isset($_POST['q'])) {
    $filter = $_POST['q'];

    if ($filter != "") {
        $query .= " AND (Kunde.Kundennummer = '$filter' OR Vorname LIKE '%$filter%' OR Nachname LIKE '%$filter%' OR Mail LIKE '%$filter%' OR Registrierung LIKE '%$filter%' OR Rang.Bezeichnung LIKE '%$filter%')";
    }
}

$query .= ";";

$dataStatement = $pdo->prepare($query);

if ($dataStatement->execute()) {
    while ($user = $dataStatement->fetch()) {
        echo "<tr>";
        echo "<td>" . $user['Artikelnummer'] . "</td>";
        echo "<td>" . $user['Titel'] . "</td>";
        echo "<td>" . $user['Bezeichnung'] . "</td>";
        echo "<td>" . $user['Beschreibung'] . "</td>";
        echo "<td>" . $user['Preis'] . "</td>";
        echo "<td>" . $user['Vorname'] . " " . $user['Nachname'] . "(" . $user['Kundennummer'] . ")</td>";
        echo "<td id='seperator'><a href='edit/index.php?id=" . $user['Artikelnummer'] . "'>Verwalten</a></td>";
        echo "</tr>";
    }
}
?>