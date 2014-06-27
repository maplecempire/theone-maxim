<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="khttp://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>匯能國際</title>
</head>
<body style="margin-left:100px;">
<h3>提交订单信息</h3>
<form action="./redirect.php" method="post" target="_blank">
	接口版本：<input type="text" name="service_version" value="1.0"/><br/><br/>
	银行类型:<select name="bank_type">
				<option value="ccb" selected>建设银行</option>
				<option value="icbc">工商银行</option>
				<option value="abc">农业银行</option>
				<option value="boc">中国银行</option>
				<option value="comm">交通银行</option>
				<option value="cmb">招商银行</option>
				<option value="cmbc">民生银行</option>
				<option value="spdb">浦发银行</option>
				<option value="ecitic">中信银行</option>
				<option value="ceb">光大银行</option>
				<option value="gdb">广发银行</option>
				<option value="post">邮政储蓄</option>
				<option value="sdb">深发展银行</option>
				<option value="hxb">华夏银行</option>
				<option value="cib">兴业银行</option>
				<option value="bea">东亚银行</option>
				
				<option value="bccb">北京银行</option>
				<option value="pab">平安银行</option>
			
			</select><br/><br/>
	<?php date_default_timezone_set("PRC");?>
	商品描述: <input type="text" name="body" value="商品a"/><br/><br/>
	附加数据: <input type="text" name="attach" value="attach"/><br/><br/>
	返回URL:  <input type="text" name="return_url" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>/../return.php"/><br/><br/>
	通知URL:  <input type="text" name="notify_url" value="http://www.tobvip.com/demo/return.php"/><br/><br/>
	商户号:   <input type="text" name="partner" value="test@test.com"/><br/><br/>
	商户订单号:<input type="text" name="out_trade_no" value="<?php echo date('YmdHis');?>"/><br/><br/>
	银行卡号:    <input type="text" name="card_num" value=""/><br/><br/>
	总金额:    <input type="text" name="order_money" value="0.01"/><br/><br/>
	币种:     <select name="fee_type">
					<option value="1" selected>人民币</option>
					<option value="2">港币</option>
					<option value="3">美元</option>
				</select><br/><br/>
	用户IP:   <input type="text" name="spbill_create_ip" value="<?php echo getUserIp();?>"/><br/><br/>
	交易起始时间: <input type="text" name="time_start" value="<?php echo date('YmdHis');?>"/><br/><br/>
	交易结束时间: <input type="text" name="time_expire" value="<?php echo date('YmdHis',time()+3600);?>"/><br/><br/>
	<input type="submit" name="" value="提交"/>

</form>

<?php 

	function getUserIp()
	{
       if (getenv("HTTP_X_FORWARDED_FOR")) 
       { 
          $ip = getenv("HTTP_X_FORWARDED_FOR"); 
       } 
       elseif (getenv("HTTP_CLIENT_IP")) 
       { 
           $ip = getenv("HTTP_CLIENT_IP"); 
       } 
       elseif (getenv("REMOTE_ADDR")) 
       { 
           $ip = getenv("REMOTE_ADDR"); 
        } 
        else 
        { 
            $ip = "127.0.0.1"; 
        } 
        return $ip ; 
	}

?>

</body>
</html>
