<?php
include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

if (isset($_POST['create'])) {
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $geburtstag = $_POST['geburtstag'];

    $mail = $_POST['email'];
    $pw = $_POST['passwort'];
    $hashed_password = hash('sha256', $pw);
    $registerDate = date("Y-m-d");

    $rank = $_POST['rank'];

    $rankSet = $sql->result('SELECT RangID FROM Rang WHERE Bezeichnung LIKE "' . $rank . '";');
    $rankID = $rankSet['RangID'];

    $sql->execute("INSERT INTO Kunde(Vorname, Nachname, Geburtstag, Registrierung, Rang) VALUES('$vorname', '$nachname', '$geburtstag', '$registerDate', $rankID);");
    $kndnrResult = $sql->result("SELECT Kundennummer FROM Kunde WHERE Vorname='$vorname' AND Nachname='$nachname' AND Registrierung = '$registerDate'");
    $kundennummer = $kndnrResult['Kundennummer'];

    $sql->execute("INSERT INTO Login(Kundennummer, Mail, Passwort) VALUES($kundennummer, '$mail', '$hashed_password');");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Nutzer hinzufügen</title>

    <link rel="stylesheet" href="../../acp_src/sass/formstyle.css">
</head>
<body>

<form method="post">
    <h1>Kunden erstellen</h1>

    <input type="text" name="vorname" placeholder="Vorname" required active>
    <input type="text" name="nachname" placeholder="Nachname" required>
    <input type="date" name="geburtstag" placeholder="Geburtsdatum" required>

    <input type="email" name="email" placeholder="E-Mail" required>
    <input type="password" name="passwort" placeholder="Passwort" required>

    <select name="rank" required>
        <option selected disabled>Wähle einen Rang...</option>

        <?php
        $rankStmt = $pdo->prepare("SELECT Bezeichnung FROM Rang;");

        if ($rankStmt->execute()) {

            echo $rankStmt->rowCount();

            while ($row = $rankStmt->fetch()) { ?>

                <option value="<?php echo $row['Bezeichnung']; ?>"><?php echo $row['Bezeichnung']; ?></option>

                <?php
            }
        }
        ?>
    </select>

    <input type="submit" name="create" value="Kunden anlegen">
</form>

</body>
</html>
