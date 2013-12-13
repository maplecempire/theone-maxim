<meta http-equiv="Content-Type" content="text/html; charset=GBK" />

<?php

define("SERVER_ADDRESS", "173.201.253.129");
define("SERVER_PORT", "702");

#NOTES:
#leverages stored in mt4 databse as integers. For example leverage=200 means that leverage 1:200

#time - unix timestamp format

#volumes stored in mt4 database as integers. 
#MT4 typical volume format = volume/100. For example volume=70 means 0.7 in MT4 ; volume=120 means 1.2 in MT4

class CMT4DataReciver {
	var $socketPtr;
	var $secretHashValue = "none";
	var $encryptionKey = "none";
	
	function OpenConnection($server, $port) {
		$this->socketPtr = fsockopen($server, $port, $errno, $errstr, 0.4); 		
		if(!$this->socketPtr) {			
			return -1;
		} else {	
			return 0;
		}
	}
	
	function SetSafetyData($secretHashValue, $encryptionKey) {
		$this->secretHashValue = $secretHashValue;
		$this->encryptionKey = $encryptionKey;
	}
	
	function _parse_answer($answerData)
	{
		$result = array();
		$data = explode("&", $answerData);
		foreach($data as $piece)
		{
			$keyval = explode("=", $piece, 2);
			$result[$keyval[0]] = $keyval[1];
		}
		return $result;
	}
	
	function MakeRequest($action, $params = array()) {
		if(!$this->socketPtr) return "error"; 
		
		$request_id = 6099;//rand();
		$request = "action=$action&request_id=$request_id";

		foreach($params as $key => $value) {
			$request .= "&$key=$value";
		}		

		if($this->secretHashValue != "none") {
			$hash = $this->makeHash($action, $request_id);
			$request .= "&hash=$hash";
		}

		$request .= "\0"; // leading zero. It must be added to the end of each request		
		if($this->encryptionKey != "none") {
			$request = $this->cryptography($request);			
		}
		
		if($request == "") return "error";
		$this->sendRequest($request);

		return $this->_parse_answer($this->readAnswer());
	}

	function CloseConnection() {
		fclose($this->socketPtr);
	}

	function sendRequest($request) {
		fputs($this->socketPtr, $request);
	}

	function readAnswer() {
		$size = fgets($this->socketPtr, 64);	
			
		$answer = "";			
		$readed = 0;

		while($readed < $size) {
			$part = fread($this->socketPtr, $size - $readed);	
			$readed += strlen($part);
			$answer .= $part;
		}
		if($this->encryptionKey != "none") {
			$answer = $this->cryptography($answer, $encryptionKey);
		}
		return $answer;
	}
		
	function makeHash($action, $request_id) {
		return md5( $request_id . $action . $this->secretHashValue);	
	}

	function cryptography($data) {
		$keyLen = strlen($this->encryptionKey);
		$keyIndex = 0;
		for($i = 0; $i < strlen($data); $i++) {
			$data[$i] = $data[$i] ^ $this->encryptionKey[$keyIndex];
			$keyIndex++;
			if($keyIndex == $keyLen) $keyIndex = 0;
		}
		return $data;
	}

}

$encryptionKey = "asfas1";
$secretHash = "fsdvgfygfsddsag";

$mt4request = new CMT4DataReciver;
//$mt4request->SetSafetyData($secretHash, $encryptionKey); // you can turn on encryption and hash by uncommenting this line. (you need to turn it on on the server too)
$mt4request->OpenConnection(SERVER_ADDRESS, SERVER_PORT);



?>

<title>Create a new account</title>

<?php
if(isset($_REQUEST["create"]))
{
	/*$params['array'] 				= array();
	$params['group'] 				= @$_REQUEST['group'];
	$params['agent'] 				= @$_REQUEST['agent'];
	$params['login'] 				= 0;
	$params['country'] 				= @$_REQUEST['country'];
	$params['state'] 				= @$_REQUEST['state'];
	$params['city'] 				= @$_REQUEST['city'];
	$params['address'] 				= @$_REQUEST['address'];
	$params['name'] 				= @$_REQUEST['name'];
	$params['email'] 				= @$_REQUEST['email'];
	$params['password'] 			= @$_REQUEST['password'];
	$params['password_investor'] 	= @$_REQUEST['password_investor'];
	$params['password_phone'] 		= @$_REQUEST['password_phone'];
	$params['leverage'] 			= @$_REQUEST['leverage'];
	$params['zipcode'] 				= @$_REQUEST['zipcode'];
	$params['phone'] 				= @$_REQUEST['phone'];
	$params['id'] 					= '';
	$params['comment'] 				= @$_REQUEST['comment'];*/
	
	$params['login'] = "2088511615";
//    $params['value'] = 100; // above zero for deposits, below zero for withdraws
//    $params['comment'] = "test balance operation";
//    $answerData = $mt4request->MakeRequest("changebalance", $params);
//    array(4) { ["result"]=> string(1) "1" ["login"]=> string(10) "2088511615" ["newbalance"]=> string(7) "1300.00" ["order"]=> string(6) "392461" }

//    $answerData = $mt4request->MakeRequest("getaccountinfo", $params);
    //array(20) { ["result"]=> string(1) "1" ["login"]=> string(10) "2088511615" ["name"]=> string(10) "jason wong" ["email"]=> string(17) "r9jason@gmail.com" ["group"]=> string(6) "KLTEST" ["leverage"]=> string(3) "500" ["regdate"]=> string(10) "1386932016" ["country"]=> string(0) "" ["state"]=> string(0) "" ["adress"]=> string(0) "" ["city"]=> string(0) "" ["zip"]=> string(0) "" ["enable"]=> string(1) "1" ["tradingblocked"]=> string(1) "0" ["balance"]=> string(7) "1200.00" ["comment"]=> string(0) "" ["enableChangePassword"]=> string(1) "1" ["free_margin"]=> string(7) "1200.00" ["opened_orders"]=> string(2) "no" ["agent"]=> string(1) "0" }

//    $answerData = $mt4request->MakeRequest("getaccountbalance", $params);
//    array(3) { ["result"]=> string(1) "1" ["login"]=> string(10) "2088511615" ["balance"]=> string(7) "1300.00" }

    //$answerData = $mt4request->MakeRequest("getaccounts");
    //array(2) { ["result"]=> string(1) "1" ["size"]=> string(148) "144 2088511614;test;;KLTEST;500;1386930969;;;;;;1;0;1000.00;;1;0 2088511615;jason wong;r9jason@gmail.com;KLTEST;500;1386932016;;;;;;1;0;1200.00;;1;0" }
    var_dump($answerData);
}
?>

<form method="POST" action="http://localhost:8087/mt4Api/getBalance<?php //echo htmlentities($_SERVER['PHP_SELF']);?>">
<table>
<tr>
  <td><strong>login</strong> (only enter 0, do not enter other value)</td>
  <td>:</td>
  <td><input type="text" value="0" name="login" id="login"></td>
</tr>
<tr>
  <td><strong>leverage</strong> (recommended 500)</td>
  <td>:</td>
  <td><input type="text" value="500" name="leverage" id="leverage"></td>
</tr>
<tr>
  <td><strong>name</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="name" id="name"></td>
</tr>
<tr>
  <td><strong>group</strong> (only use 'KLTEST' for testing)</td>
  <td>:</td>
  <td><input type="text" value="KLTEST" name="group" id="group"></td>
</tr>
<tr>
  <td><strong>balance</strong> (the deposit $ amount for client, positive value as deposit. negative as withdrawal)</td>
  <td>:</td>
  <td><input type="text" value="1000" name="balance" id="balance"></td>
</tr>
<tr>
  <td><strong>email</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="email" id="email"></td>
</tr>
<tr>
  <td><strong>national id</strong></td>
  <td>:</td>
  <td><input type="text" value="12345678" name="id" id="id"></td>
</tr>
<tr>
  <td><strong>address</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="address" id="address"></td>
</tr>
<tr>
  <td><strong>city</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="city" id="city"></td>
</tr>
<tr>
  <td><strong>state</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="state" id="state"></td>
</tr>
<tr>
  <td><strong>zipcode</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="zipcode" id="zipcode"></td>
</tr>
<tr>
  <td><strong>country</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="country" id="country"></td>
</tr>
<tr>
  <td><strong>phone</strong></td>
  <td>:</td>
  <td><input type="text" value="" name="phone" id="phone"></td>
</tr>
<tr>
  <td><p><strong>password</strong></p>
    <p>Password must be rather complex, 5 to 15 characters long, and it must contain at least two of three character types: lowercase, uppercase, or digits.</p></td>
  <td>:</td>
  <td><input type="text" value="1234qwer" name="password" id="password"></td>
</tr>
<tr>
  <td><p><strong>Investor Password</strong> (MUST BE Different from password)</p>
    <p>Password must be rather complex, 5 to 15 characters long, and it must contain at least two of three character types: lowercase, uppercase, or digits.</p></td>
  <td>:</td>
  <td><input type="text" value="qwer1234" name="password_investor" id="password_investor"></td>
</tr>
<tr>
  <td><strong>comment</strong> (any comment for your own reference)</td>
  <td>:</td>
  <td><input type="text" value="" name="comment" id="comment"></td>
</tr>
</table>
<p>
	<input type="submit" name="create" value="Create" /> 

</form>

<?php

$mt4request->CloseConnection();

?>