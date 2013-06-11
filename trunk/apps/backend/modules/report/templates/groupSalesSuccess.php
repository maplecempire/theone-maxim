<h3>Bonus Payout</h3>
<table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
<thead>
<tr>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'></th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Date</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Sales</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>DRB</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>GDB</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>GDB Payout Percentage</th>
</tr>
<?php
$idx = 1;
foreach ($reports as $report) { ?>
<tr class='sf_admin_row_1'>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $idx;?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $report->getBonusDate();?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($report->getTotalSales(),2);?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($report->getTotalDrb(),2);?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($report->getTotalGdb(),2);?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo number_format($report->getGdbPercentage(),2);?></td>
</tr>
<?php } ?>
</thead>
<tbody>