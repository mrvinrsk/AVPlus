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
    <title>AVPlus | Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body>

<div id="searchcontainer">
    <input type="text" id="searchbar" class="form-control" placeholder="Suchen...">
    <select id="searchfilter">
        <option value="title">Produkttitel</option>
        <option value="category">Kategorie</option>
        <option value="seller">Verkäufer</option>
    </select>
</div>

<script>
    /*var url_string = window.location.href; //window.location.href
    var url = new URL(url_string);
    var c = url.searchParams.get("p");
    console.log(c);*/

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
                f: $('#searchfilter').val(),
            },
            //If result found, this funtion will be called.
            success: function (html) {
                //Assigning result to "display" div in "search.php" file.
                console.log(html);
                $("#article_container").html(html).show();
            },
            failed: function (e) {
                console.log(e);
            }
        });
    }
</script>

<div id="article_container">

</div>

</body>
</html>