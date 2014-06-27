<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>tobvip</title>
</head>
<body style="margin-left:100px;">
<h3>提交订单信息</h3>

<?php 

	$parameters = array(
					'service_version'     =>   $_POST['service_version'],
					//'bank_type'         =>   $_POST['bank_type'],
					'body'                =>   $_POST['body'],
					'attach'              =>   $_POST['attach'],
					'return_url'          =>   $_POST['return_url'],
					'notify_url'          =>   $_POST['notify_url'],
					'partner'             =>   $_POST['partner'],
					'out_trade_no'        =>   $_POST['out_trade_no'],
					'order_money'         =>   $_POST['order_money'],
					'fee_type'            =>   $_POST['fee_type'],
					'spbill_create_ip'    =>   $_POST['spbill_create_ip'],
					'time_start'          =>   $_POST['time_start'],
					'time_expire'         =>   $_POST['time_expire'],
					'key'                 =>   '3ec05ef3979fb5c9a87e8166ec2d0d2b', 
				);                   //将需加密参数封成数组
	
	/*function filter($v) {
		if ($v==="" || $v===null)
		{
			return false;
		}
		return true;
	}
	$parameters = array_filter($parameters,"filter");*/  //过滤空值数组
	
	foreach ($parameters as $key => $value){
			if(isset($value))
				$preStr .= $key.'='.$value.'&';    //将数组组成 'key1=value1&key2=value2'字符串
	}
	
	$preStr = substr($preStr, 0, strlen($returnStr)-1); //删掉最一个字符，这里指多余的'&'
	//die($preStr);
	
	$sign = strtoupper(md5($preStr));  //将字符串转成md5摘要，并再将摘要转成全部大写形式
	
	$parameters = array(
					'service_version'     =>   $_POST['service_version'],
					'bank_type'           =>   $_POST['bank_type'],
					'body'                =>   $_POST['body'],
					'attach'              =>   $_POST['attach'],
					'return_url'          =>   $_POST['return_url'],
					'notify_url'          =>   $_POST['notify_url'],
					'partner'             =>   $_POST['partner'],
					'out_trade_no'        =>   $_POST['out_trade_no'],
					'order_money'         =>   $_POST['order_money'],
					'card_num'            =>   $_POST['card_num'],
					'fee_type'            =>   $_POST['fee_type'],
					'spbill_create_ip'    =>   $_POST['spbill_create_ip'],
					'time_start'          =>   $_POST['time_start'],
					'time_expire'         =>   $_POST['time_expire'],
					'sign'                =>   $sign,
				); 
?>
页面提交中！
<form action="http://www.leinfo.hk/payment/pay.php" method="post" id="payment">
<!--<form action="http://10.200.20.99/index.php/default/gateway/pay" method="post" id="payment">
	--><?php foreach ($parameters as  $key=>$value):?>
	<input type="hidden" name="<?php echo $key?>" value="<?php echo $value?>"/><br/>
	<?php endforeach;?>

</form>
	<script>
		document.getElementById("payment").submit();
	</script>
</body>
</html>