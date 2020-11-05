<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Debug: SQL</title>
</head>
<body>

<div id="container">
    <?php
    include_once "../../api/sql/sql_account.php";
    include_once "../../api/sql/mysql_api.php";

    if (isset($pdo)) {
        echo "<p class='success'>SQL Verbindung erfolgreich hergestellt.</p>";
        echo "<script>document.getElementById('container').classList.add('success');</script>";
    } else {
        echo "<p>SQL Verbindung konnte nicht hergestellt werden.</p>";
    }
    ?>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

    div {
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;

        width: 100vw;

        background-color: #BC134E;
    }

    p {
        font-family: 'Open Sans', serif;
        font-size: 18px;
        position: relative;
        text-align: center;
        transform: translate(-50%, -0%);
        top: 50%;
        left: 50%;
    }

    div.success {
        background-color: #4BCA03;
    }
</style>

</body>
</html>
