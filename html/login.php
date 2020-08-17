<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['email'])) {
        $email = $conn->real_escape_string($_REQUEST['email']);
        $password = $conn->real_escape_string($_REQUEST['password']);
        // Check user is exist in the database
        $query = "SELECT * FROM users WHERE email='$email' AND password='" . md5($password) . "'";
        $result = mysqli_query($conn, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        
        if ($rows == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['uname'] = $row['username'];
            $_SESSION['admin'] = $row['admin'];
            // Redirect to index
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='form-signin'>
                  <h3>Incorrect email/password.</h3><br/>
                  <p>Please try again</p>
                  </div>";
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <?php include 'head.php'; ?>
    <title>Login</title>
    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <?php include 'navbar.php'; ?>
    <form class="form-signin border rounded-lg" method="post">
      <img class="mb-4" src="../images/tempLogo.png" alt="" width="300" height="45">
      <h2 class="h3 mb-3 font-weight-normal">Login</h2>
      <label for="email" class="sr-only">Email address</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
      <p class="mt-4 mb-2">New User? Create an account <a href="register.php">here</a></p>
      <p class="mt-5 mb-3 text-muted">&copy; PizzaTimeWindsor 2020</p>
    </form>
  </body>
</html>