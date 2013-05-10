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
    <style type="text/css">
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
a[href] img {
    border: medium none;
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
                <?php
                $culture = $sf_user->getCulture();
                ?>
                <div id="feedContent">
                    <a href="#">
                        <div class="poptitle">
                            <?php if ($culture == "en") { ?>
                            <h3>2013 The 9th Shanghai Investment Management & Financial Expo</h3><br>
                            <?php } else if ($culture == "cn") {  ?>
                            <h3>2013上海第九届投资理财金融博览会</h3><br>
                            <?php } else if ($culture == "jp") {  ?>
                            <h3>上海フェアー 2013</h3><br>
                            <?php }  ?>
                        </div>
                    </a>

                    <div class="news_date">
                    31 May 2013 - 2 June 2013
                    </div>
                    <br>
                    <div class="news_desc">
                        <?php if ($culture == "en") { ?>
                        <br>Maxim Trader is pleased to announce that we have been invited to participate in the prestigious 9th Shanghai Investment Management & Financial Expo which will be held on 31 May 2013 - 2 June 2013 in West Hall Gate 2, Shanghai Everbright Convention & Exhibition Centre (SECEC) Address: No. 88 Caobao Road, Xuhui District, Shanghai (booth Number : A153, A155, A169 , A170 )
                        <br>住所 : 中国上海徐江区漕宝路88号，西館2号門
                        <?php } else if ($culture == "cn") {  ?>
                        <br>马胜金融集团很高兴地宣布我司已荣幸受邀参加即将于2013.5.31-6.2日在中国上海光大会展中心举行的2013(上海)第九届投资理财金融博览会. 展馆地址为：中国上海徐汇区漕宝路88号光大会展中心西厅2号门；届时请莅临A153,A155，A169，A170
                        <br>住所 : 中国上海徐江区漕宝路88号，西館2号門
                        <?php } else if ($culture == "jp") {  ?>
                        <br>2013年5月31日~6月2日の第九回 上海投資理財金融博覧会 にマシンムトレーダー金融グループが招かれ、とても喜びを感じております。
                        <br>場所 : 上海光大会展センター
                        <br>ブース番号:A153,A155,A169,A170
                        <?php }  ?>

                        <br>
                        <?php if ($culture == "en") { ?>
                        <br>This much anticipated and eagerly awaited event will be the biggest ever to be held in China and is expected to attract more than a million visitors. We will have daily wheel of fortune lucky draws where a total prize money of USD1,000,000 will be given away.
                        <?php } else if ($culture == "cn") {  ?>
                        <br>展台参观并进一步了解我们公司。此次备受期待与热切关注的博览会将是有史以来规模最大的一次，预计将吸引超过一百万人次。马胜金融集团展台每天都会举行幸运转盘大抽奖，总奖金设置高达100万美金！
                        <?php } else if ($culture == "jp") {  ?>
                        <br>今回のイベントは 今までなく 最も注目され、100万人の訪問客を引きつけると予想されています。我々マシンムトレーダーとしてはこのイベントでは毎日 抽選会を行い、総額賞金 USD 1,000,000を出させていただいております。
                        <?php }  ?>
                        <br>
                        <?php if ($culture == "en") { ?>
                        <br>Our specially invited industry gurus will conduct financial talks and share the secrets of making money during these uncertain economic times. We expect this expo to be a tremendous success and one that will gain Maxim Trader permanent recognition as a leading innovative financial services provider.
                        <?php } else if ($culture == "cn") {  ?>
                        <br>另外我司还特别邀请了多位投资大师，举办各类金融讲座，与各位分享如何在当前不确定的经济形势下高效投资的秘密与诀窍!我们预祝博览会取得圆满成功，更希望借此机会成功打造马胜金融集团在创新型金融服务领域的永久知名度，继而进一步奠定我们在此领域的领导地位！
                        <?php } else if ($culture == "jp") {  ?>
                        <br>我々は このイベントに特別にある有名な金融の先生を招いて、金融投資に関することを会談し、この変動の激しい時代の中で お金を増やす、守る秘訣をシェアしていただけます。
                        <?php }  ?>
                        <br>
                        <?php if ($culture == "en") { ?>
                        <br>Come join us!!! Book your flight now, let’s make history together....
                        <?php } else if ($culture == "cn") {  ?>
                        <br>快来加入我们，并与我们一起谱写新的历史篇章吧！
                        <?php } else if ($culture == "jp") {  ?>
                        <br>さあ！上海にいらっしゃい、我々と一緒に この金融史に新たな一頁を創りましょう。
                        <?php }  ?>
                        <br>
                        <?php if ($culture == "en" || $culture == "jp") { ?>
                        <br>* Please make your own arrangements to stay at
                        <?php } else if ($culture == "jp") {  ?>
                        <br>* 各自に下記のホテルをご予約してください。よろしくお願いいたします。
                        <?php }  ?>
                        <br>
                        <?php if ($culture == "en") { ?>
                        Shanghai Everbright International Hotel Add: 66 Caobao Road, Xuhui District, Shanghai, China Tel: (86) 21-64842500 Website: http://www.ebhotel.com/
                        <?php } else if ($culture == "cn") {  ?>
                        请预定：上海光大国际大酒店
                        <br>地址：中国上海徐汇区漕宝路66号
                        <br>电话：(86) 21-64842500 网址：http://www.ebhotel.com/
                        <?php } else if ($culture == "jp") {  ?>
                        ホテル名:上海光大国际大酒店
                        <br>住所：中国上海徐汇区漕宝路66号Tel: (86) 21-64842500 Website: http://www.ebhotel.com/
                        <?php }  ?>
                        <br>
                        <?php if ($culture == "en") { ?>
                        <br>Note: Kindly book at www.ctrip.com as soon as possible to avoid disappointment.
                        <?php } else if ($culture == "cn" || $culture == "jp") {  ?>
                        <br>为了确保酒店入住，我们真诚地建议您尽快联系携程并完成酒店预定。
                        <?php }  ?>
                        <br><br>
                        <br>From,
                        <br>Maxim Trader management
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