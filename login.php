<?php session_start();?>


<head>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    
</head>

<?php
require('php-includes/connect.php');
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$query = mysqli_query($con,"select * from user where email='$email' and password='$password'");
$row = mysqli_fetch_assoc($query);
if(mysqli_num_rows($query)>0){
	$_SESSION['userid'] = $email;
	$_SESSION['id'] = session_id();
	$_SESSION['login_type'] = "user";
	$_SESSION['f_name'] = $row['f_name'];

	echo '<script type="text/javascript">';
  		echo 'setTimeout(function () { swal("Login Success!","Redirecting to Dashboard.","success");';
  		echo '}, 1000);
  		</script>';

    echo '<script>window.setTimeout(function(){

        window.location.assign("home.php");

    }, 5000)</script>';




	
}
else{
  	echo '<script type="text/javascript">';
  		echo 'setTimeout(function () { swal("Invalid user ID and password!","Enter valid credentials.","warning");';
  		echo '}, 1000);
  		</script>';

    echo '<script>window.setTimeout(function(){

        window.location.assign("index.php");

    }, 5000)</script>';

}



?>