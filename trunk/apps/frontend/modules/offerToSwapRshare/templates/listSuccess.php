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
.pbl_table td {
    padding: 4px !important;
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
            "txtSignature" : {
                required : true
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

    $(".buttonClass").button();
});

function calculateRshare() {
    var mt4Balance = parseFloat($('#txtMt4Balance').autoNumericGet());
    var remainingRoiAmount = parseFloat($('#txtRemainingRoiAmount').autoNumericGet());
    var convertedCp2 = parseFloat($('#convertedCp2').autoNumericGet());
    var convertedCp3 = parseFloat($('#convertedCp3').autoNumericGet());
    var roiRemainingMonth = $('#roiRemainingMonth').val();
    var roiPercentage = $('#roiPercentage').val();

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

    if (totalRshare >= 1) {
        spanFormula = "$" + mt4Balance + "K + ($" + mt4Balance + "K x " + roiRemainingMonth + " months x " + roiPercentage + "%) = $" + totalAmountConverted + "";
        spanFormulaCp2 = "CP2 (Optional) = $" + convertedCp2;
        spanFormulaCp3 = "CP3 (Optional) = $" + convertedCp3;
        spanFormulaTotalAmount = "is $" + totalAmountConvertedWithCp2Cp3 + " / 0.80";
        spanFormulaRshare = "= " + totalRshare + " R-Shares";

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
        <span class="txt_title"><?php echo __('APPLICATION FOR DISPENSATION 18 MONTH INVESTMENT TERM') ?> <?php echo __('APPROVAL STATUS') ?></span>
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
        <table class="pbl_table" cellpadding="3" cellspacing="3">
            <tbody>
            <tr class="pbl_header">
                <td><?php echo __('') ?></td>
                <td><?php echo __('Date') ?></td>
                <td><?php echo __('MT4 ID') ?></td>
                <td><?php echo __('Converted') ?></td>
                <td><?php echo __('Formula') ?></td>
                <td><?php echo __('Total Share Converted') ?></td>
                <td><?php echo __('Status') ?></td>
            </tr>
            <?php
            if (count($sssApplications) > 0) {
                $trStyle = "1";
                $idx = 1;

                foreach ($sssApplications as $sssApplication) {
                    if ($trStyle == "1") {
                        $trStyle = "0";
                    } else {
                        $trStyle = "1";
                    }
            ?>
            <tr class="row<?php echo $trStyle; ?>">
                <td valign="top" ><br><?php echo $idx++; ?></td>
                <td valign="top"><br><?php echo $sssApplication->getCreatedOn(); ?></td>
                <td valign="top"><br><?php echo $sssApplication->getMt4UserName(); ?></td>
                <td valign="top"><br><?php echo "MT4:<b>".number_format($sssApplication->getMt4Balance(),2)."</b><br>CP2:<b>".number_format($sssApplication->getCp2Balance(),2)."</b><br>CP3:<b>".number_format($sssApplication->getCp3Balance(),2); ?></b></td>
                <td valign="top"><br><?php
                        $totalAmountConverted = $sssApplication->getMt4Balance() + ($sssApplication->getMt4Balance() * $sssApplication->getRoiRemainingMonth() * $sssApplication->getRoiPercentage() / 100);
                        $totalAmountConvertedWithCp2Cp3 = $totalAmountConverted + $sssApplication->getCp2Balance() + $sssApplication->getCp3Balance();
                        $totalAmountConvertedWithCp2Cp3 = round($totalAmountConvertedWithCp2Cp3);
                        $totalRshare = $totalAmountConvertedWithCp2Cp3 / 0.8;
                        $totalRshare = round($totalRshare);
                    echo "$".number_format($sssApplication->getMt4Balance(),2)."K + ($".number_format($sssApplication->getMt4Balance(),2)."K x ".$sssApplication->getRoiRemainingMonth()." months x ". $sssApplication->getRoiPercentage(). "%) = <b>$" . number_format($totalAmountConverted,2)."</b>";
                    echo "<br><br>CP2 (Optional) = <b>$" . number_format($sssApplication->getCp2Balance(),2)."</b>";
                    echo "<br>CP3 (Optional) = <b>$" . number_format($sssApplication->getCp3Balance(),2)."</b>";
                    echo "<br><br>is $" .number_format($totalAmountConvertedWithCp2Cp3,2). " / 0.80 = <b>" . number_format($totalRshare,2) . "</b> R-Shares";
                    ?>
                    <br>
                </td>
                <td valign="top" align="right"><br><?php echo number_format($sssApplication->getTotalShareConverted(),2); ?></td>
                <td valign="top"><br><?php if ($sssApplication->getStatusCode() == Globals::STATUS_SSS_PAIRING_ASSS) { echo "COOLING-OFF PERIOD"; } else { echo $sssApplication->getStatusCode(); } ?>
                <?php
                    /*if ($sssApplication->getSwapType() == "ASSS" && ($sssApplication->getStatusCode() == Globals::STATUS_SSS_PAIRING_ASSS || $sssApplication->getStatusCode() == Globals::STATUS_SSS_PENDING)) {
                        echo "<br><br><span style='color:blue'>Client Action: ".$sssApplication->getClientAction()."</span>";
                    }*/
                ?>
                </td>
            </tr>
            <?php
                    $closeDecline = true;
                    if ($closeDecline == false) {
                        if ($sssApplication->getSwapType() == "ASSS" && ($sssApplication->getStatusCode() == Globals::STATUS_SSS_PAIRING_ASSS || $sssApplication->getStatusCode() == Globals::STATUS_SSS_PENDING)) {
            ?>
                        <tr class="row<?php echo $trStyle; ?>" align="right">
                            <td colspan="7">
                                <a href="<?php echo url_for("/offerToSwapRshare/autoSwapMemberAction?doAction=confirm&id=".$sssApplication->getSssId());?>" class="buttonClass"><?php echo __('Confirm'); ?></a>
                                <a href="<?php echo url_for("/offerToSwapRshare/autoSwapMemberAction?doAction=decline&id=".$sssApplication->getSssId());?>" class="buttonClass"><?php echo __('Decline'); ?></a>
                            </td>
                        </tr>
            <?php
                        }
                    }
                }
            } else {
            ?>
            <tr class='odd' align='center'><td colspan='7'><?php echo __('No data available in table'); ?></td></tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </td>
</tr>
<tr>
<td>
</td>
</tr>
</tbody>
</table>