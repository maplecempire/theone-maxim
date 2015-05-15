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
    <td class="tbl_sprt_bottom" align="center">
        <span class="txt_title"><?php echo __('APPLICATION FOR DISPENSATION 18 month investment term') ?></span>
        <br>
        <i>(Only applicable from 12 May 2015 to 31 May 2015)</i>
    </td>
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
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title"><?php echo __('1. Share swap option offered to Maxim members ') ?></span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title"><?php echo __('1. Share swap option offered to Maxim members ') ?></span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title"><?php echo __('1. Share swap option offered to Maxim members ') ?></span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title"><?php echo __('1. Share swap option offered to Maxim members ') ?></span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        As a result of popular requests from members, we will be offering the following options to Maxim members who have completed a minimum of 12 months under the Maxim Investment Package. This offers is also open to members who are going to reach 18 months maturity soon:
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        As a result of popular requests from members, we will be offering the following options to Maxim members who have completed a minimum of 12 months under the Maxim Investment Package. This offers is also open to members who are going to reach 18 months maturity soon:
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        As a result of popular requests from members, we will be offering the following options to Maxim members who have completed a minimum of 12 months under the Maxim Investment Package. This offers is also open to members who are going to reach 18 months maturity soon:
                    <?php
                    } else {
                    ?>
                        As a result of popular requests from members, we will be offering the following options to Maxim members who have completed a minimum of 12 months under the Maxim Investment Package. This offers is also open to members who are going to reach 18 months maturity soon:
                    <?php
                    }
                    ?>
                    <ol style="padding-left: 20px;">
                        <?php if ($culture == "cn") { ?>
                        <li>You may convert your investment capital plus the remaining unearned Performance Returns (CP3) till the maturity date, into ROGP shares (R-Shares) at promotional price of USD80 cents. Please note this offer is open only during the period from 12 to 31 May 2015.</li>
                        <li>Once you opt to swap your Maxim investment to R-Shares, you may continue to promote Maxim business and you will still be entitled to earn the bonuses in the usual manner as offered by our referral programs in Maxim ie. Direct Referral Bonus and Development Bonus. You will enjoy this benefit for a further 18 months from your original date of maturity. </li>
                        <li>Upon conversion to R-Share, your up-line will be able to enjoy a one time development bonus in Maxim.</li>
                        <li>If you do not already have your AGL account, when you opt for share swap, your R-shares will be automatically credited into an AGL S4 wallet and you may access them with your existing Maxim user ID and password. However if you wish to do AGL business, you will have to open your own AGL account.</li>
                        <?php } else if ($culture == "kr") { ?>
                        <li>You may convert your investment capital plus the remaining unearned Performance Returns (CP3) till the maturity date, into ROGP shares (R-Shares) at promotional price of USD80 cents. Please note this offer is open only during the period from 12 to 31 May 2015.</li>
                        <li>Once you opt to swap your Maxim investment to R-Shares, you may continue to promote Maxim business and you will still be entitled to earn the bonuses in the usual manner as offered by our referral programs in Maxim ie. Direct Referral Bonus and Development Bonus. You will enjoy this benefit for a further 18 months from your original date of maturity. </li>
                        <li>Upon conversion to R-Share, your up-line will be able to enjoy a one time development bonus in Maxim.</li>
                        <li>If you do not already have your AGL account, when you opt for share swap, your R-shares will be automatically credited into an AGL S4 wallet and you may access them with your existing Maxim user ID and password. However if you wish to do AGL business, you will have to open your own AGL account.</li>
                        <?php } else if ($culture == "jp") { ?>
                        <li>You may convert your investment capital plus the remaining unearned Performance Returns (CP3) till the maturity date, into ROGP shares (R-Shares) at promotional price of USD80 cents. Please note this offer is open only during the period from 12 to 31 May 2015.</li>
                        <li>Once you opt to swap your Maxim investment to R-Shares, you may continue to promote Maxim business and you will still be entitled to earn the bonuses in the usual manner as offered by our referral programs in Maxim ie. Direct Referral Bonus and Development Bonus. You will enjoy this benefit for a further 18 months from your original date of maturity. </li>
                        <li>Upon conversion to R-Share, your up-line will be able to enjoy a one time development bonus in Maxim.</li>
                        <li>If you do not already have your AGL account, when you opt for share swap, your R-shares will be automatically credited into an AGL S4 wallet and you may access them with your existing Maxim user ID and password. However if you wish to do AGL business, you will have to open your own AGL account.</li>
                        <?php } else { ?>
                        <li>You may convert your investment capital plus the remaining unearned Performance Returns (CP3) till the maturity date, into ROGP shares (R-Shares) at promotional price of USD80 cents. Please note this offer is open only during the period from 12 to 31 May 2015.</li>
                        <li>Once you opt to swap your Maxim investment to R-Shares, you may continue to promote Maxim business and you will still be entitled to earn the bonuses in the usual manner as offered by our referral programs in Maxim ie. Direct Referral Bonus and Development Bonus. You will enjoy this benefit for a further 18 months from your original date of maturity. </li>
                        <li>Upon conversion to R-Share, your up-line will be able to enjoy a one time development bonus in Maxim.</li>
                        <li>If you do not already have your AGL account, when you opt for share swap, your R-shares will be automatically credited into an AGL S4 wallet and you may access them with your existing Maxim user ID and password. However if you wish to do AGL business, you will have to open your own AGL account.</li>
                        <?php } ?>

                    </ol>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">2. Members who have just renewed their contract</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">2. Members who have just renewed their contract</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">2. Members who have just renewed their contract</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">2. Members who have just renewed their contract</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        Members who have just renewed their contract for another 18 months will have to wait for a minimum of 12 months before they can qualify for share swap option.
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        Members who have just renewed their contract for another 18 months will have to wait for a minimum of 12 months before they can qualify for share swap option.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        Members who have just renewed their contract for another 18 months will have to wait for a minimum of 12 months before they can qualify for share swap option.
                    <?php
                    } else {
                    ?>
                        Members who have just renewed their contract for another 18 months will have to wait for a minimum of 12 months before they can qualify for share swap option.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">3. Other options upon reaching maturity</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">3. Other options upon reaching maturity</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">3. Other options upon reaching maturity</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">3. Other options upon reaching maturity</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        If you do not want to select the above promotional offer R-Share swap, once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. We therefore recommend that you go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns.
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        If you do not want to select the above promotional offer R-Share swap, once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. We therefore recommend that you go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        If you do not want to select the above promotional offer R-Share swap, once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. We therefore recommend that you go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns.
                    <?php
                    } else {
                    ?>
                        If you do not want to select the above promotional offer R-Share swap, once your account reaches maturity, you will not be entitled to earn from our referral and investment programs. We therefore recommend that you go into the website and select the ‘renew’ option. Once you renew, you will be entitled to earn the bonuses offered by our referral programs and earn monthly performance returns.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">4. Shortfall in the MT4 account</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">4. Shortfall in the MT4 account</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">4. Shortfall in the MT4 account</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">4. Shortfall in the MT4 account</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        If you decide to renew your existing Maxim package and if your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        If you decide to renew your existing Maxim package and if your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        If you decide to renew your existing Maxim package and if your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
                    <?php
                    } else {
                    ?>
                        If you decide to renew your existing Maxim package and if your balance in the MT4 has fallen below your initial capital investment amount, we invite you to top-up to its original sum so that you can continue to be entitled to bonuses offered by our referral programs and enjoy monthly performance returns. If you do not top-up by the maturity date, your account will be put on hold until you fully top-up to its original sum. Once topped up, you will be entitled to our referral program and earn monthly performance returns from the date of top up.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">5. Non-renewal of contract</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">5. Non-renewal of contract</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">5. Non-renewal of contract</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">5. Non-renewal of contract</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        For any reason, if you wish not to renew your contract, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        For any reason, if you wish not to renew your contract, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        For any reason, if you wish not to renew your contract, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
                    <?php
                    } else {
                    ?>
                        For any reason, if you wish not to renew your contract, please go to the website and select the ‘non-renewal’ option. You are also required to complete the ‘non-renewal of contract’ form and email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> Your FINAL MT4 BALANCE (Initial Capital Investment which is represented by the balance in the MT4 account as of the maturity date) will then be credited into your CP3 account within 14 days after maturity date. You may then withdraw your CP2 and CP3 balances in the usual manner at the next withdrawal cycle. Once the payment is made, your account will be closed.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">6. Six months exclusion</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">6. Six months exclusion</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">6. Six months exclusion</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">6. Six months exclusion</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        Please note if you decide not to renew your contract, you are not allowed to re-join Maximtrader for a period of 6 months after the maturity date.
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        Please note if you decide not to renew your contract, you are not allowed to re-join Maximtrader for a period of 6 months after the maturity date.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        Please note if you decide not to renew your contract, you are not allowed to re-join Maximtrader for a period of 6 months after the maturity date.
                    <?php
                    } else {
                    ?>
                        Please note if you decide not to renew your contract, you are not allowed to re-join Maximtrader for a period of 6 months after the maturity date.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">7. Members with the same user ID</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">7. Members with the same user ID</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">7. Members with the same user ID</span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">7. Members with the same user ID</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        Please note that Maxim members who have more than one package under the same user ID will need to renew all the packages when they fall due in order to be entitled to bonuses offered by Maxim’s referral programs and enjoy monthly performance returns. If anyone one of the packages are not renewed, all the remaining packages under the same user ID will cease to earn any referral and development bonus.
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        Please note that Maxim members who have more than one package under the same user ID will need to renew all the packages when they fall due in order to be entitled to bonuses offered by Maxim’s referral programs and enjoy monthly performance returns. If anyone one of the packages are not renewed, all the remaining packages under the same user ID will cease to earn any referral and development bonus.
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        Please note that Maxim members who have more than one package under the same user ID will need to renew all the packages when they fall due in order to be entitled to bonuses offered by Maxim’s referral programs and enjoy monthly performance returns. If anyone one of the packages are not renewed, all the remaining packages under the same user ID will cease to earn any referral and development bonus.
                    <?php
                    } else {
                    ?>
                        Please note that Maxim members who have more than one package under the same user ID will need to renew all the packages when they fall due in order to be entitled to bonuses offered by Maxim’s referral programs and enjoy monthly performance returns. If anyone one of the packages are not renewed, all the remaining packages under the same user ID will cease to earn any referral and development bonus.
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="">Please email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> if you need further clarifications.</span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="">Please email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> if you need further clarifications.</span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="">Please email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> if you need further clarifications.</span>
                    <?php
                    } else {
                    ?>
                        <span class="">Please email to <a href="mailto:maturity@maximtrader.com" target="_blank" style="color: blue">maturity@maximtrader.com</a> if you need further clarifications.</span>
                    <?php
                    }
                     ?>
                </td>
            </tr>

            <tr>
                <td><br></td>
            </tr>


            <tr>
                <td>
                    <span style="font-weight: bold;">
                    Thank you,
<br>
<br>Dr. Andrew Lim
<br>Chief Executive Officer
<br>Maxim Capital Limited
                        </span>
</td>
            </tr>

            </tbody>
        </table>
    </td>
</tr>
<tr>
<td>
</td>
</tr>
</tbody>
</table>