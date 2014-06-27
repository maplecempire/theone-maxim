<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>
<%@ page import="com.leinfo.util.MD5Util"%>
      
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<%
//---------------------------------------------------------
//汇能国际支付应答（处理回调）示例，商户按照此文档进行开发即可
//---------------------------------------------------------
//密钥
String key = "3ec05ef3979fb5c9a87e8166ec2d0d2b";



	String sign_type = request.getParameter("sign_type");
	
	String service_version = request.getParameter("service_version");

	String trade_state = request.getParameter("trade_state");

	//String pay_info = request.getParameter("pay_info");
	
	String partner = request.getParameter("partner");
	
	String order_money = request.getParameter("order_money");
	
	String fee_type = request.getParameter("fee_type");
	
	String transaction_id = request.getParameter("transaction_id");
	
	String out_trade_no = request.getParameter("out_trade_no");
	
	String attach = request.getParameter("attach");
	
	String time_end = request.getParameter("time_end");
	
	String sign = request.getParameter("sign");
	
	String prestr = "sign_type="+sign_type+
			"&service_version="+service_version+
            //"&bank_type="+bank_type+
            "&trade_state="+trade_state+
            //"&pay_info="+pay_info+
            "&partner="+partner+
            "&order_money="+order_money+
            "&fee_type="+fee_type+
            "&transaction_id="+transaction_id+
            "&out_trade_no="+out_trade_no+
            "&attach="+attach+
            "&time_end="+time_end+
            "&key="+key;
System.out.println("prestr:" + prestr);

String lfsign = MD5Util.MD5Encode(prestr, null).toUpperCase();
	
if(sign.equals(lfsign)){	
	if( "0".equals(trade_state) ) {
		//------------------------------
		//处理业务开始
		//------------------------------ 
		
		//注意交易单不要重复处理
		//注意判断返回金额
		
		//------------------------------
		//处理业务完毕
		//------------------------------
	        out.println("支付成功");	
	} else {
		//当做不成功处理
		out.println("支付失败");
	}
} else {
	out.println("验签失败");
}
	

%>
