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

            if ($("#topup_pointAvail").val() == 0 || $("#topup_pointAvail").val() == "" || parseFloat(epoint) < parseFloat(epointPackageNeeded)) {
                error("In-sufficient fund to upgrade package.");
            } else {
                waiting();
                form.submit();
            }/*else {
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
        $('#epointNeeded').val(epointNeeded);
        $('#pid').val(pid);
        $("#topupForm").submit();
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
                    <td><?php echo __('CP2 Account') ?></td>
                    <td><input type="text" readonly="readonly" id="topup_pointAvail" size="20px" value="<?php echo number_format($pointAvailable, 2); ?>"/></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="4">
                        <table class="pbl_table" border="1" cellspacing="0">
                            <tbody>
                            <tr class="pbl_header">
                                <td valign="middle">Join Package</td>
                                <td valign="middle">Membership</td>
                                <td valign="middle">Price(<?php echo $systemCurrency; ?>)</td>
                            </tr>

                            <?php
                                if (count($packageDBs) > 0) {
                                    $trStyle = "1";
                                    foreach ($packageDBs as $packageDB) {
                                        if ($trStyle == "1") {
                                            $trStyle = "0";
                                        } else {
                                            $trStyle = "1";
                                        }

                                echo "<tr class='row" . $trStyle . "'>
                                    <td align='center'>" . link_to(__('Buy'), 'member/doPurchasePackage?packageId=' . $packageDB->getPackageId(), array(
                                               'class' => 'activeLink',
                                               'ref' => $packageDB->getPrice(),
                                               'pid' => $packageDB->getPackageId(),
                                          )) . "</td>
                                    <td align='center'>" . $packageDB->getPackageName() . "</td>
                                    <td align='center'>" . $packageDB->getPrice() . "</td>
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

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="5">
                        <p>Below is the contractural Private Investment Management Agreement that you are bound by signing up the package above.
                           We recommend that you take the time to read each of them carefully.</p>

                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                    </td>
                    <td colspan="4">
                        <a target="_blank" href="/download/privateInvestmentAgreement">Download Private Investment Agreement (67 KB Doc)</a>
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