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
            var epointPackageNeeded = $('#epointNeeded').autoNumericGet();

            <?php if ($sf_user->getAttribute(Globals::SESSION_MASTER_LOGIN) == Globals::TRUE && $sf_user->getAttribute(Globals::SESSION_DISTID) == Globals::LOAN_ACCOUNT_CREATOR_DIST_ID) {

            } else {?>
                if ($("#topup_pointAvail").val() == 0 || $("#topup_pointAvail").val() == "" || parseFloat(epoint) < parseFloat(epointPackageNeeded)) {
                    error("In-sufficient fund to purchase package.");
                    return false;
                }
            <?php } ?>
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

        $('#epointNeeded').val(epointNeeded);
        $('#pid').val(pid);
        $("#topupForm").submit();
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
<form action="/member/purchasePackageViaTree2" id="topupForm" name="topupForm" method="post">
    <input type="hidden" id="pid" name="pid" value=""/>
    <input type="hidden" id="epointNeeded" value="0"/>
    <input type="hidden" name="uplineDistCode" id="uplineDistCode" value="<?php echo $uplineDistCode;?>"/>
    <input type="hidden" name="position" id="position" value="<?php echo $position;?>"/>

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

        <tr>
            <td colspan="4">
                <table class="pbl_table" border="1" cellspacing="0">
                    <tbody>
                    <tr class="pbl_header">
                        <td valign="middle"><?php echo __('Join Package') ?></td>
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
                                    <td align='center'>" . __($packageDB->getPackageName()) . "</td>
                                    <td align='center'>" . $packagePrice . "</td>
                                </tr>";
                                    }
                                } else {
                                    echo "<tr class='odd' align='center'><td colspan='3'>" . __('No data available in table') . "</td></tr>";
                                }
                    ?>
                    </tbody>
                </table>
            </td>
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

                </tbody>
            </table>

            </form>
        </td>
    </tr>
    </tbody>
</table>