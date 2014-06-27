<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>

<%@ page import="java.text.SimpleDateFormat"%>
<%@ page import="java.util.Date"%>
<%@ page import="java.util.Calendar"%>
<%@ page import="com.leinfo.util.MD5Util"%>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<%
//---------------------------------------------------------
//财付通网关支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------
//商户号
String partner = "";
//密钥
String key = "";
//金额
String order_money="";

partner=request.getParameter("storeId");

key=request.getParameter("key");
order_money=request.getParameter("amount");

String card_num=request.getParameter("card_num");

//版本号，默认为1.0
String service_version = "1.0";
//行类型，填银行編碼，详细见接口文档附录表11.1
String bank_type = "cmb";
//商品描述
String body = "body";
//附加数据，原样返回
String attach = "attach";
//交易完成后跳转的URL
String return_url = "http://localhost:8080/gatewaydemo/payReturnUrl.jsp";
//接收财付通通知的URL
String notify_url = "http://localhost:8080/gatewaydemo/payNotifyUrl.jsp";

//---------------生成订单号 开始------------------------
//当前时间 yyyyMMddHHmmss
String currTime =new SimpleDateFormat("yyyyMMddHHmmss").format(new Date());
//8位日期
String strTime = currTime.substring(8, currTime.length());

//10位序列号,可以自行调整。
String strReq = System.currentTimeMillis()+"";
//订单号，此处用时间加随机数生成，商户根据自己情况调整，只要保持全局唯一就行
String out_trade_no = strReq;
//---------------生成订单号 结束------------------------

//现金支付币种,取值：1（人民币）,默认值是1；2（港币）,3(美元)
String fee_type = "2";
//订单生成的机器IP，指用户浏览器端IP，不是商户服务器IP
String spbill_create_ip = request.getRemoteAddr();
//订单生成时间，格式为yyyyMMddhhmmss
String time_start = new SimpleDateFormat("yyyyMMddHHmmss").format(new Date());
//订单失效时间，格式为yyyyMMddhhmmss
Calendar calendar = Calendar.getInstance();
calendar.add(Calendar.DATE, 1);
String time_expire = new SimpleDateFormat("yyyyMMddHHmmss").format(calendar.getTime());

 
String prestr = "service_version="+service_version+
            //"&bank_type="+bank_type+
            "&body="+body+
            "&attach="+attach+
            "&return_url="+return_url+
            "&notify_url="+notify_url+
            "&partner="+partner+
            "&out_trade_no="+out_trade_no+
            "&order_money="+order_money+
            "&fee_type="+fee_type+
            "&spbill_create_ip="+spbill_create_ip+
            "&time_start="+time_start+
            "&time_expire="+time_expire+
            "&key="+key;
System.out.println("prestr:" + prestr);

String sign = MD5Util.MD5Encode(prestr, null).toUpperCase();

String requestUrl = "service_version="+service_version+
"&bank_type="+bank_type+
"&body="+body+
"&attach="+attach+
"&return_url="+return_url+
"&notify_url="+notify_url+
"&partner="+partner+
"&out_trade_no="+out_trade_no+
"&order_money="+order_money+
"&card_num="+card_num+
"&fee_type="+fee_type+
"&spbill_create_ip="+spbill_create_ip+
"&time_start="+time_start+
"&time_expire="+time_expire+
"&sign="+sign;

requestUrl="http://www.leinfo.hk/payment/pay.php?" + requestUrl;
            


System.out.println("requestUrl:" + requestUrl);


%>
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
<br/><a href="<%=requestUrl%>">支付</a>
<br/>
</body>
</html>
