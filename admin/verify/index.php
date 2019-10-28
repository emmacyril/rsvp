<?php
include('../php-includes/check-login.php');
require('../../php-includes/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RSVP admin  - Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style>


                        table { 
    width: 750px; 
    border-collapse: collapse; 
    margin:50px auto;
    }

/* Zebra striping */
tr:nth-of-type(odd) { 
    background: #eee; 
    }

th { 
    background: #3498db; 
    color: white; 
    font-weight: bold; 
    }

td, th { 
    padding: 10px; 
    border: 1px solid #ccc; 
    text-align: left; 
    font-size: 18px;
    }


    </style>

 

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include('../php-includes/menu.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Unverified Users</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">


                	<div class="col-lg-12">
                    	
                            	<table>
                                    <thead>
                                    <tr>
                                        <th>
                                            First Name
                                        </th>
                                        <th>
                                            Last Name
                                        </th>
                                        <th>
                                            DOB
                                        </th>
                                        <th>
                                            PAN
                                        </th>
                                        <th>
                                            Document
                                        </th>
                                         <th>
                                            Document Number
                                        </th>
                                        <th>
                                            File
                                        </th>
                                        <th>
                                            Verify
                                        </th>
                                    </tr>
                                </thead>
                                <?php

                                $query_verify = "SELECT * FROM user WHERE verified=0";
                                $res_verify = mysqli_query($con, $query_verify);
                                while($row_verify = mysqli_fetch_assoc($res_verify)) {
                                 ?>
                                    <tr>
                                        <td>
                                            <?php echo $row_verify['f_name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_verify['l_name'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_verify['dob'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_verify['pan'] ?>
                                        </td>
                                        <td>
                                            <?php echo $row_verify['doc_type'] ?>
                                        </td>
                                         <td>
                                            <?php echo $row_verify['doc_no'] ?>
                                        </td>
                                        <td>
                                            <a target="_blank" href="http://rsvpsalenmarketing.com/kyc/<?php echo $row_verify['doc_name'] ?>"> <?php echo $row_verify['doc_name'] ?> </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </table>

                    </div>
                    
                   
                    
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
