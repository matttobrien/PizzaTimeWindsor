<?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = wordwrap($_POST['message'], 70);
        mail("contact@mattobrien.dev", "PizzaTimeWindsor", "Name: $name - Msg: $message", "cc: $email");
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <?php include 'head.php' ?> 
    <title>Contact Us</title>
    <!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'navbar.php' ?>  
    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1>We're here to help</h1>
          <p class="lead text-muted">We love pizza just as much as you do! So, thats why we would like you to contact us if theres a pizzeria that you would like to see on our website, if there are any problems with the site, or if you have any questions!</p>
        </div>
      </section>
      <div class="album py-5 bg-light">
        <div class="container">
          <div class="row justify-content-md-center">
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Contact Us</h5>
                    <form method="post">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="name" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="email" required>
                      </div>
                      <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include 'footer.php' ?>  
</html>