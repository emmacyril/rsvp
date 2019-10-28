<!--?php
	$db_host = "127.0.0.1";
	$db_user = "root";
	$db_pass = "password";
	$db_name = "rsvp";
	$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if(mysqli_connect_error()){
		echo 'connect to database failed';
	}
?-->





<?php
	$db_host = "localhost";
	$db_user = "u502039025_pvsr";
	$db_pass = "4*CAKd1NY4JI";
	$db_name = "u502039025_rsvp";
	$con =  mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if(mysqli_connect_error()){
		echo 'connect to database failed';
	}
?>