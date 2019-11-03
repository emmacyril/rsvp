<?php
include('php-includes/check-login.php');
include('php-includes/connect.php');
$userid = $_SESSION['userid'];



function redirect($url)
{
    if (!headers_sent())
    {    
        header('Location: '.$url);
        exit;
        }
    else
        {  
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
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

    <title>Dashboard | RSVP</title>

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
                        <?php if($_SESSION['f_name']){
                            echo '<h3 class="page-header">'.$_SESSION['f_name'].'\'s Dashboard</h3>';
                        }
                        else{
                            echo '<h3 class="page-header">User Home</h3>';
                        }
                         ?>
                        
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                	 <?php
						$query = mysqli_query($con,"select * from income_received where userid='$userid'");
						$result = mysqli_fetch_array($query);
					?>



                	<div class="col-lg-4">
                    	<div class="panel panel-info">
                        	<div class="panel-heading">
                            	<h4 class="panel-title">Today's Income</h4>
                            </div>
                            <div class="panel-body">
                            	<?php 
								echo $result['day_bal']
								?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                    	<div class="panel panel-success">
                        	<div class="panel-heading">
                            	<h4 class="panel-title">Current Income</h4>
                            </div>
                            <div class="panel-body">
                            	<?php 
								echo $result['current_bal'];
								?>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                    	<div class="panel panel-info">
                        	<div class="panel-heading">
                            	<h4 class="panel-title">Total Income</h4>
                            </div>
                            <div class="panel-body">
                            	<?php 
								echo $result['total_bal']
								?>
                            </div>
                        </div>
                    </div>

                    <?php

                    $query_aadhar = "SELECT * FROM user WHERE email='$userid'";
                    $res_aadhar = mysqli_query($con, $query_aadhar);
                    $row_aadhar = mysqli_fetch_assoc($res_aadhar);

                    if($row_aadhar['doc_status']==0)
                    {
                        ?>

                        <div class="col-lg-4">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title">KYC Details</h4>
                            </div>

                            <?php

                            if(isset($_POST['doc_save_button'])){
                                $doc_type =  $_POST['doc_type'];
                                $doc_no =  $_POST['doc_no'];
                            if (isset($_FILES['doc_file'])) {

    $errors = array();
    $file_name = $_FILES['doc_file']['name'];
    $file_size = $_FILES['doc_file']['size'];
    $file_tmp = $_FILES['doc_file']['tmp_name'];
    $file_type = $_FILES['doc_file']['type'];
    $tmp = explode('.', $_FILES['doc_file']['name']);
    $file_ext = end($tmp);
    $file_ext = strtolower($file_ext);
    // echo $file_ext;

    $extensions = array("jpeg", "jpg", "png", "pdf");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }
    
    if (empty($errors) == true) {
        $query2 = "UPDATE user SET doc_status=1, doc_type='$doc_type', doc_no='$doc_no', doc_name='$file_name' WHERE email='$userid'";
        $res2 = mysqli_query($con, $query2);
        echo mysqli_error($con);
        move_uploaded_file($file_tmp, "kyc/" . $file_name);
//        echo "Success";
        //redirect("index.php");
    } else {
        print_r($errors);
    }
}
redirect("Refresh:0");
}



                            ?>



                            <div class="panel-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <label for="document_no"> Document No.</label>
                                    <input id="document_no" name="doc_no" type="text"><br><br>
                                    <label> Document Type </label>
                                    <input type="radio" name="doc_type" value="aadhar">&nbsp;AADHAR &nbsp;
                                    <input type="radio" name="doc_type" value="PAN">&nbsp;PAN &nbsp;
                                    <input type="radio" name="doc_type" value="Driving License">&nbsp;Driving License&nbsp;
                                    <!-- <input type="radio" name="doc_type" value="Aadhar">&nbsp;AADHAR &nbsp; -->
                                    <input type="radio" name="doc_type" value="Voter UD">&nbsp;Voter ID &nbsp;<br>
                                    <br>
                                    <input required="required" type="file" multiple="multiple" name="doc_file"> 
                                    <br>
                                    <input type="submit" value="SAVE" name="doc_save_button">
                                </form>
                            </div>
                        </div>
                    </div>
                    

                    <?php 
                    }

                    else if($row_aadhar['doc_status']==1 && $row_aadhar['verified']==0){
                        ?>

                            <div class="col-lg-4">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h4 class="panel-title">Verification Pending</h4>
                            </div>
                            <div class="panel-body">
                                <?php 
                                echo "KYC Verification Under Progress.";
                                ?>
                            </div>
                        </div>
                    </div>

                        <?php
                    }
                    else{

                        ?>


                        <div class="col-lg-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h4 class="panel-title">Verified</h4>
                            </div>
                            <div class="panel-body">
                                <?php 
                                echo "Your KYC has been verified.";
                                ?>
                            </div>
                        </div>
                    </div>



                        <?php
                        
                    }

                     ?>
                     


                    <!-- <div class="col-lg-3">
                    	<div class="panel panel-warning">
                        	<div class="panel-heading">
                            	<h4 class="panel-title">Available Pin</h4>
                            </div>
                            <div class="panel-body">
                            	<!?php 
								echo  mysqli_num_rows(mysqli_query($con,"select * from pin_list where userid='$userid' and status='open'"));
								?>
                            </div>
                        </div>
                    </div> -->
                </div>
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

</body>

</html>
