<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kunden.xls");

include "../../api/sql/sql_account.php";

echo "<table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\">";

echo "<tr><th>Kundennummer</th><th>Vorname</th><th>Nachname</th><th>Geburtstag</th><th>Registrierung</th><th>Rang</th></tr>";

foreach ($pdo->query("SELECT * FROM Kunde, Rang WHERE Kunde.Rang = Rang.RangID") as $row) {
    $knr = $row['Kundennummer'];
    $vn = $row['Vorname'];
    $nn = $row['Nachname'];
    $bday = $row['Geburtstag'];
    $register = $row['Registrierung'];
    $rang = $row['Bezeichnung'];

    echo "<tr><td>$knr</td><td>$vn</td><td>$nn</td><td>$bday</td><td>$register</td><td>$rang</td></tr>";
}

echo "</table>";

?>
