<?php 

// The location of the PDF file 
// on the server 
$name = $_GET['fl'];
$filename = "https://rsvpsalenmarketing.com/kyc/".$name.; 

// Header content type 
header("Content-type: application/pdf"); 

header("Content-Length: " . filesize($filename)); 

// Send the file to the browser. 
readfile($filename); 
?> 
