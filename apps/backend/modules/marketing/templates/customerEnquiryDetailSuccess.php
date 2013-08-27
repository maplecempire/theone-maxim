<?php
// auto-generated by sfPropelCrud
// date: 2012/04/20 19:13:40
?>
<?php use_helper('Object') ?>
<?php use_helper('I18N') ?>
<!-- TinyMCE -->
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
$(function() {
    $("#btnSave").button({
            icons: {
                primary: "ui-icon-circle-check"
            }
        })
});
</script>

<script type="text/javascript" language="javascript">
$(function() {
    $("#csForm").validate({
        messages : {
            transactionPassword: {
                remote: "Security Password is not valid."
            }
        },
        rules : {
            "transactionPassword" : {
                required : true
                , remote: "/member/verifyTransactionPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        }
    });
});

tinyMCE.init({
    // General options
    mode : "exact",
    elements : "message",
    theme : "simple",
    width: "100%"
});
</script>

<?php echo form_tag('marketing/doCustomerEnquiryDetail') ?>
<input type="hidden" name="enquiryId" value="<?php echo $mlmCustomerEnquiry->getEnquiryId(); ?>">
<div style="padding: 10px; top: 10px; width: 98%">
    <div class="portlet">
        <div class="portlet-header">Customer Enquiry</div>
        <div class="portlet-content" style="width: 98%">
            <?php $distributorDB = MlmDistributorPeer::retrieveByPK($mlmCustomerEnquiry->getDistributorId());
            $c = new Criteria();
            $c->add(MlmDistMt4Peer::DIST_ID, $mlmCustomerEnquiry->getDistributorId());
            $mlmDistMt4s = MlmDistMt4Peer::doSelect($c);
            ?>
            <h3>Title: <?php echo $mlmCustomerEnquiry->getTitle(); ?></h3>
            <h3>Contact No: <?php echo $mlmCustomerEnquiry->getContactNo(); ?></h3>
            <h3>Leader: <?php
                $leaderArrs = explode(",", Globals::GROUP_LEADER);
                $leader = "";
                for ($i = 0; $i < count($leaderArrs); $i++) {
                    $pos = strrpos($distributorDB->getTreeStructure(), "|".$leaderArrs[$i]."|");
                    if ($pos === false) { // note: three equal signs

                    } else {
                        $distLeader = MlmDistributorPeer::retrieveByPK($leaderArrs[$i]);
                        if ($distLeader) {
                            $leader = $distLeader->getDistributorCode();
                        }
                        break;
                    }
                }
                echo $leader; ?></h3>
            <h3>MT4: <?php
                foreach ($mlmDistMt4s as $mlmDistMt4) {
                    echo $mlmDistMt4->getMt4UserName(). " ";
                }
             ?></h3>
            <h3>From ABFX: <?php echo $distributorDB->getFromAbfx(); ?></h3>

            <table class="sf_admin_list" cellpadding="3" width="100%">
                <tr>
                    <td colspan="2">
                        <?php if ($sf_flash->has('successMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-highlight ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($sf_flash->has('errorMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
                                    <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                foreach ($mlmCustomerEnquiryDetails as $mlmCustomerEnquiryDetail) {
                    if ($mlmCustomerEnquiryDetail->getReplyFrom() == "ADMIN")
                        $class = "color: #0088CF";
                    else
                        $class = "";
                ?>
                <tr style="<?php echo $class;?>">
                    <td class="caption" style="width: 20%">
                        <?php
                            if ($mlmCustomerEnquiryDetail->getReplyFrom() == "ADMIN")
                                echo $mlmCustomerEnquiryDetail->getReplyFrom();
                            else
                                echo $distributorDB->getDistributorCode();
                        ?>
                    </td>
                    <td class="value" style="width: 45%">
                        <?php echo $mlmCustomerEnquiryDetail->getMessage();?>
                    </td>
                </tr>
                <?php } ?>
                <tr class="tbl_form_row_even">
                    <td>
                        <?php echo __('Message') ?>
                    </td>
                    <td>
                        <textarea rows="3" cols="3" id="message" name="message"><?php echo $message; ?></textarea>
                    </td>
                </tr>
            </table>
            <hr/>
            <button id="btnSave">Save</button>
        </div>
    </div>
</div>
</form>