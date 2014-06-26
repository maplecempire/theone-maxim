<html>
<head>
    <title>redirecting......</title>
    <meta http-equiv="content-Type" content="text/html; charset=utf8"/>
</head>
<body>
<form action='https://www.pa-sys.com/pg/payment.php' method="post" id="frm1">
    <input name="merchantId" type="hidden" value="<?php echo $merid; ?>"/>
    <input name="successUrl" type="hidden" value="<?php echo $returnurl; ?>"/>
    <input name="failUrl" type="hidden" value="<?php echo $errorurl; ?>"/>
    <input name="orderRef" type="hidden" value="<?php echo $orderid; ?>"/>
    <input name="amount" type="hidden" value="<?php echo $amount; ?>"/>
    <input name="currCode" type="hidden" value="<?php echo $curtype; ?>"/>
    <input name="lang" type="hidden" value="<?php echo $lang; ?>"/>
    <input name="gatewayId" type="hidden" value="<?php echo $paytype; ?>"/>
    <input name="customerEmail" type="hidden" value="<?php echo $email; ?>"/>
    <input name="customerName" type="hidden" value="<?php echo $fullName; ?>"/>
    <input name="customerTel" type="hidden" value="<?php echo $contactNo; ?>"/>
    <input name="customerProduct" type="hidden" value="Maxim Trader"/>
    <input name="remark" type="hidden" value="<?php echo $remark; ?>"/>
    <!--<input type="submit" value="Submit"/>-->
</form>
<script language="javascript">
    document.getElementById("frm1").submit();
</script>
</body>
</html>