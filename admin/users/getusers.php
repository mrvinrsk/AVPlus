<?php
include_once "../../api/sql/sql_account.php";
include_once "../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);


echo '<tr id="header-line">';
echo '<th scope="col">ID</th>';
echo '<th scope="col">Vorname</th>';
echo '<th scope="col">Nachname</th>';
echo '<th scope="col">Mail</th>';
echo '<th scope="col">Rang</th>';
echo '<th scope="col">Registrierung</th>';
echo '<th scope="col"></th>';
echo '</tr>';

echo '<tr id="add"><td colspan="7">Füge <a href="add/">hier</a> einen neuen Kunden hinzu.</td></tr>';

$query = "SELECT Kunde.Kundennummer, Vorname, Nachname, Registrierung, Mail, Rang.Bezeichnung AS Rang FROM Kunde, Login, Rang WHERE Kunde.Kundennummer = Login.Kundennummer AND Kunde.Rang = Rang.RangID";

if (isset($_POST['q'])) {
    $search = $_POST['q'];
    $filter = $_POST['f'];

    $query .= " AND (";

    switch (strtolower($filter)) {
        case 'id':
            $query .= "Login.Kundennummer LIKE '%$search%'";
            break;

        case 'name':
            $query .= "Vorname LIKE '%$search%' OR Nachname LIKE '%$search%' OR CONCAT(Vorname, ' ', Nachname) LIKE '%$search%'";
            break;

        case 'mail':
            $query .= "Mail LIKE '%$search%'";
            break;

        case 'rang':
            $query .= "Rang.Bezeichnung LIKE '%$search%'";
            break;

        case 'registerdate':
            $query .= "Registrierung LIKE '%$search%'";
            break;
    }

    $query .= ")";
}

$query .= ";";

$dataStatement = $pdo->prepare($query);

if ($dataStatement->execute()) {
    while ($user = $dataStatement->fetch()) {
        echo "<tr>";
        echo "<td scope='row'>" . $user['Kundennummer'] . "</td>";
        echo "<td>" . $user['Vorname'] . "</td>";
        echo "<td>" . $user['Nachname'] . "</td>";
        echo "<td>" . $user['Mail'] . "</td>";
        echo "<td>" . $user['Rang'] . "</td>";
        echo "<td>" . $user['Registrierung'] . "</td>";
        echo "<td id='seperator'><a href='edit/index.php?id=" . $user['Kundennummer'] . "'>Verwalten</a></td>";
        echo "</tr>";
    }
}
?>