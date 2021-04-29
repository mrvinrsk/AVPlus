<?php
session_start();
$wk = $_SESSION['wk'];

require_once "../api/sql/sql_account.php";
require_once "../api/sql/mysql_api.php";
include_once "../api/functionality/site_api.php";

$sql = new MySQLAPI($pdo);

if (isset($_REQUEST['artnr'])) {
    $articlenr = $_REQUEST['artnr'];
    $currentAmount = $_REQUEST['amount'];
    $add = true;

    if (isset($_REQUEST['add'])) {
        $add = true;
    } else if (isset($_REQUEST['remove'])) {
        $add = false;
    }

    $wk = addToCart($wk, $articlenr, 1, $add);
    $_SESSION['wk'] = $wk;
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

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body>

<?php
include_once "../api/elements/navbar.php";
?>

<main role="main" class="mt-3 mt-lg-5 container-lg">
    <div class="row mb-2 mb-lg-5 text-center">
        <h1 class="text-success">Dein Warenkorb</h1>
    </div>

    <!-- Titles -->
    <div class="row mb-1 mb-lg-2 text-primary">
        <h4 class="col-lg-6 col-md-6 col-sm-5 col-12">
            Artikel
        </h4>

        <h4 class="col-lg-3 col-md-2 col-sm-2 col-6 text-center">
            Menge
        </h4>

        <h4 class="col-lg-3 col-md-4 col-sm-5 col-6 text-right text-end">
            Preis
        </h4>
    </div>

    <hr/>

    <div id="articles" class="mt-2 mt-lg-4">
        <?php
        if (count($wk) > 0) {
            foreach ($wk as $wkItem) {

                $article = $sql->result("SELECT * FROM Artikel WHERE Artikelnummer = " . $wkItem[0] . ";");
                $amount = $wkItem[1];
                ?>

                <form class="row mb-1 mb-lg-2">
                    <input type="hidden" name="artnr" value="<?php echo $article['Artikelnummer']; ?>">
                    <h5 class="col-lg-6 col-md-6 col-sm-5 col-12"><?php echo $article['Titel']; ?></h5>

                    <div class="col-lg-3 col-md-2 col-sm-2 col-6">
                        <div class="btn-group container-fluid" role="group" aria-label="Basic example">
                            <button type="submit" name="remove" value="1" class="btn btn-outline-primary">-</button>
                            <input type="number" name="amount" class="btn border border-primary text-center"
                                   value="<?php echo $amount; ?>" readonly>
                            <button type="submit" name="add" value="1" class="btn btn-outline-primary">+</button>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-5 col-6 text-right text-end">
                        <?php
                        $aprice = ($amount * $article['Preis']);
                        echo number_format(((float)$aprice), 2, ',', '.') . "€";
                        ?>
                    </div>
                </form>

                <?php
            }
        } else { ?>

            <div class="alert alert-danger" role="alert">
                Du hast aktuell keine Produkte im Warenkorb!
            </div>

            <?php
        }
        ?>
    </div>

    <div class="row mt-2 mt-lg-3">
        <div class="col-lg-9 col-md-8 col-sm-7 col-0">
            <!-- Placeholder -->
        </div>

        <div class="col-lg-3 col-md-4 col-sm-5 col-12 text-right text-end">
            <hr/>

            <?php
            echo "<h3>Total: <g class='text-primary'>" . number_format(((float)getCartTotal($wk, $sql)), 2, ',', '.') . "€</g></h3>";
            ?>

            <hr/>

            <form method="post" action="/cart/buy/index.php">
                <input type="hidden" name="total" value="<?php echo $price; ?>">
                <button type="submit" class="btn btn-success mt-2 container-fluid"><i class="bi bi-cash-stack"></i> Zur Kasse</button>
            </form>
        </div>
    </div>
</main>

<?php
include_once "../api/elements/footer.php";
?>

</body>
</html>
