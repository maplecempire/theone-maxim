<table>
    <tr>
        <td></td>
        <td>Member Id</td>
        <td>Full Name</td>
        <td>Personal Amount</td>
        <td>Group Amount</td>
        <td>Email</td>
        <td>Contact Number</td>
        <td>Country</td>
        <td>Leader</td>
    </tr>

    <?php
    $idx = 1;
    foreach ($resultArray as $arr) { ?>
    <tr>
        <td><?php echo $idx++; ?></td>
        <td><?php echo $arr['distributor_code'] ?></td>
        <td><?php echo $arr['full_name'] ?></td>
        <td><?php echo number_format($arr['personal_sales'],2) ?></td>
        <td><?php echo number_format($arr['group_sales'],2) ?></td>
        <td><?php echo $arr['email'] ?></td>
        <td><?php echo $arr['contact'] ?></td>
        <td><?php echo $arr['country'] ?></td>
        <td><?php echo $arr['LEADER'] ?></td>
    </tr>
    <?php } ?>
</table>