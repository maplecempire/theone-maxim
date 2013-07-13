<table>
    <tr>
        <td></td>
        <td>Member Id</td>
        <td>Full Name</td>
        <td>Type</td>
        <td>Small Group Amount</td>
        <td>Personal Sales</td>
        <td>Ticket Qty</td>
        <td>Contact Number</td>
        <td>Country</td>
        <td>Leader</td>
        <td>Created On</td>
    </tr>

    <?php
    $idx = 1;
    foreach ($imeReports as $imeReport) { ?>
    <tr>
        <td><?php echo $idx++; ?></td>
        <td><?php echo $imeReport->getDistributorCode(); ?></td>
        <td><?php echo $imeReport->getFullName() ?></td>
        <td><?php echo $imeReport->getBunusType() ?></td>
        <td><?php echo number_format($imeReport->getSmallLeg(),2) ?></td>
        <td><?php echo number_format($imeReport->getPersonalSales(),2) ?></td>
        <td><?php echo $imeReport->getTicketQty() ?></td>
        <td><?php echo $imeReport->getContact() ?></td>
        <td><?php echo $imeReport->getCountry() ?></td>
        <td><?php echo $imeReport->getLeader() ?></td>
        <td><?php echo $imeReport->getRegisteredOn() ?></td>
    </tr>
    <?php } ?>
</table>