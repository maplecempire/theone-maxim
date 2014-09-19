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
                <?php } else if ($culture == "kr") { ?>
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
                        <li>Once you have completed your i-Account registration and received your i-Account number, please go to
                    your Maxim Trader “member area” and update the exact information of your i-Account into your “user
                    profile”. Once this is done, you may use your i-Account as an option for your monthly withdrawal.</li>
                    <li>After you have remitted funds to Maxim Corporate i-Account, please scan and email the TT receipt to
                    finance@maximtrader.com.</li>
                <?php } else if ($culture == "kr") { ?>
                        <li>Once you have completed your i-Account registration and received your i-Account number, please go to
                    your Maxim Trader “member area” and update the exact information of your i-Account into your “user
                    profile”. Once this is done, you may use your i-Account as an option for your monthly withdrawal.</li>
                    <li>After you have remitted funds to Maxim Corporate i-Account, please scan and email the TT receipt to
                    finance@maximtrader.com.</li>
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
                <?php } else if ($culture == "kr") { ?>
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
                <?php } else if ($culture == "kr") { ?>
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