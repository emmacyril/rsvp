<?php session_start();?>
<?php
if(isset($_SESSION['id']) && $_SESSION['login_type']=='user'){
}
else{
	echo '<script>alert("Access denied");window.location.assign("index.php");</script>';
}
?>