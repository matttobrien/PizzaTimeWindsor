$(document).ready(function() {
    $('#deletePizzaeriaBtn').on("click", function(event) {
        var name = $('#dName').val()
        var button = $(this)
        console.log('name: ' + name)
        $.ajax({
            method: "POST",
            url: "deletepizzeria.php",
            data: { "name": name },
            success: pizzeriaDeleted,
            error: deleteFailed
        });
        
        function pizzeriaDeleted (response) {
            button.addClass('btn-success').removeClass('btn-primary')
            button.html('Success')
            setTimeout(function() {
                $('#closeDeletePizzeriaModal').click()
                button.addClass('btn-primary').removeClass('btn-success')
                button.html('Submit')
                $('#deletePizzeriaText').html('Please enter the name exactly as it is shown below.')
                $('#dName').val('')
                location.reload();
            }, 5000)
        }
        
        function deleteFailed (response) {
            $('#deletePizzeriaText').html('Pizzeria not found.')
        }
    })
    
    $("form#addPizzeria").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        var button = $('#addPizzaeriaBtn')
        
        $.ajax({
            url: 'addpizzeria.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                button.addClass('btn-success').removeClass('btn-primary')
                button.html('Success')
                setTimeout(function() {
                    location.reload();
                }, 1000)
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })
    
    $(document).on("click", "#deleteReview", function() {
        var button = $(this)
        var reviewID = button.data('whatever')
        
         $.ajax({
            method: "POST",
            url: "deletereview.php",
            data: { "reviewID":  reviewID},
            success: reviewDeleted
        });
        
        function reviewDeleted (response) {
            button.addClass('btn-outline-success').removeClass('btn-outline-danger')
            button.html('Success')
            setTimeout(function() {
                $('#closeModalButton').click()
            }, 1000)
        }
    })
    
    $('#closeModalButton').on("click", function() {
        var modal = $('#exampleModal')
        modal.find('.modal-reviews').empty()
    })
    
    $('#closeModalX').on("click", function() {
        var modal = $('#exampleModal')
        modal.find('.modal-reviews').empty()
    })
    
    $('#submitReview').on("click", function(event) {
        var modal = $('#exampleModal')
        var text = modal.find('#reviewInput').val()
        var id = modal.find('#pizzeriaID').val()
        var rating = $("input[name=rating]:checked").val()
        modal.find('#reviewInput').val('Thank you for your feedback!')
        
        $.ajax({
            method: "POST",
            url: "submitreview.php",
            data: { "reviewText": text, "pizzeriaID":  id, "rating": rating},
            success: reviewSubmitted
        })
        
        function reviewSubmitted (response) {
            setTimeout(function() {
                modal.find('#reviewInput').val('')
                $("input[name=rating]:checked").prop( "checked", false );
                $('#closeModalButton').click()
            }, 1000)
        }
        
    })
    
    // END OF MODAL CODE
    
    $("#pop").click(function() {
        var album = $('#pizzerias')
        album.empty()
        
        $.ajax({
            method: "POST",
            url: "sortby.php",
            data: { "sortBy": "Popularity" },
            success: repopPizzerias
        })
        
        function repopPizzerias (response) {
            var pizzerias = JSON.parse(response)
            pizzerias.forEach(function(obj) {
                album.append('<div class="col-md-4"><div class="card mb-4 shadow-sm"><img src="../images/' + obj.imgName + '" class="img-fluid border-bottom" alt="Responsive image"><div class="card-body"><p class="card-text">' + obj.name + '<br> Address: ' + obj.address + '<br> Phone: ' + obj.phoneNum + '<br>' + '</p><div class="d-flex justify-content-between align-items-center"><div class="btn-group"><a href="' + obj.menuLink + '" target="_blank"><button type="button" class="btn btn-sm btn-outline-secondary">View Menu</button></a><button type="button" class="btn btn-sm btn-outline-secondary">Order</button></div><button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal" data-whatever="' + obj.name + '.' + obj.pizzeriaID + '">Reviews</button></div></div></div></div>')
            })
        }
    })
    
    $("#rev").click(function() {
        var album = $('#pizzerias')
        album.empty()
        
        $.ajax({
            method: "POST",
            url: "sortby.php",
            data: { "sortBy": "Reviews" },
            success: repopPizzerias
        });
        
        function repopPizzerias (response) {
            var pizzerias = JSON.parse(response)
            pizzerias.forEach(function(obj) {
                album.append('<div class="col-md-4"><div class="card mb-4 shadow-sm"><img src="../images/' + obj.imgName + '" class="img-fluid border-bottom" alt="Responsive image"><div class="card-body"><p class="card-text">' + obj.name + '<br> Address: ' + obj.address + '<br> Phone: ' + obj.phoneNum + '<br>' + '</p><div class="d-flex justify-content-between align-items-center"><div class="btn-group"><a href="' + obj.menuLink + '" target="_blank"><button type="button" class="btn btn-sm btn-outline-secondary">View Menu</button></a><button type="button" class="btn btn-sm btn-outline-secondary">Order</button></div><button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal" data-whatever="' + obj.name + '.' + obj.pizzeriaID + '">Reviews</button></div></div></div></div>')
            })
        }
    })
    
    $("#all").click(function() {
        var album = $('#pizzerias')
        album.empty()
        
        $.ajax({
            method: "POST",
            url: "sortby.php",
            data: { "sortBy": "All" },
            success: repopPizzerias
        });
        
        function repopPizzerias (response) {
            var pizzerias = JSON.parse(response)
            pizzerias.forEach(function(obj) {
                album.append('<div class="col-md-4"><div class="card mb-4 shadow-sm"><img src="../images/' + obj.imgName + '" class="img-fluid border-bottom" alt="Responsive image"><div class="card-body"><p class="card-text">' + obj.name + '<br> Address: ' + obj.address + '<br> Phone: ' + obj.phoneNum + '<br>' + '</p><div class="d-flex justify-content-between align-items-center"><div class="btn-group"><a href="' + obj.menuLink + '" target="_blank"><button type="button" class="btn btn-sm btn-outline-secondary">View Menu</button></a><button type="button" class="btn btn-sm btn-outline-secondary">Order</button></div><button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal" data-whatever="' + obj.name + '.' + obj.pizzeriaID + '">Reviews</button></div></div></div></div>')
            })
        }
    })
    
    $('#searchBtn').on("click", function(event) {
        var album = $('#pizzerias')
        album.empty()
        var searchInput = $('#searchInput').val()
        
        $.ajax({
            method: "POST",
            url: "search.php",
            data: { "searchInput": searchInput },
            success: repopPizzerias
        });
        
        function repopPizzerias (response) {
            var pizzerias = JSON.parse(response)
            pizzerias.forEach(function(obj) {
                album.append('<div class="col-md-4"><div class="card mb-4 shadow-sm"><img src="../images/' + obj.imgName + '" class="img-fluid border-bottom" alt="Responsive image"><div class="card-body"><p class="card-text">' + obj.name + '<br> Address: ' + obj.address + '<br> Phone: ' + obj.phoneNum + '<br>' + '</p><div class="d-flex justify-content-between align-items-center"><div class="btn-group"><a href="' + obj.menuLink + '" target="_blank"><button type="button" class="btn btn-sm btn-outline-secondary">View Menu</button></a><button type="button" class="btn btn-sm btn-outline-secondary">Order</button></div><button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal" data-whatever="' + obj.name + '.' + obj.pizzeriaID + '">Reviews</button></div></div></div></div>')
            })
        }
    })

});