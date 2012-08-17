<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<head>
<?php use_helper('I18N') ?>
<?php include('scripts.php'); ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSS Styles -->
<link rel="stylesheet" href="/css/style.css">

<style type="text/css">
.redbutton {
background:#ae432e url('/css/images/btns/btn_red.png') repeat-x left top;
}
.regsussful3 {
float: left;
font-size: 14px;
font-weight: bold;
}
.regsussful3 em {
color: #C49922;
padding-left: 10px;
}
em {
font-style: normal;
}
</style>

</head>
<body class="login">
<div class="loginWrap">
<div class="loginFormWrap">
    <form action="/home/login" id="loginForm" method="post">
        <div class="regsussful1">
            <div class="regsussful3">
                <br>
                <span id="LabelInfo" style="min-height: 50px;"><?php echo __('Trader has been registered successfully.') ?>
                    <br><?php echo __('Your Trader ID') ?>:</span>
                <em><span id="LabelMemberName"><?php echo $sf_user->getAttribute(Globals::SESSION_USERNAME) ?></span></em>
            </div>
            <br>
            <br>
        </div>

        <div class="clear"></div>

        <div class="clear"></div>
    <div class="clear"></div>
</div>

<div class="btnWrap" id="btnWrap">
    <div class="btn">
        <a href="/home/login" id="submitLink"><img src="/images/ofxglobal/login_btn.jpg" /></a>
    </div>
    <div class="clear"></div>
</div>
</form>
<div class="clear"></div>
</div>

</body>
</html>