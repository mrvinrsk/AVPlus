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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="../../acp_src/sass/formstyle.css">-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body>

<form method="post" class="row container-lg py-2 px-4 g-3 position-absolute top-50 start-50 translate-middle">
    <h1>Kunden erstellen</h1>

    <div class="col-md-6">
        <label for="vorname" class="form-label">Vorname</label>
        <input type="text" class="form-control" id="vorname" name="vorname" required active>
    </div>
    <div class="col-md-6">
        <label for="nachname" class="form-label">Nachname</label>
        <input type="text" class="form-control" id="nachname" name="nachname" required>
    </div>

    <div class="col-md-12">
        <label for="geburtstag" class="form-label">Geburtstag</label>
        <input type="date" id="geburtstag" name="geburtstag" class="form-control" required>
    </div>

    <div class="col-md-12">
        <label for="email" class="form-label">E-Mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="col-md-12">
        <label for="passwort" class="form-label">Passwort</label>
        <input type="password" class="form-control" id="passwort" name="passwort" required>
    </div>

    <div class="col-md-12">
        <label for="rank" class="form-label">Nutzerrang</label>
        <select name="rank" id="rank" class="form-control" required>
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
    </div>

    <div class="col-md-12 mt-3">
        <button type="submit" name="create" class="btn btn-primary container-fluid">Kunden anlegen</button>
    </div>
</form>

</body>
</html>
