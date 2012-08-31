<style type="text/css">
.titleHead {
    color: #CCAD5A;
    display: block;
    font-size: 12px;
    font-weight: bold;
    font-family: arial;
    padding-top: 20px;
}
#menu .menu .menu-item {
    text-align: left !important;
    line-height: 25px !important;
}
#menu {
    float: left;
    margin: 0 auto;
    width: 100%;
    z-index: 30;
}
</style>
<div id="menu">
<ul id="menu-menu" class="menu" style="list-style: none outside none; margin: 0px; padding-left: 40px;">
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <span class="titleHead">HOME</span>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/summary"><span><?php echo __('Summary'); ?></span></a>
    </li>
<?php if ($distDB->getStatusCode() == Globals::STATUS_PENDING) { ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="#" id="linkPackagePurchase"><span>Package Purchase</span></a>
    </li>
<?php } ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/epointPurchase"><span>Forex Point Purchase</span></a>
    </li>
<?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/packageUpgrade"><span>Package Upgrade</span></a>
    </li>
<?php } ?>
<?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/epointLog"><span><?php echo __('Forex Point Log'); ?></span></a>
    </li>
<?php } ?>



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


    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <span class="titleHead">Profile</span>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/viewProfile"><span><?php echo __('Account Information'); ?></span></a>
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


    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <span class="titleHead">Hierarchy</span>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/sponsorTree"><span><?php echo __('Genealogy'); ?></span></a>
    </li>

    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <span class="titleHead">Bonus</span>
    </li>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="/member/bonusDetails"><span><?php echo __('Bonus Details'); ?></span></a>
    </li>

    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <span class="titleHead">Download</span>
    </li>
<?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="<?php echo url_for("/member/downloadMt4?q=" . rand()) ?>"><span>Download MT4 Platform</span></a>
    </li>
<?php } ?>
<?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE) { ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="<?php echo url_for("/download/downloadGuide?q=" . rand()) ?>"><span>Download Daily FX Guide</span></a>
    </li>
<?php } ?>
<?php if ($distDB->getStatusCode() == Globals::STATUS_ACTIVE && $distDB->getDistributorCode() != "demo123") { ?>
    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209">
        <a href="<?php echo url_for("/download/downloadMt4Pro") ?>"><span><?php echo __('Download MT4 Pro'); ?></span></a>
    </li>
<?php } ?>
</ul>

</div>