<?php
session_start();
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
include_once "../../../api/elements/navbar.php";
?>

<main role="main" class="mt-3 mt-lg-5 container-lg">
    <div class="container-lg mt-3 mt-lg-5">
        <h3>Deine Bestellung ist unterwegs!</h3>
        <span>
            Deine Bestellung mit der Rechnungsnummer #<?php echo $_SESSION['rechnung'] ?> wird verarbeitet.
            Du kannst dir deine Rechnung <a href="/cart/buy/success/download.php">hier</a> herunterladen und diesen Tab nun schließen.
        </span>
    </div>
</main>

<?php
include_once "../../../api/elements/footer.php";
?>

</body>
</html>
