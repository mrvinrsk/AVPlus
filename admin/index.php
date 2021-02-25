<?php
session_start();
$start = microtime(true);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Home</title>

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
    .redirect {
        transition-duration: .25s;
    }

    .redirect:hover {
        transform: scale(1.05);
        cursor: pointer;
        transition-duration: .25s;
    }

    .redirect:hover div {
        box-shadow: 0 0 15px rgba(0, 0, 0, .25);
        transition-duration: .25s;
    }
</style>

<div class="row container-lg py-2 px-4 g-3 position-absolute top-50 start-50 translate-middle">
    <h3 class="text-primary">Administration</h3>
    <h5 class="text-secondary">
        In dieser Administrations-Oberfläche hast du die Möglichkeit Kunden, Artikel & Kategorien zu hinzuzufügen und zu verwalten.
        Wähle dazu ganz einfach den Unterpunkt, den du aufrufen möchtest.
        <br/>
        Auf den einzelnen Unterseiten kannst du dich dann per Navigator weiter fortbewegen.
    </h5>

    <div class="container mt-5 mt-lg-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-1 g-sm-2 g-lg-3">
            <div class="col redirect" onclick="window.location = 'users/';">
                <div class="p-3 bg-primary text-light">Kundenverwaltung</div>
            </div>
            <div class="col redirect">
                <div class="p-3 bg-primary text-light">Artikelverwaltung</div>
            </div>
            <div class="col redirect">
                <div class="p-3 bg-primary text-light">Rangverwaltung</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>