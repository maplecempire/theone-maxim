<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>
<%@ page import="com.leinfo.util.MD5Util"%>
<%@ page import="com.leinfo.util.LfUtil"%>
<%

String key = "3ec05ef3979fb5c9a87e8166ec2d0d2b";
String service_version = request.getParameter("service_version");
String partner = request.getParameter("partner");
String transaction_id = request.getParameter("transaction_id");
String out_trade_no = request.getParameter("out_trade_no");
StringBuffer sb = new StringBuffer();
if(service_version!=null && service_version.trim().length()>0){
	sb.append("service_version="+service_version);
}
if(partner!=null && partner.trim().length()>0){
	sb.append("&partner="+partner);
}
if(transaction_id!=null && transaction_id.trim().length()>0){
	sb.append("&transaction_id="+transaction_id);
}
if(out_trade_no!=null && out_trade_no.trim().length()>0){
	sb.append("&out_trade_no="+out_trade_no);
}
//sb.append("&key="+key);
String prestr=sb.toString() + "&key="+key;
System.out.println("prestr:" + prestr);

String sign = MD5Util.MD5Encode(prestr, null).toUpperCase();

String url="http://www.leinfo.hk/payment/query.php";
String postDate=sb.toString()+ "&sign="+sign;
String result=LfUtil.post(url, postDate);
//out.println(postDate);
out.println(result);

%>
