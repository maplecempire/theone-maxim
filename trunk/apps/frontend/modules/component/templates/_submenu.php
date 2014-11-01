<style type="text/css">
<?php if ($sf_user->getCulture() == "cn" || $sf_user->getCulture() == "jp") { ?>
html, body, form, a, acronym, code, div, hr, img, label, p, pre, span, strong, table, tr, th, td, button, input, textarea {
    font-family : "Microsoft YaHei" !important;
}
<?php } ?>
.menu_title {
    font-weight: bold;
    font-family: arial;
    font-size: 12px;
}
</style>
<script type="text/javascript" >

$(function() {
    blink('#msg');
});

function blink(selector) {
    $(selector).fadeOut('slow', function() {
        $(this).fadeIn('slow', function() {
            blink(this);
        });
    });
}
</script>

<?php
$onlyTransferRP = false;

if ($distDB->getDistributorId() == 296707 || $distDB->getDistributorId() == 296708 || $distDB->getDistributorId() == 296709) {
    $onlyTransferRP = true;
}
?>

<div class="menu" style="z-index: 20;">
    <ul>
        <li class="menu_title"><?php echo __('MAIN MENU'); ?></li>
        <?php if ($onlyTransferRP == false) { ?>
            <li>
                <a href="/member/summary"><span><?php echo __('Summary'); ?></span></a>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
                <a href="/member/viewProfile"><span><?php echo __('User Profile'); ?></span></a>
            </li>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorId() != 263640 && $distDB->getNormalInvestor() == "N") { ?>
            <li>
                <a href="/member/memberRegistration"><span><?php echo __('Registration'); ?></span></a>
            </li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_PENDING) { ?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
                <a href="<?php echo url_for("/member/packagePurchase")?>" id="linkPackagePurchase"><span><?php echo __('Package Purchase'); ?></span></a>
            </li>
        <?php } ?>

            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
                <a href="<?php echo url_for("/member/transferEpoint")?>"><span><?php echo __('Funds Deposit'); ?></span></a>
            </li>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorId() != 263640 && $distDB->getNormalInvestor() == "N") { ?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209" style="font-weight: bold;">
                <a href="/member/packageUpgrade"><span><?php echo __('Package Upgrade'); ?></span></a>
            </li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorId() != 263640) { ?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
                <a href="/member/reloadTopup"><span><?php echo __('Reload MT4 Fund'); ?></span></a>
            </li>
        <?php } ?>
    <?php } ?>
    <?php if ($rp > 0) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/transferRP"><span><?php echo __('RP Transfer'); ?></span></a>
        </li>
    <?php } ?>
    <?php if ($onlyTransferRP == false) { ?>
    <?php
        // maximcapital
        if ($sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 60 || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 1797) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/fmc"><span><?php echo __('FMC'); ?></span></a><img src="/images/new_icon.gif">
        </li>
    <?php } ?>
    <?php } ?>
    </ul>

    <?php
    $rookieChallenge = false;

    if ($distDB->getActiveDatetime() != null) {
        $exp_date = "2014-03-01";
        $todays_date = $distDB->getActiveDatetime();
        $today = strtotime($todays_date);
        $expiration_date = strtotime($exp_date);
        if ($expiration_date > $today) {

        } else {
            $rookieChallenge = true;
        }
    }

    if ($onlyTransferRP == false) {
    if ($rookieChallenge == true) {
    ?>
    <!--<br class="clear"><br>
    <ul>
        <li class="menu_title"><?php /*echo __('Rookie Challenge'); */?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/rookieChallenge"><span><?php /*echo __('Rookie Challenge'); */?><img src="/images/new_icon.gif"></a>
        </li>
    </ul>-->
    <?php } ?>

    <?php if ($distDB->getDistributorId() != 263640) { ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('ACCOUNT INFORMATION'); ?></li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <?php if ($distDB->getHideGenealogy() == "N") { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/bonusDetails"><span><?php echo __('Commission'); ?></span></a>
        </li>
        <?php } ?>
        <?php if ($distDB->getNormalInvestor() == "N") { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/pipsRebate"><span><?php echo __('Pips Rebate'); ?></span></a>
        </li>
        <?php } ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/epointLog") ?>"><span><?php echo __('Monetary Wallet'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/mt4Withdrawal"><span><?php echo __('Withdrawal'); ?></span></a>
        </li>
    <?php } ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/bankInformation") ?>"><span><?php echo __('Maxim Capital Bank Details'); ?></span></a>
        </li>

    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php /*echo url_for("/member/applyDebitCard") */?>"><span><?php /*echo __('Apply Maxim Trader VISA Debit Card'); */?></span></a>
        </li>-->
    <?php } ?>

    <?php if (Globals::APPLY_IME_VISIBLE == true) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/imeRegistration") ?>"><span><?php echo __('IME Registration'); ?></span></a>
        </li>
    <?php } ?>

    <?php if (Globals::APPLY_EZYCASHCARD_VISIBLE == true) { ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/applyEzyCashCard") ?>"><span><?php echo __('Apply EzyCash Card'); ?></span></a>
        </li>
        <?php } ?>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="https://www.ezybonds.com/members/join.asp?affiliateid=36496" target="_blank">
                <span><?php echo __('EzyAccount Registration'); ?></span>
            </a>
        </li>
    <?php } ?>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/moneyTrac/createAccount") ?>"><span><?php echo __('Apply MoneyTrac'); ?><img src="/images/new_icon.gif"></span></a>
        </li>

        <?php
        // gj1092, ko4390, korean001, Nextbill1, Openman   - leader group
        // alexsim
        /*if ($distDB->getDistributorId() == 142
            || $distDB->getDistributorId() == 454
            || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 255607
            || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 257700
            || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 255709
            || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 264845
            || $sf_user->getAttribute(Globals::SESSION_LEADER_ID, 0) == 273056) { */
            ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/iAccount/index") ?>"><span><?php echo __('Apply i-Account'); ?><img src="/images/new_icon.gif"></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/iAccount/internationalTransfer") ?>"><span><?php echo __('i-Account International Transfer'); ?><img src="/images/new_icon.gif"></span></a>
        </li>
        <?php //} ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">

        </li>
    </ul>
    <?php } ?>
    <!--<br class="clear"><br>
    <ul>
        <li class="menu_title"><?php /*echo __('EDUCATION / TRAINING COURSES'); */?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/underMaintenance"><span><?php /*echo __('Education Course'); */?></span></a>
        </li>
    </ul>-->
    <!--<br class="clear"><br>
    <ul>
        <li class="menu_title">PROFILE</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/viewProfile"><span><?php /*echo __('Personal Information'); */?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/viewBankInformation"><span><?php /*echo __('Bank Account Information'); */?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/loginPassword"><span><?php /*echo __('Change Password'); */?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/transactionPassword"><span><?php /*echo __('Change Security Password'); */?></span></a>
        </li>
    </ul>-->
    <br class="clear"><br>
    <?php
    if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getPlacementTreeStructure() != null && $distDB->getHideGenealogy() == "N") { ?>
    <ul>
        <li class="menu_title"><?php echo __('HIERARCHY'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/sponsorTree"><span><?php echo __('Genealogy'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>

    <?php } ?>

    <?php
    if ($distDB->getDistributorId() == 1) { ?>
    <ul>
        <li class="menu_title"><?php echo __('EXCHANGE RATE'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/exchange"><span><?php echo __('Exchange Rate'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <?php } ?>

    <ul>
        <li class="menu_title"><?php echo __('CONTACT'); ?></li>
        <?php
            $style = "";
            if ($totalUnreadCsMessage > 0) {
                $style = "style='color: green'";
            }
        ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/customerEnquiry" <?php echo $style;?>>
            <?php
            if ($totalUnreadCsMessage > 0) { ?>
                <div id="msg"> <strong><?php
                    echo __('CS Center')." (".$totalUnreadCsMessage.")"; ?></strong> </div>
            <?php
            } else {
                echo __('CS Center');
            }
            ?></a>
        </li>
    </ul>
    <br class="clear"><br>
    <!--<br class="clear"><br>
    <ul>
        <li class="menu_title"><?php /*echo __('ANNOUNCEMENT'); */?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/announcementList"><span><?php /*echo __('Announcement List'); */?></span></a>
        </li>
    </ul>-->
    <!--<br class="clear"><br>-->

    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorId() != 263640 && $distDB->getNormalInvestor() == "N") { ?>
    <ul>
        <li class="menu_title"><?php echo __('FUND MANAGEMENT'); ?></li>


        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/fundManagementReport") ?>"><span><?php echo __('Fund Management Report'); ?>
            <?php if ($distDB->getNewReportFlag() == Globals::YES_Y) { ?>
                <img src="/images/new_icon.gif">
            <?php } ?>
            </span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/fundManagementContract") ?>"><span><?php echo __('Fund Management Contract'); ?></span></a>
        </li>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <span style="color: #808080;"><?php /*echo __('MaximTrade Executor™ Report'); */?></span>
        </li>-->
    </ul>
    <!--<a href="<?php /*echo url_for("/member/maximExecutorReport") */?>"><span><?php /*echo __('MaximTrade Executor™ Report'); */?></span></a>-->
    <br class="clear"><br>
    <?php } ?>

    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorId() != 263640) { ?>
    <ul>
        <li class="menu_title"><?php echo __('DOWNLOAD'); ?></li>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/download/downloadMt4Pro?q=" . rand()) ?>"><span><?php echo __('Download MT4 Platform'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/dailyFxGuide") ?>"><span><?php echo __('Download Daily FX Guide'); ?></span></a>
        </li>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php /*echo url_for("/member/dailyAUGoldTradeGuide") */?>"><span><?php /*echo __('Download Daily XAU Gold Trade Guide (Coming Soon)'); */?></span></a>
        </li>-->

    <?php /*if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { */?><!--
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php /*echo url_for("/download/downloadVideo") */?>"><span><?php /*echo __('Download Video'); */?></span></a>
        </li>
    --><?php /*}*/ ?>
    </ul>
    <?php } ?>

    <?php $hideMaxStore = true;
    if ($hideMaxStore == false) {
    ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('MAX STORE'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore"><span><?php echo __('MAX Store'); ?></span></a>
        </li>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore/history"><span><?php /*echo __('Transaction History'); */?></span></a>
        </li>-->
    </ul>
    <?php
    }
    ?>
    <?php $hideQ3 = true;
    if ($hideQ3 == false) {
    ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('Q3 Champions Challenge'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/q3ChampionsChallenge"><span><?php echo __('Q3 Champions Challenge'); ?></span></a>
        </li>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore/history"><span><?php /*echo __('Transaction History'); */?></span></a>
        </li>-->
    </ul>
    <?php
    }
    ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('Bentley Flying Spur Champions Challenge'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/bentleyChallenge"><span><?php echo __('Bentley Flying Spur Champions Challenge'); ?><img src="/images/new_icon.gif"></a>
        </li>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore/history"><span><?php /*echo __('Transaction History'); */?></span></a>
        </li>-->
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('BMW X6 Champions Challenge'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/bmwX6Challenge"><span><?php echo __('2nd BMW X6 Champions Challenge'); ?><img src="/images/new_icon.gif"></a>
        </li>
        <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore/history"><span><?php /*echo __('Transaction History'); */?></span></a>
        </li>-->
    </ul>
    <?php
    //if ($distDB->getDistributorId() == 1 || $distDB->getDistributorId() == 2) {
    ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('Legal Watch'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/legalWatch"><span><?php echo __('Ask and be answered'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/uploads/Maxim-Code-of-Ethic.pdf" target="_blank"><span><?php echo __('Maxim Code of Ethic'); ?> (9.5MB)</span><img src="/images/new_icon.gif"></a>
        </li>
    </ul>
    <?php
    //}
    ?>

    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('Maxim Trader Newsletter'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/download/newsletter2013"><span><?php echo __('Download Newsletter Nov/Dec 2013'); ?> (69MB)</span></a>
        </li>
    </ul>
    <?php
    if ($distDB->getDistributorId() == 1 || $distDB->getDistributorId() == 2) {
    ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('Maxim Trader e-Book'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/ebook/read.htm" target="_blank"><span><?php echo __('Online Reading'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/ebook/pdf/myPDF.pdf" target="_blank"><span><?php echo __('Download e-Book'); ?> (75MB)</span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/IME-ebook/read.htm" target="_blank"><span><?php echo __('International Members Exchange'); ?></span></a>
        </li>
    </ul>
    <?php
    }
    ?>
    <?php
    if ($distDB->getDistributorId() == 1 || $distDB->getDistributorId() == 203 || $distDB->getDistributorId() == 1458 ||
            $distDB->getDistributorId() == 15) {
    ?>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('Member List'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/downlineList"><span><?php echo __('Member List'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/downlineCp2WithdrawalList"><span><?php echo __('CP2 Withdrawal List'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/downlineCp3WithdrawalList"><span><?php echo __('CP3 Withdrawal List'); ?></span></a>
        </li>
    </ul>
    <?php
    }
    ?>
    <?php
    }
    ?>
    <br class="clear"><br>
</div>