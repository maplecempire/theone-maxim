<ul id="menu-menu" class="menu" style="list-style: none outside none; margin: 0px; padding: 0px;">
    <?php if ($sf_user->getAttribute(Globals::SESSION_USERNAME)) { ?>
    <li id="menu-item-209"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-209"><a
            href="<?php echo url_for("/home")?>">Home</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29">
        <a href="<?php echo url_for("/home/company")?>">The Consortium</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-156"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php echo url_for("/home/investment")?>">Fund Management</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-157"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php echo url_for("/home/maximExecutor")?>">MaximTrade Executor™</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-158"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a
            href="<?php echo url_for("/home/marketNews")?>">Market News</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <!--<li id="menu-item-89" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-89">
        <a href="<?php /*echo url_for("/home/marketNews")*/?>">Market News</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>-->
    <li id="menu-item-98" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-98">
        <a href="<?php echo url_for("/home/contactUs")?>">Contact Us</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>

    <li id="menu-item-140"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140"><a
            href="<?php echo url_for("/member/summary")?>">Member Area</a>
        <div class="hr2" style="margin-bottom: 0px; margin-top: 0px; margin:auto; width:150px; float: none;"></div>
    </li>
    <li id="menu-item-141"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140"><a
            href="<?php echo url_for("/home/logout")?>">Logout</a>
    </li>
    <?php } else {?>
    <li id="menu-item-142"
        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140"><a
            href="<?php echo url_for("/home/login")?>">Member Login</a>
    </li>
    <?php }?>
</ul>