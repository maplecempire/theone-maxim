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
            "convertAmount" : {
                required : true
            }
        },
        submitHandler: function(form) {
            waiting();
            var cp1Balance = $('#cp1Balance').autoNumericGet();
            var cp2Balance = $('#cp2Balance').autoNumericGet();
            var cp3Balance = $('#cp3Balance').autoNumericGet();
            var convertAmount = $('#convertAmount').autoNumericGet();
            var convertOption = $('#convertOption').val();
            //var convertAmount = parseFloat($("#cbo_convertAmount").val());

            if (convertOption == "CP1" && convertAmount > parseFloat(cp1Balance)) {
                alert("In-sufficient CP1 Credit");
                return false;
            }
            if (convertOption == "CP2" && convertAmount > parseFloat(cp2Balance)) {
                alert("In-sufficient CP2 Credit");
                return false;
            }
            if (convertOption == "CP3" && convertAmount > parseFloat(cp3Balance)) {
                alert("In-sufficient CP3 Credit");
                return false;
            }
            $("#convertAmount").val(convertAmount * <?php echo $convertRate ?>);
            form.submit();
        }
    });
    $('#convertAmount').autoNumeric({
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
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Convert To CP4') ?></span></td>
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
            <form action="<?php echo url_for("/member/convertToCp4") ?>" id="ecreditForm" name="ecreditForm" method="post">
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
                    <th colspan="2"><?php echo __('Convert To CP4') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP1 Balance'); ?></td>
                    <td>
                        <input name="cp1Balance" id="cp1Balance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($cp1AccountBalance, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP2 Balance'); ?></td>
                    <td>
                        <input name="cp2Balance" id="cp2Balance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($cp2AccountBalance, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Balance'); ?></td>
                    <td>
                        <input name="cp3Balance" id="cp3Balance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($cp3AccountBalance, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Convert Option'); ?></td>
                    <td>
                        <select name="convertOption" id="convertOption" tabindex="2">
                            <option value="CP1">CP1</option>
                            <option value="CP2">CP2</option>
                            <option value="CP3">CP3</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Convert Amount'); ?></td>
                    <td>
                        <input name="convertAmount" id="convertAmount" tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even" style="display: none;">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP1 Converted Amount'); ?></td>
                    <td>
                        <input name="epointConvertedAmount" id="epointConvertedAmount" tabindex="3" disabled="disabled" readonly="readonly"/>
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