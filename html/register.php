<?php
  // When form submitted, insert values into the database.
  require('db.php');
  if (isset($_REQUEST['firstName'])) {
      $firstName = $conn->real_escape_string($_REQUEST['firstName']);
      $lastName = $conn->real_escape_string($_REQUEST['lastName']);
      $address = $conn->real_escape_string($_REQUEST['address']);
      $email = $conn->real_escape_string($_REQUEST['email']);
      $username = $conn->real_escape_string($_REQUEST['username']);
      $password = $conn->real_escape_string($_REQUEST['password']);
      $query = "INSERT into users (email, firstName, lastName, username, address, password, admin, active) VALUES ('$email', '$firstName', '$lastName', '$username', '$address', '" . md5($password) . "', 0, 1)";
      $result = mysqli_query($conn, $query);
      if ($result) {
          echo "<div class='form-signin'>
                <h3>You are registered successfully.</h3><br/>
                <p class='link'>Click here to <a href='login.php'>Login</a></p>
                </div>";
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
    <title>Register</title>
    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <?php include 'navbar.php'; ?>  
    <form class="form-signin border rounded-lg" method="post">
      <img class="mb-4" src="../images/tempLogo.png" alt="" width="300" height="45">
      <h2 class="h3 mb-3 font-weight-normal">Create an Account</h2>
      <label for="firstName" class="sr-only">First Name</label>
      <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" required autofocus>
      <label for="lastName" class="sr-only">Last Name</label>
      <input type="text" id="lastName"  name="lastName" class="form-control" placeholder="Last Name" required>
      <label for="address" class="sr-only">Address</label>
      <input type="text" id="address"  name="address" class="form-control" placeholder="Address" required>
      <label for="emailAddress" class="sr-only">Email</label>
      <input type="email" id="emailAddress" name="email" class="form-control" placeholder="Email" required>
      <label for="username" class="sr-only">Username</label>
      <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
      <label for="password" class="sr-only">Password</label>
      <input type="password" id="password"  name="password" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Register</button>
      <p class="mt-5 mb-3 text-muted">&copy; PizzaTimeWindsor 2020</p>
    </form>
  </body>
</html>