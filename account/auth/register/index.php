<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
include_once "../../../api/functionality/site_api.php";

session_start();
if (isLoggedIn()) {
    header_remove();
    header("Location: ../../");
}

//Validate for users over 18 only
function isOfAge($then, $min)
{
    // $then will first be a string-date
    $then = strtotime($then);
    //The age to be over, over +18
    $min = strtotime('+18 years', $then);
    if (time() < $min) {
        return false;
    }
    return true;
}

if (isset($_POST['register'])) {
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];

    $mail = $_POST['mail'];
    $mail_rp = $_POST['mail_repeat'];

    $pw = $_POST['pw'];
    $pw_rp = $_POST['pw_repeat'];

    $bday = $_POST['bday'];

    if (isset($vorname) && isset($nachname) && isset($mail) && isset($pw)) {
        if ($mail = $mail_rp && $pw == $pw_rp) {
            if (isOfAge($bday, 18)) {
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
            } else {
                echo "Du bist nicht alt genug!";
            }
        } else {
            echo "Die Daten stimmen nicht überein!";
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
    <title>AVPlus | Registrieren</title>

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

<main role="main" class="container-lg">
    <form method="post" class="mt-3 mt-lg-5 row">
        <div id="title_div" class="mb-2 mb-lg-3">
            <h3 class="text-primary">Registrieren</h3>
            <p class="text-secondary">Lege dir einen Account an und shoppe drauf los.</p>
        </div>

        <div class="col-md-6 mb-2 mb-lg-4">
            <label for="vorname" class="form-label">Vorname</label>
            <input type="text" class="form-control" id="vorname" name="vorname"
                   value="<?php echo((isset($_POST['vorname']) ? $_POST['vorname'] : '')); ?>">
        </div>
        <div class="col-md-6 mb-2 mb-lg-4">
            <label for="nachname" class="form-label">Nachname</label>
            <input type="text" class="form-control" id="nachname" name="nachname"
                   value="<?php echo((isset($_POST['nachname']) ? $_POST['nachname'] : '')); ?>">
        </div>

        <div class="col-md-6 mb-2 mb-lg-4">
            <label for="mail" class="form-label">E-Mail Adresse</label>
            <input type="email" class="form-control" id="mail" name="mail"
                   value="<?php echo((isset($_POST['mail']) ? $_POST['mail'] : '')); ?>">
        </div>
        <div class="col-md-6 mb-2 mb-lg-4">
            <label for="mail_repeat" class="form-label">E-Mail Adresse bestätigen</label>
            <input type="email" class="form-control" id="mail_repeat" name="mail_repeat"
                   value="<?php echo((isset($_POST['mail_repeat']) ? $_POST['mail_repeat'] : '')); ?>">
        </div>


        <div class="col-md-6 mb-2 mb-lg-4">
            <label for="pw" class="form-label">Passwort</label>
            <input type="password" class="form-control" id="pw" name="pw">
        </div>
        <div class="col-md-6 mb-2 mb-lg-4">
            <label for="pw_repeat" class="form-label">Passwort bestätigen</label>
            <input type="password" class="form-control" id="pw_repeat" name="pw_repeat">
        </div>

        <div class="col-md-12 mb-2 mb-lg-4">
            <label for="bday" class="form-label">Geburtsdatum</label>
            <input type="date" class="form-control" id="bday" name="bday">
        </div>

        <div class="col-12">
            <button type="submit" name="register" class="btn btn-primary container-fluid">Login</button>
        </div>

        <hr class="mt-4 mb-4" style="border-width: 2px;"/>

        <p class="text-center">Du hast schon ein Konto? <a href="/account/auth/login/">Melde dich an.</a></p>
    </form>
</main>

<?php
include_once "../../../api/elements/footer.php";
?>

</body>
</html>
