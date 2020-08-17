<?php
    require('db.php');
    session_start();
    $userID = $_SESSION['userID'];
    $pizzeriaID = intval($_POST['pizzeriaID']);
    $rating = $_POST['rating'];
    $text = $_POST['reviewText'];
    $query = "INSERT INTO reviews (pizzeriaID, userID, reviewText, rating) VALUES ($pizzeriaID, $userID, '$text', $rating)";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    echo '200';
?>