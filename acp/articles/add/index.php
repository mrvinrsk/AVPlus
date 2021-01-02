<?php
include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

if (isset($_POST['create'])) {
    $send = true;

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $seller = $_POST['seller'];

    if (!isset($_POST['title'])) {
        $send = false;
        $noTitle = true;
    }
    if (!isset($_POST['price'])) {
        $send = false;
        $noPrice = true;
    }
    if (!isset($_POST['category'])) {
        $send = false;
        $noCategory = true;
    }
    if (!isset($_POST['seller'])) {
        $send = false;
        $noSeller = true;
    }

    if ($send) {
        $sql->execute("INSERT INTO Artikel(Verkaeufer, Titel, Beschreibung, Preis, Kategorie) VALUES($seller, '$title', '$description', $price, $category);");
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
    <title>AVPlus | Artikel hinzufügen</title>

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
    <h1>Artikel erstellen</h1>

    <div class="col-md-9">
        <label for="title" class="form-label">Titel</label>
        <input type="text" id="title" name="title" class="form-control" aria-describedby="titleHelp"
               oninput="update()">
        <div id="titleHelp" class="form-text">
            Der Titel des Produktes, wie es in der Übersicht aufgelistet wird.
        </div>
        <?php
        if (isset($noTitle)) {
            echo "<span class='error_msg'>Der Artikel muss einen Namen haben!</span>";
        }
        ?>
    </div>

    <div class="col-md-3">
        <label for="price" class="form-label">Preis</label>
        <div class="input-group">
            <input type="number" name="price" id="price" required value="0.00" step="0.01" class="form-control"
                   aria-describedby="priceHelp">
            <span class="input-group-text" id="basic-addon2">€</span>
        </div>
        <div id="priceHelp" class="form-text">
            Der Verkaufspreis des Produkts.
        </div>
        <?php
        if (isset($noPrice)) {
            echo "<span class='error_msg'>Der Artikel muss einen Preis haben!</span>";
        }
        ?>
    </div>

    <div class="col-md-12 form-group">
        <label for="description" class="form-label">Beschreibung</label>
        <textarea type="text" name="description" placeholder="Beschreibe das Produkt..." id="description"
                  aria-describedby="descriptionHelp" class="form-control" style="max-height: 25vh;"></textarea>
        <div id="descriptionHelp" class="form-text">
            Eine zusätzliche, ausführliche Beschreibung der Artikeleigenschaften. (Optional)
        </div>
    </div>

    <script>
        function update() {
            if (document.getElementById('title').value != "") {
                document.getElementById('description').placeholder = "Beschreibe \"" + document.getElementById('title').value + "\"...";
            } else {
                document.getElementById('description').placeholder = "Beschreibe das Produkt...";
            }
        }
    </script>

    <div class="col-md-6 form-group">
        <label for="category" class="form-label">Kategorie</label>
        <select name="category" id="category" class="form-select" aria-describedby="categoryHelp">
            <option selected disabled>Auswählen...</option>

            <?php
            $stmt = $pdo->prepare("SELECT KategorieID, Bezeichnung FROM Artikelkategorie;");

            if ($stmt->execute()) {
                while ($row = $stmt->fetch()) { ?>

                    <option value="<?php echo $row['KategorieID']; ?>"><?php echo $row['Bezeichnung']; ?></option>

                    <?php
                }
            }
            ?>
        </select>

        <div id="categoryHelp" class="form-text">
            Die Produktkategorie des Produkts.
        </div>
    </div>

    <?php
    if (isset($noCategory)) {
        echo "<span class='error_msg'>Der Artikel muss eine Kategorie haben!</span>";
    }
    ?>

    <div class="col-md-6 form-group">
        <label for="seller" class="form-label">Verkäufer</label>
        <select id="seller" name="seller" class="form-select" aria-describedby="sellerHelp">
            <option selected disabled>Auswählen...</option>

            <?php
            $rankStmt = $pdo->prepare("SELECT Kundennummer, Vorname, Nachname FROM Kunde;");

            if ($rankStmt->execute()) {

                echo $rankStmt->rowCount();

                while ($row = $rankStmt->fetch()) { ?>

                    <option value="<?php echo $row['Kundennummer']; ?>"><?php echo $row['Kundennummer'] . ' - ' . $row['Vorname'] . ' ' . $row['Nachname']; ?></option>

                    <?php
                }
            }
            ?>
        </select>

        <div id="sellerHelp" class="form-text">
            Der Verkäufer des Produkts.
        </div>

        <?php
        if (isset($noSeller)) {
            echo "<span class='error_msg'>Dem Artikel muss ein Kunde zugewiesen sein!</span>";
        }
        ?>
    </div>

    <button type="submit" class="btn btn-primary container-fluid mt-4" name="create">Speichern</button>
</form>

</body>
</html>
