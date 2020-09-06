<?php
define("DB_SERVER", "your host");
define("DB_USER", "db user");
define("DB_PASSWORD", "password");
define("DB_DATABASE", "db name");

$conn= mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE); //mintlime



 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

} 


 

 function errlog($error,$sql){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";     
    $url.= $_SERVER['HTTP_HOST'];    
    $url.= $_SERVER['REQUEST_URI'];   $error_log = fopen("error_log.txt", "a");
    $timestamp = date("Y-m-d h:i");
    $txt = $timestamp." ERROR : [URL:".$url."] ".$error." [SQL:".$sql."]\r\n";
    fwrite($error_log, $txt);
	fclose($error_log);
	echo '<script> location.replace("error.html"); </script>';
}
?>
