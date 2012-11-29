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

<div class="menu" style="z-index: 20;">
    <ul>
        <li class="menu_title"><?php echo __('MAIN MENU'); ?></li>
        <li>
            <a href="/member/summary"><span><?php echo __('Summary'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/viewProfile"><span><?php echo __('User Profile'); ?></span></a>
        </li>
        <li>
            <a href="/member/memberRegistration"><span><?php echo __('Registration'); ?></span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_PENDING) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="#" id="linkPackagePurchase"><span><?php echo __('Package Purchase'); ?></span></a>
        </li>
    <?php } ?>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/epointPurchase")?>"><span><?php echo __('Funds Deposit'); ?></span></a>
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

    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('ACCOUNT INFORMATION'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/bonusDetails"><span><?php echo __('Commission'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/epointLog") ?>"><span><?php echo __('Monetary Wallet'); ?></span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/mt4Withdrawal"><span><?php echo __('Withdrawal'); ?></span></a>
        </li>
    <?php } ?>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">

        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('EDUCATION / TRAINING COURSES'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/underMaintenance"><span><?php echo __('Education Course'); ?></span></a>
        </li>
    </ul>
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
    <ul>
        <li class="menu_title"><?php echo __('HIERARCHY'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/sponsorTree"><span><?php echo __('Genealogy'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <!--<ul>
        <li class="menu_title"><?php /*echo __('EXCHANGE RATE'); */?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/exchange"><span><?php /*echo __('Exchange Rate'); */?></span></a>
        </li>
    </ul>
    <br class="clear"><br>-->
    <ul>
        <li class="menu_title"><?php echo __('CONTACT'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/customerEnquiry"><span><?php echo __('CS Center'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('ANNOUNCEMENT'); ?></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/announcementList"><span><?php echo __('Announcement List'); ?></span></a>
        </li>
    </ul>
    <!--<br class="clear"><br>
    <ul>
        <li class="menu_title"><?php /*echo __('REPORT'); */?></li>


        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php /*echo url_for("/member/fundManagementReport") */?>"><span><?php /*echo __('Fund Management Report'); */?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <span style="color: #808080;"><?php /*echo __('MaximTrade Executor™ Report'); */?></span>
        </li>
    </ul>-->
    <!--<a href="<?php /*echo url_for("/member/maximExecutorReport") */?>"><span><?php /*echo __('MaximTrade Executor™ Report'); */?></span></a>-->
    <br class="clear"><br>
    <ul>
        <li class="menu_title"><?php echo __('DOWNLOAD'); ?></li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/download/downloadMt4Pro?q=" . rand()) ?>"><span><?php echo __('Download MT4 Platform'); ?></span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/dailyFxGuide") ?>"><span><?php echo __('Download Daily FX Guide'); ?></span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/download/downloadVideo") ?>"><span><?php echo __('Download Video'); ?></span></a>
        </li>
    <?php } ?>
    </ul>
</div>