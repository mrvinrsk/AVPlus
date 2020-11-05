<?php

include_once "../api/sql/sql_account.php";
include_once "../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);


if (isset($_POST['sql_connection'])) {
    header('Location: SQL/');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Debug</title>
</head>
<body>

<form method="post">
    <h1>Was möchtest du testen?</h1>
    <input type="submit" name="sql_connection" value="SQL Verbindung">
</form>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

    * {
        font-family: 'Open Sans', serif;
    }

    h1 {
        font-size: 20px;
    }

    form {
        min-width: 50vw;
        font-size: 16px;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        border: 1px solid #343434;
        border-radius: 2px;
        padding: 5vh 2.5vw;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    }

    form input[type=submit] {
        margin: 1rem;
        padding: .9rem 1.75rem;

        background-color: #eee;
        border: 1px solid #343434;
        border-radius: 2px;
        color: #343434;

        transition-duration: .325s;
    }

    form input[type=submit]:hover {
        background: #0e5cff;
        color: #eee;
    }
</style>

</body>
</html>
