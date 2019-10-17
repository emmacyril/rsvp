<?php session_start();?>
<?php
include('php-includes/connect.php');
include('php-includes/check-login.php');
$userid = $_SESSION['userid'];
$capping = 500;
?>
<?php
//User cliced on join
if(isset($_GET['join_user'])){
	$side='';
	// $pin = mysqli_real_escape_string($con,$_GET['pin']);
	$pan = mysqli_real_escape_string($con,$_GET['pan']);
	$f_name = mysqli_real_escape_string($con,$_GET['f_name']);
	$l_name = mysqli_real_escape_string($con,$_GET['l_name']);
	$dob = mysqli_real_escape_string($con,$_GET['dob']);

	echo $pan;
	echo $f_name;
	echo $l_name;
	echo $dob;

	$email = mysqli_real_escape_string($con,$_GET['email']);
	$mobile = mysqli_real_escape_string($con,$_GET['mobile']);
	$under_userid = mysqli_real_escape_string($con,$_GET['under_userid']);
	$side = mysqli_real_escape_string($con,$_GET['side']);
	$digits = 5;
	$password =  rand(pow(10, $digits-1), pow(10, $digits)-1);
	
	$flag = 0;
	
	if($email!='' && $side!=''){
		
			//Pin is ok
			if(email_check($email)){
				//Email is ok
				if(!email_check($under_userid)){
					//Under userid is ok
					if(side_check($under_userid,$side)){
						//Side check
						$flag=1;
					}
					else{
						echo '<script>alert("The side you selected is not available.");</script>';
					}
				}
				else{
					//check under userid
					echo '<script>alert("Invalid Under userid.");</script>';
				}
			}
			else{
				//check email
				echo '<script>alert("This user id already availble.");</script>';
			}
		
		
	}
	else{
		//check all fields are fill
		echo '<script>alert("Please fill all the fields.");</script>';
	}
	
	//Now we are heree
	//It means all the information is correct
	//Now we will save all the information
	if($flag==1){
		
		//Insert into User profile
		$query = mysqli_query($con,"insert into user(`email`,`password`,`mobile`,`pan`,`f_name`,`l_name`,`under_userid`,`side`) values('$email','$password','$mobile','$pan','$f_name','$l_name','$under_userid','$side')");
		
		echo mysqli_error($con);

		//Insert into Tree
		//So that later on we can view tree.
		$query = mysqli_query($con,"insert into tree(`userid`) values('$email')");
		
		//Insert to side
		$query = mysqli_query($con,"update tree set `$side`='$email' where userid='$under_userid'");
		
		//Update pin status to close
		$query = mysqli_query($con,"update pin_list set status='close' where pin='$pin'");
		
		//Inset into Icome
		$query = mysqli_query($con,"insert into income (`userid`) values('$email')");
		echo mysqli_error($con);
		//This is the main part to join a user\
		//If you will do any mistake here. Then the site will not work.
		
		//Update count and Income.
		$temp_under_userid = $under_userid;
		$temp_side_count = $side.'count'; //leftcount or rightcount
		
		$temp_side = $side;
		$total_count=1;
		$i=1;
		while($total_count>0){
			$i;
			$q = mysqli_query($con,"select * from tree where userid='$temp_under_userid'");
			$r = mysqli_fetch_array($q);
			$current_temp_side_count = $r[$temp_side_count]+1;
			$temp_under_userid;
			$temp_side_count;
			mysqli_query($con,"update tree set `$temp_side_count`=$current_temp_side_count where userid='$temp_under_userid'");
			
			//income
			if($temp_under_userid!=""){
				$income_data = income($temp_under_userid);
				//check capping
				//$income_data['day_bal'];
				if($income_data['day_bal']<$capping){
					$tree_data = tree($temp_under_userid);
					
					//check leftplusright
					//$tree_data['leftcount'];
					//$tree_data['rightcount'];
					//$leftplusright;
					
					$temp_left_count = $tree_data['leftcount'];
					$temp_right_count = $tree_data['rightcount'];
					//Both left and right side should at least 1 user
					if($temp_left_count>0 && $temp_right_count>0){
						if($temp_side=='left'){
							$temp_left_count;
							$temp_right_count;
							if($temp_left_count<=$temp_right_count){
								
								$new_day_bal = $income_data['day_bal']+100;
								$new_current_bal = $income_data['current_bal']+100;
								$new_total_bal = $income_data['total_bal']+100;
								
								//update income
								mysqli_query($con,"update income set day_bal='$new_day_bal', current_bal='$new_current_bal', total_bal='$new_total_bal' where userid='$temp_under_userid' limit 1");	
							
							}
						}
						else{
							if($temp_right_count<=$temp_left_count){
						
								$new_day_bal = $income_data['day_bal']+100;
								$new_current_bal = $income_data['current_bal']+100;
								$new_total_bal = $income_data['total_bal']+100;
								$temp_under_userid;
								//update income
								if(mysqli_query($con,"update income set day_bal='$new_day_bal', current_bal='$new_current_bal', total_bal='$new_total_bal' where userid='$temp_under_userid'")){
									
								}
							}
						}
					}//Both left and right side should at least 1 user
					
				}
				//change under_userid
				$next_under_userid = getUnderId($temp_under_userid);
				$temp_side = getUnderIdPlace($temp_under_userid);
				$temp_side_count = $temp_side.'count';
				$temp_under_userid = $next_under_userid;	
				
				$i++;
			}
			
			//Chaeck for the last user
			if($temp_under_userid==""){
				$total_count=0;
			}
			
		}//Loop
		
		
		
		
		echo mysqli_error($con);
		
		echo '<script>alert("Testing success.");</script>';
	}
	
}
?><!--/join user-->
<?php 
//functions
function pin_check($pin){
	// global $con,$userid;
	
	// $query =mysqli_query($con,"select * from pin_list where pin='$pin' and userid='$userid' and status='open'");
	// if(mysqli_num_rows($query)>0){
	// 	return true;
	// }
	// else{
	// 	return false;
	// }
	return true;
}
function email_check($email){
	global $con;
	
	$query =mysqli_query($con,"select * from user where email='$email'");
	if(mysqli_num_rows($query)>0){
		return false;
	}
	else{
		return true;
	}
}
function side_check($email,$side){
	global $con;
	
	$query =mysqli_query($con,"select * from tree where userid='$email'");
	$result = mysqli_fetch_array($query);
	$side_value = $result[$side];
	if($side_value==''){
		return true;
	}
	else{
		return false;
	}
}
function income($userid){
	global $con;
	$data = array();
	$query = mysqli_query($con,"select * from income where userid='$userid'");
	$result = mysqli_fetch_array($query);
	$data['day_bal'] = $result['day_bal'];
	$data['current_bal'] = $result['current_bal'];
	$data['total_bal'] = $result['total_bal'];
	
	return $data;
}
function tree($userid){
	global $con;
	$data = array();
	$query = mysqli_query($con,"select * from tree where userid='$userid'");
	$result = mysqli_fetch_array($query);
	$data['left'] = $result['left'];
	$data['right'] = $result['right'];
	$data['leftcount'] = $result['leftcount'];
	$data['rightcount'] = $result['rightcount'];
	
	return $data;
}
function getUnderId($userid){
	global $con;
	$query = mysqli_query($con,"select * from user where email='$userid'");
	$result = mysqli_fetch_array($query);
	return $result['under_userid'];
}
function getUnderIdPlace($userid){
	global $con;
	$query = mysqli_query($con,"select * from user where email='$userid'");
	$result = mysqli_fetch_array($query);
	return $result['side'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mlml Website  - Join</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

 

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('php-includes/menu.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Join</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                	<div class="col-lg-4">
                    	<form method="get">
                           <!--  <div class="form-group">
                                <label>Pin</label>
                                <input type="text" name="pin" class="form-control" required>
                            </div> -->

                            <div class="form-group">
                                <label>PAN</label>
                                <input onchange="check_pan(this)" type="text" name="pan" class="form-control" required>
                            </div>
                            <!-- PAN STATUS -->
                            <p id="pan_status"></p>

                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control">
                            </div>

                             <div class="form-group">
                                <label>DOB</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>


                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input maxlength="10" minlength="10" type="tel" name="mobile" class="form-control" required>
                            </div>


                            <div class="form-group">
                                <label>Sponsor ID</label>
                                <input type="text" name="under_userid" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Placement</label><br>
                                <input type="radio" name="side" value="left"> Left
                                <input type="radio" name="side" value="right"> Right
                            </div>
                            
                            <div class="form-group">
                        	<input type="submit" name="join_user" class="btn btn-primary" value="Join">
                        </div>
                        </form>
                    </div>
                </div><!--/.row-->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

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
