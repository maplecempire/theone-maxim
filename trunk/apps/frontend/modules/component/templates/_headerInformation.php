<div class="sectionPersonal">
    <table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr class="colWrap">
            <td class="col01"><?php echo __('User Name') ?></td>
            <td class="col02">:</td>
            <td class="col03"><?php echo $sf_user->getAttribute(Globals::SESSION_USERNAME); ?></td>
        </tr>
        <tr class="colWrap">
            <td class="col01"><?php echo __('MT4 ID') ?></td>
            <td class="col02">:</td>
            <td class="col03"><?php echo $mt4Id; ?></td>
        </tr>
        <tr class="colWrap">
            <td class="col01"><?php echo __('Ranking') ?></td>
            <td class="col02">:</td>
            <td class="col03"><?php echo $ranking; ?></td>
        </tr>
        <!--<tr class="colWrap">
            <td class="col01"><?php /*echo __('Total Networks') */?></td>
            <td class="col02">:</td>
            <td class="col03"><?php /*echo $totalNetworks; */?></td>
        </tr>-->
        <tr class="colWrap">
            <td class="col01"><?php echo __('Currency') ?></td>
            <td class="col02">:</td>
            <td class="col03"><?php echo $currencyCode; ?></td>
        </tr>
        <!--<tr class="colWrap">
            <td class="col01"><?php /*echo __('MT4 Credit Wallet') */?></td>
            <td class="col02">:</td>
            <td class="col03"><?php /*echo number_format($ecash,2); */?></td>
        </tr>-->
        <tr class="colWrap">
            <td class="col01"><?php echo __('Deposit Fund Wallet') ?></td>
            <td class="col02">:</td>
            <td class="col03"><?php echo number_format($epoint,2); ?></td>
        </tr>
    </table>
</div>