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
    <style type="text/css">
    #popupContact {
        top: -100px !important;
    }

    .poptitle {
        color: #bc9c48;
        font-weight: bold;
        font-size: 16px
    }

    .poptitle:hover {
        color: #CCAD5A;
    }

    .popinfo1 {
        color: #333;
        font-size: 12px;
        padding: 0px 10px;
    }

    .popinfo2 {
        color: #000;
        font-weight: bold;
        font-size: 16px;
        background-color: #fbe91d;
        width: 500px;
    }

    .popdivider {
        border-top: 1px dotted #999;
        width: 100%;
        margin: 10px 0px;
    }

    .news_date {
        font-style: italic;
        font-size: 10px;
    }

    #backgroundPopup {
        display: none;
        position: fixed;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background: #000000;
        border: 1px solid #cecece;
        z-index: 100;
    }

    #popupContact {
        display: none;
        margin-top: 150px;
        padding-bottom: 150px;
        width: 500px;
        background: url(images/popbg.jpg) repeat-y #fff;
        border: 2px solid #999999;
        color: #333;
        z-index: 1000;
        font-size: 13px;
        padding: 5px 5px;
    }

#popupContact a{
	color:#CCAD5A;
	text-decoration:none;
}

#popupContact a:hover{color:#dabd71;}

    #popupContact h1 {
        text-align: center;
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        padding: 10px;
        margin-top: 0px;
        margin-bottom: 20px;
        background-color: #CCAD5A;
    }

    #popupContactClose, #popupContactClose2 {
        line-height: 14px;
        font-weight: 700;
        display: block;
        width: 80px;
        margin: auto;
        cursor: pointer;
        border: 1px solid #8ec1da;
        background-color: #ddeef6;
        border-radius: 4px;
        box-shadow: inset 0 1px 3px #fff, inset 0 -15px #cbe6f2, 0 0 3px #8ec1da;
        -o-box-shadow: inset 0 1px 3px #fff, inset 0 -15px #cbe6f2, 0 0 3px #8ec1da;
        -webkit-box-shadow: inset 0 1px 3px #fff, inset 0 -15px #cbe6f2, 0 0 3px #8ec1da;
        -moz-box-shadow: inset 0 1px 3px #fff, inset 0 -15px #cbe6f2, 0 0 3px #8ec1da;
        color: #3985a8;
        text-align: center;
        text-shadow: 0 1px #fff;
        padding: 5px 30px;
    }

    #button {
        text-align: center;
        margin: 100px;
    }


    .poptitle2 {
        color: #BC9C48;
        font-size: 13px;
        font-weight: bold;
        text-align: left;
    }

    .page_link {
        font-size: 14px;
    }

    .announcement_table p {
        line-height: 12px;
    }
    </style>
    <script type='text/javascript' src='/js/popup.js'></script>
	<script type="text/javascript">
    var annoucementArr = [];

/*annoucementArr.push({
    poptitle:'Implementation of System Generated Member ID',
    news_date:'19 MARCH 2013',
    news_desc:'<br><br>Due to the expansion of the company, to strengthen the protection of the privacy of member confidentiality, company has implemented auto generated member ID instead of input by member own self. <br><br>Start effective by today.'
});*/

/*
annoucementArr.push({
    poptitle:'CP2 convert to CP1 will get extra 5%',
    news_date:'27 MARCH 2013',
    news_desc:'<br>To all Concerned Member,<br><br>Please be informed that effective from 25th March 2013, <br><br>1.	CP2 convert to CP1 will get extra 5%<br>2.	CP3 convert to CP1 no longer to get extra 5%<br><br>Once again, thank you for your support.<br><br>Regards,<br>The Managements'});
*/

/*
annoucementArr.push({
    poptitle:'Today (24/4) 9pm Maxim Trader will stop using the existing server. ',
    news_date:'24 APRIL 2013',
    news_desc:'<br>Dear Valued member,  <br><br>Kindly be informed today (24/4) 9pm Maxim Trader will stop using the existing server. After 10pm company will start using newly upgraded server. <br><br>Please download new terminal & start using the new terminal from 10pm onwards using the existing login & same password. Therefore all must stop trading by 9pm at old server. No need close floating. Just stop trading by 9pm, start new terminal after 10pm. <br><br>The floating order will be synchronized to new terminal. <br><br>For downloading new mt4 terminal you may download the new link at <a href="http://www.maximtrader.com/trading-2/maxim-trader-metatrader-4/" target="_blank">http://www.maximtrader.com/trading-2/maxim-trader-metatrader-4/</a>. <br><br>Sorry for the inconvenience caused. Thank you. <br><br>'});
*/

<?php
$culture = $sf_user->getCulture();
$postfix = "_english";
if ($culture == "en")
        $postfix = "_english";
    else if ($culture == "jp")
        $postfix = "_english";
    else
        $postfix = "_chinese";
?>

annoucementArr.push({
poptitle:'INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)',
news_date:'8 JULY 2013',
news_desc:'<br><img width="460"  src="http://partner.maximtrader.com/images/email/IME_Poster_<?php echo $culture;?>.jpg" alt = "INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)‏"></a><br>'});
/*
annoucementArr.push({
    poptitle:'Investor Macau IME Promotion (August 2013)',
    news_date:'04 JUNE 2013',
    news_desc:'<div class="poptitle"><br>Due to POPULAR REQUEST from our Partners and Leaders...!!!  The company has relented to absolutely, positively, definitely extend the qualifying date for the LAST TIME. Macau IME FINAL Challenge Period will be extended till 30th June 2013. </div><br><br><div class="poptitle2">INVESTOR who sign up for:<br>$10K package - FOC 1 ticket to IME              <br>$20K package - FOC 1 ticket to IME plus airfare reimbursement (up to $500)<br><br>Additional Promotion:<br>$50K package - FOC 2 ticket to IME plus airfare reimbursement (up to $1000)<br><br>Regards,<br>Maxim Trader Information Department</div><br><img width="460" border="0" alt="Maxim Trader Incentive" src="/images/email/incentive_201304.jpg">'});
*/
/*annoucementArr.push({
    poptitle:'NOTICE!!!',
    news_date:'24 JUNE 2013',
    news_desc:'<div class="poptitle2"><strong>WITH IMMEDIATE EFFECT from 24th June 2013</strong>, the company will implement a new mandate that will allow ONLY 70% of initial deposit and its equivalent in MT4 credit points to be used for self directed trading with a variable of +-5%. The remaining 30% cannot be used as trading margin and the amount is to strictly WITHHOLD for fund management program.<br><br>From The Management<br><br></div>'});*/

<?php
if ($culture == "en") {

?>
/*annoucementArr.push({
    poptitle:'Investor Macau IME Promotion (August 2013)',
    news_date:'13 JUNE 2013',
    news_desc:'<br>Good News!<br>IME Early Bird Promotional has been extended to June 25th. Last chance to get your tickets at USD800 which is inclusive of 3 nights accommodation at the Venetian Hotel Macau, an evening with Jim Rogers on Aug 5th plus financial talks by industry leaders on Aug 6th. Go to members area now, click on IME registration to buy tickets for yourself and for your prospects<img width="460"  src="http://partner.maximtrader.com/images/email/MACAU-Incentive-en.jpg" alt = "Investor Macau IME Promotion (August 2013)‏"></a><br>'});*/

/*annoucementArr.push({
    poptitle:'I.M.E Macau Incentive challenge period has been extended till 31st May 2013',
    news_date:'22 MAY 2013',
    news_desc:'<div class="poptitle">Dear Member,<br><br>Great news! I.M.E. Macau Incentive challenge period has been extended till 31st May 2013. Don\'t miss this chance to qualify and be part of an event where partners of Maxim Trader the world over will gather to exchange views, to learn from each other and most importantly to share. What are you waiting for...... Go for it!!!<br><br>Regards,<br>Maxim Trader Information Department</div><br><img width="460" border="0" alt="Maxim Trader Incentive" src="/images/email/incentive_201304.jpg">'});*/

/*annoucementArr.push({
    poptitle:'2013 THE NINTH SHANGHAI INVESTMENT MANAGEMENT FINANCIAL EXPO',
    news_date:'8th MAY 2013',
    news_desc:'<br><img width="460"  src="http://partner.maximtrader.com/images/email/Shanghai_Money_Fair_Announcement_A4-01.jpg" alt = "2013 THE NINTH SHANGHAI INVESTMENT MANAGEMENT FINANCIAL EXPO‏"></a><br>'});*/

/*annoucementArr.push({
    poptitle:'Superb News!!!',
    news_date:'8th MAY 2013',
    news_desc:'<br>Maxim Trader is pleased to announce a reduction of the CP3 Withdrawal handling fee from USD60 to USD30 effective from 8th MAY 2013. <br><br>Thank you.<br><br><br><br><br><br>'});*/
/*
annoucementArr.push({
    poptitle:'Maxim Trader Presenting The Newly Upgraded MT4',
    news_date:'18 APRIL 2013',
    news_desc:'<br><a href="http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe" target="_blank"><img width = "460"  src = "http://partner.maximtrader.com/images/email/Maxim-Trader-Announcement-201304-01.jpg" alt = "Maxim Trader Presenting The Newly Upgraded MT4‏"></a><br><a href="http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe" target="_blank"><img width = "460"  src = "http://partner.maximtrader.com/images/email/Maxim-Trader-Announcement-201304-02.jpg" alt = "Maxim Trader Presenting The Newly Upgraded MT4‏"></a>'});
*/

/*annoucementArr.push({
    poptitle:'Owning to the terms as stipulated by Forex world, please provide us your documents!!!',
    news_date:'18 MARCH 2013',
    news_desc:'<br><br>Dear our distinguished member,<br><br>Thank you for your support and faith in us!<br><br>Owning to the terms as stipulated by Forex world, please provide us your documents:<br><br>1)      Identification (IC / Passport, front and back at same page)<br><br>2)      Proof of Address (Bank / Credit Card statement, OR Water / Electric statement, OR Phone / Internet statement)<br><br>-          Your name, current address and the date of the latest 3 months must be shown at the statement.<br><br>3)      Download and sign the Forex Agreements.<br><br>And upload all the documents at website.<br><br>Note:<br><br>Click "<a href="/member/viewProfile" target="_self" style="color: #3333ff;">User Profile</a>" to upload all the documents at "Upload Document".<br><br>Thank you for your highly cooperation.<br><br>Wish you all the best.'});*/
<?php } else if ($culture == "kr") {  ?>
/*annoucementArr.push({
poptitle:'Investor Macau IME Promotion (August 2013)',
news_date:'13 JUNE 2013',
news_desc:'<br>좋은 소식을 전해드립니다.<br>IME 부지런한 새 프로모션이 마지막으로 6월 25일 까지로 연장되었습니다.  마카오의 베네시안 호텔에서의 3박과 8월 5일 짐 로저스와의 저녁 대화의 시간과 이 분야의 리더들과의 금융관련 대화를 포함한 티켓을 800달러에 구입할 수 있는 마지막 기회입니다.  홈 페이지에서 멤버스(회원) 페이지로 가셔서 IME 등록을 클릭하시면 본인과 귀한 분들을 위한 티켓을 구입할 수 있습니다<img width="460"  src="http://partner.maximtrader.com/images/email/MACAU-Incentive-en.jpg" alt = "Investor Macau IME Promotion (August 2013)‏"></a><br>'});*/
/*annoucementArr.push({
    poptitle:'I.M.E 마카오 인센티브 도전 기간이 2013년 5월 31일로 연장되었습니다',
    news_date:'22 MAY 2013',
    news_desc:'<div class="poptitle">Dear Member,<br><br>대단한 소식입니다!  I.M.E 마카오 인센티브 도전 기간이 2013년 5월 31일로 연장되었습니다.  이 기회를 놓치지 마시고 자격을 충족시켜 맥심 트레이더의 전세계 파트너들이 서로 모여 비젼을 나누고 있고 서로에게서 배우고 함께 할 수 있는 이벤트에 참석하시기 바랍니다.  무엇을 기다리고 계십니까?  파이팅하십시요!!!<br><br>Regards,<br>Maxim Trader Information Department</div><br><img width="460" border="0" alt="Maxim Trader Incentive" src="/images/email/incentive_201304.jpg">'});*/


/*annoucementArr.push({
    poptitle:'2013 THE NINTH SHANGHAI INVESTMENT MANAGEMENT FINANCIAL EXPO',
    news_date:'8th MAY 2013',
    news_desc:'<br><img width="460"  src="http://partner.maximtrader.com/images/email/Shanghai_Money_Fair_Announcement_A4_Korean-01.jpg" alt = "2013 THE NINTH SHANGHAI INVESTMENT MANAGEMENT FINANCIAL EXPO‏"></a><br>'});*/

/*annoucementArr.push({
    poptitle:'Superb News!!!',
    news_date:'8th MAY 2013',
    news_desc:'<br>Maxim Trader is pleased to announce a reduction of the CP3 Withdrawal handling fee from USD60 to USD30 effective from 8th MAY 2013. <br><br>Thank you.<br><br><br><br><br><br>'});*/

<?php } else if ($culture == "jp") {  ?>
/*annoucementArr.push({
    poptitle:'Investor Macau IME Promotion (August 2013)',
    news_date:'13 JUNE 2013',
    news_desc:'<br>Good News!<br>IME Early Bird Promotional has been extended to June 25th. Last chance to get your tickets at USD800 which is inclusive of 3 nights accommodation at the Venetian Hotel Macau, an evening with Jim Rogers on Aug 5th plus financial talks by industry leaders on Aug 6th. Go to members area now, click on IME registration to buy tickets for yourself and for your prospects<img width="460"  src="http://partner.maximtrader.com/images/email/MACAU-Incentive-en.jpg" alt = "Investor Macau IME Promotion (August 2013)‏"></a><br>'});*/

/*annoucementArr.push({
    poptitle:'IMEマカオチャレンジ奨励期間は2013年5月31日まで延長と決定',
    news_date:'22 MAY 2013',
    news_desc:'<div class="poptitle">Dear Member,<br><br>ニュース：IMEマカオチャレンジ奨励期間は2013年5月31日まで延長と決定！！世界中のMaxim Traderパートナーが集め、意見を交換し、互いに学びそして経験を共有するこのチャンスを是非見逃すことなく、ご参加ください！<br><br>Regards,<br>Maxim Trader Information Department</div><br><img width="460" border="0" alt="Maxim Trader Incentive" src="/images/email/incentive_201304.jpg">'});*/

/*annoucementArr.push({
    poptitle:'最新ニュース！',
    news_date:'8th MAY 2013',
    news_desc:'<br>マシンムトレーダーのCP3口座からの出金手数料は今までの$60から$30に引き下げられました。よろしくお願いいたします。<br><br><br><br><br><br>'});*/

/*annoucementArr.push({
    poptitle:'2013年 第九回 上海投資理財金融博覧会',
    news_date:'8th MAY 2013',
    news_desc:'<br><img width="460"  src="http://partner.maximtrader.com/images/email/Shanghai_Money_Fair_Announcement_A4_Japanese-01.jpg" alt = "2013年 第九回 上海投資理財金融博覧会‏"></a><br>'});*/

<?php } else {  ?>
/*annoucementArr.push({
    poptitle:'Investor Macau IME Promotion (August 2013)',
    news_date:'13 JUNE 2013',
    news_desc:'<br>好消息!<br>很高兴的告诉大家: 马胜IME早起鸟计划截止日期已被延至6.25日. 此次活动我们为您提供澳门威尼斯人度假村酒店4天3夜住宿安排, 8.5日晚由国际著名的吉姆.罗杰斯(Jim Rogers)先生带来的独家讲座,以及8.6日由众多业界精英领袖们共同参与的金融研讨会. 这一切的费用只需要800美金, 且这将是您最后享此优惠的机会! 马上进入马胜官网会员专区, 点击IME字样注册购买, 为了您和您的美好未来投资吧! <img width="460"  src="http://partner.maximtrader.com/images/email/MACAU-Incentive-cn.jpg" alt = "Investor Macau IME Promotion (August 2013)‏"></a><br>'});*/
/*annoucementArr.push({
    poptitle:'挑战IME激励计划的截止期限已被延期至2013.5.31日',
    news_date:'22 MAY 2013',
    news_desc:'<div class="poptitle">Dear Member,<br><br>好消息！挑战IME激励计划的截止期限已被延期至2013.5.31日. 请千万不要错过这个机会千载难逢的机会：来自世界各地的马胜金融集团伙伴们会齐聚一堂，交流观念、互相学习，更重要的是会分享各自的经验！您还在等什么呢？加油吧！<br><br>Regards,<br>Maxim Trader Information Department</div><br><img width="460" border="0" alt="Maxim Trader Incentive" src="/images/email/incentive_201304.jpg">'});*/

/*annoucementArr.push({
    poptitle:'2013 THE NINTH SHANGHAI INVESTMENT MANAGEMENT FINANCIAL EXPO',
    news_date:'8th MAY 2013',
    news_desc:'<br><img width="460"  src="http://partner.maximtrader.com/images/email/Shanghai_Money_Fair_Announcement_A4-01.jpg" alt = "2013 THE NINTH SHANGHAI INVESTMENT MANAGEMENT FINANCIAL EXPO‏"></a><br>'});*/

/*annoucementArr.push({
    poptitle:'好消息!!!',
    news_date:'8th MAY 2013',
    news_desc:'<br>马胜金融集团欣然宣布从2013年5月8日起CP3提款手续费将从60美元减少至30美元<br><br>Thank you.<br><br><br><br><br><br>'});*/


/*
annoucementArr.push({
    poptitle:'马胜金融诚意呈现最新升级版MT4平台',
    news_date:'18 APRIL 2013',
    news_desc:'<br><a href="http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe" target="_blank"><img width = "460"  src = "/images/email/Chinese_Maxim_Trader_Announcement_Ad_A4_pg1.png" alt = "Maxim Trader Presenting The Newly Upgraded MT4‏"></a><br><a href="http://files.metaquotes.net/maxim.capital.limited/mt4/maxim4setup.exe" target="_blank"><img width = "460"  src = "/images/email/Chinese_Maxim_Trader_Announcement_Ad_A4_pg2.png" alt = "Maxim Trader Presenting The Newly Upgraded MT4‏"></a>'});
*/

/*annoucementArr.push({
    poptitle:'由于外汇的要求严谨，请上载您的文件',
    news_date:'18 MARCH 2013',
    news_desc:'<br><br>您好。<br><br>由于外汇的要求严谨，请您将您的文件包括：<br><br>1） 身份证（正反面在同一页）<br><br>2） 地址证明（银行/信用卡明细单，或水/电明细单，或电话/网络明细单）<br><br>-          明细单必须清楚列明您的姓名，目前住址及最近3个月日期。<br><br>3） 下载并签署外汇合约。<br><br>上传给公司，否则这会影响您日后的提现。<br><br>注：点击”<a href="/member/viewProfile" target="_self" style="color: #3333ff;">用户个人资料</a>“将所有文件上传给公司（点击"上传文件"）。<br><br>谢谢您的鼎力合作。<br><br>祝：一切顺利'});*/
<?php } ?>


/*annoucementArr.push({
    poptitle:'Apply EzyCash Card Now!!!',
    news_date:'20 FEB 2013',
    news_desc:'<br><br><a target="_self" href="/member/applyEzyCashCard"><img width="460" border="0" alt="Maxim Trader" src="/images/email/apply_ezycash_card_debit_card.png"></a>Start from today Maxim Trader clients may <a href="/member/applyEzyCashCard" style="color: #3333ff;">apply an EzyAccount</a> anytime.<br><br>EzyAccount is an extremely secure and convenient way for you to send and receive money from Maxim Trader.'
});*/

/*annoucementArr.push({
    poptitle:'Maxim Trader Incentive For February 2013 - Bangkok March Workshop (BMW) 马胜金融集团 2013年二月奖励计划 - 曼谷投资检讨会 2013年2月インセンティブ·プラン - バンコク投資レビュー',
    news_date:'18 FEB 2013',
    news_desc:'<br><br><a href="#"><img width="460" border="0" alt="Maxim Trader" src="/images/email/Bangkok_March_Workshop.jpg"></a><br>'
});*/
/*annoucementArr.push({
    poptitle:'Maxim Trader to participate in the 10th CHINA GUANGZHOU INTERNATIONAL INVESTMENT AND FINANCE EXPO 第十届广州国际投资理财金融博览会 2013年3月5-7日',
    news_date:'21 FEB 2013',
    news_desc:'<br><br><a target="_blank" href="#"><img width="460" border="0" alt="Maxim Trader" src="/images/email/maxim_international<?php echo $postfix;?>.jpg"></a><br>'
});*/

var popIndex = 1;
	$(function() {
        //loadContent(popIndex);
        <?php
        $tempDisable = true;
        if ($tempDisable == true && $sf_user->getAttribute(Globals::FIRST_TIME_POP_UP, true) == true) {
            $sf_user->setAttribute(Globals::FIRST_TIME_POP_UP, false)
        ?>
        centerPopup();
        loadPopup();
        <?php } ?>
        $(".page_link").click(function(event){
            event.preventDefault();
            $(".page").hide();
            $("#page_" + $(this).attr("ref")).show(500);
        });
        $("#popupContactClose,#popupContactClose2,#backgroundPopup").click(function(){
            disablePopup();
            //if ($(annoucementArr).length > popIndex) {
            /*if (popIndex == 1) {
                popIndex++;
                $(".page").hide();
                $("#page_" + popIndex).show(500);
                //loadContent(popIndex);
                centerPopup();
                loadPopup();
            }*/
        });
        <?php
        //if ($sf_user->getAttribute(Globals::FIRST_LOGIN, 0) == 0) {
        ?>
        //PAGE OPENING ANIMATION
        /*jQuery('#page').css({'display':'inline','width':'300px','overflow':'hidden','margin-right':'340px'});
        jQuery('#sidebar').css({'margin-left':'326px'});

        jQuery('#sidebar').delay(800).animate({'margin-left':'0px'},2100);
        jQuery('#page').delay(800).animate({'margin-right':'0px','width':'666px'},2100);*/
        <?php
            //$sf_user->setAttribute(Globals::FIRST_LOGIN, 1);
        //} else {
        ?>
            jQuery('#sidebar').css({'margin-left':'0px'});
            jQuery('#page').css({'display':'inline','width':'666px','overflow':'hidden','margin-right':'0px'});
        <?php
        //}
        ?>

        $("#linkLatestNews").click(function(event){
            event.preventDefault();
            centerPopup();
            loadPopup();
        });
	});
    function loadContent(popIndex) {
        var obj = annoucementArr[popIndex -1];
        $(".poptitle").html(obj.poptitle);
        $(".news_date").html(obj.news_date);
        $(".news_desc").html(obj.news_desc);
    }
        //centering popup
    function centerPopup(){
        //request data for centering
        var windowWidth = document.documentElement.clientWidth;
        var windowHeight = document.documentElement.clientHeight;
        var popupHeight = $("#popupContact").height();
        var popupWidth = $("#popupContact").width();
        //centering
        $("#popupContact").css({
            "position": "absolute",
            "top": windowHeight/3-popupHeight/2,
            "left": windowWidth/3-popupWidth/2,
            "margin-left": windowWidth/3-popupWidth/2
        });
        //only need force for IE6

        $("#backgroundPopup").css({
            "height": windowHeight
        });

    }
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

            <?php include_component('component', 'multiLanguage', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
            <div class="qtrans_widget_end"></div>
            <div style="clear:both;"><br></div>

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
            <div class="hr2"></div>
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
                    "autoScale": true
                });
            });
            </script>
            <p><iframe width="560" height="315" src="//www.youtube.com/embed/QBAn1YhZ-QI?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe></p>
            <div class="hr2"></div>
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/christmas.jpg"><img width="582" src="/images/christmas.jpg" alt="" title="Merry Christmas & Happy New Year" class="aligncenter size-full wp-image-162"></a></p>
            <div class="hr2"></div>
            <?php if ($culture == "cn") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/cn_shanghai_fair_banner.jpg"><img width="582" src="/images/cn_shanghai_fair_banner.jpg" alt="" title="SHANGHAI FAIR" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "kr") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/kr_shanghai_fair_banner.jpg"><img width="582" src="/images/kr_shanghai_fair_banner.jpg" alt="" title="SHANGHAI FAIR" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "jp") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/en_shanghai_fair_banner.jpg"><img width="582" src="/images/en_shanghai_fair_banner.jpg" alt="" title="SHANGHAI FAIR" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/en_shanghai_fair_banner.jpg"><img width="582" src="/images/en_shanghai_fair_banner.jpg" alt="" title="SHANGHAI FAIR" class="aligncenter size-full wp-image-162"></a></p>
            <?php } ?>
            <div class="hr2"></div>
            <?php if ($culture == "cn") {?>
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/email/IME_5speakers_13.07.2013_C.jpg"><img width="582" src="/images/email/IME_5speakers_13.07.2013_C.jpg" alt="" title="IME MACAU @ 2013" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "kr") {?>
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/email/IME_5speakers_13.07.2013_K.jpg"><img width="582" src="/images/email/IME_5speakers_13.07.2013_K.jpg" alt="" title="IME MACAU @ 2013" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "jp") {?>
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/email/IME_5speakers_13.07.2013_J.jpg"><img width="582" src="/images/email/IME_5speakers_13.07.2013_J.jpg" alt="" title="IME MACAU @ 2013" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else {?>
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/email/IME_5speakers_13.07.2013_E.jpg"><img width="582" src="/images/email/IME_5speakers_13.07.2013_E.jpg" alt="" title="IME MACAU @ 2013" class="aligncenter size-full wp-image-162"></a></p>
            <?php } ?>
            <div class="hr2"></div>
            <div id="banner">
                <ol class="slides" style="position: relative; overflow: hidden;">
                    <li class="slide-content hide"
                        style="position: absolute; top: 0px; z-index: 6; opacity: 1; display: none; width: 582px; height: 212px;">
                        <a target="_self" href="<?php echo url_for("/member/applyDebitCard") ?>">
                        <div class="slide-content"
                             style="background:#f6f7f6 url('/css/maxim/banner/bg8.jpg') left top no-repeat;width:582px;height:212px;">
                        </div>
                        </a>
                    </li>

                    <li class="slide-content hide"
                        style="position: absolute; top: 0px; left: -941px; z-index: 6; opacity: 1; display: block; width: 941px; height: 450px;">
                        <div class="slide-content slide-temp-1">
                            <div class="slide-bg">
                                <img src="/css/maxim/banner/bg1.png">
                            </div>
                            <div class="slide-main">
                                <img src="/css/maxim/banner/bg1-word.png"
                                     alt="We are MAXIM. A worldwide leader in currency trading.">
                            </div>
                            <div class="slide-tc">
                            </div>
                        </div>
                    </li>

                    <!--<li class="slide-content hide"
                        style="position: absolute; top: 0px; left: 0px; z-index: 7; opacity: 1; display: none; width: 941px; height: 1215px;">
                        <p style="display:none;"></p>
                        <link type="text/css" rel="stylesheet" href="/css/maxim/g3bo.css">
                        <div id="g3boBody">
                            <div id="g3boContent">
                                <h3 style="color: #FFFFFF;"><?php /*echo __('Maxim Trader') */?></h3>

                                <p style="color:#26272A;font-size: 1.2em;line-height:130%; padding-right: 20px"><?php /*echo __('The smart investors choice for managing funds and guaranteeing satisfaction!') */?></p>
                                <p>
                                <a title="open a trial account" href="/member/register"
                                   class="g3boButton"><?php /*echo __('OPEN AN ACCOUNT NOW') */?><img
                                        src="/css/maxim/button arrow.png"
                                        alt=""></a>
                            </div>
                        </div>-->
                        <!--<div id="flashContent">
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
                                <param value="sameDomain" name="allowScriptAccess">-->
                                <!--[if !IE]>-->
                                <!--<object width="940" height="405" type="application/x-shockwave-flash"
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
                                    <param value="sameDomain" name="allowScriptAccess">-->
                                    <!--<![endif]-->
                                    <!--<img
                                        src="/css/maxim/G3BO_HomepageSlideshow_Background.jpg"
                                        alt="">--> <!--[if !IE]>-->
                        <!--</object>-->
                                <!--<![endif]-->
                        <!--</object>
                        </div>
                        <div class="altImage">
                            <img src="/css/maxim/G3BO_HomepageSlideshow_Background.jpg" alt="">

                            </div>
                    </li>-->

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
<!--            <a href="--><?php //echo url_for("/home/maximExecutor")?><!--"><p><img width="582" height="184" src="/css/maxim/banner/banner-08.jpg" alt="" title="MAXIMTRADE EXECUTOR™" class="aligncenter size-full wp-image-162"></p></a>-->
            <p><img width="582" height="184" src="/css/maxim/banner/banner-08.jpg" alt="" title="MAXIMTRADE EXECUTOR™" class="aligncenter size-full wp-image-162"></p>

            <strong><?php echo __('Maxim Trader') ?></strong> <?php echo __('has worked out a structured investment which addresses most of the problems investors facing today.') ?>
            <!--<a href="<?php /*echo url_for("/home/investment")*/?>" style="color: #0080C8"><?php /*echo __('Learn more') */?> ?</a>-->

            <!--<div class="hr2"></div>
            <a href="<?php /*echo url_for("/home/maximExecutor")*/?>"><p><img width="582" height="184" src="/css/maxim/banner/bg2.png" alt="" title="MAXIMTRADE EXECUTOR™" class="aligncenter size-full wp-image-162"></p></a>-->

            <!--^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^-->
            <!--<div class="hr2"></div>
            <div class="one_half"><span class="medium_image"
                                        style="float: left; margin-bottom: 10px; margin-right: 20px;"><a class=""><img
                    style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-1.png" alt=""
                    height="128" width="272"></a></span> <strong>Professional Trading Team</strong>
                At  Trader, we have a professional team of traders that have over
                10 years of experience dealing mainly in the Forex market. <a
                        href="<?php /*echo url_for("/home/company")*/?>" style="color: #0080C8">Learn more ?</a></div>
            <div class="one_half_last"><span class="medium_image"
                                             style="float: left; margin-bottom: 10px; margin-right: 20px;"><a
                    class=""><img style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-3.png"
                                  alt="" height="128" width="272"></a></span> <strong>Investment Report</strong>
                We estimate that Maxim Trader investment portfolios have outperformed
                the benchmark over the past 12 months with an overall +205.92% gain. <a
                        href="<?php /*echo url_for("/home/investment")*/?>" style="color: #0080C8">Learn more ?</a></div>
            <span class="vspace"></span>-->

            <!--<div class="one_half"><span class="medium_image"
                                        style="float: left; margin-bottom: 10px; margin-right: 20px;"><a class=""><img
                    style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-4.png" alt=""
                    height="128" width="272"></a></span> <strong>Market Analysis</strong>
                Our goal is to provide investors with an investment opportunity that is
                as safe as possible and at the same time maximizing your potential
                earnings. <a href="<?php /*echo url_for("/home/investment")*/?>">Learn more ?</a></div>
            <div class="one_half_last"><span class="medium_image"
                                             style="float: left; margin-bottom: 10px; margin-right: 20px;"><a
                    class=""><img style="visibility: visible; opacity: 1;" src="/css/maxim/small-img-2.png"
                                  alt="" height="128" width="272"></a></span> <strong>Spot a Golden Opportunity</strong>
                Investing in a Forex financial tool such as XAUUSD (gold against the
                American dollar) can secure the gold reserve of your funds. <a
                        href="<?php /*echo url_for("/home/investment")*/?>">Learn more ?</a></div>-->

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
                <?php include_component('component', 'homeLeftMenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0), 'showLink' => 'Y')) ?>
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

<!--- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --->
<!--- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --->
<!--- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ --->
<!--- aside end --->
<!--- content --->
<div class="areaContent" style="display: none;">
    <div class="resultsWrap">

    </div>
    <div class="clear"></div>

    <div class="resultsViewer">
        <form action="/member/activateMember" method="post" id="memberForm">
<!--            <input type="hidden" id="distributorId">-->

            <div style="padding: 10px; top: 30px; width: 98%">

                <div class="portlet">
                    <div class="portlet-header"><?php echo __('Announcements') ?></div>
                    <div class="portlet-content">
                        <table class="display" id="datagridAnnouncement" border="0" width="100%" cellpadding="0"
                               cellspacing="0">
                            <thead>
                            <tr>
                                <th>Announcement Id[hidden]</th>
                                <th><?php echo __('Title') ?></th>
                                <th width="25%"><?php echo __('Date') ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="dgActivateMember" title="<?php echo __('Activate Member') ?>" style="display:none;">
    <input type="hidden" id="dgActivateMember_ecash">
    <input type="hidden" id="dgActivateMember_pointAvail"/>
    <table cellspacing="5" cellpadding="3">
        <tr>
            <td class="text" width="30%"><label><?php echo __('Member ID') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgActivateMember_shareholderId"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Full Name') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgActivateMember_alias"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Registered Time') ?></label></td>
            <td>:</td>
            <td><input type="text" disabled="disabled" id="dgActivateMember_registeredTime"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Package Type') ?></label></td>
            <td>:</td>
            <td>
                <select name="dgActivateMember_point" id="dgActivateMember_point"
                        class='text ui-widget-content ui-corner-all'>

                </select>
                <input type="text" disabled="disabled" id="dgActivateMember_pointNeeded"
                       class="text ui-widget-content ui-corner-all" size="10px"/>
            </td>
        </tr>
        <tr style="display: none">
            <td class="text"><label><?php echo __('Payment Type') ?></label></td>
            <td>:</td>
            <td>
                <span id="spanPaymentType">
                    <input type="radio" id="paymentTypeEPoint" name="paymentType" value="epoint"/><label for="paymentTypeEPoint"><?php echo __('CP1') ?></label>
                    <input type="radio" id="paymentTypeECash" name="paymentType" value="ecash"/><label for="paymentTypeECash"><?php echo __('MT4 Credit') ?></label>
                </span>
            </td>
        </tr>
        <tr>
            <td class="text"><label><?php echo __('Security Password') ?></label></td>
            <td>:</td>
            <td><input type="password" id="dgActivateMember_transactionPassword"
                       class="text ui-widget-content ui-corner-all"/></td>
        </tr>
    </table>
</div>

<div id="dgAnnouncement" title="<?php echo __('Announcements') ?>" style="display:none;">
    <table cellspacing="5">
        <tr>
            <td class="text" id="tdAnnouncement"></td>
    </table>
</div>

<!--####################################################################################################-->
<!--####################################################################################################-->
<!--####################################################################################################-->
<!--####################################################################################################-->

<script type="text/javascript">
$(document).ready(function() {
    /*
     *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
     */
    $('.fancybox-fittoview').fancybox({
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
<div style="position: absolute; display: none;" id="popupContact">
    <h1><?php echo __('Latest News') ?></h1>
    <a id="popupContactClose"><?php echo __('CLOSE') ?></a>

    <p id="contactArea">
        <!--<img src='http://www.abfxtrader.com/ablive/nimages/site/eidalfitr-2012.jpg' />-->
    </p>

    <div class="popdivider"></div>

    <?php
    $culture = $sf_user->getCulture();
    //foreach ($announcements as $announcement) { ?>
    <div class="popinfo1">
        <table width="100%">
            <tr>
                <td align="center">
                    <a href='#' class="page_link" ref='1'>1</a> - <a href='#' class="page_link" ref='2'>2</a> - <a href='#' class="page_link" ref='3'>3</a> - <a href='#' class="page_link" ref='4'>4</a> - <a href='#' class="page_link" ref='5'>5</a> - <a href='#' class="page_link" ref='6'>6</a> - <a href='#' class="page_link" ref='7'>7</a> - <a href='#' class="page_link" ref='8'>8</a> - <a href='#' class="page_link" ref='9'>9</a> - <a href='#' class="page_link" ref='10'>10</a>
                </td>
            </tr>
        </table>

        <div id="page_1" class="page">
            <div class="poptitle">
                10th March 2014 Annual Extravaganza Dinner & Dance @ Sunway Pyramid Convention Centre, Kuala Lumpur, Malaysia
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "08 JANUARY 2014";
                ?>
            </div>
            <div class="news_desc">
                <br>Dear Leaders and Partners, Maxim Capital Limited is pleased to confirm that our 1st Annual Extravaganza Dinner & Dance will be held in the fun city of Sunway Pyramid Convention Centre, Kuala Lumpur, Malaysia during March 9th to 12th. Proudly, we will be booking the entire hotel and on the 10th, our Gala Dinner and Dance promises to be an historical event with celebrities and dignitaries from the world over.
                <br>For more details and other arrangements, please contact our Corporate Events Executive Ms Catherine +60 10 465 3832
                <br>
                <br>亲爱的领导人或伙伴们：
                <br>马胜金融集团非常荣幸地告诉大家马胜第一届庆祝年会将会于2014.3.9日-3.12日在马来西亚吉隆坡著名城市Sunway 之Pyramid会展中心举行!我们很自豪地将会包下整个场馆酒店,且10号晚上会隆重举行马胜大型庆祝晚宴会-届时将会各国要人代表云集,群星璀璨,大家共同见证这一历史时刻!
                <br>如欲了解更多详情与安排,请联系公司活动组织官Catherine +60 10 465 3832
                <br>
                <br>パートナーやリーダ達へ、マキシム・キャピタル・リミテッドは３月９日から１２日までにマレイシア・クアラルンプール市のSunway Pyramid Convention Centre（サンウェイピラミッドコンベンションセンター）という賑やかな都会で1st Annual Extravaganza Dinner & Dance（第１回豪華ディナー＆ショー）を開催することになりました。我々は自慢なことにホテル全室を貸し切っており、そして１０日に世界各地からのセレブリティやお偉方が参加される弊社主催のガラディナー＆ダンスが歴史的なイベントに変身することをお約束致します。
                <br>
                <br>친애하는 리더와 파트너 여러분, 맥심 캐피탈이 우리의 첫 엑스트라베간자 디너 및 댄스가 말레. 이시아 쿠알라룸푸르의 선웨이 피라미드 컨벤션 센터의 펀 시티에서 9일에서 12일에 열리게 되었음을 기쁘게 알려드립니다 당사는 10일 호텔 전체를 예약하여 우리의 갈라 디너와 댄스가 전 세계적으로 역사적인 축제행사가 될 수 있게 할 것입니다.
                <br>더 자세한 상항과 행사 예약에 관하여서는 당사의 행사 담당인 캐서린에게 +60 10 465 3832로 연락하시기 바랍니다.
            </div>
        </div>

        <div id="page_2" class="page" style="display: none">
            <div class="poptitle">
                IMPORTANT ANNOUNCEMENT!!!
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "04 JANUARY 2014";
                ?>
            </div>
            <div class="news_desc">
                <br>End of Promo - CP2 to CP1 extra 5%
                <br>
                <br>Dear Partners and Leaders,
                <br>To kick off 2014 on a positive note, we are pleased to announce on the promotion of extra 5% for transferring from CP2 to CP1 will be end on 2359hrs of January 14.
                <br>say YES TO MAXIM TRADER... !!!
                <br>
                <br>优惠结束-CP2转CP1优惠5%
                <br>
                <br>亲爱的领导人与伙伴们：
                <br>为了迎接2014新年，我们很高兴地通知大家-公司CP2转CP1享额外5%的优惠政策之截止日期为2014.1.14日23:59分。
                <br>
                <br>确认马胜说:YES!!!
                <br>
                <br>キャンペーン期限のお知らせ－CP2からCP1に変換する際に５％増しパートナーやリーダー達へ、
                <br>２０１４年度を新年早々から明るく突っ走るために、CP2からCP1に変換する際に５％増しキャンペーンの期限を１月１４日から数えて２３５９時間までとすることを弊社の方でお知らせ致します。
                <br>Maxim Trader（マキシム・トレーダー）にエールを。。。！！！
                <br>
                <br>마지막 프로모션 - CP2에서 CP1 추가 5% 친애하는 파트너와 리더분들,  밝아오는 새해를 맞이하여 CP2에서 CP1으로 전환시킬경우 추가 5% 프로모션 기간이 1월 14일 오후 11시 59분까지로 연장되었음을 기쁘게 알려드립니다. 맥심에게 예스라고 합시다!!!
                <br>
            </div>
        </div>
        <div id="page_3" class="page" style="display: none">
            <div class="poptitle">
                NEW GTS FUNDING INSTRUCTION - MAXIM CAPITAL LIMITED
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "25 DECEMBER 2013";
                ?>
            </div>
            <div class="news_desc">
                <?php
                if ($culture == "kr") {
                ?>
                <table style="border-collapse:collapse;border:1px solid rgb(0,0,0)" border="0" cellspacing="0"
                       width="99%">
                    <tbody>
                    <tr>
                        <th colspan="2"
                            style="color:rgb(0,0,0);font-weight:bold;background-color:rgb(221,221,221);text-align:left;padding:3px 7px;border:1px solid rgb(170,170,170);background-repeat:initial initial">
                            Poland (USD)
                        </th>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="30%">
                            은행:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="69%">MBank (Formerly known as BRE Bank)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" colspan="2">지점 은행</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">주소:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">00-95 Warsaw, ul. Krolewska 14,
                            skr. Poczt. 728
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            계좌번호:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">계좌명:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            Global Transaction Services (UK)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">IBAN:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">PL39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">스위프트 코드 (SWIFT BIC):</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">BREXPLPWWA1</td>
                    </tr>
                    </tbody>
                </table>
                <?php
                } else if ($culture == "cn") {
                ?>
                <table style="border-collapse:collapse;border:1px solid rgb(0,0,0)" border="0" cellspacing="0"
                       width="99%">
                    <tbody>
                    <tr>
                        <th colspan="2"
                            style="color:rgb(0,0,0);font-weight:bold;background-color:rgb(221,221,221);text-align:left;padding:3px 7px;border:1px solid rgb(170,170,170);background-repeat:initial initial">
                            Poland (USD)
                        </th>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="30%">
                            银行名称:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="69%">MBank (Formerly known as BRE Bank)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">银行所在城市:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">00-95 Warsaw, ul. Krolewska 14,
                            skr. Poczt. 728
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            银行帐户号码:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">银行账户持有人:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            Global Transaction Services (UK)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">IBAN:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">PL39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">银行代码:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">BREXPLPWWA1</td>
                    </tr>
                    </tbody>
                </table>
                <?php
                } else if ($culture == "jp") {
                ?>
                <table style="border-collapse:collapse;border:1px solid rgb(0,0,0)" border="0" cellspacing="0"
                       width="99%">
                    <tbody>
                    <tr>
                        <th colspan="2"
                            style="color:rgb(0,0,0);font-weight:bold;background-color:rgb(221,221,221);text-align:left;padding:3px 7px;border:1px solid rgb(170,170,170);background-repeat:initial initial">
                            Poland (USD)
                        </th>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="30%">
                            銀行名:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="69%">MBank (Formerly known as BRE Bank)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" colspan="2">銀行支店</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">住所:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">00-95 Warsaw, ul. Krolewska 14,
                            skr. Poczt. 728
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            口座番号:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">受取人:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            Global Transaction Services (UK)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">IBAN:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">PL39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Swiftコード:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">BREXPLPWWA1</td>
                    </tr>
                    </tbody>
                </table>
                <?php
                } else {
                ?>
                <table style="border-collapse:collapse;border:1px solid rgb(0,0,0)" border="0" cellspacing="0"
                       width="99%">
                    <tbody>
                    <tr>
                        <th colspan="2"
                            style="color:rgb(0,0,0);font-weight:bold;background-color:rgb(221,221,221);text-align:left;padding:3px 7px;border:1px solid rgb(170,170,170);background-repeat:initial initial">
                            Poland (USD)
                        </th>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="30%">
                            Bank:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" width="69%">MBank (Formerly known as BRE Bank)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)" colspan="2">Account Holding Branch:</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Address:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">00-95 Warsaw, ul. Krolewska 14,
                            skr. Poczt. 728
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            Account No:
                        </td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">Account Name:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">
                            Global Transaction Services (UK)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">IBAN:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">PL39114010105240009120028849</td>
                    </tr>
                    <tr>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">SWIFT BIC:</td>
                        <td style="padding:3px 7px;border:1px solid rgb(170,170,170)">BREXPLPWWA1</td>
                    </tr>
                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
        <div id="page_4" class="page" style="display: none">
            <div class="poptitle">
                IMPORTANT ANNOUNCEMENT!!!
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "23 DECEMBER 2013";
                ?>
            </div>
            <div class="news_desc" style="text-align:left">
                <br>
                Holiday Trading and Support Hours 马胜金融集团恭祝您节日快乐,新年新气象
                <br><br>

                <div dir="ltr"><p class="MsoNormal"><span lang="EN-US">Dear Member,<br>
                    </span><span lang="ZH-CN" style="font-family:宋体">亲爱的会员：</span><span lang="EN-US"><br>
                    <br>
                    The team at Maxim Trader wish you a Happy Holiday Season and a Prosperous New
                    Year.&nbsp;<br>
                    </span><span lang="ZH-CN" style="font-family:宋体">马胜金融集团恭祝您节日快乐，新年新气象！</span><a name="1431d92baa15c48b__GoBack"></a></p>

                    <p class="MsoNormal"><span lang="EN-US"><h2>Market and Customer Support Opening Times* 以下是公司市场及客户服务时间</h2></span></p>

                    <p class="MsoNormal"><span lang="EN-US">*All times are listed in MT4 Server Time
                    (GMT + 2 hours)</span></p>

                    <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">所有时间均按照</span><span lang="EN-US">MT4</span><span lang="ZH-CN" style="font-family:宋体">服务器时间（</span><span lang="EN-US">GMT+2</span><span lang="ZH-CN" style="font-family:宋体">）</span></p>


                    <table border="1" cellpadding="0" class="announcement_table" width="630" style="width:360pt;border:1pt solid rgb(204,204,204)">
                     <tbody><tr>
                      <td style="border:none;background-color:rgb(204,204,204);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Date</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">日期</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(204,204,204);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">&nbsp;</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(204,204,204);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">FX Trading Hours</span></p>
                      <p class="MsoNormal"><span lang="EN-US">FX</span><span lang="ZH-CN" style="font-family:宋体">交易时间</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(204,204,204);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Metals Trading Hours</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">贵金属交易时间</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(204,204,204);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Customer Support Hours</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">客户服务时间</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">24th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.24</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Tuesday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期二</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">01:00 - 20:00</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">25th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.25</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Wednesday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期三</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">26th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.26</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Thursday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期四</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">01:05 - 23:59</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">07:00 - 23:59</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">27th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.27</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Friday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期五</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">28th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.28</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Saturday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期六</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">29th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.29</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Sunday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期日</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">30th December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.30</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Monday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期一</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">31st December</span></p>
                      <p class="MsoNormal"><span lang="EN-US">12.31</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Tuesday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期二</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">01:00 - 20:00</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">1st January</span></p>
                      <p class="MsoNormal"><span lang="EN-US">1.1</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Wednesday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期三</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">CLOSED</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">关闭</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">2nd January</span></p>
                      <p class="MsoNormal"><span lang="EN-US">1.2</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Thursday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期四</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">01:05 - 23:59</span></p>
                      </td>
                      <td style="border:none;background-color:rgb(235,235,235);padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">01:05 - 23:59</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                     <tr>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">3rd January</span></p>
                      <p class="MsoNormal"><span lang="EN-US">1.3</span><span lang="ZH-CN" style="font-family:宋体">日</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Friday</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">星期五</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                      <td style="border:none;padding:7.5pt">
                      <p class="MsoNormal"><span lang="EN-US">Open</span></p>
                      <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">开放</span></p>
                      </td>
                     </tr>
                    </tbody></table>

                    <p class="MsoNormal"><span lang="EN-US">&nbsp;<br>
                    <br>
                    </span></p>

                    <p class="MsoNormal"><span lang="EN-US"><h2>Low Liquidity / Widened Spreads 低流动性 / 被扩大的利差</h2></span></p>

                    <p class="MsoNormal"><span lang="EN-US">Please note that spreads may be wider and
                    there may be increased volatility in the market as fewer liquidity providers
                    offer prices during this time.<br>
                    </span><span lang="ZH-CN" style="font-family:宋体">友情提醒：由于更少的流动性报价，因此此段时间利差会被扩大，<wbr>从而可能导致市场波动幅度加大。</span><span lang="EN-US"><br>
                    <br>
                    <br>
                    Clients should make sure their accounts are adequately capitalised as these
                    conditions can impact even fully hedged positions.</span></p>

                    <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">客户应该时刻注意并保证您的账户里资金充足，<wbr>因为这些因素甚至会影响完全对冲头寸。</span><span lang="EN-US"><br>
                    <br>
                    <br>
                    Kind regards,</span></p>

                    <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">敬上</span></p>

                    <p class="MsoNormal"><span lang="EN-US"><br>
                    The Maxim Trader Team</span></p>

                    <p class="MsoNormal"><span lang="ZH-CN" style="font-family:宋体">马胜金融集团</span></p></div>
            </div>
        </div>
        <div id="page_5" class="page" style="display: none;">
            <div class="poptitle">
                IMPORTANT ANNOUNCEMENT!!!
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "23 OCTOBER 2013";
                ?>
            </div>
            <div class="news_desc" style="text-align:left">
                <br>
                IMPORTANT ANNOUNCEMENT!!!
                <br><br>

                Maxim Trader D&D 2014:
                <br>
                <br>
                Dear Partners, here is your chance to qualify for our Annual Dinner & Dance which will he held in Bangkok, Thailand in February 2014.
                <br>* Purchase 10k - receive 4 days/3 nights Accommodations (Twin Sharing Basis) in 5 Star Hotel
                <br>* Purchase 20k - receive 4 days/3 nights Accommodations (Twin Sharing Basis) in 5 Star Hotel plus Air Ticket (Reimbursement up to 500CP)
                <br>** Personal Sales of 40k (till December 31) will receive 4 days/3 nights Accommodations (Twin Sharing Basis) in 5 Star Hotel plus Air Ticket (Reimbursement up to 500CP)
                <br>
                <br>Qualifying period: October 22, 2013 to December 31, 2013
                <br>Nb. Tickets are Non-Transferable
                <br>
                <br>HURRY, be amongst the elite to qualify for a limited number of seats for our Annual Dinner & Dance 2014.
                <br>
                <div class="popdivider"></div>
                <br>
                <br>亲爱的伙伴们：
                <br>
                <br>以下是有关参加马胜金融集团2014.2月份泰国曼谷年度庆祝晚宴的具体通知-
                <br>
                <br>*购买10k美金配套-可获得泰国曼谷5星级酒店4天/3夜豪华住宿安排（双人间）
                <br>
                <br>*购买20k美金配套-可获得泰国曼谷5星级酒店4天/3夜豪华住宿安排（双人间）
                <br>
                <br>                                    并额外享受往返机票福利 (高达500CP)
                <br>
                <br>**个人销售业绩达到40k美金- 可享受泰国曼谷5星级酒店4天/3夜豪华住宿安排（双 人间）
                <br>
                <br>                                    并额外享受往返机票福利 (高达500CP)
                <br>
                <br>结算（考核）日期：2013.10.22-2013.12.31日
                <br>
                <br>注：此次活动参加资格不给转让他人
                <br>
                <br>名额有限。快点行动，成为参加此次马胜年度庆祝晚宴精英中的一员吧！
                <br>
                <div class="popdivider"></div>
                <br>
                <br>공지사항입니다.
                <br>
                <br>맥심 트레이더 D&D 2014:
                <br>
                <br>파트너 여러분들, 2014년 2월 태국 방콕에서 열릴 디너와 댄스 축제 참석 자격 요건입니다.
                <br>*만불 구매 - 5성급 호텔에서의 3박 4일 숙박권 (2인 1실)
                <br>* 이만불 구매 - 5성급 호텔에서의 3박 4일 숙박권 (2인 1실)과 비행기 티켓 (500cp 까지 보상해드립니다)
                <br>** 개인 매출 사만불 (12월 31일까지) 달성시 5성급 호텔에서의 3박 4일 숙박권 (2인 1실)과 비행기 티켓 (500cp 까지 보상해드립니다)
                <br>
                <br>자격 요건 달성 기간 : 2013년 10월 22일부터 2013년 12월 31일까지
                <br>참고 : 비행기 티켓은 환불 불가합니다.
                <br>
                <br>2014 디너와 댄스 파티의 자리는 한정되어 있습니다.  서두르셔서 자리를 확보하시기 바랍니다.
                <br>
                <div class="popdivider"></div>
                <br>
                <br>パートナーの皆様、
                <br>下記は 来年2014年2月 マキシム 年度晩餐会in Thailand バンコクの連絡事項。
                <br>
                <br>* 1万USDのパッケージの購入者- 晩餐会の招待 + 5星のホテル3泊4日の宿泊費(2人1部屋)
                <br>
                <br>* 2万USD以上のパッケージの購入者- 晩餐会の招待 + 5星のホテル3泊4日の宿泊費(2人1部屋) + バンコクまで往復航空券 ($500 まで 会社負担)
                <br>
                <br>** 直接紹介で4万USD以上の売り上げがある ナビゲーターの方には-晩餐会の招待 + 5星のホテル3泊4日の宿泊費(2人1部屋) + バンコクまで往復航空券 ($500 まで 会社負担)
                <br>
                <br>対象期間: 2013年10月22日~2013年12月31日まで。
                <br>注意事項: 参加資格は第三者に譲渡不可。
                <br>
                <br>皆様、バンコクでまたお会いできること心から願っております。
            </div>
        </div>
        <div id="page_6" class="page" style="display: none">
            <div class="poptitle">
                IMPORTANT ANNOUNCEMENT!!!
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "4 OCTOBER 2013";
                ?>
            </div>
            <div class="news_desc" style="text-align:left">
                <br>
                IMPORTANT ANNOUNCEMENT!!!
                <br><br>Please be informed that effective 1st October 2013, pending order placement will be disabled 1 hour earlier prior to the US NFP news release at 8:30 EDT and will be made available 2 hours after the news release.
            </div>

            <div class="popdivider"></div>

            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "6 SEPTEMBER 2013";
                ?>
            </div>
            <div class="news_desc" style="text-align:left">
                <br>
                IMPORTANT ANNOUNCEMENT!!!
                <br><br>To ensure security and to prevent unauthorized entry into your Maxim Account, please update, change and use a "stronger" password of between 8-32 characters: Use a combination of Capital letters, Small letters, 0-9 and underscore (_) only and must include at least one letter and one number.
                <br><br>NB1. At least eight characters long
                <br>NB2. Does not contain your user name, real name or company name.
                <br>NB3. Does not contain a complete word
                <br><br>PROTECT YOUR ACCOUNT, PROTECT YOUR MAXIM ASSET.
                <br>
                <br>
                <span style="font-family: 宋体">
                重要提醒!!!!
                <br>
                <br>为了确保您的账户安全，杜绝无授权登录行为，马胜金融集团友情提醒您尽快登录个人账户，升级您的账户密码安全级别，并将其更改至由8-32位符号组成的密码。请只组合使用大写英文字母、小写英文字母、0-9的数字，下划线等符号，且新密码必须含最少包含一个字母与一个数字。
                <br>
                <br>规则一：密码最少长度为8个符号
                <br>规则二：请不要使用您的账户名、真实姓名或公司名称
                <br>规则三：请不要包含一个完整的单词。
                <br>
                <br>保护您的账户, 保证您的资产安全!
                </span>
                <br>
                <br>
                <br>重要発表！
                <br><br>セキュリティおよびあなたのマキシムアカウントに不正侵入を防ぐために、8-32文字の"より安全な"パスワードに変更するように更新してください：アルファベットの大文字、小文字、数字の0～9、そしてアンダースコア（_）を使用してください。更に、少なくともアルファベット文字一つと数字を1つ含める必要があります。
                <br><br>1.少なくとも8文字
                <br>2.ユーザー名、本名、または会社名が含まれない。
                <br>3. 完全な単語を使用しない。
                <br><br>アカウントを守りましょう！、あなたのMAXIM資産を守りましょう！！
                <br>よろしくお願いいたします。
            </div>
        </div>
        <div id="page_7" class="page" style="display: none">
            <div class="poptitle">
                Q3 Champions Challenge
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "25 AUGUST 2013";
                ?>
            </div>
            <div class="news_desc">
                <br>
                SUPER ANNOUNCEMENT for those Registered for Q3 Challenge 2013. In addition to the many great prizes already up for grabs, it gives us tremendous pleasure to throw in a Rolex Air King for anyone and everyone that achieves a personal sales of USD200K. For those who have not registered but would like to participate, you have till August 31st to do so. Your  cumulative personal sales from August 5th to Sept 30th will be captured for the Q3 Challenge. Go For It !!! GOOD LUCK & GOOD HUNTING MAXIMers !!!!
                <br>
                <br>
                <span style="font-family: 宋体">
                超级好消息!!!
                <br>
                特告知所有报名参加第三Q3季度冠军挑战计划的伙伴们：在原有奖励计划基础上，马胜金融集团决定额外奖励每一位个人销售业绩达到二十万美金（USD200,000）的伙伴将获公司赠送名贵瑞士劳力士Rolex Air King 系列手表一只！尚未报名参加第三Q3季度冠军挑战计划的伙伴们在2013.8.31日前依然可以报名参加。公司将根据您从2013.8.5日至9.30日的个人累积销售业绩做出评判。我们期待您的参与，加油吧！
                <br>
                祝您旗开得胜，盆满钵满！
                </span>

                <br>
                <br>
                New. 2013년 삼분기 등록을 하신 분들을 위한 수퍼 발표입니다.  이미 발표된 많은 상에 추가로, 개인매출 200,000불을 달성한 모든 분들에게 로렉스 에어 킹을 드립니다.  아직 등록하지 않으신 분들은 8월 31일까지 기회가 있습니다.  8월 5일부터 9월 30일까지 누적된 개인매출이 삼분기 도전에 사용됩니다.  파이팅하십화이.  행운을 빌며, 맥심인으로 최선을 다하십시오
            </div>
        </div>
        <div id="page_8" class="page" style="display: none">
            <div class="poptitle">
                Q3 Champions Challenge - BMW 5 Series
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "4 AUGUST 2013";
                ?>
            </div>
            <div class="news_desc">
                <br>
                <a class="fancybox-fittoview" data-fancybox-group="thumb" href="/uploads/activities/q3_champions_challenge.jpg"><img width="460"  src="/uploads/activities/q3_champions_challenge.jpg" alt = "Q3 Champions Challenge - BMW 5 Series‏"></a><br>
            </div>
        </div>
        <!--<div id="page_2" class="page" style="display: none">
            <div class="poptitle">
                WHEEL OF FORTUNE
            </div>
            <div class="news_date">
            <?php
/*                $dateUtil = new DateUtil();
                echo "4 AUGUST 2013";
                */?>
            </div>
            <div class="news_desc">
                <a class="fancybox-fittoview" data-fancybox-group="thumb" href="/uploads/activities/wheel_of_fortune.jpg"><img width="460"  src="/uploads/activities/wheel_of_fortune.jpg" alt = "WHEEL OF FORTUNE‏"></a><br>
            </div>
        </div>-->
        <div id="page_9" class="page" style="display: none">
            <div class="poptitle">
                INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "8 JULY 2013";
                ?>
            </div>
            <div class="news_desc">
                <br><img width="460"  src="http://partner.maximtrader.com/images/email/Maxim_IME_Poster.jpg" alt = "INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)‏"></a><br>
            </div>
        </div>
        <div id="page_10" class="page" style="display: none">
            <div class="poptitle">
                INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "8 JULY 2013";
                ?>
            </div>
            <div class="news_desc">
                <br><img width="460"  src="http://partner.maximtrader.com/images/email/IME_Poster_<?php echo $culture;?>.jpg" alt = "INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)‏"></a><br>
            </div>
        </div>
    <div class="popdivider"></div>
    </div>
    <?php //} ?>
    <p></p>
    <a id="popupContactClose2"><?php echo __('CLOSE') ?></a><br>
</div>
<div style="height: 572px; opacity: 0.7; display: none;" id="backgroundPopup"></div>

</body>
</html>