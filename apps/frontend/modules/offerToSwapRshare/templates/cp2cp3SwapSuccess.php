<?php
include('scripts.php');
$culture = $sf_user->getCulture();
?>

<style type="text/css">
.text_green {
    color: #ffff00;
    font-size: 14px;
}
.text_green {
    color: #009900;
    font-size: 14px;
    font-weight: bold;
}
.text_red {
    color: #ff0000;
    font-size: 14px;
    font-weight: bold;
}
.text_blue {
    color: #003399;
    font-weight: bold;
}
.text_bold {
    color: #000000;
    font-weight: bold;
}
</style>

<script type="text/javascript">
$(function() {
    $("#sssForm").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            "mt4Id" : {
                required : true
            },
            "txtSignature" : {
                required : true
            },
            "transactionPassword" : {
                required : true,
                remote: "/member/verifyTransactionPassword"
            }
        },
        submitHandler: function(form) {
            var isRt = $('#swapToRt').val();

            var msg = "";
            if (isRt == "Y") {
                msg = " (RT)";
            }
            var sure = confirm("<?php echo __('Are you sure want to proceed CP2/CP3 Swap to R-Share?') ?> " + msg);
            if (sure) {
                waiting();

                var cp2 = $('#convertedCp2').autoNumericGet();
                $("#convertedCp2").val(cp2);

                var cp3= $('#convertedCp3').autoNumericGet();
                $("#convertedCp3").val(cp3);
                form.submit();
            }
        },
        success: function(label) {
            //label.addClass("valid").text("Valid captcha!")
        }
    });

    $("#link_moreExample").click(function(event){
        event.preventDefault();
        $(this).hide();
        $("#divExample").show(500);
    });

    $('#convertedCp2').autoNumeric({
        mDec: 2
    }).keyup(function(){
        calculateRshare();
    });

    $('#convertedCp3').autoNumeric({
        mDec: 2
    }).keyup(function(){
        calculateRshare();
    }).trigger("keyup");

    $('#swapToRt').change(function(event){
        event.preventDefault();
        calculateRshare();
    });

<?php
    // 254781 monkey
//if ($distributorDB->getLeaderId() == 254781) {
    ?>
//    $('#tr_swapToRt').show();
    <?php
//}
?>
    $("#mt4Id").change(function(event){
        event.preventDefault();
        calculateRshare();
    });
});

function calculateRshare() {
    var convertedCp2 = parseFloat($('#convertedCp2').autoNumericGet());
    var convertedCp3 = parseFloat($('#convertedCp3').autoNumericGet());

    var totalAmountConvertedWithCp2Cp3 = convertedCp2 + convertedCp3;
    totalAmountConvertedWithCp2Cp3 = Math.round(totalAmountConvertedWithCp2Cp3);

    var totalRshare = totalAmountConvertedWithCp2Cp3 / 0.8;
    totalRshare = Math.round(totalRshare);

    var spanFormulaCp2 = "CP2 (<?php echo __('Optional');?>) = $0";
    var spanFormulaCp3 = "CP3 (<?php echo __('Optional');?>) = $0";
    var spanFormulaTotalAmount = "is $0 / 0.80";
    var spanFormulaRshare = "= 0 <?php echo __('R-Shares');?>";

    if (totalRshare >= 1) {
        spanFormulaCp2 = "CP2 (<?php echo __('Optional');?>) = $" + convertedCp2;
        spanFormulaCp3 = "CP3 (<?php echo __('Optional');?>) = $" + convertedCp3;
        spanFormulaTotalAmount = "is $" + totalAmountConvertedWithCp2Cp3 + " / 0.80";
        spanFormulaRshare = "= " + totalRshare + " <?php echo __('R-Shares');?>";

        $("#spanFormulaCp2").html(spanFormulaCp2);
        $("#spanFormulaCp3").html(spanFormulaCp3);
        $("#spanFormulaTotalAmount").html(spanFormulaTotalAmount);
        $("#spanFormulaRshare").html(spanFormulaRshare);
    }
}

</script>

<input type="hidden" id="textFormattedDecimal">
<table cellpadding="0" cellspacing="0">
<tbody>
<tr>
    <td><br></td>
</tr>
<tr>
    <td class="tbl_sprt_bottom" align="center">
        <span class="txt_title"><?php echo __('CP2/CP3 SWAP TO R-SHARE') ?></span>
    </td>
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
        <form id="sssForm" method="post" action="/offerToSwapRshare/doCp2cp3Swap">
        <table cellpadding="3" cellspacing="5">
            <tbody>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title">CP2/CP3转换R股优惠 </span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">CP2/CP3 Swap to R-Share Promo </span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">CP2/CP3 Swap to R-Share Promo </span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">CP2/CP3 Swap to R-Share Promo </span>
                    <?php
                    }
                     ?>
                </td>
            </tr>

            <tr>
                <td>
                    <table cellpadding="3" cellspacing="3">
                        <tr><td class="text_bold" style="width: 150px;"><?php echo __('Member ID');?></td><td>:</td><td><?php echo $distributorDB->getDistributorCode();?></td></tr>
                        <tr><td class="text_bold"><?php echo __('Full Name');?></td><td>:</td><td><?php echo $distributorDB->getFullName();?></td></tr>
                        <tr><td class="text_bold"><?php echo __('Home address');?></td><td>:</td><td><?php echo $distributorDB->getAddress();?></td></tr>
                        <tr><td class="text_bold"></td><td></td><td><?php echo $distributorDB->getAddress2();?></td></tr>
                        <tr><td class="text_bold"></td><td></td><td><?php echo $distributorDB->getPostcode(). " ". $distributorDB->getCity(). " ". $distributorDB->getState();?></td></tr>
                        <tr><td class="text_bold"><?php echo __('Country');?></td><td>:</td><td><?php echo $distributorDB->getCountry();?></td></tr>
                        <tr><td class="text_bold"><br></td></tr>
                        <tr><td class="text_bold"><?php echo __('Members current email');?></td><td>:</td><td><?php echo $distributorDB->getEmail();?></td></tr>
                        <tr><td class="text_bold"><?php echo __('Mobile');?></td><td>:</td><td><?php echo $distributorDB->getContact();?></td></tr>
                        <tr><td class="text_bold"><br></td></tr>
                        <tr><td class="text_bold"><?php echo __('MT4 ID');?></td><td>:</td><td>
                            <select name="mt4Id" id="mt4Id">
                                <?php
                                if (count($mt4Ids) > 0) {
                                    echo "<option value=''><?php echo __('Please select MT4 ID');?></option>";
                                    foreach ($mt4Ids as $mt4Id) {
                                    ?>
                                    <option value="<?php echo $mt4Id?>"><?php echo $mt4Id;?></option>
                                    <?php
                                    }
                                } else {
                                ?>
                                    <option value=""><?php echo __('(empty)');?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td></tr>
                        <tr><td class="text_bold">CP2</td><td>:</td><td><?php echo number_format($cp2Balance,2);?></td></tr>
                        <tr><td class="text_bold">CP3</td><td>:</td><td><?php echo number_format($cp3Balance,2);?></td></tr>
                    </table>
                    <br>

                    <ol>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <li style="padding-bottom: 10px;">本人同意，于该豁免申请通过的条件下，将CP2账户{USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} 或/和CP3账户{USD$ <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} 用于以0.8美金一股的价格转换成R股；并相信公司尽快安排股权证的发放。</li>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for, or applied to purchase R-Share, USD$.80  each and shall expect my Certificate of R-Shares to be issued to me in due course.</li>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for, or applied to purchase R-Share, USD$.80  each and shall expect my Certificate of R-Shares to be issued to me in due course.</li>
                        <?php
                        } else {
                        ?>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for, or applied to purchase R-Share, USD$.80  each and shall expect my Certificate of R-Shares to be issued to me in due course.</li>
                        <?php
                        }
                        ?>
                    </ol>
                    <span class="text_red" id="spanFormulaCp2">CP2 (<?php echo __('Optional');?>) = $0</span>
                    <br>
                    <span class="text_red" id="spanFormulaCp3">CP3 (<?php echo __('Optional');?>) = $0</span>
                    <br>
                    <br>
                    <span class="text_green">SSS</span> <span class="text_red" id="spanFormulaTotalAmount">is $0 / 0.80</span> <span class="text_green" id="spanFormulaRshare">= 0 <?php echo __('R-Shares');?></span>
                    <br>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <table cellpadding="3" cellspacing="3">
                        <tr>
                            <td><?php echo __('Security Password') ?></td>
                            <td>:</td>
                            <td><input name="transactionPassword" type="password" id="transactionPassword" size="30"/></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>

            <?php if (count($mt4Ids) > 0) { ?>
            <tr>
                <td align="right">
                    <button id="btnTransfer"><?php echo __('Submit') ?></button>
                </td>
            </tr>
            <?php } else { ?>
            <!--<tr>
                <td>
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong>You are not entitled to Special R-Share Swap</strong></p>
                        </div>
                    </div>
                </td>
            </tr>-->
            <?php }  ?>
            </tbody>
        </table>
        </form>
    </td>
</tr>
<tr>
<td>
</td>
</tr>
</tbody>
</table>