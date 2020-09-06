<?php

session_start();
//$name=$_SESSION["fname"];
$email = $_GET['email'];
$pay_mode="Paytm";
?>


<!doctype html>
<html lang="en">
<head>
<?php 


//$did = $_GET['did'];

/*
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
*/
//require "../config/connection.php";
require "../config/connection.php";
require 'PHPMailer/PHPMailerAutoload.php';
require 'smtp_config.php';
//require "config/config.php";

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");


$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<b>Transaction status is success</b>" . "<br/>";
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	}
	else {
		echo "<b>Transaction status is failure</b>" . "<br/>";
		
		?>
		
			<script>
setTimeout(function(){window.location.replace('<?php  echo '../failure';?>.php');}, 4000);
					
</script>
		<?php
		//	exec ('localhost:8080/project/project/fail.php)') ;
	}


	
	

}
else {
	echo "<b>Checksum mismatched.</b>";
	//exec ('localhost:8080/project/project/fail.php)') ;
	?>
	<script>
setTimeout(function(){window.location.replace('<?php  echo '../index';?>.php');}, 4000);
					
</script>
	<?php
	//Process transaction as suspicious.
}
?>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Success</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    @media screen and (max-width:500px) {
      body { font-size: .6em; } 
    }
  </style>
</head>
<?php
if($isValidChecksum == "TRUE")
{
?>

<body style="text-align: center;">

  <h3 style="font-family: Georgia, serif; color: #4a4a4a; margin-top: 4em; line-height: 1.5;">
   

    <?php
    
   // $name=$_SESSION["fname"];
    ?>


   Your Donation has reached to needy ones. We appriciate your helping nature.
	<?php

			 $amount = $_GET['amt'];
	
			$subject="Donation Details";
			$body=
			'
				<html xmlns="http://www.w3.org/1999/xhtml">
				 <head>
				  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				  <title>Invoice details</title>
				  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
				 </head>
				  
				  <body style="margin: 0; padding: 0; background-color:#eaeced " bgcolor="#eaeced">

				   <h2 align="center"><i><u>Donation Recipt</u></i></h2><br><br>
				   <h3>Date : &nbsp;'.date('d/m/Y').'<br><br>
					
					Donation Amount : &nbsp;'.$amount.'<br><br>
					Payment Type : &nbsp;'.$pay_mode.'<br><br>
					Dear &nbsp;Doner, <br>
					You have successfully donated '.$amount.' Rs. to our charity. We appriciate your helpful nature.
					Thank you so much!<br><br>
					
					Sincerly,<br>
					
					Team Dodonation <br><br>
					
					
					
					</h3>
					
				  </body>
				  
				</html>
			';
			
		
		    $email = $_GET['email'];
		 //	$email=$row2['email'];
			$mail = new PHPMailer;
	     	$mail->isSMTP();  
	     
	    	//if(!$res2) errlog(mysqli_error($conn),$sql); 
			//$mail->SMTPDebug = 2;					// For deugging only,Enable verbose debug output
			$mail->Host =HOST;  	// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;             // Enable SMTP authentication
			$mail->Username = EMAIL;            // SMTP username
			$mail->Password = PASS;             // SMTP password
			$mail->SMTPSecure = 'tls';          // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                  // TCP port to connect to
			$mail->setFrom(EMAIL, 'DoDonation');
			$mail->addAddress($email);   // Add a recipient
			$mail->addReplyTo(EMAIL);
			$mail->isHTML(true);                // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $body;
			
            
			if(!$mail->send())
			{
			    echo 'mail could not be sent.';
			    echo '<br>Mailer Error: ' . $mail->ErrorInfo;
			} 
			else 
			{
			    echo '<br>mail sent to <b>'.$email.'</b><br>';
			}
		
		
	
	?>
	
	
	
	 </h3>
  <img src="http://www.goldenturtlefarm.com/resources/images/payment%20successful.png">
  <h2 style="  font-family: Verdana, sans-serif; color: #7d7d7d; font-weight: 300;">
    You will receive Donation recipet details in mail shortly.
  </h2>
  </body>
 

<script>

<?php
}
if($isValidChecksum == "TRUE")
{ ?>
setTimeout(function(){window.location.replace('<?php  echo 'https://dodonation.000webhostapp.com';?>');}, 10000);

<?php 
}
session_unset();

// destroy the session
session_destroy();
	?>				
</script>
</html>