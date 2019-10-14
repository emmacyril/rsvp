<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Simple Login Form</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style type="text/css">
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>



<?php

function random_strings($length_of_string) { 
      
    // md5 the timestamps and returns substring 
    // of specified length 
    return substr(md5(time()), 0, $length_of_string); 
}
$rand_password = random_strings(10);

// echo $rand_password;


 ?>


</head>
<body>
<div class="login-form" style="margin-bottom: 200px">
    <form action="" method="post">
        <h2 class="text-center">Register</h2>

        <div class="form-group">
            <input onchange="check_pan(this)" type="text" class="form-control" placeholder="PAN " name="pan" required="required">
        </div>

        <center> <p id="pan_status"></p> </center>
        <p style="color: gray; font-size: 12px; margin-left: 5px;">Name must be as per PAN CARD</p>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="First Name" name="f_name" required="required">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Last Name" name="l_name" required="required">
        </div>

        <div class="form-group">
            <input type="date" class="form-control" placeholder="Phone No." name="phoneno" required="required">
        </div>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="email ID" name="phoneno" required="required">
        </div>

        <div class="form-group">
            <input type="number" class="form-control" placeholder="Aadhar ID" name="aadhar" required="required">
        </div>


        <div class="form-group">
            <p style="color: gray; margin-left: 5px"> PLACEMENT </p>
            <div style="margin-left: 10px" id="placement">
                <input checked type="radio" name="radio" value="Radio 1"> LEFT
                <input type="radio" name="radio" value="Radio 2"> RIGHT
        </div>

        <br><br>



        <div class="form-group">
            <button type="submit" name="login_pressed" class="btn btn-primary btn-block">Sign Up</button>
        </div> 
    </form>
</div>
<script>
    function check_pan(a){
        var panVal = a.value;
        var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;

        if(regpan.test(panVal)){
            console.log("Correct PAN");
            // document.getElementById("pan_status").value="PAN Verified";
            document.getElementById("pan_status").innerHTML = "<span style='font-size:20px;'>&#10003;</span> PAN VALID";
            document.getElementById("pan_status").style.color="GREEN";
        }
        else {
            console.log("Incorrect PAN");
            document.getElementById("pan_status").innerHTML="<span style='font-size:20px;'>&#10006;</span> PAN INVALID";
            document.getElementById("pan_status").style.color="RED";
        }
    }
</script>
</body>
</html>                                		                            