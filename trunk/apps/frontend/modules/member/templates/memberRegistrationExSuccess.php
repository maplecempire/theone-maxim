<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
$(function() {
    $("#topupForm").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            "privateInvestmentAgreement" : {
                required : "#rdoFxgold:checked"
            }
            /*"mteAgreement" : {
                required : "#rdoMte:checked"
            }*/
            /*"transactionPassword" : {
                required : true
                , remote: "/member/verifyTransactionPassword"
            },
            "privateInvestmentAgreement" : {
                required : true
            }*/
        },
        submitHandler: function(form) {
            var epoint = $('#cp1Paid').autoNumericGet();
            var cp2cp3 = $('#cp2cp3Paid').autoNumericGet();
            var epointPackageNeeded = $('#epointNeeded').autoNumericGet();

            var totalPoint = parseFloat(epoint) + parseFloat(cp2cp3);

            if (parseFloat(totalPoint) < parseFloat(epointPackageNeeded)) {
                error("<?php echo __("In-sufficient fund to purchase package.");?>");
            } else if (parseFloat(totalPoint) > parseFloat(epointPackageNeeded)) {
                error("<?php echo __("The total funds is not match with package price.");?>");
            } else {
                waiting();
                form.submit();
            }
            /*else {
                if ($.trim($("#transactionPassword").val()) == "") {
                    error("Security Password is empty");
                    $("#transactionPassword").focus();
                    return false;
                }
                waiting();
                form.submit();
            }*/
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
        var sure = confirm("<?php echo __('Are you sure want to purchase this package ')?>" + epointNeeded + "?");
        if (sure) {
            $('#epointNeeded').val(epointNeeded);
            $('#pid').val(pid);
            $("#topupForm").submit();
        }
    });
    $("#btnSubmit").button({
        icons: {
            primary: "ui-icon-circle-check"
        }
    }).click(function(event) {
        event.preventDefault();

        if($('input[name=pid]:checked').length <= 0) {
            alert("Please select of the package")
        } else {
            var epointNeeded = $('input[name=pid]:checked').attr("ref");
            var pid = $('input[name=pid]:checked').attr("pid");
            if (pid >= <?php echo Globals::MAX_PACKAGE_ID?>) {
                epointNeeded = $("#specialPackageId option:selected").attr("price");
                pid = $("#specialPackageId").val();
            }
            var sure = confirm("<?php echo __('Are you sure want to purchase this package ')?>" + epointNeeded + "?");
            if (sure) {
                $('#epointNeeded').val(epointNeeded);
                //$('#pid').val(pid);
                $("#topupForm").submit();
            }
        }
    });

    $(".radio_class").click(function(event){
        var packagePrice = $(this).attr("ref");
        var pid = $(this).attr("pid");
        if (pid >= <?php echo Globals::MAX_PACKAGE_ID?>) {
            packagePrice = $("#specialPackageId option:selected").attr("price");
            pid = $("#specialPackageId").val();
        }
        var cp2 = $('#topup_cp2Avail').autoNumericGet();
        var cp3 = $('#topup_cp3Avail').autoNumericGet();
        var optionStr = "";
        for (var i = 0; i <= (parseFloat(packagePrice) / 2); i += 100) {
            if ($("#cp2cp3PaymentMethod").val() == "CP2") {
                if (i >= cp2) {
                    break;
                }
            } else if ($("#cp2cp3PaymentMethod").val() == "CP2") {
                if (i >= cp3) {
                    break;
                }
            }

            $('#hiddenTextInput').autoNumericSet(i, {mDec:0});
            var result = $("#hiddenTextInput").val();
            optionStr += "<option value='" + i + "'>" + result + "</option>";
        }
        $("#cp2cp3Paid").html(optionStr);
    });
    $("#rdoFxgold").click(function(event){
        $(".tdFxGold").show();
        $(".tdMte").hide();
    });
    $("#rdoMte").click(function(event){
        $(".tdFxGold").hide();
        $(".tdMte").show();
    });
    $("#cp2cp3Paid, #cp1Paid").change(function(event){
        var epoint = $('#cp1Paid').autoNumericGet();
        var cp2cp3 = $('#cp2cp3Paid').autoNumericGet();

        var totalPoint = parseFloat(epoint) + parseFloat(cp2cp3);
        $('#hiddenTextInput').autoNumericSet(totalPoint, {mDec:0});
        var result = $("#hiddenTextInput").val();
        $("#totalFunds").val(result);
    });
});
</script>
<input type="hidden" id="hiddenTextInput">
<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('Member Registration') ?></span></td>
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
            <form action="/member/memberRegistration2" id="topupForm" name="topupForm" method="post">
            <!--<input type="hidden" id="pid" name="pid" value=""/>-->
            <input type="hidden" id="epointNeeded" value="0"/>

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
                    <th colspan="2"><?php echo __('Package Purchase') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP1 Account') ?></td>
                    <td><input type="text" style="text-align: right" readonly="readonly" id="topup_pointAvail" size="20px" value="<?php echo number_format($pointAvailable, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP2 Account') ?></td>
                    <td><input type="text" style="text-align: right" readonly="readonly" id="topup_cp2Avail" size="20px" value="<?php echo number_format($cp2Available, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Account') ?></td>
                    <td><input type="text" style="text-align: right" readonly="readonly" id="topup_cp3Avail" size="20px" value="<?php echo number_format($cp3Available, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="4">
                        <table class="pbl_table" border="1" cellspacing="0">
                            <tbody>
                            <tr class="pbl_header">
                                <td valign="middle"><?php echo __('Membership') ?></td>
                                <td valign="middle"><?php echo __('Price') ?>(<?php echo $systemCurrency; ?>)</td>
                            </tr>

                            <?php
                                if (count($packageDBs) > 0) {
                                    $trStyle = "1";
                                    $combo = "<select name='specialPackageId' id='specialPackageId'>";
                                    foreach ($packageDBs as $packageDB) {
                                        if ($packageDB->getPackageId() >= Globals::MAX_PACKAGE_ID) {
                                            $combo .= "<option value='".$packageDB->getPackageId()."' price='".$packageDB->getPrice()."'>".number_format($packageDB->getPrice(), 0)."</option>";
                                        }
                                    }
                                    $combo .= "</select>";

                                    $defaultChecked = " checked='checked'";
                                    $defaultChecked = "";
                                    foreach ($packageDBs as $packageDB) {
                                        if ($packageDB->getPackageId() > Globals::MAX_PACKAGE_ID) {
                                            continue;
                                        }
                                        if ($trStyle == "1") {
                                            $trStyle = "0";
                                        } else {
                                            $trStyle = "1";
                                        }

                                        $packagePrice = number_format($packageDB->getPrice(), 2);
                                        if ($packageDB->getPackageId() == Globals::MAX_PACKAGE_ID) {
                                            $packagePrice = $combo;
                                        }
                                        echo "<tr class='row" . $trStyle . "'>
                                                <td align='left'>&nbsp;&nbsp;
                                                <input type='radio' name='pid' class='radio_class' value='".$packageDB->getPackageId()."' ref='".$packageDB->getPrice()."' ".$defaultChecked.">&nbsp;&nbsp;". __($packageDB->getPackageName()) . "</td>
                                                <td align='center'>" . $packagePrice . "</td>
                                            </tr>";

                                        /*if ($defaultChecked != "") {
                                            $defaultChecked = "";
                                            $packagePriceSelected = $packageDB->getPrice();
                                        }*/
                                    }
                                } else {
                                    echo "<tr class='odd' align='center'><td colspan='2'>" . __('No data available in table') . "</td></tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Paid by CP1') ?></td>
                    <td>
                        <select id="cp1Paid" name="cp1Paid" style="width:100px; text-align: right">
                    <?php
                        for ($i = 0; $i <= $pointAvailable; $i += 100) {
                            echo "<option value='".$i."'>".number_format($i,0)."</option>";
                        }
                    ?>
                        </select>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><select id="cp2cp3PaymentMethod" name="cp2cp3PaymentMethod" style="width:100px;">
                            <option value="CP2"><?php echo __('Paid by CP2') ?></option>
                            <option value="CP3"><?php echo __('Paid by CP3') ?></option>
                        </select>
                    </td>
                    <td>
                        <select id="cp2cp3Paid" name="cp2cp3Paid" style="width:100px; text-align: right">
                            <option value='0'>0</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Total') ?></td>
                    <td>
                        <input type="text" id="totalFunds" style="text-align: right;" value="0">
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even" style="display: none">
                    <td>&nbsp;</td>
                    <td colspan="5">
                        &nbsp;<input name="productCode" type="radio" value="fxgold" id="rdoFxgold" checked="checked">&nbsp; <label for="rdoFxgold">FX Gold A</label>
                        <span style="display: none">&nbsp;<input name="productCode" type="radio" value="mte" id="rdoMte">&nbsp; <label for="rdoMte">MaximTrade™ Executor</label></span>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="5">
                        <p><?php echo __('Below is the contractural terms and agreements that you are bound by as a client of MaximTrader for signing up the package above. We recommend that you take the time to read each of them carefully.') ?></p>
                        <br>
                        <p><?php echo __('Please check the boxes below to acknowledge your acceptance, agreement and understanding of the terms and agreements.') ?></p>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even tdFxGold">
                    <td>&nbsp;</td>
                    <td><input type="checkbox" class="checkbox" id="privateInvestmentAgreement" name="privateInvestmentAgreement">
                        <label for="privateInvestmentAgreement"><?php echo __('Private Investment Agreement') ?></label></td>
                    <td colspan="3">
                        <a target="_blank" href="/download/privateInvestmentAgreement"><?php echo __('Download PDF') ?></a>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <!--<tr class="tbl_form_row_odd tdFxGold">
                    <td>&nbsp;</td>
                    <td colspan="5">
                        <br>
                        <p><?php /*echo __('Please sign and send it to') */?> <a href="mailto:managedfund@maximtrader.com">managedfund@maximtrader.com</a>.</p>
                    </td>
                    <td>&nbsp;</td>
                </tr>-->

                <tr class="tbl_form_row_even tdMte" style="display: none">
                    <td>&nbsp;</td>
                    <td><input type="checkbox" class="checkbox" id="mteAgreement" name="mteAgreement">
                        <label for="mteAgreement">MTE <?php echo __('Agreement') ?></label></td>
                    <td colspan="3">
                        <a target="_blank" href="/download/mteAgreement"><?php echo __('Download MTE Agreement') ?></a>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_odd tdMte" style="display: none">
                    <td>&nbsp;</td>
                    <td colspan="5">
                        <br>
                        <p><?php echo __('Please sign and send it to') ?> <a href="mailto:support@maximtrader.com">support@maximtrader.com</a>.</p>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="5" align="right">
                        <button id="btnSubmit"><?php echo __("Submit"); ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <!--<tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><input type="checkbox" class="checkbox" id="privateInvestmentAgreement" name="privateInvestmentAgreement">
                        <label for="privateInvestmentAgreement">Private Investment Agreement</label></td>
                    <td colspan="4">
                        <a target="_blank" href="/download/privateInvestmentAgreement">Download Agreement (67 KB Doc)</a>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php /*echo __('Security Password'); */?></td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>-->

                </tbody>
            </table>

            </form>
        </td>
    </tr>
    </tbody>
</table>