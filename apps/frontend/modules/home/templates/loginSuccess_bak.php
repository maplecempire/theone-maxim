<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">
    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php use_helper('I18N') ?>
    <?php include('scripts.php'); ?>

    <link rel='stylesheet' id='nivocss-css'  href='/css/maxim/nivo-slider.css' type='text/css' media='all' />
    <link rel='stylesheet' id='styler-farbtastic-css'  href='/css/maxim/styler-farbtastic.css' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-paginate-css'  href='/css/maxim/wp-paginate.css' type='text/css' media='screen' />

    <link rel="stylesheet" href="/css/style.css">

    <script type='text/javascript' src='/css/maxim/comment-reply.js'></script>
    <script type='text/javascript' src='/css/maxim/preloader.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.nivo.slider.js'></script>
    <script type='text/javascript' src='/css/maxim/bottomfix.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.quicksand.js'></script>
    <script type='text/javascript' src='/css/maxim/farbtastic.js'></script>

    <meta http-equiv="Content-Language" content="en-US">
    <style type="text/css" media="screen">
    html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {
        /*background: none repeat scroll 0 0 transparent;*/
        /*border: 0 none;*/
        /*font-size: 100%;*/
        /*margin: 0;*/
        /*outline: 0 none;*/
        /*padding: 0;*/
    }

    #content p {
        clear: none;
        margin-bottom: 0px !important ;
    }
    .qtrans_flag span { display:none }
    .qtrans_flag { height:12px; width:18px; display:block }
    .qtrans_flag_and_text { padding-left:20px }
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

	<script type="text/javascript" charset="utf-8">
    $(function() {
        $("#submitLink").click(function(event) {
            $("#loginForm").submit();
        });

        $("#username, #userpassword").keydown(function(e){
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) { //Enter keycode
                $("#submitLink").trigger("click");
            }
        });
        $("#captchaimage").bind('click', function() {
            $.post('/captcha/newSession');
            $("#captchaimage").load('/captcha/imageRequest');
            return false;
        });
        $("#loginForm").validate({
            rules: {
                "captcha" : {
                    required: true,
                    remote: "/captcha/process"
                }
            },
            messages: {
                captcha: "<br><?php echo __('Correct captcha is required') ?>."
            },
            submitHandler: function(form) {
                if ("" == $("#doAction").val()) {
                <?php if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD) { ?>
                    if ($.trim($("#username").val()) == "") {
                        alert("Member ID cannot be blank.");
                        $("#username").focus();
                        return false;
                    }
                    if ($.trim($("#userpassword").val()) == "") {
                        alert("Password cannot be blank.");
                        $("#userpassword").focus();
                        return false;
                    }
                    <?php } ?>
                }
                form.submit();
            }
        });
    });
    </script>
</head>

<body class="home blog">
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request. Please be patient.</h3>
</div>
<noscript>
	<!-- display message if java is turned off -->
	<div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>
<form action="/home/doLogin" id="loginForm" method="post">
<div id="wrapper">
    <div id="page">
        <div id="content">

        <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
<table cellspacing="0" cellpadding="0">
<colgroup>
    <col width="1%">
    <col width="99%">
    <col width="1%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Member Login') ?></span></td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
<td>
<table cellspacing="0" cellpadding="0">
<tbody>
<tr>
    <td class="tbl_content_top" colspan="3">
        <table cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td colspan="3">
                    <span class="txt_error">&nbsp;<?php if ($sf_flash->has('errorMsg')) { echo $sf_flash->get('errorMsg'); } ?></span>
                </td>
            </tr>

            <tr>
                <td class="tbl_content_top">
                    <table border="0" width="256" cellspacing="0" cellpadding="0" class="tbl_login_grey_bg">
                        <colgroup>
                            <col width="1%">
                            <col width="30%">
                            <col width="61%">
                            <col width="2%">
                            <col width="1%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th class="tbl_header_left"><img border="0" src="/images/maxim/hdr-gry-left.gif"></th>
                            <th class="tbl_content_left" colspan="3"><?php echo __('Secure login') ?> &nbsp;<img src="/images/maxim/ico_secure_sml.gif"></th>
                            <th class="tbl_header_right"><img border="0" src="/images/maxim/hdr-gry-right.gif"></th>
                        </tr>

                        <tr height="20">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr height="24">
                            <td></td>
                            <td class="txt_highlight"><?php echo __('Member ID') ?></td>
                            <td colspan="2"><input type="text" autocomplete="off" size="38" id="username" name="username"></td>
                            <td></td>
                        </tr>
                        <tr height="24">
                            <td></td>
                            <td class="txt_highlight"><?php echo __('Password') ?></td>
                            <td colspan="2"><input type="password" autocomplete="off" size="38" id="userpassword" name="userpassword"></td>
                            <td></td>
                        </tr>
                        <tr height="24">
                            <td></td>
                            <td class="txt_highlight">

                            </td>
                            <td colspan="2">
                                <!--<div id="captchaimage" style="height: 28; width: 100; display: inline-block;"><a href="<?php /*echo $_SERVER['PHP_SELF']; */?>" id="refreshimg" title="Click to refresh image"><img src="/captcha/image?<?php /*echo time(); */?>" height="26" alt="Captcha image" style="border-style: none"/></a></div><input name="captcha" type="text" id="captcha" class="login_t73" size="18"/>-->
                                <?php
                                //if ($sf_user->getAttribute(Globals::LOGIN_RETRY, 0) >= 3) {
                                    require_once('recaptchalib.php');
                                    $publickey = "6LfhJtYSAAAAAAMifW42AIEE0qnNgOEFIDB0sqwt"; // you got this from the signup page
                                    echo recaptcha_get_html($publickey);
                                //}
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr height="30">
                            <td></td>
                            <td></td>
                            <td colspan="2"><img class="arwList" src="/images/maxim/arrow_blue_single_tab.gif">
                                <a href="<?php echo url_for("/member/forgetPassword") ?>"><?php echo __('Forgot username') ?> / <?php echo __('password') ?></a></td>
                            <td></td>
                        </tr>
                        <tr height="36">
                            <td align="center" colspan="5">
                                <span class="loginbutton">
                                    <input type="submit" value="<?php echo __('Login') ?>" name="Login" id="submitLink" style="width: 80px; background-color: #e5eef5">
                                </span>
                                <br>
                                <br>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>

<!--<tr>
    <td class="tbl_content_top" colspan="3">
        <table cellspacing="0" cellpadding="0" class="tbl_info_grey_bg">
            <tbody>
            <tr>
                <th class="tbl_header_left"><img src="/images/maxim/hdr-gry-left.gif"></th>
                <th colspan="2">New to Maxim Trader?</th>
                <th class="tbl_header_right"><img src="/images/maxim/hdr-gry-right.gif"></th>
            </tr>
            </tbody>
        </table>

        <table cellspacing="0" cellpadding="0" class="tbl_info_grey_bg_overall">
            <colgroup>
                <col width="1%">
                <col width="4%">
                <col width="94%">
                <col width="1%">
            </colgroup>
            <tbody>
            <tr>
                <td></td>
                <td class="tbl_content_top"><br>
                    <img src="/images/maxim/arrow_blue_single_tab.gif">
                </td>
                <td><br>
                    <a href="/index.php/member/register"><b>Instant Registration</b></a> <span class="txt_new">IT'S EASY!!</span>
                    <p>
                        <a href="/index.php/member/register">Click
                            here</a> to instantly register as Maxim Trader Member. In order to login into eTrader system, you must first register.
                            Please enter your desired user name, your email address and other required details in the form.</p>
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>-->
<tr>
    <td>&nbsp;</td>
</tr>
<!--<tr>
    <td class="tbl_content_top" colspan="3">
        <table cellspacing="0" cellpadding="0" class="tbl_info_grey_bg">
            <colgroup>
                <col width="1%" class="tbl_notice_left">
                <col width="98%" class="tbl_notice">
                <col width="1%" class="tbl_notice_right">
            </colgroup>
            <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th class="tbl_header_left"><img src="/images/maxim/hdr-gry-left.gif"></th>
                <th class="tbl_content_left">Need Help?</th>
                <th class="tbl_header_right"><img src="/images/maxim/hdr-gry-right.gif"></th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <ul class="grnList">
                        <li>
                            <div class="rightBoxHdrTitle"><b>24/7 Phone Assistance</b></div>
                            <b>Local</b><br>0123456789<br>

                        </li>
                        <li><a href="mailto:cs@maximtrader.com">Email us</a> for assistance
                        </li>
                        <li><a target="_self" href="#">
                            Frequently Asked Questions </a></li>
                    </ul>
                </td>
                <td>&nbsp;</td>
            </tr>

            </tbody>
        </table>
    </td>
</tr>-->
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>


        <?php include_component('component', 'footerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
        </div>
    </div>


    <div style="margin-left: 0px;" id="sidebar">
        <div id="sidebar-color"></div>
        <div id="sidebar-border"></div>
        <div id="sidebar-light"></div>
        <div id="sidebar-texture"></div>

        <div id="sidebar-content">

            <div id="logo"><a href="<?php echo url_for("/home")?>"><img src="/images/logo.png"></a></div>
            <div id="menu">
                <?php include_component('component', 'homeLeftMenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            </div>
            <div id="primary" class="widget-area" role="complementary">
                <ul class="xoxo">
                </ul>
            </div>
            <!-- #primary .widget-area -->
        </div>

        <div id="sidebar-bottom">
            <ul></ul>
            <p style="text-align: center;">© 2013 maximtrader.com <br> All rights reserved.</p>
        </div>
    </div>
</div>
</form>
</body>
</html>