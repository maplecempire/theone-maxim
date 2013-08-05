<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
$(function() {
    $("#topupForm").validate({
        messages : {
            transactionPassword: {
                remote: "Security Password is not valid."
            }
        },
        rules : {
            "transactionPassword" : {
                required : true,
                remote: "/member/verifyTransactionPassword"
            }
        },
        submitHandler: function(form) {
            var epoint = $('#topup_pointAvail').autoNumericGet();
            var epointPackageNeeded = $('#epointNeeded').autoNumericGet();

            if ($("#topup_pointAvail").val() == 0 || $("#topup_pointAvail").val() == "" || parseFloat(epoint) < parseFloat(epointPackageNeeded)) {
                error("In-sufficient fund to purchase product.");
            } else {
                waiting();
                form.submit();
            }
        }
    });
    $(".activeLink").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(event) {
        event.preventDefault();
        var epointNeeded = $(this).attr("ref");
        var pid = $(this).attr("pid");

        if (pid >= <?php echo Globals::MAX_PACKAGE_ID?>) {
            epointNeeded = $("#specialPackageId option:selected").attr("price");
            pid = $("#specialPackageId").val();
        }

        $('#epointNeeded').val(epointNeeded);
        $('#pid').val(pid);
        $("#topupForm").submit();
    });
    $('#totalAmount').autoNumeric({
        mDec: 2
    });
    $('.qty').autoNumeric({
        mDec: 0
    }).focus(function(){
        $(this).select();
    }).keyup(function(event){
        var totalAmount = 0;
        jQuery.each($('.qty'), function(key, value) {
            var productPrice = $(this).attr("ref");
            var productQty = $(this).autoNumericGet();
            totalAmount += parseFloat(productQty) * parseFloat(productPrice);
        });
        $("#epointNeeded").autoNumericSet(totalAmount);
    }).trigger("keyup");
});
</script>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('MAX Store Merchandising') ?></span></td>
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
            <form action="/maxStore/doPurchaseProduct" id="topupForm" name="topupForm" method="post">
            <input type="hidden" id="pid" name="pid" value=""/>

            <table cellspacing="0" cellpadding="0" class="tbl_form">
                <colgroup>
                    <col width="1%">
                    <col width="30%">
                    <col width="69%">
                    <col width="1%">
                </colgroup>
                <tbody>

                <tr>
                    <td colspan="4">
                        <table class="pbl_table" border="1" cellspacing="0">
                            <tbody>
                            <tr class="pbl_header">
                                <td valign="middle"></td>
                                <td valign="middle"><?php echo __('Product Name') ?></td>
                                <td valign="middle"><?php echo __('Price') ?></td>
                                <td valign="middle"><?php echo __('Quantity') ?></td>
                            </tr>

                            <?php
                                if (count($productDBs) > 0) {
                                    $trStyle = "1";
                                    $idx = 1;
                                    foreach ($productDBs as $productDB) {
                                        if ($trStyle == "1") {
                                            $trStyle = "0";
                                        } else {
                                            $trStyle = "1";
                                        }

                                        $productPrice = number_format($productDB->getPrice(), 2);

                                        echo "<tr class='row" . $trStyle . "'>
                                                <td align='left'>" . $idx++ . ".</td>
                                                <td align='left'>" . $productDB->getProductName() . "</td>
                                                <td align='center'>" . $productPrice . "</td>
                                                <td align='center'><input type='text' class='text qty' name='qty[]' value='0' size='5' ref='".$productDB->getPrice()."'>
                                                                   <input type='hidden' name='productId[]' value='".$productDB->getStoreId()."'></td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr class='odd' align='center'><td colspan='4'>" . __('No data available in table') . "</td></tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <table>
                            <td colspan="1" align="right" valign="top">
                                <font color="#dc143c"> <?php echo __('NOTE :') ?></font> &nbsp;
                            </td>
                            <td colspan="1" align="left">
                                <font color="#dc143c">1. <?php echo __('COLLECTION OF ALL ABOVE ITEMS IN MACAU ON 5TH & 6TH AUGUST 2013.') ?>
                                <br>2. <?php echo __('KINDLY VISIT OUR MAX STORE.') ?>
                                <br>3. <?php echo __('**ITEMS SOLD ARE NOT EXCHANGABLE OR RETURNABLE.') ?>
                                </font>
                            </td>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP1 Account') ?></td>
                    <td><input type="text" readonly="readonly" id="topup_pointAvail" size="20px" value="<?php echo number_format($pointAvailable, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>
                <!--<tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('CP2 Account') */?></td>
                    <td><input type="text" readonly="readonly" id="topup_pointAvail" size="20px" value="<?php /*echo number_format($pointAvailable, 2); */?>"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('CP3 Account') */?></td>
                    <td><input type="text" readonly="readonly" id="topup_pointAvail" size="20px" value="<?php /*echo number_format($pointAvailable, 2); */?>"/></td>
                    <td>&nbsp;</td>
                </tr>-->

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Total Amount') ?></td>
                    <td><input type="text" id="epointNeeded" name="epointNeeded" readonly="readonly" size="20px" value="0"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Security Password') ?></td>
                    <td><input type="password" id="transactionPassword" name="transactionPassword" size="20px" value=""/></td>
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