<?php
include_once "../../api/sql/sql_account.php";
include_once "../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);


echo '<tr id="header-line">';
echo '<th>ID</th>';
echo '<th>Vorname</th>';
echo '<th>Nachname</th>';
echo '<th>Mail</th>';
echo '<th>Rang</th>';
echo '<th>Registrierung</th>';
echo '<th></th>';
echo '</tr>';

$query = "SELECT Kunde.Kundennummer, Vorname, Nachname, Registrierung, Mail, Rang.Bezeichnung AS Rang FROM Kunde, Login, Rang WHERE Kunde.Kundennummer = Login.Kundennummer AND Kunde.Rang = Rang.RangID";

if (isset($_GET['q'])) {
    $filter = $_GET['q'];

    if ($filter != "") {
        $query .= "AND (Kunde.Kundennummer = '$filter' OR Vorname LIKE '%$filter%' OR Nachname LIKE '%$filter%' OR Mail LIKE '%$filter%' OR Registrierung LIKE '%$filter%')";
    }
}

$query .= ";";

if (isset($_GET['q'])) {
    echo "Suche angegeben.";
} else {
    echo "Suche nicht angegeben!";
}

echo "Suche: '" . $filter . "'</br></br></br></br></br>";
echo $query;

$dataStatement = $pdo->prepare($query);

if ($dataStatement->execute()) {
    while ($user = $dataStatement->fetch()) {

        echo "<tr>";
        echo "<td>" . $user['Kundennummer'] . "</td>";
        echo "<td>" . $user['Vorname'] . "</td>";
        echo "<td>" . $user['Nachname'] . "</td>";
        echo "<td>" . $user['Mail'] . "</td>";
        echo "<td>" . $user['Rang'] . "</td>";
        echo "<td>" . $user['Registrierung'] . "</td>";
        echo "<td id='seperator'>";
        echo "<a href='edit/index.php?id=" . $user['Kundennummer'] . "'>Verwalten</a>";
        echo "</td>";
        echo "</tr>";

    }
}
?>