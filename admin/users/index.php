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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>

<div class="container-xl mt-4 mb-4">
    <div id="searchcontainer" class="row">
        <div class="col-md-9">
            <input type="text" id="searchbar" placeholder="Suchen..." class="form-control">
        </div>

        <div class="col-md-3">
            <select id="searchfilter" class="form-select">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="mail">Mail</option>
                <option value="rang">Rang</option>
                <option value="registerdate">Registrierungsdatum</option>
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

            updateList(name);
        });

        $('#searchfilter').on('change', function () {
            var name = $('#searchbar').val();

            updateList(name);
        });
    });

    function updateList(str) {
        $.ajax({
            //AJAX type is "Post".
            type: "POST",
            //Data will be sent to "ajax.php".
            url: "getusers.php",
            //Data, that will be sent to "ajax.php".
            data: {
                //Assigning value of "name" into "search" variable.
                q: str,
                f: $('#searchfilter').val()
            },
            //If result found, this funtion will be called.
            success: function (html) {
                //Assigning result to "display" div in "search.php" file.
                $("#user-wrapper").html(html).show();
            }
        });
    }
</script>

<table id="user-wrapper" class="table table-striped container-lg table-responsive">

</table>

</body>
</html>
