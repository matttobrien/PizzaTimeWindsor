<?php
    require('db.php');
    session_start();
    $userID = $_SESSION['userID'];
    $address = $_POST['address'];
    $postal = $_POST['postal'];
    $card = $_POST['card'];
    $name = $_POST['fullName'];
    $exp = $_POST['exp'];
    $ccv = $_POST['ccv'];
    $text = $_POST['orderdet'];
    $pizzaeriaID = $_POST['pizzeriaID'];
    $q = "INSERT INTO orders (userID, pizzeriaID, orderDetails) VALUES ($userID, $pizzaeriaID, '$text')";
    $r = mysqli_query($conn, $q) or die(mysql_error());
    $qu = "SELECT orderID FROM orders WHERE userID = $userID AND pizzeriaID = $pizzaeriaID AND orderDetails = '$text'";
    $re = mysqli_query($conn, $qu) or die(mysql_error());
    $row = mysqli_fetch_array($re);
    $orderID = $row['orderID'];
    $query = "INSERT INTO payment (userID, orderID, fullName, billingAddr, creditNum, creditExp, ccv) VALUES ($userID, $orderID, '$name', '$address', '$card', '$exp', '$ccv')";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    
    echo '200';
?>