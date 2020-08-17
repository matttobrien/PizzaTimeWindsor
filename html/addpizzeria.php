<?php
    require('db.php');
    $name = $_POST['pName'];
    $address = $_POST['pAddress'];
    $phone = $_POST['pPhone'];
    $menu = $_POST['pLink'];
    $email = $_POST['pEmail'];
    $imgName = $_FILES['pImg']['name'];
    $tempFile = $_FILES['pImg']['tmp_name'];
    $filePath = '../images/' . $imgName;
    $query = "INSERT INTO pizzerias (name, address, phoneNum, imgName, menuLink, email) VALUES ('$name', '$address', '$phone', '$imgName', '$menu', '$email')";
    $result = mysqli_query($conn, $query) or die(mysql_error());
    move_uploaded_file($tempFile, $filePath);
    echo '200';
?>