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

    <script type="text/javascript">
    $(document).ready(function() {
        /*
         *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
         */
        $('.fancybox-thumbs').fancybox({
            prevEffect : 'none',
            nextEffect : 'none',

            closeBtn  : false,
            arrows    : false,
            nextClick : true,
            "autoScale": false,
             // if fancybox 2.x
            fitToView: false,
            helpers : {
                thumbs : {
                    width  : 50,
                    height : 50
                }
            }
        });
    });
    </script>

    <meta http-equiv="Content-Language" content="en-US">
    <style type="text/css">
.fancybox-custom .fancybox-skin {
    box-shadow: 0 0 50px #222;
}

.fancybox-thumbs img {
    background: none repeat scroll 0 0 white;
    border: 1px solid #BBBBBB;
    margin: 7px 14px 7px 0;
    padding: 5px;
    width: 160px;
}

html {
    background: none repeat scroll 0 0 -moz-dialog;
    font: 3mm tahoma,arial,helvetica,sans-serif;
}
#feedBody {
    -moz-padding-start: 30px;
    background: none repeat scroll 0 0 -moz-field;
    border: 1px solid threedshadow;
    margin: 2em auto;
    padding: 3em;
}
#feedHeaderContainer {
    background-color: infobackground;
    border: 1px solid threedshadow;
    border-radius: 10px 10px 10px 10px;
    margin: -4em auto 0;
}
#feedHeader {
    -moz-margin-end: 1em;
    -moz-margin-start: 1.4em;
    -moz-padding-start: 2.9em;
    color: infotext;
    font-size: 110%;
    margin-bottom: 1em;
    margin-top: 4.9em;
}
#feedIntroText {
    display: none;
}
#feedHeader[dir="rtl"] {
    background-position: 100% 10%;
}
#feedHeader[firstrun="true"] #feedIntroText {
    -moz-padding-start: 0.6em;
    display: block;
    padding-top: 0.1em;
}
#feedHeader[firstrun="true"] > #feedSubscribeLine {
    -moz-padding-start: 1.8em;
}
#feedSubscribeLine {
    padding-top: 0.2em;
}
#feedHeaderContainer {
    display: none;
}
body {
    color: -moz-fieldtext;
    font: message-box;
    margin: 0;
    padding: 0 3em;
}
h1 {
    border-bottom: 2px solid threedlightshadow;
    font-size: 160%;
    margin: 0 0 0.2em;
}
h2 {
    color: threeddarkshadow;
    font-size: 110%;
    font-weight: normal;
    margin: 0 0 0.6em;
}
#feedTitleLink {
    -moz-margin-end: 0;
    -moz-margin-start: 0.6em;
    float: right;
    margin-bottom: 0;
    margin-top: 0;
}

#feedTitleContainer {
    -moz-margin-end: 0.6em;
    -moz-margin-start: 0;
    margin-bottom: 0;
    margin-top: 0;
}
#feedTitleImage {
    -moz-margin-end: 0;
    -moz-margin-start: 0.6em;
    margin-bottom: 0;
    margin-top: 0;
    max-height: 150px;
    max-width: 300px;
}
.feedEntryContent {
    font-size: 110%;
}
.link {
    color: #0000FF;
    cursor: pointer;
    text-decoration: underline;
}
.link:hover:active {
    color: #FF0000;
}
.lastUpdated {
    font-size: 85%;
    font-weight: normal;
}
.type-icon {
    height: 16px;
    vertical-align: bottom;
    width: 16px;
}
.enclosures {
    background: none repeat scroll 0 0 -moz-dialog;
    border: 1px solid threedshadow;
    margin: 1em auto;
    padding: 1em;
}
.enclosure {
    margin-left: 2px;
    vertical-align: middle;
}
ul, ol {
    list-style: none outside none;
    margin: 0;
    color: black;
}
</style>
    <link rel="stylesheet" type="text/css" media="all" href="/css/maxim/style.css">

	<script type="text/javascript">
	$(function() {
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
    <div id="page">
        <div id="content">


            <div id="feedBody">
                <div id="feedTitle">
                    <div id="feedTitleContainer">
                        <h1 id="feedTitleText" style="margin-right: 135px;"><?php echo __('Events & Activities') ?></h1>
                    </div>
                </div>
                <div id="feedContent">
                    <a href="#">
                        <?php
                        $culture = $sf_user->getCulture();
                        ?>
                        <div class="poptitle">
                            <h3>马胜金融：三赢策略「全球金融精明投资的前景＂概念、创新＂」</h3>
                            <br>
                        </div>
                    </a>

                    <div class="news_date">
                    26 June 2013
                    </div>
                    <br>
                    <div class="news_desc">

                        <br>地点：待定（在酒店进行）
                        <br>时间：上午7：30PM
                        <br>日期：26/06/2013  星期三
                        <br><br>
                        <br>马胜金融集团御用金融投资大师Mr.Daniel Ang(超过20年经验在金融经济市场)为您讲解当今的世界在变，天也已经变了，很多人受困于，对于新兴事物，第一看不见，第二看不起，第三看不懂，第四来不及，马胜金融三赢策略的概念，创新。
                        <br><br>
                        <br>请邀请您的朋友到来参与，请预早报名。请联系：Dennis Chai, +60122222305

                        <br>
                        <br>
                        <div style="float: right"><a href="/home/activities">Go Back</a></div>
                    </div>
                </div>
            </div>

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

</body>
</html>