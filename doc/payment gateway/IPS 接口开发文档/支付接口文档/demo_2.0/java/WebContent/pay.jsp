<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<title>汇能国际程序演示</title>
</head>
<script>
    <%
       //if(key!=null&&key.length()>0)
       //  out.println("window.location='"+requestUrl+"'");
    %>
</script>
<body>

<br/>
<form name="pay" action="payRequest.jsp" method="post" target="_blank" >
<table>
<tr><td>商家号</td><td><input type="text" id ='storeId' value="test@test.com" name="storeId" size=60 maxlength=20></td> </tr>
<tr><td>密钥</td><td><input type="text"  id ='key'  value="3ec05ef3979fb5c9a87e8166ec2d0d2b" name="key" size=60 maxlength=60>  </td> </tr>
<tr><td>交易金额($)</td><td><input type="text" id ='amount' value="1" name="amount" size=60 maxlength=20>分</td> </tr>
<tr><td>银行卡号</td><td><input type="text" id ='card_num' value="" name="card_num" size=60 ></td> </tr>
 <tr><td></td><td><input type='submit' value='提交' /></td></tr>

</table> 
</form>
</body>
</html>
