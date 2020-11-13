<?php
include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);


echo '<tr id="header-line">';
echo '<th>ID</th>';
echo '<th>Bezeichnung</th>';
echo '<th></th>';
echo '</tr>';

echo '<tr id="add"><td colspan="3">Füge <a href="add/">hier</a> eine neue Kategorie hinzu.</td></tr>';

$query = "SELECT KategorieID, Bezeichnung FROM Artikelkategorie";

if (isset($_POST['q'])) {
    $search = $_POST['q'];
    $filter = $_POST['f'];

    $query .= " WHERE (";

    switch (strtolower($filter)) {
        case 'id':
            $query .= "KategorieID LIKE '%$search%'";
            break;

        case 'title':
            $query .= "Bezeichnung LIKE '%$search%'";
            break;
    }

    $query .= ")";
}

$query .= ";";

$dataStatement = $pdo->prepare($query);

if ($dataStatement->execute()) {
    while ($category = $dataStatement->fetch()) {
        echo "<tr>";
        echo "<td>" . $category['KategorieID'] . "</td>";
        echo "<td>" . $category['Bezeichnung'] . "</td>";
        echo "<td id='seperator'><a href='edit/index.php?id=" . $category['KategorieID'] . "'>Verwalten</a></td>";
        echo "</tr>";
    }
}
?>