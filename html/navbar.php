<?php session_start(); ?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #E74C3C;">
  <a class="navbar-brand" href="index.php">PizzaTimeWindsor</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        <?php } else { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $_SESSION['uname']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="account.php">Account Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        <?php } ?>
        <!--<li class="nav-item">-->
        <!--    <a class="nav-link" href="about.php">About</a>-->
        <!--</li>-->
        <li class="nav-item">
            <a class="nav-link" href="contactus.php">Contact Us</a>
        </li>
    </ul>
  </div>
</nav>