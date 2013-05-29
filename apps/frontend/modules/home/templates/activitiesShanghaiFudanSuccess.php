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
                            <?php if ($culture == "cn") {  ?>
                            <h3>马胜上海复旦大学国际金融论坛</h3>
                            <?php } else if ($culture == "jp") {  ?>
                            <h3>上海フダン大学国際金融フォーラム</h3>
                            <?php } else if ($culture == "kr") {  ?>
                            <h3>맥심 트레이더 상해 복단 대학교 국제 금융 포럼</h3>
                            <?php } else {  ?>
                            <h3>Maxim Trader Shanghai Fudan University International Financial Forum</h3>
                            <?php }  ?>
                            <br>
                        </div>
                    </a>

                    <div class="news_date">
                    2 June 2013
                    </div>
                    <br>
                    <div class="news_desc">
                        <?php if ($culture == "cn") {  ?>
                        <br>马胜金融集团很荣幸地宣布我们即将于2013.6.2日参加由上海复旦大学传媒学院举办、且只接受邀请的金融研讨论坛!届时我们进一步了解复旦大学有关外汇市场交易的经典基金管理课程，并会与众学院教授、讲师以及学生们深度交流有关外汇交易领域的案例与经验。马胜金融集团受此邀请，无上荣誉。我们相信复旦的学生将会成长为中国未来新一代的商业领袖与企业家，我们也非常高兴能够在塑造学生思维方面贡献自己的一份力量！我们无限珍惜此次无价的荣誉！
                        <?php } else if ($culture == "jp") {  ?>
                        <br>Maxim Traderはフダン大学ジャーナリズム学院が主催した招待制金融フォーラムに招待されたことを報告します。今回の金融フォーラムは2013年6月2日上海にて行われ、参加者のこれまでに為替市場において提案したファンドマネジメントプログラムを共有し、大学の教員および生徒と為替市場の経験を議論する。Maxim traderはこの金融フォーラムに招待されたこと、更に中国の次世帯ビジネスリーダーや企業家となる生徒たちの思考力形成に貢献できることを、誇り高く感じ、無上な栄誉と考えっております。
                        <?php } else if ($culture == "kr") {  ?>
                        <br>맥심트레이더가 중국 상해 복단 저널리즘 대학교가 주관하는 금융포럼에 초청되었음을 기쁘게 알려드립니다.  이는 포렉스 분야의 자산 운용 프로그램의 전문 지식과 경험을 대학 교수, 부교수, 학생들과 공유하기 위해서입니다.  이러한 초청을 받는 다는 사실은 맥심으로서는 굉장한 특권이자 영광이며 미래의 비즈니스 리더이자 사업가가 될 학생들의 생각에 많은 영향을 미칠것이라 생각됩니다. 소중한 영예라고 확신힙니다.
                        <?php } else {  ?>
                        <br>We are proud to announce that Maxim Trader has been invited to participate in the invitation-only Financial Forum organized by The School of Journalism Fudan University, Shanghai, China on 2 June 2013 to share their dedicated fund management program on the foreign exchange market, as well as to discuss experiences in this field to the University Professors, Associates and students.   It is indeed a privilege and an honor for Maxim Trader  to receive such an invite and to be able to shape the thinking of these students who one day  will be the future business leaders and entrepreneurs of China. This is an invaluable accolade indeed.
                        <?php }  ?>

                        <p>
                            <a class="fancybox-thumbs" data-fancybox-group="thumb" href="/uploads/activities/mmexport1369377913772.jpg"><img src="/uploads/activities/mmexport1369377913772.jpg" alt="" /></a>
                        </p>
                        <br>
                        <br>
                        <h1>会议流程</h1>

                        <a href="<?php echo url_for("/home/downloadFudan")?>" target="_blank">Download</a>

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