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
    <title>AVPlus | Artikelverwaltung</title>

    <link rel="stylesheet" href="../users/user-wrapper.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body>

<div id="searchcontainer">
    <input type="text" id="searchbar" placeholder="Suchen...">
    <select id="searchfilter">
        <option value="id">Artikelnummer</option>
        <option value="title">Produkttitel</option>
        <option value="price">Preis</option>
        <option value="category">Kategorie</option>
        <option value="seller">Verkäufer</option>
    </select>
</div>
<script src="../acp_src/js/table_wrapper_scroll.js"></script>


<script>
    updateList("");

    $(document).ready(function () {
        $('#searchbar').on('input', function () {
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
                f: $('#searchfilter').val()
            },
            //If result found, this funtion will be called.
            success: function (html) {
                //Assigning result to "display" div in "search.php" file.
                console.log(html);
                $("#user-wrapper").html(html).show();
            },
            failed: function (e) {
                console.log(e);
            }
        });
    }
</script>

<table id="user-wrapper">

</table>

</body>
</html>
