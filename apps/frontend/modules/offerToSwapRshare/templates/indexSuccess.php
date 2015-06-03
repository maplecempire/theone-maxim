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
            var sure = confirm("<?php echo __('Are you sure want to proceed Super Share Swap?') ?> " + msg);
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
if ($distributorDB->getLeaderId() == 254781) { ?>
    $('#tr_swapToRt').show();
    <?php
}
?>
    $("#mt4Id").change(function(event){
        event.preventDefault();
        $(".indicator").show();
        $.ajax({
            type : 'POST',
            url : "<?php echo url_for('offerToSwapRshare/enquiryMt4Balance') ?>",
            dataType : 'json',
            cache: false,
            data: {
                mt4Id : $('#mt4Id').val()
            },
            success : function(data) {
                if (data.error) {
                    alert(data.errorMsg);
                } else {
                    $(".indicator").hide();

                    $("#textFormattedDecimal").autoNumericSet(data.mt4Balance);
                    var mt4Balance = $('#textFormattedDecimal').val();
                    $("#td_mt4Balance").html(mt4Balance);
                    $("#txtMt4Balance").val(mt4Balance);

                    $("#textFormattedDecimal").autoNumericSet(data.remainingRoiAmount);
                    var $remainingRoiAmount = $('#textFormattedDecimal').val();
                    $("#txtRemainingRoiAmount").val($remainingRoiAmount);
                    $("#roiRemainingMonth").val(data.roiRemainingMonth);
                    $("#roiPercentage").val(data.roiPercentage);

                    calculateRshare();
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Server connection error.");
            }
        });
    });
});

function calculateRshare() {
    var mt4Balance = parseFloat($('#txtMt4Balance').autoNumericGet());
    var remainingRoiAmount = parseFloat($('#txtRemainingRoiAmount').autoNumericGet());
    var convertedCp2 = parseFloat($('#convertedCp2').autoNumericGet());
    var convertedCp3 = parseFloat($('#convertedCp3').autoNumericGet());
    var roiRemainingMonth = $('#roiRemainingMonth').val();
    var roiPercentage = $('#roiPercentage').val();
    var isRt = $('#swapToRt').val();

    var totalAmountConverted = mt4Balance + (mt4Balance * roiRemainingMonth * roiPercentage / 100);
    var totalAmountConvertedWithCp2Cp3 = totalAmountConverted + convertedCp2 + convertedCp3;
    totalAmountConvertedWithCp2Cp3 = Math.round(totalAmountConvertedWithCp2Cp3);

    var totalRshare = totalAmountConvertedWithCp2Cp3 / 0.8;
    totalRshare = Math.round(totalRshare);

    var spanFormula = "$0K + ($0K x 0 months x 8%) = $0";
    var spanFormulaCp2 = "CP2 (Optional) = $0";
    var spanFormulaCp3 = "CP3 (Optional) = $0";
    var spanFormulaTotalAmount = "is $0 / 0.80";
    var spanFormulaRshare = "= 0 R-Shares";

    if (isRt == "Y") {
        spanFormulaRshare = "= 0 RT";
        totalRshare = totalAmountConvertedWithCp2Cp3;
        totalRshare = Math.round(totalRshare);
    }

    if (totalRshare >= 1) {
        spanFormula = "$" + mt4Balance + "K + ($" + mt4Balance + "K x " + roiRemainingMonth + " months x " + roiPercentage + "%) = $" + totalAmountConverted + "";
        spanFormulaCp2 = "CP2 (Optional) = $" + convertedCp2;
        spanFormulaCp3 = "CP3 (Optional) = $" + convertedCp3;
        spanFormulaTotalAmount = "is $" + totalAmountConvertedWithCp2Cp3 + " / 0.80";
        spanFormulaRshare = "= " + totalRshare + " R-Shares";

        if (isRt == "Y") {
            spanFormulaTotalAmount = "is " + totalAmountConvertedWithCp2Cp3;
            spanFormulaRshare = "= " + totalRshare + " RT";
        }

        $("#spanFormula").html(spanFormula);
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
        <span class="txt_title"><?php echo __('APPLICATION FOR DISPENSATION 18 MONTH INVESTMENT TERM') ?></span>
        <br>
        <i><?php echo __('(Only applicable from 12 May 2015 to 30 June 2015)') ?></i>
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
        <form id="sssForm" method="post" action="/offerToSwapRshare/confirmation">
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
                        <span class="txt_title">R股转换优惠 </span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title">Special R-Share Swap Promo </span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title">Special R-Share Swap Promo </span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title">Special R-Share Swap Promo </span>
                    <?php
                    }
                     ?>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">To Qualify: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Contract(s) at least 12 months or more</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">SSS Formula: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Principal Sum based on MT4 Balance + Remaining Performance Return (Months) <br>+ CP2 & CP3 balance (Optional)</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">CONVERT: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">to R-Share @ <u>US$0.80 per share</u></span>
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">To Qualify: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Contract(s) at least 12 months or more</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">SSS Formula: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Principal Sum based on MT4 Balance + Remaining Performance Return (Months) <br>+ CP2 & CP3 balance (Optional)</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">CONVERT: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">to R-Share @ <u>US$0.80 per share</u></span>
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">To Qualify: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Contract(s) at least 12 months or more</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">SSS Formula: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Principal Sum based on MT4 Balance + Remaining Performance Return (Months) <br>+ CP2 & CP3 balance (Optional)</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">CONVERT: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">to R-Share @ <u>US$0.80 per share</u></span>
                    <?php
                    } else {
                    ?>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">To Qualify: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Contract(s) at least 12 months or more</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">SSS Formula: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">Principal Sum based on MT4 Balance + Remaining Performance Return (Months) <br>+ CP2 & CP3 balance (Optional)</span>
                        <br>
                        <br>
                        <br>
                        <span class="txt_title" style="font-size: 12px; color: #ff0000;">CONVERT: </span>
                        <br>
                        <span style="font-size: 12px; font-weight: bold;">to R-Share @ <u>US$0.80 per share</u></span>
                    <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td>

                <table>
                    <tr>
                        <td class="tbl_sprt_bottom">
<?php
                        if ($culture == "cn") {
    ?>
    <span class="txt_title">Example 1: VVIP $30K with 6 months PR left</span>
    <?php

} else if ($culture == "kr") {
    ?>
    <span class="txt_title">Example 1: VVIP $30K with 6 months PR left</span>
    <?php

} else if ($culture == "jp") {
    ?>
    <span class="txt_title">Example 1: VVIP $30K with 6 months PR left</span>
    <?php

} else {
    ?>
    <span class="txt_title">Example 1: VVIP $30K with 6 months PR left</span>
    <?php

}
    ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
<?php
                        if ($culture == "cn") {
    ?>
    <span class="text_red">$30K + ($30K x 6 months x 8%) = $44,400</span>
    <br>
    <br>
    <span class="text_green">SSS</span> <span class="text_red">is $44,400 / 0.80</span> <span class="text_green">= 55,500 R-Shares</span>
    <?php

} else if ($culture == "kr") {
    ?>
    <span class="text_red">$30K + ($30K x 6 months x 8%) = $44,400</span>
    <br>
    <br>
    <span class="text_green">SSS</span> <span class="text_red">is $44,400 / 0.80</span> <span class="text_green">= 55,500 R-Shares</span>
    <?php

} else if ($culture == "jp") {
    ?>
    <span class="text_red">$30K + ($30K x 6 months x 8%) = $44,400</span>
    <br>
    <br>
    <span class="text_green">SSS</span> <span class="text_red">is $44,400 / 0.80</span> <span class="text_green">= 55,500 R-Shares</span>
    <?php

} else {
    ?>
    <span class="text_red">$30K + ($30K x 6 months x 8%) = $44,400</span>
    <br>
    <br>
    <span class="text_green">SSS</span> <span class="text_red">is $44,400 / 0.80</span> <span class="text_green">= 55,500 R-Shares</span>
    <?php

}
    ?>
                        </td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                    <tr>
                        <td><a href="#" id="link_moreExample">More Example</a></td>
                    </tr>
                </table>

                    <div id="divExample" style="display: none;">
                        <table cellpadding="3" cellspacing="5">
                <tbody>
                <tr>
                    <td class="tbl_sprt_bottom">
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="txt_title">Example 2: VVIP $30K with 6 months PR left but with $10k MT4 Balance</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="txt_title">Example 2: VVIP $30K with 6 months PR left but with $10k MT4 Balance</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="txt_title">Example 2: VVIP $30K with 6 months PR left but with $10k MT4 Balance</span>
                        <?php
                        } else {
                        ?>
                            <span class="txt_title">Example 2: VVIP $30K with 6 months PR left but with $10k MT4 Balance</span>
                        <?php
                        }
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="text_red">$10K + ($10K x 6 months x 8%) = $14,800</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $14,800 / 0.80</span> <span class="text_green">= 18,500 R-Shares</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="text_red">$10K + ($10K x 6 months x 8%) = $14,800</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $14,800 / 0.80</span> <span class="text_green">= 18,500 R-Shares</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="text_red">$10K + ($10K x 6 months x 8%) = $14,800</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $14,800 / 0.80</span> <span class="text_green">= 18,500 R-Shares</span>
                        <?php
                        } else {
                        ?>
                            <span class="text_red">$10K + ($10K x 6 months x 8%) = $14,800</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $14,800 / 0.80</span> <span class="text_green">= 18,500 R-Shares</span>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class="tbl_sprt_bottom">
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="txt_title">Example 3: 	VVIP $30K with 3 months PR left</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="txt_title">Example 3: 	VVIP $30K with 3 months PR left</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="txt_title">Example 3: 	VVIP $30K with 3 months PR left</span>
                        <?php
                        } else {
                        ?>
                            <span class="txt_title">Example 3: 	VVIP $30K with 3 months PR left</span>
                        <?php
                        }
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="text_red">$30K + ($30K x 3 months x 8%) = $37,200</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $37,200 / 0.80</span> <span class="text_green">= 46,500 R-Shares</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="text_red">$30K + ($30K x 3 months x 8%) = $37,200</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $37,200 / 0.80</span> <span class="text_green">= 46,500 R-Shares</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="text_red">$30K + ($30K x 3 months x 8%) = $37,200</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $37,200 / 0.80</span> <span class="text_green">= 46,500 R-Shares</span>
                        <?php
                        } else {
                        ?>
                            <span class="text_red">$30K + ($30K x 3 months x 8%) = $37,200</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $37,200 / 0.80</span> <span class="text_green">= 46,500 R-Shares</span>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class="tbl_sprt_bottom">
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="txt_title">Example 4: VVIP $30K with 3 months PR left but with 10K MT4 balance</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="txt_title">Example 4: VVIP $30K with 3 months PR left but with 10K MT4 balance</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="txt_title">Example 4: VVIP $30K with 3 months PR left but with 10K MT4 balance</span>
                        <?php
                        } else {
                        ?>
                            <span class="txt_title">Example 4: VVIP $30K with 3 months PR left but with 10K MT4 balance</span>
                        <?php
                        }
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="text_red">$10K + ($10K x 3 months x 8%) = $12,400</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $12,400 / 0.80</span> <span class="text_green">= 15,500 R-Shares</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="text_red">$10K + ($10K x 3 months x 8%) = $12,400</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $12,400 / 0.80</span> <span class="text_green">= 15,500 R-Shares</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="text_red">$10K + ($10K x 3 months x 8%) = $12,400</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $12,400 / 0.80</span> <span class="text_green">= 15,500 R-Shares</span>
                        <?php
                        } else {
                        ?>
                            <span class="text_red">$10K + ($10K x 3 months x 8%) = $12,400</span>
                            <br>
                            <br>
                            <span class="text_green">SSS</span> <span class="text_red">is $12,400 / 0.80</span> <span class="text_green">= 15,500 R-Shares</span>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class="tbl_sprt_bottom">
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="txt_title">Example 5: VVIP $30K Maturity</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="txt_title">Example 5: VVIP $30K Maturity</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="txt_title">Example 5: VVIP $30K Maturity</span>
                        <?php
                        } else {
                        ?>
                            <span class="txt_title">Example 5: VVIP $30K Maturity</span>
                        <?php
                        }
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is $30,000 / 0.80</span> <span class="text_green">= 37,500 R-Shares</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is $30,000 / 0.80</span> <span class="text_green">= 37,500 R-Shares</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is $30,000 / 0.80</span> <span class="text_green">= 37,500 R-Shares</span>
                        <?php
                        } else {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is $30,000 / 0.80</span> <span class="text_green">= 37,500 R-Shares</span>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class="tbl_sprt_bottom">
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="txt_title">Example 6: CP2 Account or / Plus CP3 Account</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="txt_title">Example 6: CP2 Account or / Plus CP3 Account</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="txt_title">Example 6: CP2 Account or / Plus CP3 Account</span>
                        <?php
                        } else {
                        ?>
                            <span class="txt_title">Example 6: CP2 Account or / Plus CP3 Account</span>
                        <?php
                        }
                         ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is </span> <span class="text_green">Optional</span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is </span> <span class="text_green">Optional</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is </span> <span class="text_green">Optional</span>
                        <?php
                        } else {
                        ?>
                            <span class="text_green">SSS</span> <span class="text_red">is </span> <span class="text_green">Optional</span>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>

                </tbody>
                </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td class="tbl_sprt_bottom">

                </td>
            </tr>
            <tr>
                <td>
                    <?php
                        if ($culture == "cn") {
                        ?>
                            <span style="font-weight: bold; font-size: 16px;">致: 马胜金融集团法律部(LACD) </span>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <span style="font-weight: bold; font-size: 16px;">TO: The Maxim Trader Legal Office (LACD).</span>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <span style="font-weight: bold; font-size: 16px;">TO: The Maxim Trader Legal Office (LACD).</span>
                        <?php
                        } else {
                        ?>
                            <span style="font-weight: bold; font-size: 16px;">TO: The Maxim Trader Legal Office (LACD).</span>
                        <?php
                        }
                        ?>

                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="3" cellspacing="3">
                        <input type="hidden" id="roiRemainingMonth" name="roiRemainingMonth" value="<?php echo $roiRemainingMonth;?>">
                        <input type="hidden" id="roiPercentage" name="roiPercentage" value="<?php echo $roiPercentage;?>">
                        <tr><td class="text_bold" style="width: 150px;">User ID</td><td>:</td><td><?php echo $distributorDB->getDistributorCode();?></td></tr>
                        <tr><td class="text_bold">Member</td><td>:</td><td><?php echo $distributorDB->getFullName();?></td></tr>
                        <tr><td class="text_bold">Members Home address</td><td>:</td><td><?php echo $distributorDB->getAddress();?></td></tr>
                        <tr><td class="text_bold"></td><td></td><td><?php echo $distributorDB->getAddress2();?></td></tr>
                        <tr><td class="text_bold"></td><td></td><td><?php echo $distributorDB->getPostcode(). " ". $distributorDB->getCity(). " ". $distributorDB->getState();?></td></tr>
                        <tr><td class="text_bold">Country</td><td>:</td><td><?php echo $distributorDB->getCountry();?></td></tr>
                        <tr><td class="text_bold"><br></td></tr>
                        <tr><td class="text_bold">Members current email</td><td>:</td><td><?php echo $distributorDB->getEmail();?></td></tr>
                        <tr><td class="text_bold">Mobile</td><td>:</td><td><?php echo $distributorDB->getContact();?></td></tr>
                        <tr><td class="text_bold"><br></td></tr>
                        <tr><td class="text_bold">MT4 ID</td><td>:</td><td>
                            <select name="mt4Id" id="mt4Id">
                                <?php
                                if (count($mt4Ids) > 0) {
                                    echo "<option value=''>Please select MT4 ID</option>";
                                    foreach ($mt4Ids as $mt4Id) {
                                    ?>
                                    <option value="<?php echo $mt4Id?>"><?php echo $mt4Id;?></option>
                                    <?php
                                    }
                                } else {
                                ?>
                                    <option value="">(empty)</option>
                                <?php
                                }
                                ?>
                            </select>
                        </td></tr>
                        <tr><td class="text_bold">MT4 Balance<img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td><td>:</td><td id="td_mt4Balance"><?php echo number_format($mt4Balance,2);?></td></tr>
                        <tr><td class="text_bold">Contract date<img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td><td>:</td><td><?php echo $distributorDB->getActiveDateTime();?></td></tr>
                        <tr><td class="text_bold">CP2</td><td>:</td><td><?php echo number_format($cp2Balance,2);?></td></tr>
                        <tr><td class="text_bold">CP3</td><td>:</td><td><?php echo number_format($cp3Balance,2);?></td></tr>
                    </table>
                    <br>
                    <?php
                    if ($culture == "cn") {
                    ?>
                        <br>基于本人真实意愿且无任何利诱情况，本人在此正式申请18个月投资周期的豁免，并按照以下条款代替该18个月投资周期；
                    <?php
                    } else if ($culture == "kr") {
                    ?>
                        <br>Upon my OWN VOLITION and without any invitation to treat presented to me, I hereby apply for dispensation from my 18 month term obligation, and seek repudiation of the 18 Month  term of my Contract with Maxim Trader, on the following grounds;
                    <?php
                    } else if ($culture == "jp") {
                    ?>
                        <br>Upon my OWN VOLITION and without any invitation to treat presented to me, I hereby apply for dispensation from my 18 month term obligation, and seek repudiation of the 18 Month  term of my Contract with Maxim Trader, on the following grounds;
                    <?php
                    } else {
                    ?>
                        <br>Upon my OWN VOLITION and without any invitation to treat presented to me, I hereby apply for dispensation from my 18 month term obligation, and seek repudiation of the 18 Month  term of my Contract with Maxim Trader, on the following grounds;
                    <?php
                    }
                    ?>

                    <br>
                    <br>
                    <br>
                    <ol>
                        <?php
                        if ($culture == "cn") {
                        ?>
                            <li style="padding-bottom: 10px;">本人已于 [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] 完成18个月投资周期中的1个月。</li>
                            <li style="padding-bottom: 10px;">本人知晓该豁免申请时间不得早于2015.5.12日，且不得晚于2015.6.30日。任何此时间段之外的申请，自动无效。</li>
                            <li style="padding-bottom: 10px;">本人同意，于该豁免申请通过的条件下，将投资本金(等同于MT4交易账户余额) {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} 及剩余的月投资分红总额USD$ <input type="text" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>">} 全部用于以0.8美金一股的价格转换成R股；并相信公司尽快安排股权证的发放。</li>
                            <li style="padding-bottom: 10px;">本人同意，于该豁免申请通过的条件下，将CP2账户{USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} 或/和CP3账户{USD$ <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} 用于以0.8美金一股的价格转换成R股；并相信公司尽快安排股权证的发放。</li>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <li style="padding-bottom: 10px;">THAT as at [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] I have completed 1 months, of my 18 months term so far.</li>
                            <li style="padding-bottom: 10px;">THAT I file this request on a date, NO EARLIER THAN the 12th May 2015 and NO LATER THAN the 30th June 2015. Any application outside this  period is auto void.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to approval of this Dispensation Request, I herein consent to, and  instruct that, my principle sum of {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} as per the MT4 and balance Maxim account, plus any remaining ROI of {USD$ <input type="text" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>">} is to be swapped for, or applied to purchase ROGP Shares (R-Shares), at USD$.80 Cents each, and shall expect my certificate of R-Shares to be issued to me in due course.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for, or applied to purchase R-Share, USD$.80  each and shall expect my Certificate of R-Shares to be issued to me in due course.</li>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <li style="padding-bottom: 10px;">THAT as at [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] I have completed 1 months, of my 18 months term so far.</li>
                            <li style="padding-bottom: 10px;">THAT I file this request on a date, NO EARLIER THAN the 12th May 2015 and NO LATER THAN the 30th June 2015. Any application outside this  period is auto void.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to approval of this Dispensation Request, I herein consent to, and  instruct that, my principle sum of {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} as per the MT4 and balance Maxim account, plus any remaining ROI of {USD$ <input type="text" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>">} is to be swapped for, or applied to purchase ROGP Shares (R-Shares), at USD$.80 Cents each, and shall expect my certificate of R-Shares to be issued to me in due course.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for, or applied to purchase R-Share, USD$.80  each and shall expect my Certificate of R-Shares to be issued to me in due course.</li>
                        <?php
                        } else {
                        ?>
                            <li style="padding-bottom: 10px;">THAT as at [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] I have completed 1 months, of my 18 months term so far.</li>
                            <li style="padding-bottom: 10px;">THAT I file this request on a date, NO EARLIER THAN the 12th May 2015 and NO LATER THAN the 30th June 2015. Any application outside this  period is auto void.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to approval of this Dispensation Request, I herein consent to, and  instruct that, my principle sum of {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} as per the MT4 and balance Maxim account, plus any remaining ROI of {USD$ <input type="text" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>">} is to be swapped for, or applied to purchase ROGP Shares (R-Shares), at USD$.80 Cents each, and shall expect my certificate of R-Shares to be issued to me in due course.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for, or applied to purchase R-Share, USD$.80  each and shall expect my Certificate of R-Shares to be issued to me in due course.</li>
                        <?php
                        }
                        ?>
                    </ol>
                    <br>
                    <br>
                    <span class="text_red" id="spanFormula">$0K + ($0K x 0 months x 8%) = $0</span>
                    <br>
                    <br>
                    <span class="text_red" id="spanFormulaCp2">CP2 (Optional) = $0</span>
                    <br>
                    <span class="text_red" id="spanFormulaCp3">CP3 (Optional) = $0</span>
                    <br>
                    <br>
                    <span class="text_green">SSS</span> <span class="text_red" id="spanFormulaTotalAmount">is $0 / 0.80</span> <span class="text_green" id="spanFormulaRshare">= 0 R-Shares</span>
                    <br>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <table cellpadding="3" cellspacing="3">
                        <tr>
                            <td>DATED: This <?php echo " <b><u>" . date("d") . "</u></b> "?> day of <?php echo date("M")?> 2015 - SIGN</td>
                            <td>:</td>
                            <td><input type="text" name="txtSignature" id="txtSignature" value="" size="30"></td>
                        </tr>

                        <tr style="display: none;" id="tr_swapToRt">
                            <td>Swap to RT</td>
                            <td>:</td>
                            <td>
                                <select id="swapToRt" name="swapToRt">
                                    <option value="N">NO</option>
                                    <option value="Y">YES</option>
                                </select>
                            </td>
                        </tr>

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