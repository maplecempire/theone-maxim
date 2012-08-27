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
    </style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

	<script type="text/javascript">
	$(function() {
        //PAGE OPENING ANIMATION
        jQuery('#page').css({'display':'inline','width':'300px','overflow':'hidden','margin-right':'340px'});
        jQuery('#sidebar').css({'margin-left':'326px'});

        jQuery('#sidebar').delay(800).animate({'margin-left':'0px'},2100);
        jQuery('#page').delay(800).animate({'margin-right':'0px','width':'666px'},2100);

		/*jQuery('#bg_slider').bgSlider({
			'speed' : '8000',
			'pause' : '10000'
		});*/

        /*$('BODY').bgStretcher({
            images: ['/images/background/main-bg-031.jpg', '/images/background/main-bg-041.jpg','/images/background/main-bg-011.jpg', '/images/background/main-bg-022.jpg'],
            imageWidth: 1024,
            imageHeight: 768,
            slideDirection: 'N',
            nextSlideDelay: 5500,
            transitionEffect: 'fade',
            anchoring: 'left center',
            anchoringImg: 'left center'
        });*/
	});
	</script>
</head>

<body class="home blog"> 
<noscript>
	<!-- display message if java is turned off -->	
	<div id="notification">Please turn on javascript in your browser for the maximum user experience!</div>	
</noscript>

<div id="wrapper">
    <div style="display: none; width: 666px; overflow: hidden; margin-right: 0px;" id="page">
        <div id="content">

            <!--<ul class="qtrans_language_chooser" id="qtranslate-chooser">
                <li class="active"><a href="http://www.maximtrader.com/" class="qtrans_flag_en qtrans_flag_and_text"
                                      title="English"><span>English</span></a></li>
                <li><a href="http://www.maximtrader.com/zh/" class="qtrans_flag_zh qtrans_flag_and_text"
                       title="中文"><span>中文</span></a></li>
            </ul>-->
            <div class="qtrans_widget_end"></div>
            <div style="clear:both;"></div>
            <p>
            </p>

            <!--<div class="slider-nivo-holder">
                <div class="nivoSlider" style="position: relative; no-repeat scroll 0% 0% transparent;" id="slider-nivo">
                    <img style="display: none;" src="/css/maxim/main-slide-01.png" alt="">
                    <img style="display: none;" src="/css/maxim/main-slide-02.png" alt="">
                    <img style="display: none;" src="/css/maxim/main-slide-03.png" alt="">
                </div>
            </div>

            <script type="text/javascript">
                jQuery('#slider-nivo').nivoSlider({
                    controlNav:true,
                    controlNavThumbs:false,
                    keyboardNav:false,
                    pauseOnHover:false,
                    prevText:'',
                    nextText:'',
                    effect:'fade',
                    animSpeed:300,
                    pauseTime:8000
                });
            </script>-->

            <!--#####################################################################-->
            <style>

#contentSlide:after {
    clear: both;
    content: ".";
    display: block;
    height: 0;
    visibility: hidden;
}
#contentSlide {
    background: url("/assets/images/bg-content.png") repeat-y scroll 0 0 transparent;
    margin: 0 auto;
    padding: 0 23px;
    position: relative;
    width: 941px;
    z-index: 1;
}
#contentSlide li {
    font-size: 1.2em;
    line-height: 1.5em;
}
ul, ol {
    list-style: none outside none;
    margin: 0;
}
.slide-bg {
    background-color: #F2F2F2;
    height: 212px;
    margin: 0;
    padding: 0;
    width: 582px;
}
.slide-main {
    left: 16px;
    position: absolute;
    top: 26px;
    width: 377px;
}
.slide-offset {
    height: 0;
    overflow: hidden;
    position: absolute;
    text-indent: -99999px;
}
.slide-cta {
    bottom: -46px;
    left: 0;
    min-height: 20px;
    min-width: 25px;
    position: absolute;
}
.slide-tc {
    bottom: 14px;
    color: #666666;
    font-size: 10px;
    height: 20px;
    left: 86px;
    line-height: 110%;
    position: absolute;
    width: 726px;
}
.slide-tc a:link, .slide-tc a:visited, .slide-tc a:hover {
    color: #666666;
    text-decoration: underline;
}
.slide-temp-2 .slide-tc {
    color: #FFFFFF;
    text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.25);
}
.slide-temp-2 .slide-tc a:link, .slide-temp-2 .slide-tc a:visited, .slide-temp-2 .slide-tc a:hover {
    color: #FFFFFF;
    text-decoration: underline;
}
.slide-temp-3 .slide-main {
    left: 215px;
    top: 72px;
    width: 495px;
}
.slide-temp-3 .slide-cta {
    left: auto;
    right: 0;
}
#banner {
    height: 212px;
    margin: 0;
    overflow: hidden;
    padding: 0;
    position: relative;
    width: 582px;
}
#banner .slides {
    height: 405px;
    margin: 0;
    overflow: hidden;
    padding: 0;
}
#banner .slides .slide-content {
    margin: 0;
    padding: 0;
    position: relative;
}
#banner .nav {
    bottom: 15px;
    margin: 0;
    padding: 0;
    position: absolute;
    right: 34px;
    z-index: 100;
}
#banner .nav li {
    float: left;
    position: relative;
}
#banner .nav li a {
    color: #CCCCCC;
}
#banner .nav li a, #banner .nav li a.activeSlide {
    color: #CCCCCC;
    display: block;
    font-family: Arial,sans-serif;
    font-size: 30px;
    font-weight: bold;
    height: 24px;
    line-height: 1.2em;
    margin: 0;
    padding: 0 2px;
    position: relative;
    text-align: center;
    width: auto;
}
#banner .nav li a.activeSlide {
    color: #333438;
}
                a, a:link, a:hover, a:visited {
    color: inherit;
    cursor: pointer;
    text-decoration: none;
}
            </style>
            <script type='text/javascript' src='/js/jquery.cycle.all.min.js'></script>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#banner .slides').after('<ol class="nav"></ol>').cycle({
                        fx: 'scrollHorz',
                        speed: 700,
                        timeout: document.getElementById("hidSlideTimeout").value,
                        easing: 'easeInOutExpo',
                        pause: 1,
                        pager: '#banner ol.nav',
                        pagerAnchorBuilder: function (title, img) {
                            return '<li><a href="#">&bull;</a></li>';
                        }
                    });

                    if (document.getElementById("hidPauseSlideShow").value == "1") {
                        $('#banner .slides').after('<ol class="nav"></ol>').cycle('pause');
                    }
                });
            </script>
            <input type="hidden" name="hidSlideTimeout" id="hidSlideTimeout" value="10000" />
            <input type="hidden" name="hidPauseSlideShow" id="hidPauseSlideShow" value="0" />
            <div id="banner">
                <ol class="slides" style="position: relative; overflow: hidden;">

                    <li class="slide-content hide"
                        style="position: absolute; top: 0px; left: -941px; z-index: 6; opacity: 1; display: block; width: 941px; height: 450px;">
                        <div class="slide-content slide-temp-1">
                            <div class="slide-bg">
                                <img src="/css/maxim/banner/bg1.png"></div>
                            <div class="slide-main">
                                <img src="/css/maxim/banner/bg1-word.png"
                                     alt="We are MAXIM. A worldwide leader in currency trading.">

                            </div>
                            <div class="slide-tc">
                            </div>
                        </div>
                    </li>

                    <li class="slide-content hide"
                        style="position: absolute; top: 0px; left: 0px; z-index: 7; opacity: 1; display: none; width: 941px; height: 1215px;">
                        <p style="display:none;"></p>
                        <link type="text/css" rel="stylesheet" href="/css/maxim/g3bo.css">
                        <div id="g3boBody">
                            <div id="g3boContent">
                                <h3 style="color: #FFFFFF;">Maxim Trader</h3>

                                <p style="color:#26272A;font-size: 1.2em;line-height:130%; padding-right: 20px">The smart investors choice for managing funds and guaranteeing satisfaction!</p>
                                <p>
                                <a title="open a trial account" href="/member/register"
                                   class="g3boButton">OPEN AN ACCOUNT NOW<img
                                        src="/css/maxim/button arrow.png"
                                        alt=""></a>
                            </div>
                        </div>
                        <div id="flashContent">
                            <object align="middle" width="940" height="405"
                                    id="/css/maxim/banner/ActiveTrader_Homepage_001_fla5"
                                    classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
                                <param value="/css/maxim/banner/ActiveTrader_Homepage_001_fla5.swf"
                                       name="movie">
                                <param value="high" name="quality">
                                <param value="#ffffff" name="bgcolor">
                                <param value="true" name="play">
                                <param value="true" name="loop">
                                <param value="transparent" name="wmode">
                                <param value="showall" name="scale">
                                <param value="true" name="menu">
                                <param value="false" name="devicefont">
                                <param value="" name="salign">
                                <param value="sameDomain" name="allowScriptAccess">
                                <!--[if !IE]>-->
                                <object width="940" height="405" type="application/x-shockwave-flash"
                                        data="/css/maxim/banner/ActiveTrader_Homepage_001_fla5.swf">
                                    <param value="/css/maxim/banner/ActiveTrader_Homepage_001_fla5.swf"
                                           name="movie">
                                    <param value="high" name="quality">
                                    <param value="#ffffff" name="bgcolor">
                                    <param value="true" name="play">
                                    <param value="true" name="loop">
                                    <param value="transparent" name="wmode">
                                    <param value="showall" name="scale">
                                    <param value="true" name="menu">
                                    <param value="false" name="devicefont">
                                    <param value="" name="salign">
                                    <param value="sameDomain" name="allowScriptAccess">
                                    <!--<![endif]-->
                                    <img
                                        src="/css/maxim/G3BO_HomepageSlideshow_Background.jpg"
                                        alt=""> <!--[if !IE]>--></object>
                                <!--<![endif]--></object>
                        </div>
                        <div class="altImage">
                            <img src="/css/maxim/G3BO_HomepageSlideshow_Background.jpg" alt="">

                            </div>
                    </li>

                    <li class="slide-content hide"
                        style="position: absolute; top: 0px; z-index: 6; opacity: 1; display: none; width: 582px; height: 212px;">
                        <div class="slide-content"
                             style="background:#f6f7f6 url('/css/maxim/banner/bg3.png') left top no-repeat;width:582px;height:212px;">
                        </div>
                    </li>

                </ol>
            </div>
            <!--#####################################################################-->

            <div class="hr2"></div>
            <a href="<?php echo url_for("/home/maximExecutor")?>"><p><img width="582" height="184" src="/css/maxim/banner/bg2.png" alt="" title="MAXIMTRADE EXECUTOR™" class="aligncenter size-full wp-image-162"></p></a>

            <!--^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^-->
            <div class="hr2"></div>
            <div class="one_half"><span class="medium_image"
                                        style="float: left; margin-bottom: 10px; margin-right: 20px;"><a class=""><img
                    style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-1.png" alt=""
                    height="128" width="272"></a></span> <strong>Professional Trading Team</strong>
                AtMaxim Trader, we have a professional team of traders that have over
                10 years of experience dealing mainly in the Forex market. <a
                        href="<?php echo url_for("/home/company")?>">Learn more ?</a></div>
            <div class="one_half_last"><span class="medium_image"
                                             style="float: left; margin-bottom: 10px; margin-right: 20px;"><a
                    class=""><img style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-3.png"
                                  alt="" height="128" width="272"></a></span> <strong>Investment Report</strong>
                We estimate thatMaxim Trader investment portfolios have outperformed
                the benchmark over the past 12 months with an overall +205.92% gain. <a
                        href="<?php echo url_for("/home/investment")?>">Learn more ?</a></div>
            <span class="vspace"></span>

            <div class="one_half"><span class="medium_image"
                                        style="float: left; margin-bottom: 10px; margin-right: 20px;"><a class=""><img
                    style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-4.png" alt=""
                    height="128" width="272"></a></span> <strong>Market Analysis</strong>
                Our goal is to provide investors with an investment opportunity that is
                as safe as possible and at the same time maximizing your potential
                earnings. <a href="<?php echo url_for("/home/investment")?>">Learn more ?</a></div>
            <div class="one_half_last"><span class="medium_image"
                                             style="float: left; margin-bottom: 10px; margin-right: 20px;"><a
                    class=""><img style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-2.png"
                                  alt="" height="128" width="272"></a></span> <strong>Spot a Golden Opportunity</strong>
                Investing in a Forex financial tool such as XAUUSD (gold against the
                American dollar) can secure the gold reserve of your funds. <a
                        href="<?php echo url_for("/home/investment")?>">Learn more ?</a></div>

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