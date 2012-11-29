<?php include('scripts.php'); ?>

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

<h3 id="header-breadcrumbs">
    <span class="txt_title"><?php echo $mlmCustomerEnquiry->getTitle(); ?></span></h3>

<div class="sep"></div>
<?php if ($sf_flash->has('successMsg')): ?>
    <div class="ui-widget">
        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
             class="ui-state-highlight ui-corner-all">
            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                          class="ui-icon ui-icon-info"></span>
                <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
        </div>
    </div>
    <?php endif; ?>
<?php if ($sf_flash->has('errorMsg')): ?>
    <div class="ui-widget">
        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
             class="ui-state-error ui-corner-all">
            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                          class="ui-icon ui-icon-alert"></span>
                <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
        </div>
    </div>
<?php endif; ?>
<br>
<form action="/member/doCustomerEnquiryDetail" id="csForm" name="csForm" method="post">
    <input type="hidden" name="enquiryId" value="<?php echo $mlmCustomerEnquiry->getEnquiryId(); ?>">
    <table cellspacing="0" cellpadding="0" class="tbl_form">
        <colgroup>
            <col width="30%">
            <col width="69%">
        </colgroup>
        <tbody>
        <?php
        foreach ($mlmCustomerEnquiryDetails as $mlmCustomerEnquiryDetail) {
            if ($mlmCustomerEnquiryDetail->getReplyFrom() == "ADMIN")
                $class = "color: #0088CF";
            else
                $class = "";
        ?>
        <tr class="tbl_form_row_even" style="<?php echo $class;?>">
            <td>
                <?php
                    if ($mlmCustomerEnquiryDetail->getReplyFrom() == "ADMIN")
                        echo $mlmCustomerEnquiryDetail->getReplyFrom();
                    else
                        echo $sf_user->getAttribute(Globals::SESSION_USERNAME);
                ?>
            </td>
            <td>
                <?php echo $mlmCustomerEnquiryDetail->getMessage();?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

    <br>
    <table cellspacing="0" cellpadding="0" class="tbl_form">
        <colgroup>
            
            <col width="30%">
            <col width="69%">
            
        </colgroup>
        <tbody>
        <tr class="tbl_form_row_even">
            <td>
                <?php echo __('Message') ?>
            </td>
            <td>
                <textarea rows="3" cols="3" id="message" name="message"><?php echo $message; ?></textarea>
            </td>
        </tr>
        <tr class="tbl_form_row_odd">
            <td>
                <?php echo __('Security Password'); ?>
            </td>
            <td>
                <input name="transactionPassword" type="password" id="transactionPassword"/>
            </td>
        </tr>

        <tr class="tbl_form_row_odd">
            
            <td></td>
            <td align="right">
                <button id="btnSubmit"><?php echo __('Submit') ?></button>
            </td>
            
        </tr>
        </tbody>
    </table>

    </form>

    <div class="info_bottom_bg"></div>
    <div class="clear"></div>