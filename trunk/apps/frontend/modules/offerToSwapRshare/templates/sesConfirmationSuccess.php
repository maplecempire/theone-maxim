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

    if (isRt == "Y") {
        roiRemainingMonth = 0;
    }

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
        <form id="sssForm" method="post" action="/offerToSwapRshare/doSave">
        <table cellpadding="3" cellspacing="5">
            <tbody>
            <tr>
                <td><br></td>
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
                            <input type="text" readonly="readonly" id="mt4Id" name="mt4Id" value="<?php echo $mt4Id;?>">
                        </td></tr>
                        <tr><td class="text_bold"><?php echo __('MT4 Balance');?><img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td><td>:</td><td id="td_mt4Balance"><?php echo number_format($mt4Balance,2);?></td></tr>
                        <tr><td class="text_bold"><?php echo __('Contract date');?><img src="/images/common/indicator.gif" class="indicator" style="display: none;"></td><td>:</td><td><?php echo $distributorDB->getActiveDateTime();?></td></tr>
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
                            <li style="padding-bottom: 10px;">本人同意，于该豁免申请通过的条件下，将投资本金(等同于MT4交易账户余额) {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} <input type="text" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>">} 全部用于转换成RT。</li>
                            <li style="padding-bottom: 10px;">本人同意，于该豁免申请通过的条件下，将CP2账户{USD$ <input type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>" readonly="readonly">} 或/和CP3账户{USD$ <input type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>" readonly="readonly">} 转换成RT。</li>
                        <?php
                        } else if ($culture == "kr") {
                        ?>
                            <li style="padding-bottom: 10px;">THAT as at [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] I have completed 1 months, of my 18 months term so far.</li>
                            <li style="padding-bottom: 10px;">THAT I file this request on a date, NO EARLIER THAN the 12th May 2015 and NO LATER THAN the 30th June 2015. Any application outside this  period is auto void.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to approval of this Dispensation Request, I herein consent to, and  instruct that, my principle sum of {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} as per the MT4 and balance Maxim account<input type="hidden" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>"> is to be swapped for RT.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input readonly="readonly" type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input readonly="readonly" type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for RT.</li>
                        <?php
                        } else if ($culture == "jp") {
                        ?>
                            <li style="padding-bottom: 10px;">THAT as at [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] I have completed 1 months, of my 18 months term so far.</li>
                            <li style="padding-bottom: 10px;">THAT I file this request on a date, NO EARLIER THAN the 12th May 2015 and NO LATER THAN the 30th June 2015. Any application outside this  period is auto void.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to approval of this Dispensation Request, I herein consent to, and  instruct that, my principle sum of {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} as per the MT4 and balance Maxim account<input type="hidden" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>"> is to be swapped for RT.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input readonly="readonly" type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input readonly="readonly" type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for RT.</li>
                        <?php
                        } else {
                        ?>
                            <li style="padding-bottom: 10px;">THAT as at [<?php echo " <b><u>" . date("d F Y") . "</u></b> "?>] I have completed 1 months, of my 18 months term so far.</li>
                            <li style="padding-bottom: 10px;">THAT I file this request on a date, NO EARLIER THAN the 12th May 2015 and NO LATER THAN the 30th June 2015. Any application outside this  period is auto void.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to approval of this Dispensation Request, I herein consent to, and  instruct that, my principle sum of {USD$ <input type="text" readonly="readonly" style="text-align: right;" id="txtMt4Balance" value="<?php echo number_format($mt4Balance,2);?>">} as per the MT4 and balance Maxim account<input type="hidden" id="txtRemainingRoiAmount" style="text-align: right;" readonly="readonly" value="<?php echo number_format($remainingRoiAmount,2);?>"> is to be swapped for RT.</li>
                            <li style="padding-bottom: 10px;">THAT subsequent to the same approval of this Dispensation Request, I also herein consent to, and instruct, that my CP2 account {USD$ <input readonly="readonly" type="text" id="convertedCp2" name="convertedCp2" style="text-align: right;" value="<?php echo number_format($cp2Balance,2);?>">} or/plus Cp3 account {USD <input readonly="readonly" type="text" id="convertedCp3" style="text-align: right;" name="convertedCp3" value="<?php echo number_format($cp3Balance,2);?>">} is to be swapped for RT.</li>
                        <?php
                        }
                        ?>
                    </ol>
                    <br>
                    <br>
                    <span class="text_red" id="spanFormula">$0K = $0</span>
                    <br>
                    <br>
                    <span class="text_red" id="spanFormulaCp2">CP2 (<?php echo __('Optional');?>) = $0</span>
                    <br>
                    <span class="text_red" id="spanFormulaCp3">CP3 (<?php echo __('Optional');?>) = $0</span>
                    <br>
                    <br>
                    <span class="text_green">SES</span> <span class="text_green" id="spanFormulaRshare">= 0 <?php echo __('RT');?></span>
                    <br>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <table cellpadding="3" cellspacing="3">
                        <tr>
                            <?php
                            if ($culture == "cn") {
                            ?>
                                <td>日期: <?php echo " <b><u>" . date("d") . "</u></b> "?>日 <?php echo __(date("F"))?> 2015 - 签名</td>
                            <?php
                            } else if ($culture == "kr") {
                            ?>
                                <td>DATED: This <?php echo " <b><u>" . date("d") . "</u></b> "?> day of <?php echo date("F")?> 2015 - SIGN</td>
                            <?php
                            } else if ($culture == "jp") {
                            ?>
                                <td>DATED: This <?php echo " <b><u>" . date("d") . "</u></b> "?> day of <?php echo date("F")?> 2015 - SIGN</td>
                            <?php
                            } else {
                            ?>
                                <td>DATED: This <?php echo " <b><u>" . date("d") . "</u></b> "?> day of <?php echo date("F")?> 2015 - SIGN</td>
                            <?php
                            }
                            ?>
                            <td>:</td>
                            <td><input type="text" id="txtSignature" value="<?php echo $signature; ?>" size="30" readonly="readonly"></td>
                        </tr>
                        <tr style="display: none;" id="tr_swapToRt">
                            <td>Swap to RT</td>
                            <td>:</td>
                            <td>
                                <input type="text" size="30" readonly="readonly"  id="swapToRtDisplay" value="<?php if ($swapToRt == "Y") { echo "YES"; } else { echo "NO"; } ;?>">
                                <input type="hidden" size="30" readonly="readonly"  id="swapToRt" name="swapToRt" value="<?php echo $swapToRt;?>">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>

            <tr>
                <td align="right">
                    <?php if (count($mt4Ids) > 0) { ?>
                    <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    <?php } ?>
                </td>
            </tr>
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