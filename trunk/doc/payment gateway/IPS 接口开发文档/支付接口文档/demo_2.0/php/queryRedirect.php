<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>匯能國際</title>
</head>
<body style="margin-left:100px;">
<h3>提交订单信息</h3>

<?php 

	$parameters = array(
					'service_version'     =>   $_POST['service_version'],
					'partner'             =>   $_POST['partner'],
					'transaction_id'      =>   $_POST['transaction_id'],
					'out_trade_no'        =>   $_POST['out_trade_no'],
					'key'                 =>   '3ec05ef3979fb5c9a87e8166ec2d0d2b', 
				);                   //将需加密参数封成数组

	foreach ($parameters as $key => $value){
			if(isset($value))
				$preStr .= $key.'='.$value.'&';    //将数组组成 'key1=value1&key2=value2'字符串
	}
	
	$preStr = substr($preStr, 0, strlen($returnStr)-1); //删掉最一个字符，这里指多余的'&'
	//die($preStr);
	
	$sign = strtoupper(md5($preStr));  //将字符串转成md5摘要，并再将摘要转成全部大写形式
?>
页面提交中！
<form action="http://www.leinfo.hk/payment/query.php" method="post" id="payment">
<!--<form action="http://10.200.20.99/index.php/default/gateway/pay/orderquery" method="post" id="payment">
	--><?php foreach ($parameters as  $key=>$value):?>
	<input type="hidden" name="<?php echo $key?>" value="<?php echo $value?>"/><br/>
	<?php endforeach;?>
	<input type="hidden" name="sign" value="<?php echo $sign?>"/>

</form>
	<script>
		document.getElementById("payment").submit();
	</script>
</body>
</html>