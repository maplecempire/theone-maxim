<?php include('scripts.php'); ?>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td><br></td>
</tr>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Apply MoneyTrac') ?></span></td>
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
                    <a href="https://www.moneytrac.net/client/register/SJZLFA" target="_blank"><img
                            src="/images/moneyTrac/MoneyTrac.png" style="width: 600px;"></a>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="https://www.moneytrac.net/client/register/SJZLFA" target="_blank">Click to Register Now</a>
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
                        class="txt_title"><?php echo __('Introduction') ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <span
                        style="font-weight: bold;"><?php echo __('WorldwidePays  provides an integrated suite of payment system products through its MoneyTrac Consolidated Payment Gateway (CPG):') ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <ol style="padding-left: 20px;">
                        <li><?php echo __('An eWallet account allowing user to receive funds on a global basis and access those funds through multiple options') ?></li>
                        <li><?php echo __('A U.S. prepaid debit card option') ?></li>
                        <li><?php echo __('International prepaid debit card options') ?></li>
                        <li><?php echo __('Domestic and international bank account and credit card options') ?></li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                    <span
                        style="font-weight: bold;"><?php echo __('Kindly refer the link below for more information:') ?></span>

                    <br>
                    <a href="http://globalpayout.com/MCPG_solution.html" target="_blank">www.globalpayout.com</a>

                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php echo __('Consolidated Payment Gateway (CPG)') ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <span><?php echo __('Multi-national companies with thousands of employees, distributors and their members located throughout the world, require an efficient and cost effective method for both making monetary payouts and receiving funds. Global Payout has introduced <font style="font-weight: bold; font-style: italic">“MoneyTrac”</font>, the most efficient, industry leading web based payment system. MoneyTrac is fully scalable and currently available in over 180 countries. With MoneyTrac, multi-national companies can now take advantage of unified access to the Consolidated Payment Gateway (CPG) currently processing over $40B of transactions per year.') ?></span>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                    <span><?php echo __('Unlike many competitors, MoneyTrac is instantaneous. Companies can upload funds in real-time to web-based accounts and provide individuals multiple options on receiving money.') ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <strong>Payouts:</strong>
                    <br>
                    <ol style="padding-left: 20px;">
                        <li><?php echo __('Payments to <strong>Credit Cards</strong> and <strong>Debit Cards</strong> – Global Payout along with Visa and MasterCard, have created the ability to transfer funds to virtually every card in the world. Individuals can get paid as long as they have one of these branded cards issued by any bank globally.') ?></li>
                        <li><?php echo __('Payments to a <strong>Prepaid Debit Card</strong> – for those individuals who don’t have a credit or debit card, or they want access to their funds in real-time, they can order a MoneyTrac Prepaid Discover Card in the U.S. or international residents can apply for a Prepaid MasterCard and offshore bank account.') ?></li>
                        <li><?php echo __('Payments to a <strong>Bank Account</strong> – funds can be transferred to a payee’s checking or savings account via electronic funds transfer throughout the world from their MoneyTrac account. Whether the payee is located within the European Union, Asia, India, the United States or other countries throughout the world, transfers can be made through the CPG on a timely basis and at the lowest cost.') ?></li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php echo __('What Is CPG eWallet') ?></span></td>
            </tr>
            <tr>
                <td class="">
                    <span><?php echo __('The concept of EFTS (Electronic Funds Transfer System) has been around for years, and every major bank has a hand-built system of such. However, the concept of having a general purpose EFTS for the general public, businesses and corporations to use without having to go through banks is brand new.') ?></span>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="">
                    <span><?php echo __('The CPG eWallet in the most simple comparison is like PayPal for business; a user can send or receive funds to and from bank accounts. However, a CPG eWallet account also provides the user a temporary funds depository and accesibility to user’s multiple bank accounts within country - Perhaps at different banks.') ?></span>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php echo __('CPG eWallet Transaction Types') ?></span></td>
            </tr>

            <tr>
                <td align="left">
                    <a href="https://www.moneytrac.net/client/register/SJZLFA" target="_blank"><img
                            src="/images/moneyTrac/Capture.PNG" style="width: 600px;"></a>
                    <br>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom"><span
                        class="txt_title"><?php echo __('Please used this links as below for your members to create an e-Wallet account:') ?></span></td>
            </tr>

            <tr>
                <td>
                    <a href="https://www.moneytrac.net/client/register/SJZLFA" target="_blank">Click to Register Now</a>
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