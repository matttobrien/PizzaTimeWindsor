<?php 
    require_once "db.php";
    session_start();
    echo session_id();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'head.php'; ?>
    <title>About Us</title>
    <!-- Custom styles for this template -->
    <link href="../css/starter-template.css" rel="stylesheet">
  </head>
    <body>
        <?php include 'navbar.php'; ?>
        <main role="main" class="container">
          <div class="starter-template">
            <h1>About Us</h1>
            <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
            <p>Welcome <?php echo $_SESSION['test']; ?></p>
          </div>
        </main><!-- /.container -->
    </body>
</html>