<?php
    require('db.php');
    session_start();
    $sortBy = $_POST['sortBy'];
    if ($sortBy == 'Reviews') {
        $query = "SELECT pizzeriaID, COUNT(*) FROM reviews GROUP BY pizzeriaID ORDER BY COUNT(*) DESC";
        $result = mysqli_query($conn, $query) or die(mysql_error());
        $idArr = array();
        $pArr = array();
        if (mysqli_num_rows($result) > 0) {
            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                $row = mysqli_fetch_array($result);
                $pizzeriaID = $row['pizzeriaID'];
                $q = "SELECT name, address, phoneNum, imgName, menuLink FROM pizzerias WHERE pizzeriaID = $pizzeriaID";
                $r = mysqli_query($conn, $q) or die(mysql_error());
                $t = mysqli_fetch_array($r);
                $pArr[$i]->pizzeriaID = $pizzeriaID;
                $pArr[$i]->name = $t['name'];
                $pArr[$i]->address = $t['address'];
                $pArr[$i]->phoneNum = $t['phoneNum'];
                $pArr[$i]->imgName = $t['imgName'];
                $pArr[$i]->menuLink = $t['menuLink'];
            }
        }
        echo json_encode($pArr);
    } else if ($sortBy == 'Popularity') {
        $query = "SELECT pizzeriaID, COUNT(*) FROM orders GROUP BY pizzeriaID ORDER BY COUNT(*) DESC";
        $result = mysqli_query($conn, $query) or die(mysql_error());
        $idArr = array();
        $pArr = array();
        if (mysqli_num_rows($result) > 0) {
            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                $row = mysqli_fetch_array($result);
                $pizzeriaID = $row['pizzeriaID'];
                $q = "SELECT name, address, phoneNum, imgName, menuLink FROM pizzerias WHERE pizzeriaID = $pizzeriaID";
                $r = mysqli_query($conn, $q) or die(mysql_error());
                $t = mysqli_fetch_array($r);
                $pArr[$i]->pizzeriaID = $pizzeriaID;
                $pArr[$i]->name = $t['name'];
                $pArr[$i]->address = $t['address'];
                $pArr[$i]->phoneNum = $t['phoneNum'];
                $pArr[$i]->imgName = $t['imgName'];
                $pArr[$i]->menuLink = $t['menuLink'];
            }
        }
        echo json_encode($pArr);
    } else {
        $query = "SELECT * FROM pizzerias";
        $result = mysqli_query($conn, $query) or die(mysql_error());
        $pArr = array();
        if (mysqli_num_rows($result) > 0) {
            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
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
    }
?>