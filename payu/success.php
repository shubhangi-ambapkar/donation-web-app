<!doctype html>
<html lang="en">
<head>
<?php 

//session_start();
//$did = $_GET['did'];
$email = $_POST['email'];
$name = $_POST['firstname'];
$pay_mode="Payumoney";
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


?>
Transaction Successful
<body style="text-align: center;">

  <h3 style="font-family: Georgia, serif; color: #4a4a4a; margin-top: 4em; line-height: 1.5;">
   




   Your Donation has reached to needy ones. We appriciate your helping nature.
	<?php
	//	echo $oid;
	
							  	
				$query="select * from donar where email='".$email."'";
				$res=mysqli_query($conn,$query);
			
	
	
		
		
		if($res)
		{
			$row=mysqli_fetch_assoc($res);
			$amount = $_POST['amount'];
				$did=$row['did'];
			$name = $_POST['firstname'];
			$payment_mode=$row['mode'];
			$subject="Donation Details";
			$body=
			'
				<html xmlns="http://www.w3.org/1999/xhtml">
				 <head>
				  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				  <title>Invoice details</title>
				  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
				 </head>
				  
				  <body style="margin: 4; padding: 4; background-color:#eaeced " bgcolor="#eaeced">

				   <h2 align="center"><i><u>Donation Recipt</u></i></h2><br><br>
				   <h3>Date : &nbsp;'.date('d/m/Y').'<br><br>
					Donation Amount : &nbsp;'.$amount.' Rs.<br><br>
					Payment Type : &nbsp;'.$pay_mode.'<br><br>
					Dear &nbsp;'.$name.',<br>
					You have successfully donated '.$amount.' Rs. to our charity. We appriciate your helpful nature.
					Thank you so much!<br><br>
					
					Sincerly,<br>
					
					Team Dodonation <br><br>
					
					
					
					</h3>
					
				  </body>
				  
				</html>
			';
			if(isset($did)) $sql="SELECT * FROM donar WHERE did='".$did."'";
			$res2=mysqli_query($conn,$sql) or die('cant get '.$sql);
			if(!$res2) errlog(mysqli_error($conn),$sql);
			$row2=mysqli_fetch_assoc($res2);
		    $email = $_POST['email'];
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
			
		}
	
	?>
	
	
	
	 </h3>
  <img src="http://www.goldenturtlefarm.com/resources/images/payment%20successful.png">
  <h2 style="  font-family: Verdana, sans-serif; color: #7d7d7d; font-weight: 300;">
    You will receive Donation recipet details in mail shortly.
  </h2>
  </body>
 

<script>


setTimeout(function(){window.location.replace('<?php  echo 'https://dodonation.000webhostapp.com';?>');}, 10000);

				
</script>
</html>