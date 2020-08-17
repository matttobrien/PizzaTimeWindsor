<?php 
    require_once "db.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'head.php'; ?>
    <title>PizzaTimeWindsor</title>
    <!-- Custom styles for this template -->
    <script src="../js/index.js" type="text/javascript"></script>
    <link href="../css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Since I make use of a PHP session variable in my review element, I need to have this script in a .php file-->
    <script>
        $(document).ready(function() {
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                var spl = recipient.split(".")
                var modal = $(this)
                
                $.ajax({
                    method: "POST",
                    url: "getmodalcontent.php",
                    data: { "pizzeriaID": spl[1] },
                    success: editModal
                });
                
                function editModal (response) {
                    var reviews = JSON.parse(response)
                    modal.find('.modal-title').text(spl[0] + ' Reviews')
                    modal.find('#pizzeriaID').val(spl[1])
                    if (reviews.length === 0) {
                        modal.find('.modal-reviews').append('<div class="card"><div class="card-body"><h5 class="card-title">No Data</div></div>')
                    } else {
                        reviews.forEach(function(obj) {
                            modal.find('.modal-reviews').append('<div class="card"><div class="card-body"><h5 class="card-title">' + obj.username + ' ' + generateStars(obj) + '</h5>' + obj.reviewText + '</div><?php if ($_SESSION['admin'] == 1) { ?><button type="button" class="btn btn-sm btn-outline-danger" id="deleteReview" data-whatever="' + obj.reviewID + '">Delete</button><?php } ?></div>')
                        })
                    }
                }
                
                function generateStars (obj) {
                    var str = ''
                    for (var i = 0; i < 5; i++) {
                        if (i < obj.rating) {
                            str += '<span class="fa fa-star checked"></span>'
                        } else {
                            str += '<span class="fa fa-star"></span>'
                        }
                    }
                    return str
                }
            })
            
            $('#orderModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('whatever') // Extract info from data-* attributes
                $('#orderPizzeriaID').val(id)
            })
            
            $('#submitOrder').on("click", function(event) {
                var pizzeriaID = $('#orderPizzeriaID').val()
                var order = $('#orderdet').val()
                var fullName = $('#cc-name').val()
                var address = $('#orderAddress').val()
                var postal = $('#postal').val()
                var card = $('#cc-number').val()
                var exp = $('#cc-exp').val()
                var ccv = $('#cc-ccv').val()
                var button = $(this)
                
                $.ajax({
                    method: "POST",
                    url: "order.php",
                    data: { "pizzeriaID": pizzeriaID,
                            "orderdet": order,
                            "fullName": fullName,
                            "address": address,
                            "postal": postal,
                            "card": card,
                            "exp": exp,
                            "ccv": ccv },
                    success: orderSubmitted,
                    error: orderFailed
                });
                
                function orderSubmitted (response) {
                    button.addClass('btn-success').removeClass('btn-primary')
                    button.html('Success')
                    $('#orderSuccess').html('You will recieve a confirmation email once the pizzeria confirms your order.')
                    setTimeout(function() {
                        $('#closeOrderModal').click()
                        $('#orderPizzeriaID').val('')
                        $('#orderdet').val('')
                        $('#cc-name').val('')
                        $('#orderAddress').val('')
                        $('#postal').val('')
                        $('#cc-number').val('')
                        $('#cc-exp').val('')
                        $('#cc-ccv').val('')
                        $('#orderSuccess').html('')
                    }, 5000)
                }
                
                function orderFailed (response) {
                    $('#orderSuccess').html('Please make sure all of the info you entered is correct.')
                }
            })
            
        })
    </script>
    <!--this woudld not work in an external css file-->
    <style>
        .checked {
          color: orange;
        }
    </style>
  </head>
    <body>
        <?php include 'navbar.php'; ?>
        <main role="main" class="container">
          <section class="jumbotron text-center">
            <div class="container">
              <h1>It's Pizza Time!</h1>
              <p class="lead text-muted">Welcome to PizzaTimeWindsor, the one-stop-shop for pizzerias in Windsor. Check out the many pizzeria's below, you can view thier menu's, read user reviews, and place an order for yourself!</p>
              <p>
                <a href="login.php" class="btn btn-success my-2">Login</a>
                <a href="register.php" class="btn btn-secondary my-2">Create an Account</a>
                <?php if ($_SESSION['admin'] == 1) { ?>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addPizzeriaModal">Add Pizzeria</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletePizzeriaModal">Delete Pizzeria</button>
                <?php } ?>
              </p>
            </div>
          </section>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <p></p>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Sort
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#" id="pop">Popularity</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#" id="rev">Reviews</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#" id="all">All</a>
                    </div>
                  </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                  <input class="form-control mr-sm-2" id="searchInput" type="search" placeholder="Search by name" aria-label="Search">
                  <button class="btn btn-outline-success my-2 my-sm-0" id="searchBtn">Search</button>
                </div>
              </div>
            </nav>
          <div class="album py-5 bg-light">
            <div class="container">
              <div class="row" id="pizzerias">
                <!-- loop here -->
                <?php 
                    $query = "SELECT * FROM pizzerias";
                    $result = mysqli_query($conn, $query) or die(mysql_error());
                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                        while($row = mysqli_fetch_assoc($result)) { ?>
                            <!--HTML-->
                            <div class="col-md-4">
                              <div class="card mb-4 shadow-sm">
                                <img src="../images/<?php echo $row["imgName"]; ?>" class="img-fluid border-bottom" alt="Responsive image">
                                <!--<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>-->
                                <div class="card-body">
                                  <p class="card-text"><?php echo $row["name"]. "<br>" ." Address: " . $row["address"]. "<br>" ." Phone: " . $row["phoneNum"]. "<br>"; ?></p>
                                  <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                      <a href="<?php echo $row["menuLink"] ?>" target="_blank"><button type="button" class="btn btn-sm btn-outline-secondary">View Menu</button></a>
                                        <?php if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) { ?>
                                            <a href="login.php"><button type="button" class="btn btn-sm btn-outline-secondary">Order</button></a>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#orderModal" data-whatever="<?php echo $row["pizzeriaID"]; ?>">Order</button>
                                        <?php } ?>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $row["name"] . "." . $row["pizzeriaID"] . "." . $_SESSION['uname']; ?>">
                                        Reviews
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!--END OF HTML-->
                        <?php }
                    } else {
                        echo "0 results";
                    }
                    mysqli_free_result($result);
                ?>
              </div>
            </div>
          </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <input type="hidden" id="pizzeriaID"></input>
                <button type="button" class="close" id="closeModalX" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class='modal-reviews'>
                      <!--Reviews are dynamically added here-->
                  </div>
                  <br/>
                  <div class="modal-input">
                        <?php if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="reviewInput">Leave a Review</label>
                                        <input type="text" class="form-control" id="reviewInput" name="reviewInput" aria-describedby="Review" disabled>
                                        <small id="reviewTip" class="form-text text-muted"><a href="login.php">Sign in</a> to leave a review!</small>
                                        <div>
                                            <input type="radio" name="rating" value="1" disabled> <span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="2" disabled> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="3" disabled> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="4" disabled> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="5" disabled> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                        </div>
                                    </div>
                                    <button id="submitReview" class="btn btn-primary" disabled>Submit</button>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="reviewInput">Leave a Review</label>
                                        <input type="text" class="form-control" id="reviewInput" name="reviewInput" aria-describedby="Review">
                                        <small id="reviewTip" class="form-text text-muted">Stay on your Ps & Qs</small>
                                        <div>
                                            <input type="radio" name="rating" value="1"> <span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="2"> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="3"> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="4"> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                            <input type="radio" name="rating" value="5"> <span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>
                                        </div>
                                    </div>
                                    <button id="submitReview" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        <?php } ?>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <input type="hidden" id="orderPizzeriaID"></input>
                <button type="button" class="close" id="closeOrderModal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modal-order">
                <div>
                  <div class="form-group">
                    <label for="orderdet">Order</label>
                    <textarea class="form-control" id="orderdet" name="orderdet" rows="4" required></textarea>
                    <small id="reviewTip" class="form-text text-muted">Please write the order as it appears on the menu</small>
                    <br>
                    <!--<div class="row">-->
                    <!--  <div class="col-md-6 mb-3">-->
                    <!--    <label for="firstName">First Name</label>-->
                    <!--    <input type="text" class="form-control" id="firstName" placeholder="" value="" required>-->
                    <!--    <div class="invalid-feedback">-->
                    <!--      Valid first name is required.-->
                    <!--    </div>-->
                    <!--  </div>-->
                    <!--  <div class="col-md-6 mb-3">-->
                    <!--    <label for="lastName">Last Name</label>-->
                    <!--    <input type="text" class="form-control" id="lastName" placeholder="" value="" required>-->
                    <!--    <div class="invalid-feedback">-->
                    <!--      Valid last name is required.-->
                    <!--    </div>-->
                    <!--  </div>-->
                    <!--</div>-->

                    <div class="mb-3">
                      <label for="orderAddress">Billing Address</label>
                      <input type="text" class="form-control" id="orderAddress" placeholder="" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="postal">Postal Code</label>
                        <input type="text" class="form-control" id="postal" placeholder="" required>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Name on Card</label>
                            <input type="text" class="form-control" id="cc-name" placeholder="" required>
                            <small class="text-muted">Full name as displayed on card</small>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="cc-number">Credit Card Number</label>
                            <input type="text" class="form-control" id="cc-number" placeholder="" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6 mb-6">
                            <label for="cc-exp">Expiration</label>
                            <input type="text" class="form-control" id="cc-exp" placeholder="" required>
                          </div>
                          <div class="col-md-6 mb-6">
                            <label for="cc-ccv">CCV</label>
                            <input type="text" class="form-control" id="cc-ccv" placeholder="" required>
                          </div>
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-2 mb-2">
                              <button type="submit" class="btn btn-primary" id="submitOrder">Submit</button>
                          </div>
                        <div class="col-md-10 mb-10">
                            <small id="orderSuccess" class="form-text text-muted"></small>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeOrderModal" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addPizzeriaModal" tabindex="-1" aria-labelledby="pizzeriaModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="pizzeriaModalLabel">Add Pizzeria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="addPizzeria" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="pName">Name</label>
                    <input type="text" class="form-control" name="pName" id="pName" aria-describedby="pName">
                  </div>
                  <div class="form-group">
                    <label for="pAddress">Address</label>
                    <input type="text" class="form-control" name="pAddress" id="pAddress" aria-describedby="pAddress">
                  </div>
                  <div class="form-group">
                    <label for="pPhone">Phone</label>
                    <input type="text" class="form-control" name="pPhone" id="pPhone" aria-describedby="pPhone">
                  </div>
                  <div class="form-group">
                    <label for="pLink">Menu Link</label>
                    <input type="text" class="form-control" name="pLink" id="pLink" aria-describedby="pLink">
                  </div>
                  <div class="form-group">
                    <label for="pEmail">Email</label>
                    <input type="email" class="form-control" name="pEmail" id="pEmail" aria-describedby="pEmail">
                  </div>
                  <div class="form-group">
                    <label for="pImg">Image</label>
                    <input type="file" id="pImg" name="pImg" accept="image/*" aria-describedby="pImg">
                    <small id="reviewTip" class="form-text text-muted">Image should be 225hx340w pixels</small>
                  </div>
                  <button type="submit" class="btn btn-primary" id="addPizzaeriaBtn">Submit</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeAddPizzeriaModal" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="deletePizzeriaModal" tabindex="-1" aria-labelledby="pizzeriaModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="pizzeriaModalLabel">Delete Pizzeria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div>
                  <div class="form-group">
                    <label for="dName">Name</label>
                    <input type="text" class="form-control" name="dName" id="dName" aria-describedby="dName">
                    <small id="deletePizzeriaText" class="form-text text-muted">Please enter the name exactly as it is shown below.</small>
                  </div>
                  <button type="submit" class="btn btn-primary" id="deletePizzaeriaBtn">Submit</button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeDeletePizzeriaModal" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        </main><!-- /.container -->
        <?php include 'footer.php'; ?>
    </body>
</html>