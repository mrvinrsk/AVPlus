<?php
session_start();
$wk = $_SESSION['wk'];

require_once "../../api/sql/sql_account.php";
require_once "../../api/sql/mysql_api.php";
include_once "../../api/functionality/site_api.php";
$sql = new MySQLAPI($pdo);

// LOGIN
if (isset($_POST['login'])) {
    $mail = $_POST['mail'];
    $pw = $_POST['pw'];

    if (isset($mail) && isset($pw)) {
        $sql = new MySQLAPI($pdo);

        $usersFound = $sql->rows("SELECT Kundennummer FROM Login WHERE Mail = '$mail';");

        if ($usersFound >= 1) {
            $hashPWStmt = $sql->result("SELECT Passwort FROM Login WHERE Mail = '$mail';");
            $hashPW = $hashPWStmt['Passwort'];

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
                header("Refresh:0");
            } else {
                echo "Falsches Passwort!";
            }
        } else {
            echo "Falsche Mail!";
        }
    }
}

//$total = $_POST[];

// BESTELLEN
if (isset($_POST['buy'])) {
    $kundennummer = $_SESSION['user'];
    $mail = $_SESSION['email'];
    $pw = $_POST['password'];
    $hashPWStmt = $sql->result("SELECT Passwort FROM Login WHERE Mail = '$mail';");
    $hashPW = $hashPWStmt['Passwort'];

    if (password_verify($pw, $hashPW)) {
        $total = getCartTotal($wk, $sql);

        $sql->execute("INSERT INTO Bestellung(Kaeufer, Datum, Total) VALUES($kundennummer, NOW(), $total);");
        $bestellung = $sql->lastID();

        foreach ($wk as $wkItem) {
            $artikelnummer = $wkItem[0];
            $menge = $wkItem[1];

            $article = $sql->result("SELECT * FROM Artikel WHERE Artikelnummer = " . $artikelnummer . ";");

            $einzelpreis = $article['Preis'];

            $sql->execute("INSERT INTO Posten(Rechnung, Artikel, Einzelpreis, Menge) VALUES($bestellung, $artikelnummer, $einzelpreis, $menge);");
        }

        unset($wk);

        $_SESSION['rechnung'] = $bestellung;
        header("Location: /cart/buy/success/");
    } else {
        echo "Falsches Passwort!";
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
    <title>AVPlus | Warenkorb</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
</head>
<body>

<?php
include_once "../../api/elements/navbar.php";
?>

<main role="main" class="mt-3 mt-lg-5 container-lg">
    <?php
    if (isset($_SESSION['login'])) { ?>

        <form method="post" class="container-lg mt-3 mt-lg-5">
            <div id="title_div" class="mb-2 mb-lg-4">
                <h3 class="text-primary">Einkauf abschließen</h3>
                <p class="text-secondary">Gebe zur Verifikation deiner Identität dein Passwort ein, um den Kauf zu bestätigen.</p>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Aktuelles Passwort</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <button type="submit" class="btn btn-success container-fluid" name="buy">Bestellen (<?php echo number_format(((float)getCartTotal($wk, $sql)), 2, ',', '.') . "€"; ?>)</button>
        </form>

    <?php } else { ?>

        <form method="post" class="container-lg mt-3 mt-lg-5">
            <div id="title_div" class="mb-2 mb-lg-4">
                <h3 class="text-primary">Einloggen</h3>
                <p class="text-secondary">Logge dich, zum Bezahlen, in deinen Account ein.</p>
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

    <?php } ?>
</main>

<?php
include_once "../../api/elements/footer.php";
?>

</body>
</html>
