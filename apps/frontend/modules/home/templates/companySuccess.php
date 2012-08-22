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

    <link rel='stylesheet' id='nivocss-css' href='/css/maxim/nivo-slider.css' type='text/css' media='all'/>
    <link rel='stylesheet' id='styler-farbtastic-css' href='/css/maxim/styler-farbtastic.css' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='wp-paginate-css' href='/css/maxim/wp-paginate.css' type='text/css' media='screen'/>

    <script type='text/javascript' src='/css/maxim/comment-reply.js'></script>
    <script type='text/javascript' src='/css/maxim/preloader.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.nivo.slider.js'></script>
    <script type='text/javascript' src='/css/maxim/bottomfix.js'></script>
    <script type='text/javascript' src='/css/maxim/jquery.quicksand.js'></script>
    <script type='text/javascript' src='/css/maxim/farbtastic.js'></script>

    <meta http-equiv="Content-Language" content="en-US">
    <style type="text/css" media="screen">
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
        }
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

    <script type="text/javascript">
        $(function() {
            $('BODY').bgStretcher({
                        images: ['/images/background/main-bg-031.jpg', '/images/background/main-bg-041.jpg','/images/background/main-bg-011.jpg', '/images/background/main-bg-022.jpg'],
                        imageWidth: 1024,
                        imageHeight: 768,
                        slideDirection: 'N',
                        nextSlideDelay: 5500,
                        transitionEffect: 'fade',
                        anchoring: 'left center',
                        anchoringImg: 'left center'
                    });
        });
    </script>
</head>

<body class="home blog">
<noscript>
    <!-- display message if java is turned off -->
    <div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>
</noscript>

<div id="wrapper">
    <div style="display: inline; width: 666px; overflow: hidden; margin-right: 0px;" id="page">
        <div id="content">
            <div style=" width:450; float:left;"><h1>The Company</h1></div>

            <div class="qtrans_widget_end"></div>
            <div class="hr"></div>
            <div style="clear:both;"></div>
            <p>Maxim Trader is a private investment and wealth management company that allows international participation
                of individuals and groups a like. Our primary focus of investment is in the Forex market. Our service
                provides highly lucrative return on investment along with complete account privacy, top-level online
                security, efficient account management and a fully dedicated support team. Our company’s financial
                portfolio is backed-up by an active pool of realized profits from various high-yield assets that we hold
                around the globe. All our investors have equal opportunity to benefit from our investment portfolios on
                a long-term basis, with the lowest possible risk of losing the initial principle invested.</p>

            <h2>Professional Team of Traders</h2>

            <div><img width="272" height="128" title="small-img-5" alt=""
                      src="/css/maxim/small-img-5.png"></div>
            <p>At Maxim Trader, we have a professional team of traders that have over 10 years of experience dealing
                mainly in the Forex market. Making profits from the Forex market is often considered as an acquired
                skill with a well-balanced mix of individual intuition gain over years of experience. Our main goal is
                to provide each investor and trader with an opportunity that is as safe as possible and at the same time
                maximizing your potential earnings. We diminish the risks normally associated with trading investments
                in the Forex Market by laying out a trading strategy that has been proven to work through our teams well
                balanced and various experiences over the past years.</p>
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