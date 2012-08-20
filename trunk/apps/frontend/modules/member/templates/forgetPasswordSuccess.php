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
        $("#registerForm").validate({
            messages : {

            },
            rules : {
                "username" : {
                    required : true
                },
                "email" : {
                    required : true
                    , email: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            },
            success: function(label) {
                //label.addClass("valid").text("Valid captcha!")
            }
        });
    });

    function waiting() {
        $("#waitingLB h3").html("<h3>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");

        $.blockUI({
            message: $("#waitingLB")
                , css: {
                    border: 'none',
                    padding: '5px',
                    'background-color': '#fff',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    'border-radius': '10px',
                    opacity: .8,
                    color: '#000'
        }});
        $(".blockOverlay").css("z-index", 1010);
        $(".blockPage").css("z-index", 1011);
    }
    function alert(data) {
        var msgs = "";
        if ($.isArray(data)) {
            jQuery.each(data, function(key, value) {
                msgs = value + "<br>";
            });
        } else {
            msgs = data + "<br>";
        }

        var alertPanel = "<div style='margin-bottom: 20px; padding: 0 .7em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span>";
        alertPanel += msgs +"</p></div>";
        $("#waitingLB h3").html(alertPanel);
        $.blockUI({
            message: $("#waitingLB")
                , css: {
                    border: 'none',
                    padding: '5px',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    'border-radius': '10px',
                    opacity: .9
        }});
        $(".blockOverlay").css("z-index", 1010);
        $(".blockPage").css("z-index", 1011);
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
    }
    </script>
</head>
<body>
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request.  Please be patient.</h3>
</div>
<form action="/member/forgetPassword" id="registerForm" method="post">
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
    <td class="tbl_sprt_bottom"><span class="txt_title">Forget Password</span></td>
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
                    <?php if ($sf_flash->has('errorMsg')) { ?>
                    <span class="txt_error">&nbsp; <?php echo $sf_flash->get('errorMsg'); ?></span>
                    <?php } ?>
                    <?php if ($sf_flash->has('successMsg')) { ?>
                    <span class="txt_success">&nbsp; <?php echo $sf_flash->get('successMsg'); ?></span>
                    <?php } ?>
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
                            <th colspan="3" class="tbl_content_left">Request password</th>
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
                            <td class="txt_highlight">Trader ID</td>
                            <td colspan="2"><input name="username" id="username" size="18" autocomplete="off"
                                                   type="text" value="<?php echo $username ?>"></td>
                            <td></td>
                        </tr>
                        <tr height="24">
                            <td></td>
                            <td class="txt_highlight"><?php echo __('Email'); ?></td>
                            <td colspan="2"><input name="email" id="email" size="18" autocomplete="off"
                                                   type="text" value="<?php echo $email ?>"></td>
                            <td></td>
                        </tr>
                        <tr height="30">
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td></td>
                        </tr>
                        <tr height="36">
                            <td colspan="5" align="center">
                                <span class="loginbutton">
                                    <input style="width: 80px; background-color: #e5eef5" id="submitLink"
                                       name="Login" value="<?php echo __('Send') ?>" type="submit">
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

                </td>
            </tr>
            </tbody>
        </table>
    </td>
    <td>&nbsp;</td>
    <td class="tbl_content_top">

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