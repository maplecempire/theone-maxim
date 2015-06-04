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
    .chinese_font {
        font-family : "Microsoft YaHei" !important;
    }
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
        width: 650px;
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
        //centerPopup();
        <?php if ($distributor->getNormalInvestor() == "N") { ?>
        loadPopup();
        <?php } ?>
        <?php } ?>
        $(".page_link").click(function(event){
            event.preventDefault();
            //$(".page").hide();
            $("#page_" + $(this).attr("ref")).toggle(500);
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
            //centerPopup();
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
<!--            <p><iframe width="560" height="315" src="//www.youtube.com/embed/QBAn1YhZ-QI?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe></p>-->
<!--            <div class="hr2"></div>-->

            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201412/news_2.jpg"><img src="/images/201412/news_2.jpg" alt="" title="MAXIM FINAL CHALLENGE 2014" class="aligncenter size-full wp-image-162"></a></p>
            <div class="hr2"></div>

            <?php if ($culture == "kr") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201412/news_1_kr.jpg"><img src="/images/201412/news_1_kr.jpg" alt="" title="SINGAPORE CONVENTION 2015" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "jp") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201412/news_1_jp.jpg"><img src="/images/201412/news_1_jp.jpg" alt="" title="SINGAPORE CONVENTION 2015" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201412/news_1.jpg"><img src="/images/201412/news_1.jpg" alt="" title="SINGAPORE CONVENTION 2015" class="aligncenter size-full wp-image-162"></a></p>
            <?php } ?>
            <div class="hr2"></div>

            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201410/shanghai_money_fair.jpg"><img width="582" src="/images/201410/shanghai_money_fair.jpg" alt="" title="SHANHAI MONEY FAIR" class="aligncenter size-full wp-image-162"></a></p>
            <div class="hr2"></div>
            
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201406/chengdu_money_fair.jpg"><img width="582" src="/images/201406/chengdu_money_fair.jpg" alt="" title="CHENGDU MONEY FAIR" class="aligncenter size-full wp-image-162"></a></p>
            <div class="hr2"></div>

            <?php if ($culture == "cn") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201403/sys-cn.gif"><img width="582" src="/images/201403/sys-cn.gif" alt="" title="SINGAPORE YACHT SHOW 2014" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "kr") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201403/sys-kr.gif"><img width="582" src="/images/201403/sys-kr.gif" alt="" title="SINGAPORE YACHT SHOW 2014" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else if ($culture == "jp") {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201403/sys-en.gif"><img width="582" src="/images/201403/sys-en.gif" alt="" title="SINGAPORE YACHT SHOW 2014" class="aligncenter size-full wp-image-162"></a></p>
            <?php } else {?>
                <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201403/sys-en.gif"><img width="582" src="/images/201403/sys-en.gif" alt="" title="SINGAPORE YACHT SHOW 2014" class="aligncenter size-full wp-image-162"></a></p>
            <?php } ?>
            <div class="hr2"></div>

            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201403/dubai_banner.jpg"><img width="582" src="/images/201403/dubai_banner.jpg" alt="" title="MENA 13TH FOREX SHOW MANAGED FUNDS & INVESTMENT OPPOTUNITIES" class="aligncenter size-full wp-image-162"></a></p>
            <div class="hr2"></div>
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/banner4.jpg"><img width="582" src="/images/banner4.jpg" alt="" title="Maxim Trader Annual Convention" class="aligncenter size-full wp-image-162"></a></p>
<!--            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/christmas.jpg"><img width="582" src="/images/christmas.jpg" alt="" title="Merry Christmas & Happy New Year" class="aligncenter size-full wp-image-162"></a></p>-->
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
            <p><a class="fancybox-thumbs" data-fancybox-group="thumb" href="/images/201403/most_trusted_forex_company.jpg"><img width="582" src="/images/201403/most_trusted_forex_company.jpg" alt="" title="The most trusted Forex Company Award By JRJ .COM" class="aligncenter size-full wp-image-162"></a></p>
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
<div style="position: absolute; display: none; position: absolute; left: 30%; margin-left: -50px;" id="popupContact">
    <h1><?php echo __('Latest News') ?></h1>
    <a id="popupContactClose"><?php echo __('CLOSE') ?></a>

    <table width="100%">
            <tr>
                <td align="center">
                    <strong><?php echo __("Click on each title for more details")?></strong>
                </td>
            </tr>
        </table>
    <p id="contactArea">
        <!--<img src='http://www.abfxtrader.com/ablive/nimages/site/eidalfitr-2012.jpg' />-->
    </p>

    <div class="popdivider"></div>

    <?php
    $culture = $sf_user->getCulture();
    //$isFmc = in_array($sf_user->getAttribute(Globals::SESSION_LEADER_ID), array(60, 682));
    $isFmc = false;
    if ($sf_user->getAttribute(Globals::SESSION_DISTID) == 139
            || $sf_user->getAttribute(Globals::SESSION_DISTID) == 682
            || $sf_user->getAttribute(Globals::SESSION_DISTID) == 276722
            || $sf_user->getAttribute(Globals::SESSION_DISTID) == 301955
            || $sf_user->getAttribute(Globals::SESSION_DISTID) == 1504) {

    } else {
        $distDB = MlmDistributorPeer::retrieveByPK($sf_user->getAttribute(Globals::SESSION_DISTID));

        if (strrpos($distDB->getTreeStructure(), "|1504|") === false) {
            if (strrpos($distDB->getTreeStructure(), "|61|") === false) {
                if (strrpos($distDB->getTreeStructure(), "|257250|") === false) {
                    $isPeter1 = strrpos($distDB->getTreeStructure(), "|15|");
                    if ($isPeter1 === false) { // note: three equal signs
                        $isLadyConquer = strrpos($distDB->getTreeStructure(), "|269293|");
                        if ($isLadyConquer === false) { // note: three equal signs
                            $isVivian = strrpos($distDB->getTreeStructure(), "|682|");
                            if ($isVivian === false) { // note: three equal signs
                                $pos = strrpos($distDB->getTreeStructure(), "|60|");
                                if ($pos === false) { // note: three equal signs

                                } else {
                                    $isFmc = true;
                                }
                            }
                        }
                    } else {
                        $isFmc = true;
                    }
                }
            }
        }
    }
    //foreach ($announcements as $announcement) { ?>
    <div class="popinfo1">

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='71'>Annoucement</a><img src="/images/new_icon.gif">
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "04 June 2015";
                ?>
            </div>

            <div id="page_71" class="news_desc" style="text-align: left;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Shareholders,
<br>
<br>We are pleased to inform all shareholders that our group of company RGF has on the 2nd June 2015 successfully acquired shareholding of the single largest stakeholder of ASX Top 200 Australian Public Listed Company: Citigold Corp Ltd (www.Citigold.com) which is an Australian gold mining company with operations based at Charters Towers in north eastern Australia. Citigold hold's all of the high grade Charters Towers goldfield where a Mineral Resource of 11,000,000 ounces of gold (342 tonnes) at an average grade of 14g/t gold has been defined (25 million tonnes @ 14g/t gold) and documented, to JORC (Joint Ore Reserves Committee) Code reporting standards at current reserve value at approximately USD11Billion. Our reserve value is USD1.28Billion and shall be injected into ROGP once we have finalize the corporate exercise.
<br>
<br>Thank you.
<br>The Management.
<br>
<br>股东们，大家好！
<br>
<br>在此我们非常荣幸地向大家宣布: 皇家控股集团旗下RGF有限公司已成功入股澳大利亚金城矿业集团（CITIGOLD) 成为该集团第一大股东。金城公司(www.Citigold.com)是一家澳大利亚黄金开采公司，是澳大利亚交易所ASX排名前200的一家上市公司；运营部设在澳大利亚东北部的查特斯堡。公司为一成长型公司，其目标为通过扩大黄金开采业务实现现金流量的不断增长。查特斯堡金银矿是一个独特的矿脉系统，在澳大利亚为品味最高的金矿之一。随着对查特斯堡矿体的深入研究，查特斯堡项目现在进入了发展和产能提升阶段，这将使生产水平得到显著提高。 金城拥有全部查特斯堡高品位的金矿区，矿区内有平均品味为14克黄金/吨的1100,0000盎司(342吨)的黄金矿产资源，已根据JORC(矿石储量联合委员会)规范的报告标准进行定义(2500,0000吨，14克/吨 金)及文件编制。该矿区储备价值高达110亿美金。其中我们占股拥有的储备价值达12.8亿美金，我们将尽快完成相关手续，将此部分入注皇家控股集团！
<br>
<br>谢谢！
<br>公司管理层
                            
                            <br>
                            <br>
                            <img src="/images/email/932c47aeff3c55351a26764c2dcf666d.jpg" alt="" style="width:610px;">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
<div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='70'>Super Share Swap -SSS Note</a><img src="/images/new_icon.gif">
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "11 May 2015";
                ?>
            </div>

            <div id="page_70" class="news_desc" style="text-align: left;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear International Member,
<br>
<br>THE RULES ON SUPER SHARE SWAP
<br>
<br>1.	Share swap available to Maxim members
<br>
<br>As a result of popular requests from members, the following is open to Maxim members who have completed a minimum of 12 months under the Maxim Investment Package which is also open to members who are going to reach 18 months maturity soon:
<br>
<br>i.	You may convert your investment, capital plus the remaining unearned Performance Returns (CP3) till the maturity date, into ROGP shares (R-Shares) at promotional price of USD80 cents. Please note this is open only during the period from 12 to 31 May 2015.
<br>
<br>ii.	Once you decide to swap your Maxim investment to R-Shares, you may continue to promote Maxim business and you will still be entitled to earn the bonuses in the usual manner as offered by our referral programs in Maxim ie. Direct Referral Bonus and Development Bonus. You will enjoy this benefit for a further 18 months from your upcoming date of 18 months maturity.
<br>
<br>iii.	Upon conversion to R-Share, your higher member base will be able to enjoy a one time development bonus in Maxim.
<br>
<br>iv.	If you do not already have your AGL account, when you elect to share swap, your R-shares will be automatically credited into an AGL S4 wallet and you may access them with your existing Maxim user ID and password. However if you wish to do AGL business, you will have to open your own AGL account.
<br>
<br>2.	Members who have just renewed their contract
<br>
<br>Members who have just renewed their contract for another 18 months will have to wait for a minimum of 12 months before they can qualify for the share swap plan.
<br>
<br>3.	Other options upon reaching maturity
<br>
<br>If you do not want to select the R-Share swap plan, once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. We therefore recommend that you go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns.
<br>
<br>4.	Shortfall in the MT4 account
<br>
<br>If you decide to renew your existing Maxim package and if your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
<br>
<br>5.	Non-renewal of contract
<br>For any reason, if you wish not to renew your contract AND do not wish participate in the share swap plan, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to maturity@maximtrader.com. Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
<br>
<br>6.	Six months exclusion
<br>
<br>Please note if you decide not to renew your contract, you are not allowed to re-join Maxim Trader for a period of 6 months after the maturity date.
<br>
<br>7.	Members with the same user ID
<br>
<br>Please note that Maxim members who have more than one package under the same user ID will need to renew all the packages as and when they fall due, in order to be entitled to bonuses offered by Maxim’s referral programs and enjoy monthly performance returns. If anyone one of the packages are not renewed, all the remaining packages under the same user ID will cease to earn any referral and development bonus.
<br>
<br>8.	Please email to maturity@maximtrader.com if you need further clarifications.
<br>
<br>Thank you,
<br>
<br>Dr. Andrew Lim
<br>Chief Executive Officer
<br>Maxim Capital Limited
<br>
<br>
<br>
<br>2015.5.11日
<br>
<br>
<br>尊敬的国际会员,
<br>股票转换规则公告
<br>
<br>1. 马胜会员股票转换选择
<br>
<br>基于市场的强烈要求, 已于马胜金融集团投资长达12个月或以上的投资会可以拥有以下转换选择; 该转换选择也向18个月投资周期即将结束的会员开放:
<br>
<br>i.	您可以选择将投资本金以及尚未实现的投资分红利润(CP3)以0.8美金一股的价格转换成ROGP股票。该转换期限仅限于2015.5.12日至5.31日。
<br>
<br>ii.	一旦您决定将您的马胜投资转换成R股, 您仍然可以继续发展您的马胜事业, 享受系统的奖金制度，即直接推荐奖和组织奖。在您合同原到期日之外, 公司特额外再赠送18个月的账户有效时间。
<br>
<br>iii.	如果您选择了将投资转换成R股, 您的直接推荐人将会于马胜系统内再获得一次组织奖金。
<br>
<br>iv.	如果您尚未激活AGL账户，当您选择转换时，系统会自动将等额的S4股票数额放置于您的S4账户; 您可以使用同一账户ID及密码登陆AGL系统。如果您希望开展AGL事业，您也是需要有自己的账户的。
<br>
<br>2.	针对已经续约投资合同的会员
<br>
<br>已经续约第二个18各月投资合同的客户必须在第二个合同也已达到12个月的情况下才符合转换条件。
<br>
<br>3.	投资合同到期时的其他选择
<br>
<br>如果您不愿意选择R股转换计划，那么当您合同投资到期不续约时，您不能继续享受推荐奖金以及组织奖金。因此，我们建议您合同到期时，在网站提示处选择“续约”选项，以便您在再次享受每月投资分红的同时，可以继续享受系统的奖金制度。
<br>
<br>
<br>4.	MT4余额低于初始本金
<br>
<br>如果您的MT4余额低于您的初始入金，我们建议您充值至初始本金额度  以继续享受由公司市场推荐制度产生的推荐奖金及投资分红。如果您未在合同到期日之前充值，您的账户将在合同到期日之后被暂时搁置，直到您充值至初始本金额度。一旦账户额度达到初始本金额度，您将重新开始享受推荐奖金及每月投资分红。
<br>
<br>5.	不继续合同
<br>
<br>如果您个人决定不再继续合同，请于公司网站会员专区选择“不再续期”选项。请按照要求填写“合同不再续期”表格并邮件至maturity@maximtrader.com. 您MT4账号中最后的余额（合同到期届时，投资本金等同于MT4交易账户中的最后余额），将会在合同到期日后14天之内转入您的CP3账户。公司会将您CP2与CP3款项全部支付给您，之后您的个人账户将会从系统中注销，因此您将不再享受马胜市场推荐制度所带来的任何获利。
<br>
<br>6.	6个月不得重新加入
<br>
<br>如果您选择终止合同，公司严格规定6个月之内您将不得再次投资马胜，敬请遵守。
<br>
<br>7.	一个账户ID内拥有多个配套的会员
<br>
<br>请留意: 如果会员在一个账户ID内拥有多个投资配套，若会员需要继续享受推荐奖金或组织奖金，会员需要续约所有的配套; 如果有任一配套没有续约而被终止，那么该账户将不再继续享受任何推荐奖或组织奖。
<br>
<br>8.	欲知更多详情，欢迎邮件至maturity@maximtrader.com.
<br>
<br>谢谢!
<br>
<br>Dr. Andrew Lim
<br>马胜资本有限公司首席执行官
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>2015년 5월 11일
<br>
<br>전환 공지
<br>
<br>1.	맥심 트레이더  회원에게 제안하는 주식전환 기회
<br>
<br>회원들의 요청에 의해, 맥심 투자 패키지에 최소 12개월 예치 완료한 맥심 트레이더 회원을 대상으로 다음과 같은 옵션을 제안할 것입니다. 이번 제안은 또한 곧 18개월 만료가 되는 회원에게도 열려 있습니다.
<br>
<br>i.	귀하는 현재 만료일까지의 수당지급 (CP3)을 더한 투자금을 ROGP (R-Share)로 전환할 수 있으며, 가격은 USD80센트입니다. 본 제안은 2015년 5월 12일부터 31일까지만 가능합니다.
<br>
<br>ii.	귀하의 맥심 투자금을 R-주식으로 전환을 결정하시면, 맥심 비즈니스를  계속하게 되어, 직접 소개 수당 및 개발 수당과 같은 맥심의 소개 보너스를 예전과 같이 받을 수 있는 자격은 유지됩니다. 귀하는 다가오는 계약 만료일부터 18개월 동안 더 이러한 혜택을 받을 수 있습니다.
<br>
<br>iii.	R-주식으로 전환하면, 귀하의 업라인은 한차례 맥심 개발 수당 혜택을 받을 수 있습니다.
<br>
<br>iv.	AGL 계좌를 가지고 있지 않으면, 주식 스왑시, 귀하의 R-주식은 자동으로 AGL S4 지갑으로 이전되고, 귀하는 현재의 ID와 패스워드로 여기에 접근할 수 있습니다. 그럼에도 불구하고 AGL 사업진행을 원하시면 , AGL 계좌를 오픈해야 합니다.
<br>
<br>2.	계약을 최근 갱신한 회원
<br>
<br>최근18개월 연장을 갱신한 회원은 주식전환 자격 취득을 위해 최소 12개월을 기다려야 합니다.
<br>
<br>3.	만료일에 대한 다른 옵션
<br>
<br>만약 만기일 도래시 위의 R-주식 전환을 원치 않으면,  맥심 소개 및 투자 수당 프로그램이 상실됩니다.  이에 따라 당사는 웹사이트로 가서 ‘갱신’ 옵션을 선택하시기를 권장합니다.  갱신하면 당사의 소개 수당 및 월간 실적 수당을 받을 수 있는 자격을 가지게 됩니다
<br>
<br>4.	MT4 계좌 잔액 부족
<br>
<br>만약 현재 맥심 패키지를 갱신하기로 결정했는데, MT4 잔액이 초기 투자 금액이하로 떨어졌다면,  초기 투자 금액으로 탑업하여 소개 수당과 매월 실적 수당을 받을 수 있는 자격을 얻으시기 바랍니다.  만약 만기일 까지 탑업하지 않으면, 탑업시 까지 계좌는 정지됩니다.  탑업하면 자격을 얻게 됩니다.
<br>
<br>5.	갱신하지 않을 경우
<br>어떠한 이유로든지, 만약 갱신하지 않기를 원하시면, 웹사이트로 가서 “Non-renewal (갱신안함) “을 선택하십시오. 또한 ‘Non-renewal(갱신안함) 계약서”를 작성해서 maturity@maximtrader.com 로 메일을 보내주시기 바랍니다.  귀하의 마지막 MT4 잔액( 만기일 MT4 계좌 잔액에 표시된 초기 자본 투자)는 만기일 후 14일 이내 귀하의 CP3 계좌로 이체될 것입니다.  이후 다음 인출 사이클시 평소처럼 인출 할 것입니다.  지급되면 귀하의 계좌는 폐쇄됩니다.
<br>
<br>6.	6개월 금지
<br>
<br>갱신하지 않는다면, 만기일 이후 6개월 동안 맥심트레이더에 재가입이 안됩니다.
<br>
<br>7.	동일 유저 ID회원
<br>
<br>동일 아이디로 한 개 이상의 패키지를 가입한 회원은 모든 패키지를 갱신해야 소개 수당 및 실적 수당을 받을 수 있는 자격을 얻을 수 있습니다. 만약 하나라도 갱신하지 않으면, 동일 ID의 모든 패키지로는 추천수당과 디벨롭먼트 수당을 받을 수 없습니다.
<br>
<br>8.	추가 문의가 있으시면 maturity@maximtrader.com 로 연라바랍니다. .
<br>
<br>감사합니다,
<br>
<br>앤드류 림 박사
<br>CEO
<br>맥심 캐피탈
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>2015.5.11日
<br>スーパー株式スワップに関するルール
<br>
<br>1.	マキシムトレーダー会員へ提供可能なスワップ
<br>
<br>市場の強い願望より、以下が最低12ヶ月以上投資したマキシムのメンバーにオープンになる。マキシムトレーダー（以下会社と略す）は12ヶ月あるいはそれ以上、マキシム投資パッケージに投資した会員へ以下のオプションを提供する。これはまた18ヶ月投資の満期に達する会員にも提供する。
<br>
<br>i.	会員様は投資元本および投資周期残りの月間配当（CP3）を0.8ドル/株の株価でROGP株に転換することが可能である。申請期間は2015年5月12日から2015年5月31日まで。
<br>
<br>ii.	マキシムトレーダーへの投資をROGP株へ転換することを決めたあとで、マキシムトレーダーへの投資をビジネスとして継続することが可能で、今までの直接紹介ボーナスや組織発展ボーナスが発生します。18ヶ月の投資契約満了した後、会社はさらに18ヶ月間の口座有効期間を提供します。
<br>
<br>iii.	ROGP株への転換を選択した場合、あなたの上位のメンバーベースはマキシムトレーダーのシステム内で、もう一度組織発展ボーナスが発生します。
<br>
<br>iv.	あなたはAGL口座をアクティブしてない場合、システムが自動的に同額の株をAGL口座のS4に移管する。それによって、マキシムトレーダーと同じIDとパスワードでAGLに登録できます。AGLをビジネスとして展開したい場合、有効な口座が必要である。
<br>
<br>2.	マキシムトレーダーで再投資した場合
<br>
<br>一回目の投資契約が満了し、再投資した会員様は同様に第二回目の投資契約が12ヶ月に達することが、株転換の条件とする。
<br>
<br>3.	投資契約期間満了時の選択肢
<br>
<br>
<br>ROGP株への転換を申請せず、投資契約期間が満了時に再投資しない場合、引き続き直接紹介ボーナスおよび組織発展ボーナスを受けることできない。によって、会社のアドバイスとして、投資契約期間満了時に「継続」を選択することがお勧めします。それによって、毎月の配当およびシステムのボーナス制度を受けることができる。
<br>
<br>
<br>4.	MT4 Balanceは投資元本より減少した場合
<br>
<br>MT4 Balanceは投資元本より少ない場合、投資元本まで補填することがお勧めする。それによって会社の組織発展ボーナスおよび直接紹介ボーナスを受けることができる。投資契約期間が満了時に元本まで補填してない場合、口座は補填するまで有効な口座として見なさない。一旦元本まで補填すると、各種のボーナスおよび月間配当が再開される。
<br>
<br>5.	投資契約を継続しない場合
<br>
<br>あなたは投資契約を継続しない場合、会社ホームページのメンバーエリアにで、「継続しない」と選択してください。そして、該当する申請書を記入し、maturity@maximtrader.comまで送信してください。あなたの口座内のMT4 Balanceと同額な金額は14日以内にCP3に振り込まれる。CP2およびCP3の全額は支給する。その後、あなたの口座はシステムから取り消され、マキシムトレーダーをビジネスとして展開する一切のボーナスを受けることできなくなる。
<br>
<br>6.	6ヶ月内で再投資できない
<br>
<br>あなたは投資契約を継続しないと選択した場合、6ヶ月以内にマキシムトレーダーへの投資は禁止される。
<br>
<br>7.	同一口座内複数のパッケージを持つ会員様
<br>
<br>注意：同一口座内に複数のパッケージを持つ会員様は、直接紹介ボーナスおよび組織発展ボーナスを受けるには、すべてのパッケージを投資継続することが必要である。そのうちの一つのパッケージを投資継続しないでも、各種の紹介とデヴェロッップメント・ボーナßスを受けることができない。
<br>
<br>8.	より詳細な情報はmaturity@maximtrader.comまで請求してください。
<br>
<br>
<br>
<br>Dr. Andrew Lim
<br>マキシムトレーダー CEO
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='69'>Extend the IME 2015 qualifying date for another 30 days till May 31st 2015</a><img src="/images/new_icon.gif">
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "02 May 2015";
                ?>
            </div>

            <div id="page_69" class="news_desc" style="text-align: left;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Based on your request......
<br>
<br>We are pleased to extend the qualifying date for another 30 days till May 31st 2015 to allow you to book your place for our IME 2015 which will be held in the magical wonderland of Gold Coast Australia.
<br>
<br>What are you waiting for ..... Less than 1,000 of the 3,500 tickets left !!!!!!
<br>
<br>应广大会员强烈要求！
<br>
<br>我们非常高兴地宣布马胜金融集团2015澳大利亚黄金海岸国际金融交流会优惠促销活动将延期30天至2015.5.30日.
<br>
<br>3500席位，只剩下最后的1000个名额，大家还等什么呢? 加油吧!!!!!!
<br>
<br>みなさまのリクエストにより…….
<br>
<br>私たちはオーストラリアのゴールドコーストのマジカルワンダーランドで開かれる予定のIME2015への資格日をさらに30日延長し、2015年５月31日まで予約ができるようにしたことを、喜んでお伝えします。
<br>
<br>あなたは何を待っているのですか….….3500のチケットのうち残りは1000以下になっています!!!!!!
<br>
<br>여러분의 요청에 따라....
<br>
<br>당사는 환상의 원더랜드인 호주 골드 코스트에서 열릴 2015 IME에 참석힐 수 있는 자격충족 기간을 2015년 5월 31일까지 30일 연장하게 되었음을 기쁘게 알려드립니다.
<br>
<br>무엇을 기다리고 계십니까.... 3,500 석중 1,000석도 남지않았습니다!!!!!!
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='68'>03 April 2015 - US, Good Friday</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "1 April 2015";
                ?>
            </div>

            <div id="page_68" class="news_desc" style="text-align: left;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Members,
                            <br>

<br>FX and Precious Metals trading hours remain the same, a lack of liquidity may lead to wider spreads; please plan your trades accordingly.
<br>
<br>For Precious Metals, due to the closure of futures markets during the period as stated below, liquidity may be especially thin and there may be no bid/offers:
<br>03 April 2015 0500hrs (SGT/HKT) - 04 April 2015 0500hrs (SGT/HKT).
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='66'>US Daylight Changing Notice</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "5 March 2015";
                ?>
            </div>

            <div id="page_66" class="news_desc" style="text-align: left;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Members,
                            <br>
                            <br>Please note the US daylight changing will starts on Sunday 8/3/2015, 2am. The MT4 day end time will be adjusted to 5am. Metal trading session starts on 6am on Monday.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='65'>iAccount Notice
<br>iAccount 通告
<br>iAccount 고지
<br>iAccount お知らせ</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "14 February 2015";
                ?>
            </div>

            <div id="page_65" class="news_desc" style="text-align: left;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Dear Members,
<br>亲爱的会员,
<br>
<br>Your February 2015 withdrawals have been processed by Maxim. We have been informed by iAccount that the crediting into individual iAccounts are going on progressively but some delays are expected due to the festive season which is hindered by manpower shortages as result of Chinese New Year celebrations.
<br>针对本月(2015.2月)的取现, 都已经在处理当中. 有关iAccount的取现, 公司得到通知已经在稳序进行当中; 因为中国假期的到来, 部分iAccount员工已经休假, 因此可能会因人手问题而出现稍许延误.
<br>
<br>iAccount has assured us that they will complete the crediting soonest possible.
<br>请放心, iAccount已经在快马加鞭, 承诺会以最快的速度处理所有客户的转款.
<br>
<br>Your kind understanding and patience is much appreciated over this isolated delay.
<br>为此造成的延误,我们表示十分的抱歉; 也万分感谢您的谅解与理解!
<br>
<br>Thank you 非常感谢!
<br>CFO
<br>Maxim Trader
<br>马胜金融首席财务官
<br>
<br>친애하는 회원  여러분
<br>
<br>맥심 2015년 2월 인출이 진행되었습니다.  i어카운트에서 설날을 기하여 많은 직원들의 휴가로 인한 인력 부족으로 개인의 계좌로의 진행이 조금 늦어질 수 있다는 연락을 받았습니다.
<br>
<br>i어카운트는 가능한한 가장 빠른 시간에 작업을 완수할 것을 약속했습니다.
<br>
<br>여러분의 이해와 인내에 깊은 감사드립니다.
<br>
<br>감사합니다.
<br>CFO
<br>맥심 트레이더
<br>
<br>メンバーの皆様
<br>
<br>皆様の2015年２月の引き出しは現在マキシムによって処理中です。弊社はiAccountより、個人のお客様へのへのiAccountsへの入金作業は現在進行中ながら、中国正月による人出不足が見込まれるため、若干の遅れが予測されるとの知らせを受けています。
<br>iAccountは可能な限り早急に入金を完了させると私たちに確約しています。
<br>この遅れに対して、皆様のご理解およびご協力をいただければ幸いです。
<br>
<br>ありがとうございます。
<br>CFO
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='64'>Chinese New Year Notice</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "12 February 2015";
                ?>
            </div>

            <div id="page_64" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Dear Members,
<br>亲爱的会员,
<br>
<br>Please note our Customer Service Division will be closed from 18 to 24 February in conjunction with Chinese New Year celebrations. If you need any urgent assistance during this period, please contact your Leaders or alternatively you may continue to email support@maximtrader.com and we will reply you soonest possible. Thank you for your understanding and co-operation.
<br>请注意: 因为中国春节即将到来,公司的客户服务中心将从2.18日-2.24日暂停服务. 如果在此期间您有紧急事情需要公司的处理, 请发送邮件至support@maximtrader.com, 我们会尽快回复您.谢谢您的谅解与合作!
<br>
<br>We wish All Members and their Families, A Very Happy and Prosperous New Year !
<br>祝愿您及您的家人新春快乐、笑口常开、万事如意!
<br>
<br>CEO
<br>Maxim Trader
<br>马胜金融集团首席执行官
<br>
<br>친애하는 회원 여러분,
<br>
<br>설날을 기하여 2월 18일부터 24일까지 당사 고객서비스부서가 근무를 하지 않습니다. 만약 이 기간동안 급한 도움이 필요하시면, 귀하의 리더에게 연락하시거나 support@maximtrader.com으로 메일을 보내주시기 바랍니다.  가능한 한 빠른 시일내에 답변을 드리도록 하겠습니다.  이해와 협조에 감사드립니다.
<br>
<br>모든 회원분들과 그 가족 분들 모두 새해 복 많이 받으시기 바랍니다.
<br>
<br>CEO
<br>맥심 트레이더
<br>
<br>メンバーの皆様
<br>
<br>弊社カスタマーサービス部は、２月18日〜24日の間中国の旧正月のお祝いのため閉鎖となりますのでご注意ください。もし何かしらの緊急のご用事がこの期間にある場合、あなたのリーダー、または別の方法として
<br>support@maximtrader.com にメールしてくだされば、できるだけ早めにお返事いたします。ご理解とご協力に感謝します。
<br>
<br>すべてのメンバーおよびご家族の皆様に、新年のご挨拶を申し上げるとともに、繁栄した１年になるよう、お祈りいたします。
<br>
<br>CEO
<br>マキシムトレーダー
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='61'>Forex Markets Notice</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "11 February 2015";
                ?>
            </div>

            <div id="page_61" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Dear Members,
<br>
<br>Please take note of the upcoming market holiday(s) below.
<br>
<br>17 Feb 2015 - US, Presidents' Day
<br>
<br>The Forex markets will be open throughout this period but liquidity is expected to be lower than normal. The Gold and Silver Markets will be closed at 2.00am - 7.00am SGT/HKT
<br>
<br>Kindly plan your trades accordingly.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='63'>iAccount Notice
<br>iAccount 通告
<br>iAccount 고지
<br>iAccount お知らせ</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "1 February 2015";
                ?>
            </div>

            <div id="page_63" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Dear Members,
<br>亲爱的会员,
<br>
<br>Pls note withdrawal process for February 2015 will be as follows:
<br>请注意2015年2月份取现安排将会如下:
<br>
<br>1. Withdrawal period: 1 to 7 February only.
<br>取现申请时间: 2月1号-7号
<br>
<br>2. Members who have iAccount will be able to select iAccount option only.
<br>拥有iAccount账户的会员,将只能通过iAccount进行取现.
<br>
<br>3. For members without iAccount, the system will automatically allow them only to select local bank transfer.
<br>尚未开通iAccount账户的会员, 系统将自动只允许其通过本地银行进行转账.
<br>
<br>4. Pls note after February, withdrawal option will be available only via iAccount, as such please apply for your iAccount immediately.
<br>请注意, 从2月份开始以后的月份, 取现只可以通过iAccount进行. 所以请尽快申请iAccount账户.
<br>
<br>5. The above does not apply to members in China, Indonesia and Thailand whose present withdrawal system will remain unchanged.
<br>以上变更不适用于来自中国、泰国以及印度尼西亚的会员; 以上三个国家的本地银行取现政策保持不变.
<br>
<br>Thank you, 谢谢
<br>
<br>CFO 首席财务官
<br>Maxim Trader 马胜金融
<br>
<br>친애하는 회원여러분
<br>
<br>2015년 2월 인출이 아래와 같이 진행될 것입니다.
<br>
<br>1. 인출기간 : 2월 1일에서 7일 까지 한정
<br>2. I-어카트를 가진 회원은 I어카운트 옵션만 선택할 수 있습니다.
<br>3. I어카운트를 가지고 있지 않은 회원은 시스템이 자동적으로 현지 은행만 선택할 수 있도록 합니다.
<br>4. 2월 이후부터 인출 옵션은 i어카운트만 가능할 것이므로 i어카운트를 즉시 신청하시기 바랍니다.
<br>5. The above does not apply to members in China, Indonesia and Thailand whose present withdrawal system will remain unchanged.
<br>
<br>감사합니다.
<br>CFO
<br>
<br>メンバーの皆さま
<br>
<br>2015年2月の引き出し手順は以下の通りになりますのでお知らせします。
<br>
<br>1..引き出し期間:2月1日から7日のみとなります。
<br>2. iAccountをお持ちのお客様はiAccountオプションのみを選択いただけます。
<br>3.iAccountをお持ちでないお客様はシステムにより自動的に地域の銀行送金を選択することになります。
<br>4. どうぞ2月以降、引き出しオプションはiAccountを通してのみ可能になりますことをご注意ください。そのため、どうぞiAccountに至急お申し込みください。
<br>5. The above does not apply to members in China, Indonesia and Thailand whose present withdrawal system will remain unchanged.
<br>
<br>ありがとうございます。
<br>CFO
<br>マキシムトレーダー
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='62'>Maxim Annual Convention Notice</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "23 January 2015";
                ?>
            </div>

            <div id="page_62" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Dear IMs and Partners
<br>亲爱的代理及伙伴们:
<br>
<br>CONGRATULATIONS .... We have COMPLETELY SOLD OUT our Maxim Annual Convention to be held in Marina Bay Sands on March 22nd 2015.
<br>热烈恭喜!我们将于2015.3.22日在新加坡金沙湾酒店盛大开幕的年会门票正式售罄!!
<br>
<br>ALL PROMOs FOR THIS EVENT WILL EFFECTIVELY END AS OF 2359 Hours (GMT+8) December 31st, 2014.
<br>所有有关此次年会的优惠促销活动于2014.12.31日23:59分(GMT+8)正式结束!
<br>
<br>See you in Singapore !!!!!
<br>与您相约在新加坡!!!!!
<br>
<br>친애하는 국제회원 및 파트너 여러분,
<br>
<br>축하합니다 .... 2015년 3월 22일 마리나 베이 샌드에서 열릴 맥심 애뉴얼 컨벤션 티켓이 완판되었습니다.
<br>
<br>이 행사 관련 모든 프로모션은 2014년 12월 31일 오전 9시 (GMT+8)에 마감됩니다.
<br>
<br>싱가폴에서 뵙기를 기원합니다!!!!!
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
<!--
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='61'>iAccount Notice
<br>iAccount 通告
<br>iAccount 고지
<br>iAccount お知らせ</a>
            </div>
            <div class="news_date">
                <?php
/*                $dateUtil = new DateUtil();
                echo "18 January 2015";
                */?>
            </div>

            <div id="page_61" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>2015年1月份取现通知
<br>
<br>In the process of implementing iAccount, a sudden surge in the number of applicants is being experienced by iAccount processing centre. As such some members may not have received their iAccount yet in order to make January withdrawals. Such members are advised to email anna@maximtrader.com or contact her at +6012 226 3718 by 5pm on 23rd January (GMT +8) and we will assist to process your request as a special case. We apologize for any inconvenience caused.
<br>在实施iAccount的过程中, iAccount处理中心接到的客户申请数量出现了爆炸性的增长;因此导致目前尚有部分会员未收到iAccount账户以及时申请接收2015年1月份的取现. 我们建议此类会员尽快在2015.1.23日下午5点(GMT+8)之前邮件至anna@maximtrader.com或电话至+6012 226 3718,以便我们为您做特殊处理. 为此造成的不便,我们深表歉意.
<br>
<br>Thank you.谢谢!
<br>CEO 首席执行官
<br>
<br>2015년 인출 공지 :
<br>
<br>i어카운트를 실행하는 과정에서, i어카운트 프로세싱 센터는 신청자 수의 갑작스런 급증을 경험하게 되었습니다.  이러한 이유로 회원들 중 1월 인출을 위한  i어카운트를 아직 받지 못한 분들이 발생하였습니다.  만약 아직 i어카운트를 받지 못한 회원이 계시다면  1월 23일 오후 5시까지 (GMT+8) anna@maximtrader.com로 이메일을 보내주시거나  +6012 226 3718로 전화주시기 바랍니다.  특별한 케이스로 진행될 수 있도록 도와드리겠습니다. 불편을 끼쳐드려서 죄송합니다.
<br>
<br>감사합니다.
<br>CEO
<br>
<br>2015年1月　引き出しに関わるお知らせ
<br>
<br>iAccount実施の過程におきまして、
<br>iAccountの処理センターに突然、多大な申し込み数がよせられました。そのため、メンバーの皆様のなかには、まだ１月の支払いのための
<br>iAccount口座を受け取っていない方もいるのではないかと思われます。そのようなメンバーの皆様は、1月23日(GMT
<br>+8)までに、anna@maximtrader.comへメールされるか、または  +6012 226
<br>3718へ電話してください。私たちがお客様を特別なケースとして取り扱うようにお手伝いします。ご不便をおかけし申し訳ありません。
<br>
<br>ありがとうございます。
<br>
<br>CEO
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>-->

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='60'>iAccount Notice
<br>iAccount 通告
<br>iAccount 고지
<br>iAccount お知らせ</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "13 January 2015";
                ?>
            </div>

            <div id="page_60" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Dear Members,
<br>亲爱的会员,
<br>
<br>Please take note that iAccount website is under maintenance, as such online iAccount new applications cannot be processed now. The website is expected to be back to normal by tomorrow morning. Very sorry for the inconvenience caused.
<br>请注意, 目前iAccount网站正在维护当中, 因此新iAccount申请将暂停处理;预计iAccount网站明天早晨会恢复正常. 为此造成的不便,我们表示非常抱歉.
<br>
<br>Thank you. 谢谢!
<br>
<br>Revi Pillai CFO 首席财务官
<br>
<br>친애하는 회원 여러분,
<br>
<br>i어카운트 웹사이트가 유지보수 중이므로 현재 새로운 신청이 진행되지 않고 있습니다. 내일 아침에 정상진행이 될 예정입니다. 불편을 끼쳐  대단히 죄송합니다.
<br>
<br>감사합니다.
<br>
<br>레비 필라이 CFO
<br>
<br>メンバーのみなさま
<br>
<br>どうぞiAccountのウエブサイトが現在メンテナンス中であることにご注意ください。そのためiAccountの新しいアプリケーションは現在お使いいただけません。ウエブサイトは明日の朝には通常通りお使いいただける見込みです。ご不便をおかけして大変申し訳ございません。
<br>
<br>ありがとうございます。
<br>
<br>Revi Pillai CFO
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='59'>Market Holidays Notice
                    <br>市场假期通告</a>
            </div>
            <div class="news_date">
                <?php
                $dateUtil = new DateUtil();
                echo "13 January 2015";
                ?>
            </div>

            <div id="page_59" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                    <tr>
                        <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>Please take note of the upcoming market holiday(s) below.
<br>
<br>19 Jan 2015 - US, Dr. Martin Luther King, Jr. Day
<br>
<br>While FX and Precious Metals trading hours remain the same, a lack of liquidity may lead to wider spreads; please plan your trades accordingly.
<br>
<br>For Precious Metals, due to the closure of futures markets during the period as stated below, liquidity may be especially thin and there may be no bid/offers at times:
<br>20 Jan 2015 0200hrs (SGT/HKT) - 20 Jan 2015 0700hrs (SGT/HKT).
<br>
<br>*******************************************************************************
<br>
<br>尊敬的客户，
<br>
<br>以下是即将来临的市场假期 。
<br>
<br>19 Jan 2015 - US Dr. Martin Luther King, Jr. Day
<br>
<br>当日外汇与贵金属照常交易，但潜在市场流通性不足的情况，有可能导致点差扩大，请相应地计划您的交易。
<br>
<br>至于贵金属，尤其是在以下时段，ＣＭＥ黄金与白银期货交易停止，比较少银行会报价：
<br>20 Jan 2015 0200hrs (SGT/HKT) - 20 Jan 2015 0700hrs (SGT/HKT).
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='58'>e-wallet Notice
<br>e-wallet 通告
<br>e-wallet 고지
<br>e-wallet のお知らせ</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "6 January 2015";
                ?>
            </div>

            <div id="page_58" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear IMs &amp; Partners,
<br>亲爱的代理及伙伴们:
<br>
<br>Effective 1st Jan 2015, all transactions in your e-wallet which are more than 3 months old will be archived. You will be able to view current and immediate past 3 months transactions.
<br>从2015.1.1日生效-会员专区内超过3个月之久的金融钱包声明将会被存档. 会员只能看见最近3个月之内的交易明细.
<br>
<br>Anyone requiring archived statements, please write to <a href="mailto:support@maximtrader.com">support@maximtrader.com</a>.
<br>如果需要查看3个月之前的明细, 请邮件至 <a href="mailto:support@maximtrader.com">support@maximtrader.com</a> 申请.
<br>
<br>There will be a nominal charge of 10 CPs per month, for requests processed. Please give 3 working days for processing.
<br>针对此类申请,系统将收取10CP点数/每月(明细). 处理时间为三个工作日.
<br>
<br>Thank you.
<br>谢谢配合!
<br>
<br>CEO 首席执行官
<br>
<br>친애하는 맥심 회원 및 파트너 여러분,
<br>
<br>2015년 1월 1일부로, 3개월 이상된  e-월렛에서 이루어지는 모든 거래는 기록으로 남겨질 것입니다. 현재 상태를 보실 수 있으면 지난 3개월 동안의 거래 내역도 확인하실 수 있습니다.
<br>
<br>거래 내역서를 원하신다면, <a href="mailto:support@maximtrader.com">support@maximtrader.com</a> 으로 메일 보내주시기 바랍니다.
<br>
<br>신청을 진행함에 있어서 매달 10 CPs의 수수료가 발생하며 근무일 3일의 시간이 소요됩니다.
<br>
<br>감사합니다.
<br>CEO
<br>
<br>親愛なるIMおよびパートナーの皆様
<br>
<br>2015年1月1日より、お客様のe-walletにおける三ヶ月以上前のすべての取引はアーカイブされます。ご覧いただけるのは、現在および三ヶ月以内のお取引となります。
<br>
<br>
<br>アーカイブをご覧になりたい方は、どうぞCSセンターまでご連絡ください。一度リクエストが処理されますと10CPのわずかな手数料が毎月発生します。処理には3営業日いただきます。
<br>
<br>ありがとうございます。
<br>CEO
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='57'>iAccount Notice
<br>iAccount通告
<br>iAccount 고지</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "5 January 2015";
                ?>
            </div>

            <div id="page_57" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear Members,
<br>亲爱的会员:
<br>
<br>Further to our announcement on monthly withdrawals via iAccount to be made compulsory, please note with effect from January 2015, every member is required to open an iAccount and update it in their user profile, otherwise your January withdrawal will be rejected until you have opened your iAccount. In order to enable you to open the iAccount, January 2015 withdrawal period will be extended till 20 January 2015. Those of you who haven't opened your iAccount yet, please do so immediately.
<br>鉴于此前发布的会员通过iAccount取现的政策, 请注意从2015年1月份开始, 所有会员需开通iAccount账户,并于会员区个人资料处更新：若然,本月的取现请求将会被系统拒绝. 为了给大家更多时间开通iAccount, 本月(2015.1月)的取现申请接收时间将会延迟至2015.1.20日.请所有会员尽快开通iAccount账户.
<br>
<br>Please note members in China, Thailand and Indonesia may do withdrawal request via local bank account or iAccount.
<br>另外, 中国大陆, 泰国以及印度尼西亚的会员可以自由选择通过iAccount或者本地银行取现.
<br>
<br>Your prompt action and kind understanding of the matter is highly appreciated in order to enable us to serve you better.
<br>敬请留意,谢谢大家的配合!我们一直努力,更好地服务所有会员!
<br>
<br>Thank you. 谢谢!
<br>CEO 首席执行官
<br>
<br>친애하는 회원 여러분,
<br>
<br>매월 인출시 i어카운트로 인출하는 것이 의무사항이 됨에 따라, 2015년 1월부로 모든 회원들은   i어카운트 계좌를 개설하고 유저 프로필을 업데이트 하여야만 합니다. 만약 이를 실시하지 않을 경우, 귀하의 1월 인출은  i어카운트 계좌 개설시 까지 불가능합니다.  i어카운트 계좌를 개설 하실 수 있도록 2015 1월 인출 기간을 2015년 1월 20일까지 연장할 것입니다.   아직 i어카운트 계좌를 개설하지 않으신 회원분들은 즉시 개설하시기 바랍니다.
<br>
<br>중국, 태국, 인도네시아 회원분들은 현지 은행 계좌 또는 i어카운트 계좌에서 인출하실 수 있습니다.
<br>
<br>귀하의 빠른 계좌 개설과 본 사항에 대한 이해에 감사드리며 더 나은 서비스를 드릴 수 있도록 최선을 다하겠습니다.
<br>
<br>감사합니다.
<br>CEO
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

    <?php if ($isFmc == false) { ?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='56'>New exchange rates for investment in Maxim Trader packages, will take effect from 1st Jan 2015
<br>马胜投资配套价格汇率价格公告将于2015.1.1日起正式生效</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "23 December 2014";
                ?>
            </div>

            <div id="page_56" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear ALL,
<br>
<br>Further to our recent announcement, kindly note the new exchange rates for investment in Maxim Trader packages, will take effect from 1st Jan 2015. Please note these rates are inclusive of 10% FMC charge. Please follow these rates so that your CP1 will be credited correctly and promptly:
<br>
<br>1. Malaysia RM - RM3.90
<br>2. Thailand Baht - B36
<br>3. Indonesia Rupiah - IDR13,500
<br>4. China RMB - RMB7.00
<br>5. Taiwan New Dollar - NTD34
<br>6. Hong Kong Dollar - HKD8.5
<br>7. Japanese Yen - Bank rate + 10%
<br>8. Korean Won - KRW1,250
<br>9. Phillipine Peso - PHP50
<br>10. Singapore Dollar - SGD1.46
<br>11. Cambodia Riel - KHR4,500
<br>12. Vietnam Dong - VND24,000
<br>13. India Rupee - INR69
<br>14. USD - USD1.1
<br>
<br>亲爱的会员及代理们:
<br>
<br>请注意我们最近发布的有关马胜投资配套价格汇率价格公告将于2015.1.1日起正式生效; 公告价格包含10%的FMC外汇管理费用. 敬请留意政策变化, 以便公司及时正确处理CP1分数转款:
<br>
<br>1. 马币 - RM3.90
<br>2. 泰铢 - B36
<br>3. 印尼盾 - IDR13,500
<br>4. 人民币 - RMB7.00
<br>5. 台币 - NTD34
<br>6. 港币 - HKD8.5
<br>7. 日元 - 当前银行汇率价格+10%
<br>8. 韩元 - KRW1,250
<br>9. 菲律宾比索 - PHP50
<br>10. 新币 - SGD1.46
<br>11. 柬埔寨瑞尔 - KHR4,500
<br>12. 越南盾 - VND24,000
<br>13. 印度卢比 - INR69
<br>14. 美金 - USD1.1
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php } ?>

    <?php
    if ($isFmc == true) { ?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='55'>New exchange rates for investment in Maxim Trader packages, will take effect from 1st Jan 2015
<br>马胜投资配套价格汇率价格公告将于2015.1.1日起正式生效</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "23 December 2014";
                ?>
            </div>

            <div id="page_55" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear ALL,
<br>
<br>Further to our recent announcement, kindly note the new exchange rates for investment in Maxim Trader packages, will take effect from 1st Jan 2015. Please note these rates are NOT inclusive of 10% FMC charge. Please follow these rates so that your CP1 will be credited correctly and promptly:
<br>
<br>1. Malaysia RM - RM3.60
<br>2. Thailand Baht - B33
<br>3. Indonesia Rupiah - IDR12,000
<br>4. China RMB - RMB6.3
<br>5. Taiwan New Dollar - NTD31
<br>6. Hong Kong Dollar - HKD7.8
<br>7. Japanese Yen - Bank rate
<br>8. Korean Won - KRW1,150
<br>9. Phillipine Peso - PHP44
<br>10. Singapore Dollar - SGD1.33
<br>11. Cambodia Riel - KHR4,100
<br>12. Vietnam Dong - VND22,000
<br>13. India Rupee - INR62
<br>14. USD - USD1
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php } ?>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='54'>Unauthorized use of Maxim Materials, Trade Marks and Copyright
<br>未經授權使用馬勝金融的材料、商標及版權</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "22 December 2014";
                ?>
            </div>

            <div id="page_54" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
<br>The Management has received  complaints of unauthorized distribution of Maxim Trader Information used at various unofficial websites & Facebook pages these past couple of months. Unless members obtain prior written approval from the Legal Office of the Company (LACD), this is a direct breach of Article 3 of the Maxim Code of Ethics, which is posted at the members area of the Back Office.
<br>Kindly be reminded that the Maxim Trader name, logo &trademarks belong to  Maxim Capital Limited(MCL), or better known as Maxim Trader. Following a proper and just investigation, any Member found in breach of Article 3, may be imposed with the penalty of suspension or  termination. Please be guided by Article 3 the Code of Ethics on how to obtain approval for the use of such materials.
<br>
<br>過去數個月，管理層收到一些投訴，有關未經授權發送馬勝金融的資訊，用於非官方批准的網站及面書。除非會員得到由馬勝金融的法律部門（法律事務與法規遵從部門）事前面書許可，否則這是直接違反馬勝金融的道德規範第三項，而道德規範是發表於後勤部門的會員專區。
<br>請緊記馬勝金融的名稱、標誌及商標屬於馬勝金融集團，或更好稱為馬勝金融。跟據一個適當及公正的調查後，任何會員被發現違反道德規範第三項，可被實施暫停或中止的處罰。請根據道德規範的引導有關如何得到許可。
<br>
<br>회사의허가를받지않은 Maxim Trader 정보를인터넷싸이트나페이스북에올리거나회사이름을적은명함을쓰는맴버들에대한고발을회사는지난몇개월동안받아왔습니다.  회사맴버창에공시되어있는대로회사법무팀의사전허가를받지않고이런정보를올리거나쓰는맴버들은맥심윤리강령 3조를위반하고있음을알려드립니다.
<br>Maxim Trader 상호와이름, 로고들은 Maxim CaptialLimited(MCL) 또는 Maxim Trader 회사에속한재산권임을다시한번확인시켜드립니다.  맥심윤리강령 조를위반한맴버들에대해서는적법한조사를할것이며이를위반한맴버들에대해서는경고나맴버퇴출을집행할것임을알려드립니다.  회사의허가를어떻게받을수있는지에대해서는윤리강령을참고하시기바랍니다.

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <?php if ($sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) <> 60) { ?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='53'>New exchange rates for investment in Maxim Trader packages, effective from 23rd Dec 2014 shall be as follows
<br>从2014.12.23日起, 购买公司美金配套的汇率价格将发生变化</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "18 December 2014";
                ?>
            </div>

            <div id="page_53" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear ALL,
<br>
<br>Kindly note the new exchange rates for investment in Maxim Trader packages, effective from 23rd Dec 2014 shall be as follows. This rate is inclusive of the 10% FMC charge. Please follow these rates so that your CP1 will be credited correctly and promptly:
<br>
<br>1. Malaysia RM - RM3.90
<br>2. Thailand Baht - B36
<br>3. Indonesia Rupiah - IDR13,500
<br>4. China RMB - RMB7.00
<br>5. Taiwan New Dollar - NTD34
<br>6. Hong Kong Dollar - HKD8.5
<br>7. Japanese Yen - JPY130
<br>8. Korean Won - KRW1,250
<br>9. Phillipine Peso - PHP50
<br>10. Singapore Dollar - SGD1.46
<br>11. Cambodia Riel - KHR4,500
<br>12. Vietnam Dong - VND24,000
<br>13. India Rupee - INR69
<br>14. USD - USD1.1
<br>
<br>亲爱的会员及代理们：
<br>
<br>请注意从2014.12.23日起, 购买公司美金配套的汇率价格将发生变化; 新的价钱将包含10%的基金管理费用FMC. 请参照新的价格表购买CP分数:
<br>
<br>1. 马币 - RM3.90
<br>2. 泰铢 - B36
<br>3. 印尼盾 - IDR13,500
<br>4. 人民币 - RMB7.00
<br>5. 台币 - NTD34
<br>6. 港币 - HKD8.5
<br>7. 日元 - JPY130
<br>8. 韩元 - KRW1,250
<br>9. 菲律宾比索 - PHP50
<br>10. 新币 - SGD1.46
<br>11. 柬埔寨瑞尔 - KHR4,500
<br>12. 越南盾 - VND24,000
<br>13. 印度卢比 - INR69
<br>14. 美金 - USD1.1
<br>
<br>여러분 안녕하십니까
<br>
<br>2014년 12월 23일부터 적용될 맥심 트레이더 패키지를 구입시 새로운 적용 환율을 알려드립니다.
<br>본 환율은 FMC 비용 10%가 포함된 금액입니다. 아래의 환율을 확인하셔서 귀하의 CP1에 정확하고 신속하게 입금될 수 있도록 하여주십시요:
<br>
<br>1. 말레이시아 링깃 - RM3.90
<br>2. 태국 바트 - B36
<br>3.인도네시아 루피아 - IDR13,500
<br>4. 중국 RMB - RMB7.00
<br>5. 대만 뉴달러 - NTD34
<br>6. 홍콩 달러 - HKD8.5
<br>7. 일본 엔 - JPY130
<br>8. 한국 원 - KRW1,250
<br>9. 필리핀 페소 - PHP50
<br>10. 싱가폴 달러 - SGD1.46
<br>11. 캄보디아 리엘 -  KHR4,500
<br>12. 베트남 동 - VND24,000
<br>13. 인도 루피 - INR69
<br>14. USD - USD1.1
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php } ?>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='52'>Definition of Cross Lining
<br>橫跨界線的定義</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "18 December 2014";
                ?>
            </div>

            <div id="page_52" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>See Chinese below
<br>請參閱以下中文
<br>
<br>“Members who open a Maxim Account in the same line of their Referring Member. Then that very same new Member either in person or through a Company, Trust or any other entity, opens another Account at some other line (whether that is a Maxim, AGL or other account at any other venture in any organization within any Related or Sister company inter-connected with Maxim Trader) where the same above referrer is not present in that line and does so without the written consent of his initial referrer, duly consummates the breach of CROSS LINING”
<br>會員開設一個馬勝金融的戶口，作同一界線與他們的轉介會員。其後，該新會員以個人身份、或透過一間公司、信託、或任何其他實體，開設另一戶口於其他界線（無論是一個馬勝金融、AGL或其他戶口於任何其他企嶪在任何組織與馬勝金融有關聯或姐妹公司）當同一的上線推薦人並不存在於該界線，及如此作為並未得到其原先推薦人的書面同意，正式地構成違反橫跨界線。
<br>
<br>This is strictly forbidden and serious consequences will be imposed against members found guilty of cross lining, subject to due process. The Formal Complaint form can be obtained from Legal Watch (LW) …to be completed and submitted to LW for immediate investigation and action against alkeged Cross Liners.
<br>這是嚴厲地被禁止，及嚴重後果將會實施於被發現違反橫跨界線之會員，受合法程序的管制。正式投訴表格可於法律監察中得到 …將要完成及提交去法律監察以對橫跨界線採取即時行動。
<br>
<br>Thank you.
<br>LACD
<br>法律事務與法規遵從部門


                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='51'>Announcement to all Malaysian Maxim Trader Members
                <br>所有马来西亚的会员请注意</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "17 December 2014";
                ?>
            </div>

            <div id="page_51" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Announcement to all Malaysian Maxim Trader Members:
<br>所有马来西亚的会员请注意:
<br>
<br>It is the practice of the Company to maintain stable exchange rates by ignoring minor fluctuations as far as possible. However, of late the Malaysian Ringgit has fallen significantly against the US Dollar and these leaves Maxim with no choice but to adjust the rates upwards. From 23rd December 2014 onwards, members will have to remit RM3.90 for every US dollar. This includes 10% FMC charge. We thank you for your understanding of this unavoidable move.
<br>一直以来, 公司政策都是尽量不受市场汇率价格的波动影响以保持配套价格不变. 但是最近马币兑美币贬值的幅度太大, 公司没有办法只能相应调整价格. 从2014.12.23日起, 马币购买公司配套的价格将为1美金等于3.9马币(此价格已含10%的FMC基金管理费用). 敬请谅解, 谢谢配合!
<br>
<br>CEO 首席执行官
<br>Maxim Trader
<br>马胜金融集团
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='50'>Updating Back Office Passwords
                <br>升级会员专区密码
                <br>Officeのパスワードのバック更新
                <br>오피스 암호를 돌아 업데이트</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "10 December 2014";
                ?>
            </div>

            <div id="page_50" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear IMs &amp; Partners
<br>
<br>For system integrity and security reasons, we politely request that you UPDATE and CHANGE your Login Password and Security Password.
<br>
<br>By Order
<br>CEO
<br>Maxim Capital Limited
<br>
<br>
<br>亲爱的会员及伙伴们,
<br>
<br>为了系统的稳定性及安全原因，请一定及时更改及更新您的登录密码和安全密码.
<br>
<br>命令
<br>
<br>首席执行官
<br>马胜资本有限公司
<br>
<br>
<br>バックオフィスのパスワード変更
<br>
<br>IMおよびパートナーのみなさま
<br>
<br>システムの健全性および安全上の理由により、私たちは皆さまにログインパスワードおよびセキュリティパスワードをアップデートし、変更していただくようお願いいたします。
<br>
<br>CEOの命により
<br>マキシム・キャピタル・リミテッド
<br>
<br>
<br>백 오피스 패스워드 업데이트
<br>
<br>친애하는 국제 회원 및 파트너 여러분
<br>안정적 시스템 구축과 시스템의 보안을 위하여 로그인 패스워드와 보안 패스워드를 업데이트와 변경해  주시기를 바랍니다.
<br>
<br>명령에 의해
<br>CEO
<br>맥심 캐피탈 주식회
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='49'>UNAUTHORIZED SITE
                <br>未经授权认证的网站公告
                <br>無許可の認定に関するお知らせ
                <br>무단 인증 공지 사항</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "10 December 2014";
                ?>
            </div>

            <div id="page_49" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear IMs and Partners,
<br>亲爱的会员及伙伴们:
<br>
<br>Please NOTE that http://www.maximchina.com.cn/ is AN UNAUTHORIZED Website which our LACD HAVE BEEN GIVEN SPECIFIC INSTRUCTIONS TO DEMAND THAT THE OPERATORS OF THIS WEBSITE CEASE AND SHUT IT DOWN OR FACE LEGAL PROCEEDINGS.
<br>请注意网站http://www.maximchina.com.cn/未经公司授权认证; 目前公司LACD法律部已经下发公告要求该网站运行人员关闭该网站,若然我们将采取法律措施.
<br>
<br>In event that the website is operated by an IM, we will not hesitate to Suspend and/or Terminate if there is Non-Compliance.
<br>如果一经查实该网站为我们的会员所有, 且相关人员不配合公司政策, 我们将坚决注销会员资格.
<br>
<br>CEO 首席执行官
<br>Maxim Capital Limited
<br>马胜资本有限公司
<br>
<br>
<br>不正行為について
<br>
<br>親愛なるパートナーおよびIMのみなさん
<br>
<br>最近、何人かのIMからの報告によれば、社から提供されたと主張する「盗まれた・非公式の」CP1、CP2、CP3ポイントを提供する個人がいるそうです。
<br>
<br>注意1：弊社はいかなる個人／会社に対しても、CPポイントをディスカウントレートでバルク販売することはしません。
<br>
<br>注意2：弊社はすべてのIMに非公式のIMおよび見知らぬ人からのCPポイントを購入しないように忠告します。
<br>
<br>注意３：弊社は、盗難による／非公式のCPによってアクティベートされたと証明された場合に、そのアカウント／プレイスメントを取り消す権利を有しています。さらに、弊社は盗難による／非公式のCPポイントによって得られたプレイスメントによって生じたすべての支払い済みのコミッションを取り戻す権利を持っています。
<br>
<br>注意４：弊社は盗難による／非公認のCPポイントを買ったり売ったりした不正行為に参加した人のアカウントをを停止／終了させることを厭いません。
<br>
<br>注意５：弊社はこれらの不正行為や露骨な盗難行為をした人を告訴することを厭いません。
<br>
<br>アンドリュー・リム博士
<br>CEO
<br>マキシム・キャピタル・リミテッド
<br>
<br>사기행위
<br>
<br>친애하는 파트너 및 국제회원 여러분
<br>최근 몇몇 회원들로부터 회사 직원을 사칭하는 개인이 “도난/무단” CP1, CP2와 CP3포인트를 제안한다는 사실이 확인되었습니다.
<br>
<br>주의 1 : 회사는 절대 어떠한 개인 또는 회자 직원이 할인 가격으로 대량의 CP 포인트를 팔도록 승인하지 않습니다.
<br>
<br>주의2: 회사는 국제회원 여러분들이 승인받지 않은 다른 국제회원 또는 낯선 이로부터 CP 포인트를 사지 말 것을 당부합니다.
<br>
<br>주의 3: 회사는 도난/무단 CP로 활성화된 계좌 또는 위치를 무효화 할 권리가 있습니다. 더 나아가서, 회사는 도난/무단 CP 포인트로 결정된 배치에 의한 커미션을 모두 상환시킬 것입니다.
<br>
<br>주의4: 회사는 이러한 사기 행각에 가담하여 도난/무단 포인트의 판매 또는 구매한 회원 자격의 유예/박탈하는 것을 주저하지 않을 것입니다.
<br>
<br>주의5 : 회사는 이러한 사기 행위와 노골적인 절도행위에 가담한 사람들을 고소할 것을 주저하지 않을 것입니다.
<br>
<br>앤드류 림 박사
<br>CEO
<br>맥심 캐피탈 주식회사
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='48'>iAccount Notice
                <br>iAccount公告
                <br>iAccount発表
                <br>iAccount발표</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "10 December 2014";
                ?>
            </div>

            <div id="page_48" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Notification to all members to open iAccount by 31 December 2014 in order to improve monthly withdrawal process:
<br>
<br>We wish to achieve greater efficiency, speed and economies of scale in the monthly withdrawal process. As such, we would like to introduce uniformity in the withdrawal mode and credit the withdrawal amounts into your e-wallet by the 11th of every month.
<br>
<br>In order to achieve this, we urge you to open an iAccount latest by 31 December 2014 so that all withdrawals could be credited into your personal iAccount from January 2015 onwards. Once credited into your iAccount, you may withdraw the amount anytime, at your convenience.
<br>
<br>Kindly log-on to www.maximtrader.com and click the iAcccount hyperlink to apply an iAccount and base debit card at the same time. Please ensure you upload your Passport or National ID and Proof of Mailing (POM) in colour, as part of the iAccount application requirements.
<br>
<br>Your kind co-operation and prompt action shall be highly appreciated.
<br>
<br>
<br>
<br>通知: 为了每月取现过程更加顺畅，请所有客户于2014.12.31日之前开通iAccount功能.
<br>
<br>近来公司每月取现额度越来越大，为了让该过程更加顺畅、高效，我们希望能够引用统一的取现通道，能够在每月11日之前将所有款项打入会员的电子钱包。
<br>
<br>为此，我们强烈建议所有会员于2014.12.31日之前开通iAccount功能，这样从2015.1月份开始所有的取现都将打入会员个人的iAccount中。一旦款项进入iAccount，会员可以决定随时取现。
<br>
<br>请登录www.maximtrader.com，并点击iAccount超链接以申请iAccount以及关联的Debit借记卡。请确保您及时上传您的护照或身份证以及地址证明的扫描件(均需彩色文件)，以完成整个申请流程。
<br>
<br>非常谢谢大家的理解与配合!
<br>
<br>
<br>
<br>2014年12月31日までにiAccountを開くすべてのメンバーへ月間引き出しプロセス改善のお知らせ
<br>
<br>私たちはより効率的でスピード感溢れる月間引き出しプロセスを提供したいと願っています。そこで、このたび引き出しモードにおいて一律、引き出し金額を毎月11日までにあなたのe-walletにクレジットすることになったことをご紹介します。
<br>
<br>これを達成するために、私たちは皆さまに2014年12月31日までにiAccountを開いていただくようお願いします。これにより、2015年1月以降、すべての引き出しはあなたの個人iAccount口座にクレジットされるようになります。一度iAccountにクレジットされましたら、その金額はいつでも都合のいいときに引き出すことができます。
<br>
<br>どうぞwww.maximtrader.comにログインし、iAccountのリンクをクリックしてiAccountとデビッドカードに同時にお申し込みください。どうぞ、iAccountのアプリケーションの求めに応じて、あなたのパスポートまたは個人証明書をメール証明（POM）をカラーでアップロードしてください。
<br>
<br>ご協力と迅速な行動に深く感謝します。
<br>
<br>
<br>
<br>월별 인출 프로세스 개선을 위하여 2014년 12월 31일까지 모든 회원의 i어카운트 개설 의무에 대한 통지 :
<br>
<br>효율성과 속도, 월별 인출 과정의 경제성을 고려하여 더 나은 서비스를 제공하기를 원합니다.  위를 위해, 인출 모드의 균일성을 소개하고자 하고 매월 11일에 귀하의 e-웰렛으로 인출시킬 수 있도록 하고자 합니다.
<br>
<br>이렇게 할 수 있기를 위하여, 늦어도 2014년 12월 31일까지 i어카운트를 개설하시기 바랍니다. 2015년 이후로 모든 인출은 귀하의 개인 i어카운트 계좌로 입금될 것이며, 편리한 시간에 어디서나 원하는 금액을 인출하실 수 있습니다.
<br>
<br>www.maximtrader.com에 로그인하셔서 i어카운트 링크를 클릭하시면 i어카운트의 구좌와 기본 데빗 카드를 동시에 신청하실 수 있습니다.  i어카운트 신청 조건의 일부인 여권이나 주민등록증과 주소 증빙서 (POM)을 첨부하시기 바랍니다.
<br>
<br>귀하의 협조에 감사드리며 조속한 신청을 부탁드립니다.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='47'>MBS Singapore Convention March 22nd 2015
                <br>新加坡滨海湾金沙大酒店March 22nd 2015年会</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "10 December 2014";
                ?>
            </div>

            <div id="page_47" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Don't you dare miss out on qualifying for our 2nd Annual Maxim Trader Convention which will be held at the pride and joy of Singapore... The Marina Bay Sands Expo and Convention Centre.
<br>千万不容错失-马胜金融集团第二届全球年会将会在新加坡滨海湾金沙大酒店(MBS)会议中心盛大举行!
<br>
<br>Promo Period: November 20th 2014 to January 28th, 2015
<br>优惠期限: 2014.11.20 至 2015.1.28日
<br>
<br>To Qualify: Sign Up USD30K or more in a Single Account for Maxim or AGL Package(s)
<br>优惠条件: 单个账户购买3万美金的马胜或AGL配套
<br>
<br>Entitled: 1 door ticket to Maxim Trader Singapore Convention & Gala Dinner @ The Marina Bay Sands Expo and Convention Centre
<br>优惠项目: 会员将获得新加坡MBS年会及晚宴入场门票一张
<br>
<br>Nb: 1 Ticket per UserID regardless of amounts in excess of USD30K
<br>注: 单个账户ID (即使配套高出3万美金)只能享有1张门票
<br>
<br>LIMITED to 4,000 persons ONLY
<br>名额有限，尊享4000位
<br>
<br>MBSシンガポール・コンベンション March 22nd 2015
<br>
<br>誇りと喜びに満ちたシンガポールのマリーナ・ベイ・サンズエキスポ＆コンベンションセンターにて開催される二回目となるマキシムトレーダー・コンベンションを見逃してはいけません。
<br>
<br>プロモーション期間: 2014年11月20日〜2015年1月28日
<br>
<br>資格条件:マキシムのシングルアカウントまたはAGLパッケージで、USD30Kまたはそれ以上へのサインアップ
<br>
<br>権利:マキシム・トレーダー・シンガポールコンベンション＆ガラディナーへのチケット1枚@マリーナ・ベイ・サンズエキスポ＆コンベンションセンター
<br>
<br>注意:USD30Kを超えた価格に対して金額に関係なくチケット1ユーザーIDあたり１枚
<br>
<br>4000名様限定
<br>
<br>MBS 싱가폴 컨벤션 March 22nd 2015
<br>
<br>자랑스럽고 활기찬 싱가폴 마리나 베이 샌드 엑스포 및 컨벤션 센터에서 열릴 우리의 두번째 애뉴얼 맥심 트레이더 컨벤션을 놓치고 싶지 않으시겠죠.
<br>
<br>프로모션 기간 : 2014년 11월 20일부터 2014년 1월 28일
<br>
<br>자격요건 : 3만불 패키지 또는 그 이상의 단일 맥심 계좌 또는 AGL 패키지(들) 구매
<br>
<br>혜택 : 마리나 배이 샌드 엑스포 및 컨벤션 센터에서 열릴 맥심 트레이더 싱가폴 컨벤션 및 갈라 디너 참석 티켓 1매
<br>
<br>주의 : 3만불 이상 시 금액에 관계없이 UserID 당 티켓 1매
<br>
<br>4,000명 한정입니다.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='46'>STRICTLY NO CROSS LINE OF MEMBERS IN MAXIM & AGL
                <br>马胜及AGL业务之间严格不可跨线
                <br>マキシム＆AGLにおいてのメンバークロスライン行為禁止について
                <br>맥심과  AGL 사이의 크로스 라인을 엄격히 금지합니다.</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "1 December 2014";
                ?>
            </div>

            <div id="page_46" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear IMs and Partners
<br>亲爱的会员及伙伴们:
<br>
<br>(1) PLEASE BE REMINDED THAT CROSS LINING AND POACHING UNDER ANY CIRCUMSTANCES IS STRICTLY  PROHIBITED  IN BOTH  MAXIM & AGL NETWORK
<br>请注意在马胜及AGL业务中, 任何形式的跨线或抢线都是被严格禁止的.
<br>
<br>(2) SEVERE ACTION (LEADING TO SUSPENSION AND TERMINATION) WILL METED OUT AGAINST THOSE WHO BLATANTLY IGNORE OUR CODE OF ETHICS
<br>对于任何无视公司道德标准指南的会员, 公司将采取严厉打击措施(如注销会员代理资格等).
<br>
<br>3) THOSE AFFECTED BY CROSS LINING AND POACHING NEED ONLY SUBMIT A FORMAL WRITTEN COMPLAINT TO LACD TO INITIATE AN INVESTIGATION AND THEREAFTER RECTIFY LINEAGE
<br>所有受非法越线或抢险影响的会员, 请向公司LACD法律部提交正式的书面投诉, 公司将根据投诉案件启动调查,并作出公正裁决;
<br>
<br>By a Order 命令
<br>CEO 首席执行官
<br>Maxim Capital Limited
<br>马胜资本有限公司
<br>
<br>IMおよびパートナーのみなさま
<br>
<br>
<br>(1) マキシムおよびAGLの両ネットワークにおいてクロスライン（越境）行為と侵入行為は堅く禁止されていますことをご承知ください。
<br>
<br>(2) この倫理規定に背いた場合、厳しい措置（停止や終了を導くもの）をとることになります。
<br>
<br>(3) クロスライン行為や侵入行為に関わったものに対しては、捜査を開始し、さらに系統を改正するために、LACDに正式な訴状を提出します。
<br>
<br>命令により
<br>CEO
<br>マキシム・キャピタル・リミテッド
<br>
<br>
<br>(1) 맥심과  AGL의 네트웍의 크로스 라인을 하거나 불법으로 들어가는 것은 어떠한 경우에도 엄격히 금지되고 있습니다.
<br>
<br>(2) 노골적으로 윤리를 무시하는 회원들게게는 엄격한 처벌 (자격정지 또는 박탈에 해당되는)이 내려질 것입니다.
<br>
<br>(3) 크로스 라인 행위를 하거나 불법 침입의 폐해를 받은 회원들은 LACD에게 서면으로 불편사항을 보내시면 조사가 행해지고 정정이 이루어질 것입니다.
<br>
<br>명령에 의한 메시지입니다.
<br>CEO
<br>맥심 캐피탈 주식회사
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='45'>FRAUDULENT Act
                <br>欺诈性行为通告
                <br>不正行為について
                <br>사기행위</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "1 December 2014";
                ?>
            </div>

            <div id="page_45" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear Partners & IMs
<br>亲爱的伙伴及代理们:
<br>
<br>Most recently, several IMs have reported to the company that they have been offered "stolen/unauthorized" CP1, CP2 & CP3 points from individuals claiming that they are from the company.
<br>最近有个别代理向公司反应有人向他们兜售自称来自公司但实际上却是"盗取或未经认证的"CP1,CP2及CP3分数.
<br>
<br>NB1: THE COMPANY HAS NOT AUTHORIZED ANY INDIVIDUAL/CORPORATE TO SELL IN BULK CP POINTS AT DISCOUNTED RATES.
<br>注1: 公司未认证任何个人或者集体以折扣的价格批量销售任何CP分数.
<br>
<br>NB2: THE COMPANY WOULD LIKE TO ADVISE ALL IMs NOT TO BUY CP POINTS FROM UNAUTHORIZED IMs AND STRANGERS.
<br>注2: 公司建议所有的代理不要从未认证的代理或者陌生人那里购买CP分数.
<br>
<br>NB3: THE COMPANY HAS THE RIGHT TO VOID THE ACCOUNT/PLACEMENT IF PROVEN THAT IT WAS ACTIVATED WITH STOLEN/UNAUTHORIZED  CPs. FURTHER MORE, THE COMPANY WILL CLAW BACK ALL COMMISSIONS PAID-OUT AS A RESULT OF PLACEMENTS MADE WITH STOLEN/UNAUTHORIZED CP points
<br>注3: 如果调查结果证明有涉嫌盗取或者未经认证的CP分数, 公司有权取消所有相关账户及账户的安置; 另外, 公司将收回所有相关涉嫌盗取或未经认证的CP分数账户及安置所产生的佣金及奖金分数.
<br>
<br>NB4: THE COMPANY WILL NOT HESITATE TO SUSPEND/ TERMINATE ANYONE WHO PARTICIPATES IN THIS FRAUDULENT ACT OF BUYING AND SELLING OF STOLEN/UNAUTHORIZED CP POINTS
<br>注4: 公司将坚决吊销/终止所有参与盗取或未经认证CP分数买卖的代理之代理资格.
<br>
<br>NB5: THE COMPANY WILL NOT HESITATE TO PROSECUTE THOSE INVOLVED IN THESE FRAUDULENT
<br>DEEDS AND BLATANT ACT OF THEFT.
<br>注5: 公司将采取严厉措施,控告所有参与这一嚣张的欺诈性行为的人员.
<br>
<br>Dr Andrew Lim 博士
<br>CEO 首席执行官
<br>Maxim Capital Limited
<br>马胜资本有限公司
<br>
<br>
<br>親愛なるパートナーおよびIMのみなさん
<br>
<br>最近、何人かのIMからの報告によれば、社から提供されたと主張する「盗まれた・非公式の」CP1、CP2、CP3ポイントを提供する個人がいるそうです。
<br>
<br>注意1：弊社はいかなる個人／会社に対しても、CPポイントをディスカウントレートでバルク販売することはしません。
<br>
<br>注意2：弊社はすべてのIMに非公式のIMおよび見知らぬ人からのCPポイントを購入しないように忠告します。
<br>
<br>注意３：弊社は、盗難による／非公式のCPによってアクティベートされたと証明された場合に、そのアカウント／プレイスメントを取り消す権利を有しています。さらに、弊社は盗難による／非公式のCPポイントによって得られたプレイスメントによって生じたすべての支払い済みのコミッションを取り戻す権利を持っています。
<br>
<br>注意４：弊社は盗難による／非公認のCPポイントを買ったり売ったりした不正行為に参加した人のアカウントをを停止／終了させることを厭いません。
<br>
<br>注意５：弊社はこれらの不正行為や露骨な盗難行為をした人を告訴することを厭いません。
<br>
<br>アンドリュー・リム博士
<br>CEO
<br>マキシム・キャピタル・リミテッド
<br>
<br>
<br>친애하는 파트너 및 국제회원 여러분
<br>최근 몇몇 회원들로부터 회사 직원을 사칭하는 개인이 “도난/무단” CP1, CP2와 CP3포인트를 제안한다는 사실이 확인되었습니다.
<br>
<br>주의 1 : 회사는 절대 어떠한 개인 또는 회자 직원이 할인 가격으로 대량의 CP 포인트를 팔도록 승인하지 않습니다.
<br>
<br>주의2: 회사는 국제회원 여러분들이 승인받지 않은 다른 국제회원 또는 낯선 이로부터 CP 포인트를 사지 말 것을 당부합니다.
<br>
<br>주의 3: 회사는 도난/무단 CP로 활성화된 계좌 또는 위치를 무효화 할 권리가 있습니다. 더 나아가서, 회사는 도난/무단 CP 포인트로 결정된 배치에 의한 커미션을 모두 상환시킬 것입니다.
<br>
<br>주의4: 회사는 이러한 사기 행각에 가담하여 도난/무단 포인트의 판매 또는 구매한 회원 자격의 유예/박탈하는 것을 주저하지 않을 것입니다.
<br>
<br>주의5 : 회사는 이러한 사기 행위와 노골적인 절도행위에 가담한 사람들을 고소할 것을 주저하지 않을 것입니다.
<br>
<br>앤드류 림 박사
<br>CEO
<br>맥심 캐피탈 주식회사
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='43a'>Notification to all members to open iAccount by 31 December 2014 in order to improve monthly withdrawal process</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "1 December 2014";
                ?>
            </div>

            <div id="page_43a" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear Client,
<br>
<br>We wish to achieve greater efficiency, speed and economies of scale in the monthly withdrawal process. As such, we would like to introduce uniformity in the withdrawal mode and credit the withdrawal amounts into your e-wallet by the 11th of every month.
<br>
<br>In order to achieve this, we urge you to open an iAccount latest by 31 December 2014 so that all withdrawals could be credited into your personal iAccount from January 2015 onwards. Once credited into your iAccount, you may withdraw the amount anytime, at your convenience.
<br>
<br>Kindly log-on to www.maximtrader.com and click the iAcccount hyperlink to apply an iAccount and base debit card at the same time. Please ensure you upload your Passport or National ID and Proof of Mailing (POM) in colour, as part of the iAccount application requirements.
<br>
<br>Your kind co-operation and prompt action shall be highly appreciated.

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='44'>Change in CURRENCY EXCHANGE RATE (27/11Change in CURRENCY EXCHANGE RATE (27/11/2014):
                    <br>2014.11.27日 货币兑换比例调整通知</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "28 November 2014";
                ?>
            </div>

            <div id="page_44" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear IMs and Partners
<br>亲爱的会员及伙伴们:
<br>
<br>In an effort to serve you better and with IMMEDIATE EFECT, please NOTE that we have revised our currency exchange rates.
<br>为了更好的服务大家，敬请留意以下货币兑换比例调整通知。该调整即时生效。
<br>
<br>The currency exchange rate revision is in line with the rising value of the US Dollar over the months. The management has revised some currency exchange rates as the company can not provide rates which are lower than the market.
<br>此次货币兑换比例的变更是因为美元在过去几个月的走势发生了很大的变化。因为公司无法提供比市场更低的利率，因此公司已经调整了个别币种的兑换比例。
<br>
<br>One of the currency exchange rate that has been revised is the JAPANESE YEN. Effective from 1st Dec 2014, the revised rate will be 130 YEN to 1 USD.
<br>其中之一被调整的币种为日元；从2014.12.1日起，日元入金比例将调整为130日元兑1美金。
<br>
<br>Any bank transfer to Corporate Bank Account in US dollars is subject to 10% Fund Management Cost and hereby the 1:1.1 ratio (For a USD10,000 package, members should transfer USD11,000) .
<br>所有以美金为货币汇款至公司账户款项都需支付10%的外汇FMC管理费用；因此请按照1:1.1的比例汇款(即客户购买1万美金配套,需转款1万1千美金)。
<br>
<br>The latest currency exchange rates can be found in the ANNOUNCEMENT page inside the PARTNER AREA.
<br>有关最新货币兑换比例信息，请参照会员网站公告区。
<br>
<br>The Management
<br>Maxim Capital Limited
<br>马胜金融集团管理层
<br>November 27th 2014
<br>
<br>通貨交換レートの変換について（27/11/2014）
<br>
<br>IMおよびパートナーの皆様
<br>
<br>迅速な効果を伴ったよりよいサービス提供のために、私たちは為替レートの改訂を行います。
<br>
<br>為替レートの変更は、ここ数ヶ月のUSドルの価値上昇によるものです。マネジメントは、マーケットよりも低いレートを提供するわけにはいかないために、いくつかの為替レートを変更します。
<br>
<br>すでに変更された為替レートには日本円があります。改訂レートは130円=1USDです。これは2014年12月1日から実施になります。
<br>銀行からコーポレートバンク・アカウントへのUSドルでの支払いは、10％の資金管理コストがかかります。そのため、比率は1:1.1となります（USD10,000パッケージに対して、メンバーはUSD11,000を送金しなくてはなりません）。
<br>
<br>最新の通貨交換レートにつきましてはパートナーエリアの「ANNOUNCEMENT」ページをご覧ください。
<br>
<br>マネージメント
<br>マキシム・キャピタル・リミテッド
<br>2014年11月27日
<br>
<br>환율 변경 (27/11/2014):
<br>
<br>친애하는 회원 및 파트너 여러분
<br>
<br>여러분들께 더 나은 서비스를 드리고자 환율을 변경하게 되었음을 알려드립니다. (바로 실행됩니다.)
<br>환율 변경은 지난 몇달 동안 지속되어온 미국 달러 가치의 변화의 일환입니다. 당사는 시장의 환율보다 아래의 환율로 제공할 수 없기 때문에 변경을 결정합니다.
<br>
<br>변경되는 환율 중 하나가 일본 엔입니다. 2014년 12월 1일부로 변경될 환율은 1달러 당 130원입니다.
<br>
<br>본사 구좌로 미국 달러를 송금할 경우, 펀드 매니지먼트 비용 10%이 차감되며 이로 인하여 1:1.1 비율이 적용됩니다. (예를 들어 미화 10,000불 패키지의 경우 회원은 미화 11,000불을 송금하여야 합니다.)
<br>
<br>맥심 캐피탈 임직원
<br>2014년 11월 27일
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='43'>This coming US Thanksgiving holiday on 27th November 2014, the business will be as usual.</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "26 November 2014";
                ?>
            </div>

            <div id="page_43" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear Client,
<br>
<br>This coming US Thanksgiving holiday on 27th November 2014, the business will be as usual.
<br>Please note that liquidity is expected to be thin with many banks not participating, especially for XAUUSD & XAGUSD when Gold futures on CME/Comex is CLOSED during the following periods. This may result in unusually WIDE spreads:
<br>
<br>- 28 Nov 2014 0200hrs - 0700hrs (SG/HK Time)
<br>- 29 Nov 2014 0245hrs - 0600hrs (SG/HK Time)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='42'>Change in CURRENCY EXCHANGE RATE (21/11/2014)<br>2014.11.20日 货币兑换比例调整通知<br>환율 변경 (21/11/2014)<br></a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "21 November 2014";
                ?>
            </div>

            <div id="page_42" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>
<br>Dear IMs and Partners
<br>亲爱的会员及伙伴们:
<br>
<br>In an effort to serve you better and with IMMEDIATE EFECT, please NOTE that we have revised our currency exchange rates.
<br>为了更好的服务大家，敬请留意以下货币兑换比例调整通知。该调整即时生效。
<br>
<br>The currency exchange rate revision is in line with the rising value of the US Dollar over the months. The management has revised some currency exchange rates as the company can not provide rates which are lower than the market.
<br>此次货币兑换比例的变更是因为美元在过去几个月的走势发生了很大的变化。因为公司无法提供比市场更低的利率，因此公司已经调整了个别币种的兑换比例。
<br>
<br>One of the currency exchange rate that has been revised is the KOREAN WON. The revised rate is now 1250 WON to 1 USD.
<br>其中之一被调整的币种为韩元，现在比例为1美元兑1250韩元。
<br>
<br>Any bank transfer to Corporate Bank Account in US dollars is subject to 10% Fund Management Cost and hereby the 1:1.1 ratio (For a USD10,000 package, members should transfer USD11,000) .
<br>所有以美金为货币汇款至公司账户款项都需支付10%的外汇FMC管理费用；因此请按照1:1.1的比例汇款(即客户购买1万美金配套,需转款1万1千美金)。
<br>
<br>The latest currency exchange rates can be found in the ANNOUNCEMENT page inside the PARTNER AREA.
<br>有关最新货币兑换比例信息，请参照会员网站公告区。
<br>
<br>The Management
<br>Maxim Capital Limited
<br>马胜金融集团管理层
<br>November 21st, 2014
<br>
<br>
<br>IMおよびパートナーの皆様
<br>
<br>迅速な効果を伴うよりよいサービス提供のために、私たちは為替レートの改訂を行います。
<br>
<br>為替レートの変更は、ここ数ヶ月のUSドルの価値上昇によるものです。マネジメントはいくつかの為替レートを変更します。弊社がマーケットよりも低いレートを提供するわけにはいかないからです。
<br>
<br>すでに変更された為替レートには韓国ウォンがあります。改訂レートは1250ウォン=1USDです。
<br>
<br>銀行からコーポレートバンク・アカウントへのUSドルでの支払いは、10％の資金管理コストがかかります。そのため、比率は1:1.1となります（USD10,000パッケージに対して、メンバーはUSD11,000を送金しなくてはなりません）。
<br>
<br>最新の通貨交換レートにつきましてはパートナーエリアの「ANNOUNCEMENT」ページをご覧ください。
<br>
<br>マネージメント
<br>マキシム・キャピタル・リミテッド
<br>2014年11月21日
<br>
<br>
<br>친애하는 회원 및 파트너 여러분
<br>
<br>여러분들께 더 나은 서비스를 드리고자 환율을 변경하게 되었음을 알려드립니다. (바로 실행됩니다.)
<br>환율 변경은 지난 몇달 동안 지속되어온 미국 달러 가치의 변화의 일환입니다. 당사는 시장의 환율보다 아래의 환율로 제공할 수 없기 때문에 변경을 결정합니다.
<br>
<br>변경되는 환율 중 하나가 한국 원입니다. 변경된 환율은 1달러 당 1,250원입니다.
<br>
<br>본사 구좌로 미국 달러를 송금할 경우, 펀드 매니지먼트 비용 10%이 차감되며 이로 인하여 1:1.1 비율이 적용됩니다. (예를 들어 미화 10,000불 패키지의 경우 회원은 미화 11,000불을 송금하여야 합니다.)
<br>
<br>가장 최근의 환율은 파트너 에리어의 공지사항에서 보실 수 있습니다.
<br>맥심 캐피탈 임직원
<br>2014년 11월 21일
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='41'>MBank Visa Card Service Termination Notice<br>马胜MBank Visa借记卡服务暂停公告</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "29 October 2014";
                ?>
            </div>

            <div id="page_41" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear IMs and Partners,
                            <br>亲爱的会员及领导们:
                            <br>
                            <br>Please kindly note that due to the past problems with MBank Visa Cards, the company has decided to terminate their service.  All the balance in accounts will be returned to our members CP3 accounts by 31 Oct 2014, after which you are welcome to apply for i-Accounts in Member Area.
                            <br>请注意，鉴于MBank的Visa Card多次出现问题，公司决定终止与其的合作关系。公司会安排所有客户Visa卡的余额在2014.10.31日之前返还至CP3账户。之后欢迎会员申请i-Account。
                            <br>
                            <br>We apologize again for the inconvenience, yet please understand the company is doing so because we believe all our members deserve the best service. We very much appreciate your understanding and cooperation!
                            <br>为此给您带来的不便我们深表歉意；但公司这样做正是因为我们一直将客户的利益谨记于心。谢谢大家的理解与配合！
                            <br>
                            <br>Mgmt of MCL
                            <br>马胜金融集团管理层
                            <br>
                            <br>
                            <br>
                            <br>MBankビザカードサービス終了のお知らせ
                            <br>
                            <br>IMおよびパートナーの皆様
                            <br>
                            <br>過去にあった問題により、MBankビザカードのサービスを終了することになったことをお知らせします。この口座のすべての残高はメンバーのCP3アカウントに、2014年10月31日までにお戻しします。その後、メンバーエリアのi-Accountsへの申し込みを歓迎します。
                            <br>
                            <br>さらなるご不便をおかけすることをお詫びします。弊社がこのような措置を取ったのは、弊社メンバーの皆様に最良のサービスがふさわしいと信じているからだということをご理解ください。ご協力とご理解に感謝します！
                            <br>
                            <br>MCLマネジメント
                            <br>
                            <br>
                            <br>
                            <br>MBank 비자카드 서비스 만료 공지
                            <br>
                            <br>국제회원 및 파트너님께,
                            <br>
                            <br>지난 MBank 비자카드의  문제 발생 이후로, 회사는  본 서비스를 종료하기로 결정하였음을 알려드립니다. 계좌에 있는 모든 잔액은 2014년 10월31일까지 우리의 회원 CP3 계좌로 다시 예치될 것입니다. 이후 홈페이지 멤버 에리어에서 i-account를 신청 하시기 바랍니다.
                            <br>
                            <br>다시 한번 불편을 끼쳐드린 점 죄송하게 생각하며, 회사는 회원들이 최상의 서비스를 드리기 위해서 이런 결정을 내리게 되었음을 이해해 주시기 바랍니다. 여러분의 이해와 협력에 깊은 감사를 드립니다.
                            <br>
                            <br>MCL 관리팀
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='40'>October PROMO - Maxim GOLD CHALLENGE !!!<br>10月促销 - 马胜金融金钞挑战计划!</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "21 October 2014";
                ?>
            </div>

            <div id="page_40" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br><img width="580" src="/images/201410/maxim_gold.jpg">
                            <br>Period: 1/10/2014 to 31/10/2014 2359hrs (GMT+8)
							<br>挑战时间: 2014.10.1-10.31日23:59分(GMT+8)
							<br>
							<br>To Qualify: Directly Sponsor 2 x USD100k VVIP AccountS
							<br>挑战条件: 直接推荐2个VVIP10万美金的账户
							<br>
							<br>Entitle: 1 Set of Limited Edition Commemorative Medallion (1 Gold Note & 2 Gold Coins 999.9 pure certified by Government Labs with a total combined weight of 37grams ) 
							<br>优惠获得：限量纪念版金钞1套(含经官方验证999.9纯金-金钞1张、金币2枚, 共重达37克)
							<br>
							<br>plus
							<br>及
							<br>
							<br>1 Entry Ticket to Maxim Trader Annual Convention & Gala Dinner 2015 in Phuket, Thailand (TBC). 
							<br>马胜金融集团2015泰国普吉岛(待确认)年会及晚宴门票1张
							<br>
							<br>Say YES to Maxim Trader..... Yes!!!!
							<br>确认马胜说: YES!!!!
							<br>
							<br>10월 프로모 – 맥심 골드 챌린지!!!!
							<br>
							<br>기간 : 1/10/2014 에서 31/10/2014 23시 59분
							<br>
							<br>자격요건 : 직접 추천 2 X USD10만불 VVIP 구좌들
							<br>
							<br>상품 : 기념 메달 리미티드 에디션 1 세트 (금권 1개와 금화 2개 총 무게 37그램, 정부 허가 기관에서 인증한 순도 999.9)
							<br>
							<br>와 함께
							<br>
							<br>태국 푸켓(추후 확정)에서 열리는 맥심 트레이더 컨벤션 및 갈라 디너 2015 참석권 1개
							<br>
							<br>맥심에게 예스라고 하세요… 예스!!!!
							<br>
							<br>10月プロモーション-マキシム・ゴールド・チャレンジ!!!
							<br>
							<br>期間:2014年10月1日〜10月31日　23時59分（GMT＋8）
							<br>
							<br>資格:ダイレクトなスポンサー2　×　USD100k VVIPアカウントS
							<br>
							<br>権利:限定バージョンの記念メダル1セット（金券1枚と政府の研究所で認定された37グラムの2枚の純粋な24金コイン）
							<br>
							<br>プラス
							<br>
							<br>2015年タイ・プーケット島におけるマキシムトレーダー年次コンベンション＆ガラディナーへの招待チケット1枚(追って確定予定です)
							<br>
							<br>マキシムトレーダーにYESと言ってください……YES!!!!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='39'>News on Visa Debit Card Service Interruption<br>马胜借记卡服务暂停通告</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "06 October 2014";
                ?>
            </div>

            <div id="page_39" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear IMs and Partners,
                            <br>亲爱的会员及领导们:
                            <br>
                            <br>We are sorry to inform you that due to technical difficulties with Mbank, our Visa Debit Card service was affected during the past few days.  We hope that Mbank could solve current problems soonest.  We shall liaise with Mbank continuously and give you update on this matter as soon as we receive news from them.
                            <br>很抱歉地通知大家-因为MBank出现技术问题，我们的Visa Debit借记卡服务在过去几天受到了影响。我们希望MBank可以尽快解决该问题。公司会积极跟进，稍后若有回复，我们会第一时间告知。
                            <br>
                            <br>Your understanding and attention to this matter is much appreciated. We sincerely apologize for all inconvenience caused.
                            <br>敬请谅解与配合。为此给您带来的不便，我们深表歉意。
                            <br>
                            <br>Mgmt of MCL
                            <br>马胜金融集团管理层
                            <br>
                            <br>
                            <br>
                            <br>ビザ・デビットカードサービス中断のお知らせ
                            <br>
                            <br>親愛なるIMおよびパートナーの皆様、
                            <br>
                            <br>Mbankの技術的問題のため、私たちのビザ・でビットカードサービスがここ数日影響を受けていることをお詫びします。我々はMbankがこの問題を早急に解決することを望んでいます。Mbankはこの問題に関してMbankからの継続的な情報を得るとともに、新たな情報があり次第お客様にお知らせします。
                            <br>
                            <br>この問題に関してご理解とご注意いただき感謝します。ご不便をおかけしておりますことを心よりお詫びいたします。
                            <br>
                            <br>MCLマネージメント
                            <br>
                            <br>
                            <br>
                            <br>비자 데빗카드 서비스 중단
                            <br>
                            <br>친애하는 국제회원 및 파트너 여러분
                            <br>
                            <br>Mbank의 기술적인 문제에 의해 데빗 카드 서비스가 지난 몇일동안 영향을 받았왔음에 유감을 표명합니다.  Mbank가 현재 문제를 빠른 시일내에 해결 할 수 있기를 바랍니다.  당사는 Mbank와 지속적인 협조를 할 것이며, 새로운 소식을 받는 즉시 알려드리겠습니다.
                            <br>
                            <br>귀하의 이해와 이 사항에 대한 관심에 감사드립니다.  불편을 끼쳐드려서 죄송합니다.
                            <br>
                            <br>맥심 매니지먼트
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='38'>Important Announcement</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "15 September 2014";
                ?>
            </div>

            <div id="page_38" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear All,
                            <br>
                            <br>Due to technical deficiency, the connection to bank encountered power outrage, causing the price feed to stop. All prices resumed at 0900 Singapore time. We sincerely apologies for the unancipated error and strived to serve you better in the near future.
                            <br>
                            <br>Thank you.
                            <br>
                            <br>IT & Support
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='37'>Rookie Challenge EXTENDED TO SEPTEMBER 19th, 2014 !!!!</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "9 September 2014";
                ?>
            </div>

            <div id="page_37" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear All....
                            <br>所有的伙伴们：
                            <br>
                            <br>ROOKIE CHALLENGE !!!
                            <br>最新针对新伙伴挑战计划!!!
                            <br>
                            <br>Proudly and for the first-time ever, we are having a promo for Rookie IMs and Partners who as long as from date joined till now, are not over 6 calendar months .....
                            <br>有史以来第一次公司针对新会员及伙伴们开放此政策，只要您加入马胜不超过6个(自然)月，您就可以享受该优惠！
                            <br>
                            <br>Challenge Period: August 8th to September 19th, 2014
                            <br>优惠时间: 2014.8.8-9.19日
                            <br>
                            <br>Direct Sponsor:
                            <br>直接推荐:
                            <br>
                            <br>USD50,000 to USD99,000 will receive an Extra 5%
                            <br>50,000-99,000美金可额外享受5%奖金
                            <br>
                            <br>USD100,000 to USD199,000 will receive an Extra 6%
                            <br>100,000-199,000美金可额外享受6%奖金
                            <br>
                            <br>USD200,000 to USD300,000 will receive an Extra 7%
                            <br>200,000-300,000美金可额外享受7%奖金
                            <br>
                            <br>Nb1: Rookie Challenge Bonus will be credited into CP1
                            <br>注1：该项奖金将会进入CP1账户
                            <br>
                            <br>Nb2. Rookie member who joined on 2014 March, April, May, June, July, August & September entitled only.
                            <br>注2: 该项奖金只对于2014年3月、4月、5月、6月、7月、8月、9月加入马胜的会员。
                            <br>
                            <br>Come On Rookies ...... This is your chance to shine and reap your reward$$$
                            <br>加油吧，所有新伙伴们！这是专属您闪亮炫耀的机会！
                            <br>
                            <br>
                            <br>회원 여러분..
                            <br>
                            <br>새회원 챌린지!!!!
                            <br>
                            <br>처음으로 자랑스럽게 새로운 국제 회원 여러분과 파트너들을 위한 프로모션을 발표합니다. 새 회워 자격은 최초로 회사에 합류한 일자가 지금부터 6개월 이내의 회원을 의미합니다.
                            <br>
                            <br>도전 기간 : 2014년 8월 8일에서 9월 19일까지
                            <br>직 스폰서/개인 매출 : USD50,000부터 USD99,000 은 추가 5%를 받습니다.
                            <br>USD100,000부터 USD199,000은 추가 6%를
                            <br>USD200,000부터 USD300,000은 추가 7%를 받게 됩니다.
                            <br>
                            <br>참고 1: 새 회원 도전 보너스는 CP1 계좌로 들어갑니다.
                            <br>참고 2: 2014 3월, 5월, 6월, 7월, 8월, 9월에 등록한 새 회원들만 도전이 가능합니다,
                            <br>
                            <br>도전하세요, 새 회원 여러분... 여러분의 보상을 거둬들이고 밝혀줄 기회입니다.
                            <br>
                            <br>
                            <br>親愛なるみなさま……
                            <br>
                            <br>ルーキー・チャレンジ
                            <br>
                            <br>今回初めて、そして大変誇らしいことに、私たちは6ヵ月以内に参加してくれた新人のIMとパートナーの皆様に向けてプロモーションを開始しました。
                            <br>チャレンジ期間　2014年8月8日〜9月19日
                            <br>ダイレクトスポンサー／パーソナルセールス
                            <br>USD50,000〜99,000　の方はさらに5％
                            <br>USD100,000から199,000の方はさらに6％
                            <br>USD300,000〜300,000の方はさらに7％
                            <br>
                            <br>1　ルーキーチャレンジボーナスはCP1にクレジットされます。
                            <br>2　2014年3月、4月、5月、6月、7月、8月、9月に参加したメンバーのみがルーキーとなります。
                            <br>
                            <br>来れルーキーたちよ ...... あなたの報酬を輝かせて刈り取るチャンスです！
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='36'>Server Maintenance</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "5 September 2014";
                ?>
            </div>

            <div id="page_36" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear IMs and Partners,
                            <br>亲爱的领导人与会员们:
                            <br>
                            <br>Please be informed that we will doing maintenance on our server between the hours of 0000hrs to 0600hrs GMT ON Saturday September 6th 2014.
                            <br>公司将于2014.9.6日周六凌晨12:00至早上6:00进行系统及服务器的维护，敬请留意。
                            <br>
                            <br>We apologize for any inconvenience cause and assure you that we are constantly looking into improving our support services to achieve service excellence for you.
                            <br>为此给大家带来的不便，我们深表抱歉。公司一直竭尽全力为大家提供更好的服务。
                            <br>
                            <br>Thank you.
                            <br>谢谢
                            <br>
                            <br>IT & Support
                            <br>技术支持部
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php if ($culture == "cn" || $culture == "en") {?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='35'>Latest update on Bali IME: 巴厘岛IME国际金融交流会最新公告</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "21 July 2014";
                ?>
            </div>

            <div id="page_35" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td align="center">
                                <span style="font-size: 20px; color: red"><?php echo __("Remaining");?> : <?php echo $totalMemberEntitle;?></span>
                                <br>
                                <br>
                                <span style="font-size: 20px; color: red">
We are pleased to announce that the Door Tickets for our Maxim BALI IME Convention & Gala Dinner (Sept 20th, 2014) is hereby declared CLOSED and that the 2,500 tickets have been completely SOLD OUT.
<br>
<br>Thank you all for your continuing  support of Maxim's Events.
<br>
<br>Say YES to Maxim Trader....... !!!!</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear IMs & Partners,
                            <br>亲爱的领导人与伙伴们：
                            <br>
                            <br>We are pleased to announce that the dates for our Bali IME are confirmed for September 19th to 22nd with our Gala IME Dinner in the luxurious and spectacular Bali Convention Centre on September 20th.
                            <br>我们很荣幸地告知大家我们的2014巴厘岛IME国际金融交流会将会于9.19-22日在巴厘岛会议中心隆重举行,庆祝晚宴时间为9.20日晚上！
                            <br>
                            <br>By the way, we have only a maximum 2,500 pax available for this event and as of TODAY (July 19), there is only 750 pax left....
                            <br>另外，此次活动场地只能接纳2500人，到今天(2014.7.19日)截止，仅剩下750个名额......
                            <br>
                            <br>Hurry, sign up for your package, get yourself qualified, pack your bags and let the romantic island of Bali seduce you with her culture, charms and beauty.
                            <br>加油吧！注册配套，打包行李，神秘浪漫的巴厘岛正在等着您！
                            <br>
                            <br>Say YES to Maxim Trader......
                            <br>确认马胜说: YES!
                            <br>
                            <br>IMおよびパートナーの皆様
                            <br>
                            <br>バリIMEの最新のアップデート
                            <br>
                            <br>親愛なるIMおよびパートナーの皆様
                            <br>
                            <br>私たちはバリIMEの日程が9月19日〜22日に確定しましたことを喜んでお伝えします。9月20日には豪華で壮大なバリコンベンションセンターでのガラディナーも行われます。
                            <br>
                            <br>ところで、私たちはこのイベントに対して、2500席しかご用意しておらず、現在のところ(7月19日)、750席しか残っておりません。
                            <br>
                            <br>どうぞ急いで、パッケージのサインアップをしてください。資格を得ていただき、バッグを支度し、バリのロマンティックな島にその文化と魅力、美しさで貴方を誘惑させてください。
                            <br>
                            <br>マキシムトレーダーにYESを言ってください。
                            <br>
                            <br>국제회원 및 파트너 여러분,
                            <br>
                            <br>발리 IME 일자가 9월 19알에서 22일로 확정되었음을 기쁘게 알려드립니다. 갈라 IME 디너는 화려하고 웅장한 발리 컨벤션 세터에서 9월 20일 열리게 될 것입니다.
                            <br>
                            <br>참조. 이 이벤트에 2,500 좌석만 입장이 가능하며 오늘부로 (7월 19일), 750좌석만이 남았습니다.
                            <br>
                            <br>서두르십시요. 패키지에 서명하셔서 자격을 충족하세요. 가방을 싸서 로맨티한 섬 발리가 자신의 매력적인 문화와 아름다움으로 당신을 유혹하게 하세요.
                            <br>
                            <br>맥심 트레이더에 예스라고 하세요.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php } ?>
    <?php if ($culture == "cn" || $culture == "en") {?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='34'>Bali IME Convention Promo 马胜巴厘岛国际金融交流会优惠计划</a>>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "9 July 2014";
                ?>
            </div>

            <div id="page_34" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear IMs and Partners,
                            <br>
                            <br>Promo Period: June15th to August 15th, 2014
                            <br>优惠时期：2014.6.15-8.15日
                            <br>
                            <br>To Qualify: Sign Up for USD30k & above package
                            <br>Entitle: 1 door ticket to Maxim Trader Bali IME Convention & Gala Dinner
                            <br>优惠项目：购买3万美金及以上配套
                            <br>优惠获得：马胜巴厘岛国际金融交流会议及晚宴门票一张
                            <br>
                            <br>Nb. Maximum 1 ticket per UserID
                            <br>注：一个账户ID只能享受一张票
                            <br>
                            <br>(Above Promo applies for all countries except Japan, Korea and Australia)
                            <br>(以上优惠针对所有会员国家，除开日本、韩国以及澳大利亚)
                            <br>
                            <br>The beautiful and romantic island of Bali is calling you..... Hurry, we have limited seats left for the Maxim Trader Bali IME Gala Dinner  ..... !!!!
                            <br>神秘浪漫的巴厘岛正在等待着您的到来！名额有限，机不可失，加油吧!!!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
    <?php } ?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='27'>Effective Sep 30th, 2014 the minimum package to sign up with Maxim Trader is our Gold Package of USD5,000</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "19 June 2014";
                ?>
            </div>

            <div id="page_27" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear IMs and Partners,
                            <br>
                            <br>Effective Sep 30th, 2014 the minimum package to sign up with Maxim Trader is our Gold Package of USD5,000.
                            <br>
                            <br>This decision has been a long time coming and very much in line with our objective to become an Icon in the Forex and Fund Management industry which is the aspiration of all our IMs and Partners.
                            <br>
                            <br>Say YES to MAXIM TRADER !!!!
                            <br>
                            <br>尊敬的领导人与伙伴们：
                            <br>
                            <br>从2014.9.30日起生效-马胜金融集团最低投资配套额度将变为黄金配套5000美金.
                            <br>
                            <br>公司有此决定由来已久，这也与希望将公司打造成外汇与基金管理界领军企业的远景不谋而合。
                            <br>
                            <br>确认马胜说：YES!
                            <br>
                            <br>친애하는 국제회원 및 파트너 여러분,
                            <br>
                            <br>2014년 9월 30일부터 맥심 트레이더에 사인하는 최소 패키지는 미화 5천불의 골드 패키지입니다.
                            <br>
                            <br>이 결정은 오래전에 정해진 결정이며 외환과 펀드 매니지먼트 산업의 아이콘이 되고자 하는 모든 국제 회원과 파트너의 염원을 목표로 하는 것과 같은 선상에 있습니다.
                            <br>
                            <br>맥심 트레이더에게 “예스”라고 합시다.
                            <br>
                            <br>IM(インターナショナルメンバー)およびパトナーの皆様
                            <br>2014年9月30日より、マキシマムトレーダーの最小投資金額は5,000ドルのゴールドパッケージとなります。この変更は、マキシマムトレーダーを、為替・ファンドマネジメント業界のリーダーにする経営目標、そして、IM(インターナショナルメンバー)およびパトナーたちの期待を考慮した上で、長時間にわたって決定したことである。
                            <br>マキシマムトレーダーの更なる成長に、「イエス」と言いましょう！！
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='32'>Development bonus reduction announcement</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "04 July 2014";
                ?>
            </div>

            <div id="page_32" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            Dear Partners and Leaders,
                            <br>
                            <br>Please note that with effect from 1 August 2014, Development Bonus will be calculated based on BV. Development Bonus of USD 1 will have a value of 0.5 BV. All other bonuses and Return on Investment will remain unchanged.
                            <br>
                            <br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='33'>04 July 2014 - US Independence Day Holiday</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "03 July 2014";
                ?>
            </div>

            <div id="page_33" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            亲爱的领导人与伙伴们：
                            <br>
                            <br>以下是即将来临的市场假期 。
                            <br>04 July 2014 - US Independence Day
                            <br>
                            <br>当日潜在市场流通性不足的情况，可能导致点差扩大，请相应地计划您的交易。
                            <br>
                            <br>黄金和白银市场将在19:59:59关闭。
                            <br>
                            <br>*******************************************************************************
                            <br>
                            <br>Dear Partners and Leaders,
                            <br>
                            <br>Please take note of the upcoming market holiday(s) below.
                            <br>04 July 2014 - US Independence Day
                            <br>
                            <br>A lack of liquidity on these dates may lead to wider spreads; please plan your trades accordingly.
                            <br>
                            <br>The Spot Gold & Spot Silver market will be closed at 19:59:59.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='31'>HongKong Diamond Quest 香港钻石优惠 홍콩 다이아몬드 퀘스트</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "25 June 2014";
                ?>
            </div>

            <div id="page_31" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Partners and Leaders,
                            <br>亲爱的领导人与伙伴们：
                            <br>친애하는  파트너 및 리더 여러분,
                            <br>
                            <br>Due to overwhelming request by our IMs for the company to extend our 1 Carat Diamond Promo, the management is pleased:
                            <br>鉴于众多会员们强烈要求公司延长1克拉钻石促销计划，我们很高兴地宣布：
                            <br>1 캐럿 다이아몬드 프로모션을 연장해 달라는 우리 IMs의 열화와 같은 요구에, 우리 경영진은 기뻐하고 있습니다.
                            <br>
                            <br>Qualifying Period Extended to : June 30th, 2014
                            <br>Amount to Qualify: USD100K
                            <br>Receive: 1 Carat Diamond plus 2 door tickets to attend our Convention in the beautiful romantic island of Bali in September 2014 (actual dates TBA).
                            <br>优惠期限延长至：2014.6.30
                            <br>额度要求：10万美金
                            <br>优惠奖励：一颗1克拉钻石，外加马胜2014巴厘岛国际金融交流会门票2张（会议具体时间再定）
                            <br>연장 기간  :  2014년 6월 30일
                            <br>유효 금액  : USD 100K
                            <br>상품 :   1 캐럿 다이아몬드  + 2014년 9월 아름다운 낭만의 섬 발리에서 개최되는 컨벤션 티켓 2장 (상세일정 추후 공지)
                            <br>
                            <br>Go for it, DON'T MISS OUT ON GETTING YOUR OWN DIAMOND !!!
                            <br>加油吧，抓住这最后机会赢取属于您自己的钻石！
                            <br>꼭 참가하셔서. 다이아몬드 상품 기회를 놓치지 마세요!!!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='28'>Promo: 2nd BMW X6 Challenge: BMW X6挑战计划第二期</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "21 June 2014";
                ?>
            </div>

            <div id="page_28" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Qualifying period June 1st to August 31st 2014 @ 23:59hours (GMT+8)
                            <br>挑战日期：2014.6.1-8.31日晚23:59(GMT+8)
                            <br>
                            <br>Grand Prize BMW X6 Challenge
                            <br>- The qualifier with the MOST Personal Sales will RECEIVE a Brand New BMW X6 in their country of domicile.
                            <br>Note: ONLY 1 (one) WINNER
                            <br>宝马BMW X6 特级挑战
                            <br>挑战时期内个人销售业绩第一名的伙伴将会获得一辆崭新的BMW X6轿车(于会员注册国提取新车)
                            <br>注：名额只限1位
                            <br>
                            <br>Consolation Prize
                            <br>- Achieve a Personal Sales of USD3Million and you will receive a Brand New BMW 3 Series in your country.
                            <br>Note: Multiple Winners Apply
                            <br>宝马轿车挑战
                            <br>于挑战时期间个人业绩达成300万美金的会员将会获得一辆崭新宝马BMW 3系列轿车(于会员注册国提取新车)
                            <br>注：多位名额
                            <br>
                            <br>Go for it, Grab your BMW today....!!!
                            <br>加油吧，赢取只属于您的宝马荣耀！
                            <br>
                            <br>プロモーション　第二次 BMW X6チャレンジ
                            <br>資格期間　2014年6月1日〜8月31日 23:59 (GMT+8)
                            <br>大賞　BMX X6　チャレンジ
                            <br>- もっとも大きな個人売り上げをあげた資格者は新品のBMW X6を居住地にてお受け取りいただけます。
                            <br>注意；勝者はお一人様のみとなります
                            <br>
                            <br>残念賞
                            <br>- USD300万以上の個人セールスをあげた方は、新品のBMW3シリーズをあなたの国で受け取ります。
                            <br>注意；複数名様
                            <br>
                            <br>頑張ってください。あなたのBMWを今日掴んでください....!!!
                            <br>
                            <br>프로모션 : 두번째 BMW X6 챌린지
                            <br>
                            <br>자격 충족 기간 2014년 6월 1일부터 8월 31일 밤 11:59시 까지
                            <br>
                            <br>최고 상 BMW X6 챌린지
                            <br>-   최고 개인 판매를 올릴 경우 자국에서 신형 BMW X6를 받을 것입니다.
                            <br>참조 : 단 1명의 승자
                            <br>
                            <br>감투상
                            <br>
                            <br>-   개인 매출 미화 3백만 달러를 달성할 경우 자국에서 신형 BMW 3시리즈를 받을 것입니다.
                            <br>
                            <br>참조 : 다수의 수상자 가능
                            <br>
                            <br>파이팅하십시오, 오늘 당신의 BMW를 쟁취하십시오…!!!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <?php if ($culture == "kr") {?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='26'>국제 회원 교류 (IME) 한국 회원만을 위한 발리 프로모션</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "18 June 2014";
                ?>
            </div>

            <div id="page_26" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>국제 회원 교류 (IME) 한국 회원만을 위한 발리 프로모션:
                            <br>
                            <br>프로모션 기간 2014년 6월 15일에서 7월 31일
                            <br>
                            <br>자격요견 : 3만달러 신청
                            <br>권리 : 1인 호텔 숙박권 (3박 – 2인1실 기준)과 맥심 트레이더 발리 IME 갈라 디너 참석권과 비행기 티켓 (500CP1 상당)
                            <br>
                            <br>또는
                            <br>
                            <br>개인 매출 자격 요견 : 개인 매출 100만 불
                            <br>권리 : 1인 호텔 숙박권 (3박 – 2인1실 기준)과 맥심 트레이더 발리 IME 갈라 디너 참석권과 비행기 티켓 (500CP1 상당)
                            <br>
                            <br>참조 1: 한국국적 또는 거주자에 한함. (증빙 주소 요구)
                            <br>참조 2: 국제 회원 또는 리더들은 1 인센티브만 자격 가능.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php } ?>
        <?php if ($culture == "jp") {?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='25'>日本のためのバリ特別プロモーション</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "18 June 2014";
                ?>
            </div>

            <div id="page_25" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>日本のためのバリ特別プロモーション
                            <br>プロモーション期間　2014年6月15日〜7月31日
                            <br>
                            <br>資格を得るには:
                            <br>USD30kパッケージへの自己投資
                            <br>権利:お一人さまにつきホテル宿泊（３泊　ツインルームのシェアベース）。さらにマキシムトレーダーバリIME@ガラディナーへの1ドアチケット。
                            <br>USD50kパッケージへの自己投資
                            <br>権利: お一人さまにつきホテル宿泊（３泊
                            <br>ツインルームのシェアベース）。さらにマキシムトレーダーバリIME@ガラディナーへの1ドアチケット＋航空券（500CP1）
                            <br>
                            <br>または
                            <br>直接紹介業績:USD150kのパーソナルセールス
                            <br>権利:  お一人さまにつきホテル宿泊（３泊
                            <br>ツインルームのシェアベース）。さらにマキシムトレーダーバリIME@ガラディナーへの1ドアチケットおよび航空券 (500CP1)
                            <br>
                            <br>
                            <br>注意1:日本の居住者および日本国民のみがこのプロモーションの対象となります。（住所を証明するものが必要です）
                            <br>
                            <br>注意2: IMまたはリーダーは1インセンティブのみの権利となります。
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <?php } ?>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='24'>HongKong Diamond Quest 香港钻石优惠 홍콩 다이아몬드 퀘스트 香港ダイヤモンドクエスト</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "15 June 2014";
                ?>
            </div>

            <div id="page_24" class="news_desc" style="text-align: left; display: none;">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Partners and Leaders,
                            <br>亲爱的领导人于伙伴们：
                            <br>친애하는 파트너 및 리더 여러분들,
                            <br>パートナーおよびリーダーのみなさま
                            <br>Due to overwhelming request by our IMs for the company to offer our 1
                            <br>Carat Diamond Promo, the management is pleased to offer a Not To Be
                            <br>Repeated "HONGKONG DIAMOND QUEST".
                            <br>鉴于众多会员强烈要求公司继续1克拉钻石促销计划，公司很高兴地通知大家我们新的、且只此一次计划的“香港钻石优惠”。
                            <br>1 캐럿 다이아몬드 프로모션에 대한 우리 국제 멤버들의 열화와 같은 요청에 의해, 회사 매니지먼트 팀은 반복되지 않는 “홍콩
                            <br>다이아몬드 퀘스트” 프로모션을 진행하게 됨을 기쁘게 알려드립니다.
                            <br>、1カラットダイヤモンドプロモーションに対する私たちのIMからの圧倒的なリクエストにより、マネジメントはもう二度とない「香港ダイヤモンドクエスト」をここに喜んでオファーします。
                            <br>
                            <br>Qualifying Period: June 14th to June 23rd, 2014
                            <br>Amount to Qualify: USD100K
                            <br>Receive: 1 Carat Diamond plus 2 door tickets to attend our Convention
                            <br>in the beautiful romantic island of Bali in September 2014 (actual
                            <br>dates TBA).
                            <br>
                            <br>資格期間：2014年6月14日〜6月23日
                            <br>資格を得るための額：100K　USD
                            <br>受賞；1カラットのダイヤモンドおよび、2014年9月に弊社がバリ島の美しいロマンチックな島で行われるコンベンションへの２ドアチケット（詳細日程は追ってお知らせします）
                            <br>
                            <br>优惠期限：2014.6.14-6.23
                            <br>额度要求：10万美金
                            <br>优惠奖励：一颗1克拉钻石，外加两张马胜2014巴厘岛国际金融交流会门票2张（会议具体时间再定）
                            <br>자격 충족 기간 : 2014년 6월 14일부터 6월 23일 까지
                            <br>자격 금액 : 미화 100,000달러
                            <br>수상 : 2014년 9월에 열릴 아름답고 로맨틱한 발리 섬에서의 컨벤션 참석 2 도어 티켓과 1 캐럿 다이아몬드 (정확한 날짜는 추후 통보)
                            <br>Go for it, DON'T MISS OUT ON GETTING YOUR OWN DIAMOND !!!
                            <br>頑張ってください。あなた自身のダイヤモンドを入手する機会をお見逃しなく！！！
                            <br>加油吧，抓住这最后机会赢取属于您自己的钻石！
                            <br>힘내십시오, 당신의 자신의 다이아몬드를 얻기 놓치지 마세요!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='30'>Auto Placement into Genealogy 自动安置通知 자동 배치 系図への自動配置について</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "06 June 2014";
                ?>
            </div>

            <div id="page_30" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Partners and Leaders, effective immediately, please be informed that those Registered Members that have bought packages and not Restructured their Placement will be Automatically Placed by the company onto the Weaker Group of their Referrer's genealogy after 7 days to ensure that there are no orphan account in the system.
                            <br>
                            <br>By Order
                            <br>Management of MCL
                            <br>
                            <br>
                            <br>
                            <br>亲爱的领导人和伙伴们：
                            <br>
                            <br>即时生效-为了系统内不产生遗留无推荐人账户，所有已经注册且已购买配套的会员账户若7天之内未完成安置，公司系统将会自动为您安置在业绩小的一条线上。敬请留意。
                            <br>
                            <br>马胜金融集团高层
                            <br>
                            <br>
                            <br>
                            <br>친애하는 파트너와 리더 여러분, 오늘부터 패키지를 구매한 등록 회원 중 위치를 재조정 하지 않은 분들은7일 이후에 시스템 확인 후 회사에 의해서 추천인의 소그룹으로 자동 배치될 것입니다.
                            <br>
                            <br>주문부서회사
                            <br>맥심 캐피탈 주식
                            <br>
                            <br>
                            <br>
                            <br>系図への自動配置について
                            <br>
                            <br>パートナーとリーダーの皆さま、登録されたメンバーで、パッケージを購入し、まだプレイスメントを再構築していない方は、システム内の孤立アカウントがないことを確実にするために、７日後に会社によって彼らの紹介者の系図のウィーカーグループに自動的に配置されてしまいますことをご承知ください。これは即時有効となります。
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='23'>Investors and IMs can place funds in tranches of USD5million 投资者与代理IB们即可以实现500万美金的汇款</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "30 May 2014";
                ?>
            </div>

            <div id="page_23" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear Leaders and Partners
                            <br>
                            <br>The company takes pleasure to announce that effective immediately and from May 30th 2014, Investors and IMs can place funds in tranches of USD5million.
                            <br>
                            <br>Applicants will be required to comply with Due Diligence procedure conducted by our LACD and once approved, can proceed to make arrangements for transfer of funds from a recognized A+ New York Bank to our Bankers.
                            <br>
                            <br>By Order
                            <br>Management of MCL
                            <br>
                            <br>亲爱的领导人与伙伴们:
                            <br>
                            <br>我们很荣幸地告诉所有伙伴-从2014.5.30日起，投资者与代理IB们即可以实现500万美金的汇款。
                            <br>
                            <br>需要汇款500万美金的申请者需要配合公司法律部LACD完成一份尽职调查。一旦审核完毕，公司即将安排申请者通过一家纽约A+级别银行完成汇款。
                            <br>
                            <br>马胜资本有限公司管理层公告
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='22'>Monthly withdrawal period will be extended by an additional day to <strong>8 May 2014, 11.59PM</strong></a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "7 May 2014";
                ?>
            </div>

            <div id="page_22" class="news_desc" style="text-align: left;  display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <br>Dear International Members,
                            <br>
                            <br>As you are aware, we had been experiencing some glitches in our website during the past two days.
                            <br>This problem has now been fixed and to assist you, the monthly withdrawal period will be extended by an additional day to <strong>8 May 2014, 11.59PM</strong>.
                            <br>The inconvenience caused is highly regretted and steps are under way to improve the services.
                            <br>
                            <br>Thank you,
                            <br>CEO
                            <br>
                            <br>尊敬的领导人与伙伴们:
                            <br>
                            <br>非常抱歉过去两天公司的网站出现了未能登陆的问题，现在已经确定该问题已被解决。为了弥补因此带来的延迟，公司特决定将本月的取现截止日期推迟至5.8日夜晚11:59分。再次代表公司对您赞成的不便表示抱歉，且我们一定会尽更大的努力为所有的伙伴提供更好的服务!
                            <br>
                            <br>谢谢！
                            <br>首席执行官CEO
                            <br>
                            <br>インターナショナルメンバーの皆様
                            <br>皆様もお気づきのことと存じますが、ここ数日、当社のウエブサイトにいくつかの不具合が起きています。この問題は現在は解決されていますが、あなたの助けになるように、毎月の引き出しの期限を、2014年5月8日午後11時59分まで延長します。ご不便をおかけして誠に申し訳ありません。また、サービスを改善するために努力をしています。ありがとうございました。
                            <br>CEO
                            <br>
                            <br>친애하는 국제 멤버 여러분들, 아시다시피 지난 2일간 홈페이지에 작은 문제가 있었습니다.  이 문제는 이제 해결되었으며 여러분들의 편의를 위하여, 월별 인출 기간을 201년 5월 8일 오후 11시 59분까지 추가로 연장됩니다. 불편을 끼쳐드려 죄송합니다. 서비스의 질을 높이기 위해 최선을 다할 것입니다. 감사합니다.
                            <br>CEO
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='21'>Easter schedule</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "17 April 2014";
                ?>
            </div>

            <div id="page_21" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="width:630px;font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                        <tbody>
                            <tr>
                              <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse" valign="top" width="699">
                                <p>Dear Traders,</p>

                                <p>Maxim would like to inform you that on Friday 18th of April certain instruments will be closed for trading during the U.S. trading session due to Good <span class="aBn" data-term="goog_1601317888" tabindex="0"><span class="aQJ">Friday</span></span>.</p>

                                <p>Please find below the list of the affected instruments.</p>
                                <table cellpadding="5" cellspacing="5">
                                  <tbody>
                                    <tr bgcolor="#434343">
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse"><strong>Asset class</strong></td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse"><strong>Instrument</strong></td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse"><strong>Good Friday 18th of April</strong></td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse"><strong>Easter <span class="aBn" data-term="goog_1601317889" tabindex="0"><span class="aQJ">Monday 21st of April</span></span></strong></td>
                                    </tr>
                                    <tr bgcolor="#EEEEEE">
                                      <td align="center" style="border-collapse:collapse">FOREX</td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse">All Currency Pairs</td>
                                      <td align="center" style="border-collapse:collapse">Open </td>
                                      <td align="center" style="border-collapse:collapse">Open</td>
                                    </tr>
                                    <tr bgcolor="#EEEEEE">
                                      <td align="center" style="border-collapse:collapse">SHARE CFDs</td>
                                      <td align="center" style="border-collapse:collapse"><table cellpadding="5" cellspacing="5">
                                        <tbody>
                                          <tr>
                                            <td style="border-collapse:collapse" align="center">US Shares</td>
                                            </tr>
                                          <tr>
                                            <td style="border-collapse:collapse" align="center">UK Shares</td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                      <td align="center" style="border-collapse:collapse">
                                          <table cellpadding="5" cellspacing="5">
                                        <tbody>
                                          <tr>
                                            <td style="border-collapse:collapse" align="center">Closed</td>
                                            </tr>
                                          <tr>
                                            <td style="border-collapse:collapse" align="center">Closed</td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                      <td align="center" style="border-collapse:collapse"><table cellpadding="5" cellspacing="5">
                                        <tbody>
                                          <tr>
                                            <td align="center" style="border-collapse:collapse">Open</td>
                                            </tr>
                                          <tr>
                                            <td align="center" style="border-collapse:collapse">Open</td>
                                            </tr>
                                          </tbody>
                                        </table></td>
                                    </tr>
                                    <tr bgcolor="#F9F9F9">
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse">METAL SPOT</td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse">XAU/USD &amp; XAG/USD </td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse">Closed</td>
                                      <td align="center" bgcolor="#EEEEEE" style="border-collapse:collapse">Open </td>
                                    </tr>
                                  </tbody>
                                </table>
                              <p>*Please be advised that on holidays a low trading volume and illiquidity; high spreads and volatility in markets are expected</p></td>
                            </tr>
                        </tbody>
                    </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='20'>1 Carat Diamond Challenge 1克拉钻石挑战赛 <br>(Period: 26th March – 30th April 2014)</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "13 April 2014";
                ?>
            </div>

            <div id="page_20" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">


                            <span style="color: #ff0000; font-weight: bold;">Sign up 100k package - entitle for 1 carat diamond <br>投资單項十萬美金既可获取此奬勵。</span>
                            <br>
                            <br>
                            <span style="color: #ff0000; font-weight: bold;">Sponsor 2 x 100k package - entitled to 1 carat diamond <br>直接推荐两位直線10萬美金，將合格一卡拉＂鑽石＂</span>
                            <br>
                            <br>
                            <strong>HURRY, LAST Chance to win yourself a 1 Carat Diamond 最后的机会为自己赢得一颗1克拉的钻石</strong>
                            <br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='19'>Extend the SYS promo to 12 midnight of March 25th, 2014</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "21 March 2014";
                ?>
            </div>

            <div id="page_19" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse" valign="top">
                            <br>Due to Request and Appeals by our IMs and Leadership, <strong>the company will extend the SYS promo to 12 midnight of March 25th, 2014.</strong>
                            <br>Please NOTE that we have limited rooms left due to the overwhelming response received so far.
                            <br>Sign up and make payment immediately to avoid disappointment.
                            <br>Singapore Yacht Show, the most prestigious event of the year brought to you by Maxim Trader.... DON'T MISS OUT!!!
                            <br>
                            <br>鉴于多位领导人和伙伴们的要求, 我们决定将<strong>新加坡国际游艇展促销计划的截止日期延迟到2014.3.25日晚上12:00点</strong>。请注意因为目前接到的请求太多，所剩的房间数量并不多。请尽快报单并付清全款。这将是今年最值得期待的活动，机不可失 失不再来!
                            <br>
                            <br>국제 멤버들과 리더들의 요청에 의해서, <strong>당사는 SYS 프로모션을 2014년 3월 25일 자정까지 연장</strong>
                            <br>하기로 하였습니다.
                            <br>현재까지 열화와 같은 응답으로 남은 바 수가 제한되어 있음을 잊지 마십시오.
                            <br>실망할 수 있으니 서둘러 신청하시고 결제하시기 바랍니다.
                            <br>싱가폴 요트 쇼, 맥심 트레이더가 제공하는 올해 가장 특별한 이벤트입니다.
                            <br>놓치지 마세요.
                            <br>
                            <br>IM、リーダーシップの皆さんの要請および希望により、<strong>社ではSYSプロモの会期を3月25日夜中12時まで延長します</strong>。
                            <br>
                            <br>これまでにも圧倒的な反響があったため、どうぞ残りの部屋がすでに限られていることにご注意ください。
                            <br>
                            <br>失望しないで済むために、サインアップし、すぐに支払いをしてください。
                            <br>
                            <br>シンガポールヨットショーは、マキシムトレーダーがあなたにお届けする今年もっとも権威あるイベントです。お見逃しなく。
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='18'>IMPORTANT MESSAGE “FOREX LICENSING” 有关“外汇许可证”的重要通知</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "17 March 2014";
                ?>
            </div>

            <div id="page_18" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse" valign="top">
                            <p>PLEASE NOTE THAT THE FLASH PRESENTATION SHOWN AT THE MAXIM CONVENTION IN KL, IS A MERE REPLICA  WHICH AS SPELT OUT CLEARLY ON THE NIGHT, IT IS NOT TO BE REPRESENTED TO ANY THIRD PARTY TIL THE  OFFICIALLY SEALED ORGINAL IS RECEIVED BY LACD.
                            <br>
                            <br><span class="chinese_font">诚如我们在此次马来西亚金融峰会上所说，我们展示的有关公司获得外汇许可证的介绍，请注意在我们尚未获得原件时，不要展示给任何第三方机构或个人。</span>
                            <br>
                            <br>THIS WAS ONLY SHOWN IN COPY FORM AND IS NOT TO BE REPRESENTED AS THE MAXIM LICENCE UNTIL THE LACD HAVE THE ORIGINAL, AND HAVE ANNOUNCED CLEARANCE FOR USE WHICH WILL TAKE AROUND 14 DAYS. MEMBERS FOUND WRONGFULLY REPRESENTING THIS TO OTHERS, BEFORE 14 DAYS,  MAY FACE TERMINATION PROCEEDINGS. HIGHER MEMBERS AND SUPREME MEMBERS ARE EXPECTED TO SUPERVISE AND ENFORCE THIS ANNOUNCEMENT PLEASE.
                            <br>
                            <br><span class="chinese_font">我们在会议中展示的是复印件，且在我们收到原件之前不要用作展示用。我们接到通知，大概14天左右会收到原件。任何伙伴和会员不得违反此规定，若擅自于我们收到原件之前展示此复印件，最严重可能会终止伙伴关系。若发现类似情况，也请公司高层及领导人严格按照此规定执行。</span>
                            <br>
                            <br>Mr. W. Royce (Rocky) Lane
                            <br>CHIEF  LEGAL COUNSEL- Inhouse
                            <br><span class="chinese_font">集团内部首席法律顾问</span>
                            <br><span style="color: blue">In-house.legalcounsel@gmail.com</span>
                            <br>Int’l Bar Association-Member  No. 108394
                            <br>Legal Affairs & Compliance Division(LACD)
                            <br>Multinational Group of Companies - <span style="color: blue">www.maximtrader.com</span>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <?php if ($culture == "cn") {?>
                <a href='#' class="page_link" ref='15'>新加坡国际游艇展-优惠计划</a>
                <?php } else if ($culture == "kr") {?>
                <a href='#' class="page_link" ref='15'>싱가포르 요트 쇼 라이프스타일 인센티브</a>
                <?php } else if ($culture == "jp") {?>
                <a href='#' class="page_link" ref='15'>ガポール・ヨットショー・ライフスタイル・インセンティブ</a>
                <?php } else {?>
                <a href='#' class="page_link" ref='15'>Singapore Yacht Show Lifestyle Incentive</a>
                <?php } ?>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "11 March 2014";
                ?>
            </div>

            <div id="page_15" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">
                            <?php if ($culture == "cn") {?>
                            <strong>2014.4.10-13日@新加坡圣淘沙One 15 Marina俱乐部</strong>
                            <?php } else if ($culture == "kr") {?>
                            <strong>2014년 4월 10일@원15 마리나 클럽 센토사, 싱가포르</strong>
                            <?php } else if ($culture == "jp") {?>
                            <strong>2014年４月10日〜13日@シンガポール・One15 マリーナクラブ・セントーサ </strong>
                            <?php } else {?>
                            <strong>April 10th to 13th 2014@One 15 Marina Club Sentosa, Singapore</strong>
                            <?php } ?>
                            <br>
                            <?php if ($culture == "cn") {?>
                            <br>非常荣幸<strong>马胜金融集团</strong>能够成为<strong>2014新加坡国际游艇展-这一亚太地区最顶级、最奢华生活方式代表活动的主要赞助商</strong>。新加坡和新加坡国际游艇展也担任着向亚洲地区最有影响力的财富新贵们展现这一世界顶级精英游艇界的奢华生活的重任。继摩纳哥帆船展及劳德代尔堡国际游艇展之后，世界的焦点再一次聚焦-新加坡国际游艇展。
                            <?php } else if ($culture == "kr") {?>
                            <br><strong>맥심 캐피탈이 아시아 퍼시픽의 가장 훌륭하고 명망 높은 라이프스타일 이벤트인 싱가포르 요트 쇼 2014의 메인 스폰서</strong> 중 하나가 되어서 매우 영광스럽습니다.  싱가포르와 싱가포르 요트 쇼는 세계의 가장 비싼 보트와 상 받은 럭셔리 슈퍼 요트의 쇼케이스를 열어 아시아의 최고 부유층과 선두 사업자들을 초대합니다.  모나코 요트 쇼와 포트 로더데일 국제 보트 쇼 이후로, 세계는 지금 싱가포르 요트 쇼에 주목하고 있습니다.
                            <?php } else if ($culture == "jp") {?>
                            <br>マキシム・キャピタル・リミテッドにとって、アジア太平洋地域でもっとも素晴らしく、権威のあるライフスタイル・イベントであるシンガポール・ヨットショー2014のメインスポンサーになったことは、大変光栄なことです。シンガポールとシンガポール・ヨットショーは世界でもっとも高級なボートや、秘蔵の豪華なスーパーヨットを、アジアでもっとも豊かなコミュニティーに先導して紹介します。モナコ・ヨットショーと、フォートフローダーテール国際ボートショーのあと、世界の注目はシンガポール・ヨットショーに集まっています。
                            <?php } else {?>
                            <br>It is indeed an honor for <strong>Maxim Capital Limited</strong> to be the <strong>main sponsor for one of the finest and most prestigious lifestyle events in the Asia Pacific, the Singapore Yacht Show 2014</strong>. Singapore and the Singapore Yacht Show is taking the lead to showcase some of the world’s most exclusive boats and prized luxury super yachts to Asia’s wealthiest community and leading business players. After Monaco Yacht Show and Ft Lauderdale International Boat Show, the world’s attention is focused on …. The Singapore Yacht Show.
                            <?php } ?>
                            <br>     
                            <?php if ($culture == "cn") {?>
                            <br>在今年的活动中，<strong>最令人激动人心的是The Royal Albatross也会作为高位横帆船和超级游艇的代表</strong>首次跟大家见面。这艘游艇主体长度为47米，宽度为34米，拥有4跟铝造桅杆，可支撑22个帆蓬。作为高位横帆船和超级游艇的代表，The Royal Albatross也是唯一一艘拥有日间航行能力的游艇，并可容纳149位客人（最大容量为200位以上），且它还配有5个豪华船舱（夜间可容纳10位客人留宿），2个酒吧，270度全方位海景观赏，同时艺术灯光、音响以及导航系统配备齐全。很骄傲得告诉大家，<strong>The Royal Albatross将于4月10-11日对马胜开放</strong>。
                            <?php } else if ($culture == "kr") {?>
                            <br>사상 처음으로, <strong>세계에서 가장 독특하고 고급스러운 톨 쉽과 로얄 알바트로스는</strong> 올해 쇼의 초고의 스타로 주목 받을 것입니다.  이 배는 41m 길이에 너비가 34m이며 22명의 돛이 44개의 알루미늄 돛대에 꽂혀있습니다. 149명이 항해할 수 있으며, 200+ 이상의 함께 모일 수 있는 장소와 10명이 5개의 스위트 객실에서 하룻밤 전세를 낼 수 있으며, 2개의 바, 270도 바다를 볼 수 있는 뷰를 가진 그랜드 살롱, 예술 수준의 조명, 오디오 장비와 네비게이션 시스템을 가진 이 클래스에서 유일한 배입니다.  <strong>로얄 알바트로스는 4월 10일과 11일에 우리의 개인 사용을 위해 사용할 수 있습니다.</strong>
                            <?php } else if ($culture == "jp") {?>
                            <br>史上初めて、世界でもっともユニークで豪華な帆船であり、スーパーヨットクラスの「ザ・ロイヤル・アルバトロス号」は今年のショーのスター的アトラクションとなるでしょう。この船は長さ47メートル、幅34メートル。22の帆を付けられる4本のアルミニウムのマストを持っています。このクラスの船でははじめて、1日に149人のゲストを運ぶことができます。5つの大きなエンスイートキャビンをつけると、それぞれに10人が宿泊でき、200人以上を収容できます。２つのバー、270度を見渡せるグランドサロンと、アートライトニング、オーディオ機器、ナビゲーションシステムがあります。4月10日と11日、私たちはロイヤル・アルバトロス号をプライベートに使うことができます。
                            <?php } else {?>
                            <br>For the first time ever, <strong>the world’s most unique and luxurious Tall Ship and Super Yacht class The Royal Albatross</strong> will be the star attraction of this year’s show. She is 47m long, 34m wide and has 4 aluminum masts that carry 22 sails. It’s the only one in this class to have day sailing capacity of 149 guests, alongside capacity of 200+ and overnight charter of 10 guests in her 5 large en-suite cabins, 2 bars, 270view grand salon and state of the art lighting, audio equipment and navigation system. <strong>The Royal Albatross will be available for our private usage on April 10th & 11th</strong>.
                            <?php } ?>
                            <br>     
                            <?php if ($culture == "cn") {?>
                            <br>为了庆祝此次里程碑的活动，我们也为会员们准备了<span style="color: #ff0000;">专门的新加坡奢华游艇优惠计划。请注意，以下优惠只针对于<u>2014.3.10日报单且与2014.3.20日付完全款的客户</u></span>。
                            <?php } else if ($culture == "kr") {?>
                            <br>이 기념비 적인 이베트를 축하하기 위하여, 독점적으로 싱가포르 요트 쇼 라이프스타일 패키지를 마련하였습니다….. <span style="color: #ff0000;"><u>2014년 3월 20일까지 등록 및 입금완료한  분들 만을 위한</u></span>
                            <?php } else if ($culture == "jp") {?>
                            <br>この記念すべきイベントを祝い、私たちは特別な方だけに限定したシンガポールヨットショー・ライフスタイルパッケージを、<span style="color: #ff0000;"><u>2014年3月10日にコミットされた方だけにご用意します。支払いと登録は2014年3月20日までに済ませる必要があります</u></span>
                            <?php } else {?>
                            <br>To celebrate this milestone event, we have designed these very <span style="color: #ff0000;">exclusive Singapore Yacht Show Lifestyle Packages... <u>ONLY</u> for those that <u>COMMIT on March 10th 2014 with PAID SIGN UP by March 20th 2014</u>.</span>
                            <?php } ?>
                            <br>
                            <?php if ($culture == "cn") {?>
                            <br><span style="color: #ff0000;">购买配套额度为30,000-99,000美金，则可享受 --- 1人次 :</span>
                            <ul style="list-style: circle">
                                <li>4天/3夜五星级酒店住宿（双人床）</li>
                                <li>飞机票500 CP1的报销</li>
                                <li>机场接送</li>
                                <li>此次为期4天的新加坡国际游艇展的VIP套票</li>
                                <li><strong>受邀于4.10日晚登上The Royal Albatross享用马胜烧烤(BBQ)派对</strong></li>
                            </ul>
                            <?php } else if ($culture == "kr") {?>
                            <br><span style="color: #ff0000;">미화 30,000 – 99,000가입하는 회원 - 1명이 즐길 수 있는 특권은 :</span>
                            <ul style="list-style: circle">
                                <li>3박 4일 (2인 1일 실) 5성급 호텔 숙박</li>
                                <li>비행기 값 500CP1 보상</li>
                                <li>공항까지 교통편 제공</li>
                                <li>싱가포르 요트 쇼 4일간의 VIP 패스</li>
                                <li><strong>4월 10일 로얄 알바트로스 호에서 열리는 맥심 바비큐 파티 초대</strong></li>
                            </ul>
                            <?php } else if ($culture == "jp") {?>
                            <br><span style="color: #ff0000;">30,000USD〜99,000USDにサインアップされた方は以下をお楽しみいただけます（1名様）:</span>
                            <ul style="list-style: circle">
                                <li>5つ星ホテルへの3泊4日の滞在（原則ツインをシェア）</li>
                                <li>飛行機チケット代の500CP1相当の返還</li>
                                <li>エアポートへの往復送迎</li>
                                <li>4日間のシンガポール・ヨット・ショーへのVIPパス</li>
                                <li><strong>4月10日夜、ロイヤル・アルバトロス号でのマキシムBBQパーティーへのご招待</strong></li>
                            </ul>
                            <?php } else {?>
                            <br><span style="color: #ff0000;">SIGN UP for USD30,000 to USD99,000 and you will <u>enjoy</u>  - for 1 pax :</span>
                            <ul style="list-style: circle">
                                <li>4 days / 3 nights stay (twin share basis) in 5 Star Hotel</li>
                                <li>Reimbursement of 500CP1 for your plane ticket</li>
                                <li>2-way airport transfer</li>
                                <li>VIP Pass to the 4-day Singapore Yacht Show</li>
                                <li>Invite to <strong>Royal Albatross on night of April 10th for on-board Maxim BBQ party</strong></li>
                            </ul>
                            <?php } ?>
                            <br>
                            <?php if ($culture == "cn") {?>
                            <br><span style="color: #ff0000;">购买配套额度为100,000-499,000美金，则可享受 --- 1人次 :</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1卡拉钻戒</span></li>
                                <li><strong>4天/3夜五星级酒店住宿（高级客房)（双人床）</strong></li>
                                <li>飞机票500 CP1的报销</li>
                                <li>豪华轿车机场接送</li>
                                <li><strong>此次为期4天的新加坡国际游艇展的VIP套票-银级别</strong></li>
                                <li><strong>受邀4.10日晚登上The Royal Albatross享用马胜烧烤(BBQ)派对</strong></li>
                                <li><strong>受邀4.11日中午与马胜金融CEO首席执行官以及公司高层共享午宴</strong></li>
                                <li><strong>受邀4.11日晚登上The Royal Albatross参加马胜VVIP派对</strong></li>
                            </ul>
                            <?php } else if ($culture == "kr") {?>
                            <br><span style="color: #ff0000;">미화 100,000 to 499,000 가입하는 회원 - 1명이 즐길 수 있는 특권은 :</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1캐롯 다이아몬드 반지</span></li>
                                <li><strong>3박 4일 (2인 1일 실) 5성급 호텔 숙박 – 프리미엄 룸</strong></li>
                                <li>비행기 값 500CP1 보상 </li>
                                <li>공항까지 리무진 제공</li>
                                <li><strong>싱가포르 요트 쇼 4일간의 실버 VIP 패스</strong></li>
                                <li><strong>4월 11일 CEO와 맥심 임원진들과의 점심 식사</strong></li>
                                <li><strong>4월 10일 로얄 알바트로스 호에서 열리는 맥심 바비큐 파티 초대</strong></li>
                                <li><strong>4월 11일 밤 로얄 알바트로스 호에서 열리는 맥심 VVIP 파티 초대</strong></li>
                            </ul>
                            <?php } else if ($culture == "jp") {?>
                            <br><span style="color: #ff0000;">100,000USD〜499,000USDにサインアップされた方は以下をお楽しみいただけます（1名様）:</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1カラットのダイヤモンドリングを無料で差し上げます</span></li>
                                <li><strong>5つ星ホテルへの3泊4日の滞在- プレミアムルーム（原則ツインをシェア）</strong></li>
                                <li>飛行機チケット代の500CP1相当の返還</li>
                                <li>リムジンにてエアポートへの往復送迎</li>
                                <li><strong>4日間のシンガポール・ヨット・ショーへのシルバーVIPパス</strong></li>
                                <li><strong>4月11日、マキシムのCEOおよびマネージメントチームとの昼食会</strong></li>
                                <li><strong>4月10日夜、ロイヤル・アルバトロス号でのマキシムBBQパーティーへのご招待</strong></li>
                                <li><strong>4月11日夜、ロイヤル・アルバトロス号でのマキシムVVIPパーティーへご招待</strong></li>
                            </ul>
                            <?php } else {?>
                            <br><span style="color: #ff0000;">SIGN UP for USD100,000 to USD499,000 and you will <u>enjoy</u> – for  1 pax :</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1 Carat Diamond Ring</span></li>
                                <li>4 days / 3 nights stay (twin share basis) in <strong>5 Star Hotel - Premium Room</strong></li>
                                <li>Reimbursement of 500CP1 for your plane ticket</li>
                                <li>Limousine 2-way airport transfers</li>
                                <li><strong>Silver VIP Pass</strong> to the 4-day Singapore Yacht Show</li>
                                <li>Invite to <strong>Royal Albatross on night of April 10th for on-board Maxim BBQ party</strong></li>
                                <li><strong>April 11th - Lunch with CEO and Maxim Management Team</strong></li>
                                <li>Invite to <strong>Royal Albatross on night of April 11th for Maxim VVIP party</strong></li>
                            </ul>
                            <?php } ?>
                            <br>
                            <?php if ($culture == "cn") {?>
                            <br><span style="color: #ff0000;">报单额度为500,000美金及以上，则可享受 --- 1人次:</span>
                            <br><span style="color: #ff0000;">**名额只限30位。（客户可选择在且只在1个用户名下购买多个100,000美金的配套来达到该项优惠的金额要求。）</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1卡拉钻戒</span></li>
                                <li><strong>4天/3夜五星级酒店住宿（套房）</strong></li>
                                <li><strong>私人飞机送至新加坡Seletar机场</strong></li>
                                <li><strong>为期4天的豪华轿车自由使用，并配有私人司机</strong></li>
                                <li><strong>此次为期4天的新加坡国际游艇展的VVIP套票-钻石黑级别</strong></li>
                                <li><strong>受邀4.10日晚登上The Royal Albatross享用马胜烧烤(BBQ)派对</strong></li>
                                <li><strong>受邀4.12日与马胜金融CEO首席执行官以及公司高层共享香槟午宴</strong></li>
                                <li><strong>受邀4.11日晚登上The Royal Albatross参加马胜VVIP派对</strong></li>
                            </ul>
                            <?php } else if ($culture == "kr") {?>
                            <br><span style="color: #ff0000;">미화 500,000 이상 가입하는 회원 – 1명이 즐길 수 있는 특권은 :</span>
                            <br><span style="color: #ff0000;">**30명 한정으로 한 번에 완납 기준 (한 ID에 여러 개의 미화 100,000)</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1캐롯 다이아몬드 반지</span></li>
                                <li><strong>3박 4일 (2인 1일 실) 5성급 호텔 숙박 – 스위트 룸</strong></li>
                                <li><strong>싱가포르 셀레타 공항으로 개인 제트기 제공</strong></li>
                                <li><strong>4일간 기사와 리무진 제공</strong></li>
                                <li><strong>싱가포르 요트 쇼 4일간의 다이아몬드 블랙 VVIP 패스</strong></li>
                                <li><strong>4월 10일 로얄 알바트로스 호에서 열리는 맥심 바비큐 파티 초대</strong></li>
                                <li><strong>4월 12일 CEO와 맥심 임원진들과의 샴패인을 곁들인 점심 식사</strong></li>
                                <li><strong>4월 11일 밤 로얄 알바트로스 호에서 열리는 맥심 VVIP 파티 초대</strong></li>
                            </ul>
                            <?php } else if ($culture == "jp") {?>
                            <br><span style="color: #ff0000;">500,000USD以上をサインアップされた方は以下をお楽しみいただけます– 1名様 :</span>
                            <br><span style="color: #ff0000;">**最大30名様まで。ただしサインアップ時に全額払い込むことが必須です.（お一人様のIDにつき、USD100,000の倍数であることが必要です）</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1カラットのダイヤモンドリングを無料で差し上げます</span></li>
                                <li><strong>5つ星ホテルへの3泊4日の滞在- スイートルーム</strong></li>
                                <li><strong>シンガポール・セレター空港までプライベートジェット*でご案内します</strong></li>
                                <li><strong>4日間、豪華な運転手付き限定リムジンの特別ご提供</strong></li>
                                <li><strong>4日間のシンガポール・ヨット・ショーへのダイヤモンドブラックVVIPパス</strong></li>
                                <li><strong>4月10日夜、ロイヤル・アルバトロス号でのマキシムBBQパーティーへのご招待</strong></li>
                                <li><strong>4月12日、マキシムのCEOおよびマネージメントチームとのシャンパンランチ</strong></li>
                                <li><strong>4月11日夜、ロイヤル・アルバトロス号でのマキシムVVIPパーティーへご招待</strong></li>
                            </ul>
                            <?php } else {?>
                            <br><span style="color: #ff0000;">SIGN UP for USD500,000 and above to <u>enjoy</u> – for 1 pax:</span>
                            <br><span style="color: #ff0000;">**Limited to 30 pax on a First Fully Paid Sign Up Basis (multiples of USD100,000 under 1 single UserID)</span>
                            <ul style="list-style: circle">
                                <li><span style="color: #ff0000; font-weight: bold;">1 Carat Diamond Ring</span></li>
                                <li>4 days / 3 nights stay in <strong>5 Star Hotel - Suite Room</strong></li>
                                <li><strong>Private jet</strong> to bring YOU to Singapore Seletar Airport</li>
                                <li><strong>Exclusive use of Luxury Limousine plus Chauffeur for 4 days</strong></li>
                                <li><strong>Diamond Black VVIP pass</strong> to the 4-day Singapore Yacht Show</li>
                                <li>Invite to <strong>Royal Albatross on night of April 10th for on-board Maxim BBQ party</strong></li>
                                <li><strong>Champagne Lunch with CEO and Maxim Management Team on April 12th</strong></li>
                                <li>Invite to <strong>Royal Albatross on night of April 11th for Maxim VVIP party</strong></li>
                            </ul>
                            <?php } ?>
                            <br>
                            <img style="width: 600px" src="/images/201403/Singapore_Yacht_Show_Lifestyle_Incentive.jpg">
                            <br>
                            <?php if ($culture == "cn") {?>
                            <br><span style="font-weight: bold;font-style: italic;">** 如果去往同一个国家的客人不足8人，私人飞机会飞到另外一个地方继续载客，以确保每次航行上的马胜伙伴人数均为12人.</span>
                            <br>
                            <br><span style="color: #ff0000; font-weight: bold;">现在就来报名吧! 让我们一起撼动整个世界!!!</span>
                            <?php } else if ($culture == "kr") {?>
                            <br><span style="font-weight: bold;font-style: italic;">** 한 특정 국가에서 개인 제트기에 대한 자격을 획득한 회원이 8명 미만일 경우, 맥심 캐피탈은 각 비행기의 최대 인원수인 12명을 맞추기 위하여 다른 지역의 회원과 함께 비행할 수 있게 조정할 것입니다.</span>
                            <br>
                            <br><span style="color: #ff0000; font-weight: bold;">심 회원 여러분들,어서 사인하시기 바랍니다……. 함께 세상을 뒤흔듭시다!!!</span>
                            <?php } else if ($culture == "jp") {?>
                            <br><span style="font-weight: bold;font-style: italic;">** もしある地域でのプライベート・ジェットの人数が8人に満たない場合、マキシム・キャピタルはそれぞれの機種を最大12 名までにするために、ほかの地域に飛ぶことがあります。</span>
                            <br>
                            <br><span style="color: #ff0000; font-weight: bold;">MAXIMersの皆さん、いますぐサインアップを.. 世界を揺さぶりましょう!!!</span>
                            <?php } else {?>
                            <br><span style="font-weight: bold;font-style: italic;">** If there are less than 8 persons in a particular country qualifying for the Private Jet, Maxim Capital will fly these qualifiers to another destination to join others to make up the maximum number of 12 passengers for each flight.</span>
                            <br>
                            <br><span style="color: #ff0000; font-weight: bold;">COME MAXIMers, SIGN UP NOW…… LET’S ROCK THE WORLD!!!</span>
                            <?php } ?>
                            <br>
                            <br>
                            <a href="/images/201403/SYS_LIFESTYLE_INCENTIVE.pdf" target="_blank" style="color: #3333ff; font-weight: bold;">Download Sys Lifestyle Incentive.pdf (1.4MB)</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <?php if ($culture == "cn") {?>
                    <a href='#' class="page_link" ref='16'>新加坡国际游艇展挑战 <br>(期限：10th – 20th 3月 2014)</a>
                <?php } else if ($culture == "kr") {?>
                    <a href='#' class="page_link" ref='16'>싱가폴 요트쇼 라이프 스타일 챌린지 <br>(기간 : 2014년 3월 10일 ~ 20일)</a>
                <?php } else if ($culture == "jp") {?>
                <a href='#' class="page_link" ref='16'>シンガポールヨットショー・ライフスタイルチャレンジ <br>（期間　2014年3月10〜20日）</a>
                <?php } else {?>
                <a href='#' class="page_link" ref='16'>Singapore Yacht Show Lifestyle Challenge <br>(Period: 10th – 20th March 2014)</a>
                <?php }?>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "10 March 2014";
                ?>
            </div>

            <div id="page_16" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">

                            <?php if ($culture == "cn") {?>
                            <span style="color: #ff0000; font-weight: bold;">直推奖励。2 个最少USD30,000 至 99,000配套，您将免费获得票券1张</span>
                            <ul style="list-style: circle">
                                <li>4天/3夜五星级酒店住宿（双人床）</li>
                                <li><span style="color: #ff0000; font-weight: bold;">飞机票500 CP1的报销</span></li>
                                <li>机场接送</li>
                                <li>此次为期4天的新加坡国际游艇展的VIP套票</li>
                                <li>受邀 <strong>4.10日晚登上The Royal Albatross享用马胜烧烤(BBQ)派对</strong></li>
                            </ul>
                            <?php } else if ($culture == "kr") {?>
                            <span style="color: #ff0000; font-weight: bold;">2명 직접 추천 X   30,000 ~ 99,000 미국달러 – 무료 SYS 티켓 1장</span>
                            <ul style="list-style: circle">
                                <li>3박 4일 (2인 1일 실) 5성급 호텔 숙박</li>
                                <li><span style="color: #ff0000; font-weight: bold;">비행기 값 500CP1 보상</span></li>
                                <li>공항까지 교통편 제공</li>
                                <li>싱가포르 요트 쇼 4일간의 VIP 패스</li>
                                <li><strong>4월 10일 로얄 알바트로스 호에서 열리는 맥심 바비큐 파티 초대</strong></li>
                            </ul>
                            <?php } else if ($culture == "jp") {?>
                            <span style="color: #ff0000; font-weight: bold;">直接2×USD30,000〜99,000をお申し込みいただくと、SYSチケットを1枚無料で差し上げます</span>
                            <ul style="list-style: circle">
                                <li>5つ星ホテルでの３泊４日の滞在（ツインルームのシェア基本）</li>
                                <li><span style="color: #ff0000; font-weight: bold;">500CP1の飛行機チケットの償還</span></li>
                                <li>エアポート往復送迎</li>
                                <li>シンガポールヨットショーへの４日間のVIPパス</li>
                                <li>strong>4月10日　夜ロイヤル・アルバトロス号へ招待</strong></li>
                            </ul>
                            <?php } else {?>
                            <span style="color: #ff0000; font-weight: bold;">Direct refer 2 x USD30,000 to USD99,000 you are entitled for 1 FREE SYS Ticket</span>
                            <ul style="list-style: circle">
                                <li>4 days / 3 nights stay (twin share basis) in 5 Star Hotel</li>
                                <li><span style="color: #ff0000; font-weight: bold;">Reimbursement of 500CP1 for your plane ticket</span></li>
                                <li>2-way airport transfer</li>
                                <li>VIP Pass to the 4-day Singapore Yacht Show</li>
                                <li>Invite to <strong>Royal Albatross on night of April 10th for on-board Maxim BBQ party</strong></li>
                            </ul>
                            <?php } ?>
                            <br>
                            <?php if ($culture == "cn") {?>
                            <span style="color: #ff0000; font-weight: bold;">直推奖励 2 个最少100,000-USD499,000配套，您将免费获得票券1张及1卡拉钻戒</span>
                            <ul style="list-style: circle">
                                <li>4天/3夜<strong>五星级酒店住宿（高级客房）</strong></li>
                                <li>飞机票500 cp1的报销</li>
                                <li>豪华轿车机场接送</li>
                                <li><strong>此次为期4天的新加坡国际游艇展的VIP套票-银级别</strong></li>
                                <li><strong>受邀4.11日中午与马胜金融CEO首席执行官以及</strong></li>
                                <li><strong>受邀4.11日晚登上The Royal Albatross参加马胜VVIP派对公司高层共享午宴</strong></li>
                            </ul>
                            <?php } else if ($culture == "kr") {?>
                            <span style="color: #ff0000; font-weight: bold;">2명 직접 추천 X 100,000 ~ 499,000 미국달러  - SYS 무료티켓 1장과 1캐롯 다이아몬드 반지</span>
                            <ul style="list-style: circle">
                                <li><strong>3박 4일 (2인 1일 실) 5성급 호텔 숙박 – 프리미엄 룸</strong></li>
                                <li>비행기 값 500CP1  보상 </li>
                                <li>공항까지 왕복 리무진 제공</li>
                                <li><strong>싱가포르 요트 쇼 4일간의 실버 VIP 패스</strong></li>
                                <li><strong>4월 11일 CEO와 맥심 임원진들과의 점심 식사</strong></li>
                                <li><strong>4월 11일 밤 로얄 알바트로스 호에서 열리는 맥심 VVIP 파티 초대</strong></li>
                            </ul>
                            <?php } else if ($culture == "jp") {?>
                            <span style="color: #ff0000; font-weight: bold;">直接2×USD100,000〜499,000をお申し込みいただくと、SYSチケットを1枚と1カラットのダイヤモンドリングを無料で差し上げます</span>
                            <ul style="list-style: circle">
                                <li><strong>5つ星ホテルでの３泊４日の滞在（プレミアムルーム）</strong></li>
                                <li>500CP1の飛行機チケットの償還</li>
                                <li>リムジンでのエアポート往復送迎</li>
                                <li><strong>シンガポールヨットショーへの４日間のシルバーVIPパス</strong></li>
                                <li><strong>4月11日 CEO とマネージメントチームとのシャンパンランチへご招待</strong></li>
                                <li><strong>4月11日 夜ロイヤル・アルバトロス号VVIPパーティーへご招待</strong></li>
                            </ul>
                            <?php } else {?>
                            <span style="color: #ff0000; font-weight: bold;">Direct refer 2 x USD100,000 to USD499,000 you are entitled for 1 FREE SYS Ticket & 1 Carat Diamond Ring</span>
                            <ul style="list-style: circle">
                                <li>4 days / 3 nights stay in <strong>5 Star Hotel - Premium Room</strong></li>
                                <li>Reimbursement of 500CP1 for your plane ticket</li>
                                <li>Limousine 2-way airport transfers</li>
                                <li><strong>Silver VIP Pass</strong> to the 4-day Singapore Yacht Show</li>
                                <li><strong>April 11th - Lunch with CEO and Maxim Management Team</strong></li>
                                <li>Invite to <strong>Royal Albatross on night of April 11th for Maxim VVIP party</strong></li>
                            </ul>
                            <?php } ?>
                            <br>
                            <?php if ($culture == "cn") {?>
                            <br><span style="color: #ff0000; font-weight: bold;">直推奖励 2 个最少500,000配套，您将免费获得票券1张及1卡拉钻戒</span>
                            <ul style="list-style: circle">
                                <li>4天/3夜<strong>五星级酒店住宿（套房）</strong></li>
                                <li><strong>私人飞机</strong>送至新加坡Seletar机场</li>
                                <li><strong>为期4天的豪华轿车自由使用，并配有私人司机</strong></li>
                                <li><strong>此次为期4天的新加坡国际游艇展的VVIP套票-钻石黑级别</strong></li>
                                <li><strong>受邀4.10日晚登上The Royal Albatross享用马胜烧烤(BBQ)派对</strong></li>
                                <li><strong>受邀4.12日与马胜金融CEO首席执行官以及公司高层共享香槟午宴</strong></li>
                                <li><strong>受邀4.11日晚登上The Royal Albatross参加马胜VVIP派对</strong></li>
                                <li><strong>受邀4.12日晚在Exclusive W Hotel参加游艇展会后活动</strong></li>
                            </ul>
                            <?php } else if ($culture == "kr") {?>
                            <br><span style="color: #ff0000; font-weight: bold;">2명 직접 추천  X 500,000  미국달러 - SYS 무료 티겟 1장과 1캐롯 다이아몬드 반지</span>
                            <ul style="list-style: circle">
                                <li><strong>3박 4일 (2인 1일 실) 5성급 호텔 숙박 – 스위트 룸</strong></li>
                                <li><strong>싱가포르 셀레타 공항으로 개인 제트기 제공</strong></li>
                                <li><strong>4일간 기사와 리무진 제공</strong></li>
                                <li><strong>싱가포르 요트 쇼 4일간의 다이아몬드 블랙 VVIP 패스</strong></li>
                                <li><strong>4월 12일 CEO와 맥심 임원진들과의 샴패인을 곁들인 점심 식사</strong></li>
                                <li><strong>4월 11일 밤 로얄 알바트로스 호에서 열리는 맥심 VVIP 파티 초대</strong></li>
                            </ul>
                            <?php } else if ($culture == "jp") {?>
                            <br><span style="color: #ff0000; font-weight: bold;">直接2×USD500,000をお申し込みいただくと、SYSチケットを1枚と1カラットのダイヤモンドリングを無料で差し上げます</span>
                            <ul style="list-style: circle">
                                <li><strong>5つ星ホテルでの３泊４日の滞在（スイートルーム）</strong></li>
                                <li><strong>シンガポール・セレター空港までプライベートジェットでお運びします</strong></li>
                                <li><strong>4日間運転手付き専用リムジンをご用意</strong></li>
                                <li><strong>シンガポールヨットショーへの４日間のダイヤモンドブラックVIPパス</strong></li>
                                <li><strong>4月12CEO とマネージメントチームとのシャンパンランチへご招待</strong></li>
                                <li><strong>4月11日　夜ロイヤル・アルバトロス号マキシムVVIPパーティーへご招待</strong></li>
                            </ul>
                            <?php } else {?>
                            <br><span style="color: #ff0000; font-weight: bold;">Direct refer 2 x USD500,000 you are entitled for 1 FREE SYS Ticket & 1 Carat Diamond Ring</span>
                            <ul style="list-style: circle">
                                <li>4 days / 3 nights stay in <strong>5 Star Hotel - Suite Room</strong></li>
                                <li><strong>Private jet</strong> to bring YOU to Singapore Seletar Airport</li>
                                <li><strong>Exclusive use of Luxury Limousine plus Chauffeur for 4 days</strong></li>
                                <li><strong>Diamond Black VVIP pass</strong> to the 4-day Singapore Yacht Show</li>
                                <li><strong>Champagne Lunch with CEO and Maxim Management Team on April 12th</strong></li>
                                <li>Invite to <strong>Royal Albatross on night of April 11th for Maxim VVIP party</strong></li>
                            </ul>
                            <?php } ?>
                            <br>
                            <a href="/images/201403/Singapore_Yacht_Show_Lifestyle_Challenge.pdf" target="_blank" style="color: #3333ff; font-weight: bold;">Download Singapore Yacht Show Lifestyle Challenge.pdf (1.4MB)</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <?php if ($culture == "cn") {?>
                <a href='#' class="page_link" ref='17'>BMW X6挑战大奖 <br>(期限：3月10号 –  5月31号2014)</a>
                <?php } else if ($culture == "kr") {?>
                    <a href='#' class="page_link" ref='17'>BMW X6 챌린지 <br>(기간 : 2014년 3월 10일 ~ 5월 31일)</a>
                <?php } else if ($culture == "jp") {?>
                    <a href='#' class="page_link" ref='17'>BMW X6　チャレンジ <br>（期間：２０１４年3月１０〜３１日）</a>
                <?php } else {?>
                <a href='#' class="page_link" ref='17'>BMW X6 CHALLENGE <br>(Period: 10th March – 31th  May 2014)</a>
                <?php } ?>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "10 March 2014";
                ?>
            </div>

            <div id="page_17" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse; padding: 10px;" valign="top">

                            <img style="width: 600px" src="/images/201403/bmw.jpg">

                            <?php if ($culture == "cn") {?>
                            <span style="color: #ff0000; font-weight: bold;">最高个人业绩者将获得一部崭新的BMW X6 系列
                            <br>** 以最少3百万美金各人业绩为准.
                            <?php } else if ($culture == "kr") {?>
                            <span style="color: #ff0000; font-weight: bold;">최고의 개인 판매실적을 올린 분께 신형 BMW X6 시리즈를 드립니다
                            <br>** 최소 개인 판매실적 미화 3백만 달러 이상 필요.
                            <?php } else if ($culture == "jp") {?>
                            <span style="color: #ff0000; font-weight: bold;">トップパーソナルセールスの達成者には新品のBMX X6 シリーズ獲得の権利があります
                            <br>** ただし、個人セールスで、最低300万USDを達成する必要があります.
                            <?php } else {?>
                            <span style="color: #ff0000; font-weight: bold;">TOP PERSONAL SALES ACHIEVER ENTITLED FOR A BRAND NEW BMW X6 SERIES
                            <br>** Minimum PERSONAL SALES of USD3mil required.
                            <?php } ?>
                            </span>
                            <br>
                            <br>
                            <a href="/images/201403/BMW_X6_CHALLENGE.pdf" target="_blank" style="color: #3333ff; font-weight: bold;">Download BMW X6 CHALLENGE.pdf (0.7MB)</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='14'>MoneyTrac - FOR NOW AND UNTIL FURTHER NOTICE, ONLY AVAILABLE FOR M'sians 直到有进一步通知，Money Trac服务目前只对马来西亚客户开放</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "31 JANUARY 2014";
                ?>
            </div>

            <div id="page_14" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse" valign="top">
                            <p>Dear Partners and Leaders,</p>

                            <p>亲爱的领导人与伙伴们：</p>

                            <p>In an effort to serve you better in 2014, we have tied up with MoneyTrac (product of GlobalPayout.com) which is an international payment gateway that offers a variety of options to receive and disburse your Maxim earnings.</p>

                            <p>为了在2014年更好地服务所有伙伴,我们已与一家国际支付渠道MoneyTrac(Global Payout. com旗下产品)达成合作协议，为您马胜的收入提供更丰富的出金渠道。</p>

                            <p>We encourage you to Sign Up for your MoneyTrac e-wallet account. Once done, you can transfer your CP2 & CP3 into your MoneyTrac account and thereafter decide if you want to load into your local bank(s) accounts, credit/debit cards. It is user friendly and a very efficient way to manage and utilise your Maxim$$$.</p>

                            <p>我们鼓励所有的客户注册MoneyTrac电子钱包账户。一旦注册成功，您可以选择将您的CP2和CP3转入您的MoneyTrac账户，之后您可再选择将金钱转至于您的本地借记卡或信用卡。该账户使用非常方便，处理高效。</p>

                            <p>Say YES TO MAXIM TRADER...</p>

                            <p>确认马胜说：YES!</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>

        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='1'>2014 US Martin Luther King Jr. Holiday</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "19 JANUARY 2014";
                ?>
            </div>

            <div id="page_1" class="news_desc" style="text-align: left; display: none">
                <table bgcolor="#F2F2F2" border="0" cellpadding="10" cellspacing="0" style="font-size:10pt;font-family:Arial,Geneva,Arial,Helvetica,sans-serif;display:table" width="719">
                    <tbody>
                        <tr>
                            <td style="font-size:10pt;font-family:2arial,Geneva,Arial,Helvetica,sans-serif;border-collapse:collapse" valign="top">
                            <p>Dear Trader,</p>

                            <p>Maxim would like to inform you that on Monday 20th of January certain instruments will be closed for trading during the U.S. trading session due to Martin Luther King day.</p>

                            <p>Please find below the list of the affected instruments (timing base on MT4 server, GMT+2):</p>

                            <table border="1">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="border-collapse:collapse">Monday 20th Jan, 2014:</td>
                                    </tr>
                                    <tr>
                                        <td width="164" style="border-collapse:collapse">&nbsp;</td>
                                        <td width="144" style="border-collapse:collapse"><strong>Close (Today)</strong></td>
                                        <td bgcolor="#F2F2F2" style="border-collapse:collapse"><strong>Re Open (21st of January)</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="border-collapse:collapse">XAU/USD</td>
                                        <td style="border-collapse:collapse"><span class="aBn" data-term="goog_1344016735" tabindex="0"><span class="aQJ">20:00</span></span></td>
                                        <td bgcolor="#F2F2F2" style="border-collapse:collapse"><span class="aBn" data-term="goog_1344016736" tabindex="0"><span class="aQJ">01:00</span></span></td>
                                    </tr>
                                    <tr>
                                        <td style="border-collapse:collapse">XAG/USD</td>
                                        <td style="border-collapse:collapse"><span class="aBn" data-term="goog_1344016737" tabindex="0"><span class="aQJ">20:00</span></span></td>
                                        <td bgcolor="#F2F2F2" style="border-collapse:collapse"><span class="aBn" data-term="goog_1344016738" tabindex="0"><span class="aQJ">01:00</span></span></td>
                                    </tr>
                                    <tr>
                                        <td style="border-collapse:collapse">CFD</td>
                                        <td style="border-collapse:collapse">Closed</td>
                                        <td bgcolor="#F2F2F2" style="border-collapse:collapse">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>

                            <p>*Please be advised that on holidays a low trading volume and illiquidity; high spreads and volatility in markets are expected</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='2'>LACD LEGAL WARNING NOTICE TAKE NOTICE THAT: LACD法律部警示</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "08 JANUARY 2014";
                ?>
            </div>

            <div id="page_2" class="news_desc" style="text-align: left; display: none">
                <br>It has come to the attention of the Company that some Maxim Members, and others, are allegedly in breach of COPYRIGHT LAW, by causing the unauthorized replication of the Company’s, Maxim Trader, Official Website and using the same to their own advantage to the complete detriment and financial loss of the lawful owner of the Copy Right, Maxim Capital Ltd, and its Registered Mark “Maxim Trader.”
                <br>我们最近注意到部分马胜金融集团的会员涉嫌违法版权法，未经授权使用公司名称、公司商标以及公司官网作个人目的，并给马胜资本有限公司、“马胜金融集团”商标带来损害以及财务损失。
                <br>
                <br>LET IT CLEARLY BE MADE KNOWN TO ALL, that persons allegedly in breach (Including those who have done this, to aid their presentation of the Maxim Module), shall be tenaciously tracked down, found and brought before the Courts whereat, upon being found guilty, shall not only suffer the immediate Termination of their Maxim Membership, but the Company shall seek the most highest and maximum penalty metered out by law, to be imposed against Copy Right offenders. Rewards will be paid to anyone assisting to lead LACD towards the detection of Copy Right offenders.
                <br>因此我们在此郑重声明: 任何涉嫌违反版权法的会员（包括已经违反版权用来帮助个人马胜发展的人士）都会被严肃追踪、追查、并起诉至法庭接受罪行审判。此外，其马胜会员资格会被立即取消，同时马胜公司还会确保其因违反版权法而受到法律允许范围内的最高、最大惩罚 。任何协助马胜公司LACD法律部追踪、追查该类事件的，公司将会大力嘉赏。
                <br>
                <br>Maxim Members, who wish to seek the prior approval from LACD, to use such company Aids should use the new LEGAL WATCH facility at their back office Members area, to query their possibility of seeking LACD approval, for the use of the Company’s Copy Right.
                <br>若您需要该类公司工具发展事业，并提前获得LACD的批准，请登录公司网站会员专区，点击“LEGAL WATCH 法务观察”，向法律部提出使用公司版权的申请。
                <br>
                <br>DATED this 10th day of January 2014
                <br>生效日期: 2014.1.10日
                <br>
                <br>BY ORDER OF:
                <br>Legal Affairs and Compliance Division (LACD) Maxim Trader and Group of companies
                <br>马胜金融集团级集团公司法律事务与合规部(LACD)
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='3'>Attention</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "08 JANUARY 2014";
                ?>
            </div>
            <div id="page_3" class="news_desc" style="text-align: left; display: none">
                <br>This is the OFFICIAL WEBSITE of Maxim Trader. Unauthorized use and replication of company information is not permitted unless with the written approval of LACD. Any infringement of this policy will result in immediate suspension followed by termination if necessary.
                <br>
                <div class="popdivider"></div>
                <br>这是马胜金融集团唯一官方网站。除非获得马胜金融集团LACD法律部的书面批准，任何对公司信息的未经授权的使用和复制都是不被允许的。任意对该政策的侵犯在必要时将会立即导致使用终止。
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='4'>10th March 2014 Annual Extravaganza Dinner & Dance @ Sunway Pyramid Convention Centre, Kuala Lumpur, Malaysia</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "08 JANUARY 2014";
                ?>
            </div>
            <div id="page_4" class="news_desc" style="text-align: left; display: none">
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

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='5'>IMPORTANT ANNOUNCEMENT!!! End of Promo - CP2 to CP1 extra 5%</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "04 JANUARY 2014";
                ?>
            </div>
            <div id="page_5" class="news_desc" style="text-align: left; display: none">
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

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='6'>NEW GTS FUNDING INSTRUCTION - MAXIM CAPITAL LIMITED</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "25 DECEMBER 2013";
                ?>
            </div>
            <div id="page_6" class="news_desc" style="display: none">
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

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='7'>Holiday Trading and Support Hours 马胜金融集团恭祝您节日快乐,新年新气象</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "23 DECEMBER 2013";
                ?>
            </div>
            <div id="page_7" class="news_desc" style="text-align:left; display: none">
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

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='8'>IMPORTANT ANNOUNCEMENT!!!</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "23 OCTOBER 2013";
                ?>
            </div>
            <div id="page_8" class="news_desc" style="display: none; text-align:left">
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

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='9'>IMPORTANT ANNOUNCEMENT!!!</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "4 OCTOBER 2013";
                ?>
            </div>
            <div id="page_9" class="news_desc" style="display: none; text-align:left">
                <br>
                IMPORTANT ANNOUNCEMENT!!!
                <br><br>
                <ol>
                    <li>Please be informed that effective 1st October 2013, pending order placement will be disabled 1 hour earlier prior to the US NFP news release at 8:30 EDT and will be made available 2 hours after the news release.</li>
                    <li>
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
                    </li>
                </ol>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='10'>Q3 Champions Challenge</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "25 AUGUST 2013";
                ?>
            </div>
            <div id="page_10" class="news_desc" style="display: none;">
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

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='11'>Q3 Champions Challenge - BMW 5 Series</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "4 AUGUST 2013";
                ?>
            </div>
            <div id="page_11" class="news_desc" style="display: none">
                <br>
                <a class="fancybox-fittoview" data-fancybox-group="thumb" href="/uploads/activities/q3_champions_challenge.jpg"><img width="460"  src="/uploads/activities/q3_champions_challenge.jpg" alt = "Q3 Champions Challenge - BMW 5 Series‏"></a><br>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='12'>INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "8 JULY 2013";
                ?>
            </div>
            <div id="page_12" class="news_desc" style="display: none">
                <br><img width="460"  src="http://partner.maximtrader.com/images/email/Maxim_IME_Poster.jpg" alt = "INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)‏"></a><br>
            </div>

            <div class="popdivider"></div>
        </div>
        <div class="page">
            <div class="poptitle">
                <a href='#' class="page_link" ref='13'>INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)</a>
            </div>
            <div class="news_date">
            <?php
                $dateUtil = new DateUtil();
                echo "8 JULY 2013";
                ?>
            </div>
            <div id="page_13" class="news_desc" style="display: none">
                <br><img width="460"  src="http://partner.maximtrader.com/images/email/IME_Poster_<?php echo $culture;?>.jpg" alt = "INAUGURAL INTERNATIONAL MEMBER EXCHANGE (IME)‏"></a><br>
            </div>

        </div>
    <div class="popdivider"></div>
    </div>
    <?php //} ?>
    <p></p>
    <a id="popupContactClose2"><?php echo __('CLOSE') ?></a><br>
</div>
<div style="min-height: 1572px; opacity: 0.7; display: none;" id="backgroundPopup"></div>

</body>
</html>