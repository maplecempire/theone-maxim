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
	$params['array'] 				= array();
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
	$params['comment'] 				= @$_REQUEST['comment'];
	
	$answer = $mt4request->MakeRequest("createaccount", $params);
	
	if($answer['result']!=1)
	{
			print "<p style='background-color:#FFEEEE'>An error occured: <b>".$answer['reason']."</b>.</p>";
	}
	else
	{	
			print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> has just been created.</p>";
			
			$params = array();
			$params['login'] 	= $answer['login'];
			$params['value'] 	= @$_REQUEST['balance']; // above zero for deposits, below zero for withdraws
			$params['comment'] 	= "test balance operation";
			$answer = $mt4request->MakeRequest("changebalance", $params);
			
			if($answer['result']!=1)
			{
				print "<p style='background-color:#FFEEEE'>Balance change error: <b>".$answer['reason']."</b>.</p>";
			}
			else
			{	
				print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> credited to balance: ".$_REQUEST['balance'].".</p>";
			}
	}
}
?>

<form method="POST" action="http://localhost:8087/mt4Api<?php //echo htmlentities($_SERVER['PHP_SELF']);?>">
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