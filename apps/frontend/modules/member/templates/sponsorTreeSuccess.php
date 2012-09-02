<?php include('scripts.php'); ?>
<style type="text/css">
#footer {
    background: none repeat scroll 0 0 #333333;
    height: 50px;
    margin: 10px auto 0;
    width: 980px;
    position: fixed;
    bottom: 0px;
}
</style>

<script type="text/javascript" language="javascript">
    $(function() {
        $("#sponsorTree").treeview({
            url: "/member/manipulateSponsorTree"
        });
    });
</script>

<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Genealogy for your Trader ID') . ": " . $distinfo->getDistributorCode(); ?></span></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>
        <ul id="sponsorTree" style="background-color: #ffffff;">
            <?php
            $className = "";

            if ($hasChild) {
                $className = "class='hasChildren'";
            }
            ?>
            <li id="<?php echo $distinfo->getDistributorId();?>" <?php echo $className;?>>
                <span>
                    <?php echo "".$distinfo->getDistributorCode()
                               . " " . $distinfo->getFullName()
                               . " Joined " . date('Y-m-d', strtotime($distinfo->getActiveDatetime()))
                               . " " . $distinfo->getRankCode();
                    ?>
                </span>
            <?php
            if ($hasChild) {
                ?>
                <ul>
                    <li><span class="placeholder">&nbsp;</span></li>
                </ul>
                <?php } ?>
            </li>
        </ul>
    </td>
</tr>
</tbody>
</table>