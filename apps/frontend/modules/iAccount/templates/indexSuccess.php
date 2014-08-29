<?php
include('scripts.php');
$culture = $sf_user->getCulture();
?>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td><br></td>
</tr>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Apply i-Account') ?></span></td>
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
        <table>
            <tr>
                <td align="left">
                    <a href="http://www.liri-bd.com/apply/apply-personal.php?a_aid=53cf8e44ce6ed&amp;a_bid=7f6fb8e1" target="_blank"><img src="http://partner.lidyarich.com/af300/accounts/default1/banners/7f6fb8e1.png" alt="" title="" width="270" height="112" /></a><img style="border:0" src="http://partner.lidyarich.com/af300/scripts/imp.php?a_aid=53cf8e44ce6ed&amp;a_bid=7f6fb8e1" width="1" height="1" alt="" />
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="http://www.liri-bd.com/apply/apply-personal.php?a_aid=53cf8e44ce6ed&amp;a_bid=7f6fb8e1" target="_blank">
                        <?php if ($culture == "cn") { ?>
                        <?php echo __('Please click to apply for an i-Account') ?>
                        <?php } else if ($culture == "kr") { ?>
                        i-Account와 카드를 동시에 신청하실 경우 이곳을 클릭하여 주십시오.
                        <?php } else if ($culture == "jp") { ?>
                        i-Accountとカードを同時に申し込む際はこちら
                        <?php } else { ?>
                        <?php echo __('Please click to apply for an i-Account') ?>
                        <?php } ?>
                    </a>
                </td>
            </tr>
            <!--<tr>
                <td>
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-highlight ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-info"></span>
                                <strong><?php /*echo __("For community transfers, kindly go to \"<strong>Add Community Member</strong>\" and fill in <br><br>1. Customer Name: Maxim Capital Limited <br>2. Customer Number: 000028911 <br>3. Customer Email Address: finance@maximtrader.com. <br><br>Tick \"Receive Funds From this Customer\" and Send Connection Request"); */?></strong></p>
                        </div>
                    </div>
                </td>
            </tr>-->
        </table>
        <br>
        <table cellpadding="3" cellspacing="5">
            <tbody>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php
                    if ($culture == "cn") {
                        echo __('What’s the i-Account?');
                    } else if ($culture == "kr") {
                        echo __('i-Account란?');
                    } else if ($culture == "jp") {
                        echo __('i-Accountとはなんですか?');
                    } else {
                        echo __('What’s the i-Account?');
                    }
                     ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span style="font-weight: bold;"><?php echo __('It’s an exclusive money platform where users can enjoy money transfers, making payments, currency diversification and many more E-Wallet functions. Access your account from any PC/tablets or right from your smart phones with no space and time limitations. With a Visa prepaid card, the i-Account allows cardholders to make purchases, or withdraw local currency from any Visa member stores and ATMs around the world.') ?></span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span style="font-weight: bold;">i-Account는 특별한 전자화폐 플랫폼이며, 사용자들은 송금, 지불, 자금 분산 등 보다 다양한 E-Wallet 서비스를 이용할 수 있습니다. 컴퓨터/태블릿PC、스마트폰을 이용하여 온라인상에서 계좌 이체、지불、외화 환전 서비스등을  시간과 장소에 구애받지 않고 사용하실수 있습니다.또한 i-Account 계좌와 연동된 Visa、Master카드를 이용하여 전 세계의 Visa、Master 가맹점에서 사용할 수 있고, 전 세계의Visa、Master 마크가 있는 ATM에서 현지 화폐를 인출할 수 있습니다.</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span style="font-weight: bold;">それは限られたユーザーが、資金の移動、支払い、通貨の両替ほか、たくさんの電子財布機能を楽しんでいただける特権的なマネープラットフォームです。PC/タブレットやあなたのスマートフォーンから、時間、場所を問わずにアクセスしていただけます。Visaプリペイドカードがあれば、i-アカウントを使って買い物や、世界中のVisaメンバーストアおよびATMでの現地通貨の引き出しができます。</span>
                    <?php
                    } else {
                    ?>
                        <span style="font-weight: bold;"><?php echo __('It’s an exclusive money platform where users can enjoy money transfers, making payments, currency diversification and many more E-Wallet functions. Access your account from any PC/tablets or right from your smart phones with no space and time limitations. With a Visa prepaid card, the i-Account allows cardholders to make purchases, or withdraw local currency from any Visa member stores and ATMs around the world.') ?></span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <ol style="padding-left: 20px;">
                        <?php if ($culture == "cn") { ?>
                        <li><?php echo __('Ideal solution for money transfers and tax plan!') ?></li>
                        <li><?php echo __('Your exclusive money platform!!') ?></li>
                        <?php } else if ($culture == "kr") { ?>
                        <li><?php echo __('자금이동 및 세무전략에 대한 이상적인 솔루션!') ?></li>
                        <li><?php echo __('당신만을 위한 특별한 머니 플랫폼') ?></li>
                        <?php } else if ($culture == "jp") { ?>
                        <li><?php echo __('資金移動や税金プランに理想的なソリューション！') ?></li>
                        <li><?php echo __('お客様専用の通貨プラットフォーム!') ?></li>
                        <?php } else { ?>
                        <li><?php echo __('Ideal solution for money transfers and tax plan!') ?></li>
                        <li><?php echo __('Your exclusive money platform!!') ?></li>
                        <?php } ?>

                    </ol>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>

            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title">1.
                    <?php if ($culture == "cn") { ?>
                            Multiple ways to fund your i-Account
                        <?php } else if ($culture == "kr") { ?>
                            다양한 방법을 통한 i-Account 입금
                        <?php } else if ($culture == "jp") { ?>
                            i-Accountへの様々な入金方法
                        <?php } else { ?>
                            Multiple ways to fund your i-Account
                        <?php } ?>
                    </span></td>
            </tr>
            <tr>
                <td class="">
                    <?php if ($culture == "cn") { ?>
                    <span><?php echo __('Users are able to make deposits to their i-Account through bank wire transfers, local bank transfer services or even with international brand card (VISA、Master Card、China Union pay). Also, when you deposit money from one i-Account to another i-Account, funds will be reflected immediately.') ?></span>
                    <?php } else if ($culture == "kr") { ?>
                    <span>국내외 송금 및 은행카드를 통해 i-Account 입금이 가능합니다. (VISA/Master Card、China Union pay) 또한 고객님의 i-Account에서 다른 분의 i-Account로 송금 시, 즉시 반영됩니다.

                    </span>
                    <?php } else if ($culture == "jp") { ?>
                    <span>銀行送金やローカルバンク・トランスファーにて入金ができます。また国際ブランドカード(VISA、Master Card、China Union pay)からも簡単に入金ができます。
                    i-Accountシステム上、第三者へのi-Accountへの振替の際は即時反映されます。</span>
                    <?php } else { ?>
                    <span><?php echo __('Users are able to make deposits to their i-Account through bank wire transfers, local bank transfer services or even with international brand card (VISA、Master Card、China Union pay). Also, when you deposit money from one i-Account to another i-Account, funds will be reflected immediately.') ?></span>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                    <?php if ($culture == "cn") { ?>
                    <span>Don't like the inconvenience of going to a retail bank when making transfers? Or simply don’t have time to go to the bank? With an i-Account, you can simply deposit funds into your account via a VISA, MasterCard, China Union Pay credit/debit card, as well as with a bank transfer. After your deposit is complete, you can make international transfers from the i-Account immediately. The i-Account allows you to open an account, deposit funds, and transfer money online 24/7/365. If you are thinking of diversifying your wealth outside your country, the i-Account is the ideal solution. Like any foreign financial offshore bank account, your government may require you to report the i-Account. Seek tax counsel to ensure you are in compliance with your country’s tax laws.</span>
                    <?php } else if ($culture == "kr") { ?>
                    <span>송금하기 위해 은행에 가는 것이 번거롭지 않으신가요? 또는 은행을 방문하실 시간이 없지 않으신가요?  i-Account로 간단히 Visa, Master 카드, China Union pay 신용/직불카드로 또는 은행 송금으로 귀하의 계좌에 입금할 수 있습니다. 입금이 완료되면 i-Account에서 즉시 국제 송금을 할 수 있습니다.
                            i-Account에서는 1년 365일 24시간 계좌를 개설할수 있으며 입금및 송금을 할 수 있습니다. 만약 보유재산을 해외로 분산하고 싶으시다면, i-Account는 이상적인 솔루션입니다.  다른 국외 은행 계좌와 같이, 정부는 귀하의 i-Account 리포트를 요청할 수 있습니다. 자국 세법을 준수하고자 한다면 세금 컨설팅을 받으십시오.</span>
                    <?php } else if ($culture == "jp") { ?>
                    <span>普段銀行へ行く時間がなく、銀行での送金サービスなどにご不便を感じていらっしゃいませんか？ i-Accountでは、クレジットカードによるご入金の後、すぐ国際送金をすることができます。お申込み、入金、送金まですべてオンラインで操作でき、24時間365日お取引をしていただくことができます。入金から送金までの流れがi-Accountシステム上で解決できます。もしあなたが富を海外へ移動することを考えているのなら、これは理想的なソリューションです。ほかのオフショアアカウントと同様に、あなたの政府はi-Accountのレポートを求めるでしょう。税金のコンサルタントをお探しいただき、あなたが自国の税法に従っていることを確認してください。</span>
                    <?php } else { ?>
                    <span>Don't like the inconvenience of going to a retail bank when making transfers? Or simply don’t have time to go to the bank? With an i-Account, you can simply deposit funds into your account via a VISA, MasterCard, China Union Pay credit/debit card, as well as with a bank transfer. After your deposit is complete, you can make international transfers from the i-Account immediately. The i-Account allows you to open an account, deposit funds, and transfer money online 24/7/365. If you are thinking of diversifying your wealth outside your country, the i-Account is the ideal solution. Like any foreign financial offshore bank account, your government may require you to report the i-Account. Seek tax counsel to ensure you are in compliance with your country’s tax laws.</span>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title">2.
                    <?php if ($culture == "cn") { ?>
                    <?php echo __('Speedy transfers without any boundaries') ?>
                    <?php } else if ($culture == "kr") { ?>
                    간단한 이용방법
                    <?php } else if ($culture == "jp") { ?>
                    簡単な利用方法
                    <?php } else { ?>
                    <?php echo __('Speedy transfers without any boundaries') ?>
                    <?php } ?>
                    </span></td>
            </tr>
            <tr>
                <td class="">
                    <span>
                        <?php if ($culture == "cn") { ?>
                        There are many transfer benefits to having an i-Account. Customers enjoy the boundless capital transfers among worldwide banks through international transfers, 24/7 online currency exchanges, and fast and convenient account settlement services.
                        <br><br>Transfers are conducted by i-Account on behalf of all customers, which gives you peace of mind knowing you have full privacy protection.
                        <br><br>Your i-Account is ideal for receiving dividends from your investments or commissions from online affiliates as the fund will be kept under the i-Account name.
                        <?php } else if ($culture == "kr") { ?>
                        i-Account에서는 국제송금, 외화 환전, 결제(지불)서비스를 265일 24시간 제공해 드리고 있습니다. 국제송금의 경우i-Account Services사가 대행하고 있기 때문에 송금시 고객님의 프라이버시를 전면적으로 보호해드릴 수 있습니다.
                        <br><br>또한 고객님의 자금은 i-Account의 명의하에 보관되므로, 투자후의 수익(배당금) 혹은 온라인 회원의 커미션 문제등을 해결하기에 이상적인 계좌입니다.
                        <?php } else if ($culture == "jp") { ?>
                        i-Accountでは、世界中の銀行宛へ送金、通貨の両替、支払いが24時間365日可能です。
                        <br><br>国際送金をする場合、i-Account Services社が送金を代行しているため、お客様の名前が送金時に出ることはありませんので、金融プライバシーを保つことができます。
                        <br><br>資金はi-Account名義で保全されますので、投資資金の配当やオンラインアフィリエイトのコミッション受け取りなどに最適な口座です。
                        <?php } else { ?>
                        There are many transfer benefits to having an i-Account. Customers enjoy the boundless capital transfers among worldwide banks through international transfers, 24/7 online currency exchanges, and fast and convenient account settlement services.
                        <br><br>Transfers are conducted by i-Account on behalf of all customers, which gives you peace of mind knowing you have full privacy protection.
                        <br><br>Your i-Account is ideal for receiving dividends from your investments or commissions from online affiliates as the fund will be kept under the i-Account name.
                        <?php } ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title">
                    <?php if ($culture == "cn") { ?>
                    3. Ideal for i-Account
                    <?php } else if ($culture == "kr") { ?>
                    3. i-Account는 이러한 고객님들께 추천드립니다.
                    <?php } else if ($culture == "jp") { ?>
                    3. i-Accountは下記のような方々にお薦めします。
                    <?php } else { ?>
                    3. Ideal for i-Account
                    <?php } ?>
                    </span></td>
            </tr>
            <tr>
                <td class="">
                    <span>
                        <?php if ($culture == "cn") { ?>
                        Anyone who wants to make international transfers conveniently.
<br>Anyone who wants to maintain financial privacy.
<br>Anyone who thinks the traditional banks are not convenient.
<br>Anyone who wants to gain currency diversification.
<br>Anyone who receives dividends from their investments.
<br>Anyone who wants to have a VISA/ Master Card with international exposure.
<br>Anyone who owns a business, and is looking for an account to diversify some of their funds.
                        <?php } else if ($culture == "kr") { ?>
                        <br>빠르고 간편한 국제송금을 원하시는 분
                        <br>개인정보 유지 문제로 고민하시는 분
                        <br>보수적인 은행 서비스에 불편을 느끼고 있는 분
                        <br>보유자금을 해외로 분산하시고 싶으신 분
                        <br>모종 투자에서 수익을 얻고계시는 분
                        <br>전세계에서 사용 가능한 Visa、Master카드를 발급하고 싶으신 분
                        <br>투자금에 대한 배당금을 송금받을 계좌가 필요하신 분
                        <br>사업진행중 발생한 수입, 매출등을 송금받을 계좌가 필요하신 분
                        <?php } else if ($culture == "jp") { ?>
                        <br>素早く簡単な国際送金が必要な方
                        <br>金融プライバシーを保ちたい方
                        <br>通常の銀行サービスに不便を感じられている方
                        <br>自国から海外へ資金を移動させたい方
                        <br>投資を行っており、配当などの受け皿がほしい方
                        <br>世界中で使えるVisa、Masterカードを利用したい方
                        <br>ビジネスを行っており、売り上げを受け取る口座が必要な方
                        <?php } else { ?>
                        Anyone who wants to make international transfers conveniently.
                        <br>Anyone who wants to maintain financial privacy.
                        <br>Anyone who thinks the traditional banks are not convenient.
                        <br>Anyone who wants to gain currency diversification.
                        <br>Anyone who receives dividends from their investments.
                        <br>Anyone who wants to have a VISA/ Master Card with international exposure.
                        <br>Anyone who owns a business, and is looking for an account to diversify some of their funds.
                        <?php } ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php if ($culture == "cn") { ?>
                        4. Make purchases and withdrawals with a connected Visa/Master Card
                        <?php } else if ($culture == "kr") { ?>
                        4. 연동된 Visa, Master카드로 물품 결제 및 현지통화 인출
                        <?php } else if ($culture == "jp") { ?>
                        4. 紐付けられているVISA/MasterCardでローカル通貨引き出しやショッピングが可能。
                        <?php } else { ?>
                        4. Make purchases and withdrawals with a connected Visa/Master Card
                        <?php } ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <span>
                        <?php if ($culture == "cn") { ?>
                        An i-Account delivers a new generation of international money platforms. It provides individuals and corporate customers with customized, value added services like instant funds loading from a user’s i-Account account to a connected Visa/ Master Card, which are issued upon user’s request. With the card in hand, cardholders can withdraw local currency from ATMs globally, and use it for online and in-store shopping wherever Visa/Master card is accepted.
<br><br>This VISA/Master Card can be issued to anyone; including those who do not qualify for a credit card.
                        <?php } else if ($culture == "kr") { ?>
                        i-Account는 차세대 머니 플랫폼으로써 국제통화 플랫폼을 제공합니다.
                        개인및 기업 고객님들을 위해Visa/Master의 충전식 프리페이드(선불)카드를 발행하고 있으며, 해당 카드를 이용하여 전 세계Visa/MasterCard 로고 표시가 되어 있는 ATM기기에서 현지통화를 인출하실수 있고, Visa/MasterCard가맹점 또는 온라인 마켓에서도 사용할 수 있습니다.

                        <br><br>신용카드를 발급하지 못하시는 분들을 포함하여 어느 누구나Visa、Master카드 신청이 가능합니다.
                        <?php } else if ($culture == "jp") { ?>
                        i-Accountでは次世代マネープラットフォームとして国際通貨プラットフォームを提供しております。個人及び企業お客様に対しVISAやMasterCardのリチャージ式プリペイドカードを発行しており、i-Accountと紐付けカードをご利用することで、VISAやMasterCard加盟店で決済したり世界中のATMにて現地通貨で引き出せます。

                        <br><br>クレジットカードを持てない方でも、VISAやMasterCardロゴのついたカードを発行することができます。
                        <?php } else { ?>
                        An i-Account delivers a new generation of international money platforms. It provides individuals and corporate customers with customized, value added services like instant funds loading from a user’s i-Account account to a connected Visa/ Master Card, which are issued upon user’s request. With the card in hand, cardholders can withdraw local currency from ATMs globally, and use it for online and in-store shopping wherever Visa/Master card is accepted.
<br><br>This VISA/Master Card can be issued to anyone; including those who do not qualify for a credit card.
                        <?php } ?>

</span>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php if ($culture == "cn") { ?>
                        5. Multi-functional corporate accounts
                        <?php } else if ($culture == "kr") { ?>
                        5. 다양한 기능의 법인계좌
                        <?php } else if ($culture == "jp") { ?>
                        5. 多機能な法人口座
                        <?php } else { ?>
                        5. Multi-functional corporate accounts
                        <?php } ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <span>
                        <?php if ($culture == "cn") { ?>
                        A corporate i-Account features a preset, one-off transfer to multiple accounts, or bulk transfers on designated dates you choose. This is ideal for affiliate, and commission payouts. The auto-direct debit is also recommended for businesses with recurring payments collection.
<br><br><strong>Knowing that you have quick and easy access to your money is key to feeling secure. Make personal international financial transactions, while at the same time protecting your financial privacy!</strong>
                        <?php } else if ($culture == "kr") { ?>
                        i-Account의 법인계좌는 지정하신 날짜에 다수 계좌로의 일괄 송금이 가능합니다. 이러한 자동이체 서비스는 파트너 회사와의 보수 지급 문제를 해결하기에 가장 좋은 방법이며, 일정주기마다 수당을 지급하는 회사에도 적절한 서비스입니다.
<br><br><strong>i-Account를 이용하시면 개인 금융정보를 철저히 지키면서, 국제송금 등을 보다 손쉽게 하실수 있습니다.</strong>
                        <?php } else if ($culture == "jp") { ?>
                        i-Accountの企業口座（法人口座）では、通常の送金機能のほか、一括送金や日付指定の一括送金機能があります。これはアフィリエイトへの支払いやコミッションの支払いに大変便利です。自動引落機能は、メンバーシップ会員様よりの会員費用の徴収や繰り返し支払に適切なサービスとなります。
                        <br><br><strong>金融プライバシーを保ち、送受金のできる便利なプラットフォームをご利用ください！</strong>
                        <?php } else { ?>
                        A corporate i-Account features a preset, one-off transfer to multiple accounts, or bulk transfers on designated dates you choose. This is ideal for affiliate, and commission payouts. The auto-direct debit is also recommended for businesses with recurring payments collection.
<br><br><strong>Knowing that you have quick and easy access to your money is key to feeling secure. Make personal international financial transactions, while at the same time protecting your financial privacy!</strong>
                        <?php } ?>
</span>
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <strong><?php if ($culture == "cn") { ?>
                        For more information, please click the following links:
                        <?php } else if ($culture == "kr") { ?>
                        보다 다양한 정보를 확인하고 싶으신가요? 아래의 링크를 클릭하여 주십시오:
                        <?php } else if ($culture == "jp") { ?>
                        さらなる情報が知りたいですか？　以下のリンクをクリックしてください:
                        <?php } else { ?>
                        For more information, please click the following links:
                        <?php } ?></strong>
                    <br>
                    <br>
                    <a href="http://www.liri-bd.com/apply/apply-personal.php?a_aid=53cf8e44ce6ed&amp;a_bid=7f6fb8e1" target="_blank"><?php if ($culture == "cn") { ?>
                        Please click to apply for an i-Account
                        <?php } else if ($culture == "kr") { ?>
                        i-Account와 카드를 동시에 신청하실 경우 이곳을 클릭하여 주십시오.
                        <?php } else if ($culture == "jp") { ?>
                        i-Accountとカードを同時に申し込む際はこちら
                        <?php } else { ?>
                        Please click to apply for an i-Account
                        <?php } ?></a>
                </td>
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