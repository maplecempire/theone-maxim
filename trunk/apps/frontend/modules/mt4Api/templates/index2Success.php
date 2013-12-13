<?php

define(SERVER_ADDRESS, "173.201.253.129");
define(SERVER_PORT, "702");

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
	$params['group'] = isset($_REQUEST['group'])?$_REQUEST['group']:'demo';
	$params['agent'] = isset($_REQUEST['agent'])?$_REQUEST['agent']:'0';
	$params['login'] = 0;
	$params['country'] = 'Russia';
	$params['state'] = 'Lenoblast';
	$params['city'] = 'Saint-Petersburg';
	$params['address'] = '18 linia VO';
	$params['name'] = isset($_REQUEST['name'])?$_REQUEST['name']:'John Smith';
	$params['email'] = isset($_REQUEST['email'])?$_REQUEST['email']:'test@tools4brokers.com';
	$params['password'] = 'tools4brokers';
	$params['password_investor'] = 'tools4brokers';
	$params['password_phone'] = '';
	$params['leverage'] = 100;
	$params['zipcode'] = '02217';
	$params['phone'] = '12345678';
	$params['id'] = '';
	$params['comment'] = 'NO COMMENT';

	$answer = $mt4request->MakeRequest("createaccount", $params);

	if($answer['result']!=1)
	{
		print "<p style='background-color:#FFEEEE'>An error occured: <b>".$answer['reason']."</b>.</p>";
	}
	else
	{
		print "<p style='background-color:#EEFFEE'>Account No. <b>".$answer["login"]."</b> has just been created.</p>";
	}
}
?>

<form method="POST" action="<?php echo $PHP_SELF;?>">
<table>
<tr>
	<td>Name</td><td><input type="text" name="name" value="John Smith" /></td>
</tr>
<tr>
	<td>E-mail</td><td><input type="text" name="email" value="test@tools4brokers.com" /></td>
</tr>
<tr>
	<td colspan=2>... etc</td>
</tr>
</table>
<p>
	<input type="submit" name="create" value="Create" /> a new account in a <b>group</b> named <input type="text" name="group" value="testgroup" /> with an <b>agent</b> field set to <input type="text" name="agent" value="100" />.
</p>

</form>

<?php

$mt4request->CloseConnection();

?>



<?php
/*
$params['login'] = "4";
$params['value'] = 100; // above zero for deposits, below zero for withdraws
$params['comment'] = "test balance operation";
$answerData = $mt4request->MakeRequest("changebalance", $params);
*/

/*
$params['login'] = "112";
$answerData = $mt4request->MakeRequest("getaccountinfo", $params);
*/

/*$params['login'] = "30398";
$answerData = $mt4request->MakeRequest("getaccountinfo", $params);*/






/*print($answerData);
print("<br /><br />");*/

/*
$params['login'] = "303453";
$answerData = $mt4request->MakeRequest("getaccountbalance", $params);
print($answerData);
print("<br /><br />");

/*
$params['login'] = "300001";
$answerData = $mt4request->MakeRequest("getaccounts");
print($answerData);
*/
/*
$params['mode'] = 0;
$params['from'] = 1274072400;
$params['to'] = 1274072400 + 3600*24;
$params['filter'] = "login";
$answerData = $mt4request->MakeRequest("getjournal", $params);
print($answerData);
*/

/*
$params['state'] = 'Kiev';
$params['email'] = 'test@test.com';
$params['group'] = 'Mason_test_X';
$params['city'] = 'Kiev';
$params['password_investor'] = 'serg12';
$params['leverage'] = 100;
$params['id'] = '';
$params['address'] = 'my address';
$params['country'] = 'UKRAINE';
$params['passwords'] = 'serg12';
$params['password_phone'] = '';
$params['name'] = 'Gulko Serg2';
$params['zipcode'] = '02217';
$params['phone'] = '12345678';
$params['login'] = 1230;
$params['comment'] = 'this is comments';
$params['agent'] = '';
$answerData = $mt4request->MakeRequest("createaccount", $params);

print($answerData);
print("<br /><br />");
*/
/*
$params['name'] = "OLD5";
$params['base_group'] = "OLD2";
$params['enable'] = 1;
$params['margin_stopout'] = 30;
$params['company'] = "Tools For Brokers";
$answerData = $mt4request->MakeRequest("creategroup", $params);
print($answerData);
print("<br /><br />");

/*
$answerData = $mt4request->MakeRequest("servertime");
print($answerData);
print("<br /><br />");


$params['login'] = "300001";
$answerData = $mt4request->MakeRequest("getaccountbalance", $params);
print($answerData);
print("<br /><br />");


$params['login'] = "300001";
$answerData = $mt4request->MakeRequest("getaccountinfo", $params);
print($answerData);
print("<br /><br />");



$params['login'] = "300001";
$answerData = $mt4request->MakeRequest("accounthavetrades", $params);
print($answerData);
print("<br /><br />");



$params['login'] = "300001";
$params['enable'] = "1";
// here you can add any fields from 'createaccount', except password
$answerData = $mt4request->MakeRequest("modifyaccount", $params);
print($answerData);
print("<br /><br />");


$params['login'] = "300001";
$params['pass'] = "qwerty123";
$params['investor'] = 0;
$answerData = $mt4request->MakeRequest("changepassword", $params);
print($answerData);
print("<br /><br />");


$params['login'] = "300001";
$params['value'] = 100; // above zero for deposits, below zero for withdraws
$params['comment'] = "test balance operation";
$answerData = $mt4request->MakeRequest("changebalance", $params);
print($answerData);
print("<br /><br />");


$params['login'] = "22";
$answerData = $mt4request->MakeRequest("deleteaccount", $params);
print($answerData);
print("<br /><br />");


$params['name'] = "aleks";
$params['login'] = "22"; // 0 if you want to use next valid login number on the server
$params['agent'] = "30";
$params['group'] = "t100_usd";
$params['id'] = "-";
$params['address'] = "street 1";
$params['city'] = "SPB";
$params['state'] = "SPBB";
$params['zipcode'] = "19635";
$params['country'] = "RUSSIA";
$params['phone'] = "9922344";
$params['passwords'] = "qwerty123";
$params['password_phone'] = "test";
$params['password_investor'] = "qwerty1";
$params['comment'] = "true";
$answerData = $mt4request->MakeRequest("createaccount", $params);
print($answerData);
print("<br /><br />");


/* REQUEST WITH CSV DATA

$answerData = $mt4request->MakeRequest("getaccounts");
print($answerData);
print("<br /><br />");


$params['login'] = "300001";
$params['from'] = 1270225426 - 3600 * 24 * 31;
$params['to'] = 1270225426;
$answerData = $mt4request->MakeRequest("getbalancesoperations", $params);
//csv line format:  deal;profit;time;comment
print($answerData);
print("<br /><br />");

$params['login'] = "300001;132057;132034;130209";
$answerData = $mt4request->MakeRequest("getprofitlosebylogins", $params);
print($answerData);
//print("<br /><br />");

$params['login'] = "132060;132057;132034;130209";
$params['from'] = 1270225426 - 3600 * 24 * 31;
$params['to'] = 1270225426;
//csv line format: login;deal;symbol;open_price;close_price;profit;volume
$answerData = $mt4request->MakeRequest("gettradingvolume", $params);
print($answerData);
print("<br /><br />");

$answerData = $mt4request->MakeRequest("getleverageandgroup");
//csv line format: login;group;leverage
print($answerData);
print("<br /><br />");
//*/
//$mt4request->CloseConnection();


// PARSE $answerData
// ...
// END


?>