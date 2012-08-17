<?php use_helper('I18N');
echo "<link href='/sf/sf_admin/css/main.css' media='screen' type='text/css' rel='stylesheet'>";
?>

<script type="text/javascript">
$(function() {
    $(".editLink").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    });
    $("#btnCreate").button({
        icons: {
            primary: "ui-icon-circle-plus"
        }
    });
});
</script>

<div style="padding: 10px; top: 10px; width: 98%">
    <div class="portlet" id="sf_admin_container">
        <div class="portlet-header">Delivery Group</div>
        <div class="portlet-content" id="sf_admin_content" style="width: 98%">
            <table class="sf_admin_list" width="100%">
                <thead>
                <tr>
                    <th>Package</th>
                    <th>Package name</th>
                    <th>Price</th>
                    <th>Commission</th>
                    <th>Pips</th>
                    <th>Generation</th>
                    <th>Pips2</th>
                    <th>Generation2</th>
                    <th>Display on client side</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($mlm_packages as $mlm_package):
                    if ($className == "sf_admin_row_0") {
                        $className = "sf_admin_row_1";
                    } else {
                        $className = "sf_admin_row_0";
                    }
                    ?>
                <tr class="<?php echo $className?>">
                    <td><?php echo link_to($mlm_package->getPackageId(), 'admin/packageEdit?package_id=' . $mlm_package->getPackageId()) ?></td>
                    <td><?php echo $mlm_package->getPackageName() ?></td>
                    <td><?php echo $mlm_package->getPrice() ?></td>
                    <td><?php echo $mlm_package->getCommission() ?></td>
                    <td><?php echo $mlm_package->getPips() ?></td>
                    <td><?php echo $mlm_package->getGeneration() ?></td>
                    <td><?php echo $mlm_package->getPips2() ?></td>
                    <td><?php echo $mlm_package->getGeneration2() ?></td>
                    <td><?php
                            if ($mlm_package->getPublicPurchase() == Globals::YES)
                                echo "Yes";
                            else if ($mlm_package->getPublicPurchase() == Globals::NO)
                                echo "No";
                            else
                                echo $mlm_package->getPublicPurchase();
                        ?>
                    </td>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>

            <div style="text-align: right">
                <?php echo link_to('create', 'admin/packageCreate', array("id" => "btnCreate")) ?>
            </div>
        </div>
    </div>
</div>