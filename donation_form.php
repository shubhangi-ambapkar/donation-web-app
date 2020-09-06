<?php
include "config/connection.php";
$MERCHANT_KEY = "your payumoney merchant key";
$SALT = "your payumoney salt";
// Merchant Key and Salt as provided by Payu.

$PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
//$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
	
  }
}
									
$strFileName = 'error_log.txt';
$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Donation form</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
	
<script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
</head>

<body onload="submitPayuForm()">
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Donation Form</h2>
                    <form id="payuForm" name="payuForm" class="quick-contact-form"  action="<?php echo $action; ?>" method="POST">
                        
                                <div class="input-group">
                                    <label class="label">Full Name</label>
                                    <input class="input--style-4" id="firstname" name="firstname" class="form-control" type="text" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" required="">
                                </div>
                          
                       
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" id="email" name="email" class="form-control" type="text" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" required="">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Phone Number</label>
                                    <input class="input--style-4" id="phone" name="phone" class="form-control" type="text"value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" required="" >
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="label">Payment Mode</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select id="mode"  name="mode" onchange='changeAction(this.value)'>
                                    <option disabled="disabled" selected="selected">Choose option</option>
                                    <option value="<?php echo "PaytmKit/pgRedirect.php"; ?>">Paytm</option>
                                    <option value="<?php echo $action; ?>">PayuMoney</option>
                                    
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                         <div class="input-group">
								<input id="ORDER_ID"  name="ORDER_ID" value="<?php echo "OD".rand(10000,500000);?>"  type="hidden"/>
								<input  id="TXN_AMOUNT" name="TXN_AMOUNT" value="" type="hidden" />
								 <input id="CHANNEL_ID" name="CHANNEL_ID" value="WEB" type="hidden"/>
								 <input id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" value="Retail" type="hidden" />
								 <input id="CUST_ID" name="CUST_ID" value="CUST001" type="hidden"/>
								
								 
								 <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
								<input type="hidden" name="hash" value="<?php echo $hash ?>"/>
								<input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
								  
                            <div class="rs-select2 js-select-simple select--no-search">
                                <div class="input-group">
                                    <label class="label">Amount</label>
                                    <input class="input--style-4" type="number" name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>">
                                </div>
                                
                            </div>
							   <input name="productinfo" type="hidden" value="<?php echo $posted['productinfo']= $package_title; ?>"/>
      <input name="surl" type="hidden" value="<?php echo $posted['surl']="https://dodonation.000webhostapp.com/payu/success.php";?>" size="64" />
       <input name="furl" type="hidden" value="<?php echo  $posted['furl']="https://dodonation.000webhostapp.com/payu/failure.php"; ?>" size="64" />
        
          <input type="hidden" name="service_provider" value="payu_paisa" size="64" />

                        </div>
                        <div class="p-t-15">
						
          <?php 
		 // echo $hash;
		  
		  if(!$hash) { ?>
		  
<br> 
                            <button class="btn btn--radius-2 btn--blue" name="submit" id="submit" type="submit">Donate</button>
							 <?php } ?>
                        </div>
								 <script>
			 
								function changeAction(val){
								document.getElementById('payuForm').setAttribute('action', val);
								}
								</script>
                    </form>
                    
          
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
