<style type="text/css">
.menu_title {
    font-weight: bold;
    font-family: arial;
    font-size: 12px;
}
</style>

<div class="menu" style="z-index: 20;">
    <ul>
        <li class="menu_title">MAIN MENU</li>
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
            <a href="#" id="linkPackagePurchase"><span>Package Purchase</span></a>
        </li>
    <?php } ?>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/epointPurchase")?>"><span>Funds Deposit</span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/packageUpgrade"><span>Package Upgrade</span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/reloadTopup"><span>Reload MT4 Fund</span></a>
        </li>
    <?php } ?>

    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">ACCOUNT INFORMATION</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/bonusDetails"><span><?php echo __('Commission'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/epointLog"><span><?php echo __('Monetary Wallet'); ?></span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/mt4Withdrawal"><span>Withdrawal</span></a>
        </li>
    <?php } ?>

        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">

        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">EDUCATION COURSES / EVENT</li>
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
        <li class="menu_title">HIERARCHY</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/sponsorTree"><span><?php echo __('Genealogy'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">EXCHANGE RATE</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/exchange"><span><?php echo __('Exchange Rate'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">CONTACT</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/underMaintenance"><span><?php echo __('CS Center'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">REPORT</li>


        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/fundManagementReport") ?>"><span>Fund Management Report</span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/maximExecutorReport") ?>"><span>MaximTrade Executor™ Report</span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">DOWNLOAD</li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/download/downloadMt4Pro?q=" . rand()) ?>"><span>Download MT4 Platform</span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/dailyFxGuide") ?>"><span>Download Daily FX Guide</span></a>
        </li>
    <?php } ?>
    </ul>
</div>