<?php include('scripts.php'); ?>
<script>
$(function() {
    $("#registerForm").validate({
        messages : {
            transactionPassword: {
                remote: "Security Password is not valid."
            }
        },
        rules : {
            "bankName" : {
                required : true,
                minlength : 3
            },
            "bankAccNo" : {
                required : true,
                minlength : 3
            },
            "rebankAccNo" : {
                required : true,
                minlength : 3,
                equalTo: "#bankAccNo"
            },
            "bankHolderName" : {
                required : true,
                minlength : 3
            },
            "visaDebitCard" : {
                required : "#visaDebitCard:filled",
                minlength : 16
            },
            "revisaDebitCard" : {
                required : "#visaDebitCard:filled",
                minlength : 16,
                equalTo: "#visaDebitCard"
            },
            "transactionPassword" : {
                required : true,
                remote: "/member/verifyTransactionPassword"
            }
        },
        submitHandler: function(form) {
            waiting();
            form.submit();
        },
        success: function(label) {
            //label.addClass("valid").text("Valid captcha!")
        }
    });
    $("#btnUpdate").button({
        icons: {
            primary: "ui-icon-disk"
        }
    });
});
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Bank Account Information') ?></span></td>
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
            <form id="registerForm" method="post" action="/member/updateBankInformation">
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
                    <th><?php echo __('Bank Account Details') ?></th>
                    <th class="tbl_content_right"></th>
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Name') ?></td>
                    <td><input name="bankName" type="text" id="bankName"
                             size="30" value="<?php echo $distDB->getBankName() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Account Number') ?></td>
                    <td><input name="bankAccNo" type="text" id="bankAccNo" size="30"
                                                         value="<?php echo $distDB->getBankAccNo() ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Re-Confirm Bank Account Number') ?></td>
                    <td><input name="rebankAccNo" type="text" id="rebankAccNo" size="30"
                                                         value=""/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Account Holder Name') ?></td>
                    <td><input name="bankHolderName" type="text" id="bankHolderName" size="30"
                                                         value="<?php echo $distDB->getBankHolderName() ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Bank Swift Code / ABA') ?></td>
                    <td><input name="bankSwiftCode" type="text" id="bankSwiftCode" size="30"
                                                         value="<?php echo $distDB->getBankSwiftCode() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Chinatrust Bank Visa Debit Card') ?></td>
                    <td>
                        <input name="visaDebitCard" type="text" id="visaDebitCard" size="30" maxlength="16"
                                                         value="<?php echo $distDB->getVisaDebitCard() ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Re-Confirm Chinatrust Bank Visa Debit Card') ?></td>
                    <td>
                        <input name="revisaDebitCard" type="text" id="revisaDebitCard" size="30" maxlength="16"
                                                         value=""/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password') ?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword" size="30"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnUpdate">Update</button>
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