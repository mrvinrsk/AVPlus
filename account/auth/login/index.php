<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
include_once "../../../api/functionality/site_api.php";

session_start();
if (isLoggedIn()) {
    //header_remove();
    //header("Location: ../../");
}

if (isset($_POST['login'])) {
    $mail = $_POST['mail'];
    $pw = $_POST['pw'];

    if (isset($mail) && isset($pw)) {
        $sql = new MySQLAPI($pdo);

        $usersFound = $sql->rows("SELECT Kundennummer FROM Login WHERE Mail = '$mail';");
        $hashPWStmt = $sql->result("SELECT Passwort FROM Login WHERE Mail = '$mail';");
        $hashPW = $hashPWStmt['Passwort'];

        if ($usersFound >= 1) {
            if (password_verify($pw, $hashPW)) {
                $user = $sql->result("SELECT Kunde.Kundennummer, Kunde.Vorname, Kunde.Nachname, Login.Mail FROM Kunde, Login WHERE Login.Mail = '$mail' AND Kunde.Kundennummer = Login.Kundennummer;");
                $id = $user['Kundennummer'];
                $vorname = $user['Vorname'];
                $nachname = $user['Nachname'];

                $sessstr = $id . "_" . $vorname . "_" . $nachname;

                $_SESSION['user'] = $id;
                $_SESSION['login'] = $sessstr;
                $_SESSION['email'] = $user['Mail'];

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

<?php
include_once "../../../api/elements/navbar.php";
?>

<main role="main">
    <form method="post" class="container-lg mt-3 mt-lg-5">
        <div id="title_div" class="mb-2 mb-lg-4">
            <h3 class="text-primary">Einloggen</h3>
            <p class="text-secondary">Logge dich in deinen Account ein.</p>
        </div>

        <div class="mb-3">
            <label for="mail" class="form-label">E-Mail Adresse</label>
            <input type="email" class="form-control" id="mail" name="mail"
                   value="<?php echo((isset($_POST['mail']) ? $_POST['mail'] : '')); ?>">
        </div>
        <div class="mb-3">
            <label for="pw" class="form-label">Passwort</label>
            <input type="password" class="form-control" id="pw" name="pw">
        </div>

        <div class="col-12">
            <button type="submit" name="login" class="btn btn-primary container-fluid">Login</button>
        </div>

        <hr class="mt-4 mb-4" style="border-width: 2px;"/>

        <p class="text-center">Du hast noch kein Konto? <a href="/account/auth/register/">Erstelle eins.</a></p>
    </form>
</main>

<?php
include_once "../../../api/elements/footer.php";
?>

</body>
</html>
