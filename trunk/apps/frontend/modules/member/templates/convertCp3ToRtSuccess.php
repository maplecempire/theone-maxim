<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
$(function() {
    $("#ecreditForm").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            "transactionPassword" : {
                required : true
                , remote: "/member/verifyTransactionPassword"
            },
            "epointAmount" : {
                required : true
            }
        },
        submitHandler: function(form) {
            waiting();
            var ecashBalance = $('#ecashBalance').autoNumericGet();
            var epointAmount = $('#epointAmount').autoNumericGet();
            //var epointAmount = parseFloat($("#cbo_epointAmount").val());

            if (epointAmount > parseFloat(ecashBalance)) {
                alert("In-sufficient CP3 Credit");
                return false;
            }
            $("#epointAmount").val(epointAmount);
            form.submit();
        }
    });
    $('#epointAmount').autoNumeric({
        mDec: 2
    }).keyup(function(){
        var convertedAmount = 0;
        var epointAmount = $('#epointAmount').autoNumericGet();
        //convertedAmount = parseFloat(epointAmount) * 1.05;
//        convertedAmount = parseFloat(epointAmount) * 1;
//        convertedAmount = Math.floor(convertedAmount);

        $("#epointConvertedAmount").val(epointAmount);
    });
    $('#epointConvertedAmount').autoNumeric({
        mDec: 2
    });
});
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Convert CP3 To RT') ?></span></td>
    </tr>
    <tr>
        <td><br>
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

        </td>
    </tr>
    <tr>
        <td>
            <form action="<?php echo url_for("/member/convertCp3ToRt") ?>" id="ecreditForm" name="ecreditForm" method="post">
            <table cellspacing="0" cellpadding="0" class="tbl_form">
                <colgroup>
                    <col width="1%">
                    <col width="30%">
                    <col width="69%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <th class="tbl_header_left">
                        <div class="border_left_grey">&nbsp;</div>
                    </th>
                    <th colspan="2"><?php echo __('Convert CP3 To RT') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Balance'); ?></td>
                    <td>
                        <input name="ecashBalance" id="ecashBalance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($ledgerAccountBalance, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Amount'); ?></td>
                    <td>
                        <input name="epointAmount" id="epointAmount" tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('RT Converted Amount'); ?></td>
                    <td>
                        <input name="epointConvertedAmount" id="epointConvertedAmount" tabindex="3" readonly="readonly"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password'); ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"
                                           tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>

            </form>
        </td>
    </tr>
    </tbody>
</table>