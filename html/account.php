<?php 
    require_once "db.php";
    session_start();
    
    if (isset($_POST['firstName']) || isset($_POST['lastName']) ||
        isset($_POST['address']) || isset($_POST['email']) ||
        isset($_POST['username']) || isset($_POST['password'])) {
        $query = "UPDATE users SET";
        if (isset($_POST['firstName'])) {
            $firstName = $_POST['firstName'];
            $query .= " firstName = '$firstName'";
        } else if (isset($_POST['lastName'])) {
            $lastName = $_POST['lastName'];
            $query .= " lastName = '$lastName'";
        } else if (isset($_POST['address'])) {
            $address = $_POST['address'];
            $query .= " address = '$address'";
        } else if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $query .= " email = '$email'";
        } else if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $query .= " username = '$username'";
        } else if (isset($_POST['password'])) {
            $password = $_POST['password'];
            $query .= " password = '" . md5($password) . "'";
        }
        $userID = $_SESSION['userID'];
        $query .= "WHERE userID = $userID";
        $result = mysqli_query($conn, $query) or die(mysql_error());
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <?php include 'head.php' ?> 
    <title>Account Settings</title>
    <!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">
    <script src="../js/account.js" type="text/javascript"></script>
  </head>
  <body>
    <?php include 'navbar.php' ?>  
    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1>Account Settings</h1>
          <!--<p class="lead text-muted">We love pizza just as much as you do! So, thats why we would like you to contact us if theres a pizzeria that you would like to see on our website, if there are any problems with the site, or if you have any questions!</p>-->
        </div>
      </section>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row justify-content-md-center">
            <div class="col">
              <div class="card w-250 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Edit Account Info</h5>
                    <?php
                        $userID = $_SESSION['userID'];
                        $query = "SELECT username, email, firstName, lastName, address FROM users WHERE userID = $userID";
                        $result = mysqli_query($conn, $query) or die(mysql_error());
                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $firstName = $row['firstName'];
                            $lastName = $row['lastName'];
                            $address = $row['address'];
                            $username = $row['username'];
                            $email = $row['email'];
                        }
                    ?>
                    <form method="post">
                      <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" name="firstName" id="firstName" placeholder="<?php echo $firstName; ?>" aria-describedby="firstName">
                      </div>
                      <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" name="lastName" id="lastName" placeholder="<?php echo $lastName; ?>" aria-describedby="lastName">
                      </div>
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="<?php echo $address; ?>" aria-describedby="address">
                      </div>
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="<?php echo $username; ?>" aria-describedby="username">
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo $email; ?>" aria-describedby="email">
                      </div>
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="********" aria-describedby="password">
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card w-250 shadow-sm" style="height: 100%;">
                <div class="card-body">
                    <h5 class="card-title text-center">Order History</h5>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">orderID</th>
                          <th scope="col">Pizzeria</th>
                          <th scope="col">Order Details</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $query = "SELECT * FROM orders where userID = $userID";
                        $result = mysqli_query($conn, $query) or die(mysql_error());
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) { 
                                $pizzeriaID = $row['pizzeriaID'];
                                $q = "SELECT name FROM pizzerias WHERE pizzeriaID = $pizzeriaID"; 
                                $r = mysqli_query($conn, $q) or die(mysql_error());
                                $prow = mysqli_fetch_assoc($r); ?>
                                <!--HTML-->
                                <tr>
                                  <th scope="row"><?php echo $row['orderID']; ?></th>
                                  <td><?php echo $prow['name']; ?></td>
                                  <td><?php echo $row['orderDetails']; ?></td>
                                <!--END OF HTML-->
                            <?php }
                        } ?>
                      </tbody>
                   </table>
                </div>
              </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-md-center">
            <?php if ($_SESSION['admin'] == 1) { ?>
                <div class="col">
                  <div class="card w-250 shadow-sm">
                    <div class="card-body">
                        <?php include 'chart.php';  ?>
                    </div>
                  </div>
                </div>
            <?php } ?>
            </div>
        <br> 
        <div class="row justify-content-md-center">
            <?php if ($_SESSION['admin'] == 1) { ?>
                <div class="col">
                  <div class="card w-250 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center">Manage Users</h5>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">userID</th>
                              <th scope="col">Username</th>
                              <th scope="col">Active</th>
                              <th scope="col">Account</th>
                              <th scope="col">Delete</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                            $query = "SELECT userID, username, active, admin FROM users";
                            $result = mysqli_query($conn, $query) or die(mysql_error());
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) { ?>
                                    <!--HTML-->
                                    <tr>
                                      <th scope="row"><?php echo $row['userID']; ?></th>
                                      <td><?php echo $row['username']; ?></td>
                                      <td><?php if($row['active'] == 1) { echo '<button type="button" class="btn btn-outline-danger" id="disableAcc" data-whatever="' . $row['userID'] . '">Disable</button>'; } else { echo '<button type="button" class="btn btn-outline-success" id="enableAcc" data-whatever="' . $row['userID'] . '">Enable</button>'; } ?></td>
                                      <td><?php if($row['admin'] == 1) { echo '<button type="button" class="btn btn-outline-success" id="noMoreAdmin" data-whatever="' . $row['userID'] . '">Admin</button>'; } else { echo '<button type="button" class="btn btn-outline-danger" id="makeAdmin" data-whatever="' . $row['userID'] . '">User</button>'; } ?></td>
                                      <td><button type="button" class="btn btn-outline-danger" id="deleteAcc" data-whatever="<?php echo $row['userID']; ?>">Delete</button></td>
                                    </tr>
                                    <!--END OF HTML-->
                                <?php }
                            } ?>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            <?php } ?>
            </div>
          </div>
        </div>
          </div>
        </div>
      </div>
    </main>
    <?php include 'footer.php' ?>  
</html>
