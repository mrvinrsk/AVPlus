<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../api/sql/sql_account.php";
include_once "../api/sql/mysql_api.php";
include_once "../api/functionality/site_api.php";

if (!isLoggedIn()) {
    header_remove();
    header("Location: ./auth/login/");
}

$sql = new MySQLAPI($pdo);
$sc = $_SESSION['login'];
$kdnr = explode("_", $sc)[0];

$user = $sql->result("SELECT * FROM Kunde WHERE Kundennummer = $kdnr;");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Kunden-Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="index.css">-->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body>

<style>
    .bcard {
        transition-duration: .25s;
    }

    .bcard:hover {
        transform: scale(1.02);

        color: #0d6efd;
        border: 1px solid #0d6efd !important;

        box-shadow: 1px 1px 10px rgba(0, 0, 0, .2);

        cursor: pointer;
    }
</style>

<div class="container-lg mt-3 mt-lg-5">
    <div class="essential_informations mb-5">
        <h1 class="text-primary"><?php echo $user['Vorname'] . " " . $user['Nachname']; ?></h1>

        <?php
        // RANG
        $user = $sql->result("SELECT Rang.Bezeichnung FROM Rang, Kunde WHERE Kundennummer = $kdnr AND Rang.RangID = Kunde.Rang;");
        $rang = $user['Bezeichnung'];
        ?>

        <h6 class="text-secondary"><?php echo $rang; ?></h6>
    </div>

    <div class="container px-4">
        <div class="row gx-5">
            <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                <div class="p-3 border bg-light bcard text-center text-decoration-none">Userdaten ändern</div>
            </div>

            <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                <div class="p-3 border bg-light bcard text-center text-decoration-none">Produkte</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>