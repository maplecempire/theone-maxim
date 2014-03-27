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
<?php
if ($sf_user->hasCredential(Globals::PROJECT_NAME . Globals::ROLE_DISTRIBUTOR)) { ?>
    <li id="menu-item-209"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209"><a
            href="<?php echo url_for("/home")?>"><?php echo __('Home') ?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <!--<li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29">
        <a href="<?php /*echo url_for("/home/company")*/?>"><?php /*echo __('The Consortium') */?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>-->
    <!--<li id="menu-item-156"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php /*echo url_for("/home/investment")*/?>"><?php /*echo __('Fund Management') */?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-157"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php /*echo url_for("/home/maximExecutor")*/?>"><?php /*echo __('MaximTrade™ Executor') */?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>-->
    <?php if ($showLink == "Y" && $distDB->getNormalInvestor() == "N") { ?>
    <li id="menu-item-158"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="#" id="linkLatestNews"><?php echo __('Latest News') ?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <?php } ?>
    <li id="menu-item-158"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php echo url_for("/home/marketNews")?>"><?php echo __('Market News') ?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-158"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php echo url_for("/home/activities")?>"><?php echo __('Events') ?> & <?php echo __('Activities') ?>
        <?php if ($distDB->getNewActivityFlag() == Globals::YES_Y) { ?>
        <img src="/images/new_icon.gif">
        <?php } ?>
        </a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-158"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php echo url_for("/home/announcementList")?>"><?php echo __('Announcement') ?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <!--<li id="menu-item-89" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-89">
        <a href="<?php /*echo url_for("/home/marketNews")*/?>">Market News</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>-->
    <!--<li id="menu-item-98" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-98">
        <a href="<?php /*echo url_for("/home/contactUs")*/?>"><?php /*echo __('Contact Us') */?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>-->

    <li id="menu-item-140"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140"><a
            href="<?php echo url_for("/member/summary")?>"><?php echo __('Member Area') ?></a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-141"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140"><a
            href="<?php echo url_for("/home/logout")?>"><?php echo __('Logout') ?></a>
    </li>
<?php } else {?>
    <li id="menu-item-142"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140"><a
            href="<?php echo url_for("/home/login")?>"><?php echo __('Member Login') ?></a>
    </li>
<?php }?>
</ul>
</div>