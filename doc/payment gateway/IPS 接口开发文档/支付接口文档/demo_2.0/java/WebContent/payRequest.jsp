<%@ page language="java" contentType="text/html; charset=GBK" pageEncoding="GBK"%>

<%@ page import="java.text.SimpleDateFormat"%>
<%@ page import="java.util.Date"%>
<%@ page import="java.util.Calendar"%>
<%@ page import="com.leinfo.util.MD5Util"%>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<%
//---------------------------------------------------------
//�Ƹ�ͨ����֧������ʾ�����̻����մ��ĵ����п�������
//---------------------------------------------------------
//�̻���
String partner = "";
//��Կ
String key = "";
//���
String order_money="";

partner=request.getParameter("storeId");

key=request.getParameter("key");
order_money=request.getParameter("amount");

String card_num=request.getParameter("card_num");

//�汾�ţ�Ĭ��Ϊ1.0
String service_version = "1.0";
//�����ͣ������о��a����ϸ���ӿ��ĵ���¼��11.1
String bank_type = "cmb";
//��Ʒ����
String body = "body";
//�������ݣ�ԭ������
String attach = "attach";
//������ɺ���ת��URL
String return_url = "http://localhost:8080/gatewaydemo/payReturnUrl.jsp";
//���ղƸ�֪ͨͨ��URL
String notify_url = "http://localhost:8080/gatewaydemo/payNotifyUrl.jsp";

//---------------���ɶ����� ��ʼ------------------------
//��ǰʱ�� yyyyMMddHHmmss
String currTime =new SimpleDateFormat("yyyyMMddHHmmss").format(new Date());
//8λ����
String strTime = currTime.substring(8, currTime.length());

//10λ���к�,�������е�����
String strReq = System.currentTimeMillis()+"";
//�����ţ��˴���ʱ�����������ɣ��̻������Լ����������ֻҪ����ȫ��Ψһ����
String out_trade_no = strReq;
//---------------���ɶ����� ����------------------------

//�ֽ�֧������,ȡֵ��1������ң�,Ĭ��ֵ��1��2���۱ң�,3(��Ԫ)
String fee_type = "2";
//�������ɵĻ���IP��ָ�û��������IP�������̻�������IP
String spbill_create_ip = request.getRemoteAddr();
//��������ʱ�䣬��ʽΪyyyyMMddhhmmss
String time_start = new SimpleDateFormat("yyyyMMddHHmmss").format(new Date());
//����ʧЧʱ�䣬��ʽΪyyyyMMddhhmmss
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
<title>���ܹ��ʳ�����ʾ</title>
</head>
<script>
    <%
       //if(key!=null&&key.length()>0)
       //  out.println("window.location='"+requestUrl+"'");
    %>
</script>
<body>
<br/><a href="<%=requestUrl%>">֧��</a>
<br/>
</body>
</html>
