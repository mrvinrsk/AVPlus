<?php
include_once "../../api/sql/sql_account.php";
include_once "../../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AVPlus | Nutzerverwaltung</title>

    <link rel="stylesheet" href="user-wrapper.css">
</head>
<body>

<input type="text" id="searchbar" placeholder="Suche nach Kunden..." oninput="search(this.value)">


<script>
    search('');

    function search(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("user-wrapper").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "getusers.php?q=" + str, true);
        xmlhttp.send();
    }
</script>


<p id="query"></p>
<table id="user-wrapper">

</table>

</body>
</html>
