<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";

if (isset($_POST['login'])) {
    $mail = $_POST['mail'];
    $pw = $_POST['pw'];

    if (isset($mail) && isset($pw)) {
        $sql = new MySQLAPI($pdo);
        $usersFound = $sql->rows("SELECT Kundennummer FROM Login WHERE Mail = '$mail';");
        $hashPW = $sql->result("SELECT Passwort FROM Login WHERE Mail = '$mail';")['Passwort'];

        if ($usersFound >= 1) {
            if (password_verify($pw, $hashPW)) {
                $user = $sql->result("SELECT Login.Kundennummer, Kunde.Vorname, Kunde.Nachname FROM Kunde, Login WHERE Login.Mail = '$mail' AND Kunde.Kundennummer = Login.Kundennummer;");
                $id = $user['Kundennnummer'];
                $vorname = $user['Vorname'];
                $nachname = $user['Nachname'];

                $_SESSION['login'] = $id . "_" . $vorname . "_" . $nachname;
                header_remove();
                header("Location: ../../");
            } else {
                echo "Falsches Passwort!";
            }
        } else {
            echo "Falsche Mail!";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="index.css">-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body>

<form method="post" class="container-lg position-absolute top-50 start-50 translate-middle" name="login">
    <div id="title_div" class="mb-2 mb-lg-4">
        <h3 class="text-primary">Einloggen</h3>
        <p class="text-secondary">Logge dich in deinen Account ein.</p>
    </div>

    <div class="mb-3">
        <label for="mail" class="form-label">E-Mail Adresse</label>
        <input type="email" class="form-control" id="mail" name="mail">
    </div>
    <div class="mb-3">
        <label for="pw" class="form-label">Passwort</label>
        <input type="password" class="form-control" id="pw" name="pw">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <hr class="mt-2 mb-2"/>

    <p>Du hast noch kein Konto? <a href="../register/">Erstell eins.</a></p>
</form>

</body>
</html>