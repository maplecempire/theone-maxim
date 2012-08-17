<div id="header">
    <div class="left middle" id="logo-title" style="padding: 5px">
        <div style="float: left; width: 30%">
            <a id="logo" rel="home" title="Vital Universe Group" href="/">
                <!-- <img alt="Vital Universe Group" src="/images/logo.png">-->
            </a>
        </div>
        <div style="float: right; width: 80%">
            <table cellpadding="1" cellspacing="2" border="0" width="500px">
                <tr>
                    <td width="20%"><?php echo __('Member Id') ?>:</td>
                    <td width="20%"><strong><?php echo $sf_user->getAttribute(Globals::SESSION_USERNAME); ?></strong></td>
                    <td width="10%">&nbsp;</td>
                    <td width="20%"><?php echo __('MT4 Credit Wallet') ?>:</td>
                    <td width="30%"><strong><?php echo number_format($ecash,2) ?></strong></td>
                </tr>
                <tr>
                    <td><?php echo __('Name') ?>:</td>
                    <td><strong><?php echo $componentDistributor->getFullName(); ?></strong></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo __('Package Rank') ?>:</td>
                    <td><strong><?php echo __($componentDistributor->getRankCode()); ?></strong></td>
                    <td>&nbsp;</td>
                    <td><?php echo __('Last Login') ?>:</td>
                    <td><strong><?php echo $lastLogin ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>