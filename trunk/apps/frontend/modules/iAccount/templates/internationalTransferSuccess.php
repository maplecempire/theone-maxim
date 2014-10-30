<?php
include('scripts.php');
$culture = $sf_user->getCulture();
?>

<style type="text/css">
.page_ul ul,  .page_ul li {
    padding-left: 10px !important;
    padding-bottom: 5px !important;
}
</style>
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td><br></td>
</tr>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('International Transfer Information') ?></span></td>
</tr>
<tr>
    <td><br>
        <?php if ($sf_flash->has('successMsg')): ?>
            <div class="ui-widget">
                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                     class="ui-state-highlight ui-corner-all">
                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                  class="ui-icon ui-icon-info"></span>
                        <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                </div>
            </div>
            <?php endif; ?>
        <?php if ($sf_flash->has('errorMsg')): ?>
            <div class="ui-widget">
                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                     class="ui-state-error ui-corner-all">
                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                  class="ui-icon ui-icon-alert"></span>
                        <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                </div>
            </div>
            <?php endif; ?>

    </td>
</tr>
<tr>
    <td>
        <table cellpadding="3" cellspacing="5">
            <tbody>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                <?php if ($culture == "cn") { ?>
                    Maxim Capital Limited Seychelles (公司名称)
                    <br><br>Please deposit fund from your banking account to following account by international transfer via bank counter or internet banking. The account information is stated below.
                    <br><br>
                    <ul class="page_ul">
                        <li>You may transfer funds into your personal i-Account or Maxim’s corporate i-Account by international transfer via any bank counter or via internet banking. We will process your remittance as soon as we receive it.</li>
                        <li>Alternatively, you may also do a local bank transfer in the following countries:
                            <ol>
                                <li>Korea</li>
                                <li>Japan</li>
                            </ol>
                        </li>
                        <li>The bank account information are as follows (Please take note of the important notice at the bottom) :</li>
                    </ul>
                <?php } else if ($culture == "kr") { ?>
                        Maxim Capital Limited Seychelles (Company name)
                    <!--<br><br>Please deposit fund from your banking account to following account by international transfer via bank counter or internet banking. The account information is stated below.
                    <br><br>
                    <ul class="page_ul">
                        <li>You may transfer funds into your personal i-Account or Maxim’s corporate i-Account by international transfer via any bank counter or via internet banking. We will process your remittance as soon as we receive it.</li>
                        <li>Alternatively, you may also do a local bank transfer in the following countries:
                            <ol>
                                <li>Korea</li>
                                <li>Japan</li>
                            </ol>
                        </li>
                        <li>The bank account information are as follows (Please take note of the important notice at the bottom) :</li>
                    </ul>-->
                <?php } else if ($culture == "jp") { ?>
                        Maxim Capital Limited Seychelles (Company name)
                    <!--<br><br>Please deposit fund from your banking account to following account by international transfer via bank counter or internet banking. The account information is stated below.
                    <br><br>
                    <ul class="page_ul">
                        <li>You may transfer funds into your personal i-Account or Maxim’s corporate i-Account by international transfer via any bank counter or via internet banking. We will process your remittance as soon as we receive it.</li>
                        <li>Alternatively, you may also do a local bank transfer in the following countries:
                            <ol>
                                <li>Korea</li>
                                <li>Japan</li>
                            </ol>
                        </li>
                        <li>The bank account information are as follows (Please take note of the important notice at the bottom) :</li>
                    </ul>-->
                <?php } else { ?>
                    Maxim Capital Limited Seychelles (Company name)
                    <br><br>Please deposit fund from your banking account to following account by international transfer via bank counter or internet banking. The account information is stated below.
                    <br><br>
                    <ul class="page_ul">
                        <li>You may transfer funds into your personal i-Account or Maxim’s corporate i-Account by international transfer via any bank counter or via internet banking. We will process your remittance as soon as we receive it.</li>
                        <li>Alternatively, you may also do a local bank transfer in the following countries:
                            <ol>
                                <li>Korea</li>
                                <li>Japan</li>
                            </ol>
                        </li>
                        <li>The bank account information are as follows (Please take note of the important notice at the bottom) :</li>
                    </ul>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Section A') ?></span></td>
            </tr>
            <tr>
                <td class="">
                <ul class="page_ul">
                    <?php if ($culture == "cn") { ?>
                        <li>当您完成i-Account注册并获取i-Account账号之后，请到Maxim Trader的 “member area” 将您i-Account详细信息更新到 “user profile” 中。完成之后，您便可每月使用i-Account进行出金。</li>
                    	<li>在您完成向Maxim i-Account 账户汇款后，请扫描电汇收据并发送至finance@maximtrader.com。</li>
	                <?php } else if ($culture == "kr") { ?>
	                    <li>i-Account등록 완료 후, i-Account계좌번호를 확인 하시면Maxim Trader사의「member area 」의 「user profile (개인설정)」에서,i-Account의 정확한 정보를(계좌번호 등) 갱신하여 주십시오.갱신 완료 후, i-Account를 매달 출금시 이용하실수 있습니다. </li>
	                    <li>Maxim사의i-Account로 자금 송금 후, finance@maximtrader.com로TTreceipt를 첨부해 주십시오.</li>
	                <?php } else if ($culture == "jp") { ?>
	                    <li>i-Accountの登録が完了し、i-Accountの口座番号を受け取りましたら、Maxim Trader社の「member area (メンバーエリア)」から「user profile (個人設定)」にアクセスし、i-Accountに関する正確な情報を更新してください。更新が完了した後、i-Account を月々の引き出しにご利用いただけます。</li>
	                    <li>Maxim社のi-Accountに資金を送金した後、finance@maximtrader.comまでTTレシートをスキャンしたものをメールにて送付してください。</li>
	                <?php } else { ?>
	                    <li>Once you have completed your i-Account registration and received your i-Account number, please go to
	                        your Maxim Trader “member area” and update the exact information of your i-Account into your “user
	                        profile”. Once this is done, you may use your i-Account as an option for your monthly withdrawal.</li>
	                    <li>After you have remitted funds to Maxim Corporate i-Account, please scan and email the TT receipt to
	                        finance@maximtrader.com.</li>
                    <?php } ?>
                </ul>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Section B') ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <?php if ($culture == "cn") { ?>
                        	您可在银行柜台或网上银行，通过国际汇款从您自己的银行账户向以下账户汇款。账户信息如下。
			                <br>
			                <br>
			                <ul class="page_ul">
			                    <li>您可以通过任何银行柜台或网上银行，用国际汇款方式汇款到您的个人i-Account账户或Maxim企业i-Account账户。我们会在确认到汇款后立即进行处理。</li>
			                    <li>银行账户信息如下 （请注意底部需要注意事项）</li>
			                </ul>
			                <br><br>
			                <ul class="page_ul">
			                    <li>收款方银行名称：SHANGHAI PUDONG DEVELOPMENT BANK</li>
			                    <li>收款方银行地址：12 ZHONG SHAN DONG YI LU SHANGHAI200002 CHINA</li>
			                    <li>收款方银行国家：中国</li>
			                    <li>SWIFT: SPDBCNSHOSA</li>
			                    <li>收款方账户名称：IACCOUNT SERVICES (HK) LIMITED</li>
			                    <li>收款方地址: Room501,5/F,Workingport Commercial Building,3 Hau Fook Street,Tsim Sha Tsui,Kowloon,Hong Kong</li>
			                    <li>收款方账号（各币种账号不同）</li>
			                    <li>收款方地区：香港</li>
			                    <li>邮编： 999077</li>
			                    <li>USD: OSA1144632571742</li>
			                </ul>
                <?php } else if ($culture == "kr") { ?>
                    은행 창구 또는 인터넷뱅킹을 이용하여 하기의 계좌로 국제송금 하여주십시오.
                    <ul class="page_ul">
                    <li>은행 창구 또는 인터넷뱅킹을 이용하여, 고객님의i-Account또는Maxim사의 법인i-Account로 입금 하실수 있습니다. 고객님의 입금이 확인 되면, 즉시 송금처리 해드리겠습니다.</li>
                    <li>국내송금에 대해서, Section C의 기재내용을 확인하여 주십시오.</li>
                    <li>은행계좌 정보는 하기를 참조하여 주십시오. (자료 하단의 「중요」에 기재되어 있는 내용포함)</li>
                    </ul>
                <br>
                <br>
                입금계좌 정보
                <ul class="page_ul">
                    <li>은행명: SHANGHAI PUDONG DEVELOPMENT BANK</li>
                    <li>은행주소: 12 ZHONG SHAN DONG YI LU SHANGHAI200002 CHINA</li>
                    <li>은행국가: CHINA</li>
                    <li>SWIFT: SPDBCNSHOSA</li>
                    <li>계좌명의: IACCOUNT SERVICES (HK) LIMITED</li>
                    <li>계좌명의인 주소: Room501,5/F,Workingport Commercial Building,3 Hau Fook Street,Tsim Sha Tsui,Kowloon,Hong Kong</li>
                    <li>계좌번호：통화별로 계좌번호가 다릅니다</li>
                    <li>계좌명의인 국가: HONG KONG</li>
                    <li>우편번호: 999077</li>
                    <li>USD계좌:OSA11443632571742</li>
                </ul>
                <?php } else if ($culture == "jp") { ?>

銀行窓口またはインターネットバンキングにて、お客様のお持ちの銀行口座から下記口座あてに国際送金してください。

<ul class="page_ul">
                    <li>資金を銀行の窓口またはネットバンキングより、お客様のi-AccountまたはMaximの法人i-Accountに入金することができます。お客様からの入金の確認が取れ次第、早急に送金の処理をさせていただきます。</li>
<li>国内送金については、Section Cに記載の内容をご確認ください。</li>
<li>銀行口座情報は下記の通りとなります。(資料下部の「重要」に記載されている内容も合わせてご確認ください。)</li>
</ul>
                        入金口座情報 (International Transfer)
                <br>
                <br>
                <ul class="page_ul">
                    <li>銀行名: SHANGHAI PUDONG DEVELOPMENT BANK</li>
                    <li>銀行住所: 12 ZHONG SHAN DONG YI LU SHANGHAI200002 CHINA</li>
                    <li>銀行国: CHINA</li>
                    <li>SWIFT: SPDBCNSHOSA</li>
                    <li>口座名義: IACCOUNT SERVICES (HK) LIMITED</li>
                    <li>口座名義人住所: Room501,5/F,Workingport Commercial Building,3 Hau Fook Street,Tsim Sha Tsui,Kowloon,Hong Kong</li>
                    <li>口座番号：各通貨ごとに異なります</li>
                    <li>口座名義人国: HONG KONG</li>
                    <li>郵便番号: 999077</li>
                    <li>USD口座:OSA11443632571742</li>
                </ul>
                <?php } else { ?>
                    Beneficiary Account Information (International Transfer)
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>Name of Beneficiary Bank: SHANGHAI PUDONG DEVELOPMENT BANK</li>
                        <li>Address of Beneficiary Bank: 12 ZHONG SHAN DONG YI LU SHANGHAI200002 CHINA</li>
                        <li>Country of Beneficiary Bank: CHINA</li>
                        <li>SWIFT: SPDBCNSHOSA</li>
                        <li>Beneficiary Name: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>Beneficiary Address: Room501,5/F,Workingport Commercial Building,3 Hau Fook Street,Tsim Sha Tsui,Kowloon,Hong Kong</li>
                        <li>Beneficiary Account (each currency has respective account number)</li>
                        <li>Beneficiary Country: HONG KONG</li>
                        <li>Postcode: 999077</li>
                        <li>USD:OSA11443632571742</li>
                    </ul>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>

            <tr>
                <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('[Important Notice]') ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <?php if ($culture == "cn") { ?>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>如果您往自己的i-Account账户汇款，请在“Message”栏中填入您的i-Account账号 （例：111-123456-888）</li>
                        <li>如果您往Maxim企业i-Account账户汇款, 请在您的i-Account账号前面加上“MAX”(例：MAX 111-123456-888)</li>
                        <li>请注意，如果“Message”栏中没有填写任何信息，我们将无法进行处理汇款</li>
                    </ul>

                    <br>
                    <br>** Please note if no information is filled in the memo / remarks column in the remittance, we will be unable to post the transaction.
                <?php } else if ($culture == "kr") { ?>
                    메시지란 기입방법
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>본인명의의i-Account계좌로 입금하시는 경우i-Account계좌번호 중간 6자리중 끝에서부터 5자리 를 입력하여 주십시오
                            <br>（예：계좌번호가[111-123456-888]인 경우 [23456]기입）</li>
                        <li>Maxim사의 계좌로 입금하실 경우, i-Account번호 앞에 [M]기입 후 i-Account계좌번호 중간 6자리중 끝에서부터 4자리를 입력하여 주십시오
                            <br>(예：계좌번호가[111-123456-888]인 경우 [M3456]기입)</li>
                    </ul>

                    <br>
                    <br>**「메시지란」에 내용을 기입하지 않으시면, i-Account에 반영되지 않으므로, 이 경우  「support@liri-bd.com」로 송금명세서와 함께 입금하실i-Account계좌번호를 기재하여 연락주십시오.
                    <br>** 송금처 은행정보를 잘못기재하신 경우, 송금(이체)하신 은행에 연락하여 정보를 바르게 수정하여 주십시오.

                <?php } else if ($culture == "jp") { ?>
                        メッセージ欄の記入内容
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>受取人へのメッセージ：ご自身のi-Account口座に入金する場合、ご自身のi-Account番号をご記載ください。
                            <br>例: 111-123456-888</li>
                        <li>Maxim社口座へ入金を行う場合には、ご自身のi-Account口座番号の前に「MAX」と記入してください。
                            <br>例: "MAX 111-123456-888".</li>
                    </ul>

                    <br>
                    <br>** 「メッセージ」欄の記入漏れがあった場合には、送金を反映できかねますので、予めご了承ください。
                <?php } else { ?>
                    Beneficiary Account Information (International Transfer)
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>Please include your i-Account No. in the "Message" box if you want to send to your own i-Account.
                            <br>eg. 111-123456-888</li>
                        <li>Please add the word "MAX" before your i-Account No. if you want to send to Maxim.
                            <br>eg. "MAX 111-123456-888".</li>
                    </ul>

                    <br>
                    <br>** Please note if no information is filled in the memo / remarks column in the remittance, we will be unable to post the transaction.
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>

            <?php if ($culture == "kr") { ?>
                    <tr>
                <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Section C') ?></span></td>
            </tr>
            <tr>
                <td class="">
<br>                <strong>Local Bank Transfer(HP)안내</strong>
<br>
<br>당사의 서비스를 이용해 주셔서 감사합니다.
<br>
<br>당사에서는 i-Account법인계좌 입금방법으로써 한국국내의 송금대행처와 함께 손을 잡고 「Local Bank Transfer（HP）」라는 서비스를 제공하고 있습니다.
<br>
<br>본 서비스를 이용하여 고객님들께서는 법인명의i-Account계좌에 해외송금이 아닌 국내송금으로 자금을 이체 하실수 있습니다.
<br>
<br><strong>서비스명</strong>
<br>Local Bank Transfer（HP）
<br>※한국 국내송금으로 법인i-Account계좌 입금이 가능합니다.
<br>
<br><strong>입금은행 계좌</strong>
<br>은행명：Korea Exchange Bank(외환은행, 강남역 지점)
<br>계좌명의：Hanapay Co Ltd
<br>계좌번호：630008529734
<br>
<br><strong>입금반영</strong>
<br>- 2영업일 이내
<br>** 송금일 당일（한국시간17：00이전송금）을 제 1영업일로 합니다.
<br>
<br><strong>이용방법</strong>
<br><strong><법인 i-Account계좌 송금방법></strong>
<br>송금메시지 또는 송금자란에 송금처인 Agent의 법인 기호를 입력하여 주십시오.
<br>** Maxim사의 계좌로 입금하실 경우, 본인명의의 i-Account번호 앞에 [MAX]를 기입하여 주십시오.
<br> 　（예:MAX: 111-123456-888）
<br>
<br><strong><개인i-Account계좌 송금방법></strong>
<br>송금메시지 또는 송금자란에 입금하시는 경우i-Account번호를 기입하여 주십시오.
<br>（예：111-123456-888）
<br>**「메시지란」에 내용을 기입하지 않으시면, i-Account에 반영되지 않으므로, 이 경우  「support@liri-bd.com」로 송금명세서와 함께 입금하실i-Account계좌번호를 기재하여 연락주십시오.
<br>** 송금처 은행정보를 잘못기재하신 경우, 송금(이체)하신 은행에 연락하여 정보를 바르게 수정하여 주십시오.
<br>　
<br>
<br><strong>입금은행 계좌 사용에 대해</strong>
<br>- 본 서비스는 당사에서 지정하는 계좌로 입금하는 목적으로만 이용가능 합니다.
<br>- 본 서비스는 당사가 지정한 계좌에USD로 입금반영 됩니다.
<br>
<br>
<br><strong>금지사항</strong>
<br>
<ul>
    <li>이용자가 본 서비스를 관리, 운용, 제공 한다는 오해를 불러일으키는 표현 및 안내.</li>
    <li>이용자의 Web사이트 내에서 입금은행 계좌를 공개하는 것.</li>
    <li>법령, 이용규약, 본 가이드라인 또는 공서양속에 위반되는 행위.</li>
    <li>타인에게 경제적 정신적 손해를 끼치는 것.</li>
    <li>타인의 명예를 훼손 및 프라이버시를 침해하는 것.</li>
    <li>당사에 대한 비방 또는 악성댓글작성, 당사의 권리를 침해 하는것.</li>
    <li>일반 공공장소에서 통지, 정보를 공개 하는것.</li>
    <li>입금은행 계좌의 명의인에게 직접 연락 하는것.</li>
</ul>
<br>
<br>** 금지항목에 해당하는 내용이 확인되는 경우, 본 서비스이용이 중지됩니다.
<br>
<br>송금처 은행정보를 잘못기재하신 경우, 송금(이체)하신 은행에 연락하여 정보를 바르게 수정하여 주십시오.

                </td>
            </tr>
            <?php } ?>
            <?php if ($culture == "jp") { ?>
            <tr>
                <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Section C') ?></span></td>
            </tr>
            <tr>
                <td class="">
<br>                Local Bank Transfer(ATM)のご案内について
<br>
<br>                i-Accountへ新たな入金方法として国内送金代行により早期着金を実現する『Local Bank Transfer(ATM)』を開始する運びとなりましたことを案内いたします。こちらのServiceをご利用頂くことにより自身へのi-Accountや法人名義のi-Accountへの送金が日本の銀行口座への送金で可能となります。
<br>                i-Accountへの送金として当日～5日までを目安にi-Account口座へ資金反映が可能となります。
<br>
<br><strong>サービス名</strong>
<br>Local Bank Transfer(ATM)
<br>** 日本国内の送金によりi-Account口座へ入金が可能となります。
<br>
<br><strong>ご利用条件</strong>
<br>- i-Accountへのご入金に限り受付する事ができます。
<br>- 1回あたりの送金はJPYで100万円が上限となります。
<br>(100万円以上を送金する場合、100万円毎に分割となり別途手数料が発生致します。)
<br>** 場合により、限度額は変更となる場合があります。
<br>
<br><strong>ご利用方法</strong>
<br>Local Bank Transfer(ATM)の利用には登録手続きなどは必要ございません。
<br>ご入金されたい場合、下記の方法で送金頂ければi-Accountへ反映されます。
<br>
<br>送金先銀行口座:
<br>銀行名：三井住友(ミツイスミトモ)　銀行　新宿西口支店
<br>口座名義：エーティーエム、シュウノウグチ　
<br>口座番号：普通口座　2925491
<br>
<br>＜個人のi-Accountへの送金方法＞
<br>振込名義人欄へエクスプレスの有無とご入金先のi-Account番号を下記の様にご記入ください。
<br>
<br>- 通常入金の場合:入金希望i-Account口座
<br>例：111123456888
<br>i-Account口座への送金反映は3～5営業日を目安に反映されます。
<br>
<br>・エクスプレス入金の場合:EX＋入金希望i-Account口座
<br>例:EX  111123456888
<br>i-Account口座への送金反映は当日に反映されます。
<br>
<br><strong><法人名義のi-Accountへの送金方法＞</strong>
<br>振込名義人欄へエクスプレスの有無とご入金先の法人の任意の記号数字(法人記号+御社が顧客を識別できる任意の数字)をご記入ください。
<br>
<br>- 通常入金の場合:
<br>入金希望の法人の任意の記号数字(法人記号+御社が顧客を識別できる任意の数字)
<br>例：法人記号 0000
<br>i-Account口座への送金反映は3～5営業日を目安に反映されます。
<br>
<br>- エクスプレス入金の場合:
<br>EX＋入金希望の法人の任意の記号数字(法人記号+御社が顧客を識別できる任意の数字)
<br>例：EX 法人記号 0000
<br>i-Account口座への送金反映は当日に反映されます。
<br>
<br>**	以下、ご利用基準となります。
<br>- 日本時間15時までにご送金頂ければ、日本時間の当日中の送金として送金処理致します。
<br>- 日本時間15時以降にご送金頂いた場合、日本時間の翌日の送金として送金処理致します。
<br>- 送金処理は三井住友銀行の営業日ベースにて行い、月曜～金曜(祝日以外)となります。
<br>
<br>**	i-Account口座番号はどの口座への入金かを判断する唯一の情報となりますので、忘れずにご記入をお願いします。
<br>
<br><strong>ご利用料金(送金1回あたり)</strong>
<br>- 通常入金の場合
<br>　JPY 1,500/1回
<br>- エクスプレス入金の場合
<br>　JPY 2,500/1回
<br>
<br>** 100万円以上を送金する場合、100万円毎に分割となり、別途手数料が発生致します。
<br>** 利用料金は送金額より差し引いた金額をi-Account口座へ入金反映します。
<br>
<br><strong>注意事項</strong>
<br>振込人欄の記入内容：
<br>- ご自身のi-Account口座に入金する場合、ご自身のi-Account番号をご記載ください。（例：111123456888）
<br>- Maxim社口座へ入金を行う場合には、ご自身のi-Account口座番号の前に「MAX」と記入してください。
<br>（例：MAX111123456888）
<br>
<br>- 振込人欄にご記入頂く入金希望i-Account口座番号に間違いがございましたら、i-Accountに着金反映出来かねますので、この場合、お客様ご登録メールアドレスより「support@liri-bd.com」までご連絡頂き、送金明細書とご入金希望i-Account口座番号をご連絡頂く必要がございます。
<br>
<br>- 送金先銀行情報を記入し間違えた場合、送金元銀行にお問合せ頂き、送金先銀行情報を修正ください。
<br>
<br>- 送金代行においてはエーティーエム社の責任の元、行っておりますので当社に関しては影響を及ぼさない点を予めご了承ください。
<br>
<br><strong>禁止事項</strong>
<br>- i-Account口座への入金以外の用途でのご利用できません。
<br>(BinaryOption口座、Forex口座などへはご利用頂けません。)
<br>- 一般パブリックへ通知、情報公開すること
<br>- 入金銀行口座の名義人へ直接コンタクトを取ること
<br>- 利用者が本サービスを管理、運用、提供しているという誤解を招く表現や案内
<br>- 法令、利用規約、このガイドラインまたは公序良俗に反するもの
<br>- 他人に経済的もしくは精神的損害を与えるもの
<br>- 他人の名誉を毀損し、または他人のプライバシーを侵害するもの
<br>- 弊社を誹謗もしくは中傷し、または弊社の権利を侵害するもの
<br>** 禁止事項に該当する内容が確認された場合、ご利用を停止する場合がございますので、ご了承ください。

                </td>
            </tr>
            <?php } ?>
            <tr>
                <td><br></td>
            </tr>
            </tbody>
        </table>

        <div class="clear"></div>
        <br>

    </td>
</tr>
<tr>
<td>
</td>
</tr>
</tbody>
</table>