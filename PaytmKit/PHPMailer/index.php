<?php

session_start();
$id = $_SESSION['idr'];
require 'PHPMailerAutoload.php';
echo($_POST['mail1']);
echo($_POST['msg1']); 

exit();
$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.hostinger.in';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'mails@mintlime.in';                 // SMTP username
$mail->Password = 'Mail12#$';                           // SMTP password
$mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('mails@mintlime.in', 'MintLime');
if(isset($_POST['mail'])){
$mail->addAddress($_POST['mail'], "USER");
}

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'For Testing perpose.';
if(isset($_POST['email'])){
$mail->Body    = "Thank you for choosing Mintlime";
}
if(isset($_POST['mail'])){
$mail->Body    = "You Have Been Selected by ".$_POST['name'].
"Contact No.:".$_POST['phn'].
"Form:".$_POST['city']
;

}
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
   // echo 'Mailer Error: ' . $mail->ErrorInfo;
    ?>

<script type="text/javascript">
	alert("Mail Could not be Sent");
	alert("plz Try again Latter");
	window.location ="contact_form.php";
</script>
    <?php
} else {
    echo 'Message has been sent';
?>
<script type="text/javascript">
	//var id = "<?php echo $id;?>";
// 	window.location ="contact_form.php?count="+num;
//alert("sent");
		window.location ="marketplace_models.php";
</script>
<?php
}
// die("end");
// echo $_SESSION['form_name'];
// echo $_SESSION['form_email'];
// echo $_SESSION['form_message'];

?>