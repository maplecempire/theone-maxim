<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    var moneytracUsername = "<?php echo $distributorDB->getMoneytracUsername()?>";
    var moneytracCustomerId = "<?php echo $distributorDB->getMoneytracCustomerId()?>";
    $(function() {
        $("#cbo_cp3Amount").change(function(){
            <?php if ($distributorDB->getCloseAccount() == "Y") { ?>
            var ecashFinal = $("#cbo_cp3Amount").autoNumericGet() - 30;
            <?php } else { ?>
            var ecashFinal = $("#cbo_cp3Amount").val() - 30;
            <?php } ?>
            $("#ecashFinal").autoNumericSet(ecashFinal);
        }).change();
            $("#withdrawForm").validate({
                messages : {
                    transactionPassword: {
                        remote: "<?php echo __("Security Password is not valid")?>"
                    }
                },
                rules : {
                    "bankInTo" : {
                        required : true
                    },
                    "transactionPassword" : {
                        required : true
                        , remote: "/member/verifyTransactionPassword"
                    }
                },
                submitHandler: function(form) {
                    if ($("#bankInTo").val() == "<?php echo Globals::WITHDRAWAL_IACCOUNT?>" && $("#iaccountChecking").val() == "Y") {
                        error("Please Apply for i-Account now before submit.");
                    } else {
                        waiting();
                        var ecashBalance = $('#ecashBalance').autoNumericGet();
                        var monthlyPerformanceReturnAmount = parseFloat($('#monthlyPerformanceReturnAmountDisplay').autoNumericGet());
                    <?php if ($distributorDB->getCloseAccount() == "Y") { ?>
                        var withdrawAmount = parseFloat($("#cbo_cp3Amount").autoNumericGet());
                        <?php } else { ?>
                        var withdrawAmount = parseFloat($("#cbo_cp3Amount").val());
                        <?php } ?>
                        if (withdrawAmount <= 30) {
                            error("<?php echo __("%1% must greater than %2%.", array("%1%" => __("CP3 Withdrawal Amount"), "%2%" => "30.00")) ?>");
                            return false;
                        }
                        if (withdrawAmount > monthlyPerformanceReturnAmount) {
                            error("<?php echo __("Maximum withdrawal is limited to your monthly Performance Return amount") ?>");
                            return false;
                        }
                        if (withdrawAmount > parseFloat(ecashBalance)) {
                            error("<?php echo __("In-sufficient CP3") ?>");
                            return false;
                        }
                        if ($("#bankInTo").val() == "<?php echo Globals::WITHDRAWAL_MONEYTRAC?>" && moneytracCustomerId == "") {
                            error("<?php echo __("Please update Money Trac Information in User Profile.") ?>");
                            return false;
                        }

                    <?php if ($distributorDB->getCloseAccount() == "Y") { ?>
                        $("#cbo_cp3Amount").val(withdrawAmount);
                        <?php } ?>
                        form.submit();
                    }
                }
            });

        $("#bankInTo").change(function(){
            if ($("#bankInTo").val() == "<?php echo Globals::WITHDRAWAL_MONEYTRAC?>") {
                $("#moneyTracNote").show(500);
                $("#moneyTracNote2").show(500);
            } else if ($("#bankInTo").val() == "<?php echo Globals::WITHDRAWAL_IACCOUNT?>" && $("#iaccountChecking").val() == "Y") {
                error("Please Apply for i-Account now.");
            } else {
                $("#moneyTracNote").hide(500);
                $("#moneyTracNote2").hide(500);
            }
        }).trigger("change");

        <?php if ($distributorDB->getCloseAccount() == "Y") { ?>
        $('#cbo_cp3Amount').autoNumeric({
            mDec: 2
        });
        <?php } ?>
    });
</script>

<div class="ewallet_li">
	<a target="_self" class="navcontainer" href="/member/mt4Withdrawal" style="color: rgb(0, 93, 154);">
        <?php echo __('MT4 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/ecashWithdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP2 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/cp3Withdrawal");?>" style="color: rgb(134, 197, 51);">
        <?php echo __('CP3 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/maturityWithdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP2 Withdrawal (Maturity)'); ?>
    </a>
    &nbsp;&nbsp;
</div>
<?php
$toApplyIaccount = "N";
if ($distributorDB->getIaccount() == "") {
    $toApplyIaccount = "Y";
}
?>
<input type="hidden" id="iaccountChecking" value="<?php echo $toApplyIaccount?>">
<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('CP3 Withdrawal') ?></span></td>
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
            <form action="/member/cp3Withdrawal" id="withdrawForm" name="withdrawForm" method="post">
            <table cellspacing="0" cellpadding="0" class="tbl_form">
                <colgroup>
                    <col width="1%">
                    <col width="40%">
                    <col width="59%">
                    <col width="1%">
                </colgroup>
                <tbody>
                <tr>
                    <th class="tbl_header_left">
                        <div class="border_left_grey">&nbsp;</div>
                    </th>
                    <th colspan="2"><?php echo __('CP3 Withdrawal') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('Monthly Performance Return Amount'); ?></td>
                    <td>
                        <input name="monthlyPerformanceReturnAmountDisplay" id="monthlyPerformanceReturnAmountDisplay" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($monthlyPerformanceReturnAmount, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Balance'); ?></td>
                    <td>
                        <input name="ecashBalance" id="ecashBalance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($ledgerAccountBalance, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP3 Withdrawal Amount'); ?></td>
                    <td>
                        <?php if ($distributorDB->getCloseAccount() == "Y") { ?>
                        <input name="cp3Amount" id="cbo_cp3Amount" tabindex="2"/>
                        <?php } else { ?>
                        <select name="cp3Amount" id="cbo_cp3Amount" tabindex="2" style="text-align:right">
                            <?php
                                //if ($distributorDB->getMt4UserName() != null) {
                                for ($i = 100; $i <= 550; $i = $i + 10) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                for ($i = 600; $i <= 1000; $i = $i + 50) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                for ($i = 1100; $i <= 10000; $i = $i + 100) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                for ($i = 10500; $i <= 100000; $i = $i + 500) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                //}
                            ?>
                        </select>
                        <?php } ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('After handling fee'); ?>
                    </td>
                    <td>
                        <input name="ecashFinal" type="text" id="ecashFinal" readonly="readonly" tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Credit To'); ?>
                    </td>
                    <td>
                        <select name="bankInTo" id="bankInTo">
                            <?php
                            // TODO: Amend backend code as well for validation.
                            $disable = " disabled='disabled'";
                            $disableMoney = " disabled='disabled'";
                            $disableIAccount = "";

                            /*if ($distributorDB->getBankCountry() == "Malaysia") {
                                $disable = " disabled='disabled'";
                                $disableMoney = "";
                            }*/
                            if ($distributorDB->getBankCountry() == "China (PRC)" || $distributorDB->getBankCountry() == "Thailand") {
                                $disable = "";
                                $disableMoney = "";
                            }
                            if ($distributorDB->getBankCountry() == "Indonesia") {
                                $disableIAccount = " disabled='disabled'";
                                $disable = "";
                            }
                            if ($distributorDB->getBankCountry() == "Australia") {
                                $disable = "";
                            }
                            // bwhk (chales approved)
                            if ($distributorDB->getDistributorId() == 257749 || $distributorDB->getDistributorId() == 257792) {
                                $disable = "";
                                $disableMoney = "";
                            }
                            // special case (anna)
                            if ($distributorDB->getDistributorId() ==  168 || $distributorDB->getDistributorId() == 257219 || $distributorDB->getDistributorId() == 256078 || $distributorDB->getDistributorId() == 270107) {
                                $disable = "";
                            }

                            /*if ($distributorDB->getCloseAccount() == "Y" && $distributorDB->getIaccount() == "") {
                                $c = new Criteria();
                                $c = new Criteria();
                                $c->add(NotificationOfMaturityPeer::DIST_ID, $distributorDB->getDistributorId());
                                $c->add(NotificationOfMaturityPeer::STATUS_CODE, Globals::STATUS_MATURITY_WITHDRAW);
                                $c->addAscendingOrderByColumn(NotificationOfMaturityPeer::DIVIDEND_DATE);
                                $notificationOfMaturity = NotificationOfMaturityPeer::doSelectOne($c);

                                if ($notificationOfMaturity) {
                                    $exp_date = "2015-02-28 00:00:00";
                                    $todays_date = $notificationOfMaturity->getDividendDate();
                                    $today = strtotime($todays_date);
                                    $expiration_date = strtotime($exp_date);
                                    if ($expiration_date > $today) {
                                        $disable = "";
                                    }
                                }
                            }*/

                            if ($distributorDB->getIaccount() == "") {
                                $disable = "";
                            }
                            //if ($distributorDB->getIaccount() != "" && $disableIAccount == "") {
                            if ($disableIAccount == "") { ?>
                            <option value="<?php echo Globals::WITHDRAWAL_IACCOUNT; ?>"><?php echo __('i-Account'); ?></option>
                            <?php } ?>
                            <?php if ($distributorDB->getVisaDebitCard() != "") { ?>
<!--                            <option value="--><?php //echo Globals::WITHDRAWAL_VISA_DEBIT_CARD; ?><!--" disabled='disabled'>--><?php //echo __('Maxim Trader VISA Debit Card'); ?><!--</option>-->
                            <?php } ?>
                            <?php if (Globals::APPLY_EZYCASHCARD_ENABLE == true) { ?>
                            <!--<option value="<?php /*echo Globals::WITHDRAWAL_EZY_CASH_CARD; */?>">EzyAccount</option>-->
                            <?php } ?>
                            <?php if ($disable == "") { ?>
                            <option value="<?php echo Globals::WITHDRAWAL_LOCAL_BANK; ?>" <?php echo $disable;?>><?php echo __('Local Bank Transfer'); ?></option>
                            <?php } ?>
<!--                            <option value="--><?php //echo Globals::WITHDRAWAL_MONEYTRAC; ?><!--" --><?php //echo $disableMoney;?><!-->--><?php //echo __('Money Trac'); ?><!--</option>-->
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Security Password'); ?>
                    </td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td colspan="2" valign="top">
                         &nbsp;
                        <font color="#dc143c"> <?php echo __('NOTE :') ?></font>
                        <br>
                        <ol style="color: #dc143c; padding-left: 20px;">
                            <li><?php echo __('Minimum withdrawal amount is USD100') ?></li>
                            <li><?php echo __('Maximum withdrawal is limited to your monthly Performance Return amount') ?></li>
                            <li><?php echo __('Withdrawal request must be done during the first 7 days of each month') ?></li>
                            <li><?php echo __('Processing time will be at least 3 days') ?></li>
<!--                            <li>--><?php //echo __('Payout will be by the 15th of each month') ?><!--</li>-->
                            <li><?php echo __('Handling Fee is USD30') ?></li>
                            <li><?php echo __('All withdrawals shall be paid out based on current days\' prevailing exchange rate and subject to local bank charges') ?></li>
                            <!--<li><?php /*echo __('Payout time for monthly CP3 withdrawals to be credited to your account:') */?>
                                <ul>
                                    <li style="padding-left: 15px;"><?php /*echo __('Local bank accounts - by 25th') . " ".__('(Excluding non-working days)')  */?></li>
                                    <li style="padding-left: 15px;"><?php /*echo __('i-Account - by 11th') . " ".__('(Excluding non-working days)')  */?></li>
<!--                                    <li style="padding-left: 15px;">--><?php /*//echo __('Money Trac - by 20th') */?><!--</li>-->
<!--                                </ul>-->
<!--                            </li>-->
                        </ol>

                        <div class="ui-widget">
                            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                              class="ui-icon ui-icon-info"></span>
                                    <strong>Effective, 1st June 2015, CP3 withdrawals will be limited to the actual monthly Performance Return amount. Accumulation is therefore not allowed. This is done to avoid attracting unnecessary attention to IMs' withdrawal amounts by their respective banks. Please further note that for investment packages of USD1,000, the performance returns withdrawal amount shall be a minimum of USD100 and a maximum of USD540.</strong></p>
                            </div>
                        </div>
                        <!--<div class="ui-widget" style="display: none" id="moneyTracNote">
                            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                              class="ui-icon ui-icon-info"></span>
                                    <strong><?php /*echo __("For community transfers, kindly go to \"<strong>Add Community Member</strong>\" and fill in <br>
                                    <ol>
                                        <li>Customer Name: Maxim Capital Limited</li>
                                        <li>Customer Number: 000028911</li>
                                        <li>Customer Email Address: finance@maximtrader.com</li>
                                    </ol>
                                    Tick \"Receive Funds From this Customer\" and Send Connection Request"); */?></strong>
                                    <br>
                                    </p>
                            </div>
                        </div>-->

                        <div class="ui-widget" style="display: none" id="moneyTracNote2">
                            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                              class="ui-icon ui-icon-info"></span>

                                    <strong>Latest info regarding MoneyTrac:</strong>
                                    <br>
                                    <br>For time being, we withdrawals from MoneyTrac to local Malaysian accounts only available for (master/visa)
                                    <br>
                                    <br>1) MBB Debit Card
                                    <br>2) PBB Saving Acc Debit Card
                                    <br>3) HSBC Debit Card
                                    <br>
                                    <br>Not to
                                    <br>CIMB, Hong Leong Bank, RHB
                                    </p>
                            </div>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                //var_dump(preg_match('/[^\\p{Common}\\p{Latin}]/u', '你好吗'));
                //var_dump(preg_match('/[^\\p{Common}\\p{Latin}]/u', 'sadasdasdasdaas'));
                //exit();
                if (!$validatorLib->isBankAccountDetailsUpdated2($distributorDB, $errorMsg)) {
                ?>
                    <tr class="tbl_form_row_odd">
                        <td colspan="3">
                            <div class="ui-widget">
                                <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                     class="ui-state-error ui-corner-all">
                                    <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                                  class="ui-icon ui-icon-alert"></span>
                                        <strong><?php echo __('You are not allowed to submit withdrawal, due to') ?> : <br><br><?php echo __($errorMsg) ?>. <a href="<?php echo url_for("/member/viewProfile")?>" style="color: #0080c8;"><?php echo __('Update Here') ?></a></strong></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                //} else if ($distributorDB->getVisaDebitCard() != "" && strlen($distributorDB->getVisaDebitCard()) != 16) {
                ?>
                <!--<tr class="tbl_form_row_odd">
                    <td colspan="3">
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong><?php /*echo __('You are not allowed to submit withdrawal, due to') */?> : <br><br><?php /*echo __('Maxim Trader VISA Debit Card must be 16 characters') */?>. <a href="<?php /*echo url_for("/member/viewProfile")*/?>" style="color: #0080c8;"><?php /*echo __('Update Here') */?></a></strong></p>
                        </div>
                    </div>
                    </td>
                </tr>-->
                <?php
                } else {
                    if ($sf_user->getAttribute(Globals::SESSION_LEADER_ID) == 255709
                        || $sf_user->getAttribute(Globals::SESSION_LEADER_ID) == 255607
                        || $sf_user->getAttribute(Globals::SESSION_LEADER_ID) == 264845
                        || $sf_user->getAttribute(Globals::SESSION_LEADER_ID) == 273056
                        || $sf_user->getAttribute(Globals::SESSION_LEADER_ID) == 255882) {
                ?>
                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td></td>
                    <td align="right">
                        <button id="btnTransfer"><?php echo __('Submit') ?></button>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>

            </form>

            <div class="info_bottom_bg"></div>
            <div class="clear"></div>
            <br>

            <script type="text/javascript" language="javascript">
            var datagrid = null;
            $(function() {
                datagrid = $("#datagrid").r9jasonDataTable({
                    // online1DataTable extra params
                    "idTr" : true, // assign <tr id='xxx'> from 1st columns array(aoColumns);
                    "extraParam" : function(aoData) { // pass extra params to server
                    },
                    "reassignEvent" : function() { // extra function for reassignEvent when JSON is back from server
                        reassignDatagridEventAttr();
                    },

                    // datatables params
                    "bLengthChange": true,
                    "bFilter": false,
                    "bProcessing": true,
                    "bServerSide": true,
                    "bAutoWidth": false,
                    "sAjaxSource": "/finance/cp3WithdrawalList",
                    "sPaginationType": "full_numbers",
                    "aaSorting": [
                        [6,'desc']
                    ],
                    "aoColumns": [
                        { "sName" : "dist_id", "bVisible" : false,  "bSortable": true},
                        { "sName" : "deduct",  "bSortable": true},
                        { "sName" : "amount",  "bSortable": true},
                        { "sName" : "bank_in_to",  "bSortable": true},
                        { "sName" : "status_code",  "bSortable": true},
                        { "sName" : "remarks",  "bSortable": true},
                        { "sName" : "created_on",  "bSortable": true}
                    ]
                });
            }); // end function

            function reassignDatagridEventAttr() {
            }
        </script>

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
                <th><?php echo __('CP3 Withdrawal Status') ?></th>
                <th class="tbl_content_right"></th>
                <th class="tbl_header_right">
                    <div class="border_right_grey">&nbsp;</div>
                </th>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="display" id="datagrid" border="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th><?php echo __('Withdrawal') ?></th>
                <th><?php echo __('Amount') ?></th>
                <th><?php echo __('Credit To') ?></th>
                <th><?php echo __('Status') ?></th>
                <th><?php echo __('Remarks') ?></th>
                <th><?php echo __('Date') ?></th>
            </tr>
            </thead>
        </table>
        </td>
    </tr>
    </tbody>
</table>