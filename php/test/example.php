<?php 

define('__ROOT__', dirname(dirname(__FILE__))); 
include(__ROOT__.'\htdocs\FirstApi\Firstapi\HTTP_Connection.php');

$apiKey = $_POST["apiKey"];
$apiSecret = $_POST["apiSecret"];
$gatewayID = $_POST["gatewayID"];
$gatewayPass = $_POST["gatewayPassword"];
$abp = new HTTP_Connection();
$abp->_setAttr($apiKey,$apiSecret,$gatewayID,$gatewayPass);
echo $abp->_getAttr();
$url = 'https://demo26-test.apigee.net/firstapi-cat/transactions';
$array = $abp->_makePayment($url, $abp->_generateCreditCardTestPayload());
?>

<html> 
<head> 
<title>First Api</title> 
</head> 
<body> 
<form method="post"  action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
<!-- //   -->
Apigee ApiKey:<input type="text" name="apiKey"><br /> 
Apigee ApiSecret:<input type="text" name="apiSecret"><br />
SOA Gateway ID:<input type="text" name="gatewayID"><br /> 
SOA Password:<input type="text" name="gatewayPassword"><br /> 
<input type="submit" value="submit" name="submit1">
</form>

<textarea><?php print_r($array) ?></textarea>
</body>
</html>