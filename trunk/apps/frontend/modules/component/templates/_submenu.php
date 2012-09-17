<style type="text/css">
.menu_title {
    font-weight: bold;
    font-family: arial;
    font-size: 12px;
}
</style>

<div class="menu" style="z-index: 20;">
    <ul>
        <li class="menu_title">HOME</li>
        <li>
            <a href="/member/summary"><span><?php echo __('Summary'); ?></span></a>
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
            <a href="/member/epointPurchase"><span>Deposit Fund Purchase</span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/packageUpgrade"><span>Package Upgrade</span></a>
        </li>
    <?php } ?>

    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">ACCOUNT INFORMATION</li>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
                <a href="/member/reloadTopup"><span>Reload MT4 Fund</span></a>
            </li>
        <?php } ?>
        <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
                <a href="/member/mt4Withdrawal"><span>MT4 Withdrawal</span></a>
            </li>
        <?php } ?>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">PROFILE</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/viewProfile"><span><?php echo __('Personal Information'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/viewBankInformation"><span><?php echo __('Bank Account Information'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/loginPassword"><span><?php echo __('Change Password'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/transactionPassword"><span><?php echo __('Change Security Password'); ?></span></a>
        </li>
    </ul>
    <br class="clear"><br>
    <ul>
        <li class="menu_title">HIERARCHY</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/sponsorTree"><span><?php echo __('Sponsor Genealogy'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/placementTree"><span><?php echo __('Placement Genealogy'); ?></span></a>
        </li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/placementTree?p=stat"><span><?php echo __('Downline Stats'); ?></span></a>
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
        <li class="menu_title">STATEMENT</li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/bonusDetails"><span><?php echo __('Bonus Details'); ?></span></a>
        </li>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="/member/epointLog"><span><?php echo __('Deposit Account'); ?></span></a>
        </li>
    <?php } ?>
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
            <a href="<?php echo url_for("/member/downloadMt4?q=" . rand()) ?>"><span>Download MT4 Platform</span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/member/dailyFxGuide") ?>"><span>Download Daily FX Guide</span></a>
        </li>
    <?php } ?>
    <?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorCode() != "demo123") { ?>
        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
            <a href="<?php echo url_for("/download/downloadMt4Pro") ?>"><span><?php echo __('Download MT4 Pro'); ?></span></a>
        </li>
    <?php } ?>
    </ul>
</div>