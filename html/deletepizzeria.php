<?php
    require('db.php');
    $name = $_POST['name'];
    $query = "SELECT pizzeriaID FROM pizzerias WHERE name = '$name'";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    $row = mysqli_fetch_array($result);
    $pizzeriaID = $row['pizzeriaID'];
    $q = "DELETE FROM orders WHERE pizzeriaID = $pizzeriaID";
    $r = mysqli_query($conn, $q) or die(mysql_error());
    $qu = "DELETE FROM reviews WHERE pizzeriaID = $pizzeriaID";
    $re = mysqli_query($conn, $qu) or die(mysql_error());
    $que = "DELETE FROM pizzerias WHERE pizzeriaID = $pizzeriaID";
    $res = mysqli_query($conn, $que) or die(mysql_error());
    echo '200';
?>