<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh" lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>匯能國際</title>
</head>
<body style="margin-left:100px;">
<h3>提交订单信息</h3>
<form action="queryRequest.jsp" method="post" target="_blank">
	接口版本：<input type="text" name="service_version" value="1.0"/><br/><br/>
	
	商户号:   <input type="text" name="partner" value="test@test.com"/><br/><br/>
	网关订单号 :<input type="text" name="transaction_id" value=""/><br/><br/>
	商户订单号:    <input type="text" name="out_trade_no" value="120120815155001"/><br/><br/>
	
	<input type="submit" name="" value="提交"/>

</form>

</body>
</html>
