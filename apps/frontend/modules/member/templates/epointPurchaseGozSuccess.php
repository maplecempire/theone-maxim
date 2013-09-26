<?php
header("Content-type:text/html; charset=gb2312"); 

//提交地址
/*
if(Globals::PAYMENT_GATEWAY_ENVIRONMENT == 'DEV') {
	$form_url = 'http://www.goz-llq.com/do/Trade/iPay/goTrans.aspx'; //测试
} else {
	$form_url = 'http://www.goz-llq.com/do/Trade/iPay/goTrans.aspx'; //正式
}

$form_url = 'http://www.goz-llq.com/do/Trade/iPay/goTrans.aspx'; //正式

//商户号
$Mer_code = $merCode;

//商户证书：登陆http://merchant.ips.com.cn/商户后台下载的商户证书内容
$Mer_key = $merKey;

//商户订单编号
$Billno = $billNo;

//订单金额(保留2位小数)
$Amount = number_format($amount, 2, '.', '');

//订单日期
$Date = $paymentDate;

//币种
$Currency_Type = $currencyType;

//支付卡种
$Gateway_Type = $gatewayType;

//语言
$Lang = $lang;

//支付结果成功返回的商户URL
$Merchanturl = Globals::PAYMENT_GATEWAY_MERCHANT_URL;

//支付结果失败返回的商户URL
$FailUrl = Globals::PAYMENT_GATEWAY_FAIL_URL;

//支付结果错误返回的商户URL
$ErrorUrl = "";

//商户数据包
$Attach = $attach;

//显示金额
$DispAmount = $dispAmount;

//订单支付接口加密方式
$OrderEncodeType = $orderEncodeType;

//交易返回接口加密方式 
$RetEncodeType = $retEncodeType;

//返回方式
$Rettype = $rettype;

//Server to Server 返回页面URL
$ServerUrl = Globals::PAYMENT_GATEWAY_MERCHANT_URL;
//OrderEncodeType设置为5，且在订单支付接口的Signmd5字段中存放MD5摘要认证信息。
//交易提交接口MD5摘要认证的明文按照指定参数名与值的内容连接起来，将证书同时拼接到参数字符串尾部进行md5加密之后再转换成小写，明文信息如下：
//billno+【订单编号】+ currencytype +【币种】+ amount +【订单金额】+ date +【订单日期】+ orderencodetype +【订单支付接口加密方式】+【商户内部证书字符串】
//例:(billno000001000123currencytypeRMBamount13.45date20031205orderencodetype5GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ)
//订单支付接口的Md5摘要，原文=订单号+金额+日期+支付币种+商户证书 
$orge = 'billno'.$Billno.'currencytype'.$Currency_Type.'amount'.$Amount.'date'.$Date.'orderencodetype'.$OrderEncodeType.$Mer_key ;
//echo '明文:'.$orge ;
//$SignMD5 = md5('billno'.$Billno.'currencytype'.$Currency_Type.'amount'.$Amount.'date'.$Date.'orderencodetype'.$OrderEncodeType.$Mer_key);
$SignMD5 = md5($orge) ;
//echo '密文:'.$SignMD5 ;
//sleep(20);
*/
?>
<html>
  <head>
    <title>redirecting......</title>
    <meta http-equiv="content-Type" content="text/html; charset=utf8" />
  </head>
  <body>
  <?php
  $test = "1.0";
  $Mer_key = "100009";
  $Billno = date("Ymdhis");
  $Amount = "0.10";
  $Date = date("Ymd");
  $Currency_Type = "RMB";
  $Gateway_Type = "01";
  $Lang = "GB";
  $Merchanturl = "http://localhost:8087/member/gozSuccessRedirect";
  $ErrorUrl = "http://localhost:8087/member/gozErrorRedirect";
  $remark = "testremarkaa";
  $enctype = "1";
  $channelid = "CMB";

  $md5Key = "88496625849445331821427993934397583101845496550535688096140279054296113998693043340961948795056633136331268949200793818235742794";
  //$orge = "ver=$test&merid=$Mer_key&orderid=$Billno&amount=$Amount&orderdate=$Date&curtype=$Currency_Type&paytype=$Gateway_Type&lang=$Lang&returnurl=$Merchanturl&errorurl=$ErrorUrl&remark1=$remark&enctype=$enctype&notifytype=2&channelid=$channelid";
  $orge = 'ver='.$test.'&merid='.$Mer_key.'&orderid='.$Billno.'&amount='.$Amount.'&orderdate='.$Date.'&curtype='.$Currency_Type.'&paytype='.$Gateway_Type.'&lang='.$Lang.'&returnurl='.$Merchanturl.'&errorurl='.$ErrorUrl.'&remark1='.$remark.'&enctype='.$enctype.'&notifytype=2&urltype=1&s2surl='.$ErrorUrl.'&goodsname=goods&channelid='.$channelid;
	echo  $orge;
  $SignMD5 = md5($orge.$md5Key) ;
  ?>
    <form action="http://www.goz-llq.com/do/Trade/iPay/goTrans.aspx" method="post" id="frm1">
      <!--<input type="hidden" name="ver" value="<?php echo $test ?>">
      <input type="hidden" name="merid" value="<?php echo $Mer_key ?>">
      <input type="hidden" name="orderid" value="<?php echo $Billno ?>">
      <input type="hidden" name="amount" value="<?php echo $Amount ?>" >
      <input type="hidden" name="orderdate" value="<?php echo $Date ?>">
      <input type="hidden" name="curtype" value="<?php echo $Currency_Type ?>">
      <input type="hidden" name="paytype" value="<?php echo $Gateway_Type ?>">
      <input type="hidden" name="lang" value="<?php echo $Lang ?>">
      <input type="hidden" name="returnurl" value="<?php echo $Merchanturl ?>">
      <input type="hidden" name="errorurl" value="<?php echo $ErrorUrl ?>">
      <input type="hidden" name="remark1" value="<?php echo $remark ?>">
      <input type="hidden" name="urltype" value="">
      <input type="hidden" name="s2surl" value="">
      <input type="hidden" name="enctype" value="<?php echo $enctype ?>">
      <input type="hidden" name="channelid" value="<?php echo $channelid ?>">
      <input type="hidden" name="goodsname" value="">
      <input type="hidden" name="sign" value="<?php echo $SignMD5;?>">-->
	<input type="hidden" name="ver" value=<?php echo $test ?> />
	<input type="hidden" name="merid" value=<?php echo $Mer_key ?> />
	<input type="hidden" name="orderid" value=<?php echo $Billno ?> /><!-- md5随机-->
	<input type="hidden" name="amount" value=<?php echo $Amount ?> />
	<input type="hidden" name="orderdate" value=<?php echo $Date ?> /><!--订单日期yyymmdd -->
	<input type="hidden" name="curtype" value=<?php echo $Currency_Type ?> /><!--币种 默认BMB -->
	<input type="hidden" name="paytype" value=<?php echo $Gateway_Type ?> />
	<input type="hidden" name="lang" value=<?php echo $Lang ?> />
	<input type="hidden" name="returnurl" value=<?php echo $Merchanturl ?> /><!--返回地址  1次-->
	<input type="hidden" name="errorurl" value=<?php echo $ErrorUrl ?> /><!--错误返回地址 -->
	<input type="hidden" name="remark1" value=<?php echo $remark ?> />
	<input type="hidden" name="enctype" value=<?php echo $enctype ?> />
	<input type="hidden" name="notifytype" value=2 />
	<input type="hidden" name="urltype" value=1 />
	<input type="hidden" name="s2surl" value=<?php echo $ErrorUrl ?> /><!-- 后台返回地址 4/5次 -->
	<input type="hidden" name="goodsname" value=goods />
	<input type="hidden" name="channelid" value=<?php echo $channelid ?> />
	<input type="hidden" name="sign" value=<?php echo $SignMD5;?> />
	<input type="submit" />
    </form>
    <script language="javascript">
//      document.getElementById("frm1").submit();
    </script>
  </body>
</html>