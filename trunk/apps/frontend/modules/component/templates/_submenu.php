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

<div class="menu" style="z-index: 20;">
    <ul>
        <li class="menu_title"><?php echo __('MAIN MENU'); ?></li>
        <li>
            <a href="/member/summary"><span><?php echo __('Summary'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/viewProfile"><span><?php echo __('User Profile'); ?></span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
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
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209" style="font-weight: bold;">
            <a href="/member/packageUpgrade"><span><?php echo __('Package Upgrade'); ?></span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/reloadTopup"><span><?php echo __('Reload MT4 Fund'); ?></span></a>
        </li>
    <?php } ?>
    <?php if ($rp > 0) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/transferRP"><span><?php echo __('RP Transfer'); ?></span></a>
        </li>
    <?php } ?>

    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('ACCOUNT INFORMATION'); ?></li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/bonusDetails"><span><?php echo __('Commission'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/pipsRebate"><span><?php echo __('Pips Rebate'); ?></span></a>
        </li>
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
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/applyDebitCard") ?>"><span><?php echo __('Apply Maxim Trader VISA Debit Card'); ?></span></a>
        </li>
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

        </li>
    </ul>
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

    <ul>
        <li class="menu_title"><?php echo __('MAX STORE'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore"><span><?php echo __('MAX Store Merchandising'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/maxStore/history"><span><?php echo __('MAX Store Merchandising History'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <?php } ?>
    <!--<ul>
        <li class="menu_title"><?php /*echo __('EXCHANGE RATE'); */?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/exchange"><span><?php /*echo __('Exchange Rate'); */?></span></a>
        </li>
    </ul>
    <br class="clear"><br>-->
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
    <!--<br class="clear"><br>
    <ul>
        <li class="menu_title"><?php /*echo __('ANNOUNCEMENT'); */?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/announcementList"><span><?php /*echo __('Announcement List'); */?></span></a>
        </li>
    </ul>-->
    <br class="clear"><br>

    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
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

    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
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
</div>