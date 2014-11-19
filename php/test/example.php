
<!DOCTYPE HTML> 
<html>
<title>Payeezy&#8482; PHP Test Example </title>
<head>
<style>
.error {color: #FF0000;}
body {
background: #336699 !important;
font-family: "Lucida Grande", Tahoma, Arial, Verdana, sans-serif!important;
font-size: small!important;
margin: 8px 0 16px!important;
text-align: left;
}

.title{
padding: 15px;
text-align: center;
color: white;
clear: left;font-size: 160%;
font-weight: bold;
background-color: #6699CC;
}

label.description {
border: none;
color: #222;
display: block;
font-size: 95%;
font-weight: 700;
line-height: 150%;
padding: 0 0 1px;
}

</style>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="all">
<!-- <script type="text/javascript" src="js/bootstrap.js"></script> -->

</head>
<body> 

<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/Payeezy/Payeezy.php'); 

// Initialise Payeezy
$payeezy = new Payeezy();

//Set Payeezy params
$payeezy::$apiKey = "y6pWAJNyJyjGv66IsVuWnklkKUPFbb0a";
$payeezy::$apiSecret = "86fbae7030253af3cd15faef2a1f4b67353e41fb6799f576b5093ae52901e6f7";
$payeezy::$merchantToken = "fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6";
$payeezy::$baseURL = "https://api-cert.payeezy.com/v1/transactions";

$transaction_id = $transaction_tag = $transaction_type = $amount =  $split_shipment = "";
$card_holder_name = $card_number = $card_type = $card_cvv = $card_expiry = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["transaction_type"])) {
     $transaction_typeErr = "Transaction Type is required";
   } else {
     $transaction_type = test_input($_POST["transaction_type"]);
     // check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$transaction_type)) {
       $transaction_typeErr = "Only letters and white space allowed"; 
     }
   }

  $transaction_id = test_input($_POST["transaction_id"]);
  $transaction_tag = test_input($_POST["transaction_tag"]);
  $card_holder_name = test_input($_POST["card_holder_name"]);
  $card_number = test_input($_POST["card_number"]);
  $card_type = test_input($_POST["card_type"]);
  $card_cvv = test_input($_POST["card_cvv"]);
  $card_expiry = test_input($_POST["card_expiry"]);
  $amount = test_input($_POST["amount"]);
  $split_shipment = test_input($_POST["split_shipment"]);


  switch (strtolower($transaction_type)) {
    case 'authorize':
        $response_JSON = $payeezy->authorize(array(
                                "amount"=> $amount,
                                "card_number" => $card_number, 
                                "card_type" => $card_type, 
                                "card_holder_name" => $card_holder_name, 
                                "card_cvv" => $card_cvv, 
                                "card_expiry" => $card_expiry,
                                "merchant_ref" => "Test Transaction",
                                "currency_code" => "USD",
                            ));
      break;

    case 'purchase':
        $response_JSON = $payeezy->purchase(array(
                                "amount"=> $amount,
                                "card_number" => $card_number, 
                                "card_type" => $card_type, 
                                "card_holder_name" => $card_holder_name, 
                                "card_cvv" => $card_cvv, 
                                "card_expiry" => $card_expiry,
                                "merchant_ref" => "Test Transaction",
                                "currency_code" => "USD",
                            ));
      break;

    case 'capture':
        $response_JSON = $payeezy->capture(array(
                                "amount"=> $amount,
                                "transaction_tag" => $transaction_tag, 
                                "transaction_id" => $transaction_id, 
                                "merchant_ref" => "Test Transaction",
                                "currency_code" => "USD",
                            ));
      break;

    case 'void':
        $response_JSON = $payeezy->void(array(
                                "amount"=> $amount,
                                "transaction_tag" => $transaction_tag, 
                                "transaction_id" => $transaction_id, 
                                "merchant_ref" => "Test Transaction",
                                "currency_code" => "USD",
                            ));
      break;

    case 'refund':
        $response_JSON = $payeezy->refund(array(
                                "amount"=> $amount,
                                "transaction_tag" => $transaction_tag, 
                                "transaction_id" => $transaction_id, 
                                "merchant_ref" => "Test Transaction",
                                "currency_code" => "USD",
                            ));
      break;

    case 'split-shipment':
        $response_JSON = $payeezy->split_shipment(array(
                                "amount"=> $amount,
                                "transaction_tag" => $transaction_tag, 
                                "transaction_id" => $transaction_id, 
                                "merchant_ref" => "Test Transaction",
                                "currency_code" => "USD",
                                "split_shipment" => $split_shipment,
                            ));
      break;
    
    default:
      $transaction_typeErr = "Transaction Type Error. Please check and try again";
      break;
  }

}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return strval($data);
}
?>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6" style="background:white;margin-top: 3%;">
<div class="form_description">
        <h2 class="title">Payeezy Example</h2><hr>
        <p>Here is the example for Payeezy - PHP Client.<br>I Transaction ID &amp; Transaction Tag are required for Transaction Types: Capture, Void, Refund &amp; Split Shipment.<br>II Charge Card Details section is to be filled for Transaction Types: Authorize &amp; Purchase
        </p>
  <p><span class="error">* required field.</span></p>
</div>

<hr>
<h5 style="margin-left: 2%;">Payeezy Transaction</h5><br>
<form style="margin-left: 2%;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

  <label class="decription">Transaction ID</label> <br>
  <input type="text" name="transaction_id" value="<?php echo $transaction_id;?>" style="margin-top: -1%;">
  <br><br>


  <label class="decription">Transaction Tag</label> <br>
  <input type="text" name="transaction_tag" value="<?php echo $transaction_tag;?>" style="margin-top: -1%;">
  <br><br>


  <label class="decription">Transaction Type</label>
  <span class="error">* <?php echo $transaction_typeErr;?></span> <br>
  <input type="radio" name="transaction_type" <?php if (isset($transaction_type) && $transaction_type=="authorize") echo "checked";?>  value="Authorize">  Authorize
  <br><input type="radio" name="transaction_type" <?php if (isset($transaction_type) && $transaction_type=="purchase") echo "checked";?>  value="Purchase">  Purchase
  <br><input type="radio" name="transaction_type" <?php if (isset($transaction_type) && $transaction_type=="capture") echo "checked";?>  value="Capture">  Capture
  <br><input type="radio" name="transaction_type" <?php if (isset($transaction_type) && $transaction_type=="void") echo "checked";?>  value="Void">  Void
  <br><input type="radio" name="transaction_type" <?php if (isset($transaction_type) && $transaction_type=="refund") echo "checked";?>  value="Refund">  Refund
  <br><input type="radio" name="transaction_type" <?php if (isset($transaction_type) && $transaction_type=="split") echo "checked";?>  value="Split-Shipment">  Split-Shipment
  <br><br>


  <label class="decription">Split Shipment No.</label> <br>
  <input type="text" name="split_shipment" value="<?php echo $split_shipment;?>" style="margin-top: -1%;">
  <br><br>


  <label class="decription">Amount</label> <br>
  <input type="text" name="amount" value="<?php echo $amount;?>" style="margin-top: -1%;">
  <br><br>


  <hr>
  <h5 style="margin-left: 2%;">Charge Card Details</h5><br>


  <label class="decription">Card holder's Name</label> <br>
  <input type="text" name="card_holder_name" value="<?php echo $card_holder_name;?>" style="margin-top: -1%;">
  <br><br>


  <label class="decription">Card Number</label>
  <span class="error">   <?php echo $card_numberErr;?></span> <br>
  <input type="text" name="card_number" value="<?php echo $card_number;?>" style="margin-top: -1%;">
  <br><br>


  <label class="decription">Card Type</label><br>
  <input type="radio" name="card_type" <?php if (isset($card_type) && $card_type=="visa") echo "checked";?>  value="visa">  Visa
  <br><input type="radio" name="card_type" <?php if (isset($card_type) && $card_type=="mastercard") echo "checked";?>  value="mastercard">  Master Card
  <br><input type="radio" name="card_type" <?php if (isset($card_type) && $card_type=="american_express") echo "checked";?>  value="american_express">  American Express
  <br><br>

  <label class="decription">CVV</label> <br>
  <input type="text" name="card_cvv" value="<?php echo $card_cvv;?>" style="margin-top: -1%;">
  <br><br>


  <label class="decription">Card Expiration (MMYY)</label> <br>
  <input type="text" name="card_expiry" value="<?php echo $card_expiry;?>" style="margin-top: -1%;">
  <br><br>

   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>

<br><br>

<div>
  <h2 class="title">Response</h2><br>
  <dl>
      <dt>Type:</dt>
      <dd><?php echo $transaction_type; ?><br></dd>
      <dt>Result:</dt>
      <dd><pre><?php echo $response_JSON; ?></pre></dd>
  </dl>
</div>

</div>
  <div class="col-md-3"></div>
</div>
</body>
</html>