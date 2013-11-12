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

$totalSales = 0;
$totalDrb = 0;
$totalGdb = 0;
foreach ($reports as $report) {
    $totalSales += $report->getTotalSales();
    $totalDrb += $report->getTotalDrb();
    $totalGdb += $report->getTotalGdb();
    ?>
<tr class='sf_admin_row_1'>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;' align="right"><?php echo $idx++;?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;' align="right"><?php echo $report->getBonusDate();?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;' align="right"><?php echo number_format($report->getTotalSales(),2);?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;' align="right"><?php echo number_format($report->getTotalDrb(),2);?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;' align="right"><?php echo number_format($report->getTotalGdb(),2);?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;' align="right"><?php echo number_format($report->getGdbPercentage() * 100,2);?> %</td>
</tr>
<?php } ?>

<tr>
   <td></td>
   <td></td>
   <td align="right"><?php echo number_format($totalSales,2);?></td>
   <td align="right"><?php echo number_format($totalDrb,2);?></td>
   <td align="right"><?php echo number_format($totalGdb,2);?></td>
   <td align="right"><?php echo number_format($totalGdb / $totalSales * 100,2);?>%</td>
</tr>
</thead>
<tbody>