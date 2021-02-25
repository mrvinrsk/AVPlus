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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link rel="stylesheet" href="../users/user-wrapper.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body>

<div id="products_title" class="text-center mt-2 mt-lg-4 mb-3 mb-lg-5">
    <h1>Artikelverwaltung</h1>
    <h5 class="text-secondary" style="letter-spacing: 1px; word-spacing: 4px;">
        Hier kannst du alle Artikel aus dem Shop einsehen und verwalten.
    </h5>
</div>

<div class="container-xl mt-4 mb-4">
    <div id="searchcontainer" class="row">
        <div class="col-md-9">
            <input type="text" id="searchbar" placeholder="Suchen..." class="form-control">
        </div>

        <div class="col-md-3">
            <select id="searchfilter" class="form-select">
                <option value="id">Artikelnummer</option>
                <option value="title">Produkttitel</option>
                <option value="price">Preis</option>
                <option value="category">Kategorie</option>
                <option value="seller">Verkäufer</option>
                <option value="sellerid">Verkäufer-ID</option>
            </select>
        </div>
    </div>
</div>
<script src="../acp_src/js/table_wrapper_scroll.js"></script>


<script>
    updateList("");

    $(document).ready(function () {
        $('#searchbar').on('input', function () {
            var name = $('#searchbar').val();

            if (name != "") {
                updateList(name);
            } else {
                updateList("");
            }
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

<table id="user-wrapper" class="table table-striped container-lg table-sm table-responsive">

</table>

</body>
</html>
