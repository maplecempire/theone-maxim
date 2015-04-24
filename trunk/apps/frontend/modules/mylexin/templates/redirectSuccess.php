<?php
header("Content-type:text/html; charset=gb2312"); 
?>
<html>
  <head>
    <title>redirecting......</title>
    <meta http-equiv="content-Type" content="text/html; charset=utf8" />
  </head>
  <body>
  <?php
  ?>
    <form action="http://www.mylexin.com/loginmx" method="post" id="frm1">
	<input type="hidden" name="transactionToken" value="<?php echo $transactionToken ?>" />
<!--	<input type="submit" />-->
    </form>
    <script language="javascript">
        document.getElementById("frm1").submit();
    </script>
  </body>
</html>