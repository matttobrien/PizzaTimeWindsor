<?php
    require('db.php');
    $reviewID = $_POST['reviewID'];
    $query = "DELETE FROM reviews WHERE reviewID = $reviewID";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    echo '200';
?>