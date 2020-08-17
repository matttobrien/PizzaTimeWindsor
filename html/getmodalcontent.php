<?php
    require('db.php');
    $id = intval($_POST['pizzeriaID']);
    $query = "SELECT * FROM reviews WHERE pizzeriaID = $id";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    $arr = array();
    if (mysqli_num_rows($result) > 0) {
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            // echo $row['reviewText']."<br/>";
            $row = mysqli_fetch_array($result);
            $temp = $row['userID'];
            $arr[$i]->reviewText = $row['reviewText'];
            $arr[$i]->reviewID = $row['reviewID'];
            $arr[$i]->rating = $row['rating'];
            $q = "SELECT * FROM users WHERE userID = $temp";
            $r = mysqli_query($conn, $q) or die(mysql_error());
            $u = mysqli_fetch_array($r);
            $username = $u['username'];
            $arr[$i]->username = $username;
        }
    }
    echo json_encode($arr);
?>