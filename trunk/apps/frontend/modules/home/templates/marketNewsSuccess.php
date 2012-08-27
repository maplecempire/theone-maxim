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
    html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {
        background: none repeat scroll 0 0 transparent;
        border: 0 none;
        font-size: 100%;
        margin: 0;
        outline: 0 none;
        padding: 0;
        vertical-align: baseline;
        text-align: center !important;
    }
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
    <div id="page">
        <div id="content">


            <h1>Market News</h1>

            <div class="hr"></div>
            <ul id="blog-small" style="list-style: none outside none; margin: 0; padding: 0px">
                <li>
                    <div class="blog-small-image">
                        <a href="#"
                           class="">
                            <div class="imghover_small_blog"
                                 style="background-image: url(&quot;/css/maxim/image_overlay.png&quot;); opacity: 0;"></div>
                            <img src="#"
                                 style="visibility: visible; opacity: 1;"></a>
                    </div>

                    <div class="blog-small-text">
                        <a href="#">
                            <h1>FOREX-Euro weak on profit-taking, dollar recovers</h1></a>
                        <p><br></p>
                        <p class="blog-small-excerpt">The euro dipped to a one-week low against the dollar on Thursday
                            on profit-taking after a huge injection of cash... <a
                                    href="#">Read
                                more</a> <br><a class="read_more"
                                                href="#">Continue
                                reading →</a></p>

                    </div>
                </li>
                <li class="blog-small-sep"></li>

                <li>
                    <div class="blog-small-image">
                        <a href="#"
                           class="">
                            <div class="imghover_small_blog"
                                 style="background-image: url(&quot;/css/maxim/image_overlay.png&quot;); opacity: 0;"></div>
                            <img src="#"
                                 style="visibility: visible; opacity: 1;"></a>
                    </div>
                    <div class="blog-small-text">
                        <a href="#">
                            <h1>“Big Four” auditors brace for big changes in China</h1></a>
                        <p><br></p>
                        <p class="blog-small-excerpt">The Big Four&nbsp;global audit firms, which dominate the Chinese
                            market, are negotiating with Beijing to lessen the impact of forced... <a
                                    href="#">Read
                                more</a> <br><a class="read_more"
                                                href="#">Continue
                                reading →</a></p>

                    </div>
                </li>
                <li class="blog-small-sep"></li>
            </ul>
            <div class="navigation"></div>

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