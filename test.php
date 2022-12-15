<!DOCTYPE html>
<html lang="en">

<head>
    <title>TEST</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {

            $("tr").click(function() {
                table = $(this).find('table');
                console.log(table)
            });
            $("input").keyup(function() {
                trId = table.prevObject[0].id;
                var TrItem = document.getElementById(trId);

                input = $(this).find(':input');
                InputObj = input.prevObject[0];
                id = $(InputObj).attr('id');
                idObj = $(InputObj).find(id);

                value = idObj.prevObject[0].value;
                type = idObj.prevObject[0].type;


                if (type == 'number') {
                    min = idObj.prevObject[0].min;
                    max = idObj.prevObject[0].max;

                    value = parseFloat(value);
                    min = parseFloat(min);
                    max = parseFloat(max);

                    if ((value >= min) && (value <= max)) {
                        $(TrItem).removeClass().addClass("table-success");
                    } else if ((value < min) || (value > max)) {
                        $(TrItem).removeClass().addClass("table-danger");
                    } else {
                        $(TrItem).removeClass().addClass("table-default");
                    }

                } else if (type == 'text') {

                    if (value !== '') {
                        $(TrItem).removeClass().addClass("table-success");
                    } else {
                        $(TrItem).removeClass().addClass("table-default");
                    }
                }
            });
        });
    </script>
</head>

<body>

    <div class="container">
        <h2 class="text-center">STARTUP2.0</h2>
        <form name="form">
            <table class="table table-bordered thead-dark">
                <thead class="thead-dark">
                    <tr>
                        <th>PROCESS</th>
                        <th>ITEM</th>
                        <th>SPEC</th>
                        <th>VALUE</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="div1">
                        <td>OVEN</td>
                        <td>ITEM1</td>
                        <td>0-10</td>
                        <td><input id="value1" name="value1" type="number" min="0" max="10"></td>
                    </tr>
                    <tr id="div2">
                        <td>OVEN</td>
                        <td>ITEM2</td>
                        <td>20-50</td>
                        <td><input id="value2" name="value2" type="number" min="20" max="50"></td>
                    </tr>
                    <tr id="div3">
                        <td>OVEN</td>
                        <td>ITEM3</td>
                        <td>TEXT</td>
                        <td><input id="value3" name="value3" type="text"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</body>

</html>

<?php
// $mydir = 'T:\Common';
// $myfiles = array_diff(scandir($mydir), array('.', '..'));
// print_r($myfiles);
?>