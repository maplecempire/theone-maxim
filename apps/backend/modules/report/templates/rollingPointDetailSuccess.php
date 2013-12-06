<h3>Rolling Point Detail - <?php echo $dist->getDistributorCode();?></h3>
<table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
    <thead>
    <tr>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'></th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Action</th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Credit</th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Debit</th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Balance</th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Remark</th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Internal Remark</th>
        <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Date</th>
    </tr>
    </thead>
    <tbody>

    <?php
    $idx = 1;
    foreach ($reportDetails as $reportDetail) { ?>
        <tr class='sf_admin_row_1'>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $idx++;?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $reportDetail->getTransactionType();?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($reportDetail->getCredit(),2);?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($reportDetail->getDebit(),2);?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($reportDetail->getBalance(),2);?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $reportDetail->getRemark();?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $reportDetail->getInternalRemark();?></td>
            <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $reportDetail->getCreatedOn();?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>