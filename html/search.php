<?php
    require('db.php');
    $searchInput = $_POST['searchInput'];
    $query = "SELECT * FROM pizzerias WHERE name LIKE '%$searchInput%'";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    $pArr = array();
    if (mysqli_num_rows($result) > 0) {
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            // echo $row['reviewText']."<br/>";
            $row = mysqli_fetch_array($result);
            $pArr[$i]->pizzeriaID = $row['pizzeriaID'];
            $pArr[$i]->name = $row['name'];
            $pArr[$i]->address = $row['address'];
            $pArr[$i]->phoneNum = $row['phoneNum'];
            $pArr[$i]->imgName = $row['imgName'];
            $pArr[$i]->menuLink = $row['menuLink'];
        }
    }
    echo json_encode($pArr);
?>