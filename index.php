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

<?php
include_once "./api/elements/navbar.php";
?>

<main role="main">
    <div class="page-container">
        <div class="content-container">
            <div id="products_title" class="text-center mt-2 mt-lg-4 mb-3 mb-lg-5">
                <h1>AVPlus</h1>
                <h5 class="text-secondary" style="letter-spacing: 1px; word-spacing: 4px;">Ihre - hoffentlich - erste Wahl für Onlinekäufe aus Deutschland.</h5>
            </div>

            <div class="article_container">
                <div class="container-lg mt-3 mt-lg-5 mb-2 mb-lg-3">
                    <h3 class="text-primary">Produkte</h3>
                </div>

                <div class="container-lg mt-2 mt-lg-3 mb-2 mb-lg-3">
                    <div id="searchcontainer" class="row">
                        <div class="col-md-9">
                            <input type="text" id="searchbar" placeholder="Suchen..." class="form-control">
                        </div>

                        <div class="col-md-3">
                            <select id="searchfilter" class="form-select">
                                <option value="title">Produkttitel</option>
                                <option value="category">Kategorie</option>
                                <option value="seller">Verkäufer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <script>
                    updateList("");

                    $(document).ready(function () {
                        $('#searchbar').on('input', function () {
                            var name = $('#searchbar').val();

                            updateList(name);
                        });

                        $('#searchfilter').on('change', function () {
                            var name = $('#searchbar').val();

                            updateList(name);
                        });
                    });

                    function updateList(str) {
                        $.ajax({
                            //AJAX type is "Post".
                            type: "POST",
                            //Data will be sent to "ajax.php".
                            url: "getarticles.php",
                            //Data, that will be sent to "ajax.php".
                            data: {
                                //Assigning value of "name" into "search" variable.
                                q: str,
                                f: $('#searchfilter').val(),
                            },
                            //If result found, this funtion will be called.
                            success: function (html) {
                                //Assigning result to "display" div in "search.php" file.
                                $("#article_container").html(html).show();
                            },
                            failed: function (e) {
                                console.log(e);
                            }
                        });
                    }
                </script>

                <div id="article_container" class="container-lg">

                </div>
            </div>

            <div class="most_selling">
                <div class="container-lg mt-3 mt-lg-5 mb-2 mb-lg-3">
                    <h3 class="text-primary">Neue Verkäufer</h3>
                </div>

                <div id="seller_container" class="container-lg">
                    <?php
                    include_once "api/sql/sql_account.php";
                    include_once "api/sql/mysql_api.php";

                    $sql = new MySQLAPI($pdo);
                    $sellerStmt = $pdo->prepare("SELECT Kundennummer, Vorname, Nachname FROM Kunde ORDER BY Registrierung DESC LIMIT 4;");

                    if ($sellerStmt->execute()) {
                        while ($row = $sellerStmt->fetch()) {
                            $products = $sql->rows("SELECT Artikelnummer FROM Artikel WHERE Verkaeufer = " . $row['Kundennummer'] . ";");
                            ?>

                            <div class="card mb-2 bg-light text-dark">
                                <div class="card-body row">
                                    <div class="col-9 col-md-9 col-lg-10">
                                        <h6 class="card-title"><a
                                                    href="./users/?id=<?php echo $row['Kundennummer']; ?>"><?php echo $row['Vorname'] . " " . $row['Nachname']; ?></a>
                                        </h6>
                                        <p class="card-subtitle mb-2 text-muted"><?php echo $products . " " . ($products == 1 ? "Produkt" : "Produkte"); ?></p>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <?php
            $end = microtime(true);

            printf("<p class='text-muted mt-3 mt-lg-4 mb-2 mb-lg-5 text-center'>Seite wurde geladen in %f Sekunden.</p>", $end - $start);
            ?>
        </div>
    </div>
</main>
<?php
include_once "api/elements/footer.php";
?>

</body>
</html>
