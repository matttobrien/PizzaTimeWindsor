$(document).ready(function() {
    $(document).on("click", "#deleteAcc", function(){
        var button = $(this)
        var userID = button.data('whatever')
        console.log(userID)
        
        $.ajax({
            method: "POST",
            url: "editaccounts.php",
            data: { "function": "deleteAcc", "userID": userID },
            success: allgood
        });
        
        function allgood (response) {
            location.reload();
        }
    })
        
    $(document).on("click", "#disableAcc", function(){
        var button = $(this)
        var userID = button.data('whatever')
        
        $.ajax({
            method: "POST",
            url: "editaccounts.php",
            data: { "function": "disable", "userID": userID },
            success: allgood
        });
        
        function allgood (response) {
            button.addClass('btn-outline-success').removeClass('btn-outline-danger')
            button.prop('id', 'enableAcc');
            button.html('Enable')
        }
    })
    
    $(document).on("click", "#enableAcc", function(){
        var button = $(this)
        var userID = button.data('whatever')
        
        $.ajax({
            method: "POST",
            url: "editaccounts.php",
            data: { "function": "enable", "userID": userID },
            success: allgood
        });
        
        function allgood (response) {
            button.addClass('btn-outline-danger').removeClass('btn-outline-success')
            button.prop('id', 'disableAcc');
            button.html('Disable')
        }
    })
    
    $(document).on("click", "#makeAdmin", function(){
        var button = $(this)
        var userID = button.data('whatever')
        
        $.ajax({
            method: "POST",
            url: "editaccounts.php",
            data: { "function": "makeAdmin", "userID": userID },
            success: allgood
        });
        
        function allgood (response) {
            button.addClass('btn-outline-success').removeClass('btn-outline-danger')
            button.prop('id', 'noMoreAdmin');
            button.html('Admin')
        }
    })
    
    $(document).on("click", "#noMoreAdmin", function(){
        var button = $(this)
        var userID = button.data('whatever')
        
        $.ajax({
            method: "POST",
            url: "editaccounts.php",
            data: { "function": "noMoreAdmin", "userID": userID },
            success: allgood
        });
        
        function allgood (response) {
            button.addClass('btn-outline-danger').removeClass('btn-outline-success')
            button.prop('id', 'makeAdmin');
            button.html('User')
        }
    })
})