<h3>Referrer List</h3>
<table width='100%' style='border-color: #DDDDDD -moz-use-text-color -moz-use-text-color #DDDDDD;border-image: none; border-style: solid none none solid;border-width: 1px 0 0 1px;'>
<thead>
<tr>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'></th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Member ID</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Full Name</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Amount</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Created On</th>
    <th style='background-color: #CCCCFF; padding: 2px; text-align: left;'>Remark</th>
</tr>
<?php
$idx = 1;
foreach ($mlmDistributors as $mlmDistributor) { ?>
<tr class='sf_admin_row_1'>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $idx++;?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $mlmDistributor->getDistributorCode();?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $mlmDistributor->getFullName();?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php //echo $mlmDistributor->getRankId();
        $distPackage = MlmPackagePeer::retrieveByPK($mlmDistributor->getRankId());
        echo $distPackage->getPrice();?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $mlmDistributor->getCreatedOn();?></td>
    <td style='background-color: #EEEEFF; border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; padding: 3px;'><?php echo $mlmDistributor->getRemark();?></td>
</tr>
<?php } ?>
</thead>
<tbody>