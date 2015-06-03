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
<!--    <link rel="stylesheet" href="/css/style.css">-->

<!--    <link rel='stylesheet' id='nivocss-css' href='/css/maxim/nivo-slider.css' type='text/css' media='all'/>-->
<!--    <link rel='stylesheet' id='styler-farbtastic-css' href='/css/maxim/styler-farbtastic.css' type='text/css' media='all'/>-->
<!--    <link rel='stylesheet' id='wp-paginate-css' href='/css/maxim/wp-paginate.css' type='text/css' media='screen'/>-->

<!--    <script type='text/javascript' src='/css/maxim/comment-reply.js'></script>-->
<!--    <script type='text/javascript' src='/css/maxim/preloader.js'></script>-->
<!--    <script type='text/javascript' src='/css/maxim/jquery.nivo.slider.js'></script>-->
<!--    <script type='text/javascript' src='/css/maxim/bottomfix.js'></script>-->
<!--    <script type='text/javascript' src='/css/maxim/jquery.quicksand.js'></script>-->
<!--    <script type='text/javascript' src='/css/maxim/farbtastic.js'></script>-->

	<link type="text/css" href="/css/maxim/member/slider-styles.css" rel="stylesheet">
    <script src="/css/maxim/member/popup.js" type="text/javascript"></script>

	<link href="/css/maxim/member/style.css" rel="stylesheet">
	<link media="screen" type="text/css" href="/css/maxim/member/member.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/style.css">
<!--    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">-->

    <style type="text/css" media="screen">
        /*#content p {
            clear: none;
            margin-bottom: 0px !important ;
        }
        .ui-widget {
            font-family: Segoe UI, Arial, sans-serif;
            font-size: 0.9em;
        }
        .qtrans_flag span {
            display: none
        }

        .qtrans_flag {
            height: 12px;
            width: 18px;
            display: block
        }

        .qtrans_flag_and_text {
            padding-left: 20px
        }*/
        #sidebar-border {
            /*background-image: url("/css/maxim/sidebar-border.png");*/
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

        $(function() {
            $("button, input:submit, input:button").button();
            $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
                    .find(".portlet-header")
                    .addClass("ui-widget-header ui-corner-all")
                    .prepend("<a href='#' class='ui-dialog-titlebar-close ui-corner-all' role='button'><span class='ui-icon ui-icon-circle-triangle-n' style='padding-right: 2px'></span></a>")
                    .end()
                    .find(".portlet-content");

            $(".portlet-header .ui-icon").click(function() {
                $(this).toggleClass("ui-icon-circle-triangle-n").toggleClass("ui-icon-circle-triangle-s");
                $(this).parents(".portlet:first").find(".portlet-content").toggle("fast");
            });

            $("#btnLogout").click(function(){
                $("#formLogout").submit();
            });

            /*******    Digital Clock   ***************/
            // Create two variable with the names of the months and days in an array
            var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
            var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

            // Create a newDate() object
            var newDate = new Date(<?php echo microtime(true) * 1000;?>);
            // Extract the current date from Date object
            newDate.setDate(newDate.getDate());
            // Output the day, date, month and year
            $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear() + " (GMT+8)");

            setInterval( function() {
                // Create a newDate() object and extract the seconds of the current time on the visitor's
                var seconds = new Date().getSeconds();
                // Add a leading zero to seconds value
                $("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
            },1000);

            setInterval( function() {
                // Create a newDate() object and extract the minutes of the current time on the visitor's
                var minutes = new Date().getMinutes();
                // Add a leading zero to the minutes value
                $("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
            },1000);

            setInterval( function() {
                // Create a newDate() object and extract the hours of the current time on the visitor's
                var hours = new Date().getHours();
                // Add a leading zero to the hours value
                $("#hours").html(( hours < 10 ? "0" : "" ) + hours);
            }, 1000);
        });

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
        /*$("#captchaimage").bind('click', function() {
            $.post('/captcha/newSession');
            $("#captchaimage").load('/captcha/imageRequest');
            return false;
        });*/
        $("#loginForm").validate({
            rules: {
                /*"captcha" : {
                    required: true,
                    remote: "/captcha/process"
                }*/
            },
            messages: {
                captcha: "<br><?php echo __('Correct captcha is required') ?>."
            },
            submitHandler: function(form) {
                if ("" == $("#doAction").val()) {
                <?php if (sfConfig::get('sf_environment') == Globals::SF_ENVIRONMENT_PROD) { ?>
                    if ($.trim($("#username").val()) == "") {
                        alert("Username cannot be blank.");
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
    <!--<div id="sidebar-light"></div>-->
    <div class="nav_texture" style="z-index: 14;"></div>
    <!--<div class="nav_texture_carbon" style="z-index: 15;"></div>-->
    <div class="nav_texture_leather" style="z-index: 16;"></div>
    <a href="/home/index">
        <div class="logo" style="z-index: 20;"></div>
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
<?php
                                    $closeLogin = false;
                                    $monthStr = "06";
                                    $monthEngStr = "June";
                                    $dayStr = "04";
                                    $hourStr = "7";
                                    $totalHourStopStr = "1";
                                    if ($closeLogin == false) {

                                    } else {
                                    ?>

                                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                         class="ui-state-highlight ui-corner-all">
                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                      class="ui-icon ui-icon-info"></span>
                            <strong>Dear IMs and Partners
<br>亲爱的代理及会员们:
<br>
<br>Please NOTE that the company server will be SHUT DOWN at <?php echo $hourStr;?>:00hrs <?php echo $monthEngStr;?> <?php echo $dayStr;?> 2015 for a period of <?php echo $totalHourStopStr;?> hours.
<br>请注意公司将于2015.<?php echo $monthStr;?>.<?php echo $dayStr;?>日<?php echo $hourStr;?>:00分关闭服务器, 时长为<?php echo $totalHourStopStr;?>小时.
<br>
<!--<br>This is necessary because we are UPGRADING our servers to better serve our IMs and to keep up abreast with the demands of our continued growth.-->
<!--<br>这一操作是因为我们需要升级服务器,也是为了满足我们不断快速成长的需求, 更好地服务所有代理及会员.-->
<!--<br>-->
<br>We seek your kind understanding and apologize for any inconvenience caused. 敬请留意,谢谢大家的理解!为此造成任何不便,我们深表歉意.
<br>
<br>CEO 首席执行官
<br>Maxim Capital Limited
<br>马胜金融集团
<br>
<br>친애하는 국제회원 및 파트너 여러분
<br>
<br>회사 서버가 2015년 <?php echo $monthStr;?>월 <?php echo $dayStr;?>일 <?php echo $hourStr;?>시00분부터 <?php echo $totalHourStopStr;?>시간동안 연결되지 않을 것입니다.
<br>
<br>이는 국제회원 여러분에게 더 나은 서비스와 지속적으로 늘어나는 요구를 충족시킬 수 있도록 서버를 업그레이드 하기 위함입니다.
<br>
<br>여러분의 이해에 감사드리며 불편를 끼쳐드려서 죄송합니다.
<br>
<br>CEO
                                <br>
                                <br>
<br>맥심 캐피탈 주식회사
<br>
<br>IMおよびパートナーの皆様
<br>
<br>弊社サーバーが2015年<?php echo $monthStr;?>月<?php echo $dayStr;?>日<?php echo $hourStr;?>時00分より<?php echo $totalHourStopStr;?>時間停止しますので、ご注意ください。
<br>これはIMの皆様により良いサービスを提供すると共に、需要の増大に対応するため、弊社サーバーをアップグレードするものです。
<br>
<br>ご不便をおかけすることをお詫びします。どうぞ皆様のご理解をお願いいたします。
<br>
<br>CEO
<br>マキシム・キャピタル・リミテッド
                            </strong>
                                    </p></div>
<?php } ?>
                                    <span class="txt_error">&nbsp;<?php if ($sf_flash->has('errorMsg')) { echo $sf_flash->get('errorMsg'); } ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td class="tbl_content_top">
                                    <?php
                                    /*$closeLogin = false;
                                    if (date("d") > 21) {
                                        $closeLogin = true;
                                    }*/
                                    if ($closeLogin == false) {
                                    ?>
                                    <form action="/home/doLogin" id="loginForm" method="post">
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
                                            <td class="txt_highlight"><?php echo __('Username') ?></td>
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
                                            <td class="txt_highlight"></td>
                                            <td colspan="2">
                                                <?php
                                                if ($sf_user->getAttribute(Globals::LOGIN_RETRY, 0) >= 3) {
                                                    require_once('recaptchalib.php');
                                                    $publickey = "6LfhJtYSAAAAAAMifW42AIEE0qnNgOEFIDB0sqwt"; // you got this from the signup page
                                                    echo recaptcha_get_html($publickey);
                                                }
                                                ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr height="30">
                                            <td></td>
                                            <td></td>
                                            <td colspan="2"><img class="arwList" src="/images/maxim/arrow_blue_single_tab.gif">
                                                <a href="<?php echo url_for("/home/forgetPassword") ?>"><?php echo __('Forgot username') ?> / <?php echo __('password') ?></a></td>
                                            <td></td>
                                        </tr>
                                        <tr height="36">
                                            <td align="center" colspan="5">
                                                <span class="loginbutton">
                                                    <input type="submit" value="<?php echo __('Login') ?>" name="Login" id="submitLink" style="width: 80px; background-color: #e5eef5">
                                                </span>
                                                &nbsp;&nbsp;
                                                <!--<a href="<?php /*echo url_for("/member/register") */?>"><?php /*echo __('Register Now') */?></a>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    </form>
                                    <?php } ?>
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

<!--                    ####################################################            -->

        <?php
                        if ($closeLogin == false) {
                        ?>
        <table cellpadding="0" cellspacing="0">
            <tbody>

            <tr>
                <td class="tbl_content_top">
                    <table class="tbl_info_grey_bg" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr>
                            <th class="tbl_header_left"><img src="/images/maxim/hdr-gry-left.gif"></th>
                            <th colspan="2"><?php echo __('New to Maxim Trader') ?>?</th>
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
                                <a href="<?php echo url_for("/member/register")?>"><b><?php echo __('Self Registration') ?></b></a> <span class="txt_new"><?php echo __("IT'S EASY!!") ?></span>
                                <p>
                                    <a href="<?php echo url_for("/member/register")?>">
                                        <?php echo __('Click here') ?></a> <?php echo __('to instantly register as Maxim Trader Member') ?>. </p>
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
    <?php } ?>
<!--                    ####################################################            -->
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