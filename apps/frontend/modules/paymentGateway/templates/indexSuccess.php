<form action='https://www.pa-sys.com/pg/payment.php' method="post">
    <input name="merchantId" type="hidden" value="10000204"/>
    <input name="successUrl" type="hidden" value="http://localhost:8087/paymentGateway?successcode=0"/>
    <input name="failUrl" type="hidden" value="http://localhost:8087/paymentGateway?successcode=1"/>
    <input name="orderRef" type="hidden" value="maxim_19874582"/>
    <input name="amount" type="hidden" value="123"/>
    <input name="currCode" type="hidden" value="156"/>
    <input name="lang" type="hidden" value="En"/>
    <input name="gatewayId" type="hidden" value="23"/>
    <input name="customerEmail" type="hidden" value="r9jason@gmail.com"/>
    <input name="customerName" type="hidden" value="Jason Wong"/>
    <input name="customerTel" type="hidden" value="0123456789"/>
    <input name="customerProduct" type="hidden" value="Maxim"/>
    <input name="remark" type="hidden" value="Maxim Remark"/>
    <input type="submit" value="Submit"/>
</form>