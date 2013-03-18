<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">

    <?php use_helper('I18N') ?>
    <?php include('scripts.php'); ?>

    <link rel="stylesheet" type="text/css" href="/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/button.css" media="all">
    <link rel="shortcut icon" href="/favicon.ico"/>
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
        $("#loginForm").validate({
            rules: {

            },
            messages: {
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
<body>
<form action="/home/doLogin" id="loginForm" method="post">
<input type="hidden" name="doAction" id="doAction" value="">
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td align="left">
<table class="tbl_layout" cellpadding="0" cellspacing="0">
<colgroup>
    <col width="1%">
    <col width="98%">
    <col width="1%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td>


        <table cellpadding="0" cellspacing="0">
            <colgroup>
                <col class="scb_colorbar1" width="20%">
                <col class="scb_colorbar2" width="10%">
                <col class="scb_colorbar3" width="15%">
                <col class="scb_colorbar4" width="5%">
                <col class="scb_colorbar5" width="50%">
            </colgroup>
            <tbody>
            <tr>
                <td class="scb_colorbar1">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="tbl_heading" cellpadding="0" cellspacing="0">
            <colgroup>
                <col width="17%">
                <col width="83%">
            </colgroup>
            <tbody>
            <tr>
                <td rowspan="2">
                    <img src="/images/logo.png" height="85">
                </td>
                <td class="txt_mainheading">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td class="txt_subheading">

                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <hr class="hr_heading">
    </td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
<td><br>
<table cellpadding="0" cellspacing="0">
<colgroup>
    <col width="10%">
    <col width="80%">
    <col width="10%">
</colgroup>
<tbody>
<tr>
    <td rowspan="3">&nbsp;</td>
    <td class="tbl_sprt_bottom"><span class="txt_title">MaximTrade Executor</span></td>
    <td rowspan="3">&nbsp;</td>
</tr>
<tr>
    <td><br>
    </td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0">
<colgroup>
    <col width="75%">
    <col width="3%">
    <col width="22%">
</colgroup>
<tbody>
<tr>
    <td class="tbl_content_top">
        <table cellpadding="0" cellspacing="0">
            <colgroup>
                <col width="45%">
                <col width="4%">
                <col width="51%">
            </colgroup>

            <tbody>
            <tr>
                <td colspan="3">
                    <span class="txt_error">&nbsp;<?php if ($sf_flash->has('errorMsg')) { echo $sf_flash->get('errorMsg'); } ?></span>
                </td>
            </tr>

            <tr>
                <td class="tbl_content_top">
                    <table class="tbl_login_grey_bg" cellpadding="0" cellspacing="0" width="256" border="0">
                        <colgroup>
                            <col width="1%">
                            <col width="30%">
                            <col width="61%">
                            <col width="2%">
                            <col width="1%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th class="tbl_header_left"><img src="/images/maxim/hdr-gry-left.gif" border="0"></th>
                            <th colspan="3" class="tbl_content_left">Secure login &nbsp;<img
                                    src="/images/maxim/ico_secure_sml.gif"></th>
                            <th class="tbl_header_right"><img src="/images/maxim/hdr-gry-right.gif" border="0"></th>
                        </tr>

                        <tr height="40">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr height="24">
                            <td></td>
                            <td class="txt_highlight">Member ID</td>
                            <td colspan="2"><input name="username" id="username" size="18" autocomplete="off"
                                                   type="text"></td>
                            <td></td>
                        </tr>
                        <tr height="24">
                            <td></td>
                            <td class="txt_highlight">Password</td>
                            <td colspan="2"><input name="userpassword" id="userpassword" size="18" autocomplete="off"
                                                   type="password"></td>
                            <td></td>
                        </tr>
                        <tr height="30">
                            <td></td>
                            <td></td>
                            <td colspan="2"><img src="/images/maxim/arrow_blue_single_tab.gif" class="arwList">
                                <a href="<?php echo url_for("/member/forgetPassword")?>">Forgot username / password </a></td>
                            <td></td>
                        </tr>
                        <tr height="36">
                            <td colspan="5" align="center">
                                <span class="loginbutton">
                                    <input style="width: 80px; background-color: #e5eef5" id="submitLink"
                                       name="Login" value="Login" type="submit">
                                </span>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr class="tbl_form_end">
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>

                </td>

                <td class="tbl_content_middle">&nbsp;</td>

                <td class="tbl_content_top">
                    <table class="tbl_info_grey_bg" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th class="tbl_header_left"><img src="/images/maxim/hdr-gry-left.gif"></th>
                            <th colspan="2">New to Maxim Trader?</th>
                            <th class="tbl_header_right"><img src="/images/maxim/hdr-gry-right.gif"></th>
                        </tr>
                        </tbody>
                    </table>

                    <table class="tbl_info_grey_bg_overall" cellpadding="0" cellspacing="0">
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
                                <a href="<?php echo url_for("/member/register")?>"><b>Instant Registration</b></a> <span class="txt_new">IT'S EASY!!</span>
                                <p>
                                    <a href="<?php echo url_for("/member/register")?>">Click
                                        here</a> to instantly register as Maxim Trader Member. In order to login into eTrader system, you must first register.
                                        Please enter your desired user name, your email address and other required details in the form.</p>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><br></td>
                            <td><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <br>
                                <br>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="tbl_notice_end">
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            </tbody>
        </table>
    </td>
    <td>&nbsp;</td>
    <td class="tbl_content_top">
        <table class="tbl_info_green" cellpadding="0" cellspacing="0">
            <colgroup>
                <col class="tbl_notice_left" width="1%">

                <col class="tbl_notice" width="98%">
                <col class="tbl_notice_right" width="1%">
            </colgroup>
            <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <th class="tbl_header_left">
                    <div class="border_left_green">&nbsp;</div>
                </th>
                <th class="tbl_content_left">Need Help?</th>
                <th class="tbl_header_right">
                    <div class="border_right_green">&nbsp;</div>
                </th>
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
                        <li><a href="#" target="_self">
                            Frequently Asked Questions </a></li>
                    </ul>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr class="tbl_info_green_bottom">
                <td colspan="100%"><b class="green_border"><b class="green_border4"></b><b class="green_border3"></b><b
                        class="green_border2"><b></b></b><b class="green_border1"><b></b></b></b>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>

<tr>
    <td colspan="3">&nbsp;</td>
</tr>
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
</td>
</tr>
<tr>
    <td>


        <br>
        <br>
        <br>
        <br>
        <hr class="hr_heading">
        <br>
        Copyright © Maxim Trader
        &nbsp;<span class="txt_seperator">|</span>&nbsp;
        <img src="/images/maxim/arrow_blue_single_tab.gif">

        <a href="#" class="navcontainer_nav_1" id="nav_terms_conditions" target="_self">
            Terms &amp; Conditions
        </a>

        &nbsp;<span class="txt_seperator">|</span>&nbsp;

        <img src="/images/maxim/arrow_blue_single_tab.gif">
        <a href="#" target="_self">
            Data Protection and Privacy Policy
        </a>
    </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</form>

</body>
</html>