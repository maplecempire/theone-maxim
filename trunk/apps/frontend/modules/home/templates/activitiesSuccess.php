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
.news_date {
    padding-top: 10px;
    font-weight: bold;
    font-size: 13px;
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
<?php
$culture = $sf_user->getCulture();
?>
<div id="wrapper">
    <div id="page">
        <div id="content">

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

            <div id="feedBody">
                <div id="feedTitle">
                    <div id="feedTitleContainer">
                        <h1 id="feedTitleText" style="margin-right: 135px;"><?php echo __('Events & Activities') ?></h1>
                    </div>
                </div>
                <div id="feedContent">

                    <a href="#">
                        <div class="poptitle"><h3>2014 January Calendar</h3><br>
                    </div>
                    </a>
                    <br>

                    <br><a href="/download/calendar">Download 2014 January Calendar</a> (315KB PDF)
                    <div class="news_date">
                    Posted on 09 January 2014
                    </div>

                    <div class="hr"></div>

                    <a href="#">
                        <div class="poptitle"><h3>马胜集团12月份新加坡商业金融分享会(200名额) Maxim Trader December Singapore business and finance seminar (Limited to 200 participants)</h3><br>
                    </div>
                    </a>
                    <br>
                    <br>时间: 2013.12.17
                    <br>时间: 晚上7: 30
                    <br>地点: Suntec Singapore International Convention & Exhibition Centre.
                    <br>Level 6 Hall 605 Room 606E
                    <br>1 Raffles Boulevard, Suntec city, Singapore 039593.
                    <br>语言: 中英双语.
                    <br>
                    <br>Date: 17th Dec 2013
                    <br>Time: 7.30pm
                    <br>Venue: Suntec Singapore International Convention & Exhibition Centre.
                    <br>Level 6 Hall 605 Room 606E
                    <br>1 Raffles Boulevard, Suntec city, Singapore 039593.
                    <br>Medium: English/Mandarin.
                    <br>Contact person : +6591200067 (Rykel Lim)
                    <div class="news_date">
                    Posted on 16 December 2013
                    </div>

                    <div class="hr"></div>

                    <a href="#">
                        <div class="poptitle"><h3>Perth event</h3><br>
                    </div>
                    </a>
                    <br>

                    <br>16/1/2014 Thursday :
                    <br>Leader meeting with Dr Andrew lim , 7.30pm @ Antrium crown plaza .
                    <br>PO Box 500 Victoria Park  Western Australia 6979
                    <br>
                    <br>18/1/2014 Saturday :
                    <br>Financial Preview & Maxim Preview by Mr Daniel Ang & Dr Andrew Lim (for Public, estimate 100-150pax)
                    <br>7pm to 11pm @ botanicals room, crown burswood. PO Box 500 Victoria Park  Western Australia 6979
                    <br>
                    <br>19/1/2014 Sunday :
                    <br>Forex training by Mr Daniel Ang ( for in house trader estimate 40-60pax)
                    <br>10am to 5pm @ community hall , city of bayswater . 28 Eighth Avenue Maylands. WA 6051
                    <div class="news_date">
                    Posted on 05 December 2013
                    </div>

                    <div class="hr"></div>

                    <a href="#">
                        <div class="poptitle"><h3>Maxim Trader Forex Preview</h3><br>
                    </div>
                    </a>
                    <br>

                    <br>YOU ARE INVITED!
                    <br>
                    <br>8 November 2013, 7:30pm
                    <br>
                    <br>Suntec Singapore International
                    <br>Convention & Exhibition Centre
                    <br>Level 6 Hall 605 Room 606E
                    <br>1 Raffles Boulevard. Suntec City, Singapore
                    <br>039593
                    <br>
                    <br>BY INVITATION ONLY.
                    <br>Register through your Introducing Broker.
                    <br>
                    <br>Guests from overseas will be given priority seating.
                    <div class="news_date">
                    Posted on 10 November 2013
                    </div>

                    <div class="hr"></div>


                    <a href="#">
                        <?php if ($culture == "cn") {  ?>
                        <div class="poptitle"><h3>马胜集团11月份梹城商业金融分享会(100名额)</h3><br>
                        <?php } else {  ?>
                        <div class="poptitle"><h3>Maxim Trader November Penang business and finance preview (Limited to 100 participants)</h3><br>
                        <?php }   ?>
                    </div>
                    </a>
                    <br>
                    <?php if ($culture == "cn") {  ?>
                    <br>时间: 2013.11.12 晚上8:00
                    <br>地点: Penang Vistana Hotel
                    <br>语言: 中英双语
                    <?php } else {  ?>
                    <br>Date: 12. Nov 2013
                    <br>Time: 8pm
                    <br>Venue: Vistana Hotel. Penang
                    <br>Medium: English/Mandarin.
                    <br>Contact person. Ms Fion 0174000830 (pg)
                    <?php }   ?>
                    <div class="news_date">
                    Posted on 10 November 2013
                    </div>

                    <div class="hr"></div>


                    <a href="#">
                        <?php if ($culture == "cn") {  ?>
                        <div class="poptitle"><h3>国际金融交流会(IME)澳门 2013</h3><br>
                        <?php } else if ($culture == "kr") {   ?>
                        <div class="poptitle"><h3>첫번째 인터내셔날 멤버스 교환 (IME) 2013</h3><br>
                        <?php } else if ($culture == "jp") {   ?>
                        <div class="poptitle"><h3>国際金融交流会(IME) in マカオ 2013</h3><br>
                        <?php } else {  ?>
                        <div class="poptitle"><h3>INAUGURAL INTERNATIONAL MEMBERS EXCHANGE (IME) 2013</h3><br>
                        <?php }   ?>
                    </div>
                    </a>
                    <br>
                    <?php if ($culture == "cn") {  ?>
                    <br>马胜以无尚荣幸地欢迎各位亲爱的伙伴与尊贵的嘉宾们参加此次国际金融交流盛会！我们会为您奉上来自世界一流的金融大师、顶尖的行业专家以及著名的激励演讲名师带来各式讲座与思想交流！如果您想真正打造自己的国际视野并建立国际事业，这将是一个千载难逢的机会！您可以与800多位来自世界不同国家与地区的领导，并与您拥有一致目标的伙伴们增进互动、交流思想！非凡体验，不可错失！
                    <br><br><font color="red" style="font-weight: bold; font-size: 16px">我们与您相约在澳门！</font>
                    <?php } else if ($culture == "kr") {  ?>
                    큰 기쁨으로 이 엄청남 컨퍼런스와 미팅을 찾아오신 맥심의 모든 멤버들과 손님들을 환영합니다.  오신 모든 분들을 위하여 최고의 금융전문가, 업계 전문가와 최고의 동기부여 강사들을 자랑스러움을 가지고 모셨습니다.  진심으로 글로벌 비즈니스의 성공을 원하신다면 IME로 오십시오.  오셔서 전세계에서 모인 800여명의 같은 생각을 갖고 계신 회원들, 친구들, 손님들과 아이디어를 교환하시고, 관계를 만드시고, 시너지를 개발하십시오.… 절대로 놓쳐서는 안 되는 놀라운 경험이 될 것입니다.
                    <br><br><font color="red" style="font-weight: bold; font-size: 16px">마카오에서 뵙기를 바랍니다.</font>
                    <?php } else if ($culture == "jp") {  ?>
                    我々マッシムトレーダーはパートナーや御来賓が国際金融交流イベントに参加することを、心より歓迎しております。今回の交流会において、世界トップクラスの金融専門家や業界エリート、および有名なファシリテーター講師を招待し、多彩のセミナーを開いていただき、思考交流のチャンスを提供致します。あなたが本当に自分自身の国際的な視点を構築し、国際的なキャリアを確立したいなら、今回の交流会は絶好のチャンスになります。800人の世界各地から来た指導者や同じ目標を持つ仲間たちと、連携を促進し、意見を交換することができます！特別な体験なので、是非見逃すことなく。
                    <br><br><font color="red" style="font-weight: bold; font-size: 16px">マカオでお会いしましょう！</font>
                    <?php } else {  ?>
                    <br>With the greatest of pleasure, we welcome members and guests of Maxim to this fabulous conference and meeting of minds. Proudly, we bring you the best Financial Gurus, Industry Experts and Motivation Speaker Extraordinaire. Come to IME if you want to build for yourself a truly successful global business. Come exchange ideas, foster relationships and develop synergy with over 800 like-minded members, friends and guests from around the world……
                    <br><br><font color="red" style="font-weight: bold; font-size: 16px">An amazing experience NOT to be MISSED.</font>
                    <?php }   ?>

                    <p>
                        <a class="fancybox-thumbs" data-fancybox-group="thumb" href="/uploads/activities/INVITATION.jpg"><img src="/uploads/activities/INVITATION.jpg" alt="" style="height: 100px;"/></a>
                    </p>
                    <a href="<?php echo url_for("/download/invitation")?>"><?php echo __("Download")?></a>
                    <div class="news_date">
                    Posted on 4 August 2013
                    </div>

                    <div class="hr"></div>

                    <a href="#">
                        <?php if ($culture == "cn") {  ?>
                        <div class="poptitle"><h3>马胜金融讲座</h3><br>
                        <?php } else {  ?>
                        <div class="poptitle"><h3>Maxim Financial Seminar</h3><br>
                        <?php }   ?>
                    </div>
                    </a>
                    <br>
                    <?php if ($culture == "cn") {  ?>
                    <br>由马胜特聘讲师兼亚洲著名金融分析师Mr. Daniel Ang为你讲解最新巿场走势与货币／贵金属交易的基本优势，幇肋你开拓新的投资视野。欢迎马胜伙伴帯新朋友来参与这知性之旅及探讨新商机。
                    <br>日期：2013年7月23日
                    <br>时间：下午2时30分
                    <br>地点：中国义乌大酒店
                    <br>语言：华语
                    <?php } else {  ?>
                    <br>Maxim Consultant and Famous Asia Financial Analyst, Mr. Daniel Ang will be sharing with you the latest market outlook, basic advantages about precious metal/currency trading and broaden your investment prospective. All Maxim partners are welcome to invite new guests to participate and learn about new business opportunity.
                    <br><br>Date: 23 July 2013
                    <br>Time: 2:30pm
                    <br>Venue: china yiwu Hotel
                    <br><br>Pls pledge your group seat with - chris 18559033787 by 20july.
                    <br>Limited seat!!!
                    <?php }   ?>
                    <div class="news_date">
                    Posted on 18 July 2013
                    </div>

                    <div class="hr"></div>

                    <a href="#">
                        <div class="poptitle"><h3>金汇融资商讨会 Dual Currency Investment (DCI)</h3><br>
                    </div>
                    </a>
                    <br>
                    <br>地点： Kinta Riverfront Hotel
                    <br>地址 : Sultes, Level 3, Tronoh Hall, Jalan Lim Bo Seng, 30000 Ipoh, Perak.
                    <br>时间：下午7：30PM
                    <br>日期：17/07/2013  星期三
                    <br><br>
                    <br>当然，最重要的是，我们邀请了一名神秘国际金融师来与我们分享接下来的 10 年里最红的投资项目，DCI
                    <br><br>
                    <br>The most important event for the night, we have invited an International Financial Advisor to share with us why DCI will be the best investment opportunity in next 10 years.
                    <br><br>
                    <br>Pledge ticket before 14July @ 5pm Ms. Vicky  01111112616
                    <div class="news_date">
                    Posted on 12 June 2013
                    </div>

                    <div class="hr"></div>


                    <a href="#">
                        <div class="poptitle"><h3>金汇融资商讨会 Dual Currency Investment (DCI)</h3><br>
                    </div>
                    </a>

                    <br>
                    <br>地点： Furama Hotel Bukit Bintang
                    <br>地址：136, Jalan Changkat Thambi Dollah, Bukit Bintang Kuala Lumpur.
                    <br>Event hall 会场 : Saffron l,ll&lll, Level 27楼
                    <br>时间：下午7：30PM
                    <br>日期：19/07/2013  星期五
                    <br><br>
                    <br>当然，最重要的是，我们邀请了一名神秘国际金融师来与我们分享接下来的 10 年里最红的投资项目，DCI
                    <br><br>
                    <br>The most important event for the night, we have invited an International Financial Advisor to share with us why DCI will be the best investment opportunity in next 10 years.
                    <br><br>
                    <br>Pledge ticket before 15July @ 5pm Ms. Jennifer  +60163228282
                    <br>
                    <div class="news_date">
                    Posted on 10 July 2013
                    </div>

                    <div class="hr"></div>
                    <a href="#">
                        <?php if ($culture == "cn") {  ?>
                        <div class="poptitle"><h3>马胜交易员工作仿限于所有马胜注册10k usd以上的伙伴</h3><br>
                        <?php } else {  ?>
                        <div class="poptitle"><h3>Maxim Trader "Forex Price Action" Workshop for members with investment of USD 10k and above</h3><br>
                        <?php } ?>
                    </div>
                    </a>

                    <?php if ($culture == "cn") {  ?>
                    <br>报名截止：2013年7月10日 (Ms Fion 0174000830)
                    <br>人数：只限150人
                    <br>请自备已安装MT4平台的电脑。
                    <br><br>工作仿详情如下：
                    <br>日期：2013年7月14日
                    <br>时间：上午9点至下午5点
                    <br>地点: 槟城Gurney酒店
                    <br>语言：中英
                    <br>*中间午休时午餐自理
                    <br><br>请向各自的团队领导报名。
                    <br>1. 全名
                    <br>2. MT4户口号码
                    <br>4. 手机号码
                    <br>5. 电邮信箱
                    <?php } else {  ?>
                    <br>Registration before 10th July 2013 (Ms Fion 0174000830)
                    <br>No of seats : 150 pax
                    <br>Please arrange your own PC or Tablet with MT4 installed
                    <br><br>
                    <br>Date 14th July 2013
                    <br>Time  9am to 5pm
                    <br><br>
                    <br>Venue Penang Gurney Hotel
                    <br>Medium English
                    <br>Note Meal not provide
                    <br><br>Please register with following details
                    <br>1 Name
                    <br>2 User ID
                    <br>3 MT4 No.
                    <br>4 Email
                    <br>5 Contact No.

                    <?php } ?>
                    <br>
                    <div class="news_date">
                    Posted on 9 July 2013
                    </div>

                    <div class="hr"></div>

                    <a href="#">
                        <?php if ($culture == "cn") {  ?>
                        <div class="poptitle"><h3>马胜金融讲座</h3><br>
                        <?php } else {  ?>
                        <div class="poptitle"><h3>Maxim Financial Seminar</h3><br>
                        <?php } ?>
                    </div>
                    </a>

                    <?php if ($culture == "cn") {  ?>
                    <br>由马胜特聘讲师兼亚洲著名金融分析师Mr. Daniel Ang为你讲解最新巿场走势与货币／贵金属交易的基本优势，幇肋你开拓新的投资视野。欢迎马胜伙伴帯新朋友来参与这知性之旅及探讨新商机。
                    <br><br>日期：2013年7月13日
                    <br>时间：晚上7时30分
                    <br>地点：槟城Gurney酒店
                    <br>语言：英为主，中为补
                    <?php } else {  ?>
                    <br>Maxim Consultant and Famous Asia Financial Analyst, Mr. Daniel Ang will be sharing with you the latest market outlook, basic advantages about precious metal/currency trading and broaden your investment prospective. All Maxim partners are welcome to invite new guests to participate and learn about new business opportunity.
                    <br><br>Date: 13 July 2013
                    <br>Time: 7:30pm
                    <br>Venue: Penang Gurney Hotel
                    <br>Medium: English

                    <?php } ?>
                    <br><br>Pls pledge your group seat with Miss Fion 0174000830 by 10 July before 5pm. Limited seat!!!
                    <br>
                    <div class="news_date">
                    Posted on 9 July 2013
                    </div>

                    <div class="hr"></div>


                    <!--+++++++++++++++++++++++++++++++++++++++++++++++++-->
                    <a href="/home/activities_26062013">
                        <?php if ($culture == "cn") {  ?>
                        <div class="poptitle"><h3>马胜金融：三赢策略「全球金融精明投资的前景＂概念、创新＂」</h3><br>
                        <?php } else {  ?>
                        <div class="poptitle"><h3>Maxim Trader : Three-Win Strategy [ Global Financial Savvy Investment Outlook The Concept of The Innovation ]</h3><br>
                        <?php } ?>
                    </div>
                    </a>

                    <?php if ($culture == "cn") {  ?>
                    <br>地点：Furama Hotel Bukit Bintang
                    <br>地址：136, Jalan Changkat Thambi Dollah, Bukit Bintang Kuala Lumpur.
                    <br>时间：上午7：30PM
                    <br>日期：26/06/2013  星期三
                    <br><br>
                    <br>马胜金融集团御用金融投资大师Mr.Daniel Ang(超过20年经验在金融经济市场)为您讲解当今的世界在变，天也已经变了，很多人受困于，对于新兴事物，第一看不见，第二看不起，第三看不懂，第四来不及，马胜金融三赢策略的概念，创新。
                    <br><br>
                    <br>请邀请您的朋友到来参与，当晚出席名额只限200位，请预早报名。
                    <br>请联系：Dennis Chai, +60122222305, +60108368888
                    <?php } else {  ?>
                    <br>Venue：Furama Hotel Bukit Bintang
                    <br>Address：136, Jalan Changkat Thambi Dollah, Bukit Bintang Kuala Lumpur.
                    <br>Time：7：30PM
                    <br>Date：26/06/2013  Wednesday
                    <br><br>
                    <br>Senior Invest Professor, Mr.Daniel Ang (who possessed 0ver 20years in Finance Investment)
will elaborate how the world and economic environments have changed, and are in the process. When it comes to newly sprouted things, many people would always find themselves in the following dilemmas:
<br>
<br>- They have problem identifying one when it firstly sprouts.
<br>- They look down upon on them.
<br>- They lack proper and specialized expertise to fully understand one even after identification.
<br>- They keep running behind and end up letting opportunities slip through their fingers.
<br>
<br>Come and know more about Maxim’s “Three-Win” strategy. We help you manage your wealth in a better way!
                    <br><br>
                    <br>Please invite your friend to attend together, the talk is free, but seat is limited (only 200 seats). Please register early as you can.
                    <br>Dennis Chai, +60122222305, +60108368888
                    <?php } ?>
                    <br>
                    <div class="news_date">
                    Posted on 26 June 2013
                    </div>

                    <div class="hr"></div>

                    <a href="/home/activitiesBusinessPreview">
                        <div class="poptitle"><h3>Maxim Trader - Business Preview</h3><br>
                    </div>
                    </a>
                    <br>
                    <div class="news_date">
                    June 2013 Activities.
                    </div>

                    <div class="hr"></div>

                    <a href="/home/activitiesShanghaiInternationalDinnerGathering">
                        <?php
                        $culture = $sf_user->getCulture();
                        ?>
                        <div class="poptitle">
                        <h3>马胜金融国际交流晚宴</h3>
                        <br>
                        </div>
                    </a>
                        <?php if ($culture == "cn") {  ?>
                        <br>亲爱的领导人及伙伴们：
                        <br><br>
                        <br>马胜金融集团非常荣幸地通知各位：为了表示对已经是我们尊贵伙伴和即将成为我们伙伴的各位贵宾的欢迎，公司将于6.1日晚举办一场国际晚宴.这将是一个让人难忘的夜晚, 因为有史以来您将第一次听到我们来自全球的伙伴们分享他们的人生经历与精彩故事.请各位于5.30号下午7点以前将参会人数报于各自的推荐人,以方便我们提前安排.
                        <br>晚宴地址: 湘鄂情(虹桥店)
                        <br>上海-湘鄂情-漕虹店
                        <br>地址：上海市徐汇区桂平路391号 （近漕宝路）
                        <br>新漕河泾国际商务中心
                        <br>C 座 2F 213- 214
                        <br>前台：02164857077
                        <br><br>
                        <br>日期：01-06-2013
                        <br>入席时间：下午6：30pm
                        <br><br>
                        <br>我们期待您的光临!
                        <?php } else {  ?>
                        <br>Dear Partners and Fellow Leaders, it gives us tremendous pleasure to organize a Maxim Trader Shanghai International Dinner Gathering on 1st June @ 6.30pm for our valued partners and potential partners to be. It will be a memorable night because for the first time ever, we will be able to hear testimonies and real life experiences from partners of different countries. Please let your leader know how many of you will be attending this dinner event before 30/5 @ 7pm
                        <br><br>Venue: Xiangeqing
                        <br>Shanghai - Xiangeqing - canal Rainbow Shop
                        <br>Address: Guiping Road, Xuhui District, No. 391 (near CaoBao) New Caohejing International Business Center
                        <br>Block C 2F 213 - 214
                        <br><br>
                        <br>Date :01-06-2013
                        <br>Time: 6:30 pm
                        <?php }  ?>

                        <br><br>
                        <br>P/S : 请在7pm点30-5-2013之前联系您的领导预订人数，座位有限，谢谢合作。
                        <br>



                    <br>
                    <div class="news_date">
                    Posted on 1 June 2013
                    </div>


                    <div class="hr"></div>

                    <a href="/home/activitiesShanghaiFudan">
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
                        <?php if ($culture == "cn") {  ?>
                        <br>马胜金融集团很荣幸地宣布我们即将于2013.6.2日参加由上海复旦大学传媒学院举办、且只接受邀请的金融研讨论坛!届时我们进一步了解复旦大学有关外汇市场交易的经典基金管理课程，并会与众学院教授、讲师以及学生们深度交流有关外汇交易领域的案例与经验。马胜金融集团受此邀请，无上荣誉。我们相信复旦的学生将会成长为中国未来新一代的商业领袖与企业家，我们也非常高兴能够在塑造学生思维方面贡献自己的一份力量！我们无限珍惜此次无价的荣誉！
                        <?php } else if ($culture == "jp") {  ?>
                        <br>Maxim Traderはフダン大学ジャーナリズム学院が主催した招待制金融フォーラムに招待されたことを報告します。今回の金融フォーラムは2013年6月2日上海にて行われ、参加者のこれまでに為替市場において提案したファンドマネジメントプログラムを共有し、大学の教員および生徒と為替市場の経験を議論する。Maxim traderはこの金融フォーラムに招待されたこと、更に中国の次世帯ビジネスリーダーや企業家となる生徒たちの思考力形成に貢献できることを、誇り高く感じ、無上な栄誉と考えっております。
                        <?php } else if ($culture == "kr") {  ?>
                        <br>맥심트레이더가 중국 상해 복단 저널리즘 대학교가 주관하는 금융포럼에 초청되었음을 기쁘게 알려드립니다.  이는 포렉스 분야의 자산 운용 프로그램의 전문 지식과 경험을 대학 교수, 부교수, 학생들과 공유하기 위해서입니다.  이러한 초청을 받는 다는 사실은 맥심으로서는 굉장한 특권이자 영광이며 미래의 비즈니스 리더이자 사업가가 될 학생들의 생각에 많은 영향을 미칠것이라 생각됩니다. 소중한 영예라고 확신힙니다.
                        <?php } else {  ?>
                        <br>We are proud to announce that Maxim Trader has been invited to participate in the invitation-only Financial Forum organized by The School of Journalism Fudan University, Shanghai, China on 2 June 2013 to share their dedicated fund management program on the foreign exchange market, as well as to discuss experiences in this field to the University Professors, Associates and students.   It is indeed a privilege and an honor for Maxim Trader  to receive such an invite and to be able to shape the thinking of these students who one day  will be the future business leaders and entrepreneurs of China. This is an invaluable accolade indeed.
                        <?php }  ?>

                    <br>
                    <div class="news_date">
                    Posted on 2 June 2013
                    </div>


                    <div class="hr"></div>

                    <a href="/home/activitiesShanghaiInvestmentManagement">
                        <?php
                        $culture = $sf_user->getCulture();
                        ?>
                        <div class="poptitle">
                        <?php if ($culture == "en") { ?>
                        <h3>2013 The 9th Shanghai Investment Management & Financial Expo</h3>
                        <?php } else if ($culture == "cn") {  ?>
                        <h3>2013上海第九届投资理财金融博览会</h3>
                        <?php } else if ($culture == "jp") {  ?>
                        <h3>上海フェアー 2013</h3>
                        <?php } else {  ?>
                        <h3>2013 The 9th Shanghai Investment Management & Financial Expo</h3>
                        <?php } ?>
                        <br>
                    </div>
                    </a>
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
                        <?php } else {  ?>
                        <br>Maxim Trader is pleased to announce that we have been invited to participate in the prestigious 9th Shanghai Investment Management & Financial Expo which will be held on 31 May 2013 - 2 June 2013 in West Hall Gate 2, Shanghai Everbright Convention & Exhibition Centre (SECEC) Address: No. 88 Caobao Road, Xuhui District, Shanghai (booth Number : A153, A155, A169 , A170 )
                        <br>住所 : 中国上海徐江区漕宝路88号，西館2号門
                        <?php } ?>

                    <br>
                    <div class="news_date">
                    31 May 2013 - 2 June 2013
                    </div>

                    <div class="hr"></div>

                    <a href="/home/activitiesFinancialMarketOutlook">
                        <div class="poptitle"><h3>Maxim Trader - Financial Market outlook and Business Preview</h3><br>
                    </div>
                    </a>
                        House Speaker: Mr Daniel Ang (International Financial Guru)
                    <br>
                    <div class="news_date">
                    May 2013 Activities.
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