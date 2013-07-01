<table>
    <tr>
        <td></td>
        <td>Member Id</td>
        <td>Full Name</td>
        <td>Left Group Amount</td>
        <td>Right Group Amount</td>
        <td>Email</td>
        <td>Contact Number</td>
        <td>Country</td>
        <td>Leader</td>
        <td>Created On</td>
    </tr>

    <?php
    $idx = 1;
    foreach ($resultArray as $arr) { ?>
    <tr>
        <td><?php echo $idx++; ?></td>
        <td><?php echo $arr['distributor_code'] ?></td>
        <td><?php echo $arr['full_name'] ?></td>
        <td><?php echo number_format($arr['left_sum'],2) ?></td>
        <td><?php echo number_format($arr['right_sum'],2) ?></td>
        <td><?php echo $arr['email'] ?></td>
        <td><?php echo $arr['contact'] ?></td>
        <td><?php echo $arr['country'] ?></td>
        <td><?php echo $arr['LEADER'] ?></td>
        <td><?php echo $arr['created_on'] ?></td>
    </tr>
    <?php } ?>
</table>