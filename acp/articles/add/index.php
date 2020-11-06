<?php
include_once "../../../api/sql/sql_account.php";
include_once "../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);
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

    <select name="category" required>
        <option selected disabled>Wähle eine Kategorie...</option>

        <?php
        $stmt = $pdo->prepare("SELECT Bezeichnung FROM Artikelkategorie;");

        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) { ?>

                <option value="<?php echo $row['Bezeichnung']; ?>"><?php echo $row['Bezeichnung']; ?></option>

                <?php
            }
        }
        ?>
    </select>

    </br>
    <input type="submit" value="Artikel speichern">
</form>

</body>
</html>
