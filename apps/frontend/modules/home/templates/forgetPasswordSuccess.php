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
    .qtrans_flag span { display:none }
    .qtrans_flag { height:12px; width:18px; display:block }
    .qtrans_flag_and_text { padding-left:20px }
    a {
        background-color: transparent;
        color: #005D9A !important;
    }
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

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

<body class="home blog">

<div id="waitingLB" style="display:none; cursor: default">
    <h3 style="width: 100%; padding-left: 0px; background-color:inherit; color: black; line-height:0px; margin-top: 0px">We are processing your request. Please be patient.</h3>
</div>

<noscript>
    <!-- display message if java is turned off -->
    <div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>

<div id="wrapper">
    <div style="display: inline; width: 666px; overflow: hidden; margin-right: 0px;" id="page">
        <div id="content">

            <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            <div class="qtrans_widget_end"></div>
            <div style="clear:both;"><br></div>

            <table cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="1%">
                    <col width="99%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <td rowspan="3">&nbsp;</td>
                    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Forget Password') ?></span></td>
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
                                    <form action="/home/forgetPassword" id="registerForm" method="post">
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
                                            <th class="tbl_content_left" colspan="3"><?php echo __('Request Password') ?></th>
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
                                        </tbody>
                                    </table>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
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
            <p style="text-align: center;">© 2012 maximtrader.com <br> All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>