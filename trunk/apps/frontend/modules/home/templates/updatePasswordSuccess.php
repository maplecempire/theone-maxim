<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html style="display: block;">
<head>
    <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
    <meta http-equiv="CACHE-CONTROL" content="NO-STORE">
    <meta http-equiv="PRAGMA" content="NO-CACHE">
    <meta http-equiv="EXPIRES" content="-1">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=8" /><![endif]-->
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php use_helper('I18N') ?>
    <?php include('scripts.php'); ?>

	<link type="text/css" href="/css/maxim/member/slider-styles.css" rel="stylesheet">
    <script src="/css/maxim/member/popup.js" type="text/javascript"></script>

	<link href="/css/maxim/member/style.css" rel="stylesheet">
	<link media="screen" type="text/css" href="/css/maxim/member/member.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/style.css">

    <style type="text/css" media="screen">
        #sidebar-border {
            background-repeat: repeat-y;
            float: left;
            height: 100%;
            margin-left: 13px;
            position: absolute;
            width: 306px;
            z-index: 13;
        }

        #sidebar-light {
            background-image: url("/css/maxim/sidebar-light.png");
            background-position: center top;
            background-repeat: no-repeat;
            float: left;
            height: 100%;
            margin-left: 13px;
            position: absolute;
            width: 306px;
            z-index: 14;
        }

        /* digital clock */
        /* If you want you can use font-face */
        @font-face {
            font-family: 'BebasNeueRegular';
            src: url('BebasNeue-webfont.eot');
            src: url('BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
                 url('BebasNeue-webfont.woff') format('woff'),
                 url('BebasNeue-webfont.ttf') format('truetype'),
                 url('BebasNeue-webfont.svg#BebasNeueRegular') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        .clock {width:100px; margin:0 auto; padding:5px; color:#fff; }
        #Date { font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; font-size:10px; text-align:center; text-shadow:0 0 5px #00c6ff; }
        .clock ul { width:100px; margin:0 auto; padding:0px; list-style:none; text-align:center; }
        .clock ul li { display:inline; font-size:10px; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff; }
        #point { position:relative; -moz-animation:mymove 1s ease infinite; -webkit-animation:mymove 1s ease infinite; padding-left:0px; padding-right:0px; }

        /* Simple Animation */
        @-webkit-keyframes mymove
        {
        0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
        50% {opacity:0; text-shadow:none; }
        100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }
        }

        @-moz-keyframes mymove
        {
        0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
        50% {opacity:0; text-shadow:none; }
        100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }
        }
    </style>

    <script type="text/javascript">
        var infoStyle = "<div style='margin-bottom: 20px; padding: 0 .7em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span><strong id='_msg'></strong></p></div>";
        var errorStyle = "<div style='padding: 0 .7em;' class='ui-state-error ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-alert'></span><strong id='_msg'></strong></p></div>";

        function alert(data) {
            var msgs = "";
            if ($.isArray(data)) {
                jQuery.each(data, function(key, value) {
                    msgs = value + "<br>";
                });
            } else {
                msgs = data + "<br>";
            }

            var alertPanel = "<div style='padding: 10px; line-height :normal' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span>";
            alertPanel += msgs + "</p></div>";
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
            $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);
        }
        function error(data) {
            var msgs = "";
            if ($.isArray(data)) {
                jQuery.each(data, function(key, value) {
                    msgs = value + "<br>";
                });
            } else {
                msgs = data + "<br>";
            }

            var errorPanel = "<div style='padding: 10px; line-height :normal' class='ui-state-error ui-corner-all'>";
            errorPanel += "<p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-alert'></span>";
            errorPanel += msgs + "</p></div>";
            $("#waitingLB h3").html(errorPanel);
            $.blockUI({
                        message: $("#waitingLB")
                        , css: {
                            border: 'none',
                            padding: '5px',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            'border-radius': '10px',
                            opacity: .9,
                            'min-width': '30%',
                            'width': '60%',
                            left: '25%',
                            top: '25%'
                        }});
            $(".blockOverlay").css("z-index", 1010);
            $(".blockPage").css("z-index", 1011);
            $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);
        }
        function waiting() {
            /*$("#waitingLB h3").html("<h3>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");*/
            $("#waitingLB h3").html("<h3 style='width: 100%; padding-left: 0px; background-color:inherit; color: black; line-height:0px; margin-top: 20px;'>Loading...</h3><div id='loader' class='loader'><img id='img-loader' src='/images/loading.gif' alt='Loading'/></div>");

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
    </script>

    <script type='text/javascript' src='/js/jquery/jquery.validate.min.js'></script>
    <script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $("#username, #userpassword").keydown(function(e){
            var code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) { //Enter keycode
                $("#submitLink").trigger("click");
            }
        });
        $("#updatePasswordForm").validate({
            rules: {
                "oldPassword" : {
                    required : true
                },
                "newPassword" : {
                    required : true,
                    minlength : 6
                },
                "newPassword2" : {
                    required : true,
                    minlength : 6,
                    equalTo: "#newPassword"
                },
                "oldSecurityPassword" : {
                    required : true
                },
                "newSecurityPassword" : {
                    required : true,
                    minlength : 6
                },
                "newSecurityPassword2" : {
                    required : true,
                    minlength : 6,
                    equalTo: "#newSecurityPassword"
                }
            },
            messages: {
                newPassword2: {
                    equalTo: "<?php echo __('Please enter the same password as above') ?>"
                },
                newSecurityPassword2: {
                    equalTo: "<?php echo __('Please enter the same password as above') ?>"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
    </script>
</head>

<!--<img src="/images/loading.gif" style="display: none;">-->
<body class="home blog">
<div id="waitingLB" style="display:none; cursor: default">
    <h3 style="width: 100%; padding-left: 0px; background-color:inherit; color: black; line-height:0px; margin-top: 0px">We are processing your request. Please be patient.</h3>
</div>

<noscript>
    <!-- display message if java is turned off -->
    <div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>

<div class="main_auto_frame">
<div class="top_bar"></div>

<div class="main_width_frame">

<br class="clear">

<div class="content" style="min-height: inherit;">

<div class="top_bar_overlap"></div>
<div class="nav" style="min-height: inherit">
    <div class="nav_bg" style="z-index: 12;"></div>
    <div id="sidebar-border" style="z-index: 13;"></div>
    <div class="nav_texture" style="z-index: 14;"></div>
    <div class="nav_texture_leather" style="z-index: 16;"></div>
    <a href="/home/index">
        <?php
            $bonusService = new BonusService();
            if ($bonusService->hideGenealogy() == false) {
            } else {
        ?>
        <div class="logo" style="z-index: 20;"></div>
        <?php } ?>
    </a>
    <br class="clear">

    <div class="side_bar_line" style="z-index: 20;"></div>

    <?php include_component('component', 'homeLeftMenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>

    <div class="footer_frame" style="z-index: 20;">
        <div class="footer_content">&copy; 2013 maximtrader.com <br> All rights reserved.</div>
    </div>
</div>
<br class="clear">


<div class="top_item_frame">
    <div class="left_item"><?php echo __('Welcome to Maxim Trader.') ?></b></div>
    <div class="right_item">

        <div class="language"><?php echo __('Language') ?>: <a href="/home/language?lang=en">English</a> / <a href="/home/language?lang=cn">中文</a> / <a href="/home/language?lang=jp">日本語</a> / <a href="/home/language?lang=kr">한국어</a></div>
    </div>
</div>


<div class="content_frame">
    <div class="padding">
        <div class="content_title"></div>
    </div>
    <!--<div class="content_line"></div>-->
    <br class="clear">

    <?php if ($sf_flash->has('successMsg')) { ?>
        <div class="ui-widget">
            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
                <p style="margin: 10px">
                    <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                    <strong><?php echo $sf_flash->get('successMsg') ?></strong>
                </p>
            </div>
        </div>
    <?php } ?>
    <?php if ($sf_flash->has('errorMsg')) { ?>
        <div class="ui-widget">
            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
                <p style="margin: 10px">
                    <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                    <strong><?php echo $sf_flash->get('errorMsg') ?></strong>
                </p>
            </div>
        </div>
    <?php } ?>

    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
        <p style="margin: 10px"><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
            <strong><?php echo __('Your password has expired. Please update your password to continue using our Site and Service.') ?></strong>
        </p>
    </div>

    <table cellspacing="0" cellpadding="0">
                <colgroup>
                    <col width="1%">
                    <col width="99%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <td rowspan="3">&nbsp;</td>
                    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Update Password') ?></span></td>
                    <td rowspan="3">&nbsp;</td>
                </tr>
                <tr>
                <td>
                <table cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td class="tbl_content_top" colspan="3">
                        <form action="/member/doUpdatePassword" id="updatePasswordForm" name="updatePasswordForm" method="post">
                            <table cellspacing="0" cellpadding="0" class="tbl_form">
                            <colgroup>
                                <col width="1%">
                                <col width="30%">
                                <col width="69%">
                                <col width="1%">
                            </colgroup>
                            <tbody>
                            <tr>
                                <th class="tbl_header_left">
                                    <div class="border_left_grey">&nbsp;</div>
                                </th>
                                <th><?php echo __('Update Password Details') ?></th>
                                <th class="tbl_content_right"><!--Step 1 of 3--></th>
                                <th class="tbl_header_right">
                                    <div class="border_right_grey">&nbsp;</div>
                                </th>
                            </tr>

                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('Old Login Password'); ?></td>
                                <td><input name="oldPassword" type="password" id="oldPassword" tabindexBak="1"/>
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('New Login Password') ?></td>
                                <td>
                                    <input type="password" class="inputbox" id="newPassword" name="newPassword">
                                    &nbsp;
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('Re-enter Login Password') ?></td>
                                <td>
                                    <input type="password" class="inputbox" id="newPassword2" name="newPassword2">
                                    &nbsp;
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('Old Security Password'); ?></td>
                                <td>
                                    <input type="password" id="oldSecurityPassword" name="oldSecurityPassword" />
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_even">
                                <td>&nbsp;</td>
                                <td><?php echo __('New Security Password') ?></td>
                                <td>
                                    <input type="password" id="newSecurityPassword" name="newSecurityPassword" />
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_form_row_odd">
                                <td>&nbsp;</td>
                                <td><?php echo __('Re-enter Security Password'); ?></td>
                                <td>
                                    <input name="newSecurityPassword2" type="password" id="newSecurityPassword2" tabindexBak="3" />
                                </td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="tbl_listing_end">
                                <td>&nbsp;</td>
                                <td colspan="5" class="tbl_content_right">
                                     <span class="button">
                                         <input type="submit" name="" value="<?php echo __('Submit') ?>">
                                    </span>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                        </form>
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

    <div class="info_bottom_bg"></div>

    <!-- announcement popup   -->
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">

    <div class="content_line" style="position: absolute; bottom: 170px;"></div>
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <div style="position: absolute; bottom: 10px; padding-right: 40px;">
        <?php include_component('component', 'footerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    </div>
</div>

</div>

</div>

</div>
</body>
</html>