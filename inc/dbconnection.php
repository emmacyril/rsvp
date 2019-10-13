<?php
error_reporting(E_ALL);
// encrypt code
function encryptIt_webs($q) {
    $cryptKey = '@#preztishwebscrat';
    $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
    return( $qEncoded );
}
//decrypt_code
function decryptIt_webs($q) {
    $cryptKey = '@#preztishwebscrat';
    $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
    return( $qDecoded );
}
date_default_timezone_set("Asia/Calcutta");
$host="localhost";
$user="u502039025_pvsr";
$pass="4*CAKd1NY4JI";
$dbname="u502039025_rsvp";
$link=@mysqli_connect($host,$user,$pass,$dbname);
    if(mysqli_connect_errno())
    {
        echo"Failed to Connect!!";
        exit();
    }
    else
    {
         //echo "Connected Successfully";
    }
?>



<!-- <?php
// error_reporting(E_ALL);
// // encrypt code
// function encryptIt_webs($q) {
//     $cryptKey = '@#preztishwebscrat';
//     $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
//     return( $qEncoded );
// }
// //decrypt_code
// function decryptIt_webs($q) {
//     $cryptKey = '@#preztishwebscrat';
//     $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
//     return( $qDecoded );
// }
// date_default_timezone_set("Asia/Calcutta");
// $host="localhost";
// $user="katallys_usr";
// $pass = "TU%Zm5-urHGu";
// $dbname="katallys_main";
// $link=@mysqli_connect($host,$user,$pass,$dbname);
//     if(mysqli_connect_errno())
//     {
//         echo"<br>Failed to Connect!!";
//         exit();
//     }
?> -->