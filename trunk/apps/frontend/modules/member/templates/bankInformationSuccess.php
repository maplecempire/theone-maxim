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

<div class="aside">
    <?php include_component('component', 'headerInformation', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #BeginLibraryItem "/Library/side_navi.lbi" -->
    <div class="sidenavi">
        <ul>
            <li><a href="/member/viewProfile"><span><?php echo __('Account Information'); ?></span></a></li>
            <li><a href="/member/viewBankInformation"><span><?php echo __('Bank Account Information'); ?></span></a></li>
            <li><a href="/member/loginPassword"><span><?php echo __('Change Password'); ?></span></a></li>
            <li><a href="/member/transactionPassword"><span><?php echo __('Change Security Password'); ?></span></a></li>
        </ul>
    </div>

    <?php include_component('component', 'submenu', array('param' => $sf_user->getAttribute(Globals::SESSION_DISTID, 0))) ?>
    <!-- #EndLibraryItem -->
</div>

<div class="areaContent">
    <div class="resultsWrap">
        <form id="registerForm" method="post" action="/member/updateBankInformation">
            <table cellpadding="3" cellspacing="3" border="0" width="100%" class="tablelist" bgcolor="#f90;"
                   align="center">
                <caption><?php echo __('Bank Account Information') ?></caption>
                <tr>
                    <td colspan=2 align='center'>
                        <?php if ($sf_flash->has('successMsg')): ?>
                        <div class="ui-widget">
                            <div style="margin-top: 20px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p><span style="float: left; margin-right: .3em;"
                                         class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" width="650px" style="margin:0 auto">
                            <tr>
                                <td class="caption"><span id="Label13"><strong><?php echo __('Bank Name') ?></strong></span></td>
                                <td class="value"><input name="bankName" type="text" id="bankName"
                                                         size="30" value="<?php echo $distDB->getBankName() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Bank Account Number') ?></strong></span></td>
                                <td class="value"><input name="bankAccNo" type="text" id="bankAccNo" size="30"
                                                         value="<?php echo $distDB->getBankAccNo() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Re-Confirm Bank Account Number') ?></strong></span></td>
                                <td class="value"><input name="rebankAccNo" type="text" id="rebankAccNo" size="30"
                                                         value=""/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Bank Account Holder Name') ?></strong></span></td>
                                <td class="value"><input name="bankHolderName" type="text" id="bankHolderName" size="30"
                                                         value="<?php echo $distDB->getBankHolderName() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Bank Swift Code / ABA') ?></strong></span></td>
                                <td class="value"><input name="bankSwiftCode" type="text" id="bankSwiftCode" size="30"
                                                         value="<?php echo $distDB->getBankSwiftCode() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Chinatrust Bank Visa Debit Card') ?></strong></span></td>
                                <td class="value"><input name="visaDebitCard" type="text" id="visaDebitCard" size="30" maxlength="16"
                                                         value="<?php echo $distDB->getVisaDebitCard() ?>"/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Re-Confirm Chinatrust Bank Visa Debit Card') ?></strong></span></td>
                                <td class="value"><input name="revisaDebitCard" type="text" id="revisaDebitCard" size="30" maxlength="16"
                                                         value=""/></td>
                            </tr>
                            <tr>
                                <td class="caption" valign="top"><span><strong><?php echo __('Security Password') ?></strong></span></td>
                                <td class="value"><input name="transactionPassword" type="password" id="transactionPassword" size="30"/></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <button id="btnUpdate">Update</button>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        <div class="clear"></div>
    </div>
</div>