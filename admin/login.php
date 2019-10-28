<?php
echo "Hello World";
session_start();
require('../php-includes/connect.php');
// $userid = mysqli_real_escape_string($con,$_POST['userid']);
// $password = mysqli_real_escape_string($con,$_POST['password']);

$userid = $_POST['userid'];
$password = $_POST['password'];

echo $userid;
echo $password;

$login_query = "select * from admin where userid='$userid' and password='$password'";
$res_query = mysqli_query($con, $login_query);


echo $login_query;

if(mysqli_num_rows($con)>0){
	$_SESSION['userid'] = $userid;
	$_SESSION['id'] = session_id();
	$_SESSION['login_type'] = "admin";
	
	echo '<script>alert("Login Success.");window.location.assign("home.php");</script>';
	
}
else{
	echo "Something Went Wrong";
	echo '<script>alert("Email id or password is wrong.");

	

	</script>';
}

?>