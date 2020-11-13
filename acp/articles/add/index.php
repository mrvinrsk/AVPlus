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

    <link rel="stylesheet" href="../../acp_src/sass/formstyle.css">
</head>
<body>

<form method="post">
    <h1>Artikel erstellen</h1>

    <input type="text" name="title" required placeholder="Produkttitel" id="title" oninput="update()" active>
    <?php
    if (isset($noTitle)) {
        echo "<span class='error_msg'>Der Artikel muss einen Namen haben!</span>";
    }
    ?>

    <textarea type="text" name="description" placeholder="Beschreibe das Produkt..." id="description"></textarea>

    <script>
        function update() {
            if (document.getElementById('title').value != "") {
                document.getElementById('description').placeholder = "Beschreibe \"" + document.getElementById('title').value + "\"...";
            } else {
                document.getElementById('description').placeholder = "Beschreibe das Produkt...";
            }
        }
    </script>

    <input type="number" name="price" required value="0.00" step="0.01">
    <?php
    if (isset($noPrice)) {
        echo "<span class='error_msg'>Der Artikel muss einen Preis haben!</span>";
    }
    ?>

    <select name="category" required>
        <option selected disabled>Wähle eine Kategorie...</option>

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
    <?php
    if (isset($noCategory)) {
        echo "<span class='error_msg'>Der Artikel muss eine Kategorie haben!</span>";
    }
    ?>

    <select name="seller" required>
        <option selected disabled>Wähle einen Verkäufer...</option>

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
    <?php
    if (isset($noSeller)) {
        echo "<span class='error_msg'>Dem Artikel muss ein Kunde zugewiesen sein!</span>";
    }
    ?>

    </br>
    <input type="submit" value="Artikel speichern" name="create">
</form>

</body>
</html>
