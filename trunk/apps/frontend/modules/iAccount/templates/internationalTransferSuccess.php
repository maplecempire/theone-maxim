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
                    <li>Once you have completed your i-Account registration and received your i-Account number, please go to
                    your Maxim Trader “member area” and update the exact information of your i-Account into your “user
                    profile”. Once this is done, you may use your i-Account as an option for your monthly withdrawal.</li>
                    <li>After you have remitted funds to Maxim Corporate i-Account, please scan and email the TT receipt to
                    finance@maximtrader.com.</li>
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
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>

            <tr>
                <td class="tbl_sprt_bottom"><span class="txt_title">[Important Notice]</span></td>
            </tr>
            <tr>
                <td class="">
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
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
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