<?php
include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);
$user = $sql->result("SELECT * FROM Kunde, Login WHERE Kunde.Kundennummer = Login.Kundennummer;");
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Kunde verwalten: <?php echo $user['Vorname'] . " " . $user['Nachname']; ?></title>

    <link rel="stylesheet" href="../user-wrapper.css">
</head>
<body>

<table id="user-wrapper">
    <tr id="header-line">
        <th>ID</th>
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Geburtstag</th>
        <th>Mail</th>
        <th>Rang</th>
        <th>Registrierung</th>
        <th></th>
    </tr>

    <?php
    $id = $_GET['id'];
    $query = "SELECT Kunde.Kundennummer, Vorname, Nachname, Registrierung, Geburtstag, Mail, Rang.Bezeichnung AS Rang FROM Kunde, Login, Rang WHERE Kunde.Kundennummer = Login.Kundennummer AND Kunde.Rang = Rang.RangID AND Kunde.Kundennummer = $id;";

    $query .= ";";

    $dataStatement = $pdo->prepare($query);

    if ($dataStatement->execute()) {
        while ($user = $dataStatement->fetch()) { ?>

            <tr>
                <td><?php echo $user['Kundennummer']; ?></td>
                <td><?php echo $user['Vorname']; ?></td>
                <td><?php echo $user['Nachname']; ?></td>
                <td><?php echo $user['Geburtstag']; ?></td>
                <td><?php echo $user['Mail']; ?></td>
                <td><?php echo $user['Rang']; ?></td>
                <td><?php echo $user['Registrierung']; ?></td>
                <td id="seperator">
                    <a href="edit/index.php?id=<?php echo $user['Kundennummer']; ?>">Verwalten</a>
                </td>
            </tr>

            <?php
        }
    }
    ?>
</table>

</body>
</html>
