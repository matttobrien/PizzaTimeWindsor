<?php
    require('db.php');
    $query = "select pizzeriaID, count(*) as Count from orders group by pizzeriaID";
    $result = mysqli_query($conn, $query) or die(mysql_error());
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});

    google.charts.setOnLoadCallback(drawChart);
    function drawChart(){
        var data = new google.visualization.DataTable();
        var data = google.visualization.arrayToDataTable([
            ['Pizzeria','Number of Orders'],
            <?php
                while($row = mysqli_fetch_assoc($result)){
                    $pizzeriaID = $row["pizzeriaID"];
                    $q = "SELECT name FROM pizzerias WHERE pizzeriaID = $pizzeriaID";
                    $r = mysqli_query($conn, $q) or die(mysql_error());
                    $p = mysqli_fetch_assoc($r);
                    $name = str_replace('\'', '', $p["name"]);
                    echo "['".$name."', ".$row["Count"]."],";
                }
            ?>
           ]);

        var options = {
            title: 'Number of Orders per Pizzeria',
            legend: { position: 'bottom' },
            width: 'auto',
            height: 'auto'
        };

        var chart = new google.visualization.PieChart(document.getElementById('areachart'));
        chart.draw(data, options);
    }

</script>

<div id="areachart" style="width: 100%; height: 400px;"></div>
