<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
$(function() {
    <?php if ($hasFmcCharges) { ?>
    $("#specialPackageId").change(function() {
        var price = parseInt($("option:selected", this).attr("price"));
        $("#formattedValue").autoNumericSet(price * 10 / 100, {mDec: 0});

        var unformmattedPrice = parseFloat($("#formattedValue").autoNumericGet());
        $(this).parent().prev(".priceCharges").html($("#formattedValue").val());

        var totalPrice = price + parseFloat(unformmattedPrice);
        $("#formattedValue").autoNumericSet(totalPrice);
        $(this).parent().next(".priceTotal").html($("#formattedValue").val());
    });
    <?php } ?>
    $("#topupForm").validate({
        messages : {
            transactionPassword: {
                remote: "<?php echo __("Security Password is not valid")?>"
            }
        },
        rules : {
            "privateInvestmentAgreement" : {
                required : "#rdoFxgold:checked"
            },
            "mteAgreement" : {
                required : "#rdoMte:checked"
            }
            /*"transactionPassword" : {
                required : true
                , remote: "/member/verifyTransactionPassword"
            },
            "privateInvestmentAgreement" : {
                required : true
            }*/
        },
        submitHandler: function(form) {
            var epoint = $('#topup_pointAvail').autoNumericGet();
            var cp4 = $('#topup_cp4Avail').autoNumericGet();
            var epointPackageNeeded = $('#epointNeeded').autoNumericGet();

            if ($("#payBy").val() == "CP1") {
                if ($("#topup_pointAvail").val() == 0 || $("#topup_pointAvail").val() == "" || parseFloat(epoint) < parseFloat(epointPackageNeeded)) {
                    error("<?php echo __("In-sufficient CP1 to purchase package.");?>");
                    return false;
                }
            }
            if ($("#payBy").val() == "CP4") {
                if ($("#topup_cp4Avail").val() == 0 || $("#topup_cp4Avail").val() == "" || parseFloat(cp4) < parseFloat(epointPackageNeeded)) {
                    error("<?php echo __("In-sufficient CP4 to purchase package.");?>");
                    return false;
                }
            }
            waiting();
            form.submit();
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
        if (<?php echo ($hasFmcCharges ? "true" : "false") ?>) {
            epointNeeded = parseInt(epointNeeded, 10);
            epointNeeded += (epointNeeded * 10 / 100);
        }
        var sure = confirm("<?php echo __('Are you sure want to purchase this package ')?>" + epointNeeded + "?");
        if (sure) {
            $('#epointNeeded').val(epointNeeded);
            $('#pid').val(pid);
            $("#topupForm").submit();
        }
    });

    $("#rdoFxgold").click(function(event){
        $(".tdFxGold").show();
        $(".tdMte").hide();
    });
    $("#rdoMte").click(function(event){
        $(".tdFxGold").hide();
        $(".tdMte").show();
    });
});
</script>

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
            <input type="hidden" id="formattedValue">
            <input type="hidden" id="pid" name="pid" value=""/>
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
                    <td><input type="text" readonly="readonly" id="topup_pointAvail" size="20px" value="<?php echo number_format($pointAvailable, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP4 Account') ?></td>
                    <td><input type="text" readonly="readonly" id="topup_cp4Avail" size="20px" value="<?php echo number_format($cp4Available, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="4">
                        <?php if ($hasFmcCharges) { ?>
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;" class="ui-state-error ui-corner-all">
                                <p style="margin: 10px">
                                    <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo __('Total includes 10% of 18 months fund management cost (FMC).') ?></strong>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                        <table class="pbl_table" border="1" cellspacing="0">
                            <tbody>
                            <tr class="pbl_header">
                                <td valign="middle"><?php echo __('Join Package') ?></td>
                                <td valign="middle"><?php echo __('Membership') ?></td>
                                <?php if ($hasFmcCharges) { ?>
                                <td valign="middle"><?php echo __('Fund Management Cost (FMC)') ?></td>
                                <?php } ?>
                                <td valign="middle"><?php echo __('Price') ?>(<?php echo $systemCurrency; ?>)</td>
                                <?php if ($hasFmcCharges) { ?>
                                <td valign="middle"><?php echo __('Total') ?></td>
                                <?php } ?>
                            </tr>

                            <?php
                                if (count($packageDBs) > 0) {
                                    if ($cp1Enable == true) {
                                        $combo = "<select name='specialPackageId' id='specialPackageId' style='text-align: right;'>";
                                        $packageDBTemp = null;
                                        foreach ($packageDBs as $packageDB) {
                                            $combo .= "<option value='".$packageDB->getPackageId()."' price='".$packageDB->getPrice()."'>".number_format($packageDB->getPrice(), 0)."</option>";
                                            $packageDBTemp = $packageDB;
                                        }
                                        $combo .= "</select>";

                                        echo "<tr class='row" . $trStyle . "'>
                                            <td align='center'>" . link_to(__('Sign up'), 'member/doPurchasePackage?packageId=' . $packageDBTemp->getPackageId(), array(
                                                                                                                                                                   'class' => 'activeLink',
                                                                                                                                                                   'ref' => $packageDBTemp->getPrice(),
                                                                                                                                                                   'pid' => $packageDBTemp->getPackageId(),
                                                                                                                                                              )) . "</td>
                                            <td align='center'>Platinum / VIP / VVIP</td>
                                            <td align='center'>" . $combo . "</td>
                                        </tr>";
                                    } else {
                                        $trStyle = "1";
                                        $combo = "<select name='specialPackageId' id='specialPackageId'>";
                                        foreach ($packageDBs as $packageDB) {
                                            if ($packageDB->getPackageId() >= Globals::MAX_PACKAGE_ID) {
                                                $combo .= "<option value='".$packageDB->getPackageId()."' price='".$packageDB->getPrice()."'>".number_format($packageDB->getPrice(), 0)."</option>";
                                            }
                                        }
                                        $combo .= "</select>";

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
                                                <td align='center'>" . link_to(__('Sign up'), 'member/doPurchasePackage?packageId=' . $packageDB->getPackageId(), array(
                                                                                                                                                                       'class' => 'activeLink',
                                                                                                                                                                       'ref' => $packageDB->getPrice(),
                                                                                                                                                                       'pid' => $packageDB->getPackageId(),
                                                                                                                                                                  )) . "</td>
                                                <td align='center'>" . __($packageDB->getPackageName()) . "</td>";
                                            if ($hasFmcCharges) {
                                                echo "<td align='center' class='priceCharges'>".number_format($packageDB->getPrice() * 10 / 100)."</td>";
                                            }
                                            echo "<td align='center'>" . $packagePrice . "</td>";
                                            if ($hasFmcCharges) {
                                                echo "<td align='center' class='priceTotal'>".number_format($packageDB->getPrice() + ($packageDB->getPrice() * 10 / 100), 2)."</td>";
                                            }
                                            echo "</tr>";
                                        }
                                    }
                                } else {
                                    echo "<tr class='odd' align='center'><td colspan='3'>" . __('No data available in table') . "</td></tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('Pay by') ?></td>
                    <td>
                        <select name="payBy" id="payBy">
                            <?php
                            if ($cp1Enable == true) {
                            ?>
                            <option value="CP1">CP1</option>
                            <?php
                            }
                            ?>
                            <option value="CP4">CP4</option>
                        </select>
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