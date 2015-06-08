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
            background-image: url("/css/maxim/sidebar-border.png");
            background-repeat: repeat-y;
            float: left;
            height: 100%;
            margin-left: 13px;
            position: fixed;
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
            position: fixed;
            width: 306px;
            z-index: 14;
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

            var alertPanel = "<div style='margin-bottom: 20px; padding: 0 .7em;' class='ui-state-highlight ui-corner-all'><p><span style='float: left; margin-right: .3em;' class='ui-icon ui-icon-info'></span>";
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

            var errorPanel = "<div style='padding: 0 .7em;' class='ui-state-error ui-corner-all'>";
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
    </script>
</head>

<img src="/images/loading.gif" style="display: none;">
<body class="home blog">
<div id="waitingLB" style="display:none; cursor: default">
    <h3>We are processing your request. Please be patient.</h3>
</div>

<noscript>
    <!-- display message if java is turned off -->
    <div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>

<div class="main_auto_frame">
<div class="top_bar"></div>

<div class="main_width_frame">

<br class="clear">

<div class="content">

<div class="top_bar_overlap"></div>
<div class="nav">
    <div class="nav_bg" style="z-index: 12;"></div>
    <div id="sidebar-border" style="z-index: 13;"></div>
    <!--<div id="sidebar-light"></div>-->
    <div class="nav_texture" style="z-index: 14;"></div>
    <!--<div class="nav_texture_carbon" style="z-index: 15;"></div>-->
    <div class="nav_texture_leather" style="z-index: 16;"></div>
    <a href="#">
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

    <div class="menu" style="z-index: 20;">
        <ul>
            <li class="menu_title">MAIN MENU</li>
            <li><a href="index.php">Home </a></li>
            <li><a href="profile.php">User Profile</a></li>
            <li><a href="register.php">Registration</a></li>
            <li><a href="activate.php">Package Purchase</a></li>
        </ul>
        <br class="clear"><br>
        <ul>
            <li class="menu_title">ACCOUNT INFORMATION</li>
            <li><a href="commission.php">Commission</a></li>
            <li><a href="epoint_transfer.php">Wallet</a></li>
            <li><a href="withdrawal.php">Withdrawal</a></li>
        </ul>
        <br class="clear"><br>
        <ul>
            <li class="menu_title">HIERARCHY</li>
            <li><a href="genealogy.php">Genealogy</a></li>
        </ul>
        <br class="clear"><br>
        <ul>
            <li class="menu_title">CONTACT</li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="support_ticket.php">CS Center</a></li>
        </ul>
        <br class="clear"><br>
        <ul>
            <li class="menu_title">NEWS &amp; EVENTS</li>
            <li><a href="newsevent.php">News &amp; Events</a></li>
        </ul>
        <br class="clear"><br>
        <ul>
            <li class="menu_title">Exchange Rate</li>
            <li><a href="exchange.php">Exchange Rate</a></li>
        </ul>
        <br class="clear"><br>
        <ul>
            <li class="menu_title">Forex Account</li>
            <!--<li><a href='apply_live_mt4.php'>Apply Live MT4 Account</a></li>-->
            <li><a href="mt4_fileupload.php">Document Upload</a></li>
            <li><a href="downloads.php">MT4 Platform Downloads</a></li>
        </ul>
    </div>

    <div class="footer_frame" style="z-index: 20;">
        <div class="footer_content">&copy; 2012 ABFXTraders.com <br> All rights reserved.</div>
    </div>
</div>
<br class="clear">


<div class="top_item_frame">
    <div class="left_item">Welcome fxwinner</div>
    <div class="right_item">

        <div class="language">Language: <a href="?__lang=en">English</a> / <a href="?__lang=cn">中文</a></div>

        <div class="sep"></div>
        <div class="logout"><a href="logout.php">Logout</a></div>

    </div>
</div>


<div class="content_frame">
    <div class="padding">
        <div class="content_title"></div>
    </div>
    <div class="content_line"></div>
    <br class="clear">

    <p class="headtag"><b class="b1">fxwinner, Welcome to ABFX.</b></p>

    <h2>Member's Home</h2><br>fxwinner, welcome to ABFX.<br>

    <h2>Account Information</h2>

    <table class="pbt_table">
        <tbody>
        <tr>
            <td width="200">User Name:</td>
            <td>fxwinner</td>
        </tr>
        <tr>
            <td>Rank:</td>
            <td>Privilege Package</td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>Active</td>
        </tr>
        <tr>
            <td>Last Login:</td>
            <td>29/8/2012 5:11:00 PM</td>
        </tr>
        </tbody>
    </table>
    <div class="info_bottom_bg"></div>
    <br><br>

    <h2>Your Account Points</h2>
    <table class="pbt_table">
        <tbody>
        <tr class="row_header">
            <td width="200">CP2 Wallet:</td>
            <td>60.97</td>
        </tr>
        <tr>
            <td width="200">Register Wallet:</td>
            <td>0.00</td>
        </tr>

        </tbody>
    </table>
    <div class="info_bottom_bg"></div>
    <div class="clear"></div>
    <br><br>

    <h2>Member Purchase Record</h2>

    <div>2 records.</div>
    <table class="pbl_table">
        <tbody>
        <tr class="pbl_header">
            <td>Date</td>
            <td>Username</td>
            <td>Package Info</td>
        </tr>

        <tr class="row0">
            <td class="date">5/7/2012 7:25:58 PM</td>
            <td class="date">fxwinner</td>
            <td>
                Package : Silver Package<br>
                Price (USD) : 1,000.00<br>
                Status : Confirmed<br>
            </td>
        </tr>
        <tr class="row1">
            <td class="date">4/7/2012 4:34:09 PM</td>
            <td class="date">fxwinner</td>
            <td>
                Package : 7 Days Privilege Account<br>
                Price (USD) : 0.00<br>
                Status : <br>
            </td>
        </tr>
        </tbody>
    </table>
    <div>2 records. <br><br></div>
    <div class="info_bottom_bg"></div>
    <div id="popupContact" style="position: absolute; top: -343.333px; left: 19.8px; display: none;">
        <h1>Latest News</h1>
        <a id="popupContactClose">CLOSE</a>

        <p id="contactArea">
            <img src="http://www.abfxtrader.com/ablive/nimages/site/eidalfitr-2012.jpg">
        </p>

        <div class="popdivider"></div>

        <div class="popinfo1">
            <a href="newsevent.php?n=89d09ac4084cc4fe69fd0395ecfed375">
                <div class="poptitle">【System Announcement】Adjustment of Pairing Bonus System</div>
            </a>

            <div class="news_date">2012-08-30</div>
            <div class="news_desc">The Company has adjusted the Point Value of Pairing Bonus from floating to a fixed
                method.
            </div>
            <a href="newsevent.php?n=">Read More &gt;&gt;</a>
        </div>
        <div class="popdivider"></div>

        <div class="popinfo1">
            <a href="newsevent.php?n=eb070b8b62854b2b32c07c216095786a">
                <div class="poptitle">【Promotion】Fast Start Promotion-2 is now on！</div>
            </a>

            <div class="news_date">2012-08-16</div>
            <div class="news_desc">Fast Start Promotion-2 is now on, starting from 16th August 2012 until 30th September
                2012. <a
                        href="http://www.abfxtrader.com/ablive/members/newsevent.php?n=eb070b8b62854b2b32c07c216095786a">Please
                    click here for the details</a>.
            </div>
            <a href="newsevent.php?n=">Read More &gt;&gt;</a>
        </div>
        <div class="popdivider"></div>

        <div class="popinfo1">
            <a href="newsevent.php?n=dfbf6cf87b2b11f76dd0cf6d4fda0dc8">
                <div class="poptitle">【System Announcement】Revision of Exchange Rate for register point purchase &amp;
                    withdrawal
                </div>
            </a>

            <div class="news_date">2012-08-16</div>
            <div class="news_desc">The company has revised the exchange rate for register point purchase &amp;
                withdrawal.(Please click “<a href="http://www.abfxtrader.com/ablive/members/exchange.php"><u>Exchange
                    Rate</u></a>” for the complete list)
            </div>
            <a href="newsevent.php?n=">Read More &gt;&gt;</a>
        </div>
        <div class="popdivider"></div>

        <div class="popinfo1">
            <a href="newsevent.php?n=c49bb34b76c6b75197113b70b93b54b2">
                <div class="poptitle">【System Announcement】Fast Start Promotion Extended</div>
            </a>

            <div class="news_date">2012-08-01</div>
            <div class="news_desc">The Company has decided to extend the Fast Start Promotion until 15th August 2012.
            </div>
            <a href="newsevent.php?n=">Read More &gt;&gt;</a>
        </div>
        <div class="popdivider"></div>

        <div class="popinfo1">
            <a href="newsevent.php?n=caea0523e416d59facf7d6deb0972adc">
                <div class="poptitle">【FOREX】FOREX Monthly Return in July 2012</div>
            </a>

            <div class="news_date">2012-08-01</div>
            <div class="news_desc">The Company has decided to give a 7% as the monthly return for July 2012.</div>
            <a href="newsevent.php?n=">Read More &gt;&gt;</a>
        </div>
        <div class="popdivider"></div>

        <p></p>
        <a id="popupContactClose2">CLOSE</a><br>
    </div>
    <div id="backgroundPopup" style="height: 572px; opacity: 0.7; display: none;"></div>

    <br class="clear">
    <br class="clear">

    <div class="content_line"></div>
    <br class="clear">
    <br class="clear">
    <br class="clear">
    <br class="clear">
</div>

</div>

</div>

</div>
</body>
</html>