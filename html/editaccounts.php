<?php
    require('db.php');
    $function = $_POST['function'];
    $userID = $_POST['userID'];
    $query = "";
    if ($function == 'enable') {
        $query = "UPDATE users SET active = 1 WHERE userID = $userID";
    } else if ($function == 'disable') {
        $query = "UPDATE users SET active = 0 WHERE userID = $userID";
    } else if ($function == 'makeAdmin') {
        $query = "UPDATE users SET admin = 1 WHERE userID = $userID";
    } else if ($function == 'noMoreAdmin') {
        $query = "UPDATE users SET admin = 0 WHERE userID = $userID";
    } else {
        $query = "DELETE FROM users WHERE userID = $userID";
        $q = "DELETE FROM payment WHERE userID = $userID";
        $r = mysqli_query($conn, $q) or die(mysql_error());
        $qu = "DELETE FROM orders WHERE userID = $userID";
        $re = mysqli_query($conn, $qu) or die(mysql_error());
        $que = "DELETE FROM reviews WHERE userID = $userID";
        $res = mysqli_query($conn, $que) or die(mysql_error());
    }
    $result = mysqli_query($conn, $query) or die(mysql_error());
    echo '200';
?>