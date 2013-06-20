<table>
    <tr>
        <td>DistId</td>
        <td>Full Name</td>
        <td>Nick Name</td>
        <td>Bank Name</td>
        <td>Bank Holder Name</td>
        <td>Address</td>
        <td>Address 2</td>
        <td>City</td>
        <td>State</td>
    </tr>

    <?php foreach ($mlmDistributors as $mlmDistributor) { ?>
    <tr>
        <td><?php echo $mlmDistributor->getDistributorId() ?></td>
        <td><?php echo $mlmDistributor->getFullName() ?></td>
        <td><?php echo $mlmDistributor->getNickName() ?></td>
        <td><?php echo $mlmDistributor->getBankName() ?></td>
        <td><?php echo $mlmDistributor->getBankHolderName() ?></td>
        <td><?php echo $mlmDistributor->getAddress() ?></td>
        <td><?php echo $mlmDistributor->getAddress2() ?></td>
        <td><?php echo $mlmDistributor->getCity() ?></td>
        <td><?php echo $mlmDistributor->getState() ?></td>
    </tr>
    <?php } ?>
</table>