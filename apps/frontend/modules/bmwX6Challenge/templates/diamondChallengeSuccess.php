<?php include('scripts.php'); ?>

<table class="pbl_table" border="1" cellspacing="0">
    <tbody>
    <tr class="pbl_header">
        <td valign="middle" width="10"></td>
        <td valign="middle"><?php echo __('Member ID') ?></td>
        <td valign="middle"><?php echo __('Total Personal Sales') ?></td>
        <td align='middle'>Full Name</td>
        <td align='middle'>Date</td>
        <td align='middle'>Leader</td>
    </tr>

    <?php
        if (count($resultArray) > 0) {
            $trStyle = "1";
            $idx = 1;
            foreach ($resultArray as $member) {
                if ($trStyle == "1") {
                    $trStyle = "0";
                } else {
                    $trStyle = "1";
                }

                echo "<tr class='row" . $trStyle . "'>
                        <td align='left'>" . $idx++ . ".</td>
                        <td align='middle'>" . $member['distributor_code'] . "</td>
                        <td align='middle'>" . $member['price'] . "</td>
                        <td align='middle'>" . $member['full_name'] . "</td>
                        <td align='middle'>" . $member['active_datetime'] . "</td>
                        <td align='middle'>" . $member['LEADER'] . "</td>";

                echo "</tr>";

                //if ($idx > 10)
                //    break;
            }
            foreach ($upgradeResultArray as $member) {
                if ($trStyle == "1") {
                    $trStyle = "0";
                } else {
                    $trStyle = "1";
                }

                echo "<tr class='row" . $trStyle . "'>
                        <td align='left'>" . $idx++ . ".</td>
                        <td align='middle'>" . $member['distributor_code'] . "</td>
                        <td align='middle'>" . $member['price'] . "</td>
                        <td align='middle'>" . $member['full_name'] . "</td>
                        <td align='middle'>" . $member['created_on'] . "</td>
                        <td align='middle'>" . $member['LEADER'] . "</td>";

                echo "</tr>";

                //if ($idx > 10)
                //    break;
            }
        } else {
            echo "<tr class='odd' align='center'><td colspan='2'>" . __('No data available in table') . "</td></tr>";
        }
    ?>
    </tbody>
    <!--<input type='text' class='text qty' name='qty[]' value='0' size='5' ref='".$productDB->getPrice()."'>-->
</table>