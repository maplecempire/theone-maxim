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
                    马胜资本有限公司(塞舌尔)
                    <br><br>请通过银行柜台或者网络转账至以后银行账户；具体请参照下文B部分的账户信息。
                    <br><br>
                    <ul class="page_ul">
                        <li>会员可以通过银行柜台或者网络转账从个人i-Account汇款至马胜金融集团的i-Account账户。一旦确认收到款项，公司会第一时间处理。</li>
                        <li>另外，以下国家或地区的会员还可以通过本地银行，使用本地货币转账
                            <ol>
                                <li>韩国</li>
                                <li>日本</li>
                                <li>香港</li>
                            </ol>
                        </li>
                        <li>下一部分列有具体银行账户信息(请留意页面底部的重要通知):</li>
                    </ul>
                    <br><br>
                <?php } else if ($culture == "kr") { ?>
                    马胜资本有限公司(塞舌尔)
                    <br><br>请通过银行柜台或者网络转账至以后银行账户；具体请参照下文B部分的账户信息。
                    <br><br>
                    <ul class="page_ul">
                        <li>会员可以通过银行柜台或者网络转账从个人i-Account汇款至马胜金融集团的i-Account账户。一旦确认收到款项，公司会第一时间处理。</li>
                        <li>另外，以下国家或地区的会员还可以通过本地银行，使用本地货币转账
                            <ol>
                                <li>韩国</li>
                                <li>日本</li>
                                <li>香港</li>
                            </ol>
                        </li>
                        <li>下一部分列有具体银行账户信息(请留意页面底部的重要通知):</li>
                    </ul>
                    <br><br>
                <?php } else if ($culture == "jp") { ?>
                    マキシム・キャピタル・リミテッド（セーシェル）
                    <br><br>どうぞあなたの銀行口座から以下のアカウントに銀行窓口またはネットバンキングによる国際送金で資金を送金してください。アカウントの情報は以下のセクションBに記載されています。
                    <br><br>
                    <ul class="page_ul">
                        <li>あなたはファンドを個人的なi-Accountまたはマキシムの社のi-アカウントに銀行窓口またはインターネットバンキングによる国際送金にて送るかもしれません。私たちは受け取ったら出来るだけ早く送金を処理します。</li>
                        <li>別の方法として、以下の国においては、あなたは現地通貨を利用して現地の銀行送金を使用するかもしれません。
                            <ol>
                                <li>韩国</li>
                                <li>日本</li>
                                <li>香港</li>
                            </ol>
                        </li>
                        <li>銀行の情報は以下の通りです。（最後にある大切な情報にご注意ください）</li>
                    </ul>
                    <br><br>
                <?php } else { ?>
                    맥심 캐피탈 주식회사 (세이쉘)
                    <br><br>귀하의 은행 계좌에서 아래의 계좌로 외환 거래 또는 인터넷 외환 거래로  자금을 입금하시기 바랍니다. 계좌정보는 아래 섹션 B에 명시되어 있습니다.
                    <br><br>
                    <ul class="page_ul">
                        <li>귀하의 자금을 귀하의 개인 i-어카운트 또는 맥심 회사 i-어카운트로 외환 송금을 직접 또는 인터넷을 통해 이체하시기 바랍니다. 자금을 받는 즉시 귀하의 송금을 진행할 것입니다.</li>
                        <li>대안으로는, 아래의 국가에서는 자국의 통화로 국내 이체를 하실 수 있습니다.
                            <ol>
                                <li>대한민국</li>
                                <li>일본</li>
                                <li>홍콩</li>
                            </ol>
                        </li>
                        <li>은행 계좌 정보는 아래와 같습니다. (아래 중요한 노티스를 참고하시기 바랍니다.)</li>
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
                    收款人信息如下。会员请注意以下两个选择:
                    <br>
                    <br>
                    <strong>选择 1:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>银行: BANK OF COMMUNICATIONS CO., LTD OFFSHORE BANKING UNIT</li>
                        <li>银行地址: NO 188, YINCHENG ZHONG ROAD, SHANGHAI, CHINA</li>
                        <li>银行国家: CHINA</li>
                        <li>SWIFT: COMMCN3XOBU</li>
                        <li>收款人姓名: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>收款人地址: Room501, 5/F, Workingport Commercial Building, 3 Hau Fook Street,Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Account (each currency has respective account number)</li>
                        <li>收款人国家/地区: HONG KONG</li>
                        <li>Postcode: 999077</li>
                        <li>美金账户号码: OSA90000088020100</li>
                        <li>港币账户号码: OSA90000088020100</li>
                    </ul>
                    <br>
                    <br>
                    <strong>选择 2:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>银行: CHINA CONSTRUCTION BANK (ASIA) CORPORATION LIMITED</li>
                        <li>银行地址: HONG KONG DEVON HOUSE, FLOOR 11:  979, KING’S ROAD</li>
                        <li>银行国家: HONG KONG</li>
                        <li>SWIFT: CCBQHKAX</li>
                        <li>收款人姓名: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>收款人国家/地区: Room 501,5/F, Workingport Commercial Building, 3 Hau Fook Street, Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Country: HONG KONG</li>
                        <li>美金账户号码: 10343921</li>
                        <li>港币账户号码: 10343921</li>
                    </ul>
                <?php } else if ($culture == "kr") { ?>
                    Beneficiary Account information for International Transfer. Please note you have two options to choose from:
                    <br>
                    <br>
                    <strong>옵션 1:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>수취 은행명: BANK OF COMMUNICATIONS CO., LTD OFFSHORE BANKING UNIT</li>
                        <li>수취 은행 주소: NO 188, YINCHENG ZHONG ROAD, SHANGHAI, CHINA</li>
                        <li>수취 국가: CHINA</li>
                        <li>SWIFT: COMMCN3XOBU</li>
                        <li>수취인 명: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>수취인 주소: Room501, 5/F, Workingport Commercial Building, 3 Hau Fook Street,Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Account (each currency has respective account number)</li>
                        <li>Beneficiary Country: HONG KONG</li>
                        <li>Postcode: 999077</li>
                        <li>미국달러 어카운트: OSA90000088020100</li>
                        <li>홍콩달러 어카운트: OSA90000088020100</li>
                    </ul>
                    <br>
                    <br>
                    <strong>옵션 2:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>수취 은행명: CHINA CONSTRUCTION BANK (ASIA) CORPORATION LIMITED</li>
                        <li>수취 은행 주소: HONG KONG DEVON HOUSE, FLOOR 11:  979, KING’S ROAD</li>
                        <li>수취 국가: HONG KONG</li>
                        <li>SWIFT: CCBQHKAX</li>
                        <li>수취인 명: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>Beneficiary Address: Room 501,5/F, Workingport Commercial Building, 3 Hau Fook Street, Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Country: HONG KONG</li>
                        <li>미국달러 어카운트: 10343921</li>
                        <li>홍콩달러 어카운트: 10343921</li>
                    </ul>
                <?php } else if ($culture == "jp") { ?>

                    国際資金送金のための受益者のアカウント情報。以下の二つのオプションがあることにご留意ください
                    <br>
                    <br>
                    <strong>オプション 1:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>受け取り銀行の住所: BANK OF COMMUNICATIONS CO., LTD OFFSHORE BANKING UNIT</li>
                        <li>受け取り銀行の住所: NO 188, YINCHENG ZHONG ROAD, SHANGHAI, CHINA</li>
                        <li>受け取り銀行のある国: CHINA</li>
                        <li>SWIFT: COMMCN3XOBU</li>
                        <li>受け取り者名: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>受け取り者住所: Room501, 5/F, Workingport Commercial Building, 3 Hau Fook Street,Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Account (each currency has respective account number)</li>
                        <li>受け取り銀行のある国: HONG KONG</li>
                        <li>Postcode: 999077</li>
                        <li>HKD Account: OSA90000088020100</li>
                        <li>USD Account: OSA90000088020100</li>
                    </ul>
                    <br>
                    <br>
                    <strong>オプション 2:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>受け取り銀行の住所: CHINA CONSTRUCTION BANK (ASIA) CORPORATION LIMITED</li>
                        <li>受け取り銀行の住所: HONG KONG DEVON HOUSE, FLOOR 11:  979, KING’S ROAD</li>
                        <li>受け取り銀行のある国: HONG KONG</li>
                        <li>SWIFT: CCBQHKAX</li>
                        <li>受け取り者名: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>受け取り者住所: Room 501,5/F, Workingport Commercial Building, 3 Hau Fook Street, Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>受け取り銀行のある国: HONG KONG</li>
                        <li>USD Account: 10343921</li>
                        <li>HKD Account: 10343921</li>
                    </ul>
                </ul>
                <?php } else { ?>
                    Beneficiary Account information for International Transfer. Please note you have two options to choose from:
                    <br>
                    <br>
                    <strong>OPTION 1:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>Name of Beneficiary Bank: BANK OF COMMUNICATIONS CO., LTD OFFSHORE BANKING UNIT</li>
                        <li>Address of Beneficiary Bank: NO 188, YINCHENG ZHONG ROAD, SHANGHAI, CHINA</li>
                        <li>Country of Beneficiary Bank: CHINA</li>
                        <li>SWIFT: COMMCN3XOBU</li>
                        <li>Beneficiary Name: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>Beneficiary Address: Room501, 5/F, Workingport Commercial Building, 3 Hau Fook Street,Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Account (each currency has respective account number)</li>
                        <li>Beneficiary Country: HONG KONG</li>
                        <li>Postcode: 999077</li>
                        <li>HKD Account: OSA90000088020100</li>
                        <li>USD Account: OSA90000088020100</li>
                    </ul>
                    <br>
                    <br>
                    <strong>OPTION 2:</strong>
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>Name of Beneficiary Bank: CHINA CONSTRUCTION BANK (ASIA) CORPORATION LIMITED</li>
                        <li>Address of Beneficiary Bank: HONG KONG DEVON HOUSE, FLOOR 11:  979, KING’S ROAD</li>
                        <li>Country of Beneficiary Bank: HONG KONG</li>
                        <li>SWIFT: CCBQHKAX</li>
                        <li>Beneficiary Name: IACCOUNT SERVICES (HK) LIMITED</li>
                        <li>Beneficiary Address: Room 501,5/F, Workingport Commercial Building, 3 Hau Fook Street, Tsim Sha Tsui, Kowloon, Hong Kong</li>
                        <li>Beneficiary Country: HONG KONG</li>
                        <li>USD Account: 10343921</li>
                        <li>HKD Account: 10343921</li>
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
                    用于国家转账的收款人账户信息
                    <br>
                    <br>
                    请注意以上1、2项选择中的收款人只能是马胜资本有限公司或您个人的i-Account账户；根据会员个人意愿，请在转款页面中“备注”栏中填写不同的信息:
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>如果会员决定将款项转至个人i-Account账户，请在“备注”栏中填写您个人的i-Account账户
                            <br>如111-123456-888</li>
                        <li>如果会员决定将款项转至公司，请于“备注”栏中填写公司账户资料，如MAX 111-123456-888
                            <br>eg. "MAX 111-123456-888".</li>
                    </ul>

                    <br>
                    <br>** 如果转款单页面“备注”栏中没有填写具体的明示，公司将暂不对此款项做出公示/处理.
                <?php } else if ($culture == "kr") { ?>
                    외환 거래를 위한 수취인 계좌 정보:
                    <br>
                    <br>
                    외환 송금 신청서의 “메시지 또는 비고”란에 아래에 명시되어 있는 바와 같이 작성에 따라 위의 옵션 1과 옵션 2의 은행 계좌에 대한 최적의 수취인은 맥심 캐피탈 주식회사 또는 귀하의 개인 i-어카운트로 귀하가 비고란에 하시는 표시에 의해 정해집니다:
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>귀하의 i-어카운트에 보내시기를 원하신다면 i-어카운트 번호를 “메시지” 박스에 적어주시기 바랍니다.
                            <br>예. 111-123456-888</li>
                        <li>맥심으로 보내시기 원하신다면 귀하의 i-어카운트 번호 앞에 “MAX”를 적어주시기 바랍니다.
                            <br>예. "MAX 111-123456-888".</li>
                    </ul>

                    <br>
                    <br>** 송금영수증의 메시지/비고 란에 아무런 정보가 적혀있지 않다면 거래를 게시할 수 없음을 양지하시기 바랍니다.
                <?php } else if ($culture == "jp") { ?>
                    国際送金における受益者アカウントの情報
                    <br>
                    <br>
                    オプション1でも2でも、最終的な銀行口座の受益者は、マキシム・キャピタル・リミテッドまたはあなたの個人i-アカウントになることにご注意ください。これは、あなたが送金時の「メッセージまたは注意」欄に以下のように、何と書いたかによって決まります:
                    <br>
                    <br>
                    <ul class="page_ul">
                        <li>もし、あなたがご自身のi-アカウントに送金したい場合は、メッセージ欄にあなたのi-アカウント番号をご記入ください.
                            <br>eg. 111-123456-888</li>
                        <li>もしあなたがマキシムにお金を送りたい場合は、"MAX 111-123456-888"のようにあなたのi-アカウント番号の前に"MAX"を追加してください.</li>
                    </ul>

                    <br>
                    <br>** 注意:もし何もメッセージ／注意欄に書いていない場合には、私たちは取引を行いませんので、どうぞご注意ください.
                <?php } else { ?>
                    Beneficiary Account Information (International Transfer)
                    <br>
                    <br>
                    Please note the ultimate beneficiary for the above bank accounts in Option 1 and Option 2 is either Maxim Capital Limited or your personal i-Account, depending on what you write in the “Message or Remarks” column of the remittance application as stated below:
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