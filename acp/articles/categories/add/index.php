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
    <title>AVPlus | Kategorie hinzufügen</title>
    <base href="/AVPlus">

    <link rel="stylesheet" href="../../../acp_src/sass/formstyle.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<?php
include_once "../../../../api/sql/sql_account.php";
include_once "../../../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);

if (isset($_POST['create'])) {
    $bezeichnung = $_POST['title'];

    if ($sql->rows("SELECT LOWER(Bezeichnung) FROM Artikelkategorie WHERE Bezeichnung = LOWER('$bezeichnung');") == 0) {
        $sql->execute("INSERT INTO Artikelkategorie(Bezeichnung) VALUES('$bezeichnung');");
        ?>

        <script>
            Toastify({
                text: "Die Kategorie <?php echo $bezeichnung; ?> wurde erstellt.",
                duration: 2500,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                stopOnFocus: true, // Prevents dismissing of toast on hover
                onClick: function () {
                } // Callback after click
            }).showToast();
        </script>

        <?php
    } else {
        $alreadyExists = true;
    }
}
?>
<body>

<form method="post">
    <h1>Kategorie erstellen</h1>

    <input type="text" name="title" required placeholder="Bezeichnung" id="title" active
           value="<?php (isset($_POST['title']) ? $_POST['title'] : "") ?>">
    <?php
    if (isset($alreadyExists)) { ?>

        <script>
            Toastify({
                text: "Diese Kategorie existiert bereits.",
                duration: 2500,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                backgroundColor: "#92000B",
                stopOnFocus: true, // Prevents dismissing of toast on hover
                onClick: function () {
                } // Callback after click
            }).showToast();
        </script>

    <?php } ?>

    </br>
    <input name="create" type="submit" value="Kategorie speichern">
</form>

</body>
</html>
