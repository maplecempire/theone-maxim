<?php include('scripts.php'); ?>

<script type="text/javascript" language="javascript">
    var moneytracUsername = "<?php echo $distributorDB->getMoneytracUsername()?>";
    var moneytracCustomerId = "<?php echo $distributorDB->getMoneytracCustomerId()?>";
    $(function() {
        $("#cbo_ecashAmount").change(function(){
            var ecashFinal = $("#cbo_ecashAmount").val() - 60;
            var handlingCharge = $("#cbo_ecashAmount").val() * 0.95;

            if (parseFloat(handlingCharge) < ecashFinal)
                ecashFinal = handlingCharge;
//            var ecashFinal = $("#cbo_ecashAmount").val();

            $("#ecashFinal").autoNumericSet(ecashFinal);
        }).change();

        $("#withdrawForm").validate({
            messages : {
                transactionPassword: {
                    remote: "<?php echo __("Security Password is not valid")?>"
                }
            },
            rules : {
                "transactionPassword" : {
                    required : true
                    , remote: "/member/verifyTransactionPassword"
                }
            },
            submitHandler: function(form) {
                waiting();
                var ecashBalance = $('#ecashBalance').autoNumericGet();
                var withdrawAmount = parseFloat($("#cbo_ecashAmount").val());

                if (withdrawAmount > parseFloat(ecashBalance)) {
                    error("In-sufficient CP2");
                    return false;
                }
                if ($("#bankInTo").val() == "<?php echo Globals::WITHDRAWAL_MONEYTRAC?>" && moneytracCustomerId == "") {
                    error("Please update Money Trac Information in User Profile.");
                    return false;
                }
                form.submit();
            }
        });

        $("#bankInTo").change(function(){
            if ($("#bankInTo").val() == "<?php echo Globals::WITHDRAWAL_MONEYTRAC?>") {
                $("#moneyTracNote").show(500);
                $("#moneyTracNote2").show(500);
            } else {
                $("#moneyTracNote").hide(500);
                $("#moneyTracNote2").hide(500);
            }
        }).trigger("change");
    });
</script>

<div class="ewallet_li">
	<a target="_self" class="navcontainer" href="/member/mt4Withdrawal" style="color: rgb(0, 93, 154);">
        <?php echo __('MT4 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/ecashWithdrawal");?>" style="color: rgb(134, 197, 51);">
        <?php echo __('CP2 Withdrawal'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="<?php echo url_for("/member/cp3Withdrawal");?>" style="color: rgb(0, 93, 154);">
        <?php echo __('CP3 Withdrawal'); ?>
    </a>
</div>

<table cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="tbl_sprt_bottom"><span class="txt_title"><?php echo __('CP2 Withdrawal') ?></span></td>
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
            <form action="/member/ecashWithdrawal" id="withdrawForm" name="withdrawForm" method="post">
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
                    <th colspan="2"><?php echo __('CP2 Withdrawal') ?></th>
<!--                    <th class="tbl_content_right"></th>-->
                    <th class="tbl_header_right">
                        <div class="border_right_grey">&nbsp;</div>
                    </th>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP2 Balance'); ?></td>
                    <td>
                        <input name="ecashBalance" id="ecashBalance" tabindex="1" disabled="disabled"
                                           value="<?php echo number_format($ledgerAccountBalance, 2); ?>"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td><?php echo __('CP2 Withdrawal Amount'); ?></td>
                    <td>
                        <select name="ecashAmount" id="cbo_ecashAmount" tabindex="2" style="text-align:right">
                            <?php
                                //if ($distributorDB->getMt4UserName() != null) {
                                for ($i = 100; $i <= 10000; $i = $i + 100) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                for ($i = 10500; $i <= 100000; $i = $i + 500) {
                                    echo "<option value='".$i."'>".number_format($i, 0)."</option>";
                                }
                                //}
                            ?>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('After handling fee'); ?>
                    </td>
                    <td>
                        <input name="ecashFinal" type="text" id="ecashFinal" readonly="readonly" tabindex="3"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Credit To'); ?>
                    </td>
                    <td>
                        <select name="bankInTo" id="bankInTo">
                            <?php
                            $disable = "";
                            $disableMoney = " disabled='disabled'";

                            if ($distributorDB->getCountry() == "Malaysia") {
                                $disable = " disabled='disabled'";
                                $disableMoney = "";
                            } else if ($distributorDB->getCountry() == "Hong Kong") {
                                $disable = "";
                                $disableMoney = "";
                            }
                            // bwhk (chales approved)
                            if ($distributorDB->getDistributorId() == 257749) {
                                $disable = "";
                                $disableMoney = "";
                            }
                            if ($distributorDB->getVisaDebitCard() != "") { ?>
                            <option value="<?php echo Globals::WITHDRAWAL_VISA_DEBIT_CARD; ?>"><?php echo __('Maxim Trader VISA Debit Card'); ?></option>
                            <?php } ?>
                            <?php if (Globals::APPLY_EZYCASHCARD_ENABLE == true) { ?>
                            <option value="<?php echo Globals::WITHDRAWAL_EZY_CASH_CARD; ?>">EzyAccount</option>
                            <?php } ?>
                            <option value="<?php echo Globals::WITHDRAWAL_LOCAL_BANK; ?>" <?php echo $disable;?>><?php echo __('Local Bank Transfer'); ?></option>
                            <option value="<?php echo Globals::WITHDRAWAL_MONEYTRAC; ?>" <?php echo $disableMoney;?>><?php echo __('Money Trac'); ?></option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_odd">
                    <td>&nbsp;</td>
                    <td>
                        <?php echo __('Security Password'); ?>
                    </td>
                    <td>
                        <input name="transactionPassword" type="password" id="transactionPassword"/>
                    </td>
                    <td>&nbsp;</td>
                </tr>

                <tr class="tbl_form_row_even">
                    <td>&nbsp;</td>
                    <td colspan="2" valign="top">
                         &nbsp;
                        <font color="#dc143c"> <?php echo __('NOTE :') ?></font>
                        <br>
                        <ol style="color: #dc143c; padding-left: 20px;">
                            <li><?php echo __('Minimum withdrawal amount is USD100') ?></li>
                            <li><?php echo __('Withdrawal request must be done during the first 7 days of each month') ?></li>
                            <li><?php echo __('Processing time will be at least 3 days') ?></li>
                            <li><?php echo __('Payout will be by the 15th of each month') ?></li>
                            <li><?php echo __('Handling Fee USD60 or 5% whichever is higher') ?></li>
                            <li><?php echo __('All withdrawals shall be paid out based on current days\' prevailing exchange rate and subject to local bank charges') ?></li>
                        </ol>
                        <div class="ui-widget" style="display: none" id="moneyTracNote">
                            <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                 class="ui-state-highlight ui-corner-all">
                                <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                              class="ui-icon ui-icon-info"></span>
                                    <strong><?php echo __("For community transfers, kindly go to \"<strong>Add Community Member</strong>\" and fill in <br>
                                    <ol>
                                        <li>Customer Name: Maxim Capital Limited</li>
                                        <li>Customer Number: 000028911</li>
                                        <li>Customer Email Address: finance@maximtrader.com</li>
                                    </ol>
                                    Tick \"Receive Funds From this Customer\" and Send Connection Request"); ?></strong>
                                    <br>
                                    </p>
                            </div>
                        </div>

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
                                    <br>CIMB, Hong Leong Blank, RHB
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
                if ($distributorDB->getBankAccNo() == "" || $distributorDB->getBankAccNo() == null
                    || $distributorDB->getBankName() == "" || $distributorDB->getBankName() == null
                    || $distributorDB->getBankBranchName() == "" || $distributorDB->getBankBranchName() == null
                    || $distributorDB->getBankAddress() == "" || $distributorDB->getBankAddress() == null
                    || $distributorDB->getBankHolderName() == "" || $distributorDB->getBankHolderName() == null
                    || $distributorDB->getFileBankPassBook() == "" || $distributorDB->getFileBankPassBook() == null
                    || $distributorDB->getFileNric() == "" || $distributorDB->getFileNric() == null) {
                ?>
                <tr class="tbl_form_row_odd">
                    <td colspan="3">
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong><?php echo __('You are not allowed to submit withdrawal, due to') ?> : <br><br><?php echo __('You need to update all your Bank Account Details and upload Bank Account Proof, Proof of Residence and Passport/Photo ID') ?>. <a href="<?php echo url_for("/member/viewProfile")?>" style="color: #0080c8;"><?php echo __('Update Here') ?></a></strong></p>
                        </div>
                    </div>
                    </td>
                </tr>
                <?php
                } else if ($distributorDB->getCountry() == "Taiwan"
                           &&
                           (preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankName()) == 1
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankBranchName()) == 1
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankAddress()) == 1
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankHolderName()) == 1)) {
                ?>
                <tr class="tbl_form_row_odd">
                    <td colspan="3">
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong><?php echo __('You are not allowed to submit withdrawal, due to') ?> : <br><br><?php echo __('You need to update all your Bank Account Details must be latin word') ?>. <a href="<?php echo url_for("/member/viewProfile")?>" style="color: #0080c8;"><?php echo __('Update Here') ?></a></strong></p>
                        </div>
                    </div>
                    </td>
                </tr>
                <?php
                } else if (($distributorDB->getCountry() == "Korea North" || $distributorDB->getCountry() == "Korea South")
                        &&
                           (preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankName()) == 1
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankBranchName()) == 1
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankAddress()) == 1
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankHolderName()) == 1)) {
                ?>
                <tr class="tbl_form_row_odd">
                    <td colspan="3">
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong><?php echo __('You are not allowed to submit withdrawal, due to') ?> : <br><br><?php echo __('Please ensure all your Bank Account Details is latin word') ?>. <a href="<?php echo url_for("/member/viewProfile")?>" style="color: #0080c8;"><?php echo __('Update Here') ?></a></strong></p>
                        </div>
                    </div>
                    </td>
                </tr>
                <?php
                } else if ($distributorDB->getCountry() == "China (PRC)"
                           &&
                           (preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankName()) == 0
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankBranchName()) == 0
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankAddress()) == 0
                           || preg_match('/[^\\p{Common}\\p{Latin}]/u', $distributorDB->getBankHolderName()) == 0)) {
                ?>
                <tr class="tbl_form_row_odd">
                    <td colspan="3">
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong><?php echo __('You are not allowed to submit withdrawal, due to') ?> : <br><br><?php echo __('Please ensure all your Bank Account Details is chinese word') ?>. <a href="<?php echo url_for("/member/viewProfile")?>" style="color: #0080c8;"><?php echo __('Update Here') ?></a></strong></p>
                        </div>
                    </div>
                    </td>
                </tr>
                <?php
                } else if ($distributorDB->getVisaDebitCard() != "" && strlen($distributorDB->getVisaDebitCard()) != 16) {
                ?>
                <tr class="tbl_form_row_odd">
                    <td colspan="3">
                    <div class="ui-widget">
                        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                             class="ui-state-error ui-corner-all">
                            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                          class="ui-icon ui-icon-alert"></span>
                                <strong><?php echo __('You are not allowed to submit withdrawal, due to') ?> : <br><br><?php echo __('Maxim Trader VISA Debit Card must be 16 characters') ?>. <a href="<?php echo url_for("/member/viewProfile")?>" style="color: #0080c8;"><?php echo __('Update Here') ?></a></strong></p>
                        </div>
                    </div>
                    </td>
                </tr>
                <?php
                } else {
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
                    "sAjaxSource": "/finance/ecashWithdrawalList",
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
                <th><?php echo __('CP2 Withdrawal Status') ?></th>
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