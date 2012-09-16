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
    <div style="display: inline; width: 666px; overflow: hidden; margin-right: 0px;" id="page">
        <div id="content">
            <div style=" width:450; float:left;"><h1>Contact Us</h1></div>

            <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            <div class="qtrans_widget_end"></div>
            <div class="hr"></div>
            <div style="clear:both;"></div>
            <table class="pbt_table">
                <tbody>
                <tr class="pbt_body">
                    <td class="td_1st"><b>Contact Number</b></td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st">+012- 3456 7890</td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st"><br clss="clear"></td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st"><b>Email</b></td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st">info@maximtrader.com</td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st">info.maximtrader@gmail.com</td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st"><br clss="clear"></td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st"><b>Our Address</b></td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st">
                        Maxim Offices<br>
                        Vero Centre Auckland<br>
                        Level 31, 48 Shortland Street, Auckland<br>
                        1010 NEW ZEALAND<br><br>
                    </td>
                </tr>
                <tr class="pbt_body">
                    <td class="td_1st"><br clss="clear"></td>
                </tr>
                </tbody>
            </table>
            <iframe width="300" height="150" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Vero+Centre+Auckland,+Level+31,+48+Shortland+Street,+Auckland&amp;aq=&amp;sll=-36.801038,174.768448&amp;sspn=0.137728,0.338173&amp;ie=UTF8&amp;hq=Vero+Centre+Auckland,+Level+31,+48+Shortland+Street,+Auckland&amp;hnear=&amp;radius=15000&amp;t=m&amp;cid=17786362531510328297&amp;ll=-36.84659,174.768362&amp;spn=0.020606,0.025749&amp;z=14&amp;output=embed"></iframe>
            <br><br>
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